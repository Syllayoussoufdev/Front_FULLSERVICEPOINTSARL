<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Full Service Point SARL | BTP, Hydraulique HVA & Sécurité Côte d\'Ivoire')</title>

    <!-- Métadonnées SEO & Référencement Naturel -->
    <meta name="description" content="@yield('meta_description', 'Full Service Point (FSP) SARL — Entreprise ivoirienne de référence spécialisée dans l\'Hydraulique Villageoise Améliorée (HVA), BTP & Génie Civil, Sécurité Privée, Transport et Microfinance à Abidjan et partout en Côte d\'Ivoire.')" />
    <meta name="keywords" content="@yield('meta_keywords', 'Full Service Point, FSP SARL, Hydraulique Côte d\'Ivoire, HVA Abidjan, BTP Côte d\'Ivoire, Sécurité Privée Abidjan, Transport fret Côte d\'Ivoire, Forage hydraulique, Narcisse KRA')" />
    <meta name="author" content="Full Service Point SARL" />
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    <!-- Open Graph / Réseaux Sociaux & Partages WhatsApp -->
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:locale" content="fr_CI" />
    <meta property="og:site_name" content="Full Service Point SARL" />
    <meta property="og:title" content="@yield('og_title', 'Full Service Point SARL — Bâtir l\'essentiel. Changer des vies.')" />
    <meta property="og:description" content="@yield('og_description', 'Partenaire stratégique de référence en Côte d\'Ivoire : Hydraulique (HVA), BTP, Sécurité, Transport et Microfinance.')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', asset('images/projets/hva1.png'))" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', 'Full Service Point SARL | Solutions d\'Infrastructures & Services')" />
    <meta name="twitter:description" content="@yield('og_description', 'Hydraulique HVA, BTP & Sécurité en Côte d\'Ivoire.')" />
    <meta name="twitter:image" content="@yield('og_image', asset('images/projets/hva1.png'))" />

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              brand: {
                red: '#DC2626',
                'red-dark': '#B91C1C',
                'red-light': '#EF4444',
              },
              slate: {
                850: '#101626',
                950: '#070A12',
              }
            },
            fontFamily: {
              heading: ['"Plus Jakarta Sans"', 'sans-serif'],
              body: ['"Inter"', 'sans-serif'],
              mono: ['"Space Grotesk"', 'monospace'],
            }
          }
        }
      }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}" />

    <!-- Identifiant Google Analytics 4 (injecté depuis la configuration) -->
    <script>
      window.GA_MEASUREMENT_ID = "{{ config('services.google.analytics_id', 'G-FSP2026CI') }}";
    </script>

    @stack('schema')
</head>
<body class="bg-white text-slate-700 antialiased selection:bg-red-500 selection:text-white">

    <div id="scroll-progress"></div>

    <!-- TOPBAR INSTITUTIONNELLE (Aucun lien d'administration visible) -->
    <div id="topbar" class="hidden md:block">
      <div class="max-w-7xl mx-auto px-6 flex items-center justify-between text-xs">
        <div class="flex items-center gap-6">
          <span class="flex items-center gap-2 text-slate-400">
            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-red"></i>
            Abidjan / Yopougon, Côte d'Ivoire
          </span>
          <span class="flex items-center gap-2 text-slate-400">
            <i data-lucide="phone-call" class="w-3.5 h-3.5 text-brand-red"></i>
            +225 27 24 37 15 77 / +225 07 68 97 84 42
          </span>
          <span class="flex items-center gap-2 text-slate-400">
            <i data-lucide="mail" class="w-3.5 h-3.5 text-brand-red"></i>
            fullservicepoint@gmail.com
          </span>
        </div>
        <div class="flex items-center gap-4 text-slate-400 font-mono text-[11px]">
          <span class="bg-white/5 px-2.5 py-0.5 rounded border border-white/10 text-emerald-400">
            Chaque projet transforme des vies
          </span>
          <span class="text-slate-400">Abidjan & Régions</span>
        </div>
      </div>
    </div>

    <!-- NAVBAR PRINCIPALE -->
    <header id="navbar">
      <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
          <div class="w-11 h-11 rounded-xl bg-white/10 p-1.5 flex items-center justify-center border border-white/15 backdrop-blur-md transition-transform group-hover:scale-105">
            <img src="{{ asset('images/logo.png') }}" alt="Logo FSP SARL" class="w-full h-full object-contain" />
          </div>
          <div class="flex flex-col">
            <span class="font-heading font-extrabold text-lg text-white tracking-tight leading-none group-hover:text-red-400 transition-colors">
              FULL SERVICE POINT
            </span>
            <span class="font-mono text-[10px] text-slate-400 tracking-wider uppercase mt-1">
              SARL • Côte d'Ivoire
            </span>
          </div>
        </a>

        <!-- Menu Desktop -->
        <nav class="hidden lg:flex items-center gap-8">
          <a href="{{ route('home') }}#hero" class="nav-link">Accueil</a>
          <a href="{{ route('home') }}#apropos" class="nav-link">À Propos</a>
          <a href="{{ route('home') }}#services" class="nav-link">Pôles d'Activités</a>
          <a href="{{ route('home') }}#projets" class="nav-link">Réalisations</a>
          <a href="{{ route('home') }}#equipe" class="nav-link">Direction</a>
          <a href="{{ route('blog.index') }}" class="nav-link">Actualités</a>
          <a href="{{ route('home') }}#contact" class="nav-link">Contact</a>
        </nav>

        <!-- Action Devis -->
        <div class="hidden lg:flex items-center gap-4">
          <a href="{{ route('home') }}#contact" class="btn btn-primary text-xs py-2 px-4 shadow-sm">
            <span>Demander un Devis</span>
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 btn-icon"></i>
          </a>
        </div>

        <!-- Menu Mobile Button -->
        <button id="menu-toggle" class="lg:hidden p-2 text-white hover:text-red-400 focus:outline-none" aria-label="Ouvrir le menu">
          <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
      </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    @yield('content')

    <!-- FOOTER INSTITUTIONNEL -->
    <footer class="bg-slate-950 text-slate-300 pt-16 pb-12 border-t border-white/10">
      <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
          <div>
            <div class="flex items-center gap-3 mb-4">
              <img src="{{ asset('images/logo.png') }}" alt="FSP Logo" class="w-9 h-9 object-contain" />
              <span class="font-heading font-extrabold text-white text-base">FULL SERVICE POINT</span>
            </div>
            <p class="text-xs text-slate-400 leading-relaxed font-light mb-4">
              Société à Responsabilité Limitée d'ingénierie, de travaux et de services stratégiques en Côte d'Ivoire.
            </p>
          </div>

          <div>
            <h4 class="font-heading font-bold text-white text-sm mb-4">Navigation</h4>
            <ul class="space-y-2.5 text-xs">
              <li><a href="{{ route('home') }}#hero" class="hover:text-white transition-colors">Accueil</a></li>
              <li><a href="{{ route('home') }}#apropos" class="hover:text-white transition-colors">À Propos</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Pôles d'Activités</a></li>
              <li><a href="{{ route('home') }}#projets" class="hover:text-white transition-colors">Nos Réalisations</a></li>
              <li><a href="{{ route('home') }}#equipe" class="hover:text-white transition-colors">Équipe Dirigeante</a></li>
              <li><a href="{{ route('blog.index') }}" class="hover:text-white transition-colors">Actualités / Blog</a></li>
            </ul>
          </div>

          <div>
            <h4 class="font-heading font-bold text-white text-sm mb-4">Expertises</h4>
            <ul class="space-y-2.5 text-xs">
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Hydraulique (HVA)</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">BTP & Travaux Publics</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Sécurité Privée</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Transport & Fret</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Auto-École</a></li>
              <li><a href="{{ route('home') }}#services" class="hover:text-white transition-colors">Microfinance (FUFINAP)</a></li>
            </ul>
          </div>

          <div>
            <h4 class="font-heading font-bold text-white text-sm mb-4">Siège & Contact</h4>
            <p class="text-xs text-slate-400 mb-2">Abidjan / Yopougon, Côte d'Ivoire</p>
            <p class="text-xs text-white font-medium mb-1">Fixe : (+225) 27 24 37 15 77</p>
            <p class="text-xs text-slate-300 font-medium mb-3">Mob : (+225) 07 68 97 84 42</p>
            <a href="mailto:fullservicepoint@gmail.com" class="text-xs text-brand-red hover:underline block break-all">
              fullservicepoint@gmail.com
            </a>
          </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-mono text-slate-400 sm:pr-24">
          <p>© {{ date('Y') }} Full Service Point SARL. Tous droits réservés. • <button type="button" onclick="window.fspOpenCookieModal && window.fspOpenCookieModal()" class="text-slate-400 hover:text-white underline decoration-slate-700 transition-colors">Gestion des cookies</button></p>
          <p class="text-slate-400">
            Plateforme institutionnelle conçue par <span class="text-white font-semibold">Sly_TechnologieCi</span>
          </p>
        </div>
      </div>
    </footer>

    <!-- Bouton WhatsApp Flottant -->
    <a href="https://wa.me/2250768978442?text=Bonjour%20Full%20Service%20Point%20SARL,%20je%20souhaite%20des%20informations%20sur%20vos%20services" target="_blank" rel="noopener noreferrer" class="whatsapp-float" aria-label="Contacter sur WhatsApp">
      <i data-lucide="message-circle" class="w-7 h-7"></i>
    </a>

    <!-- Scripts de Fonctionnement & Cookie Consent Analytics -->
    <script src="{{ asset('main.js') }}"></script>
    <script src="{{ asset('cookie-consent.js') }}"></script>
    @stack('scripts')
</body>
</html>
