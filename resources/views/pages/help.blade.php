@extends('layouts.app')

@section('title', 'Centro de Ajuda — GoConcurso')
@section('seo_description', 'Encontre respostas às perguntas mais frequentes sobre o GoConcurso: como publicar concursos, submeter propostas, gerir a sua conta e muito mais.')
@section('seo_url', route('help'))
@section('seo_type', 'website')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Centro de Ajuda</h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
            Encontre respostas às perguntas mais frequentes sobre a plataforma GoConcurso.
        </p>
    </div>

    {{-- FAQ Sections --}}
    @php
        $sections = [
            [
                'title' => 'Sobre a Plataforma',
                'icon'  => '🏢',
                'faqs'  => [
                    ['q' => 'O que é o GoConcurso?',
                     'a' => 'O GoConcurso é uma plataforma digital moçambicana de procurement que liga empresas compradoras a fornecedores de bens e serviços. Permite publicar concursos de fornecimento, pesquisar oportunidades e submeter propostas de forma simples e segura.'],
                    ['q' => 'O GoConcurso é gratuito?',
                     'a' => 'Sim, existe um plano gratuito que permite publicar até 3 concursos por mês. Para funcionalidades avançadas e maior visibilidade, disponibilizamos planos pagos adaptados às necessidades da sua empresa.'],
                    ['q' => 'Em que países está disponível o GoConcurso?',
                     'a' => 'O GoConcurso está disponível em toda a África, com foco particular em Moçambique. Empresas de Maputo, Beira, Nampula, Tete e de todo o país já utilizam a plataforma.'],
                ],
            ],
            [
                'title' => 'Para Empresas (Compradores)',
                'icon'  => '🏗️',
                'faqs'  => [
                    ['q' => 'Como publico um concurso de fornecimento?',
                     'a' => 'Após registar a sua empresa, aceda ao painel de empresa e clique em "Publicar Concurso". Preencha os detalhes do concurso — título, descrição, requisitos, prazo e orçamento — e submeta. O concurso fica disponível na plataforma imediatamente.'],
                    ['q' => 'Como recebo as propostas dos fornecedores?',
                     'a' => 'Todas as propostas são recebidas e geridas directamente no seu painel de empresa, na secção "Candidaturas". Pode visualizar, filtrar e actualizar o estado de cada proposta.'],
                    ['q' => 'Posso editar ou eliminar um concurso depois de publicado?',
                     'a' => 'Sim. Aceda a "Meus Concursos" no painel de empresa, seleccione o concurso e utilize as opções de editar ou eliminar. Recomendamos notificar os fornecedores interessados em caso de alterações significativas.'],
                    ['q' => 'Que tipos de concursos posso publicar?',
                     'a' => 'Pode publicar concursos públicos, concursos limitados (por convite), pedidos de proposta (RFP) e consultas ao mercado. A plataforma é adequada para aquisição de bens, obras e serviços.'],
                ],
            ],
            [
                'title' => 'Para Fornecedores (Candidatos)',
                'icon'  => '🔧',
                'faqs'  => [
                    ['q' => 'Como me candidato a um concurso?',
                     'a' => 'Pesquise os concursos disponíveis, seleccione o que lhe interessa e clique em "Submeter Proposta". Deverá carregar a sua proposta técnica em PDF e preencher a carta de apresentação. A empresa compradora será notificada.'],
                    ['q' => 'Posso acompanhar o estado da minha proposta?',
                     'a' => 'Sim. No seu perfil, na secção "Propostas", pode ver o estado actualizado de cada proposta: Pendente, Em Análise, Seleccionada ou Rejeitada.'],
                    ['q' => 'Como manifesto interesse num concurso sem submeter proposta?',
                     'a' => 'Em concursos que permitem registo de interesse, pode clicar em "Registar Interesse" e indicar a sua área de actuação e contactos. A empresa poderá contactá-lo directamente.'],
                    ['q' => 'Posso guardar concursos para consultar mais tarde?',
                     'a' => 'Sim. Clique no ícone de guardar em qualquer concurso para o adicionar à sua lista de guardados, acessível no seu perfil.'],
                ],
            ],
            [
                'title' => 'Conta e Segurança',
                'icon'  => '🔐',
                'faqs'  => [
                    ['q' => 'Como altero a minha palavra-passe?',
                     'a' => 'Aceda ao seu perfil, clique em "Editar Perfil" e utilize a opção de alteração de palavra-passe. Por segurança, necessitará de introduzir a palavra-passe actual.'],
                    ['q' => 'Os meus dados estão seguros?',
                     'a' => 'Sim. O GoConcurso utiliza encriptação SSL/TLS em todas as comunicações e armazena os dados em servidores seguros. Não partilhamos os seus dados pessoais com terceiros sem o seu consentimento. Consulte a nossa Política de Privacidade para mais detalhes.'],
                    ['q' => 'Como elimino a minha conta?',
                     'a' => 'Para eliminar a sua conta, contacte-nos através do formulário "Fale Connosco" com o assunto "Eliminação de conta". Processaremos o pedido em até 5 dias úteis.'],
                ],
            ],
        ];
    @endphp

    <div class="space-y-10" x-data="{ open: null }">
        @foreach($sections as $si => $section)
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>{{ $section['icon'] }}</span> {{ $section['title'] }}
                </h2>
                <div class="space-y-3">
                    @foreach($section['faqs'] as $fi => $faq)
                        @php $key = $si . '-' . $fi; @endphp
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden"
                             x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-5 py-4 text-left">
                                <span class="font-medium text-gray-800 text-sm">{{ $faq['q'] }}</span>
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0 transition-transform"
                                     :class="open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="px-5 pb-4">
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="mt-16 bg-forest-green rounded-2xl p-8 text-center text-white">
        <h3 class="text-xl font-bold mb-2">Não encontrou a sua resposta?</h3>
        <p class="text-green-100 mb-6 text-sm">A nossa equipa de suporte está disponível para o ajudar.</p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 bg-white text-forest-green font-semibold px-6 py-2.5 rounded-lg hover:bg-green-50 transition text-sm">
            Fale Connosco
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>
@endsection
