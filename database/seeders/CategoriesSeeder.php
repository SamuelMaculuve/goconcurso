<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContestCategory;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tecnologia & TI',           'slug' => 'tecnologia-ti',           'icon' => '💻', 'color' => '#2D6A4F', 'description' => 'Fornecimento de hardware, software, serviços de TI e desenvolvimento de sistemas'],
            ['name' => 'Construção & Obras',        'slug' => 'construcao-obras',         'icon' => '🏗️', 'color' => '#6B4226', 'description' => 'Obras de construção civil, reabilitação de edifícios e infraestruturas'],
            ['name' => 'Consultoria & Assessoria',  'slug' => 'consultoria-assessoria',   'icon' => '🤝', 'color' => '#D4A017', 'description' => 'Serviços de consultoria técnica, jurídica, financeira e de gestão'],
            ['name' => 'Manutenção & Reparação',    'slug' => 'manutencao-reparacao',     'icon' => '🔧', 'color' => '#C0602A', 'description' => 'Serviços de manutenção preventiva e correctiva de equipamentos e instalações'],
            ['name' => 'Fornecimento de Materiais', 'slug' => 'fornecimento-materiais',   'icon' => '📦', 'color' => '#1B4332', 'description' => 'Fornecimento de materiais de escritório, industriais e de consumo'],
            ['name' => 'Saúde & Equipamento Médico','slug' => 'saude-equipamento-medico', 'icon' => '🏥', 'color' => '#27AE60', 'description' => 'Fornecimento de medicamentos, equipamentos médicos e serviços de saúde'],
            ['name' => 'Segurança & Vigilância',    'slug' => 'seguranca-vigilancia',     'icon' => '🛡️', 'color' => '#2C3E50', 'description' => 'Serviços de segurança privada, vigilância e controlo de acessos'],
            ['name' => 'Logística & Transporte',    'slug' => 'logistica-transporte',     'icon' => '🚚', 'color' => '#E67E22', 'description' => 'Serviços de transporte de mercadorias, logística e distribuição'],
            ['name' => 'Limpeza & Saneamento',      'slug' => 'limpeza-saneamento',       'icon' => '🧹', 'color' => '#8E44AD', 'description' => 'Serviços de limpeza, higienização e gestão de resíduos'],
            ['name' => 'Alimentação & Catering',    'slug' => 'alimentacao-catering',     'icon' => '🍽️', 'color' => '#E74C3C', 'description' => 'Fornecimento de refeições, catering para eventos e cantinas'],
            ['name' => 'Energia & Utilities',       'slug' => 'energia-utilities',        'icon' => '⚡', 'color' => '#1A8A4A', 'description' => 'Fornecimento de energia, combustíveis e serviços de utilities'],
            ['name' => 'Telecomunicações',           'slug' => 'telecomunicacoes',         'icon' => '📡', 'color' => '#2980B9', 'description' => 'Serviços de telecomunicações, internet e comunicações corporativas'],
            ['name' => 'Formação & Educação',       'slug' => 'formacao-educacao',        'icon' => '📚', 'color' => '#D4A017', 'description' => 'Serviços de formação profissional, e-learning e capacitação empresarial'],
            ['name' => 'Serviços Jurídicos',        'slug' => 'servicos-juridicos',       'icon' => '⚖️', 'color' => '#7F8C8D', 'description' => 'Serviços legais, notariado, auditorias e conformidade regulatória'],
        ];

        foreach ($categories as $category) {
            ContestCategory::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
