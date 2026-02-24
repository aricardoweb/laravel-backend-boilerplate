<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'slug_id' => 'basic',
                'name' => 'Básico',
                'price' => 89.90,
                'credit_validity' => '6 meses',
                'credit_validity_months' => 6,
                'features' => [
                    "Mensalidade de R$ 89,90 vira crédito todo mês",
                    "Créditos acumulam por até 6 meses",
                    "Descontos de até 70% em consultas e exames",
                    "Acesso à rede credenciada completa",
                    "Carteirinha digital com QR Code",
                    "Atendimento via WhatsApp"
                ],
                'recommended' => false,
                'is_active' => true,
            ],
            [
                'slug_id' => 'premium',
                'name' => 'Premium',
                'price' => 149.90,
                'credit_validity' => '2 anos',
                'credit_validity_months' => 24,
                'features' => [
                    "Mensalidade de R$ 149,90 vira crédito todo mês",
                    "Créditos acumulam por até 2 anos (enquanto adimplente)",
                    "Maiores descontos em consultas e exames",
                    "Acesso à rede credenciada completa",
                    "Carteirinha digital com QR Code",
                    "Atendimento prioritário 24h",
                    "Telemedicina inclusa (consultas online)",
                    "Desconto em farmácias parceiras",
                    "Ambulância (até 2 acionamentos/ano)"
                ],
                'recommended' => true,
                'is_active' => true,
            ]
        ];

        foreach ($plans as $planData) {
            Plan::updateOrCreate(
                ['slug_id' => $planData['slug_id']],
                $planData
            );
        }
    }
}
