<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow, noarchive" />
    <title>Accès Sécurisé — Administration | Full Service Point SARL</title>
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
</head>
<body class="bg-slate-950 text-slate-100 font-body antialiased min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-brand-red selection:text-white">

    <div class="absolute -top-40 -left-40 w-96 h-96 bg-red-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <main class="w-full max-w-md relative z-10">
        <!-- Logo & Titre Institutionnel -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl p-3 shadow-2xl mb-4 group hover:border-red-500/50 transition-colors">
                <img src="{{ asset('images/logo.png') }}" alt="Logo FSP SARL" class="w-full h-full object-contain" />
            </div>
            <h1 class="font-heading font-extrabold text-2xl text-white tracking-tight">Espace d'Administration</h1>
            <p class="text-xs text-slate-400 mt-1 font-mono">Système de Gestion de Contenu — FSP SARL</p>
        </div>

        <!-- Carte de Connexion Sécurisée -->
        <div class="bg-slate-900/90 border border-white/10 backdrop-blur-xl rounded-2xl p-7 shadow-2xl relative">
            <div class="flex items-center justify-between pb-5 mb-5 border-b border-white/10 text-xs">
                <span class="flex items-center gap-1.5 text-emerald-400 font-mono text-[11px]">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                    Session Protégée & Chiffrée (Laravel Auth)
                </span>
                <span class="text-[10px] font-mono text-slate-500 bg-white/5 px-2 py-0.5 rounded border border-white/5">
                    CSRF Protégé
                </span>
            </div>

            <!-- Message Flash de Déconnexion / Statut -->
            @if(session('status'))
                <div class="mb-5 p-3 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-300 text-xs flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-blue-400 flex-shrink-0"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Erreurs de Validation ou Échec d'Authentification -->
            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-start gap-3">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-brand-red flex-shrink-0 mt-0.5"></i>
                    <div class="leading-relaxed">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Formulaire Laravel -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Champ Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5 font-heading">
                        Identifiant Professionnel (Email)
                    </label>
                    <div class="relative">
                        <i data-lucide="user" class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="email" 
                            placeholder="admin@fullservicepoint.ci" 
                            class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-slate-950/80 border @error('email') border-red-500 @else border-white/10 @enderror text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors"
                        />
                    </div>
                </div>

                <!-- Champ Mot de Passe -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-xs font-semibold text-slate-300 font-heading">
                            Mot de passe
                        </label>
                        <span class="text-[11px] text-slate-500 font-mono">Sensible à la casse</span>
                    </div>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-500 absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password" 
                            placeholder="••••••••••••" 
                            class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-slate-950/80 border @error('password') border-red-500 @else border-white/10 @enderror text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors"
                        />
                        <button 
                            type="button" 
                            id="toggle-pwd-btn" 
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 focus:outline-none p-1"
                            aria-label="Afficher ou masquer"
                        >
                            <i data-lucide="eye" id="toggle-pwd-icon" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <!-- Mémoriser ma session -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-slate-400 select-none">
                        <input type="checkbox" name="remember" id="remember" class="rounded bg-slate-950 border-white/10 text-brand-red focus:ring-0" />
                        <span>Mémoriser ma session</span>
                    </label>
                    <span class="text-[11px] text-slate-500 font-mono">Expiration: 24h</span>
                </div>

                <!-- Bouton Connexion -->
                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full py-2.5 px-4 rounded-xl bg-brand-red hover:bg-brand-red-dark text-white font-heading font-semibold text-xs tracking-wide shadow-lg shadow-red-900/30 flex items-center justify-center gap-2 transition-all group"
                    >
                        <i data-lucide="log-in" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                        <span>Se connecter au CMS</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Mentions de sécurité -->
        <div class="text-center mt-6 text-[11px] text-slate-500 font-mono space-y-1">
            <p>Accès restreint aux administrateurs accrédités de Full Service Point SARL.</p>
            <div class="pt-3">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
                    <span>Retour au site public</span>
                </a>
            </div>
        </div>
    </main>

    <script>
        const pwdInput = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-pwd-btn');
        if (toggleBtn && pwdInput) {
            toggleBtn.addEventListener('click', () => {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
                const icon = document.getElementById('toggle-pwd-icon');
                if (icon) {
                    icon.setAttribute('data-lucide', isPassword ? 'eye-off' : 'eye');
                    if (window.lucide) window.lucide.createIcons();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', () => {
            if (window.lucide) window.lucide.createIcons();
        });
    </script>
</body>
</html>
