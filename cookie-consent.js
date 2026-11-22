/**
 * Full Service Point SARL — Système de Gestion du Consentement Cookies & Google Analytics 4
 * Conforme RGPD / APDP Côte d'Ivoire
 */

(function () {
  'use strict';

  // Identifiant Google Analytics 4 (Configurable via variable d'environnement ou balise)
  const GA_MEASUREMENT_ID = window.GA_MEASUREMENT_ID || 'G-FSP2026CI';
  const COOKIE_STORAGE_KEY = 'fsp_cookie_consent';
  const COOKIE_EXPIRY_DAYS = 180; // 6 mois

  // 1. Initialiser Google Analytics 4 de manière conditionnelle
  function loadGoogleAnalytics() {
    if (window.gaLoaded) return;
    window.gaLoaded = true;

    // Injection asynchrone de la balise Google Tag
    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${GA_MEASUREMENT_ID}`;
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer || [];
    function gtag() {
      window.dataLayer.push(arguments);
    }
    window.gtag = gtag;

    gtag('js', new Date());
    gtag('config', GA_MEASUREMENT_ID, {
      anonymize_ip: true,
      send_page_view: true,
      cookie_flags: 'SameSite=None;Secure'
    });

    console.info('[FSP Analytics] Google Analytics 4 activé avec succès (' + GA_MEASUREMENT_ID + ')');
  }

  // Fonction globale d'envoi d'événements personnalisés
  window.fspTrackEvent = function (eventName, eventParams = {}) {
    const consent = localStorage.getItem(COOKIE_STORAGE_KEY);
    if (consent === 'all' || consent === 'analytics_accepted') {
      if (typeof window.gtag === 'function') {
        window.gtag('event', eventName, eventParams);
        console.debug('[FSP Analytics Event]', eventName, eventParams);
      }
    }
  };

  // 2. Création et injection du bandeau de consentement
  function injectBannerHTML() {
    if (document.getElementById('fsp-cookie-banner')) return;

    const banner = document.createElement('div');
    banner.id = 'fsp-cookie-banner';
    banner.className = 'fixed bottom-4 left-4 right-4 md:left-auto md:right-6 md:max-w-md z-50 transition-all duration-300 transform translate-y-0';
    banner.innerHTML = `
      <div class="bg-slate-950/95 border border-white/15 text-slate-200 rounded-2xl p-5 shadow-2xl backdrop-blur-xl text-xs font-body">
        <div class="flex items-start gap-3.5 mb-3">
          <div class="w-8 h-8 rounded-xl bg-red-600/20 text-brand-red flex items-center justify-center flex-shrink-0 mt-0.5 border border-red-500/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <div>
            <h4 class="font-heading font-bold text-white text-sm">Gestion des Cookies & Données</h4>
            <p class="text-slate-400 mt-1 leading-relaxed text-[11px]">
              Full Service Point SARL utilise des cookies techniques et des outils de mesure d'audience (Google Analytics) pour analyser le trafic et optimiser nos services professionnels.
            </p>
          </div>
        </div>
        <div class="flex items-center gap-2 pt-2 border-t border-white/10">
          <button id="btn-accept-all-cookies" class="flex-1 py-2 px-3 rounded-lg bg-brand-red hover:bg-red-700 text-white font-heading font-semibold text-xs tracking-wide transition-colors text-center shadow-sm">
            Accepter tout
          </button>
          <button id="btn-refuse-cookies" class="py-2 px-3 rounded-lg bg-white/10 hover:bg-white/15 text-slate-300 font-heading text-xs transition-colors text-center">
            Refuser
          </button>
          <button id="btn-open-cookie-modal" class="py-2 px-2.5 rounded-lg text-slate-400 hover:text-white text-[11px] font-mono transition-colors" title="Paramétrer les cookies">
            Détails
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(banner);

    // Événements du bandeau
    document.getElementById('btn-accept-all-cookies').addEventListener('click', () => {
      saveConsent('all');
      hideBanner();
      loadGoogleAnalytics();
      window.fspTrackEvent('consent_accepted_all');
    });

    document.getElementById('btn-refuse-cookies').addEventListener('click', () => {
      saveConsent('essential_only');
      hideBanner();
      console.info('[FSP Analytics] Cookies de mesure refusés par l’utilisateur.');
    });

    document.getElementById('btn-open-cookie-modal').addEventListener('click', () => {
      openModal();
    });
  }

  // 3. Modal de personnalisation détaillée
  function injectModalHTML() {
    if (document.getElementById('fsp-cookie-modal')) return;

    const modal = document.createElement('div');
    modal.id = 'fsp-cookie-modal';
    modal.className = 'fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden';
    modal.innerHTML = `
      <div class="bg-slate-900 border border-white/15 rounded-2xl max-w-lg w-full p-6 text-xs text-slate-300 shadow-2xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-white/10">
          <h3 class="font-heading font-bold text-white text-base">Préférences de Confidentialité</h3>
          <button id="btn-close-cookie-modal" class="text-slate-400 hover:text-white p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <p class="text-slate-400 text-[11px] leading-relaxed">
          Vous pouvez choisir d'activer ou de désactiver chaque catégorie de cookies. Vos choix sont enregistrés pour une durée de 6 mois.
        </p>

        <div class="space-y-3 pt-1">
          <!-- Cookies Essentiels -->
          <div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between">
            <div>
              <span class="font-heading font-semibold text-white block">Cookies Techniques & Sécurité</span>
              <span class="text-slate-400 text-[10px] block mt-0.5">Nécessaires au bon fonctionnement du site et à la sécurité des sessions.</span>
            </div>
            <span class="text-[10px] font-mono uppercase bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded">Toujours Actif</span>
          </div>

          <!-- Cookies Analytiques Google Analytics -->
          <div class="p-3.5 rounded-xl bg-white/5 border border-white/10 flex items-center justify-between">
            <div class="pr-4">
              <span class="font-heading font-semibold text-white block">Mesure d'Audience (Google Analytics)</span>
              <span class="text-slate-400 text-[10px] block mt-0.5">Collecte anonymisée des pages vues, conversions de devis et parcours utilisateur.</span>
            </div>
            <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
              <input type="checkbox" id="toggle-ga-analytics" checked class="sr-only peer">
              <div class="w-9 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-red"></div>
            </label>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
          <button id="btn-save-cookie-preferences" class="py-2 px-4 rounded-xl bg-brand-red hover:bg-red-700 text-white font-heading font-semibold text-xs tracking-wide transition-colors">
            Enregistrer mes choix
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(modal);

    document.getElementById('btn-close-cookie-modal').addEventListener('click', closeModal);
    document.getElementById('btn-save-cookie-preferences').addEventListener('click', () => {
      const gaAllowed = document.getElementById('toggle-ga-analytics').checked;
      if (gaAllowed) {
        saveConsent('all');
        loadGoogleAnalytics();
      } else {
        saveConsent('essential_only');
      }
      closeModal();
      hideBanner();
    });
  }

  function hideBanner() {
    const banner = document.getElementById('fsp-cookie-banner');
    if (banner) {
      banner.classList.add('opacity-0', 'translate-y-8');
      setTimeout(() => banner.remove(), 350);
    }
  }

  function openModal() {
    injectModalHTML();
    const modal = document.getElementById('fsp-cookie-modal');
    if (modal) modal.classList.remove('hidden');
  }

  function closeModal() {
    const modal = document.getElementById('fsp-cookie-modal');
    if (modal) modal.classList.add('hidden');
  }

  function saveConsent(value) {
    const consentObject = {
      choice: value,
      timestamp: Date.now(),
      expiresAt: Date.now() + (COOKIE_EXPIRY_DAYS * 24 * 60 * 60 * 1000)
    };
    localStorage.setItem(COOKIE_STORAGE_KEY, value);
    localStorage.setItem(COOKIE_STORAGE_KEY + '_data', JSON.stringify(consentObject));
  }

  // 4. Câblage automatique des interactions de conversion prospect
  function wireConversionTracking() {
    // A. Formulaire de contact / Devis
    const contactForm = document.getElementById('quote-form');
    if (contactForm) {
      contactForm.addEventListener('submit', () => {
        const pôle = document.getElementById('form-service') ? document.getElementById('form-service').value : 'Non spécifié';
        window.fspTrackEvent('generate_lead', {
          event_category: 'Prospect',
          event_label: pôle,
          value: 1.0
        });
      });
    }

    // B. Bouton WhatsApp
    const waButtons = document.querySelectorAll('a[href*="wa.me"]');
    waButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        window.fspTrackEvent('contact_whatsapp', {
          event_category: 'Engagement',
          event_label: 'Clic Bouton WhatsApp Flottant'
        });
      });
    });

    // C. Appels téléphoniques
    const phoneLinks = document.querySelectorAll('a[href^="tel:"]');
    phoneLinks.forEach(link => {
      link.addEventListener('click', () => {
        window.fspTrackEvent('contact_phone', {
          event_category: 'Engagement',
          event_label: link.getAttribute('href')
        });
      });
    });
  }

  // 5. Initialisation au chargement
  window.fspOpenCookieModal = openModal;

  document.addEventListener('DOMContentLoaded', () => {
    const consent = localStorage.getItem(COOKIE_STORAGE_KEY);
    if (!consent) {
      setTimeout(injectBannerHTML, 1000);
    } else if (consent === 'all' || consent === 'analytics_accepted') {
      loadGoogleAnalytics();
    }
    wireConversionTracking();
  });
})();
