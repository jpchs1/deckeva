/* ════════════════════════════════════════════════════════
   PRO UX — deckeva.cl
   Scroll reveal, counter animation, lazy-load polish
   ════════════════════════════════════════════════════════ */
(function(){
  'use strict';
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ── SCROLL REVEAL ── */
  function initScrollReveal(){
    // Tag sections for reveal
    var selectors = [
      // Section headers
      '.feat-header', '.ship-header', '.pay-header', '.gal-header',
      '.t-header', '.blog-section-header', '.ls1-header',
      '.timeline-header', '.dp-header',
      // Grids (stagger children)
      '.features-grid', '.countries-grid', '.gal-grid',
      '.blog-grid', '.dp-grid', '.dp-partners__grid',
      '.deckeva-partners__grid', '.dq-pillars',
      // Individual cards/items
      '.tl-item', '.ls1-card', '.ls2-item',
      '.quote-form-wrap', '.quote-info',
      '.faq-layout', '.faq-item',
      '.hero-stats-strip',
      // Partners
      '.dp-section .container',
      // Footer CTA
      '.footer-cta-inner'
    ];

    selectors.forEach(function(sel){
      document.querySelectorAll(sel).forEach(function(el){
        if(!el.classList.contains('sr') && !el.classList.contains('sr-scale')){
          // Grids get stagger
          if(sel.indexOf('grid') > -1 || sel.indexOf('Grid') > -1){
            el.classList.add('sr','sr-stagger');
            Array.from(el.children).forEach(function(c){ c.classList.add('sr'); });
          } else {
            el.classList.add('sr');
          }
        }
      });
    });

    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(e.isIntersecting){
          e.target.classList.add('sr--visible');
          // Reveal stagger children too
          if(e.target.classList.contains('sr-stagger')){
            Array.from(e.target.children).forEach(function(c){
              c.classList.add('sr--visible');
            });
          }
          io.unobserve(e.target);
        }
      });
    },{ threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.sr,.sr-left,.sr-right,.sr-scale').forEach(function(el){
      io.observe(el);
    });
  }

  /* ── COUNTER ANIMATION ── */
  function initCounters(){
    var counterEls = document.querySelectorAll('.hss-num, .hero-stat-num, .hv3t-item strong, .t-stat-num, .ship-stat-num');
    if(!counterEls.length) return;

    var cio = new IntersectionObserver(function(entries){
      entries.forEach(function(e){
        if(!e.isIntersecting) return;
        cio.unobserve(e.target);
        animateCounter(e.target);
      });
    },{ threshold: 0.5 });

    counterEls.forEach(function(el){
      el.setAttribute('data-final', el.textContent.trim());
      cio.observe(el);
    });

    function animateCounter(el){
      var text = el.getAttribute('data-final') || '';
      var match = text.match(/^([\d,.]+)/);
      if(!match) return;

      var raw = match[1];
      var num = parseFloat(raw.replace(/,/g, ''));
      if(isNaN(num)) return;

      var suffix = text.substring(raw.length);
      var hasDecimal = raw.indexOf('.') > -1;
      var decimals = hasDecimal ? (raw.split('.')[1] || '').length : 0;
      var duration = 1200;
      var start = performance.now();

      function step(now){
        var t = Math.min((now - start) / duration, 1);
        // Ease out cubic
        var eased = 1 - Math.pow(1 - t, 3);
        var current = eased * num;

        if(hasDecimal){
          el.textContent = current.toFixed(decimals) + suffix;
        } else {
          el.textContent = Math.round(current).toLocaleString('es-CL') + suffix;
        }

        if(t < 1) requestAnimationFrame(step);
        else el.textContent = text; // restore exact original
      }
      requestAnimationFrame(step);
    }
  }

  /* ── LAZY IMAGE LOADED CLASS ── */
  function initLazyPolish(){
    document.querySelectorAll('img[loading="lazy"]').forEach(function(img){
      if(img.complete){
        img.classList.add('loaded');
      } else {
        img.addEventListener('load', function(){ img.classList.add('loaded'); }, {once:true});
      }
    });
  }

  /* ── NAVBAR SCROLL SHADOW ── */
  function initNavShadow(){
    var nav = document.getElementById('navbar');
    if(!nav) return;
    var last = 0;
    window.addEventListener('scroll', function(){
      var y = window.pageYOffset;
      if(y > 60 && !nav.classList.contains('scrolled')) nav.classList.add('scrolled');
      else if(y <= 60 && nav.classList.contains('scrolled')) nav.classList.remove('scrolled');
      last = y;
    }, {passive:true});
  }

  /* ── READING PROGRESS BAR ── */
  function initProgressBar(){
    var bar = document.getElementById('read-progress');
    if(!bar){
      bar = document.createElement('div');
      bar.id = 'read-progress';
      document.body.appendChild(bar);
    }
    var ticking = false;
    function update(){
      var h = document.documentElement;
      var max = h.scrollHeight - h.clientHeight;
      var pct = max > 0 ? (h.scrollTop || window.pageYOffset) / max * 100 : 0;
      bar.style.width = pct + '%';
      ticking = false;
    }
    window.addEventListener('scroll', function(){
      if(!ticking){ requestAnimationFrame(update); ticking = true; }
    }, {passive:true});
    update();
  }

  /* ── BACK TO TOP ── */
  function initBackToTop(){
    var btn = document.getElementById('back-to-top');
    if(!btn){
      btn = document.createElement('button');
      btn.id = 'back-to-top';
      btn.type = 'button';
      btn.setAttribute('aria-label', 'Volver arriba');
      btn.innerHTML = '↑';
      document.body.appendChild(btn);
    }
    btn.addEventListener('click', function(){
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    var ticking = false;
    function toggle(){
      var y = window.pageYOffset;
      if(y > 600) btn.classList.add('show');
      else btn.classList.remove('show');
      ticking = false;
    }
    window.addEventListener('scroll', function(){
      if(!ticking){ requestAnimationFrame(toggle); ticking = true; }
    }, {passive:true});
    toggle();
  }

  /* ── DISMISSIBLE SEO BANNER + FIXED-BAR STACK RECOMPUTE ──
     The inline winter-promo script bakes the SEO banner height (38px/32px)
     into body padding-top and nav top. When the user dismisses the SEO
     banner we drop that height and keep only the winter-promo height.
     We inject an override <style> AFTER #wp-offsets so our !important
     rules win the cascade, and track winter height in a --wp-h var. */
  function initBannerStack(){
    var seo = document.getElementById('seo-cross-banner');
    if(!seo) return;

    // Override style — appended after #wp-offsets so it wins
    var ov = document.getElementById('pro-offsets');
    if(!ov){ ov = document.createElement('style'); ov.id = 'pro-offsets'; document.head.appendChild(ov); }
    ov.textContent =
      'html.seo-closed body{padding-top:var(--wp-h,0px)!important}' +
      'html.seo-closed nav#navbar{top:var(--wp-h,0px)!important}' +
      'html.seo-closed .mobile-menu.open{top:var(--wp-h,0px)!important}';

    function syncWp(){
      var wp = document.getElementById('winter-promo');
      var h = 0;
      if(wp && !document.documentElement.classList.contains('wp-closed') &&
         getComputedStyle(wp).display !== 'none'){
        h = wp.offsetHeight || 0;
      }
      document.documentElement.style.setProperty('--wp-h', h + 'px');
    }

    // Inject close button
    if(!seo.querySelector('.seo-x')){
      var x = document.createElement('button');
      x.type = 'button';
      x.className = 'seo-x';
      x.setAttribute('aria-label', 'Cerrar aviso');
      x.innerHTML = '&times;';
      seo.appendChild(x);
      x.addEventListener('click', function(){
        document.documentElement.classList.add('seo-closed');
        try{ localStorage.setItem('seoBannerClosed','1'); }catch(e){}
        syncWp();
      });
    }

    // Restore previous dismissal
    try{ if(localStorage.getItem('seoBannerClosed') === '1') document.documentElement.classList.add('seo-closed'); }catch(e){}

    syncWp();
    window.addEventListener('resize', syncWp, {passive:true});
    // React when the winter promo gets closed (class change on <html>)
    if(window.MutationObserver){
      new MutationObserver(syncWp).observe(document.documentElement, {attributes:true, attributeFilter:['class']});
    }
    setTimeout(syncWp, 300); setTimeout(syncWp, 800);
  }

  /* ── INIT ── */
  function init(){
    // Functional features run for everyone
    initLazyPolish();
    initNavShadow();
    initProgressBar();
    initBackToTop();
    initBannerStack();
    // Decorative motion only when the user allows it
    if(!reduceMotion){
      initScrollReveal();
      initCounters();
    }
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
