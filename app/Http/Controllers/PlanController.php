<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::latest()->paginate(10);
        return view('pages.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('pages.plans.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'credit_validity' => 'required|string|max:255',
            'credit_validity_months' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'recommended' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Generate unique slug
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $count = 1;
        while (Plan::where('slug_id', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug_id'] = $slug;

        $data['features'] = array_filter($data['features'] ?? [], fn($value) => !is_null($value) && $value !== '');
        $data['recommended'] = $request->has('recommended');
        $data['is_active'] = $request->has('is_active');
        
        // Convert BRL format to float before saving
        $data['price'] = $this->parseBrlToFloat($data['price']);

        Plan::create($data);

        return redirect()->route('plans.index')->with('success', 'Plano criado com sucesso.');
    }

    public function edit(Plan $plan)
    {
        return view('pages.plans.form', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'credit_validity' => 'required|string|max:255',
            'credit_validity_months' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'recommended' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data['features'] = array_filter($data['features'] ?? [], fn($value) => !is_null($value) && $value !== '');
        $data['recommended'] = $request->has('recommended');
        $data['is_active'] = $request->has('is_active');
        
        // Convert BRL format to float before saving
        $data['price'] = $this->parseBrlToFloat($data['price']);

        $plan->update($data);

        return redirect()->route('plans.index')->with('success', 'Plano atualizado com sucesso.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plano excluído com sucesso.');
    }

    private function parseBrlToFloat($value)
    {
        // Remove tudo que não for dígito, vírgula ou ponto
        $value = preg_replace('/[^\d\,\.]/', '', $value);
        // Substitui ponto por nada (separador de milhar)
        $value = str_replace('.', '', $value);
        // Substitui a vírgula por ponto (separador decimal)
        $value = str_replace(',', '.', $value);
        
        return (float) $value;
    }
}
