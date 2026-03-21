@extends('layouts.app')

@section('title', 'Planos e Preços — GoConcurso')
@section('seo_description', 'Conheça os planos do GoConcurso para empresas em Moçambique. Comece gratuitamente ou escolha um plano pago para publicar mais concursos e aceder a funcionalidades avançadas.')
@section('seo_url', route('pricing'))
@section('seo_type', 'website')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    {{-- Header --}}
    <div class="text-center mb-14">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Planos e Preços</h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
            Escolha o plano certo para a sua empresa. Comece gratuitamente e escale conforme as suas necessidades.
        </p>
    </div>

    {{-- Plans Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        @forelse($plans as $plan)
            @php
                $isFeatured = $plan->is_featured;
                $features   = is_array($plan->features) ? $plan->features : json_decode($plan->features, true) ?? [];
                $isFree     = $plan->price == 0;
            @endphp

            <div class="relative rounded-2xl border {{ $isFeatured ? 'border-terracota shadow-xl ring-2 ring-terracota' : 'border-gray-200 shadow-sm' }} bg-white overflow-hidden flex flex-col">

                {{-- Featured badge --}}
                @if($isFeatured)
                    <div class="bg-terracota text-white text-xs font-bold text-center py-1.5 tracking-wider uppercase">
                        Mais Popular
                    </div>
                @endif

                <div class="p-8 flex-1 flex flex-col">

                    {{-- Plan name & description --}}
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-gray-900">{{ $plan->name }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $plan->description }}</p>
                    </div>

                    {{-- Price --}}
                    <div class="mb-8">
                        @if($isFree)
                            <div class="flex items-end gap-1">
                                <span class="text-5xl font-extrabold text-gray-900">Grátis</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Sem cartão de crédito</p>
                        @else
                            <div class="flex items-end gap-1">
                                <span class="text-2xl font-semibold text-gray-500">MZN</span>
                                <span class="text-5xl font-extrabold text-gray-900">
                                    {{ number_format($plan->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">
                                por {{ $plan->billing_cycle === 'monthly' ? 'mês' : 'ano' }}, por empresa
                            </p>
                        @endif
                    </div>

                    {{-- CTA --}}
                    @auth
                        @if(auth()->user()->hasRole('company'))
                            <a href="{{ route('company.dashboard') }}"
                               class="block text-center w-full py-3 rounded-xl font-semibold text-sm transition mb-8
                               {{ $isFeatured ? 'bg-terracota text-white hover:bg-[#a0501f]' : 'border-2 border-gray-300 text-gray-700 hover:border-terracota hover:text-terracota' }}">
                                Ir para o Painel
                            </a>
                        @else
                            <a href="{{ route('register.company') }}"
                               class="block text-center w-full py-3 rounded-xl font-semibold text-sm transition mb-8
                               {{ $isFeatured ? 'bg-terracota text-white hover:bg-[#a0501f]' : 'border-2 border-gray-300 text-gray-700 hover:border-terracota hover:text-terracota' }}">
                                Começar {{ $isFree ? 'Gratuitamente' : 'Agora' }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register.company') }}"
                           class="block text-center w-full py-3 rounded-xl font-semibold text-sm transition mb-8
                           {{ $isFeatured ? 'bg-terracota text-white hover:bg-[#a0501f]' : 'border-2 border-gray-300 text-gray-700 hover:border-terracota hover:text-terracota' }}">
                            Começar {{ $isFree ? 'Gratuitamente' : 'Agora' }}
                        </a>
                    @endauth

                    {{-- Features --}}
                    <div class="space-y-3 flex-1">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Incluído:</p>
                        @foreach($features as $feature)
                            <div class="flex items-start gap-3">
                                <svg class="w-4 h-4 text-forest-green flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-sm text-gray-600">{{ $feature }}</span>
                            </div>
                        @endforeach

                        {{-- Max contests info --}}
                        <div class="flex items-start gap-3 pt-2 border-t border-gray-50">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-sm text-gray-500">
                                @if($plan->max_contests)
                                    Até {{ $plan->max_contests }} concursos activos
                                @else
                                    Concursos ilimitados
                                @endif
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 text-gray-400">
                <p>Nenhum plano disponível de momento. Contacte-nos para mais informações.</p>
            </div>
        @endforelse
    </div>

    {{-- FAQ --}}
    <div class="mt-20">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-10">Perguntas Frequentes sobre Planos</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            @php
                $faqs = [
                    ['q' => 'Posso mudar de plano depois de subscrever?',
                     'a' => 'Sim. Pode fazer upgrade ou downgrade do seu plano a qualquer momento. As alterações entram em vigor no próximo ciclo de facturação.'],
                    ['q' => 'Quais são os métodos de pagamento aceites?',
                     'a' => 'Aceitamos pagamento via M-Pesa, transferência bancária (BCI, BIM/Millennium, Standard Bank) e cartão de crédito/débito Visa e Mastercard.'],
                    ['q' => 'O plano gratuito tem limite de tempo?',
                     'a' => 'Não. O plano gratuito é permanente. Pode usar o GoConcurso gratuitamente até ao limite de 3 concursos activos, sem prazo de expiração.'],
                    ['q' => 'Existe contrato de fidelidade?',
                     'a' => 'Não. Os planos mensais podem ser cancelados a qualquer momento sem penalização. Nos planos anuais, o cancelamento é efectivo no final do período pago.'],
                    ['q' => 'E se a minha empresa for pública ou ONG?',
                     'a' => 'Oferecemos condições especiais para entidades públicas, ONGs e organizações internacionais. Contacte-nos para saber mais sobre os nossos preços institucionais.'],
                    ['q' => 'Como funciona o suporte?',
                     'a' => 'Todos os planos incluem suporte por email. O plano Pro inclui suporte prioritário com resposta em 24h. O plano Premium inclui um gestor de conta dedicado.'],
                ];
            @endphp

            @foreach($faqs as $faq)
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6"
                     x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-start justify-between gap-3 text-left">
                        <span class="font-medium text-gray-800 text-sm">{{ $faq['q'] }}</span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 transition-transform"
                             :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="mt-3">
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- CTA bottom --}}
    <div class="mt-16 bg-forest-green rounded-2xl p-10 text-center text-white">
        <h3 class="text-2xl font-bold mb-2">Não tem a certeza qual o plano certo?</h3>
        <p class="text-green-100 mb-6 text-sm max-w-xl mx-auto">
            A nossa equipa está disponível para ajudá-lo a escolher o plano mais adequado às necessidades
            da sua empresa ou organização.
        </p>
        <a href="{{ route('contact') }}"
           class="inline-flex items-center gap-2 bg-white text-forest-green font-semibold px-8 py-3 rounded-xl hover:bg-green-50 transition text-sm">
            Fale com a nossa equipa
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

</div>
@endsection
