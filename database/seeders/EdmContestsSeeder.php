<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Contest;
use App\Models\ContestCategory;

class EdmContestsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'concursos@edm.co.mz'],
            [
                'name'              => 'EDM Electricidade de Mocambique',
                'password'          => Hash::make('edm@2026secure'),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole('company');

        $company = Company::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name'        => 'Electricidade de Mocambique (EDM)',
                'slug'        => 'electricidade-de-mocambique-edm',
                'email'       => 'concursos@edm.co.mz',
                'phone'       => '+258 21 422571',
                'website'     => 'https://www.edm.co.mz',
                'country'     => 'Mocambique',
                'city'        => 'Maputo',
                'address'     => 'Av. Eduardo Mondlane, No 1398, 7o Andar, Maputo',
                'description' => 'Empresa publica responsavel pela producao, transmissao, distribuicao e comercializacao de energia electrica em Mocambique.',
                'sector'      => 'Energia e Utilities',
                'nuit'        => '400003789',
                'is_verified' => true,
                'is_active'   => true,
            ]
        );

        $cats      = ContestCategory::pluck('id', 'slug');
        $techId    = $cats['tecnologia-ti']         ?? 1;
        $constId   = $cats['construcao-obras']       ?? 2;
        $consultId = $cats['consultoria-assessoria'] ?? 3;
        $manutId   = $cats['manutencao-reparacao']   ?? 4;
        $telecomId = $cats['telecomunicacoes']       ?? 12;

        $contests = [
            [
                'title'              => 'Pre-Qualificacao SCADA/EMS e Telecomunicacoes para o NCC e Centros Regionais (EDM 2026)',
                'slug'               => 'pre-qualificacao-scada-ems-telecomunicacoes-ncc-rccs-edm-2026',
                'description'        => '<p>A EDM lanca pre-qualificacao para o fornecimento, instalacao e comissionamento de sistema SCADA/EMS conectando 83 subestacoes via RTUs ou SAS. Inclui backbone de telecomunicacoes e 4 novos centros de controlo: NCC em Matalane, RCC Sul em Maputo, RCC Central em Chibata, RCC Norte em Nampula.</p>',
                'requirements'       => '<ul><li>Certificacao ISO 9001:2015 ou equivalente</li><li>Certificados de utilizador final com 80% de conclusao de contratos de referencia</li><li>Perfil corporativo e certificados de registo legal (traducao para ingles obrigatoria)</li><li>Submissao: 1 original, 3 copias impressas, 1 pen USB</li></ul>',
                'benefits'           => '<p>Referencia EDM: EDM/2026-DEP/071/9. Contacto: procurement.ncc@edm.co.mz</p>',
                'category_id'        => $techId,
                'type'               => 'tender',
                'participation_type' => 'interest_only',
                'accepts_proposals'  => false,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Maputo',
                'deadline'           => '2026-03-30 14:00:00',
                'budget'             => null,
                'is_featured'        => true,
                'is_active'          => true,
            ],
            [
                'title'              => 'Manifestacao de Interesse: Consultoria para Linha 110kV Massinga-Vilankulo',
                'slug'               => 'manifestacao-interesse-consultoria-massinga-vilankulo-edm-2026',
                'description'        => '<p>A EDM solicita manifestacoes de interesse de empresas de consultoria para realizar estudos de viabilidade e avaliacao de impacto ambiental financiados pela SIDA para a linha 110kV Massinga-Vilankulo.</p>',
                'requirements'       => '<ul><li>Minimo 3 estudos de viabilidade nos ultimos 5 anos para concessionarias electricas</li><li>Experiencia na Africa Subsariana (ultimos 5 anos)</li><li>Especialistas em gestao de projectos (15+ anos, certificados)</li><li>Engenheiros e economistas (10+ anos)</li><li>Certificacao ISO 9001</li></ul><p>Avaliacao: 50pts experiencia, 40pts RH, 10pts ISO. Minimo 70 pontos.</p>',
                'benefits'           => '<p>Contacto: ppf.procurement@edm.co.mz</p>',
                'category_id'        => $consultId,
                'type'               => 'tender',
                'participation_type' => 'interest_only',
                'accepts_proposals'  => true,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Inhambane',
                'deadline'           => '2026-04-10 10:00:00',
                'budget'             => null,
                'is_featured'        => true,
                'is_active'          => true,
            ],
            [
                'title'              => 'Concurso Publico 07/EDM-DIA/2026: Fibra Optica ADSS para Xai-Xai',
                'slug'               => 'concurso-07-edm-dia-2026-fibra-optica-adss-xai-xai',
                'description'        => '<p>Concurso publico para o fornecimento, instalacao e comissionamento de cabo de fibra optica ADSS para conectar a Area de Servico ao Cliente de Xai-Xai ao COD (Centro de Operacao e Despacho).</p>',
                'requirements'       => '<ul><li>Garantia provisoria: 18.000,00 MZN</li><li>Registo obrigatorio em fornecedores.edm.co.mz</li><li>Visita ao local: 10 Marco 2026, 10:00, Sede ASC Xai-Xai (Rua Praia)</li></ul>',
                'benefits'           => '<p>Documentacao disponivel mediante 1.500,00 MZN. Contacto: +258 21 422571</p>',
                'category_id'        => $telecomId,
                'type'               => 'tender',
                'participation_type' => 'full_application',
                'accepts_proposals'  => true,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Xai-Xai',
                'deadline'           => '2026-03-31 10:00:00',
                'budget'             => 18000,
                'is_featured'        => true,
                'is_active'          => true,
            ],
            [
                'title'              => 'Concurso Publico 08/EDM-DIA/2026: 10 Abrigos para Geradores nas Subestacoes da Regiao Sul',
                'slug'               => 'concurso-08-edm-dia-2026-abrigos-geradores-subestacoes-sul',
                'description'        => '<p>Concurso publico para a construcao de dez estruturas de abrigo para geradores em subestacoes da regiao sul: Matola SE275, SE2, SE8, SE11 e outras.</p>',
                'requirements'       => '<ul><li>Garantia provisoria: 60.000,00 MZN</li><li>Registo obrigatorio em fornecedores.edm.co.mz</li><li>Visitas: 16 Marco 2026 nas subestacoes Matola SE275, SE2, SE8, SE11</li></ul>',
                'benefits'           => '<p>Documentacao disponivel mediante 1.500,00 MZN. Contacto: +258 21 422571</p>',
                'category_id'        => $constId,
                'type'               => 'tender',
                'participation_type' => 'full_application',
                'accepts_proposals'  => true,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Maputo',
                'deadline'           => '2026-03-30 10:00:00',
                'budget'             => 60000,
                'is_featured'        => true,
                'is_active'          => true,
            ],
            [
                'title'              => 'Concurso Publico 09/EDM-DIA/2026: Manutencao de Ar Condicionado em Centrais Electricas',
                'slug'               => 'concurso-09-edm-dia-2026-ar-condicionado-centrais-electricas',
                'description'        => '<p>Fornecimento, manutencao e reparacao de unidades de ar condicionado em centrais electricas, incluindo a Barragem de Corumane.</p>',
                'requirements'       => '<ul><li>Garantia provisoria: 60.000,00 MZN</li><li>Registo obrigatorio em fornecedores.edm.co.mz</li><li>Visita ao local: 18 Marco 2026, 09:00, Barragem de Corumane</li></ul>',
                'benefits'           => '<p>Documentacao disponivel mediante 1.500,00 MZN. Contacto: +258 21 422571</p>',
                'category_id'        => $manutId,
                'type'               => 'tender',
                'participation_type' => 'full_application',
                'accepts_proposals'  => true,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Maputo',
                'deadline'           => '2026-03-30 13:00:00',
                'budget'             => 60000,
                'is_featured'        => false,
                'is_active'          => true,
            ],
            [
                'title'              => 'Projecto CND Lote 1: Edificios para o Centro Nacional de Despacho e Centros Regionais (ADF)',
                'slug'               => 'projecto-cnd-lote-1-edificios-ncc-centros-regionais-edm-2026',
                'description'        => '<p>A EDM solicita propostas para concepcao, fornecimento e construcao de edificios civis em 4 sub-lotes: Lote 1-A NCC em Matalane, Lote 1-B RCC Sul Maputo, Lote 1-C RCC Central Chibata, Lote 1-D RCC Norte Nampula. Prazo 20 meses. Financiado pelo Fundo de Desenvolvimento Africano (ADF).</p>',
                'requirements'       => '<ul><li>Propostas seladas apenas (sem submissoes electronicas)</li><li>Garantia: USD 200k (1-A), USD 125k (1-B), USD 100k (1-C e 1-D)</li><li>Propostas para sub-lotes individuais ou combinados sao aceites</li></ul>',
                'benefits'           => '<p>Referencia: EDM/2025-DEP/071/09. Contacto: procurement.ncc@edm.co.mz</p>',
                'category_id'        => $constId,
                'type'               => 'tender',
                'participation_type' => 'full_application',
                'accepts_proposals'  => true,
                'status'             => 'active',
                'country'            => 'Mocambique',
                'city'               => 'Maputo',
                'deadline'           => '2026-05-05 14:00:00',
                'budget'             => null,
                'is_featured'        => true,
                'is_active'          => true,
            ],
            [
                'title'              => 'Adjudicacao: Posto de Seccionamento de 33kV de Ponta D\'Ouro - No 07/EDM-DEP-PS/2025',
                'slug'               => 'adjudicacao-posto-seccionamento-33kv-ponta-douro-edm-2025',
                'description'        => '<p>Anuncio de adjudicacao do Concurso Publico No 07/EDM-DEP-PS/2025 para construcao do Posto de Seccionamento de 33kV em Ponta D\'Ouro. Publicado para efeitos de transparencia.</p>',
                'requirements'       => '<p>Concurso encerrado.</p>',
                'benefits'           => '<p>Contacto: +258 21 422571</p>',
                'category_id'        => $constId,
                'type'               => 'tender',
                'participation_type' => 'interest_only',
                'accepts_proposals'  => false,
                'status'             => 'closed',
                'country'            => 'Mocambique',
                'city'               => 'Maputo',
                'deadline'           => '2026-04-13 00:00:00',
                'budget'             => null,
                'is_featured'        => false,
                'is_active'          => true,
            ],
            [
                'title'              => 'Adjudicacao: Reabilitacao das Subestacoes de Media Tensao da Maxixe e Chimoio-1 - No 08/EDM-DEP-SEs-MT/2025',
                'slug'               => 'adjudicacao-subestacoes-maxixe-chimoio-edm-2025',
                'description'        => '<p>Anuncio de adjudicacao do Concurso No 08/EDM-DEP-SEs-MT/2025 para reabilitacao das subestacoes de media tensao da Maxixe (Inhambane) e Chimoio-1 (Manica).</p>',
                'requirements'       => '<p>Concurso encerrado.</p>',
                'benefits'           => '<p>Contacto: +258 21 422571</p>',
                'category_id'        => $manutId,
                'type'               => 'tender',
                'participation_type' => 'interest_only',
                'accepts_proposals'  => false,
                'status'             => 'closed',
                'country'            => 'Mocambique',
                'city'               => 'Inhambane',
                'deadline'           => '2026-04-13 00:00:00',
                'budget'             => null,
                'is_featured'        => false,
                'is_active'          => true,
            ],
            [
                'title'              => 'Adjudicacao: Reabilitacao das Subestacoes da Beira, Montepuez e Lichinga - No 02/EDM-DEP-SEs-MT/2025',
                'slug'               => 'adjudicacao-subestacoes-beira-montepuez-lichinga-edm-2025',
                'description'        => '<p>Anuncio de adjudicacao do Concurso No 02/EDM-DEP-SEs-MT/2025 para reabilitacao das subestacoes de media tensao da Beira (Sofala), Montepuez (Cabo Delgado) e Lichinga (Niassa).</p>',
                'requirements'       => '<p>Concurso encerrado.</p>',
                'benefits'           => '<p>Contacto: +258 21 422571</p>',
                'category_id'        => $manutId,
                'type'               => 'tender',
                'participation_type' => 'interest_only',
                'accepts_proposals'  => false,
                'status'             => 'closed',
                'country'            => 'Mocambique',
                'city'               => 'Beira',
                'deadline'           => '2026-04-13 00:00:00',
                'budget'             => null,
                'is_featured'        => false,
                'is_active'          => true,
            ],
        ];

        foreach ($contests as $data) {
            Contest::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['company_id' => $company->id])
            );
        }

        echo 'EDM: ' . count($contests) . ' concursos importados.';
    }
}