<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\Company;
use App\Models\ContestCategory;
use Illuminate\Support\Str;

class ContestSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();
        if (!$company) return;

        $categories = ContestCategory::pluck('id', 'slug');

        $contests = [
            [
                'title'              => 'Fornecimento de Computadores e Equipamento Informático',
                'contest_type'       => 'tender',
                'participation_type' => 'full_application',
                'category_slug'      => 'tecnologia-ti',
                'description'        => 'O Banco Nacional de Angola solicita propostas para o fornecimento de 200 computadores portáteis, 50 impressoras multifunção e equipamento de rede para as suas delegações provinciais.',
                'requirements'       => "- Fornecedor registado e com NIF activo\n- Certificado de qualidade ISO ou equivalente\n- Capacidade de entrega em 30 dias\n- Garantia mínima de 2 anos\n- Suporte técnico pós-venda incluído",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Tecnologia & TI',
                'budget_min'         => 50000000,
                'budget_max'         => 80000000,
                'budget_currency'    => 'AOA',
                'deadline'           => now()->addDays(30),
                'is_featured'        => true,
            ],
            [
                'title'              => 'Serviços de Segurança e Vigilância – Edifícios Corporativos',
                'contest_type'       => 'tender',
                'participation_type' => 'full_application',
                'category_slug'      => 'seguranca-vigilancia',
                'description'        => 'A Sonangol EP abre concurso para contratação de empresa especializada em segurança privada para vigilância das suas instalações em Luanda. Contrato de 24 meses, renovável.',
                'requirements'       => "- Empresa licenciada pelo Ministério do Interior\n- Mínimo de 5 anos no sector\n- Equipa mínima de 50 agentes certificados\n- Sistemas de comunicação e monitorização 24/7\n- Seguro de responsabilidade civil",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Segurança & Vigilância',
                'budget_min'         => 120000000,
                'budget_max'         => 200000000,
                'budget_currency'    => 'AOA',
                'deadline'           => now()->addDays(20),
                'is_featured'        => true,
            ],
            [
                'title'              => 'Construção de Centro de Saúde – Bairro Palanca',
                'contest_type'       => 'public_contest',
                'participation_type' => 'full_application',
                'category_slug'      => 'construcao-obras',
                'description'        => 'A Administração Municipal de Luanda lança concurso público para a construção de um centro de saúde com capacidade para 200 consultas diárias, incluindo bloco materno-infantil.',
                'requirements'       => "- Empresa com alvará de construção classe 4 ou superior\n- Experiência comprovada em obras de saúde\n- Caução de participação: 2% do valor proposto\n- Projecto executivo aprovado\n- Prazo de execução: 18 meses",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Construção Civil',
                'budget_min'         => 500000000,
                'budget_max'         => 800000000,
                'budget_currency'    => 'AOA',
                'deadline'           => now()->addDays(45),
                'is_featured'        => false,
            ],
            [
                'title'              => 'Consultoria em Transformação Digital e ERP',
                'contest_type'       => 'consulting',
                'participation_type' => 'full_application',
                'category_slug'      => 'consultoria-assessoria',
                'description'        => 'A Unitel solicita proposta para implementação de sistema ERP integrado (finanças, RH, logística e procurement). O projecto inclui análise de processos, configuração, migração de dados e formação.',
                'requirements'       => "- Empresa certificada em SAP, Oracle ou Microsoft Dynamics\n- Equipa com mínimo 5 consultores seniores\n- Casos de sucesso documentados em empresas de telecomunicações\n- Metodologia de gestão de projecto certificada (PMP/PRINCE2)",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Consultoria & TI',
                'budget_min'         => 300000,
                'budget_max'         => 600000,
                'budget_currency'    => 'USD',
                'deadline'           => now()->addDays(35),
                'is_featured'        => true,
            ],
            [
                'title'              => 'Fornecimento de Refeições – Cantina Corporativa',
                'contest_type'       => 'tender',
                'participation_type' => 'interest_submission',
                'category_slug'      => 'alimentacao-catering',
                'description'        => 'O Hospital Josina Machel abre concurso para fornecimento de refeições para utentes e colaboradores. Estimativa de 500 refeições diárias, com menu diversificado e dietas especiais.',
                'requirements'       => "- Empresa de catering licenciada\n- Certificado de boas práticas de higiene e segurança alimentar\n- Capacidade de preparação mínima de 600 refeições/dia\n- Veículo de transporte refrigerado",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Alimentação & Catering',
                'deadline'           => now()->addDays(15),
                'is_featured'        => false,
            ],
            [
                'title'              => 'Serviços de Manutenção de Instalações Eléctricas',
                'contest_type'       => 'tender',
                'participation_type' => 'full_application',
                'category_slug'      => 'manutencao-reparacao',
                'description'        => 'A Universidade Agostinho Neto abre concurso para contratação de empresa especializada em manutenção preventiva e correctiva das instalações eléctricas do Campus de Luanda.',
                'requirements'       => "- Empresa licenciada para trabalhos eléctricos\n- Equipa mínima de 10 técnicos certificados\n- Disponibilidade de atendimento de emergência 24/7\n- Plano de manutenção preventiva semestral",
                'benefits'           => null,
                'country'            => 'Angola',
                'city'               => 'Luanda',
                'professional_area'  => 'Manutenção Eléctrica',
                'budget_min'         => 15000000,
                'budget_max'         => 30000000,
                'budget_currency'    => 'AOA',
                'deadline'           => now()->addDays(25),
                'is_featured'        => false,
            ],
        ];

        foreach ($contests as $data) {
            $categorySlug = $data['category_slug'];
            $categoryId   = $categories[$categorySlug] ?? null;
            unset($data['category_slug']);

            $slug = Str::slug($data['title']);
            Contest::updateOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'company_id'    => $company->id,
                    'category_id'   => $categoryId,
                    'slug'          => $slug,
                    'status'        => 'active',
                    'location_type' => 'local',
                    'views_count'   => rand(10, 500),
                ])
            );
        }
    }
}
