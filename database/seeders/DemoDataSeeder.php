<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Contest;
use App\Models\ContestApplication;
use App\Models\ContestInterest;
use App\Models\ContestView;
use App\Models\SavedContest;
use App\Models\Advertisement;
use App\Models\Plan;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $freePlan = Plan::where('slug', 'gratuito')->first();
        $proPlan  = Plan::where('slug', 'profissional')->first() ?? $freePlan;

        /*
        |----------------------------------------------------------------------
        | Extra Candidate Users
        |----------------------------------------------------------------------
        */
        $candidateData = [
            ['name' => 'Ana Fernandes',    'email' => 'ana.fernandes@demo.ao',    'city' => 'Luanda',   'area' => 'Direito & Jurídico'],
            ['name' => 'Carlos Mbemba',    'email' => 'carlos.mbemba@demo.ao',    'city' => 'Luanda',   'area' => 'Tecnologia & TI'],
            ['name' => 'Filomena Santos',  'email' => 'filomena.santos@demo.ao',  'city' => 'Huambo',   'area' => 'Saúde & Medicina'],
            ['name' => 'David Neto',       'email' => 'david.neto@demo.ao',       'city' => 'Benguela', 'area' => 'Engenharia Civil'],
            ['name' => 'Luciana Teixeira', 'email' => 'luciana.teixeira@demo.ao', 'city' => 'Luanda',   'area' => 'Finanças & Contabilidade'],
            ['name' => 'Manuel Kiala',     'email' => 'manuel.kiala@demo.ao',     'city' => 'Malanje',  'area' => 'Educação & Formação'],
            ['name' => 'Rosa Domingos',    'email' => 'rosa.domingos@demo.ao',    'city' => 'Luanda',   'area' => 'Marketing & Comunicação'],
            ['name' => 'Pedro Lopes',      'email' => 'pedro.lopes@demo.ao',      'city' => 'Cabinda',  'area' => 'Petróleo & Energia'],
        ];

        $candidates = [];
        foreach ($candidateData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'              => $data['name'],
                    'password'          => Hash::make('password'),
                    'role_type'         => 'candidate',
                    'country'           => 'Angola',
                    'city'              => $data['city'],
                    'professional_area' => $data['area'],
                    'is_active'         => true,
                ]
            );
            if (!$user->hasRole('candidate')) {
                $user->assignRole('candidate');
            }
            $candidates[] = $user;
        }

        /*
        |----------------------------------------------------------------------
        | Extra Companies
        |----------------------------------------------------------------------
        */
        $companyData = [
            [
                'name'         => 'Sonangol EP',
                'slug'         => 'sonangol-ep',
                'email'        => 'rh@sonangol.ao',
                'sector'       => 'Petróleo & Energia',
                'company_type' => 'public',
                'city'         => 'Luanda',
                'description'  => 'Empresa Nacional de Petróleo de Angola, líder no sector energético.',
                'is_verified'  => true,
                'plan_id'      => $proPlan?->id,
                'plan_expires_at' => now()->addYear(),
            ],
            [
                'name'         => 'BAI – Banco Angolano de Investimento',
                'slug'         => 'bai-banco-angolano',
                'email'        => 'rh@bancobai.ao',
                'sector'       => 'Banca & Finanças',
                'company_type' => 'private',
                'city'         => 'Luanda',
                'description'  => 'Principal banco privado de Angola com presença em todo o país.',
                'is_verified'  => true,
                'plan_id'      => $proPlan?->id,
                'plan_expires_at' => now()->addYear(),
            ],
            [
                'name'         => 'Universidade Agostinho Neto',
                'slug'         => 'universidade-agostinho-neto',
                'email'        => 'rh@uan.ao',
                'sector'       => 'Educação & Ensino Superior',
                'company_type' => 'public',
                'city'         => 'Luanda',
                'description'  => 'Maior universidade pública de Angola.',
                'is_verified'  => true,
                'plan_id'      => $freePlan?->id,
                'plan_expires_at' => null,
            ],
            [
                'name'         => 'Ango Construção Lda',
                'slug'         => 'ango-construcao-lda',
                'email'        => 'rh@angoconstrucao.ao',
                'sector'       => 'Construção Civil',
                'company_type' => 'private',
                'city'         => 'Luanda',
                'description'  => 'Empresa especializada em construção de infraestruturas e edifícios residenciais.',
                'is_verified'  => false,
                'plan_id'      => $freePlan?->id,
                'plan_expires_at' => null,
            ],
            [
                'name'         => 'Médicos Sem Fronteiras Angola',
                'slug'         => 'msf-angola',
                'email'        => 'rh@msf.ao',
                'sector'       => 'Saúde & ONGs',
                'company_type' => 'ngo',
                'city'         => 'Luanda',
                'description'  => 'Organização humanitária de saúde presente em Angola.',
                'is_verified'  => true,
                'plan_id'      => $proPlan?->id,
                'plan_expires_at' => now()->addMonths(6),
            ],
        ];

        $extraCompanies = [];
        foreach ($companyData as $index => $data) {
            // Create a company user for each
            $companyUser = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'      => $data['name'],
                    'password'  => Hash::make('password'),
                    'role_type' => 'company',
                    'country'   => 'Angola',
                    'city'      => $data['city'],
                    'is_active' => true,
                ]
            );
            if (!$companyUser->hasRole('company')) {
                $companyUser->assignRole('company');
            }

            $company = Company::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id'   => $companyUser->id,
                    'country'   => 'Angola',
                    'is_active' => true,
                ])
            );
            $extraCompanies[] = $company;
        }

        /*
        |----------------------------------------------------------------------
        | ContestApplications & ContestInterests
        |----------------------------------------------------------------------
        */
        $fullAppContests = Contest::where('participation_type', 'full_application')
            ->where('status', 'active')
            ->get();

        $interestContests = Contest::where('participation_type', 'interest_submission')
            ->where('status', 'active')
            ->get();

        $coverLetters = [
            'A nossa empresa possui vasta experiência na área solicitada e apresenta uma proposta técnica sólida e competitiva. Dispomos de todos os recursos humanos, materiais e financeiros para cumprir os requisitos do presente concurso.',
            'Apresentamos a nossa proposta com a convicção de que oferecemos a melhor relação qualidade-preço do mercado. A nossa equipa certificada garante o cumprimento de todos os requisitos técnicos exigidos.',
            'Com mais de 10 anos de experiência no sector e casos de sucesso documentados em projectos similares, estamos preparados para cumprir integralmente os requisitos deste concurso dentro do prazo estipulado.',
            'A nossa empresa é líder no fornecimento de soluções nesta área em Angola. Propomos uma abordagem inovadora que maximiza o retorno do investimento para a entidade contratante.',
        ];

        $applicationStatuses = ['pending', 'pending', 'reviewing', 'accepted', 'rejected'];

        foreach ($fullAppContests as $contest) {
            // 2–4 applications per contest
            $selected = collect($candidates)->shuffle()->take(rand(2, 4));
            foreach ($selected as $candidate) {
                ContestApplication::updateOrCreate(
                    ['contest_id' => $contest->id, 'user_id' => $candidate->id],
                    [
                        'cover_letter' => $coverLetters[array_rand($coverLetters)],
                        'status'       => $applicationStatuses[array_rand($applicationStatuses)],
                    ]
                );
            }
        }

        $interestMessages = [
            'Tenho interesse em participar nesta oportunidade e gostaria de receber mais informações.',
            'Manifesto o meu interesse e coloco-me à disposição para qualquer esclarecimento adicional.',
            'Após análise cuidadosa, tenho muito interesse em participar. A minha experiência é relevante para esta área.',
        ];

        $interestStatuses = ['new', 'new', 'viewed', 'contacted'];

        foreach ($interestContests as $contest) {
            $selected = collect($candidates)->shuffle()->take(rand(3, 6));
            foreach ($selected as $candidate) {
                ContestInterest::updateOrCreate(
                    ['contest_id' => $contest->id, 'user_id' => $candidate->id],
                    [
                        'name'              => $candidate->name,
                        'email'             => $candidate->email,
                        'phone'             => '+244 9' . rand(11, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                        'professional_area' => $candidate->professional_area,
                        'message'           => $interestMessages[array_rand($interestMessages)],
                        'status'            => $interestStatuses[array_rand($interestStatuses)],
                    ]
                );
            }
        }

        /*
        |----------------------------------------------------------------------
        | SavedContests
        |----------------------------------------------------------------------
        */
        $allContests = Contest::where('status', 'active')->pluck('id')->toArray();

        foreach ($candidates as $candidate) {
            $toSave = array_slice($allContests, 0, rand(1, min(3, count($allContests))));
            foreach ($toSave as $contestId) {
                SavedContest::updateOrCreate(
                    ['user_id' => $candidate->id, 'contest_id' => $contestId]
                );
            }
        }

        /*
        |----------------------------------------------------------------------
        | ContestViews
        |----------------------------------------------------------------------
        */
        foreach ($allContests as $contestId) {
            $viewCount = rand(5, 40);
            for ($i = 0; $i < $viewCount; $i++) {
                ContestView::create([
                    'contest_id' => $contestId,
                    'ip_address' => '192.168.' . rand(1, 254) . '.' . rand(1, 254),
                    'user_id'    => rand(0, 1) ? optional(collect($candidates)->random())->id : null,
                    'viewed_at'  => now()->subDays(rand(0, 30)),
                ]);
            }
        }

        /*
        |----------------------------------------------------------------------
        | Advertisements
        |----------------------------------------------------------------------
        */
        $allCompanies = Company::pluck('id')->toArray();

        $ads = [
            [
                'title'    => 'Sonangol — Oportunidades de Carreira 2025',
                'image'    => 'ads/sonangol.jpg',
                'url'      => 'https://sonangol.ao/carreiras',
                'position' => 'homepage_banner',
                'starts_at' => now()->subDays(5),
                'ends_at'   => now()->addDays(25),
                'is_active' => true,
            ],
            [
                'title'    => 'BAI — Programa de Trainee 2025',
                'image'    => 'ads/bai.jpg',
                'url'      => 'https://bancobai.ao/trainee',
                'position' => 'homepage_banner',
                'starts_at' => now()->subDays(2),
                'ends_at'   => now()->addDays(28),
                'is_active' => true,
            ],
            [
                'title'    => 'Bolsas de Estudo Internacionais — Inscrições Abertas',
                'image'    => 'ads/bolsas.jpg',
                'url'      => 'https://bolsas.ao',
                'position' => 'sidebar',
                'starts_at' => now()->subDays(10),
                'ends_at'   => now()->addDays(50),
                'is_active' => true,
            ],
            [
                'title'    => 'Curso de Gestão de Projetos — Inscrições Abertas',
                'image'    => 'ads/gestao.jpg',
                'url'      => 'https://formacao.ao/gestao-projetos',
                'position' => 'sidebar',
                'starts_at' => now()->subDays(1),
                'ends_at'   => now()->addDays(60),
                'is_active' => true,
            ],
        ];

        foreach ($ads as $adData) {
            Advertisement::updateOrCreate(
                ['title' => $adData['title']],
                array_merge($adData, [
                    'company_id'        => $allCompanies[array_rand($allCompanies)],
                    'clicks_count'      => rand(0, 200),
                    'impressions_count' => rand(100, 5000),
                ])
            );
        }
    }
}
