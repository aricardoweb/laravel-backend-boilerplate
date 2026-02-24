<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Retorna a lista de planos ativos formatada exatamente como solicitado.
     */
    public function index()
    {
        $plans = Plan::where('is_active', true)->get();

        // Mapeia para corresponder exatamente à estrutura solicitada
        // Substituindo o "slug_id" banco para a chave "id" do JSON
        $results = $plans->map(function ($plan) {
            return [
                'id' => $plan->slug_id,
                'name' => $plan->name,
                'price' => $plan->price,
                'creditValidity' => $plan->credit_validity,
                'creditValidityMonths' => $plan->credit_validity_months,
                'features' => $plan->features,
                'recommended' => $plan->recommended ? true : null // Apenas manda true se for, baseando-se no request do user
            ];
        })->map(function ($item) {
            // Remove propríedades null (como recommended do plano basico) para bater exatamente com a struct
            return array_filter($item, function ($value) {
                return $value !== null;
            });
        });

        return response()->json([
            'error' => false,
            'message' => ['sucesso'],
            'results' => $results
        ]);
    }
}
