{{-- ============================================================
     GoConcurso — SEO Meta Tags
     Yields usados:
       @section('title')          → título da página (já no <title> do layout)
       @section('seo_description')→ meta description (máx 160 chars)
       @section('seo_image')      → URL absoluta da imagem OG
       @section('seo_url')        → URL canónica da página
       @section('seo_type')       → og:type (default: website)
       @section('seo_published')  → datetime de publicação (ISO 8601)
       @section('seo_modified')   → datetime de modificação (ISO 8601)
     ============================================================ --}}

@php
    $siteUrl     = rtrim(config('app.url'), '/');
    $siteName    = 'GoConcurso';
    $defaultDesc = 'GoConcurso é a plataforma líder de procurement em Moçambique. Encontre concursos de fornecimento, publique oportunidades e conecte compradores a fornecedores em toda África.';
    $defaultImg  = $siteUrl . '/assets/img/og-default.png';
@endphp

@php
    $rawTitle   = trim(strip_tags($__env->yieldContent('title', $siteName)));
    $pageTitle  = \Illuminate\Support\Str::limit($rawTitle, 70);
    $fullTitle  = $pageTitle ? "{$pageTitle} — {$siteName}" : "{$siteName} | Procurement em Moçambique";

    $rawDesc    = trim(strip_tags($__env->yieldContent('seo_description', $defaultDesc)));
    $desc       = \Illuminate\Support\Str::limit($rawDesc, 160);

    $image      = $__env->yieldContent('seo_image') ?: $defaultImg;
    $canonical  = $__env->yieldContent('seo_url') ?: url()->full();
    $ogType     = $__env->yieldContent('seo_type') ?: 'website';
@endphp

{{-- ── Primary Meta ── --}}
<meta name="description" content="{{ $desc }}">
<meta name="author"      content="{{ $siteName }}">
<meta name="robots"      content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="keywords"    content="concursos públicos moçambique, procurement, fornecimento, licitações, concursos de fornecimento, maputo, beira, nampula, tete, africa, tender, rfp, adjudicação, compras públicas, GoConcurso">
<link rel="canonical"    href="{{ $canonical }}">

{{-- ── Open Graph ── --}}
<meta property="og:site_name"   content="{{ $siteName }}">
<meta property="og:locale"      content="pt_MZ">
<meta property="og:locale:alternate" content="pt_PT">
<meta property="og:locale:alternate" content="en_US">
<meta property="og:type"        content="{{ $ogType }}">
<meta property="og:title"       content="{{ $fullTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url"         content="{{ $canonical }}">
<meta property="og:image"       content="{{ $image }}">
<meta property="og:image:width"  content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt"   content="{{ $fullTitle }}">
@hasSection('seo_published')
<meta property="article:published_time" content="@yield('seo_published')">
@endif
@hasSection('seo_modified')
<meta property="article:modified_time"  content="@yield('seo_modified')">
@endif

{{-- ── Twitter / X Card ── --}}
<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:site"        content="@@GoConcurso">
<meta name="twitter:title"       content="{{ $fullTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image"       content="{{ $image }}">

{{-- ── Favicon ── --}}
<link rel="icon"             type="image/png" href="{{ asset('assets/img/logo-w.png') }}">
<link rel="shortcut icon"    type="image/x-icon" href="{{ asset('assets/img/logo-w.png') }}">
<meta name="theme-color"     content="#C0602A">
<meta name="msapplication-TileColor" content="#C0602A">

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HGJ3XBF2CN"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HGJ3XBF2CN');
</script>
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "w0pbhc8pln");
</script>
{{--

{{-- @hasSection('seo_breadcrumbs')
<script type="application/ld+json">
@yield('seo_breadcrumbs')
</script>
@endif


@hasSection('seo_schema')
<script type="application/ld+json">
@yield('seo_schema')
</script> --}}

