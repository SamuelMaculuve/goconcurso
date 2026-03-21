@extends('layouts.app')

@section('title', 'Termos de Uso — GoConcurso')
@section('seo_description', 'Leia os Termos de Uso do GoConcurso: condições de utilização da plataforma de procurement para empresas e fornecedores em Moçambique e África.')
@section('seo_url', route('terms'))
@section('seo_type', 'website')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-3">Termos de Uso</h1>
        <p class="text-sm text-gray-400">Última actualização: {{ date('d \d\e F \d\e Y') }}</p>
    </div>

    <div class="space-y-8 text-sm leading-relaxed text-gray-700">

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">1. Aceitação dos Termos</h2>
            <p>
                Ao aceder e utilizar a plataforma <strong>GoConcurso</strong> (doravante "Plataforma"), o utilizador
                declara ter lido, compreendido e aceite os presentes Termos de Uso. Se não concordar com estes termos,
                deverá abster-se de utilizar a Plataforma.
            </p>
            <p class="mt-2">
                A Plataforma é operada pela <strong>GoConcurso, Lda.</strong>, com sede em Maputo, Moçambique,
                e rege-se pela legislação moçambicana em vigor.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">2. Descrição do Serviço</h2>
            <p>
                O GoConcurso é uma plataforma digital que facilita o processo de procurement em Moçambique e em África,
                conectando empresas compradoras (entidades que publicam concursos de fornecimento) com fornecedores
                de bens e serviços. A Plataforma disponibiliza ferramentas para:
            </p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Publicação e gestão de concursos de fornecimento;</li>
                <li>Pesquisa e candidatura a concursos;</li>
                <li>Registo de interesse em oportunidades;</li>
                <li>Gestão de propostas e candidaturas;</li>
                <li>Estatísticas e relatórios de desempenho.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">3. Registo e Conta de Utilizador</h2>
            <p>Para aceder a determinadas funcionalidades, é necessário criar uma conta. O utilizador compromete-se a:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Fornecer informações verdadeiras, exactas e actualizadas no momento do registo;</li>
                <li>Manter a confidencialidade das suas credenciais de acesso (email e palavra-passe);</li>
                <li>Notificar imediatamente o GoConcurso em caso de acesso não autorizado à sua conta;</li>
                <li>Não criar contas falsas ou em nome de terceiros sem autorização;</li>
                <li>Ser o único responsável por todas as actividades realizadas através da sua conta.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">4. Obrigações dos Utilizadores</h2>
            <p>Ao utilizar a Plataforma, o utilizador compromete-se a:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Utilizar a Plataforma de forma legal e em conformidade com a legislação moçambicana;</li>
                <li>Não publicar conteúdo falso, enganoso, difamatório, ilegal ou que viole direitos de terceiros;</li>
                <li>Não utilizar a Plataforma para fins fraudulentos ou para prejudicar outros utilizadores;</li>
                <li>Não tentar aceder a áreas restritas da Plataforma ou a contas de outros utilizadores;</li>
                <li>Não sobrecarregar os servidores da Plataforma através de ataques automatizados ou scraping;</li>
                <li>Respeitar os direitos de propriedade intelectual do GoConcurso e de terceiros.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">5. Publicação de Concursos</h2>
            <p>As empresas que publicam concursos na Plataforma comprometem-se a:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Publicar apenas concursos reais e com intenção genuína de contratar bens ou serviços;</li>
                <li>Fornecer informações claras, completas e verdadeiras sobre os requisitos e condições do concurso;</li>
                <li>Cumprir os prazos e condições anunciados;</li>
                <li>Responder às propostas recebidas dentro de um prazo razoável;</li>
                <li>Não discriminar fornecedores com base em critérios não objectivos e não relacionados com a prestação do serviço.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">6. Submissão de Propostas</h2>
            <p>Os fornecedores que submetem propostas na Plataforma comprometem-se a:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Apresentar apenas propostas autênticas e com capacidade real de execução;</li>
                <li>Não submeter propostas em concursos nos quais existam conflitos de interesse;</li>
                <li>Não copiar ou plagiar propostas de terceiros;</li>
                <li>Aceitar que a aceitação de uma proposta pela empresa compradora não constitui contrato — o acordo formal é celebrado directamente entre as partes.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">7. Planos e Pagamentos</h2>
            <p>
                O GoConcurso disponibiliza planos gratuitos e pagos. Os planos pagos são cobrados em Meticais (MZN)
                e podem ser mensais ou anuais. O utilizador compromete-se a:
            </p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Pagar as mensalidades ou anuidades acordadas nos prazos estabelecidos;</li>
                <li>Fornecer informações de pagamento verdadeiras e actualizadas;</li>
                <li>Notificar o GoConcurso em caso de incapacidade de pagamento.</li>
            </ul>
            <p class="mt-2">
                O GoConcurso reserva-se o direito de suspender ou encerrar o acesso a funcionalidades premium
                em caso de falta de pagamento. Os valores dos planos estão disponíveis na página de
                <a href="{{ route('pricing') }}" class="text-terracota hover:underline">Planos e Preços</a>.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">8. Propriedade Intelectual</h2>
            <p>
                Todo o conteúdo da Plataforma — incluindo o logótipo, design, textos, imagens e código — é propriedade
                do GoConcurso, Lda. ou dos seus licenciadores, e está protegido pela legislação moçambicana sobre
                propriedade intelectual. É expressamente proibida a reprodução, distribuição ou utilização deste conteúdo
                sem autorização prévia e por escrito.
            </p>
            <p class="mt-2">
                O conteúdo publicado pelos utilizadores (concursos, propostas, perfis) permanece propriedade do respectivo
                utilizador. O utilizador concede ao GoConcurso uma licença não exclusiva para exibir e transmitir esse
                conteúdo no âmbito do funcionamento da Plataforma.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">9. Limitação de Responsabilidade</h2>
            <p>O GoConcurso actua como intermediário entre compradores e fornecedores. Nessa qualidade:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Não é parte nos contratos celebrados entre compradores e fornecedores;</li>
                <li>Não garante a qualidade, legalidade ou veracidade dos concursos ou propostas publicados;</li>
                <li>Não é responsável por danos resultantes de acordos celebrados entre utilizadores;</li>
                <li>Não garante a disponibilidade ininterrupta da Plataforma, reservando-se o direito de efectuar manutenções.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">10. Suspensão e Encerramento de Conta</h2>
            <p>
                O GoConcurso reserva-se o direito de suspender ou encerrar a conta de qualquer utilizador que viole
                os presentes Termos de Uso, sem aviso prévio em casos graves. O utilizador pode encerrar a sua conta
                a qualquer momento, contactando o nosso suporte.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">11. Alterações aos Termos</h2>
            <p>
                O GoConcurso reserva-se o direito de actualizar os presentes Termos de Uso. As alterações serão
                comunicadas aos utilizadores registados por email com antecedência mínima de 15 dias.
                A continuação da utilização da Plataforma após esse prazo implica a aceitação dos novos termos.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">12. Lei Aplicável e Foro Competente</h2>
            <p>
                Os presentes Termos de Uso são regidos pela legislação da República de Moçambique.
                Para a resolução de litígios emergentes da utilização da Plataforma, as partes elegem o foro
                da cidade de Maputo, com expressa renúncia a qualquer outro.
            </p>
        </section>

    </div>

    <div class="mt-12 p-5 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-500">
        Para questões sobre os Termos de Uso, contacte-nos em
        <a href="mailto:legal@goconcurso.co.mz" class="text-terracota hover:underline font-medium">legal@goconcurso.co.mz</a>
        ou através do nosso <a href="{{ route('contact') }}" class="text-terracota hover:underline font-medium">formulário de contacto</a>.
    </div>

</div>
@endsection
