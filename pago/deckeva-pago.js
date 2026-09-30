/*  DECKEVA — Portal de Pago (JS)
    Webpay Plus (CLP)  +  Mercado Pago Checkout Pro (CLP)  +  PayPal Smart Buttons (USD).

    Reusa /api/* del backend compartido (tourevo). Configurable via window.DECKEVA_CFG.
    PayPal corre client-only con el Client ID Live ya conocido.
*/
(function () {
  "use strict";

  // -------------------------------------------------------------------------
  // CONFIG
  // -------------------------------------------------------------------------
  var CFG = Object.assign({
    apiBase: "https://tourevo.cl/api",
    paypalClientId: "AdgtnNA-dGFfexjeWDSe9NVFdZQ2yqK9bhpQBc0oEIJ_kqEPuqA1ITQMXWtSodrHmkmwFTN2GTBEyGQA",
    paypalCurrency: "USD",
    paypalIntent: "capture",
    paypalLocale: "es_CL",
    brandName: "DECKEVA",
    usdRate: (typeof window.DECKEVA_USD_RATE === "number") ? window.DECKEVA_USD_RATE : 850,
    returnBase: "https://deckeva.cl/pago/",
    whatsapp: "56940211459"
  }, window.DECKEVA_CFG || {});

  window.DECKEVA_CFG = CFG;

  // -------------------------------------------------------------------------
  // DOM
  // -------------------------------------------------------------------------
  var $ = function (id) { return document.getElementById(id); };
  var nameInput     = $("payerName");
  var emailInput    = $("payerEmail");
  var phoneInput    = $("payerPhone");
  var bookingInput  = $("bookingCode");
  var amountInput   = $("amount");
  var amountAux     = $("amountAux");
  var descInput     = $("description");
  var termsInput    = $("acceptTerms");

  var sumName       = $("sumName");
  var sumDesc       = $("sumDesc");
  var sumTotal      = $("sumTotal");
  var sumUsdRow     = $("sumUsdRow");
  var sumUsd        = $("sumUsd");
  var summaryEmpty  = $("summaryEmpty");
  var summaryFilled = $("summaryFilled");
  var sumMethod     = $("sumMethod");
  var sumOrder      = $("sumOrder");
  var sumOrderRow   = $("sumOrderRow");
  var payMissing    = $("payMissing");
  var termsRow      = $("termsRow");
  var mobileBar     = $("mobileBar");
  var mbTotal       = $("mbTotal");
  var confirmCard   = $("confirm-card");

  var statusMsg     = $("statusMessage");
  var payArea       = $("payArea");
  var payAreaEmpty  = $("payAreaEmpty");
  var payWebpay     = $("payWebpay");
  var payMP         = $("payMP");
  var payPayPal     = $("payPayPal");
  var btnWebpay     = $("btnWebpay");
  var btnMP         = $("btnMP");

  var steps = {
    s1: $("step-1"),
    s2: $("step-2"),
    s3: $("step-3")
  };

  // -------------------------------------------------------------------------
  // HELPERS
  // -------------------------------------------------------------------------
  function fmtCLP(n) {
    var v = Math.max(0, Math.round(Number(n) || 0));
    return "CLP " + v.toLocaleString("es-CL");
  }
  function fmtUSD(n) {
    var v = Math.max(0, Number(n) || 0);
    return "USD " + v.toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  function getAmountCLP() {
    var raw = (amountInput.value || "").replace(/[^0-9]/g, "");
    var n = parseInt(raw, 10);
    if (!isFinite(n) || n < 0) return 0;
    return n;
  }
  function clpToUSD(clp) {
    var rate = Number(CFG.usdRate) || 850;
    if (rate <= 0) return 0;
    return Math.round((clp / rate) * 100) / 100;
  }
  function getSelectedMethod() {
    var el = document.querySelector('input[name="method"]:checked');
    return el ? el.value : "";
  }
  function showStatus(kind, text, scroll) {
    if (!statusMsg) return;
    statusMsg.className = "status " + kind + " show";
    statusMsg.textContent = text;
    if (scroll) {
      setTimeout(function () {
        try { statusMsg.scrollIntoView({ behavior: "smooth", block: "center" }); } catch (e) {}
      }, 60);
    }
  }
  function clearStatus() {
    if (!statusMsg) return;
    statusMsg.className = "status";
    statusMsg.textContent = "";
  }
  function uniqueOrderId(prefix) {
    var rnd = Math.floor(Math.random() * 1e6).toString(36);
    return (prefix || "DECK") + "-" + Date.now() + "-" + rnd;
  }
  function safe(str, max) {
    return (str || "").toString().slice(0, max || 100);
  }

  // -------------------------------------------------------------------------
  // VALIDATION
  // Un campo muestra su error recien cuando la persona paso por el (blur) o
  // cuando intenta pagar; antes, el primer blur marcaba en rojo todo el form.
  // -------------------------------------------------------------------------
  var touched = {};
  var EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function checks() {
    return {
      name:   (nameInput.value || "").trim().length >= 2,
      email:  EMAIL_RE.test((emailInput.value || "").trim()),
      amount: getAmountCLP() >= 1,
      desc:   (descInput.value || "").trim().length >= 3,
      terms:  !!termsInput.checked
    };
  }
  var FIELD_OF = { name: nameInput, email: emailInput, amount: amountInput, desc: descInput };

  function validateField(el, ok) {
    var block = el.closest(".field-block");
    if (!block) return ok;
    block.classList.toggle("has-error", !ok);
    el.classList.toggle("is-invalid", !ok);
    el.classList.toggle("is-valid", ok);
    el.setAttribute("aria-invalid", ok ? "false" : "true");
    return ok;
  }
  function markField(key) {
    var c = checks();
    if (FIELD_OF[key]) validateField(FIELD_OF[key], c[key]);
  }
  function isFormValid(opts) {
    opts = opts || { mark: false };
    var c = checks();
    if (opts.mark) {
      Object.keys(FIELD_OF).forEach(function (k) { touched[k] = true; validateField(FIELD_OF[k], c[k]); });
      if (termsRow) termsRow.classList.toggle("has-error", !c.terms);
      var first = ["name", "email", "amount", "desc"].filter(function (k) { return !c[k]; })[0];
      if (first) {
        try { FIELD_OF[first].focus({ preventScroll: true }); FIELD_OF[first].scrollIntoView({ behavior: "smooth", block: "center" }); } catch (e) {}
      } else if (!c.terms && termsRow) {
        try { termsRow.scrollIntoView({ behavior: "smooth", block: "center" }); } catch (e) {}
      }
    }
    return c.name && c.email && c.amount && c.desc && c.terms;
  }

  // Monto con separador de miles mientras se escribe (250000 -> 250.000).
  function formatAmountInput() {
    var raw = (amountInput.value || "").replace(/[^0-9]/g, "").replace(/^0+(?=\d)/, "").slice(0, 12);
    var fmt = raw ? Number(raw).toLocaleString("es-CL") : "";
    if (fmt === amountInput.value) return;
    var fromEnd = amountInput.value.length - (amountInput.selectionEnd || 0);
    amountInput.value = fmt;
    var pos = Math.max(0, fmt.length - fromEnd);
    try { amountInput.setSelectionRange(pos, pos); } catch (e) {}
  }

  // -------------------------------------------------------------------------
  // STEPPER + UI STATE
  // -------------------------------------------------------------------------
  var paidDone = false;
  function refreshStepper() {
    var c = checks();
    var step1Done = c.name && c.email && c.amount && c.desc;
    var step2Done = !!getSelectedMethod();

    setStep(steps.s1, step1Done, !step1Done);
    setStep(steps.s2, step2Done, step1Done && !step2Done);
    setStep(steps.s3, paidDone, !paidDone && step1Done && step2Done);
  }
  function setStep(el, isDone, isActive) {
    if (!el) return;
    el.classList.toggle("done", !!isDone);
    el.classList.toggle("active", !!isActive);
  }

  function refreshSummary() {
    var clp = getAmountCLP();
    var name = (nameInput.value || "").trim();
    var desc = (descInput.value || "").trim();

    var hasAny = !!(clp > 0 || name || desc);
    summaryEmpty.hidden = hasAny;
    summaryFilled.hidden = !hasAny;

    sumName.textContent = name || "—";
    sumDesc.textContent = desc || "—";
    sumTotal.textContent = fmtCLP(clp);
    if (mbTotal) mbTotal.textContent = fmtCLP(clp);

    var pedido = (bookingInput.value || "").trim();
    if (sumOrderRow) sumOrderRow.hidden = !pedido;
    if (sumOrder) sumOrder.textContent = pedido;

    var method = getSelectedMethod();
    if (sumMethod) sumMethod.textContent = METHOD_NAME[method] || "Por elegir";
    var showUsd = (method === "paypal" && clp > 0);
    if (sumUsdRow) sumUsdRow.hidden = !showUsd;
    if (sumUsd)    sumUsd.textContent = fmtUSD(clpToUSD(clp));

    if (amountAux) {
      if (clp > 0) {
        amountAux.classList.add("show");
        amountAux.textContent = "Equivale a " + fmtUSD(clpToUSD(clp)) + " (tasa referencial: 1 USD = " + Number(CFG.usdRate).toLocaleString("es-CL") + " CLP)";
      } else {
        amountAux.classList.remove("show");
      }
    }

    refreshStepper();
    refreshPayArea();
    refreshMobileBar();
  }

  var METHOD_NAME = { webpay: "Webpay Plus", mercadopago: "Mercado Pago", paypal: "PayPal (USD)" };

  var MISSING = [
    { key: "name",   label: "Tu nombre",           target: "payerName" },
    { key: "email",  label: "Tu correo",           target: "payerEmail" },
    { key: "amount", label: "El monto",            target: "amount" },
    { key: "desc",   label: "El concepto",         target: "description" },
    { key: "method", label: "Elegir método",       target: "paso-2" },
    { key: "terms",  label: "Aceptar condiciones", target: "termsRow" }
  ];

  function refreshPayArea() {
    var method = getSelectedMethod();
    var c = checks();
    c.method = !!method;
    var missing = MISSING.filter(function (m) { return !c[m.key]; });
    var ready = missing.length === 0;

    if (payArea) payArea.classList.toggle("disabled", !ready);
    if (payAreaEmpty) payAreaEmpty.hidden = ready;
    if (payMissing) {
      var sig = missing.map(function (m) { return m.key; }).join(",");
      if (payMissing.getAttribute("data-sig") !== sig) {
        payMissing.setAttribute("data-sig", sig);
        payMissing.innerHTML = "";
        missing.forEach(function (m) {
          var li = document.createElement("li");
          var a = document.createElement("a");
          a.href = "#" + m.target;
          a.textContent = m.label;
          a.addEventListener("click", function (e) {
            e.preventDefault();
            var el = $(m.target);
            if (!el) return;
            el.scrollIntoView({ behavior: "smooth", block: "center" });
            var f = el.matches("input, textarea") ? el : el.querySelector("input");
            if (f) setTimeout(function () { try { f.focus({ preventScroll: true }); } catch (err) {} }, 350);
          });
          li.appendChild(a);
          payMissing.appendChild(li);
        });
      }
    }
    if (termsRow && c.terms) termsRow.classList.remove("has-error");

    if (payWebpay)    payWebpay.hidden    = method !== "webpay";
    if (payMP)        payMP.hidden        = method !== "mercadopago";
    if (payPayPal)    payPayPal.hidden    = method !== "paypal";

    document.querySelectorAll(".method").forEach(function (card) {
      var input = card.querySelector('input[name="method"]');
      card.classList.toggle("is-active", !!(input && input.checked));
    });
  }

  // Barra fija en celular con el total y "Ir a pagar": aparece cuando hay
  // monto y el paso 3 no esta a la vista.
  var confirmVisible = false;
  function refreshMobileBar() {
    if (!mobileBar) return;
    var show = getAmountCLP() > 0 && !confirmVisible && window.innerWidth <= 980;
    mobileBar.hidden = !show;
    document.body.classList.toggle("has-mobile-bar", show);
  }

  // -------------------------------------------------------------------------
  // URL PREFILL
  // -------------------------------------------------------------------------
  function applyURLPrefill() {
    try {
      var p = new URLSearchParams(window.location.search);
      var amt = p.get("amount");
      var desc = p.get("desc");
      var name = p.get("name");
      var email = p.get("email");
      var phone = p.get("phone");
      var pedido = p.get("pedido");
      if (amt && /^[0-9]+(\.[0-9]+)?$/.test(amt)) amountInput.value = Math.round(Number(amt)).toLocaleString("es-CL");
      if (desc)   descInput.value    = safe(desc, 240);
      if (name)   nameInput.value    = safe(name, 80);
      if (email)  emailInput.value   = safe(email, 120);
      if (phone)  phoneInput.value   = safe(phone, 24);
      if (pedido) bookingInput.value = safe(pedido, 60);
    } catch (e) { /* noop */ }
  }

  // -------------------------------------------------------------------------
  // API CALLS (tourevo.cl/api/*)
  // Tourevo lee `action` desde query string (?action=X), no del body.
  // -------------------------------------------------------------------------
  function apiPost(endpoint, payload) {
    payload = payload || {};
    var action = payload.action || null;
    var body = {};
    for (var k in payload) {
      if (k !== "action" && Object.prototype.hasOwnProperty.call(payload, k)) {
        body[k] = payload[k];
      }
    }
    var url = CFG.apiBase + "/" + endpoint;
    if (action) url += (url.indexOf("?") === -1 ? "?" : "&") + "action=" + encodeURIComponent(action);
    return fetch(url, {
      method: "POST",
      mode: "cors",
      credentials: "omit",
      headers: { "Content-Type": "application/json", "Accept": "application/json" },
      body: JSON.stringify(body)
    }).then(function (res) {
      if (!res.ok) return res.text().then(function (t) { throw new Error("HTTP " + res.status + ": " + t.slice(0, 200)); });
      return res.json();
    });
  }
  function apiGet(endpoint, params) {
    var qs = params ? "?" + new URLSearchParams(params).toString() : "";
    return fetch(CFG.apiBase + "/" + endpoint + qs, {
      method: "GET",
      mode: "cors",
      credentials: "omit",
      headers: { "Accept": "application/json" }
    }).then(function (res) {
      if (!res.ok) return res.text().then(function (t) { throw new Error("HTTP " + res.status + ": " + t.slice(0, 200)); });
      return res.json();
    });
  }

  // -------------------------------------------------------------------------
  // WEBPAY PLUS  (CLP)
  // -------------------------------------------------------------------------
  function payWithWebpay() {
    clearStatus();
    if (!isFormValid({ mark: true })) {
      showStatus("error", "Completa tus datos, el monto y el concepto, y acepta las condiciones antes de pagar.");
      return;
    }
    var clp = getAmountCLP();
    if (clp < 100) { showStatus("error", "El monto mínimo para Webpay es CLP 100."); return; }

    var orderId = uniqueOrderId("DECK");
    var sessionId = "S-" + Date.now();
    btnWebpay.disabled = true;
    btnWebpay.classList.add("is-loading");
    btnWebpay.textContent = "Conectando con Webpay…";

    apiPost("webpay.php", {
      action: "create_transaction",
      amount: clp,
      buy_order: orderId,
      session_id: sessionId,
      return_url: CFG.returnBase + "webpay-return.php",
      user_email: (emailInput.value || "").trim(),
      payer_name: (nameInput.value || "").trim(),
      description: safe(descInput.value, 200)
    }).then(function (data) {
      if (!data || !data.url || !data.token) {
        throw new Error("Respuesta invalida de Webpay (faltan url/token)");
      }
      // Persistir info del pedido para mostrar tras el retorno
      try {
        sessionStorage.setItem("DECKEVA_WP_ORDER", JSON.stringify({
          orderId: orderId, amount: clp, name: nameInput.value, email: emailInput.value, desc: descInput.value
        }));
      } catch (e) {}
      submitWebpayForm(data.url, data.token);
    }).catch(function (err) {
      console.error(err);
      btnWebpay.disabled = false;
      btnWebpay.classList.remove("is-loading");
      btnWebpay.textContent = "Pagar con Webpay";
      showStatus("error", "No pudimos conectar con Webpay. Inténtalo de nuevo en un momento o escríbenos por WhatsApp.");
    });
  }

  function submitWebpayForm(url, token) {
    var f = document.createElement("form");
    f.method = "POST";
    f.action = url;
    var i = document.createElement("input");
    i.type = "hidden";
    i.name = "token_ws";
    i.value = token;
    f.appendChild(i);
    document.body.appendChild(f);
    f.submit();
  }

  function handleWebpayReturn() {
    var p = new URLSearchParams(window.location.search);
    var token = p.get("webpay_token");
    var wpStatus = p.get("webpay_status");
    if (!token && wpStatus) {
      // webpay-return.php manda aqui cuando la persona anula en Transbank
      // (TBK_TOKEN) o vuelve sin token. Antes no se mostraba nada.
      history.replaceState({}, document.title, CFG.returnBase);
      if (wpStatus === "aborted") {
        showStatus("info", "Anulaste el pago en Webpay; no se hizo ningún cargo. Puedes intentarlo de nuevo o elegir otro medio.", true);
      } else {
        showStatus("info", "No recibimos la confirmación de Webpay. Si se hizo un cargo en tu tarjeta, escríbenos por WhatsApp y lo revisamos.", true);
      }
      return true;
    }
    if (!token) return false;

    // Limpiar URL (sacar query) para que un reload no re-commite
    history.replaceState({}, document.title, CFG.returnBase);
    showStatus("info", "Confirmando tu pago con Webpay…", true);

    apiPost("webpay.php", { action: "commit_transaction", token: token })
      .then(function (data) {
        if (data && (data.response_code === 0 || data.status === "AUTHORIZED")) {
          var amt = data.amount || 0;
          var bo  = data.buy_order || data.buyOrder || "";
          showStatus(
            "success",
            "¡Pago aprobado! Orden " + bo + " · " + fmtCLP(amt) + " · Cód. de autorización " +
            (data.authorization_code || data.authorizationCode || "—") + ". Te llegará la confirmación por correo.",
            true
          );
          paidDone = true; refreshStepper();
        } else {
          var code = data && data.response_code;
          showStatus("error", "Webpay no aprobó el pago" + (code !== undefined && code !== null ? " (código " + code + ")" : "") + ". Puedes intentarlo de nuevo o usar otro medio.", true);
        }
      })
      .catch(function (err) {
        console.error(err);
        showStatus("error", "No pudimos confirmar el pago con Webpay. Si se hizo un cargo en tu tarjeta, escríbenos por WhatsApp y lo revisamos.", true);
      });
    return true;
  }

  // -------------------------------------------------------------------------
  // MERCADO PAGO  (CLP, Checkout Pro)
  // -------------------------------------------------------------------------
  function payWithMP() {
    clearStatus();
    if (!isFormValid({ mark: true })) {
      showStatus("error", "Completa tus datos, el monto y el concepto, y acepta las condiciones antes de pagar.");
      return;
    }
    var clp = getAmountCLP();
    if (clp < 100) { showStatus("error", "El monto mínimo para Mercado Pago es CLP 100."); return; }

    var orderId = uniqueOrderId("DECK");
    btnMP.disabled = true;
    btnMP.classList.add("is-loading");
    btnMP.textContent = "Conectando con Mercado Pago…";

    // Tourevo wrapper espera payload PLANO: amount + description + (opcionales).
    var payload = {
      action: "create_preference",
      amount: clp,
      description: safe(descInput.value, 200) || "Pago DECKEVA",
      quantity: 1,
      external_reference: orderId,
      plan_name: "DECKEVA",
      payer_email: safe(emailInput.value, 120),
      payer_name: safe(nameInput.value, 60),
      back_urls: {
        success: CFG.returnBase + "?status=success&order=" + encodeURIComponent(orderId),
        failure: CFG.returnBase + "?status=failure&order=" + encodeURIComponent(orderId),
        pending: CFG.returnBase + "?status=pending&order=" + encodeURIComponent(orderId)
      }
    };

    apiPost("mercadopago.php", payload)
      .then(function (data) {
        var url = data && (data.init_point || data.initPoint || data.sandbox_init_point);
        if (!url) throw new Error("Respuesta invalida de Mercado Pago (sin init_point)");
        try {
          sessionStorage.setItem("DECKEVA_MP_ORDER", JSON.stringify({
            orderId: orderId, amount: clp, name: nameInput.value, email: emailInput.value, desc: descInput.value
          }));
        } catch (e) {}
        window.location.href = url;
      })
      .catch(function (err) {
        console.error(err);
        btnMP.disabled = false;
        btnMP.classList.remove("is-loading");
        btnMP.textContent = "Pagar con Mercado Pago";
        showStatus("error", "No pudimos conectar con Mercado Pago. Inténtalo de nuevo en un momento o escríbenos por WhatsApp.");
      });
  }

  function handleMPReturn() {
    var p = new URLSearchParams(window.location.search);
    var status = p.get("status");
    if (!status) return false;
    var paymentId = p.get("payment_id") || p.get("collection_id") || "";
    var orderId = p.get("order") || p.get("external_reference") || "";

    history.replaceState({}, document.title, CFG.returnBase);

    if (status === "success" || status === "approved") {
      showStatus("success",
        "¡Pago aprobado en Mercado Pago!" + (orderId ? " Orden " + orderId : "") + (paymentId ? " · ID " + paymentId : "") +
        ". Te llegará el comprobante por correo.",
        true
      );
    } else if (status === "pending") {
      showStatus("info",
        "Tu pago en Mercado Pago está pendiente de acreditación." + (orderId ? " Orden " + orderId + "." : "") +
        " Te avisamos por correo cuando se acredite.",
        true
      );
    } else {
      showStatus("error",
        "El pago en Mercado Pago no se completó." + (orderId ? " Orden " + orderId + "." : "") +
        " Puedes intentarlo de nuevo o escribirnos por WhatsApp.",
        true
      );
    }
    return true;
  }

  // -------------------------------------------------------------------------
  // PAYPAL  (USD, Smart Buttons client-only)
  // -------------------------------------------------------------------------
  var paypalLoaded = false;
  var paypalRendered = false;

  function loadPayPalSDK() {
    if (paypalLoaded) return Promise.resolve();
    paypalLoaded = true;
    return new Promise(function (resolve, reject) {
      var src = "https://www.paypal.com/sdk/js"
        + "?client-id=" + encodeURIComponent(CFG.paypalClientId)
        + "&currency=" + encodeURIComponent(CFG.paypalCurrency)
        + "&intent=" + encodeURIComponent(CFG.paypalIntent)
        + "&commit=true"
        + "&enable-funding=card"
        + "&disable-funding=paylater,credit"
        + "&components=buttons"
        + "&locale=" + encodeURIComponent(CFG.paypalLocale);
      var s = document.createElement("script");
      s.src = src;
      s.async = true;
      s.dataset.namespace = "paypal_deckeva";
      s.onload = function () { resolve(); };
      s.onerror = function () { reject(new Error("PayPal SDK no cargo")); };
      document.head.appendChild(s);
    });
  }

  function paypalCreateOrder() {
    var clp = getAmountCLP();
    var usd = clpToUSD(clp);
    var desc = safe(descInput.value, 127) || ("Pago DECKEVA — " + safe(nameInput.value, 60));
    var ref  = safe(bookingInput.value, 60) || uniqueOrderId("DECK");
    var name = (nameInput.value || "").trim();
    var em   = (emailInput.value || "").trim();
    var tel  = (phoneInput.value || "").trim();

    return {
      intent: "CAPTURE",
      purchase_units: [{
        reference_id: ref,
        description: desc,
        custom_id: ref,
        amount: {
          currency_code: "USD",
          value: usd.toFixed(2),
          breakdown: {
            item_total: { currency_code: "USD", value: usd.toFixed(2) }
          }
        },
        items: [{
          name: desc.slice(0, 127),
          quantity: "1",
          unit_amount: { currency_code: "USD", value: usd.toFixed(2) },
          category: "DIGITAL_GOODS"
        }]
      }],
      payer: em ? {
        name: name ? {
          given_name: name.split(" ")[0],
          surname: name.split(" ").slice(1).join(" ") || name.split(" ")[0]
        } : undefined,
        email_address: em,
        phone: tel ? { phone_number: { national_number: tel.replace(/\D+/g, "").slice(-15) } } : undefined
      } : undefined,
      application_context: {
        brand_name: CFG.brandName,
        locale: CFG.paypalLocale,
        user_action: "PAY_NOW",
        shipping_preference: "NO_SHIPPING"
      }
    };
  }

  function renderPayPalButtons() {
    if (paypalRendered) return;
    var paypal = window.paypal_deckeva || window.paypal;
    if (!paypal || !paypal.Buttons) {
      showStatus("error", "PayPal no cargó bien. Recarga la página o escríbenos por WhatsApp.");
      return;
    }

    var commonHandlers = {
      onClick: function (data, actions) {
        clearStatus();
        if (!isFormValid({ mark: true })) {
          showStatus("error", "Completa tus datos, el monto y el concepto, y acepta las condiciones antes de pagar.");
          return actions.reject();
        }
        return actions.resolve();
      },
      createOrder: function (data, actions) {
        return actions.order.create(paypalCreateOrder());
      },
      onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
          var n = (details && details.payer && details.payer.name && details.payer.name.given_name)
               || (nameInput.value || "").trim();
          var id = details && details.id ? details.id : "—";
          showStatus("success",
            "¡Pago confirmado" + (n ? ", " + n : "") + "! " +
            "PayPal te enviará el comprobante por correo. " +
            "ID de transacción: " + id,
            true
          );
          paidDone = true; refreshStepper();
          if (payArea) payArea.classList.add("disabled");
        }).catch(function (err) {
          console.error(err);
          showStatus("error", "No pudimos completar el cobro en PayPal. Si se hizo un cargo en tu tarjeta, escríbenos por WhatsApp con el ID de la orden.", true);
        });
      },
      onCancel: function () {
        showStatus("info", "Cancelaste el pago en PayPal. Puedes intentarlo de nuevo cuando quieras.");
      },
      onError: function (err) {
        console.error(err);
        showStatus("error", "Hubo un error con PayPal. Revisa tus datos o escríbenos por WhatsApp.");
      }
    };

    // Boton 1 — Cuenta PayPal (gold pill)
    try {
      var ppBtn = paypal.Buttons(Object.assign({
        fundingSource: paypal.FUNDING.PAYPAL,
        style: { layout: "vertical", color: "gold", shape: "pill", label: "paypal", height: 48 }
      }, commonHandlers));
      if (ppBtn.isEligible()) ppBtn.render("#paypal-btn-paypal");
    } catch (e) { console.warn("PayPal funding PAYPAL no disponible:", e); }

    // Boton 2 — Tarjeta internacional (black pill)
    try {
      var cardBtn = paypal.Buttons(Object.assign({
        fundingSource: paypal.FUNDING.CARD,
        style: { layout: "vertical", color: "black", shape: "pill", height: 48 }
      }, commonHandlers));
      if (cardBtn.isEligible()) cardBtn.render("#paypal-btn-card");
    } catch (e) { console.warn("PayPal funding CARD no disponible:", e); }

    paypalRendered = true;
  }

  function ensurePayPalReady() {
    if (paypalRendered) return;
    loadPayPalSDK().then(renderPayPalButtons).catch(function (err) {
      console.error(err);
      showStatus("error", "No pudimos cargar PayPal. Revisa tu conexión o escríbenos por WhatsApp.");
    });
  }

  // -------------------------------------------------------------------------
  // WIRING
  // -------------------------------------------------------------------------
  function keyOf(el) {
    for (var k in FIELD_OF) if (FIELD_OF[k] === el) return k;
    return "";
  }

  function onMethodChange() {
    refreshSummary();
    var method = getSelectedMethod();
    if (method === "paypal") ensurePayPalReady();
  }

  function init() {
    if (!nameInput) return; // safety

    applyURLPrefill();
    // Lo que vino en el link (monto de la cotizacion, etc.) ya se valida.
    Object.keys(FIELD_OF).forEach(function (k) {
      if ((FIELD_OF[k].value || "").trim()) { touched[k] = true; markField(k); }
    });

    amountInput.addEventListener("input", formatAmountInput);
    [nameInput, emailInput, phoneInput, bookingInput, amountInput, descInput].forEach(function (el) {
      el.addEventListener("input", function () {
        var key = keyOf(el);
        if (key && touched[key]) markField(key);
        refreshSummary();
      });
      el.addEventListener("blur", function () {
        var key = keyOf(el);
        if (!key) return;
        // Un campo vacio que nunca se lleno no se marca solo por pasar por el.
        if (!touched[key] && !(el.value || "").trim()) return;
        touched[key] = true;
        markField(key);
      });
    });
    termsInput.addEventListener("change", refreshSummary);

    if (confirmCard && "IntersectionObserver" in window) {
      new IntersectionObserver(function (entries) {
        confirmVisible = entries[0].isIntersecting;
        refreshMobileBar();
      }, { threshold: 0.15 }).observe(confirmCard);
    }
    window.addEventListener("resize", refreshMobileBar);

    document.querySelectorAll('input[name="method"]').forEach(function (el) {
      el.addEventListener("change", onMethodChange);
    });

    if (btnWebpay) btnWebpay.addEventListener("click", function (e) { e.preventDefault(); payWithWebpay(); });
    if (btnMP)     btnMP.addEventListener("click",     function (e) { e.preventDefault(); payWithMP(); });

    // Year in footer (if present)
    var yr = $("year");
    if (yr) yr.textContent = String(new Date().getFullYear());

    // Handle returns
    if (!handleWebpayReturn()) handleMPReturn();

    refreshSummary();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
