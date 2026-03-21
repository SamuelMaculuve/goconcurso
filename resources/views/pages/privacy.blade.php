@extends('layouts.app')

@section('title', 'Política de Privacidade — GoConcurso')
@section('seo_description', 'Saiba como o GoConcurso recolhe, utiliza e protege os seus dados pessoais, em conformidade com a legislação moçambicana de protecção de dados.')
@section('seo_url', route('privacy'))
@section('seo_type', 'website')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <div class="mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-3">Política de Privacidade</h1>
        <p class="text-sm text-gray-400">Última actualização: {{ date('d \d\e F \d\e Y') }}</p>
    </div>

    <div class="prose prose-gray max-w-none space-y-8 text-sm leading-relaxed text-gray-700">

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">1. Identificação do Responsável pelo Tratamento</h2>
            <p>
                O <strong>GoConcurso</strong> é uma plataforma digital de procurement operada por <strong>GoConcurso, Lda.</strong>,
                com sede em Maputo, Moçambique. Para efeitos da presente Política de Privacidade, a GoConcurso, Lda.
                é a entidade responsável pelo tratamento dos seus dados pessoais.
            </p>
            <p class="mt-2">
                Contacto do Responsável pelo Tratamento:<br>
                Email: <a href="mailto:privacidade@goconcurso.co.mz" class="text-terracota hover:underline">privacidade@goconcurso.co.mz</a><br>
                Morada: Av. Julius Nyerere, Maputo, Moçambique
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">2. Dados Pessoais que Recolhemos</h2>
            <p>Recolhemos os seguintes dados pessoais quando utiliza a nossa plataforma:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li><strong>Dados de identificação:</strong> nome completo, endereço de email, número de telefone;</li>
                <li><strong>Dados profissionais:</strong> área de actuação, currículo (CV), carta de apresentação;</li>
                <li><strong>Dados da empresa:</strong> nome, NIF, sector de actividade, país e cidade;</li>
                <li><strong>Dados de utilização:</strong> endereço IP, tipo de browser, páginas visitadas, data e hora de acesso;</li>
                <li><strong>Comunicações:</strong> mensagens enviadas através do formulário de contacto.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">3. Finalidades do Tratamento</h2>
            <p>Os seus dados pessoais são tratados para as seguintes finalidades:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Criação e gestão da sua conta na plataforma;</li>
                <li>Facilitação da submissão e recepção de propostas em concursos de fornecimento;</li>
                <li>Comunicação entre compradores e fornecedores;</li>
                <li>Envio de notificações sobre o estado das suas candidaturas;</li>
                <li>Melhoria dos nossos serviços e funcionalidades;</li>
                <li>Cumprimento de obrigações legais aplicáveis em Moçambique;</li>
                <li>Envio de informações sobre novos concursos e funcionalidades (com o seu consentimento).</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">4. Base Legal para o Tratamento</h2>
            <p>O tratamento dos seus dados pessoais fundamenta-se nas seguintes bases legais, nos termos da legislação moçambicana aplicável:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li><strong>Execução de contrato:</strong> tratamento necessário para a prestação dos nossos serviços;</li>
                <li><strong>Consentimento:</strong> para o envio de comunicações de marketing;</li>
                <li><strong>Interesse legítimo:</strong> para a melhoria dos serviços e segurança da plataforma;</li>
                <li><strong>Obrigação legal:</strong> para cumprimento de requisitos legais e regulatórios.</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">5. Partilha de Dados com Terceiros</h2>
            <p>
                Não vendemos, alugamos ou cedemos os seus dados pessoais a terceiros para fins comerciais.
                Podemos partilhar dados nas seguintes situações:
            </p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li>Com empresas parceiras que nos prestam serviços de infraestrutura tecnológica (servidores, email), sob acordo de confidencialidade;</li>
                <li>Com autoridades competentes moçambicanas, quando exigido por lei ou decisão judicial;</li>
                <li>Com a empresa compradora, quando submete uma proposta a um concurso publicado por essa empresa (apenas os dados da proposta).</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">6. Conservação dos Dados</h2>
            <p>
                Os seus dados pessoais são conservados pelo período necessário para as finalidades para que foram recolhidos.
                Em regra, os dados de conta são conservados enquanto a conta estiver activa.
                Após o encerramento da conta, os dados são eliminados ou anonimizados no prazo de 90 dias,
                salvo obrigação legal de conservação por período superior.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">7. Os Seus Direitos</h2>
            <p>Nos termos da legislação aplicável, tem os seguintes direitos relativamente aos seus dados pessoais:</p>
            <ul class="mt-3 space-y-1 list-disc list-inside">
                <li><strong>Acesso:</strong> obter confirmação sobre se os seus dados são tratados e aceder aos mesmos;</li>
                <li><strong>Rectificação:</strong> corrigir dados inexactos ou incompletos;</li>
                <li><strong>Eliminação:</strong> solicitar a eliminação dos seus dados ("direito ao esquecimento");</li>
                <li><strong>Portabilidade:</strong> receber os seus dados em formato estruturado e legível por máquina;</li>
                <li><strong>Oposição:</strong> opor-se ao tratamento dos seus dados para fins de marketing;</li>
                <li><strong>Limitação:</strong> solicitar a limitação do tratamento em determinadas circunstâncias.</li>
            </ul>
            <p class="mt-3">
                Para exercer qualquer um destes direitos, contacte-nos em
                <a href="mailto:privacidade@goconcurso.co.mz" class="text-terracota hover:underline">privacidade@goconcurso.co.mz</a>.
                Responderemos no prazo de 15 dias úteis.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">8. Segurança dos Dados</h2>
            <p>
                Adoptamos medidas técnicas e organizativas adequadas para proteger os seus dados pessoais contra
                acesso não autorizado, perda, destruição ou divulgação indevida. A plataforma utiliza encriptação
                SSL/TLS em todas as comunicações e os dados são armazenados em servidores seguros.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">9. Cookies</h2>
            <p>
                Utilizamos cookies essenciais para o funcionamento da plataforma (sessão de utilizador, preferências).
                Não utilizamos cookies de rastreamento ou publicidade de terceiros sem o seu consentimento explícito.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">10. Alterações à Política de Privacidade</h2>
            <p>
                Reservamos o direito de actualizar esta Política de Privacidade sempre que necessário.
                Notificaremos os utilizadores registados sobre alterações significativas por email.
                A data da última actualização está indicada no topo deste documento.
            </p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-900 mb-3">11. Lei Aplicável</h2>
            <p>
                A presente Política de Privacidade é regida pela legislação moçambicana, nomeadamente
                a Lei n.º 3/2017 de 9 de Janeiro (Lei de Protecção de Dados Pessoais) e demais legislação aplicável.
            </p>
        </section>

    </div>

    <div class="mt-12 p-5 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-500">
        Para questões relacionadas com a sua privacidade, contacte-nos em
        <a href="mailto:privacidade@goconcurso.co.mz" class="text-terracota hover:underline font-medium">privacidade@goconcurso.co.mz</a>
        ou através do nosso <a href="{{ route('contact') }}" class="text-terracota hover:underline font-medium">formulário de contacto</a>.
    </div>

</div>
@endsection
