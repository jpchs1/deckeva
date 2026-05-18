(function () {
  var pageUrl = (window.DECKEVA_GUIA && window.DECKEVA_GUIA.pageUrl) || window.location.href;
  var shareMessage = (window.DECKEVA_GUIA && window.DECKEVA_GUIA.shareMessage) ||
    'Te paso la guía DECKEVA para tu piso de Goma EVA 👇';
  var emailSubject = (window.DECKEVA_GUIA && window.DECKEVA_GUIA.emailSubject) ||
    'Guía DECKEVA';
  var emailBody = shareMessage + '\n\n' + pageUrl + '\n\nCualquier duda me avisas.';

  var wa = document.getElementById('shareWhatsapp');
  if (wa) {
    wa.href = 'https://wa.me/?text=' + encodeURIComponent(shareMessage + ' ' + pageUrl);
  }

  var mail = document.getElementById('shareEmail');
  if (mail) {
    mail.href = 'mailto:?subject=' + encodeURIComponent(emailSubject) + '&body=' + encodeURIComponent(emailBody);
  }

  var copyBtn = document.getElementById('shareCopy');
  var copied = document.getElementById('shareCopied');
  if (copyBtn) {
    copyBtn.addEventListener('click', function () {
      var done = function () {
        if (!copied) return;
        copied.classList.add('on');
        setTimeout(function () { copied.classList.remove('on'); }, 2200);
      };
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(pageUrl).then(done).catch(done);
      } else {
        var t = document.createElement('textarea');
        t.value = pageUrl;
        document.body.appendChild(t);
        t.select();
        try { document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(t);
        done();
      }
    });
  }

  var yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // ─── Back-to-top ───
  var toTop = document.getElementById('toTop');
  if (toTop) {
    toTop.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  window.addEventListener('scroll', function () {
    var y = window.scrollY || window.pageYOffset;
    if (toTop) toTop.classList.toggle('on', y > 600);
  }, { passive: true });

  // ─── Checklists interactivos (persistencia en localStorage) ───
  var storageAvailable = (function () {
    try {
      var k = '__deckeva_test__';
      localStorage.setItem(k, '1'); localStorage.removeItem(k);
      return true;
    } catch (e) { return false; }
  })();

  document.querySelectorAll('.check-list[data-checklist]').forEach(function (list) {
    var key = 'deckeva-guia-checklist-' + list.getAttribute('data-checklist');
    var boxes = list.querySelectorAll('input[type="checkbox"]');
    var progressWrap = list.parentElement.querySelector('.checklist-progress');
    var bar = progressWrap ? progressWrap.querySelector('.checklist-bar > span') : null;
    var doneEl = progressWrap ? progressWrap.querySelector('.done') : null;

    if (storageAvailable) {
      try {
        var saved = JSON.parse(localStorage.getItem(key) || '[]');
        boxes.forEach(function (cb) {
          if (saved.indexOf(cb.value) !== -1) cb.checked = true;
        });
      } catch (e) {}
    }

    var update = function () {
      var checked = 0;
      var values = [];
      boxes.forEach(function (cb) {
        if (cb.checked) { checked++; values.push(cb.value); }
      });
      if (bar) bar.style.width = (boxes.length ? (checked / boxes.length * 100) : 0) + '%';
      if (doneEl) doneEl.textContent = checked;
      if (storageAvailable) {
        try { localStorage.setItem(key, JSON.stringify(values)); } catch (e) {}
      }
    };

    boxes.forEach(function (cb) { cb.addEventListener('change', update); });
    update();
  });

  // ─── Analytics helper ───
  var trackEvent = function (name, params) {
    params = params || {};
    params.page_location = pageUrl;
    try {
      if (typeof window.gtag === 'function') {
        window.gtag('event', name, params);
      } else if (window.dataLayer && typeof window.dataLayer.push === 'function') {
        window.dataLayer.push(Object.assign({ event: name }, params));
      }
    } catch (e) {}
  };

  if (wa) wa.addEventListener('click', function () { trackEvent('share', { method: 'whatsapp', content_type: 'guide' }); });
  if (mail) mail.addEventListener('click', function () { trackEvent('share', { method: 'email', content_type: 'guide' }); });
  if (copyBtn) copyBtn.addEventListener('click', function () { trackEvent('share', { method: 'copy_link', content_type: 'guide' }); });

  document.querySelectorAll('a[href*="wa.me"]').forEach(function (a) {
    a.addEventListener('click', function () {
      trackEvent('whatsapp_click', { location: a.closest('section, footer, .wa-float') ? (a.closest('section[id]') ? a.closest('section[id]').id : 'floating_or_footer') : 'unknown' });
    });
  });

  // Scroll-depth milestones
  var milestones = { 25: false, 50: false, 75: false, 100: false };
  window.addEventListener('scroll', function () {
    var doc = document.documentElement;
    var scrolled = (window.scrollY + window.innerHeight) / doc.scrollHeight * 100;
    Object.keys(milestones).forEach(function (m) {
      if (!milestones[m] && scrolled >= Number(m)) {
        milestones[m] = true;
        trackEvent('scroll_depth', { percent: Number(m) });
      }
    });
  }, { passive: true });

  // ─── Video facades ───
  var facades = document.querySelectorAll('.video-facade');
  facades.forEach(function (btn) {
    var id = btn.getAttribute('data-video-id');
    if (!id) return;

    var best = 'https://i.ytimg.com/vi/' + id + '/maxresdefault.jpg';
    var fallback = 'https://i.ytimg.com/vi/' + id + '/hqdefault.jpg';
    btn.style.backgroundImage = 'url("' + best + '")';
    var probe = new Image();
    probe.onerror = function () { btn.style.backgroundImage = 'url("' + fallback + '")'; };
    probe.src = best;

    btn.addEventListener('click', function () {
      var iframe = document.createElement('iframe');
      iframe.src = 'https://www.youtube-nocookie.com/embed/' + id +
                   '?autoplay=1&rel=0&modestbranding=1&playsinline=1';
      iframe.title = btn.getAttribute('data-title') || 'Video DECKEVA';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      iframe.referrerPolicy = 'strict-origin-when-cross-origin';
      iframe.setAttribute('frameborder', '0');
      var wrap = btn.parentElement;
      wrap.replaceChild(iframe, btn);
      trackEvent('video_play', { video_id: id, video_title: btn.getAttribute('data-title') || '' });
    }, { once: true });
  });
})();
