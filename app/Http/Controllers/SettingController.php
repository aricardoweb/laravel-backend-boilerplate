<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Setting;
use App\Helpers\SettingHelper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings configuration page.
     */
    public function index()
    {
        // Pega todas as imagens da galeria para exibição nos modais/selects
        $images = Image::latest()->get();
        
        // Pega todas as configurações do cache/database
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('pages.settings.index', compact('images', 'settings'));
    }

    /**
     * Update the application settings.
     */
    public function update(Request $request)
    {
        // Espera-se que o array settings venha no formato:
        // settings[app_name] = 'MedCare'
        // settings[app_logo] = 'URL da imagem' (selecionada da galeria)
        // ...
        
        $request->validate([
            'settings' => 'required|array',
            'settings.app_name' => 'nullable|string|max:255',
            'settings.app_logo' => 'nullable|string',
            'settings.app_favicon' => 'nullable|string',
            'settings.auth_banner' => 'nullable|string',
        ]);

        $settings = $request->input('settings', []);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Limpa o cache após a atualização
        SettingHelper::clearCache();

        return redirect()->route('settings.index')->with('success', 'Configurações atualizadas com sucesso.');
    }
}
