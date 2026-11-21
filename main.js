/**
 * FULL SERVICE POINT SARL — Core Interactions v2.0
 */

document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialiser les icônes Lucide
  if (window.lucide) {
    window.lucide.createIcons();
  }

  // 2. Barre de progression du défilement
  const progressBar = document.getElementById('scroll-progress');
  const updateScrollProgress = () => {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const scrollPercent = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    if (progressBar) {
      progressBar.style.width = `${scrollPercent}%`;
    }
  };
  window.addEventListener('scroll', updateScrollProgress, { passive: true });

  // 3. Navbar scroll effect & Topbar interaction
  const navbar = document.getElementById('navbar');
  const handleNavScroll = () => {
    if (window.scrollY > 15) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  };
  window.addEventListener('scroll', handleNavScroll, { passive: true });
  handleNavScroll();

  // 4. Menu Mobile Drawer
  const menuToggle = document.getElementById('menu-toggle');
  const mobileDrawer = document.getElementById('mobile-drawer');
  const closeDrawer = document.getElementById('close-drawer');
  const mobileLinks = document.querySelectorAll('.mobile-link');

  const openMobileMenu = () => {
    if (mobileDrawer) {
      mobileDrawer.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
  };

  const closeMobileMenu = () => {
    if (mobileDrawer) {
      mobileDrawer.classList.remove('open');
      document.body.style.overflow = '';
    }
  };

  if (menuToggle) menuToggle.addEventListener('click', openMobileMenu);
  if (closeDrawer) closeDrawer.addEventListener('click', closeMobileMenu);
  mobileLinks.forEach(link => link.addEventListener('click', closeMobileMenu));

  // 5. Révélation au défilement (Scroll Reveal)
  const revealElements = document.querySelectorAll('.reveal');
  const revealObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.05,
    rootMargin: '0px 0px 40px 0px'
  });
  revealElements.forEach(el => revealObserver.observe(el));

  // Force reveal on target navigation
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function() {
      const targetId = this.getAttribute('href');
      if (targetId && targetId !== '#') {
        const targetEl = document.querySelector(targetId);
        if (targetEl) {
          targetEl.classList.add('visible');
          targetEl.querySelectorAll('.reveal').forEach(r => r.classList.add('visible'));
        }
      }
    });
  });

  // 6. Animation des compteurs statistiques
  const countElements = document.querySelectorAll('[data-target]');
  let counted = false;

  const animateCounters = () => {
    countElements.forEach(counter => {
      const target = parseFloat(counter.getAttribute('data-target'));
      const prefix = counter.getAttribute('data-prefix') || '';
      const suffix = counter.getAttribute('data-suffix') || '';
      const isDecimal = target % 1 !== 0;
      const duration = 1800;
      const startTime = performance.now();

      const updateCount = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        // Easing outExpo
        const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
        const currentVal = easeProgress * target;

        counter.textContent = `${prefix}${isDecimal ? currentVal.toFixed(1) : Math.floor(currentVal)}${suffix}`;

        if (progress < 1) {
          requestAnimationFrame(updateCount);
        } else {
          counter.textContent = `${prefix}${isDecimal ? target.toFixed(1) : target}${suffix}`;
        }
      };

      requestAnimationFrame(updateCount);
    });
  };

  const statsSection = document.getElementById('stats-container');
  if (statsSection) {
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !counted) {
          counted = true;
          animateCounters();
        }
      });
    }, { threshold: 0.3 });
    statsObserver.observe(statsSection);
  }

  // 7. Filtre du Portfolio de Réalisations
  const filterTabs = document.querySelectorAll('.portfolio-tab');
  const portfolioCards = document.querySelectorAll('.portfolio-card');

  filterTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      filterTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');

      const filter = tab.getAttribute('data-filter');

      portfolioCards.forEach(card => {
        const category = card.getAttribute('data-category');
        if (filter === 'all' || category === filter) {
          card.style.display = 'block';
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0) scale(1)';
          }, 30);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'translateY(12px) scale(0.96)';
          setTimeout(() => {
            card.style.display = 'none';
          }, 300);
        }
      });
    });
  });

  // 8. Lightbox Modal pour prévisualisation HD des projets
  const lightboxModal = document.getElementById('lightbox-modal');
  const lightboxImg = document.getElementById('lightbox-img');
  const lightboxCaption = document.getElementById('lightbox-caption');
  const lightboxCategory = document.getElementById('lightbox-category');
  const lightboxClose = document.getElementById('lightbox-close');

  const openLightbox = (imgSrc, title, category) => {
    if (!lightboxModal) return;
    lightboxImg.src = imgSrc;
    if (lightboxCaption) lightboxCaption.textContent = title || 'Chantier Full Service Point SARL';
    if (lightboxCategory) lightboxCategory.textContent = category || 'Réalisation';
    lightboxModal.classList.add('active');
    document.body.style.overflow = 'hidden';
  };

  const closeLightbox = () => {
    if (!lightboxModal) return;
    lightboxModal.classList.remove('active');
    document.body.style.overflow = '';
  };

  document.querySelectorAll('[data-lightbox]').forEach(item => {
    item.addEventListener('click', (e) => {
      e.preventDefault();
      const imgSrc = item.getAttribute('data-lightbox-img') || item.querySelector('img')?.src;
      const title = item.getAttribute('data-lightbox-title');
      const cat = item.getAttribute('data-lightbox-category');
      if (imgSrc) openLightbox(imgSrc, title, cat);
    });
  });

  if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
  if (lightboxModal) {
    lightboxModal.addEventListener('click', (e) => {
      if (e.target === lightboxModal) closeLightbox();
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeLightbox();
      closeMobileMenu();
    }
  });

  // 9. Interactive Service Pills in Quote form
  const serviceSelect = document.getElementById('contact-service');
  const quickPills = document.querySelectorAll('.service-pill-btn');

  quickPills.forEach(pill => {
    pill.addEventListener('click', () => {
      const val = pill.getAttribute('data-service-val');
      if (serviceSelect && val) {
        serviceSelect.value = val;
        quickPills.forEach(p => p.classList.remove('active-pill'));
        pill.classList.add('active-pill');
        
        // Scroll to form smoothly
        const contactSection = document.getElementById('contact');
        if (contactSection) {
          contactSection.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

  // 10. Formulaire de contact avec validation et simulation d'envoi
  const contactForm = document.getElementById('lead-form');
  const formSuccess = document.getElementById('form-success-alert');
  const submitBtn = document.getElementById('submit-btn');

  if (contactForm && submitBtn) {
    contactForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = `<span class="inline-block animate-spin mr-2">◌</span> Envoi en cours...`;
      submitBtn.disabled = true;

      setTimeout(() => {
        submitBtn.innerHTML = `<i data-lucide="check" class="w-4 h-4 mr-2 inline"></i> Message Envoyé`;
        if (window.lucide) window.lucide.createIcons();
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('bg-emerald-600', 'text-white');

        if (formSuccess) {
          formSuccess.classList.remove('hidden');
          formSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
        contactForm.reset();

        setTimeout(() => {
          submitBtn.innerHTML = originalText;
          submitBtn.disabled = false;
          submitBtn.classList.add('btn-primary');
          submitBtn.classList.remove('bg-emerald-600', 'text-white');
          if (window.lucide) window.lucide.createIcons();
        }, 5000);
      }, 1000);
    });
  }

  // 11. Active nav link highlight on scroll
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');

  const highlightNav = () => {
    let current = '';
    const scrollPosition = window.scrollY + 200;

    sections.forEach(section => {
      const sectionTop = section.offsetTop;
      const sectionHeight = section.offsetHeight;
      if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
        current = section.getAttribute('id');
      }
    });

    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === `#${current}`) {
        link.classList.add('active');
      }
    });
  };

  window.addEventListener('scroll', highlightNav, { passive: true });
});
