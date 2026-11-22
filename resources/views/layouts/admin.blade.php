<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow, noarchive" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard d\'Administration — Full Service Point SARL')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet" />

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
    <style>
      .dash-sidebar-link.active {
        background: rgba(220, 38, 38, 0.1);
        color: #DC2626;
        border-right: 3px solid #DC2626;
        font-weight: 600;
      }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-body antialiased flex h-screen overflow-hidden">

    <!-- SIDEBAR DU DASHBOARD -->
    <aside class="w-64 bg-slate-950 text-slate-300 flex flex-col flex-shrink-0 border-r border-white/10 z-20">
      <!-- En-tête Sidebar -->
      <div class="h-20 flex items-center gap-3 px-6 border-b border-white/10">
        <div class="w-9 h-9 rounded-xl bg-white/10 p-1.5 flex items-center justify-center border border-white/15">
          <img src="{{ asset('images/logo.png') }}" alt="Logo FSP" class="w-full h-full object-contain" />
        </div>
        <div>
          <h1 class="font-heading font-extrabold text-white text-sm leading-tight tracking-tight">FSP DASHBOARD</h1>
          <span class="font-mono text-[10px] text-brand-red uppercase tracking-wider block">Admin & CMS</span>
        </div>
      </div>

      <!-- Navigation Sidebar -->
      <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto text-xs font-heading">
        <a href="#vue-ensemble" class="dash-sidebar-link active flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="vue-ensemble">
          <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
          <span>Vue d'ensemble</span>
        </a>

        <a href="#articles" class="dash-sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="articles">
          <div class="flex items-center gap-3">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            <span>Articles du Blog</span>
          </div>
          <span class="bg-red-500/20 text-brand-red px-1.5 py-0.5 rounded text-[10px] font-mono" id="badge-count-articles">3</span>
        </a>

        <a href="#messages" class="dash-sidebar-link flex items-center justify-between px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="messages">
          <div class="flex items-center gap-3">
            <i data-lucide="inbox" class="w-4 h-4"></i>
            <span>Messages & Devis</span>
          </div>
          <span class="bg-emerald-500/20 text-emerald-400 px-1.5 py-0.5 rounded text-[10px] font-mono">2 nouv.</span>
        </a>

        <a href="#services" class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="services">
          <i data-lucide="briefcase" class="w-4 h-4"></i>
          <span>Pôles de Services</span>
        </a>

        @if(auth()->check() && auth()->user()->isAdmin())
        <a href="#utilisateurs" class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="utilisateurs">
          <i data-lucide="users" class="w-4 h-4"></i>
          <span>Utilisateurs & Rôles</span>
        </a>

        <a href="#parametres" class="dash-sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/5 transition-all" data-tab="parametres">
          <i data-lucide="settings" class="w-4 h-4"></i>
          <span>Paramètres du Site</span>
        </a>
        @endif
      </nav>

      <!-- Pied de Sidebar / Profil connecté & Déconnexion -->
      <div class="p-4 border-t border-white/10 bg-slate-900/80 flex items-center justify-between">
        <div class="flex items-center gap-2.5 overflow-hidden">
          <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('images/profil/profil1.png') }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover border border-white/20 flex-shrink-0" />
          <div class="leading-tight truncate">
            <span class="font-heading font-semibold text-white text-xs block truncate">{{ auth()->user()->name }}</span>
            <span class="text-[10px] text-emerald-400 font-mono">Rôle : {{ ucfirst(auth()->user()->role) }}</span>
          </div>
        </div>
        <div class="flex items-center gap-1">
          <a href="{{ route('home') }}" target="_blank" class="p-1.5 text-slate-400 hover:text-white rounded-lg hover:bg-white/10 transition-colors" title="Voir le site public">
            <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
          </a>
          <button onclick="document.getElementById('logout-form').submit()" class="p-1.5 text-red-400 hover:text-white rounded-lg hover:bg-red-500/20 transition-colors" title="Fermer la session (Déconnexion)">
            <i data-lucide="power" class="w-3.5 h-3.5"></i>
          </button>
        </div>
      </div>
    </aside>

    <!-- Formulaire de Déconnexion Caché (CSRF Laravel) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
      @csrf
    </form>

    <!-- ZONE DE CONTENU PRINCIPALE -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
      <!-- Topbar du Dashboard -->
      <header class="h-20 bg-white border-b border-slate-200 px-8 flex items-center justify-between flex-shrink-0 z-10">
        <div class="flex items-center gap-4">
          <span class="text-xs font-mono px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Session Authentifiée Sécurisée (Laravel)
          </span>
          <span class="text-xs text-slate-400 hidden sm:inline">|</span>
          <span class="text-xs font-medium text-slate-600 hidden sm:inline">Connecté : {{ auth()->user()->name }} ({{ auth()->user()->role }})</span>
        </div>

        <div class="flex items-center gap-3">
          <button id="btn-quick-new-article" class="btn btn-primary text-xs py-2 px-3.5 shadow-sm">
            <i data-lucide="plus" class="w-3.5 h-3.5"></i>
            <span>Rédiger un article</span>
          </button>
          <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-slate text-xs py-2 px-3">
            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
            <span class="hidden md:inline">Site public</span>
          </a>
          <button onclick="document.getElementById('logout-form').submit()" class="btn btn-outline-slate text-xs py-2 px-3 text-red-600 hover:bg-red-50 hover:border-red-200 transition-colors flex items-center gap-1.5" title="Déconnexion sécurisée">
            <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
            <span>Déconnexion</span>
          </button>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto p-8">
        @yield('content')
      </main>
    </div>

    @stack('scripts')
</body>
</html>
