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
  function showStatus(kind, text) {
    if (!statusMsg) return;
    statusMsg.className = "status " + kind + " show";
    statusMsg.textContent = text;
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
  // -------------------------------------------------------------------------
  function validateField(el, ok) {
    var block = el.closest(".field-block");
    if (!block) return ok;
    if (ok) {
      block.classList.remove("has-error");
      el.classList.remove("is-invalid");
    } else {
      block.classList.add("has-error");
      el.classList.add("is-invalid");
    }
    return ok;
  }
  function isFormValid(opts) {
    opts = opts || { mark: false };
    var nameOk   = (nameInput.value || "").trim().length >= 2;
    var emailOk  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((emailInput.value || "").trim());
    var amountOk = getAmountCLP() >= 1;
    var descOk   = (descInput.value || "").trim().length >= 3;
    var termsOk  = !!termsInput.checked;

    if (opts.mark) {
      validateField(nameInput,  nameOk);
      validateField(emailInput, emailOk);
      validateField(amountInput, amountOk);
      validateField(descInput,  descOk);
    }
    return nameOk && emailOk && amountOk && descOk && termsOk;
  }

  // -------------------------------------------------------------------------
  // STEPPER + UI STATE
  // -------------------------------------------------------------------------
  function refreshStepper() {
    var step1Done = (nameInput.value || "").trim().length >= 2
                 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((emailInput.value || "").trim())
                 && getAmountCLP() >= 1
                 && (descInput.value || "").trim().length >= 3;
    var step2Done = !!getSelectedMethod();

    setStep(steps.s1, step1Done, !step1Done);
    setStep(steps.s2, step2Done, step1Done && !step2Done);
    setStep(steps.s3, false, step1Done && step2Done);
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

    var method = getSelectedMethod();
    var showUsd = (method === "paypal" && clp > 0);
    if (sumUsdRow) sumUsdRow.hidden = !showUsd;
    if (sumUsd)    sumUsd.textContent = fmtUSD(clpToUSD(clp));

    if (amountAux) {
      if (clp > 0) {
        amountAux.classList.add("show");
        amountAux.textContent = "≈ " + fmtUSD(clpToUSD(clp)) + "  (tasa referencial 1 USD = " + Number(CFG.usdRate).toLocaleString("es-CL") + " CLP)";
      } else {
        amountAux.classList.remove("show");
      }
    }

    refreshStepper();
    refreshPayArea();
  }

  function refreshPayArea() {
    var method = getSelectedMethod();
    var ok = isFormValid();

    if (payArea) payArea.classList.toggle("disabled", !ok || !method);

    if (payAreaEmpty) payAreaEmpty.hidden = !!method;
    if (payWebpay)    payWebpay.hidden    = method !== "webpay";
    if (payMP)        payMP.hidden        = method !== "mercadopago";
    if (payPayPal)    payPayPal.hidden    = method !== "paypal";

    document.querySelectorAll(".method").forEach(function (card) {
      var input = card.querySelector('input[name="method"]');
      card.classList.toggle("is-active", input && input.checked);
    });
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
      if (amt && /^[0-9]+(\.[0-9]+)?$/.test(amt)) amountInput.value = String(Math.round(Number(amt)));
      if (desc)   descInput.value    = safe(desc, 240);
      if (name)   nameInput.value    = safe(name, 80);
      if (email)  emailInput.value   = safe(email, 120);
      if (phone)  phoneInput.value   = safe(phone, 24);
      if (pedido) bookingInput.value = safe(pedido, 60);
    } catch (e) { /* noop */ }
  }

  // -------------------------------------------------------------------------
  // API CALLS (tourevo.cl/api/*)
  // -------------------------------------------------------------------------
  function apiPost(endpoint, payload) {
    return fetch(CFG.apiBase + "/" + endpoint, {
      method: "POST",
      mode: "cors",
      credentials: "omit",
      headers: { "Content-Type": "application/json", "Accept": "application/json" },
      body: JSON.stringify(payload || {})
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
      showStatus("error", "Complete sus datos, monto, descripcion y acepte los terminos antes de pagar.");
      return;
    }
    var clp = getAmountCLP();
    if (clp < 100) { showStatus("error", "Monto minimo Webpay: CLP 100."); return; }

    var orderId = uniqueOrderId("DECK");
    var sessionId = "S-" + Date.now();
    btnWebpay.disabled = true;
    btnWebpay.classList.add("is-loading");
    btnWebpay.textContent = "Conectando con Webpay…";

    apiPost("webpay.php", {
      action: "create_transaction",
      amount: clp,
      order_id: orderId,
      session_id: sessionId,
      return_url: CFG.returnBase + "webpay-return.php"
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
      showStatus("error", "No fue posible iniciar el pago Webpay. Reintente o coordine por WhatsApp.");
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
    if (!token) return false;

    // Limpiar URL (sacar query) para que un reload no re-commite
    history.replaceState({}, document.title, CFG.returnBase);
    showStatus("info", "Confirmando pago Webpay…");

    apiPost("webpay.php", { action: "commit_transaction", token: token })
      .then(function (data) {
        if (data && (data.response_code === 0 || data.status === "AUTHORIZED")) {
          var amt = data.amount || 0;
          var bo  = data.buy_order || data.buyOrder || "";
          showStatus(
            "success",
            "Pago aprobado. Orden " + bo + " · " + fmtCLP(amt) + " · Cod. autorizacion " +
            (data.authorization_code || data.authorizationCode || "—") + ". Recibira confirmacion por correo."
          );
        } else {
          showStatus("error", "Pago Webpay rechazado o cancelado. Codigo: " + (data && data.response_code) + ".");
        }
      })
      .catch(function (err) {
        console.error(err);
        showStatus("error", "No fue posible confirmar el pago Webpay. Si su tarjeta fue cobrada, contactenos por WhatsApp.");
      });
    return true;
  }

  // -------------------------------------------------------------------------
  // MERCADO PAGO  (CLP, Checkout Pro)
  // -------------------------------------------------------------------------
  function payWithMP() {
    clearStatus();
    if (!isFormValid({ mark: true })) {
      showStatus("error", "Complete sus datos, monto, descripcion y acepte los terminos antes de pagar.");
      return;
    }
    var clp = getAmountCLP();
    if (clp < 100) { showStatus("error", "Monto minimo Mercado Pago: CLP 100."); return; }

    var orderId = uniqueOrderId("DECK");
    btnMP.disabled = true;
    btnMP.classList.add("is-loading");
    btnMP.textContent = "Conectando con Mercado Pago…";

    var payload = {
      action: "create_preference",
      external_reference: orderId,
      items: [{
        title: safe(descInput.value, 256) || "Pago DECKEVA",
        quantity: 1,
        unit_price: clp,
        currency_id: "CLP"
      }],
      payer: {
        name: safe(nameInput.value, 60),
        email: safe(emailInput.value, 120),
        phone: { number: safe(phoneInput.value.replace(/[^\d]/g, ""), 16) }
      },
      back_urls: {
        success: CFG.returnBase + "?status=success&order=" + encodeURIComponent(orderId),
        failure: CFG.returnBase + "?status=failure&order=" + encodeURIComponent(orderId),
        pending: CFG.returnBase + "?status=pending&order=" + encodeURIComponent(orderId)
      },
      auto_return: "approved",
      statement_descriptor: "DECKEVA",
      metadata: { brand: "DECKEVA", order_id: orderId }
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
        showStatus("error", "No fue posible iniciar el pago Mercado Pago. Reintente o coordine por WhatsApp.");
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
        "Pago Mercado Pago aprobado." + (orderId ? " Orden " + orderId : "") + (paymentId ? " · ID " + paymentId : "") +
        ". Recibira el comprobante por correo."
      );
    } else if (status === "pending") {
      showStatus("info",
        "Pago Mercado Pago pendiente de acreditacion." + (orderId ? " Orden " + orderId : "") +
        " Le confirmaremos por correo cuando se acredite."
      );
    } else {
      showStatus("error",
        "Pago Mercado Pago no completado." + (orderId ? " Orden " + orderId : "") +
        " Puede reintentar o coordinar por WhatsApp."
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
      showStatus("error", "PayPal no se cargo correctamente. Recargue la pagina o use WhatsApp.");
      return;
    }

    var commonHandlers = {
      onClick: function (data, actions) {
        clearStatus();
        if (!isFormValid({ mark: true })) {
          showStatus("error", "Complete sus datos, monto, descripcion y acepte los terminos antes de pagar.");
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
            "Pago PayPal confirmado, " + (n || "gracias") + ". " +
            "Recibira el comprobante de PayPal por correo. " +
            "ID de transaccion: " + id
          );
          if (payArea) payArea.classList.add("disabled");
        }).catch(function (err) {
          console.error(err);
          showStatus("error", "No fue posible capturar el pago. Si su tarjeta fue cobrada, contactenos por WhatsApp con el ID de orden.");
        });
      },
      onCancel: function () {
        showStatus("info", "Pago PayPal cancelado. Puede intentarlo nuevamente.");
      },
      onError: function (err) {
        console.error(err);
        showStatus("error", "Ocurrio un error con PayPal. Revise sus datos o use WhatsApp.");
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
      showStatus("error", "No fue posible cargar PayPal. Revise su conexion o use WhatsApp.");
    });
  }

  // -------------------------------------------------------------------------
  // WIRING
  // -------------------------------------------------------------------------
  function onMethodChange() {
    refreshSummary();
    var method = getSelectedMethod();
    if (method === "paypal") ensurePayPalReady();
  }

  function init() {
    if (!nameInput) return; // safety

    applyURLPrefill();

    [nameInput, emailInput, phoneInput, bookingInput, amountInput, descInput].forEach(function (el) {
      el.addEventListener("input", refreshSummary);
      el.addEventListener("blur", function () { isFormValid({ mark: true }); });
    });
    termsInput.addEventListener("change", refreshSummary);

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
