<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Str;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'          => 'Gratuito',
                'slug'          => 'gratuito',
                'description'   => 'Ideal para começar. Publique até 3 concursos por mês.',
                'price'         => 0.00,
                'billing_cycle' => 'monthly',
                'max_contests'  => 3,
                'features'      => [
                    'Até 3 concursos ativos',
                    'Gestão de interessados',
                    'Perfil de empresa',
                ],
                'is_active'     => true,
                'is_featured'   => false,
            ],
            [
                'name'          => 'Pro',
                'slug'          => 'pro',
                'description'   => 'Para empresas em crescimento com mais necessidades.',
                'price'         => 29.99,
                'billing_cycle' => 'monthly',
                'max_contests'  => 20,
                'features'      => [
                    'Até 20 concursos ativos',
                    'Gestão de candidaturas',
                    'Estatísticas básicas',
                    'Destaque nos resultados',
                    'Suporte prioritário',
                ],
                'is_active'     => true,
                'is_featured'   => true,
            ],
            [
                'name'          => 'Premium',
                'slug'          => 'premium',
                'description'   => 'Poder total para grandes organizações e instituições.',
                'price'         => 79.99,
                'billing_cycle' => 'monthly',
                'max_contests'  => null,
                'features'      => [
                    'Concursos ilimitados',
                    'Gestão completa de candidaturas',
                    'Estatísticas avançadas',
                    'Destaque premium na homepage',
                    'Anúncios patrocinados',
                    'Suporte dedicado',
                    'API de integração',
                ],
                'is_active'     => true,
                'is_featured'   => false,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
