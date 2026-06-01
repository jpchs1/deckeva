/* ════════════════════════════════════════════════════════
   PRO UX — deckeva.cl
   Scroll reveal, counter animation, lazy-load polish
   ════════════════════════════════════════════════════════ */
(function(){
  'use strict';
  if(window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

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
      '.deckeva-partners__grid',
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

  /* ── INIT ── */
  function init(){
    initScrollReveal();
    initCounters();
    initLazyPolish();
    initNavShadow();
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
