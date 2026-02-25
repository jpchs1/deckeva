
/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
/*if(typeof jQuery.easing["jswing"] === typeof undefined){*/
	jQuery.easing["jswing"]=jQuery.easing["swing"];jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,t,n,r,i){return jQuery.easing[jQuery.easing.def](e,t,n,r,i)},easeInQuad:function(e,t,n,r,i){return r*(t/=i)*t+n},easeOutQuad:function(e,t,n,r,i){return-r*(t/=i)*(t-2)+n},easeInOutQuad:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t+n;return-r/2*(--t*(t-2)-1)+n},easeInCubic:function(e,t,n,r,i){return r*(t/=i)*t*t+n},easeOutCubic:function(e,t,n,r,i){return r*((t=t/i-1)*t*t+1)+n},easeInOutCubic:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t+n;return r/2*((t-=2)*t*t+2)+n},easeInQuart:function(e,t,n,r,i){return r*(t/=i)*t*t*t+n},easeOutQuart:function(e,t,n,r,i){return-r*((t=t/i-1)*t*t*t-1)+n},easeInOutQuart:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t+n;return-r/2*((t-=2)*t*t*t-2)+n},easeInQuint:function(e,t,n,r,i){return r*(t/=i)*t*t*t*t+n},easeOutQuint:function(e,t,n,r,i){return r*((t=t/i-1)*t*t*t*t+1)+n},easeInOutQuint:function(e,t,n,r,i){if((t/=i/2)<1)return r/2*t*t*t*t*t+n;return r/2*((t-=2)*t*t*t*t+2)+n},easeInSine:function(e,t,n,r,i){return-r*Math.cos(t/i*(Math.PI/2))+r+n},easeOutSine:function(e,t,n,r,i){return r*Math.sin(t/i*(Math.PI/2))+n},easeInOutSine:function(e,t,n,r,i){return-r/2*(Math.cos(Math.PI*t/i)-1)+n},easeInExpo:function(e,t,n,r,i){return t==0?n:r*Math.pow(2,10*(t/i-1))+n},easeOutExpo:function(e,t,n,r,i){return t==i?n+r:r*(-Math.pow(2,-10*t/i)+1)+n},easeInOutExpo:function(e,t,n,r,i){if(t==0)return n;if(t==i)return n+r;if((t/=i/2)<1)return r/2*Math.pow(2,10*(t-1))+n;return r/2*(-Math.pow(2,-10*--t)+2)+n},easeInCirc:function(e,t,n,r,i){return-r*(Math.sqrt(1-(t/=i)*t)-1)+n},easeOutCirc:function(e,t,n,r,i){return r*Math.sqrt(1-(t=t/i-1)*t)+n},easeInOutCirc:function(e,t,n,r,i){if((t/=i/2)<1)return-r/2*(Math.sqrt(1-t*t)-1)+n;return r/2*(Math.sqrt(1-(t-=2)*t)+1)+n},easeInElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return-(u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o))+n},easeOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i)==1)return n+r;if(!o)o=i*.3;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);return u*Math.pow(2,-10*t)*Math.sin((t*i-s)*2*Math.PI/o)+r+n},easeInOutElastic:function(e,t,n,r,i){var s=1.70158;var o=0;var u=r;if(t==0)return n;if((t/=i/2)==2)return n+r;if(!o)o=i*.3*1.5;if(u<Math.abs(r)){u=r;var s=o/4}else var s=o/(2*Math.PI)*Math.asin(r/u);if(t<1)return-.5*u*Math.pow(2,10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)+n;return u*Math.pow(2,-10*(t-=1))*Math.sin((t*i-s)*2*Math.PI/o)*.5+r+n},easeInBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*(t/=i)*t*((s+1)*t-s)+n},easeOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;return r*((t=t/i-1)*t*((s+1)*t+s)+1)+n},easeInOutBack:function(e,t,n,r,i,s){if(s==undefined)s=1.70158;if((t/=i/2)<1)return r/2*t*t*(((s*=1.525)+1)*t-s)+n;return r/2*((t-=2)*t*(((s*=1.525)+1)*t+s)+2)+n},easeInBounce:function(e,t,n,r,i){return r-jQuery.easing.easeOutBounce(e,i-t,0,r,i)+n},easeOutBounce:function(e,t,n,r,i){if((t/=i)<1/2.75){return r*7.5625*t*t+n}else if(t<2/2.75){return r*(7.5625*(t-=1.5/2.75)*t+.75)+n}else if(t<2.5/2.75){return r*(7.5625*(t-=2.25/2.75)*t+.9375)+n}else{return r*(7.5625*(t-=2.625/2.75)*t+.984375)+n}},easeInOutBounce:function(e,t,n,r,i){if(t<i/2)return jQuery.easing.easeInBounce(e,t*2,0,r,i)*.5+n;return jQuery.easing.easeOutBounce(e,t*2-i,0,r,i)*.5+r*.5+n}});/*}*/
/* Lazy loading: begin */

// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating
// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel
// MIT license

(function() {
  var lastTime = 0;
  var vendors = ['ms', 'moz', 'webkit', 'o'];
  for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
    window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
    window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
  }
 
  if (!window.requestAnimationFrame)
    window.requestAnimationFrame = function(callback, element) {
      var currTime = new Date().getTime();
      var timeToCall = Math.max(0, 16 - (currTime - lastTime));
      var id = window.setTimeout(function() { callback(currTime + timeToCall); }, 
        timeToCall);
      lastTime = currTime + timeToCall;
      return id;
    };
 
  if (!window.cancelAnimationFrame)
    window.cancelAnimationFrame = function(id) {
      clearTimeout(id);
    };
}());
  
// https://github.com/callmecavs/layzr.js
// CONSTRUCTOR
function Layzr(options) {
  // debounce
  this._lastScroll = 0;
  this._ticking    = false;

  // options
  options = options || {};

  this._optionsContainer  = document.querySelector(options.container) || window;
  this._optionsSelector = options.selector || '[data-layzr]';
  this._optionsAttr   = options.attr || 'data-layzr';
  this._optionsAttrSrcSet = options.attrSrcSet || 'data-layzr-srcset';
  this._optionsAttrRetina = options.retinaAttr || 'data-layzr-retina';
  this._optionsAttrBg   = options.bgAttr || 'data-layzr-bg';
  this._optionsAttrHidden = options.hiddenAttr || 'data-layzr-hidden';
  this._optionsThreshold  = options.threshold || 0;
  this._optionsBefore   = options.before || null;
  this._optionsAfter    = options.after || null;  
  this._optionsCallback = options.callback || null;

  // properties
  this._retina  = window.devicePixelRatio > 1;
  this._srcAttr = this._retina ? this._optionsAttrRetina : this._optionsAttr;

  // nodelist
  this._nodes = document.querySelectorAll(this._optionsSelector);

  // scroll and resize handler
  this._handlerBind = this._requestScroll.bind(this);

  // call to create
  this._create();
  
}

// DEBOUNCE HELPERS
// adapted from: http://www.html5rocks.com/en/tutorials/speed/animations/

Layzr.prototype._requestScroll = function() {
  if(this._optionsContainer === window) {
    this._lastScroll = window.pageYOffset;
  }
  else {
    this._lastScroll = this._optionsContainer.scrollTop + this._getOffset(this._optionsContainer);
  }

  this._requestTick();
  
};

Layzr.prototype._requestTick = function() {
  if(!this._ticking) {
    requestAnimationFrame(this.update.bind(this));
    this._ticking = true;
  }
};

// OFFSET HELPER
// remember, getBoundingClientRect is relative to the viewport

Layzr.prototype._getOffset = function(node) {
  if(node.hasAttribute("data-src")) {
    var extAttr = node.getAttribute("data-src");
    var ext = extAttr.substring(extAttr.lastIndexOf(".")+1);
  }
  if(ext == "png"){
      node.parentNode.classList.add("layzr-bg-transparent");
  };
  return node.getBoundingClientRect().top + window.pageYOffset;
};

// HEIGHT HELPER

Layzr.prototype._getContainerHeight = function() {
  return this._optionsContainer.innerHeight
      || this._optionsContainer.offsetHeight;

}

// LAYZR METHODS

Layzr.prototype._create = function() {
  // fire scroll event once
  this._handlerBind();

  // bind scroll and resize event
  this._optionsContainer.addEventListener('scroll', this._handlerBind, false);
  this._optionsContainer.addEventListener('resize', this._handlerBind, false);
};

Layzr.prototype._destroy = function() {
  // unbind scroll and resize event
  this._optionsContainer.removeEventListener('scroll', this._handlerBind, false);
  this._optionsContainer.removeEventListener('resize', this._handlerBind, false);
};

Layzr.prototype._inViewport = function(node) {
  // get viewport top and bottom offset
  var viewportTop = this._lastScroll;
  var viewportBottom = viewportTop + this._getContainerHeight();

  // get node top and bottom offset
  var nodeTop = this._getOffset(node);
  var nodeBottom = nodeTop + this._getContainerHeight();

  // calculate threshold, convert percentage to pixel value
  var threshold = (this._optionsThreshold / 100) * window.innerHeight;

  // return if node in viewport
  return nodeBottom >= viewportTop - threshold
      && nodeTop <= viewportBottom + threshold
      && !node.hasAttribute(this._optionsAttrHidden);
};

Layzr.prototype._reveal = function(node) {
  // get node source
  var source = node.getAttribute(this._srcAttr) || node.getAttribute(this._optionsAttr),
    lazyrObj = this;

  // call the callback
  if(typeof this._optionsCallback === 'function') {
    var runCallback;
    // "this" will be the node in the callback
    if(node.addEventListener) { 
      
      node.addEventListener("load",function() {
         lazyrObj._optionsCallback.call(node);
      }); 
    }else { node.attachEvent("onload", function() {
       lazyrObj._optionsCallback.call(node);
    }); }
   
  }

  // before hook
  if(typeof this._optionsBefore === 'function') {
    // "this" will be the node in the callback
    this._optionsBefore.call(node);
  }

  // set node src or bg image
  if(node.hasAttribute(this._optionsAttrBg)) {
    node.style.backgroundImage = 'url(' + source + ')';

  }
  else {

    
    if (source) node.setAttribute('src', source);
    if (node.hasAttribute(this._optionsAttrSrcSet)) node.setAttribute('srcset', node.getAttribute(this._optionsAttrSrcSet));
 
  }

  // after hook
  if(typeof this._optionsAfter === 'function') {
    // "this" will be the node in the callback
    this._optionsAfter.call(node);

  }

  // remove node data attributes
  node.removeAttribute(this._optionsAttr);
  node.removeAttribute(this._optionsAttrSrcSet);
  node.removeAttribute(this._optionsAttrRetina);
  node.removeAttribute(this._optionsAttrBg);
  node.removeAttribute(this._optionsAttrHidden);
};

Layzr.prototype.updateSelector = function() {
  // update cached list of nodes matching selector
  this._nodes = document.querySelectorAll(this._optionsSelector);
};

Layzr.prototype.update = function() {
  // cache nodelist length
  var nodesLength = this._nodes.length;

  // loop through nodes
  for(var i = 0; i < nodesLength; i++) {
    // cache node
    var node = this._nodes[i];

    // check if node has mandatory attribute
    if(node.hasAttribute(this._optionsAttr) || node.hasAttribute(this._optionsAttrSrcSet) || node.hasAttribute(this._optionsAttrRetina)) {
      // check if node in viewport
      if(this._inViewport(node)) {
        // reveal node
        this._reveal(node);
      }
    }
  }

  // allow for more animation frames
  this._ticking = false;
};

/* Lazy loading: end */

/*! PhotoSwipe - v4.1.2 - 2017-04-05
 * http://photoswipe.com
 * Copyright (c) 2017 Dmitry Semenov; */
! function(a, b) { "function" == typeof define && define.amd ? define(b) : "object" == typeof exports ? module.exports = b() : a.PhotoSwipe = b() }(this, function() { "use strict"; var a = function(a, b, c, d) { var e = { features: null, bind: function(a, b, c, d) { var e = (d ? "remove" : "add") + "EventListener";
                b = b.split(" "); for (var f = 0; f < b.length; f++) b[f] && a[e](b[f], c, !1) }, isArray: function(a) { return a instanceof Array }, createEl: function(a, b) { var c = document.createElement(b || "div"); return a && (c.className = a), c }, getScrollY: function() { var a = window.pageYOffset; return void 0 !== a ? a : document.documentElement.scrollTop }, unbind: function(a, b, c) { e.bind(a, b, c, !0) }, removeClass: function(a, b) { var c = new RegExp("(\\s|^)" + b + "(\\s|$)");
                a.className = a.className.replace(c, " ").replace(/^\s\s*/, "").replace(/\s\s*$/, "") }, addClass: function(a, b) { e.hasClass(a, b) || (a.className += (a.className ? " " : "") + b) }, hasClass: function(a, b) { return a.className && new RegExp("(^|\\s)" + b + "(\\s|$)").test(a.className) }, getChildByClass: function(a, b) { for (var c = a.firstChild; c;) { if (e.hasClass(c, b)) return c;
                    c = c.nextSibling } }, arraySearch: function(a, b, c) { for (var d = a.length; d--;)
                    if (a[d][c] === b) return d; return -1 }, extend: function(a, b, c) { for (var d in b)
                    if (b.hasOwnProperty(d)) { if (c && a.hasOwnProperty(d)) continue;
                        a[d] = b[d] } }, easing: { sine: { out: function(a) { return Math.sin(a * (Math.PI / 2)) }, inOut: function(a) { return -(Math.cos(Math.PI * a) - 1) / 2 } }, cubic: { out: function(a) { return --a * a * a + 1 } } }, detectFeatures: function() { if (e.features) return e.features; var a = e.createEl(),
                    b = a.style,
                    c = "",
                    d = {}; if (d.oldIE = document.all && !document.addEventListener, d.touch="ontouchstart"in document.documentElement||navigator.maxTouchPoints>0, window.requestAnimationFrame && (d.raf = window.requestAnimationFrame, d.caf = window.cancelAnimationFrame), d.pointerEvent = navigator.pointerEnabled || navigator.msPointerEnabled, !d.pointerEvent) { var f = navigator.userAgent; if (/iP(hone|od)/.test(navigator.platform)) { var g = navigator.appVersion.match(/OS (\d+)_(\d+)_?(\d+)?/);
                        g && g.length > 0 && (g = parseInt(g[1], 10), g >= 1 && g < 8 && (d.isOldIOSPhone = !0)) } var h = f.match(/Android\s([0-9\.]*)/),
                        i = h ? h[1] : 0;
                    i = parseFloat(i), i >= 1 && (i < 4.4 && (d.isOldAndroid = !0), d.androidVersion = i), d.isMobileOpera = /opera mini|opera mobi/i.test(f) } for (var j, k, l = ["transform", "perspective", "animationName"], m = ["", "webkit", "Moz", "ms", "O"], n = 0; n < 4; n++) { c = m[n]; for (var o = 0; o < 3; o++) j = l[o], k = c + (c ? j.charAt(0).toUpperCase() + j.slice(1) : j), !d[j] && k in b && (d[j] = k);
                    c && !d.raf && (c = c.toLowerCase(), d.raf = window[c + "RequestAnimationFrame"], d.raf && (d.caf = window[c + "CancelAnimationFrame"] || window[c + "CancelRequestAnimationFrame"])) } if (!d.raf) { var p = 0;
                    d.raf = function(a) { var b = (new Date).getTime(),
                            c = Math.max(0, 16 - (b - p)),
                            d = window.setTimeout(function() { a(b + c) }, c); return p = b + c, d }, d.caf = function(a) { clearTimeout(a) } } return d.svg = !!document.createElementNS && !!document.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect, e.features = d, d } };
        e.detectFeatures(), e.features.oldIE && (e.bind = function(a, b, c, d) { b = b.split(" "); for (var e, f = (d ? "detach" : "attach") + "Event", g = function() { c.handleEvent.call(c) }, h = 0; h < b.length; h++)
                if (e = b[h])
                    if ("object" == typeof c && c.handleEvent) { if (d) { if (!c["oldIE" + e]) return !1 } else c["oldIE" + e] = g;
                        a[f]("on" + e, c["oldIE" + e]) } else a[f]("on" + e, c) }); var f = this,
            g = 25,
            h = 3,
            i = { allowPanToNext: !0, spacing: .12, bgOpacity: 1, mouseUsed: !1, loop: !0, pinchToClose: !0, closeOnScroll: !0, closeOnVerticalDrag: !0, verticalDragRange: .75, hideAnimationDuration: 333, showAnimationDuration: 333, showHideOpacity: !1, focus: !0, escKey: !0, arrowKeys: !0, mainScrollEndFriction: .35, panEndFriction: .35, isClickableElement: function(a) { return "A" === a.tagName }, getDoubleTapZoom: function(a, b) { return a ? 1 : b.initialZoomLevel < .7 ? 1 : 1.33 }, maxSpreadZoom: 1.33, modal: !0, scaleMode: "fit" };
        e.extend(i, d); var j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, $, _, aa, ba, ca, da, ea, fa, ga, ha, ia, ja, ka, la, ma = function() { return { x: 0, y: 0 } },
            na = ma(),
            oa = ma(),
            pa = ma(),
            qa = {},
            ra = 0,
            sa = {},
            ta = ma(),
            ua = 0,
            va = !0,
            wa = [],
            xa = {},
            ya = !1,
            za = function(a, b) { e.extend(f, b.publicMethods), wa.push(a) },
            Aa = function(a) { var b = ac(); return a > b - 1 ? a - b : a < 0 ? b + a : a },
            Ba = {},
            Ca = function(a, b) { return Ba[a] || (Ba[a] = []), Ba[a].push(b) },
            Da = function(a) { var b = Ba[a]; if (b) { var c = Array.prototype.slice.call(arguments);
                    c.shift(); for (var d = 0; d < b.length; d++) b[d].apply(f, c) } },
            Ea = function() { return (new Date).getTime() },
            Fa = function(a) { ja = a, f.bg.style.opacity = a * i.bgOpacity },
            Ga = function(a, b, c, d, e) {
                (!ya || e && e !== f.currItem) && (d /= e ? e.fitRatio : f.currItem.fitRatio), a[E] = u + b + "px, " + c + "px" + v + " scale(" + d + ")" },
            Ha = function(a) { ea && (a && (s > f.currItem.fitRatio ? ya || (mc(f.currItem, !1, !0), ya = !0) : ya && (mc(f.currItem), ya = !1)), Ga(ea, pa.x, pa.y, s)) },
            Ia = function(a) { a.container && Ga(a.container.style, a.initialPosition.x, a.initialPosition.y, a.initialZoomLevel, a) },
            Ja = function(a, b) { b[E] = u + a + "px, 0px" + v },
            Ka = function(a, b) { if (!i.loop && b) { var c = m + (ta.x * ra - a) / ta.x,
                        d = Math.round(a - tb.x);
                    (c < 0 && d > 0 || c >= ac() - 1 && d < 0) && (a = tb.x + d * i.mainScrollEndFriction) } tb.x = a, Ja(a, n) },
            La = function(a, b) { var c = ub[a] - sa[a]; return oa[a] + na[a] + c - c * (b / t) },
            Ma = function(a, b) { a.x = b.x, a.y = b.y, b.id && (a.id = b.id) },
            Na = function(a) { a.x = Math.round(a.x), a.y = Math.round(a.y) },
            Oa = null,
            Pa = function() { Oa && (e.unbind(document, "mousemove", Pa), e.addClass(a, "pswp--has_mouse"), i.mouseUsed = !0, Da("mouseUsed")), Oa = setTimeout(function() { Oa = null }, 100) },
            Qa = function() { e.bind(document, "keydown", f), N.transform && e.bind(f.scrollWrap, "click", f), i.mouseUsed || e.bind(document, "mousemove", Pa), e.bind(window, "resize scroll orientationchange", f), Da("bindEvents") },
            Ra = function() { e.unbind(window, "resize scroll orientationchange", f), e.unbind(window, "scroll", r.scroll), e.unbind(document, "keydown", f), e.unbind(document, "mousemove", Pa), N.transform && e.unbind(f.scrollWrap, "click", f), V && e.unbind(window, p, f), clearTimeout(O), Da("unbindEvents") },
            Sa = function(a, b) { var c = ic(f.currItem, qa, a); return b && (da = c), c },
            Ta = function(a) { return a || (a = f.currItem), a.initialZoomLevel },
            Ua = function(a) { return a || (a = f.currItem), a.w > 0 ? i.maxSpreadZoom : 1 },
            Va = function(a, b, c, d) { return d === f.currItem.initialZoomLevel ? (c[a] = f.currItem.initialPosition[a], !0) : (c[a] = La(a, d), c[a] > b.min[a] ? (c[a] = b.min[a], !0) : c[a] < b.max[a] && (c[a] = b.max[a], !0)) },
            Wa = function() { if (E) { var b = N.perspective && !G; return u = "translate" + (b ? "3d(" : "("), void(v = N.perspective ? ", 0px)" : ")") } E = "left", e.addClass(a, "pswp--ie"), Ja = function(a, b) { b.left = a + "px" }, Ia = function(a) { var b = a.fitRatio > 1 ? 1 : a.fitRatio,
                        c = a.container.style,
                        d = b * a.w,
                        e = b * a.h;
                    c.width = d + "px", c.height = e + "px", c.left = a.initialPosition.x + "px", c.top = a.initialPosition.y + "px" }, Ha = function() { if (ea) { var a = ea,
                            b = f.currItem,
                            c = b.fitRatio > 1 ? 1 : b.fitRatio,
                            d = c * b.w,
                            e = c * b.h;
                        a.width = d + "px", a.height = e + "px", a.left = pa.x + "px", a.top = pa.y + "px" } } },
            Xa = function(a) { var b = "";
                i.escKey && 27 === a.keyCode ? b = "close" : i.arrowKeys && (37 === a.keyCode ? b = "prev" : 39 === a.keyCode && (b = "next")), b && (a.ctrlKey || a.altKey || a.shiftKey || a.metaKey || (a.preventDefault ? a.preventDefault() : a.returnValue = !1, f[b]())) },
            Ya = function(a) { a && (Y || X || fa || T) && (a.preventDefault(), a.stopPropagation()) },
            Za = function() { f.setScrollOffset(0, e.getScrollY()) },
            $a = {},
            _a = 0,
            ab = function(a) { $a[a] && ($a[a].raf && I($a[a].raf), _a--, delete $a[a]) },
            bb = function(a) { $a[a] && ab(a), $a[a] || (_a++, $a[a] = {}) },
            cb = function() { for (var a in $a) $a.hasOwnProperty(a) && ab(a) },
            db = function(a, b, c, d, e, f, g) { var h, i = Ea();
                bb(a); var j = function() { if ($a[a]) { if (h = Ea() - i, h >= d) return ab(a), f(c), void(g && g());
                        f((c - b) * e(h / d) + b), $a[a].raf = H(j) } };
                j() },
            eb = { shout: Da, listen: Ca, viewportSize: qa, options: i, isMainScrollAnimating: function() { return fa }, getZoomLevel: function() { return s }, getCurrentIndex: function() { return m }, isDragging: function() { return V }, isZooming: function() { return aa }, setScrollOffset: function(a, b) { sa.x = a, M = sa.y = b, Da("updateScrollOffset", sa) }, applyZoomPan: function(a, b, c, d) { pa.x = b, pa.y = c, s = a, Ha(d) }, init: function() { if (!j && !k) { var c;
                        f.framework = e, f.template = a, f.bg = e.getChildByClass(a, "pswp__bg"), J = a.className, j = !0, N = e.detectFeatures(), H = N.raf, I = N.caf, E = N.transform, L = N.oldIE, f.scrollWrap = e.getChildByClass(a, "pswp__scroll-wrap"), f.container = e.getChildByClass(f.scrollWrap, "pswp__container"), n = f.container.style, f.itemHolders = y = [{ el: f.container.children[0], wrap: 0, index: -1 }, { el: f.container.children[1], wrap: 0, index: -1 }, { el: f.container.children[2], wrap: 0, index: -1 }], y[0].el.style.display = y[2].el.style.display = "none", Wa(), r = { resize: f.updateSize, orientationchange: function() { clearTimeout(O), O = setTimeout(function() { qa.x !== f.scrollWrap.clientWidth && f.updateSize() }, 500) }, scroll: Za, keydown: Xa, click: Ya }; var d = N.isOldIOSPhone || N.isOldAndroid || N.isMobileOpera; for (N.animationName && N.transform && !d || (i.showAnimationDuration = i.hideAnimationDuration = 0), c = 0; c < wa.length; c++) f["init" + wa[c]](); if (b) { var g = f.ui = new b(f, e);
                            g.init() } Da("firstUpdate"), m = m || i.index || 0, (isNaN(m) || m < 0 || m >= ac()) && (m = 0), f.currItem = _b(m), (N.isOldIOSPhone || N.isOldAndroid) && (va = !1), a.setAttribute("aria-hidden", "false"), i.modal && (va ? a.style.position = "fixed" : (a.style.position = "absolute", a.style.top = e.getScrollY() + "px")), void 0 === M && (Da("initialLayout"), M = K = e.getScrollY()); var l = "pswp--open "; for (i.mainClass && (l += i.mainClass + " "), i.showHideOpacity && (l += "pswp--animate_opacity "), l += G ? "pswp--touch" : "pswp--notouch", l += N.animationName ? " pswp--css_animation" : "", l += N.svg ? " pswp--svg" : "", e.addClass(a, l), f.updateSize(), o = -1, ua = null, c = 0; c < h; c++) Ja((c + o) * ta.x, y[c].el.style);
                        L || e.bind(f.scrollWrap, q, f), Ca("initialZoomInEnd", function() { f.setContent(y[0], m - 1), f.setContent(y[2], m + 1), y[0].el.style.display = y[2].el.style.display = "block", i.focus && a.focus(), Qa() }), f.setContent(y[1], m), f.updateCurrItem(), Da("afterInit"), va || (w = setInterval(function() { _a || V || aa || s !== f.currItem.initialZoomLevel || f.updateSize() }, 1e3)), e.addClass(a, "pswp--visible") } }, close: function() { j && (j = !1, k = !0, Da("close"), Ra(), cc(f.currItem, null, !0, f.destroy)) }, destroy: function() { Da("destroy"), Xb && clearTimeout(Xb), a.setAttribute("aria-hidden", "true"), a.className = J, w && clearInterval(w), e.unbind(f.scrollWrap, q, f), e.unbind(window, "scroll", f), zb(), cb(), Ba = null }, panTo: function(a, b, c) { c || (a > da.min.x ? a = da.min.x : a < da.max.x && (a = da.max.x), b > da.min.y ? b = da.min.y : b < da.max.y && (b = da.max.y)), pa.x = a, pa.y = b, Ha() }, handleEvent: function(a) { a = a || window.event, r[a.type] && r[a.type](a) }, goTo: function(a) { a = Aa(a); var b = a - m;
                    ua = b, m = a, f.currItem = _b(m), ra -= b, Ka(ta.x * ra), cb(), fa = !1, f.updateCurrItem() }, next: function() { f.goTo(m + 1) }, prev: function() { f.goTo(m - 1) }, updateCurrZoomItem: function(a) { if (a && Da("beforeChange", 0), y[1].el.children.length) { var b = y[1].el.children[0];
                        ea = e.hasClass(b, "pswp__zoom-wrap") ? b.style : null } else ea = null;
                    da = f.currItem.bounds, t = s = f.currItem.initialZoomLevel, pa.x = da.center.x, pa.y = da.center.y, a && Da("afterChange") }, invalidateCurrItems: function() { x = !0; for (var a = 0; a < h; a++) y[a].item && (y[a].item.needsUpdate = !0) }, updateCurrItem: function(a) { if (0 !== ua) { var b, c = Math.abs(ua); if (!(a && c < 2)) { f.currItem = _b(m), ya = !1, Da("beforeChange", ua), c >= h && (o += ua + (ua > 0 ? -h : h), c = h); for (var d = 0; d < c; d++) ua > 0 ? (b = y.shift(), y[h - 1] = b, o++, Ja((o + 2) * ta.x, b.el.style), f.setContent(b, m - c + d + 1 + 1)) : (b = y.pop(), y.unshift(b), o--, Ja(o * ta.x, b.el.style), f.setContent(b, m + c - d - 1 - 1)); if (ea && 1 === Math.abs(ua)) { var e = _b(z);
                                e.initialZoomLevel !== s && (ic(e, qa), mc(e), Ia(e)) } ua = 0, f.updateCurrZoomItem(), z = m, Da("afterChange") } } }, updateSize: function(b) { if (!va && i.modal) { var c = e.getScrollY(); if (M !== c && (a.style.top = c + "px", M = c), !b && xa.x === window.innerWidth && xa.y === window.innerHeight) return;
                        xa.x = window.innerWidth, xa.y = window.innerHeight, a.style.height = xa.y + "px" } if (qa.x = f.scrollWrap.clientWidth, qa.y = f.scrollWrap.clientHeight, Za(), ta.x = qa.x + Math.round(qa.x * i.spacing), ta.y = qa.y, Ka(ta.x * ra), Da("beforeResize"), void 0 !== o) { for (var d, g, j, k = 0; k < h; k++) d = y[k], Ja((k + o) * ta.x, d.el.style), j = m + k - 1, i.loop && ac() > 2 && (j = Aa(j)), g = _b(j), g && (x || g.needsUpdate || !g.bounds) ? (f.cleanSlide(g), f.setContent(d, j), 1 === k && (f.currItem = g, f.updateCurrZoomItem(!0)), g.needsUpdate = !1) : d.index === -1 && j >= 0 && f.setContent(d, j), g && g.container && (ic(g, qa), mc(g), Ia(g));
                        x = !1 } t = s = f.currItem.initialZoomLevel, da = f.currItem.bounds, da && (pa.x = da.center.x, pa.y = da.center.y, Ha(!0)), Da("resize") }, zoomTo: function(a, b, c, d, f) { b && (t = s, ub.x = Math.abs(b.x) - pa.x, ub.y = Math.abs(b.y) - pa.y, Ma(oa, pa)); var g = Sa(a, !1),
                        h = {};
                    Va("x", g, h, a), Va("y", g, h, a); var i = s,
                        j = { x: pa.x, y: pa.y };
                    Na(h); var k = function(b) { 1 === b ? (s = a, pa.x = h.x, pa.y = h.y) : (s = (a - i) * b + i, pa.x = (h.x - j.x) * b + j.x, pa.y = (h.y - j.y) * b + j.y), f && f(b), Ha(1 === b) };
                    c ? db("customZoomTo", 0, 1, c, d || e.easing.sine.inOut, k) : k(1) } },
            fb = 30,
            gb = 10,
            hb = {},
            ib = {},
            jb = {},
            kb = {},
            lb = {},
            mb = [],
            nb = {},
            ob = [],
            pb = {},
            qb = 0,
            rb = ma(),
            sb = 0,
            tb = ma(),
            ub = ma(),
            vb = ma(),
            wb = function(a, b) { return a.x === b.x && a.y === b.y },
            xb = function(a, b) { return Math.abs(a.x - b.x) < g && Math.abs(a.y - b.y) < g },
            yb = function(a, b) { return pb.x = Math.abs(a.x - b.x), pb.y = Math.abs(a.y - b.y), Math.sqrt(pb.x * pb.x + pb.y * pb.y) },
            zb = function() { Z && (I(Z), Z = null) },
            Ab = function() { V && (Z = H(Ab), Qb()) },
            Bb = function() { return !("fit" === i.scaleMode && s === f.currItem.initialZoomLevel) },
            Cb = function(a, b) { return !(!a || a === document) && (!(a.getAttribute("class") && a.getAttribute("class").indexOf("pswp__scroll-wrap") > -1) && (b(a) ? a : Cb(a.parentNode, b))) },
            Db = {},
            Eb = function(a, b) { return Db.prevent = !Cb(a.target, i.isClickableElement), Da("preventDragEvent", a, b, Db), Db.prevent },
            Fb = function(a, b) { return b.x = a.pageX, b.y = a.pageY, b.id = a.identifier, b },
            Gb = function(a, b, c) { c.x = .5 * (a.x + b.x), c.y = .5 * (a.y + b.y) },
            Hb = function(a, b, c) { if (a - Q > 50) { var d = ob.length > 2 ? ob.shift() : {};
                    d.x = b, d.y = c, ob.push(d), Q = a } },
            Ib = function() { var a = pa.y - f.currItem.initialPosition.y; return 1 - Math.abs(a / (qa.y / 2)) },
            Jb = {},
            Kb = {},
            Lb = [],
            Mb = function(a) { for (; Lb.length > 0;) Lb.pop(); return F ? (la = 0, mb.forEach(function(a) { 0 === la ? Lb[0] = a : 1 === la && (Lb[1] = a), la++ })) : a.type.indexOf("touch") > -1 ? a.touches && a.touches.length > 0 && (Lb[0] = Fb(a.touches[0], Jb), a.touches.length > 1 && (Lb[1] = Fb(a.touches[1], Kb))) : (Jb.x = a.pageX, Jb.y = a.pageY, Jb.id = "", Lb[0] = Jb), Lb },
            Nb = function(a, b) { var c, d, e, g, h = 0,
                    j = pa[a] + b[a],
                    k = b[a] > 0,
                    l = tb.x + b.x,
                    m = tb.x - nb.x; return c = j > da.min[a] || j < da.max[a] ? i.panEndFriction : 1, j = pa[a] + b[a] * c, !i.allowPanToNext && s !== f.currItem.initialZoomLevel || (ea ? "h" !== ga || "x" !== a || X || (k ? (j > da.min[a] && (c = i.panEndFriction, h = da.min[a] - j, d = da.min[a] - oa[a]), (d <= 0 || m < 0) && ac() > 1 ? (g = l, m < 0 && l > nb.x && (g = nb.x)) : da.min.x !== da.max.x && (e = j)) : (j < da.max[a] && (c = i.panEndFriction, h = j - da.max[a], d = oa[a] - da.max[a]), (d <= 0 || m > 0) && ac() > 1 ? (g = l, m > 0 && l < nb.x && (g = nb.x)) : da.min.x !== da.max.x && (e = j))) : g = l, "x" !== a) ? void(fa || $ || s > f.currItem.fitRatio && (pa[a] += b[a] * c)) : (void 0 !== g && (Ka(g, !0), $ = g !== nb.x), da.min.x !== da.max.x && (void 0 !== e ? pa.x = e : $ || (pa.x += b.x * c)), void 0 !== g) },
            Ob = function(a) { if (!("mousedown" === a.type && a.button > 0)) { if ($b) return void a.preventDefault(); if (!U || "mousedown" !== a.type) { if (Eb(a, !0) && a.preventDefault(), Da("pointerDown"), F) { var b = e.arraySearch(mb, a.pointerId, "id");
                            b < 0 && (b = mb.length), mb[b] = { x: a.pageX, y: a.pageY, id: a.pointerId } } var c = Mb(a),
                            d = c.length;
                        _ = null, cb(), V && 1 !== d || (V = ha = !0, e.bind(window, p, f), S = ka = ia = T = $ = Y = W = X = !1, ga = null, Da("firstTouchStart", c), Ma(oa, pa), na.x = na.y = 0, Ma(kb, c[0]), Ma(lb, kb), nb.x = ta.x * ra, ob = [{ x: kb.x, y: kb.y }], Q = P = Ea(), Sa(s, !0), zb(), Ab()), !aa && d > 1 && !fa && !$ && (t = s, X = !1, aa = W = !0, na.y = na.x = 0, Ma(oa, pa), Ma(hb, c[0]), Ma(ib, c[1]), Gb(hb, ib, vb), ub.x = Math.abs(vb.x) - pa.x, ub.y = Math.abs(vb.y) - pa.y, ba = ca = yb(hb, ib)) } } },
            Pb = function(a) { if (a.preventDefault(), F) { var b = e.arraySearch(mb, a.pointerId, "id"); if (b > -1) { var c = mb[b];
                        c.x = a.pageX, c.y = a.pageY } } if (V) { var d = Mb(a); if (ga || Y || aa) _ = d;
                    else if (tb.x !== ta.x * ra) ga = "h";
                    else { var f = Math.abs(d[0].x - kb.x) - Math.abs(d[0].y - kb.y);
                        Math.abs(f) >= gb && (ga = f > 0 ? "h" : "v", _ = d) } } },
            Qb = function() { if (_) { var a = _.length; if (0 !== a)
                        if (Ma(hb, _[0]), jb.x = hb.x - kb.x, jb.y = hb.y - kb.y, aa && a > 1) { if (kb.x = hb.x, kb.y = hb.y, !jb.x && !jb.y && wb(_[1], ib)) return;
                            Ma(ib, _[1]), X || (X = !0, Da("zoomGestureStarted")); var b = yb(hb, ib),
                                c = Vb(b);
                            c > f.currItem.initialZoomLevel + f.currItem.initialZoomLevel / 15 && (ka = !0); var d = 1,
                                e = Ta(),
                                g = Ua(); if (c < e)
                                if (i.pinchToClose && !ka && t <= f.currItem.initialZoomLevel) { var h = e - c,
                                        j = 1 - h / (e / 1.2);
                                    Fa(j), Da("onPinchClose", j), ia = !0 } else d = (e - c) / e, d > 1 && (d = 1), c = e - d * (e / 3);
                            else c > g && (d = (c - g) / (6 * e), d > 1 && (d = 1), c = g + d * e);
                            d < 0 && (d = 0), ba = b, Gb(hb, ib, rb), na.x += rb.x - vb.x, na.y += rb.y - vb.y, Ma(vb, rb), pa.x = La("x", c), pa.y = La("y", c), S = c > s, s = c, Ha() } else { if (!ga) return; if (ha && (ha = !1, Math.abs(jb.x) >= gb && (jb.x -= _[0].x - lb.x), Math.abs(jb.y) >= gb && (jb.y -= _[0].y - lb.y)), kb.x = hb.x, kb.y = hb.y, 0 === jb.x && 0 === jb.y) return; if ("v" === ga && i.closeOnVerticalDrag && !Bb()) { na.y += jb.y, pa.y += jb.y; var k = Ib(); return T = !0, Da("onVerticalDrag", k), Fa(k), void Ha() } Hb(Ea(), hb.x, hb.y), Y = !0, da = f.currItem.bounds; var l = Nb("x", jb);
                            l || (Nb("y", jb), Na(pa), Ha()) } } },
            Rb = function(a) { if (N.isOldAndroid) { if (U && "mouseup" === a.type) return;
                    a.type.indexOf("touch") > -1 && (clearTimeout(U), U = setTimeout(function() { U = 0 }, 600)) } Da("pointerUp"), Eb(a, !1) && a.preventDefault(); var b; if (F) { var c = e.arraySearch(mb, a.pointerId, "id"); if (c > -1)
                        if (b = mb.splice(c, 1)[0], navigator.pointerEnabled) b.type = a.pointerType || "mouse";
                        else { var d = { 4: "mouse", 2: "touch", 3: "pen" };
                            b.type = d[a.pointerType], b.type || (b.type = a.pointerType || "mouse") } } var g, h = Mb(a),
                    j = h.length; if ("mouseup" === a.type && (j = 0), 2 === j) return _ = null, !0;
                1 === j && Ma(lb, h[0]), 0 !== j || ga || fa || (b || ("mouseup" === a.type ? b = { x: a.pageX, y: a.pageY, type: "mouse" } : a.changedTouches && a.changedTouches[0] && (b = { x: a.changedTouches[0].pageX, y: a.changedTouches[0].pageY, type: "touch" })), Da("touchRelease", a, b)); var k = -1; if (0 === j && (V = !1, e.unbind(window, p, f), zb(), aa ? k = 0 : sb !== -1 && (k = Ea() - sb)), sb = 1 === j ? Ea() : -1, g = k !== -1 && k < 150 ? "zoom" : "swipe", aa && j < 2 && (aa = !1, 1 === j && (g = "zoomPointerUp"), Da("zoomGestureEnded")), _ = null, Y || X || fa || T)
                    if (cb(), R || (R = Sb()), R.calculateSwipeSpeed("x"), T) { var l = Ib(); if (l < i.verticalDragRange) f.close();
                        else { var m = pa.y,
                                n = ja;
                            db("verticalDrag", 0, 1, 300, e.easing.cubic.out, function(a) { pa.y = (f.currItem.initialPosition.y - m) * a + m, Fa((1 - n) * a + n), Ha() }), Da("onVerticalDrag", 1) } } else { if (($ || fa) && 0 === j) { var o = Ub(g, R); if (o) return;
                            g = "zoomPointerUp" } if (!fa) return "swipe" !== g ? void Wb() : void(!$ && s > f.currItem.fitRatio && Tb(R)) } },
            Sb = function() { var a, b, c = { lastFlickOffset: {}, lastFlickDist: {}, lastFlickSpeed: {}, slowDownRatio: {}, slowDownRatioReverse: {}, speedDecelerationRatio: {}, speedDecelerationRatioAbs: {}, distanceOffset: {}, backAnimDestination: {}, backAnimStarted: {}, calculateSwipeSpeed: function(d) { ob.length > 1 ? (a = Ea() - Q + 50, b = ob[ob.length - 2][d]) : (a = Ea() - P, b = lb[d]), c.lastFlickOffset[d] = kb[d] - b, c.lastFlickDist[d] = Math.abs(c.lastFlickOffset[d]), c.lastFlickDist[d] > 20 ? c.lastFlickSpeed[d] = c.lastFlickOffset[d] / a : c.lastFlickSpeed[d] = 0, Math.abs(c.lastFlickSpeed[d]) < .1 && (c.lastFlickSpeed[d] = 0), c.slowDownRatio[d] = .95, c.slowDownRatioReverse[d] = 1 - c.slowDownRatio[d], c.speedDecelerationRatio[d] = 1 }, calculateOverBoundsAnimOffset: function(a, b) { c.backAnimStarted[a] || (pa[a] > da.min[a] ? c.backAnimDestination[a] = da.min[a] : pa[a] < da.max[a] && (c.backAnimDestination[a] = da.max[a]), void 0 !== c.backAnimDestination[a] && (c.slowDownRatio[a] = .7, c.slowDownRatioReverse[a] = 1 - c.slowDownRatio[a], c.speedDecelerationRatioAbs[a] < .05 && (c.lastFlickSpeed[a] = 0, c.backAnimStarted[a] = !0, db("bounceZoomPan" + a, pa[a], c.backAnimDestination[a], b || 300, e.easing.sine.out, function(b) { pa[a] = b, Ha() })))) }, calculateAnimOffset: function(a) { c.backAnimStarted[a] || (c.speedDecelerationRatio[a] = c.speedDecelerationRatio[a] * (c.slowDownRatio[a] + c.slowDownRatioReverse[a] - c.slowDownRatioReverse[a] * c.timeDiff / 10), c.speedDecelerationRatioAbs[a] = Math.abs(c.lastFlickSpeed[a] * c.speedDecelerationRatio[a]), c.distanceOffset[a] = c.lastFlickSpeed[a] * c.speedDecelerationRatio[a] * c.timeDiff, pa[a] += c.distanceOffset[a]) }, panAnimLoop: function() { if ($a.zoomPan && ($a.zoomPan.raf = H(c.panAnimLoop), c.now = Ea(), c.timeDiff = c.now - c.lastNow, c.lastNow = c.now, c.calculateAnimOffset("x"), c.calculateAnimOffset("y"), Ha(), c.calculateOverBoundsAnimOffset("x"), c.calculateOverBoundsAnimOffset("y"), c.speedDecelerationRatioAbs.x < .05 && c.speedDecelerationRatioAbs.y < .05)) return pa.x = Math.round(pa.x), pa.y = Math.round(pa.y), Ha(), void ab("zoomPan") } }; return c },
            Tb = function(a) { return a.calculateSwipeSpeed("y"), da = f.currItem.bounds, a.backAnimDestination = {}, a.backAnimStarted = {}, Math.abs(a.lastFlickSpeed.x) <= .05 && Math.abs(a.lastFlickSpeed.y) <= .05 ? (a.speedDecelerationRatioAbs.x = a.speedDecelerationRatioAbs.y = 0, a.calculateOverBoundsAnimOffset("x"), a.calculateOverBoundsAnimOffset("y"), !0) : (bb("zoomPan"), a.lastNow = Ea(), void a.panAnimLoop()) },
            Ub = function(a, b) { var c;
                fa || (qb = m); var d; if ("swipe" === a) { var g = kb.x - lb.x,
                        h = b.lastFlickDist.x < 10;
                    g > fb && (h || b.lastFlickOffset.x > 20) ? d = -1 : g < -fb && (h || b.lastFlickOffset.x < -20) && (d = 1) } var j;
                d && (m += d, m < 0 ? (m = i.loop ? ac() - 1 : 0, j = !0) : m >= ac() && (m = i.loop ? 0 : ac() - 1, j = !0), j && !i.loop || (ua += d, ra -= d, c = !0)); var k, l = ta.x * ra,
                    n = Math.abs(l - tb.x); return c || l > tb.x == b.lastFlickSpeed.x > 0 ? (k = Math.abs(b.lastFlickSpeed.x) > 0 ? n / Math.abs(b.lastFlickSpeed.x) : 333, k = Math.min(k, 400), k = Math.max(k, 250)) : k = 333, qb === m && (c = !1), fa = !0, Da("mainScrollAnimStart"), db("mainScroll", tb.x, l, k, e.easing.cubic.out, Ka, function() { cb(), fa = !1, qb = -1, (c || qb !== m) && f.updateCurrItem(), Da("mainScrollAnimComplete") }), c && f.updateCurrItem(!0), c },
            Vb = function(a) { return 1 / ca * a * t },
            Wb = function() { var a = s,
                    b = Ta(),
                    c = Ua();
                s < b ? a = b : s > c && (a = c); var d, g = 1,
                    h = ja; return ia && !S && !ka && s < b ? (f.close(), !0) : (ia && (d = function(a) { Fa((g - h) * a + h) }), f.zoomTo(a, 0, 200, e.easing.cubic.out, d), !0) };
        za("Gestures", { publicMethods: { initGestures: function() { var a = function(a, b, c, d, e) { A = a + b, B = a + c, C = a + d, D = e ? a + e : "" };
                    F = N.pointerEvent, F && N.touch && (N.touch = !1), F ? navigator.pointerEnabled ? a("pointer", "down", "move", "up", "cancel") : a("MSPointer", "Down", "Move", "Up", "Cancel") : N.touch ? (a("touch", "start", "move", "end", "cancel"), G = !0) : a("mouse", "down", "move", "up"), p = B + " " + C + " " + D, q = A, F && !G && (G = navigator.maxTouchPoints > 1 || navigator.msMaxTouchPoints > 1), f.likelyTouchDevice = G, r[A] = Ob, r[B] = Pb, r[C] = Rb, D && (r[D] = r[C]), N.touch && (q += " mousedown", p += " mousemove mouseup", r.mousedown = r[A], r.mousemove = r[B], r.mouseup = r[C]), G || (i.allowPanToNext = !1) } } }); var Xb, Yb, Zb, $b, _b, ac, bc, cc = function(b, c, d, g) { Xb && clearTimeout(Xb), $b = !0, Zb = !0; var h;
                b.initialLayout ? (h = b.initialLayout, b.initialLayout = null) : h = i.getThumbBoundsFn && i.getThumbBoundsFn(m); var j = d ? i.hideAnimationDuration : i.showAnimationDuration,
                    k = function() { ab("initialZoom"), d ? (f.template.removeAttribute("style"), f.bg.removeAttribute("style")) : (Fa(1), c && (c.style.display = "block"), e.addClass(a, "pswp--animated-in"), Da("initialZoom" + (d ? "OutEnd" : "InEnd"))), g && g(), $b = !1 }; if (!j || !h || void 0 === h.x) return Da("initialZoom" + (d ? "Out" : "In")), s = b.initialZoomLevel, Ma(pa, b.initialPosition), Ha(), a.style.opacity = d ? 0 : 1, Fa(1), void(j ? setTimeout(function() { k() }, j) : k()); var n = function() { var c = l,
                        g = !f.currItem.src || f.currItem.loadError || i.showHideOpacity;
                    b.miniImg && (b.miniImg.style.webkitBackfaceVisibility = "hidden"), d || (s = h.w / b.w, pa.x = h.x, pa.y = h.y - K, f[g ? "template" : "bg"].style.opacity = .001, Ha()), bb("initialZoom"), d && !c && e.removeClass(a, "pswp--animated-in"), g && (d ? e[(c ? "remove" : "add") + "Class"](a, "pswp--animate_opacity") : setTimeout(function() { e.addClass(a, "pswp--animate_opacity") }, 30)), Xb = setTimeout(function() { if (Da("initialZoom" + (d ? "Out" : "In")), d) { var f = h.w / b.w,
                                i = { x: pa.x, y: pa.y },
                                l = s,
                                m = ja,
                                n = function(b) { 1 === b ? (s = f, pa.x = h.x, pa.y = h.y - M) : (s = (f - l) * b + l, pa.x = (h.x - i.x) * b + i.x, pa.y = (h.y - M - i.y) * b + i.y), Ha(), g ? a.style.opacity = 1 - b : Fa(m - b * m) };
                            c ? db("initialZoom", 0, 1, j, e.easing.cubic.out, n, k) : (n(1), Xb = setTimeout(k, j + 20)) } else s = b.initialZoomLevel, Ma(pa, b.initialPosition), Ha(), Fa(1), g ? a.style.opacity = 1 : Fa(1), Xb = setTimeout(k, j + 20) }, d ? 25 : 90) };
                n() },
            dc = {},
            ec = [],
            fc = { index: 0, errorMsg: '<div class="pswp__error-msg"><a href="%url%" target="_blank">The image</a> could not be loaded.</div>', forceProgressiveLoading: !1, preload: [1, 1], getNumItemsFn: function() { return Yb.length } },
            gc = function() { return { center: { x: 0, y: 0 }, max: { x: 0, y: 0 }, min: { x: 0, y: 0 } } },
            hc = function(a, b, c) { var d = a.bounds;
                d.center.x = Math.round((dc.x - b) / 2), d.center.y = Math.round((dc.y - c) / 2) + a.vGap.top, d.max.x = b > dc.x ? Math.round(dc.x - b) : d.center.x, d.max.y = c > dc.y ? Math.round(dc.y - c) + a.vGap.top : d.center.y, d.min.x = b > dc.x ? 0 : d.center.x, d.min.y = c > dc.y ? a.vGap.top : d.center.y },
            ic = function(a, b, c) { if (a.src && !a.loadError) { var d = !c; if (d && (a.vGap || (a.vGap = { top: 0, bottom: 0 }), Da("parseVerticalMargin", a)), dc.x = b.x, dc.y = b.y - a.vGap.top - a.vGap.bottom, d) { var e = dc.x / a.w,
                            f = dc.y / a.h;
                        a.fitRatio = e < f ? e : f; var g = i.scaleMode; "orig" === g ? c = 1 : "fit" === g && (c = a.fitRatio), c > 1 && (c = 1), a.initialZoomLevel = c, a.bounds || (a.bounds = gc()) } if (!c) return; return hc(a, a.w * c, a.h * c), d && c === a.initialZoomLevel && (a.initialPosition = a.bounds.center), a.bounds } return a.w = a.h = 0, a.initialZoomLevel = a.fitRatio = 1, a.bounds = gc(), a.initialPosition = a.bounds.center, a.bounds },
            jc = function(a, b, c, d, e, g) { b.loadError || d && (b.imageAppended = !0, mc(b, d, b === f.currItem && ya), c.appendChild(d), g && setTimeout(function() { b && b.loaded && b.placeholder && (b.placeholder.style.display = "none", b.placeholder = null) }, 500)) },
            kc = function(a) { a.loading = !0, a.loaded = !1; var b = a.img = e.createEl("pswp__img", "img"),
                    c = function() { a.loading = !1, a.loaded = !0, a.loadComplete ? a.loadComplete(a) : a.img = null, b.onload = b.onerror = null, b = null }; return b.onload = c, b.onerror = function() { a.loadError = !0, c() }, b.src = a.src, b },
            lc = function(a, b) { if (a.src && a.loadError && a.container) return b && (a.container.innerHTML = ""), a.container.innerHTML = i.errorMsg.replace("%url%", a.src), !0 },
            mc = function(a, b, c) { if (a.src) { b || (b = a.container.lastChild); var d = c ? a.w : Math.round(a.w * a.fitRatio),
                        e = c ? a.h : Math.round(a.h * a.fitRatio);
                    a.placeholder && !a.loaded && (a.placeholder.style.width = d + "px", a.placeholder.style.height = e + "px"), b.style.width = d + "px", b.style.height = e + "px" } },
            nc = function() { if (ec.length) { for (var a, b = 0; b < ec.length; b++) a = ec[b], a.holder.index === a.index && jc(a.index, a.item, a.baseDiv, a.img, !1, a.clearPlaceholder);
                    ec = [] } };
        za("Controller", { publicMethods: { lazyLoadItem: function(a) { a = Aa(a); var b = _b(a);
                    b && (!b.loaded && !b.loading || x) && (Da("gettingData", a, b), b.src && kc(b)) }, initController: function() { e.extend(i, fc, !0), f.items = Yb = c, _b = f.getItemAt, ac = i.getNumItemsFn, bc = i.loop, ac() < 3 && (i.loop = !1), Ca("beforeChange", function(a) { var b, c = i.preload,
                            d = null === a || a >= 0,
                            e = Math.min(c[0], ac()),
                            g = Math.min(c[1], ac()); for (b = 1; b <= (d ? g : e); b++) f.lazyLoadItem(m + b); for (b = 1; b <= (d ? e : g); b++) f.lazyLoadItem(m - b) }), Ca("initialLayout", function() { f.currItem.initialLayout = i.getThumbBoundsFn && i.getThumbBoundsFn(m) }), Ca("mainScrollAnimComplete", nc), Ca("initialZoomInEnd", nc), Ca("destroy", function() { for (var a, b = 0; b < Yb.length; b++) a = Yb[b], a.container && (a.container = null), a.placeholder && (a.placeholder = null), a.img && (a.img = null), a.preloader && (a.preloader = null), a.loadError && (a.loaded = a.loadError = !1);
                        ec = null }) }, getItemAt: function(a) { return a >= 0 && (void 0 !== Yb[a] && Yb[a]) }, allowProgressiveImg: function() { return i.forceProgressiveLoading || !G || i.mouseUsed || screen.width > 1200 }, setContent: function(a, b) { i.loop && (b = Aa(b)); var c = f.getItemAt(a.index);
                    c && (c.container = null); var d, g = f.getItemAt(b); if (!g) return void(a.el.innerHTML = "");
                    Da("gettingData", b, g), a.index = b, a.item = g; var h = g.container = e.createEl("pswp__zoom-wrap"); if (!g.src && g.html && (g.html.tagName ? h.appendChild(g.html) : h.innerHTML = g.html), lc(g), ic(g, qa), !g.src || g.loadError || g.loaded) g.src && !g.loadError && (d = e.createEl("pswp__img", "img"), d.style.opacity = 1, d.src = g.src, mc(g, d), jc(b, g, h, d, !0));
                    else { if (g.loadComplete = function(c) { if (j) { if (a && a.index === b) { if (lc(c, !0)) return c.loadComplete = c.img = null, ic(c, qa), Ia(c), void(a.index === m && f.updateCurrZoomItem());
                                        c.imageAppended ? !$b && c.placeholder && (c.placeholder.style.display = "none", c.placeholder = null) : N.transform && (fa || $b) ? ec.push({ item: c, baseDiv: h, img: c.img, index: b, holder: a, clearPlaceholder: !0 }) : jc(b, c, h, c.img, fa || $b, !0) } c.loadComplete = null, c.img = null, Da("imageLoadComplete", b, c) } }, e.features.transform) { var k = "pswp__img pswp__img--placeholder";
                            k += g.msrc ? "" : " pswp__img--placeholder--blank"; var l = e.createEl(k, g.msrc ? "img" : "");
                            g.msrc && (l.src = g.msrc), mc(g, l), h.appendChild(l), g.placeholder = l } g.loading || kc(g), f.allowProgressiveImg() && (!Zb && N.transform ? ec.push({ item: g, baseDiv: h, img: g.img, index: b, holder: a }) : jc(b, g, h, g.img, !0, !0)) } Zb || b !== m ? Ia(g) : (ea = h.style, cc(g, d || g.img)), a.el.innerHTML = "", a.el.appendChild(h) }, cleanSlide: function(a) { a.img && (a.img.onload = a.img.onerror = null), a.loaded = a.loading = a.img = a.imageAppended = !1 } } }); var oc, pc = {},
            qc = function(a, b, c) { var d = document.createEvent("CustomEvent"),
                    e = { origEvent: a, target: a.target, releasePoint: b, pointerType: c || "touch" };
                d.initCustomEvent("pswpTap", !0, !0, e), a.target.dispatchEvent(d) };
        za("Tap", { publicMethods: { initTap: function() { Ca("firstTouchStart", f.onTapStart), Ca("touchRelease", f.onTapRelease), Ca("destroy", function() { pc = {}, oc = null }) }, onTapStart: function(a) { a.length > 1 && (clearTimeout(oc), oc = null) }, onTapRelease: function(a, b) { if (b && !Y && !W && !_a) { var c = b; if (oc && (clearTimeout(oc), oc = null, xb(c, pc))) return void Da("doubleTap", c); if ("mouse" === b.type) return void qc(a, b, "mouse"); var d = a.target.tagName.toUpperCase(); if ("BUTTON" === d || e.hasClass(a.target, "pswp__single-tap")) return void qc(a, b);
                        Ma(pc, c), oc = setTimeout(function() { qc(a, b), oc = null }, 300) } } } }); var rc;
        za("DesktopZoom", { publicMethods: { initDesktopZoom: function() { L || (G ? Ca("mouseUsed", function() { f.setupDesktopZoom() }) : f.setupDesktopZoom(!0)) }, setupDesktopZoom: function(b) { rc = {}; var c = "wheel mousewheel DOMMouseScroll";
                    Ca("bindEvents", function() { e.bind(a, c, f.handleMouseWheel) }), Ca("unbindEvents", function() { rc && e.unbind(a, c, f.handleMouseWheel) }), f.mouseZoomedIn = !1; var d, g = function() { f.mouseZoomedIn && (e.removeClass(a, "pswp--zoomed-in"), f.mouseZoomedIn = !1), s < 1 ? e.addClass(a, "pswp--zoom-allowed") : e.removeClass(a, "pswp--zoom-allowed"), h() },
                        h = function() { d && (e.removeClass(a, "pswp--dragging"), d = !1) };
                    Ca("resize", g), Ca("afterChange", g), Ca("pointerDown", function() { f.mouseZoomedIn && (d = !0, e.addClass(a, "pswp--dragging")) }), Ca("pointerUp", h), b || g() }, handleMouseWheel: function(a) { if (s <= f.currItem.fitRatio) return i.modal && (!i.closeOnScroll || _a || V ? a.preventDefault() : E && Math.abs(a.deltaY) > 2 && (l = !0, f.close())), !0; if (a.stopPropagation(), rc.x = 0, "deltaX" in a) 1 === a.deltaMode ? (rc.x = 18 * a.deltaX, rc.y = 18 * a.deltaY) : (rc.x = a.deltaX, rc.y = a.deltaY);
                    else if ("wheelDelta" in a) a.wheelDeltaX && (rc.x = -.16 * a.wheelDeltaX), a.wheelDeltaY ? rc.y = -.16 * a.wheelDeltaY : rc.y = -.16 * a.wheelDelta;
                    else { if (!("detail" in a)) return;
                        rc.y = a.detail } Sa(s, !0); var b = pa.x - rc.x,
                        c = pa.y - rc.y;
                    (i.modal || b <= da.min.x && b >= da.max.x && c <= da.min.y && c >= da.max.y) && a.preventDefault(), f.panTo(b, c) }, toggleDesktopZoom: function(b) { b = b || { x: qa.x / 2 + sa.x, y: qa.y / 2 + sa.y }; var c = i.getDoubleTapZoom(!0, f.currItem),
                        d = s === c;
                    f.mouseZoomedIn = !d, f.zoomTo(d ? f.currItem.initialZoomLevel : c, b, 333), e[(d ? "remove" : "add") + "Class"](a, "pswp--zoomed-in") } } }); var sc, tc, uc, vc, wc, xc, yc, zc, Ac, Bc, Cc, Dc, Ec = { history: !0, galleryUID: 1 },
            Fc = function() { return Cc.hash.substring(1) },
            Gc = function() { sc && clearTimeout(sc), uc && clearTimeout(uc) },
            Hc = function() { var a = Fc(),
                    b = {}; if (a.length < 5) return b; var c, d = a.split("&"); for (c = 0; c < d.length; c++)
                    if (d[c]) { var e = d[c].split("=");
                        e.length < 2 || (b[e[0]] = e[1]) } if (i.galleryPIDs) { var f = b.pid; for (b.pid = 0, c = 0; c < Yb.length; c++)
                        if (Yb[c].pid === f) { b.pid = c; break } } else b.pid = parseInt(b.pid, 10) - 1; return b.pid < 0 && (b.pid = 0), b },
            Ic = function() { if (uc && clearTimeout(uc), _a || V) return void(uc = setTimeout(Ic, 500));
                vc ? clearTimeout(tc) : vc = !0; var a = m + 1,
                    b = _b(m);
                b.hasOwnProperty("pid") && (a = b.pid); var c = yc + "&gid=" + i.galleryUID + "&pid=" + a;
                zc || Cc.hash.indexOf(c) === -1 && (Bc = !0); var d = Cc.href.split("#")[0] + "#" + c;
                Dc ? "#" + c !== window.location.hash && history[zc ? "replaceState" : "pushState"]("", document.title, d) : zc ? Cc.replace(d) : Cc.hash = c, zc = !0, tc = setTimeout(function() { vc = !1 }, 60) };
        za("History", { publicMethods: { initHistory: function() { if (e.extend(i, Ec, !0), i.history) { Cc = window.location, Bc = !1, Ac = !1, zc = !1, yc = Fc(), Dc = "pushState" in history, yc.indexOf("gid=") > -1 && (yc = yc.split("&gid=")[0], yc = yc.split("?gid=")[0]), Ca("afterChange", f.updateURL), Ca("unbindEvents", function() { e.unbind(window, "hashchange", f.onHashChange) }); var a = function() { xc = !0, Ac || (Bc ? history.back() : yc ? Cc.hash = yc : Dc ? history.pushState("", document.title, Cc.pathname + Cc.search) : Cc.hash = ""), Gc() };
                        Ca("unbindEvents", function() { l && a() }), Ca("destroy", function() { xc || a() }), Ca("firstUpdate", function() { m = Hc().pid }); var b = yc.indexOf("pid=");
                        b > -1 && (yc = yc.substring(0, b), "&" === yc.slice(-1) && (yc = yc.slice(0, -1))), setTimeout(function() { j && e.bind(window, "hashchange", f.onHashChange) }, 40) } }, onHashChange: function() { return Fc() === yc ? (Ac = !0, void f.close()) : void(vc || (wc = !0, f.goTo(Hc().pid), wc = !1)) }, updateURL: function() { Gc(), wc || (zc ? sc = setTimeout(Ic, 800) : Ic()) } } }), e.extend(f, eb) }; return a });
/*! PhotoSwipe Default UI - 4.1.2 - 2017-04-05
* http://photoswipe.com
* Copyright (c) 2017 Dmitry Semenov; */
!function(a,b){"function"==typeof define&&define.amd?define(b):"object"==typeof exports?module.exports=b():a.PhotoSwipeUI_Default=b()}(this,function(){"use strict";var a=function(a,b){var c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v=this,w=!1,x=!0,y=!0,z={barsSize:{top:44,bottom:"auto"},closeElClasses:["item","caption","zoom-wrap","ui","top-bar"],timeToIdle:4e3,timeToIdleOutside:1e3,loadingIndicatorDelay:1e3,addCaptionHTMLFn:function(a,b){return a.title?(b.children[0].innerHTML=a.title,!0):(b.children[0].innerHTML="",!1)},closeEl:!0,captionEl:!0,fullscreenEl:!0,zoomEl:!0,shareEl:!0,counterEl:!0,arrowEl:!0,preloaderEl:!0,tapToClose:!1,tapToToggleControls:!0,clickToCloseNonZoomable:!0,shareButtons:[{id:"facebook",label:"Share on Facebook",url:"https://www.facebook.com/sharer/sharer.php?u={{url}}"},{id:"twitter",label:"Tweet",url:"https://twitter.com/intent/tweet?text={{text}}&url={{url}}"},{id:"pinterest",label:"Pin it",url:"http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}"},{id:"download",label:"Download image",url:"{{raw_image_url}}",download:!0}],getImageURLForShare:function(){return a.currItem.src||""},getPageURLForShare:function(){return window.location.href},getTextForShare:function(){return a.currItem.title||""},indexIndicatorSep:" / ",fitControlsWidth:1200},A=function(a){if(r)return!0;a=a||window.event,q.timeToIdle&&q.mouseUsed&&!k&&K();for(var c,d,e=a.target||a.srcElement,f=e.getAttribute("class")||"",g=0;g<S.length;g++)c=S[g],c.onTap&&f.indexOf("pswp__"+c.name)>-1&&(c.onTap(),d=!0);if(d){a.stopPropagation&&a.stopPropagation(),r=!0;var h=b.features.isOldAndroid?600:30;s=setTimeout(function(){r=!1},h)}},B=function(){return!a.likelyTouchDevice||q.mouseUsed||screen.width>q.fitControlsWidth},C=function(a,c,d){b[(d?"add":"remove")+"Class"](a,"pswp__"+c)},D=function(){var a=1===q.getNumItemsFn();a!==p&&(C(d,"ui--one-slide",a),p=a)},E=function(){C(i,"share-modal--hidden",y)},F=function(){return y=!y,y?(b.removeClass(i,"pswp__share-modal--fade-in"),setTimeout(function(){y&&E()},300)):(E(),setTimeout(function(){y||b.addClass(i,"pswp__share-modal--fade-in")},30)),y||H(),!1},G=function(b){b=b||window.event;var c=b.target||b.srcElement;return a.shout("shareLinkClick",b,c),!!c.href&&(!!c.hasAttribute("download")||(window.open(c.href,"pswp_share","scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,top=100,left="+(window.screen?Math.round(screen.width/2-275):100)),y||F(),!1))},H=function(){for(var a,b,c,d,e,f="",g=0;g<q.shareButtons.length;g++)a=q.shareButtons[g],c=q.getImageURLForShare(a),d=q.getPageURLForShare(a),e=q.getTextForShare(a),b=a.url.replace("{{url}}",encodeURIComponent(d)).replace("{{image_url}}",encodeURIComponent(c)).replace("{{raw_image_url}}",c).replace("{{text}}",encodeURIComponent(e)),f+='<a href="'+b+'" target="_blank" class="pswp__share--'+a.id+'"'+(a.download?"download":"")+">"+a.label+"</a>",q.parseShareButtonOut&&(f=q.parseShareButtonOut(a,f));i.children[0].innerHTML=f,i.children[0].onclick=G},I=function(a){for(var c=0;c<q.closeElClasses.length;c++)if(b.hasClass(a,"pswp__"+q.closeElClasses[c]))return!0},J=0,K=function(){clearTimeout(u),J=0,k&&v.setIdle(!1)},L=function(a){a=a?a:window.event;var b=a.relatedTarget||a.toElement;b&&"HTML"!==b.nodeName||(clearTimeout(u),u=setTimeout(function(){v.setIdle(!0)},q.timeToIdleOutside))},M=function(){q.fullscreenEl&&!b.features.isOldAndroid&&(c||(c=v.getFullscreenAPI()),c?(b.bind(document,c.eventK,v.updateFullscreen),v.updateFullscreen(),b.addClass(a.template,"pswp--supports-fs")):b.removeClass(a.template,"pswp--supports-fs"))},N=function(){q.preloaderEl&&(O(!0),l("beforeChange",function(){clearTimeout(o),o=setTimeout(function(){a.currItem&&a.currItem.loading?(!a.allowProgressiveImg()||a.currItem.img&&!a.currItem.img.naturalWidth)&&O(!1):O(!0)},q.loadingIndicatorDelay)}),l("imageLoadComplete",function(b,c){a.currItem===c&&O(!0)}))},O=function(a){n!==a&&(C(m,"preloader--active",!a),n=a)},P=function(a){var c=a.vGap;if(B()){var g=q.barsSize;if(q.captionEl&&"auto"===g.bottom)if(f||(f=b.createEl("pswp__caption pswp__caption--fake"),f.appendChild(b.createEl("pswp__caption__center")),d.insertBefore(f,e),b.addClass(d,"pswp__ui--fit")),q.addCaptionHTMLFn(a,f,!0)){var h=f.clientHeight;c.bottom=parseInt(h,10)||44}else c.bottom=g.top;else c.bottom="auto"===g.bottom?0:g.bottom;c.top=g.top}else c.top=c.bottom=0},Q=function(){q.timeToIdle&&l("mouseUsed",function(){b.bind(document,"mousemove",K),b.bind(document,"mouseout",L),t=setInterval(function(){J++,2===J&&v.setIdle(!0)},q.timeToIdle/2)})},R=function(){l("onVerticalDrag",function(a){x&&a<.95?v.hideControls():!x&&a>=.95&&v.showControls()});var a;l("onPinchClose",function(b){x&&b<.9?(v.hideControls(),a=!0):a&&!x&&b>.9&&v.showControls()}),l("zoomGestureEnded",function(){a=!1,a&&!x&&v.showControls()})},S=[{name:"caption",option:"captionEl",onInit:function(a){e=a}},{name:"share-modal",option:"shareEl",onInit:function(a){i=a},onTap:function(){F()}},{name:"button--share",option:"shareEl",onInit:function(a){h=a},onTap:function(){F()}},{name:"button--zoom",option:"zoomEl",onTap:a.toggleDesktopZoom},{name:"counter",option:"counterEl",onInit:function(a){g=a}},{name:"button--close",option:"closeEl",onTap:a.close},{name:"button--arrow--left",option:"arrowEl",onTap:a.prev},{name:"button--arrow--right",option:"arrowEl",onTap:a.next},{name:"button--fs",option:"fullscreenEl",onTap:function(){c.isFullscreen()?c.exit():c.enter()}},{name:"preloader",option:"preloaderEl",onInit:function(a){m=a}}],T=function(){var a,c,e,f=function(d){if(d)for(var f=d.length,g=0;g<f;g++){a=d[g],c=a.className;for(var h=0;h<S.length;h++)e=S[h],c.indexOf("pswp__"+e.name)>-1&&(q[e.option]?(b.removeClass(a,"pswp__element--disabled"),e.onInit&&e.onInit(a)):b.addClass(a,"pswp__element--disabled"))}};f(d.children);var g=b.getChildByClass(d,"pswp__top-bar");g&&f(g.children)};v.init=function(){b.extend(a.options,z,!0),q=a.options,d=b.getChildByClass(a.scrollWrap,"pswp__ui"),l=a.listen,R(),l("beforeChange",v.update),l("doubleTap",function(b){var c=a.currItem.initialZoomLevel;a.getZoomLevel()!==c?a.zoomTo(c,b,333):a.zoomTo(q.getDoubleTapZoom(!1,a.currItem),b,333)}),l("preventDragEvent",function(a,b,c){var d=a.target||a.srcElement;d&&d.getAttribute("class")&&a.type.indexOf("mouse")>-1&&(d.getAttribute("class").indexOf("__caption")>0||/(SMALL|STRONG|EM)/i.test(d.tagName))&&(c.prevent=!1)}),l("bindEvents",function(){b.bind(d,"pswpTap click",A),b.bind(a.scrollWrap,"pswpTap",v.onGlobalTap),a.likelyTouchDevice||b.bind(a.scrollWrap,"mouseover",v.onMouseOver)}),l("unbindEvents",function(){y||F(),t&&clearInterval(t),b.unbind(document,"mouseout",L),b.unbind(document,"mousemove",K),b.unbind(d,"pswpTap click",A),b.unbind(a.scrollWrap,"pswpTap",v.onGlobalTap),b.unbind(a.scrollWrap,"mouseover",v.onMouseOver),c&&(b.unbind(document,c.eventK,v.updateFullscreen),c.isFullscreen()&&(q.hideAnimationDuration=0,c.exit()),c=null)}),l("destroy",function(){q.captionEl&&(f&&d.removeChild(f),b.removeClass(e,"pswp__caption--empty")),i&&(i.children[0].onclick=null),b.removeClass(d,"pswp__ui--over-close"),b.addClass(d,"pswp__ui--hidden"),v.setIdle(!1)}),q.showAnimationDuration||b.removeClass(d,"pswp__ui--hidden"),l("initialZoomIn",function(){q.showAnimationDuration&&b.removeClass(d,"pswp__ui--hidden")}),l("initialZoomOut",function(){b.addClass(d,"pswp__ui--hidden")}),l("parseVerticalMargin",P),T(),q.shareEl&&h&&i&&(y=!0),D(),Q(),M(),N()},v.setIdle=function(a){k=a,C(d,"ui--idle",a)},v.update=function(){x&&a.currItem?(v.updateIndexIndicator(),q.captionEl&&(q.addCaptionHTMLFn(a.currItem,e),C(e,"caption--empty",!a.currItem.title)),w=!0):w=!1,y||F(),D()},v.updateFullscreen=function(d){d&&setTimeout(function(){a.setScrollOffset(0,b.getScrollY())},50),b[(c.isFullscreen()?"add":"remove")+"Class"](a.template,"pswp--fs")},v.updateIndexIndicator=function(){q.counterEl&&(g.innerHTML=a.getCurrentIndex()+1+q.indexIndicatorSep+q.getNumItemsFn())},v.onGlobalTap=function(c){c=c||window.event;var d=c.target||c.srcElement;if(!r)if(c.detail&&"mouse"===c.detail.pointerType){if(I(d))return void a.close();b.hasClass(d,"pswp__img")&&(1===a.getZoomLevel()&&a.getZoomLevel()<=a.currItem.fitRatio?q.clickToCloseNonZoomable&&a.close():a.toggleDesktopZoom(c.detail.releasePoint))}else if(q.tapToToggleControls&&(x?v.hideControls():v.showControls()),q.tapToClose&&(b.hasClass(d,"pswp__img")||I(d)))return void a.close()},v.onMouseOver=function(a){a=a||window.event;var b=a.target||a.srcElement;C(d,"ui--over-close",I(b))},v.hideControls=function(){b.addClass(d,"pswp__ui--hidden"),x=!1},v.showControls=function(){x=!0,w||v.update(),b.removeClass(d,"pswp__ui--hidden")},v.supportsFullscreen=function(){var a=document;return!!(a.exitFullscreen||a.mozCancelFullScreen||a.webkitExitFullscreen||a.msExitFullscreen)},v.getFullscreenAPI=function(){var b,c=document.documentElement,d="fullscreenchange";return c.requestFullscreen?b={enterK:"requestFullscreen",exitK:"exitFullscreen",elementK:"fullscreenElement",eventK:d}:c.mozRequestFullScreen?b={enterK:"mozRequestFullScreen",exitK:"mozCancelFullScreen",elementK:"mozFullScreenElement",eventK:"moz"+d}:c.webkitRequestFullscreen?b={enterK:"webkitRequestFullscreen",exitK:"webkitExitFullscreen",elementK:"webkitFullscreenElement",eventK:"webkit"+d}:c.msRequestFullscreen&&(b={enterK:"msRequestFullscreen",exitK:"msExitFullscreen",elementK:"msFullscreenElement",eventK:"MSFullscreenChange"}),b&&(b.enter=function(){return j=q.closeOnScroll,q.closeOnScroll=!1,"webkitRequestFullscreen"!==this.enterK?a.template[this.enterK]():void a.template[this.enterK](Element.ALLOW_KEYBOARD_INPUT)},b.exit=function(){return q.closeOnScroll=j,document[this.exitK]()},b.isFullscreen=function(){return document[this.elementK]}),b}};return a});
/*!-Before After*/
jQuery(document).ready(function($) {
	if($(".twentytwenty-container").length > 0){
		$.fn.twentytwenty = function(options) {
			var options = $.extend({
				default_offset_pct: 0.5,
				orientation: 'horizontal',
				navigation_follow: false
			}, options);
			return this.each(function() {

				var sliderPct = options.default_offset_pct;
				var container = $(this);
				var sliderOrientation = options.orientation;
				var beforeDirection = (sliderOrientation === 'vertical') ? 'down' : 'left';
				var afterDirection = (sliderOrientation === 'vertical') ? 'up' : 'right';
				var slideOnHover = options.navigation_follow;

				container.wrap("<div class='twentytwenty-wrapper twentytwenty-" + sliderOrientation + "'></div>");
				var beforeImg = container.find("img:first"),
					afterImg = container.find("img:last"),
					beforeImgAlt = beforeImg.attr("title"),
					afterImgAlt = afterImg.attr("title");
				container.append("<div class='twentytwenty-handle'></div>");
				var slider = container.find(".twentytwenty-handle");
				slider.append("<span class='twentytwenty-" + beforeDirection + "-arrow'></span>");
				slider.append("<span class='twentytwenty-" + afterDirection + "-arrow'></span>");
				container.addClass("twentytwenty-container");
				beforeImg.addClass("twentytwenty-before");
				afterImg.addClass("twentytwenty-after");
				if(typeof beforeImgAlt != 'undefined' && beforeImgAlt && beforeImgAlt.length > 0) {
					container.append("<div class='twentytwenty-before-label'>" + beforeImgAlt + "</div>");
				};
				if(typeof afterImgAlt != 'undefined' && afterImgAlt && afterImgAlt.length > 0) {
					container.append("<div class='twentytwenty-after-label'>" + afterImgAlt + "</div>");
				}

				var calcOffset = function(dimensionPct) {
					var w = beforeImg.width();
					var h = beforeImg.height();
					return {
						w: w+"px",
						h: h+"px",
						cw: (dimensionPct*w)+"px",
						ch: (dimensionPct*h)+"px"
					};
				};

				var adjustContainer = function(offset) {
					if (sliderOrientation === 'vertical') {
						beforeImg.css("clip", "rect(0,"+offset.w+","+offset.ch+",0)");
					}
					else {
						beforeImg.css("clip", "rect(0,"+offset.cw+","+offset.h+",0)");
					}
					container.css("height", offset.h);
				};

				var adjustSlider = function(pct) {
					var offset = calcOffset(pct);
					slider.css((sliderOrientation==="vertical") ? "top" : "left", (sliderOrientation==="vertical") ? offset.ch : offset.cw);
					adjustContainer(offset);
				};

				$(window).on("resize.twentytwenty", function(e) {
					adjustSlider(sliderPct);
				});

				var offsetX = 0;
				var imgWidth = 0;
				slider.on("movestart", function(e) {
					if (((e.distX > e.distY && e.distX < -e.distY) || (e.distX < e.distY && e.distX > -e.distY)) && sliderOrientation !== 'vertical') {
						e.preventDefault();
					}
					else if (((e.distX < e.distY && e.distX < -e.distY) || (e.distX > e.distY && e.distX > -e.distY)) && sliderOrientation === 'vertical') {
						e.preventDefault();
					}
					container.addClass("active");
					container.removeClass("active-click");
					offsetX = container.offset().left;
					offsetY = container.offset().top;
					imgWidth = beforeImg.width(); 
					imgHeight = beforeImg.height();
				});

				slider.on("moveend", function(e) {
					container.removeClass("active");
				});

				slider.on("move", function(e) {
					if (container.hasClass("active")) {
						sliderPct = (sliderOrientation === 'vertical') ? (e.pageY-offsetY)/imgHeight : (e.pageX-offsetX)/imgWidth;
						if (sliderPct < 0) {
							sliderPct = 0;
						}
						if (sliderPct > 1) {
							sliderPct = 1;
						}
						adjustSlider(sliderPct);
					}
				});
				if (!slideOnHover && !container.hasClass("active")) {
					container.on("mouseup", function(e) {
						container.removeClass("active-click");
					});
					container.on("mousedown", function(e) {
						//container.addClass("active");
						container.addClass("active-click");
						offsetX = container.offset().left;
						offsetY = container.offset().top;
						imgWidth = beforeImg.width(); 
						imgHeight = beforeImg.height();
						sliderPct = (sliderOrientation === 'vertical') ? (e.pageY-offsetY)/imgHeight : (e.pageX-offsetX)/imgWidth;
						if (sliderPct < 0) {
							sliderPct = 0;
						}
						if (sliderPct > 1) {
							sliderPct = 1;
						}
						adjustSlider(sliderPct);
					});
				};

				container.find("img").on("mousedown", function(event) {
					event.preventDefault();
				});

				if (slideOnHover) {
					container.on("mouseenter", function (e) {
						container.addClass("active");
						offsetX = container.offset().left;
						offsetY = container.offset().top;
						imgWidth = beforeImg.width();
						imgHeight = beforeImg.height()
					});
					container.on("mouseleave", function (e) {
						container.removeClass("active")
					});
					container.on("mousemove", function (e) {
						if (container.hasClass("active")) {
							sliderPct = sliderOrientation === "vertical" ? (e.pageY - offsetY) / imgHeight : (e.pageX - offsetX) / imgWidth;
							if (sliderPct < 0) {
								sliderPct = 0
							}
							if (sliderPct > 1) {
								sliderPct = 1
							}
							adjustSlider(sliderPct)
						}
					});
				};

				$(window).trigger("resize.twentytwenty");
			});
		};
	}
});
jQuery(document).ready(function ($) {
	if (!('ontouchstart' in window) && (dtLocal.themeSettings.smoothScroll == "on" || dtLocal.themeSettings.smoothScroll == "on_parallax" && $(".stripe-parallax-bg").length > 0)) {
		$("body").css({"scroll-behavior" : "smooth"});
	}

});



/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

jQuery(document).ready(function ($) {
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		var fixTimeout;
		
		//get the starting position of each element to have parallax applied to it    
		$this.each(function(){
				firstTop = $this.offset().top;
		});

		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
			
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		
		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = dtGlobals.winScrollTop;        

			$this.each(function(){
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);

				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}

				$this.css('backgroundPosition', xpos + " " + Math.round((top - pos) * speedFactor) + "px");
			});
		}   

		$window.bind('scroll', update).resize(function() {
			update();
		}).bind("debouncedresize", function() {
			clearTimeout(fixTimeout);
			fixTimeout = setTimeout(function() {
				update();
			}, 20);
		});
		update();

	};
});


 /* !- Tooltip*/  
 function simple_tooltip(e,t){jQuery(e).each(function(e){jQuery("body").append("<div class='"+t+"' id='"+t+e+"'>"+jQuery(this).find("span.tooltip-c").html()+"</div>");var n=jQuery("#"+t+e);jQuery(this).removeAttr("title").mouseover(function(){n.css({opacity:1,display:"none"}).fadeIn(400)}).mousemove(function(e){var t=jQuery(window).scrollTop();var r=jQuery(window).width();var i;var s;var o=15;if(r-o*2>=n.width()+e.pageX){i=e.pageX+o}else{i=r-n.width()-o}if(t+o*2>=e.pageY-n.height()){s=t+o}else{s=e.pageY-n.height()-2.2*o}n.css({left:i,top:s})}).mouseout(function(){n.css({left:"-9999px"})})})}
 
/*
== malihu jquery custom scrollbar plugin == 
Version: 3.0.9 
Plugin URI: http://manos.malihu.gr/jquery-custom-content-scroller 
Author: malihu
Author URI: http://manos.malihu.gr
License: MIT License (MIT)
*/

/*
Copyright 2010 Manos Malihutsakis (email: manos@malihu.gr)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/*
The code below is fairly long, fully commented and should be normally used in development. 
For production, use either the minified jquery.mCustomScrollbar.min.js script or 
the production-ready jquery.mCustomScrollbar.concat.min.js which contains the plugin 
and dependencies (minified). 
*/

(function(factory){
	if(typeof module!=="undefined" && module.exports){
		module.exports=factory;
	}else{
		factory(jQuery,window,document);
	}
}(function($){
(function(init){
	/*! Copyright (c) 2013 Brandon Aaron (http://brandon.aaron.sh)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 3.1.12
 *
 * Requires: jQuery 1.2.2+
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a:a(jQuery)}(function(a){function b(b){var g=b||window.event,h=i.call(arguments,1),j=0,l=0,m=0,n=0,o=0,p=0;if(b=a.event.fix(g),b.type="mousewheel","detail"in g&&(m=-1*g.detail),"wheelDelta"in g&&(m=g.wheelDelta),"wheelDeltaY"in g&&(m=g.wheelDeltaY),"wheelDeltaX"in g&&(l=-1*g.wheelDeltaX),"axis"in g&&g.axis===g.HORIZONTAL_AXIS&&(l=-1*m,m=0),j=0===m?l:m,"deltaY"in g&&(m=-1*g.deltaY,j=m),"deltaX"in g&&(l=g.deltaX,0===m&&(j=-1*l)),0!==m||0!==l){if(1===g.deltaMode){var q=a.data(this,"mousewheel-line-height");j*=q,m*=q,l*=q}else if(2===g.deltaMode){var r=a.data(this,"mousewheel-page-height");j*=r,m*=r,l*=r}if(n=Math.max(Math.abs(m),Math.abs(l)),(!f||f>n)&&(f=n,d(g,n)&&(f/=40)),d(g,n)&&(j/=40,l/=40,m/=40),j=Math[j>=1?"floor":"ceil"](j/f),l=Math[l>=1?"floor":"ceil"](l/f),m=Math[m>=1?"floor":"ceil"](m/f),k.settings.normalizeOffset&&this.getBoundingClientRect){var s=this.getBoundingClientRect();o=b.clientX-s.left,p=b.clientY-s.top}return b.deltaX=l,b.deltaY=m,b.deltaFactor=f,b.offsetX=o,b.offsetY=p,b.deltaMode=0,h.unshift(b,j,l,m),e&&clearTimeout(e),e=setTimeout(c,200),(a.event.dispatch||a.event.handle).apply(this,h)}}function c(){f=null}function d(a,b){return k.settings.adjustOldDeltas&&"mousewheel"===a.type&&b%120===0}var e,f,g=["wheel","mousewheel","DOMMouseScroll","MozMousePixelScroll"],h="onwheel"in document||document.documentMode>=9?["wheel"]:["mousewheel","DomMouseScroll","MozMousePixelScroll"],i=Array.prototype.slice;if(a.event.fixHooks)for(var j=g.length;j;)a.event.fixHooks[g[--j]]=a.event.mouseHooks;var k=a.event.special.mousewheel={version:"3.1.12",setup:function(){if(this.addEventListener)for(var c=h.length;c;)this.addEventListener(h[--c],b,!1);else this.onmousewheel=b;a.data(this,"mousewheel-line-height",k.getLineHeight(this)),a.data(this,"mousewheel-page-height",k.getPageHeight(this))},teardown:function(){if(this.removeEventListener)for(var c=h.length;c;)this.removeEventListener(h[--c],b,!1);else this.onmousewheel=null;a.removeData(this,"mousewheel-line-height"),a.removeData(this,"mousewheel-page-height")},getLineHeight:function(b){var c=a(b),d=c["offsetParent"in a.fn?"offsetParent":"parent"]();return d.length||(d=a("body")),parseInt(d.css("fontSize"),10)||parseInt(c.css("fontSize"),10)||16},getPageHeight:function(b){return a(b).height()},settings:{adjustOldDeltas:!0,normalizeOffset:!0}};a.fn.extend({mousewheel:function(a){return a?this.bind("mousewheel",a):this.trigger("mousewheel")},unmousewheel:function(a){return this.unbind("mousewheel",a)}})});
	init();
}(function(){
	
	/* 
	----------------------------------------
	PLUGIN NAMESPACE, PREFIX, DEFAULT SELECTOR(S) 
	----------------------------------------
	*/
	
	var pluginNS="mCustomScrollbar",
		pluginPfx="mCS",
		defaultSelector=".mCustomScrollbar",
	
	
		
	
	
	/* 
	----------------------------------------
	DEFAULT OPTIONS 
	----------------------------------------
	*/
	
		defaults={
			/*
			set element/content width/height programmatically 
			values: boolean, pixels, percentage 
				option						default
				-------------------------------------
				setWidth					false
				setHeight					false
			*/
			/*
			set the initial css top property of content  
			values: string (e.g. "-100px", "10%" etc.)
			*/
			setTop:0,
			/*
			set the initial css left property of content  
			values: string (e.g. "-100px", "10%" etc.)
			*/
			setLeft:0,
			/* 
			scrollbar axis (vertical and/or horizontal scrollbars) 
			values (string): "y", "x", "yx"
			*/
			axis:"y",
			/*
			position of scrollbar relative to content  
			values (string): "inside", "outside" ("outside" requires elements with position:relative)
			*/
			scrollbarPosition:"inside",
			/*
			scrolling inertia
			values: integer (milliseconds)
			*/
			scrollInertia:950,
			/* 
			auto-adjust scrollbar dragger length
			values: boolean
			*/
			autoDraggerLength:true,
			/*
			auto-hide scrollbar when idle 
			values: boolean
				option						default
				-------------------------------------
				autoHideScrollbar			false
			*/
			/*
			auto-expands scrollbar on mouse-over and dragging
			values: boolean
				option						default
				-------------------------------------
				autoExpandScrollbar			false
			*/
			/*
			always show scrollbar, even when there's nothing to scroll 
			values: integer (0=disable, 1=always show dragger rail and buttons, 2=always show dragger rail, dragger and buttons), boolean
			*/
			alwaysShowScrollbar:0,
			/*
			scrolling always snaps to a multiple of this number in pixels
			values: integer
				option						default
				-------------------------------------
				snapAmount					null
			*/
			/*
			when snapping, snap with this number in pixels as an offset 
			values: integer
			*/
			snapOffset:0,
			/* 
			mouse-wheel scrolling
			*/
			mouseWheel:{
				/* 
				enable mouse-wheel scrolling
				values: boolean
				*/
				enable:true,
				/* 
				scrolling amount in pixels
				values: "auto", integer 
				*/
				scrollAmount:"auto",
				/* 
				mouse-wheel scrolling axis 
				the default scrolling direction when both vertical and horizontal scrollbars are present 
				values (string): "y", "x" 
				*/
				axis:"y",
				/* 
				prevent the default behaviour which automatically scrolls the parent element(s) when end of scrolling is reached 
				values: boolean
					option						default
					-------------------------------------
					preventDefault				null
				*/
				/*
				the reported mouse-wheel delta value. The number of lines (translated to pixels) one wheel notch scrolls.  
				values: "auto", integer 
				"auto" uses the default OS/browser value 
				*/
				deltaFactor:"auto",
				/*
				normalize mouse-wheel delta to -1 or 1 (disables mouse-wheel acceleration) 
				values: boolean
					option						default
					-------------------------------------
					normalizeDelta				null
				*/
				/*
				invert mouse-wheel scrolling direction 
				values: boolean
					option						default
					-------------------------------------
					invert						null
				*/
				/*
				the tags that disable mouse-wheel when cursor is over them
				*/
				disableOver:["select","option","keygen","datalist","textarea"]
			},
			/* 
			scrollbar buttons
			*/
			scrollButtons:{ 
				/*
				enable scrollbar buttons
				values: boolean
					option						default
					-------------------------------------
					enable						null
				*/
				/*
				scrollbar buttons scrolling type 
				values (string): "stepless", "stepped"
				*/
				scrollType:"stepless",
				/*
				scrolling amount in pixels
				values: "auto", integer 
				*/
				scrollAmount:"auto"
				/*
				tabindex of the scrollbar buttons
				values: false, integer
					option						default
					-------------------------------------
					tabindex					null
				*/
			},
			/* 
			keyboard scrolling
			*/
			keyboard:{ 
				/*
				enable scrolling via keyboard
				values: boolean
				*/
				enable:true,
				/*
				keyboard scrolling type 
				values (string): "stepless", "stepped"
				*/
				scrollType:"stepless",
				/*
				scrolling amount in pixels
				values: "auto", integer 
				*/
				scrollAmount:"auto"
			},
			/*
			enable content touch-swipe scrolling 
			values: boolean, integer, string (number)
			integer values define the axis-specific minimum amount required for scrolling momentum
			*/
			contentTouchScroll:25,
			/*
			advanced option parameters
			*/
			advanced:{
				/*
				auto-expand content horizontally (for "x" or "yx" axis) 
				values: boolean
					option						default
					-------------------------------------
					autoExpandHorizontalScroll	null
				*/
				/*
				auto-scroll to elements with focus
				*/
				autoScrollOnFocus:"input,textarea,select,button,datalist,keygen,a[tabindex],area,object,[contenteditable='true']",
				/*
				auto-update scrollbars on content, element or viewport resize 
				should be true for fluid layouts/elements, adding/removing content dynamically, hiding/showing elements, content with images etc. 
				values: boolean
				*/
				updateOnContentResize:true,
				/*
				auto-update scrollbars each time each image inside the element is fully loaded 
				values: boolean
				*/
				updateOnImageLoad:true,
				/*
				auto-update scrollbars based on the amount and size changes of specific selectors 
				useful when you need to update the scrollbar(s) automatically, each time a type of element is added, removed or changes its size 
				values: boolean, string (e.g. "ul li" will auto-update scrollbars each time list-items inside the element are changed) 
				a value of true (boolean) will auto-update scrollbars each time any element is changed
					option						default
					-------------------------------------
					updateOnSelectorChange		null
				*/
				/*
				extra selectors that'll release scrollbar dragging upon mouseup, pointerup, touchend etc. (e.g. "selector-1, selector-2")
					option						default
					-------------------------------------
					releaseDraggableSelectors	null
				*/
				/*
				auto-update timeout 
				values: integer (milliseconds)
				*/
				autoUpdateTimeout:60
			},
			/* 
			scrollbar theme 
			values: string (see CSS/plugin URI for a list of ready-to-use themes)
			*/
			theme:"light",
			/*
			user defined callback functions
			*/
			callbacks:{
				/*
				Available callbacks: 
					callback					default
					-------------------------------------
					onInit						null
					onScrollStart				null
					onScroll					null
					onTotalScroll				null
					onTotalScrollBack			null
					whileScrolling				null
					onOverflowY					null
					onOverflowX					null
					onOverflowYNone				null
					onOverflowXNone				null
					onImageLoad					null
					onSelectorChange			null
					onUpdate					null
				*/
				onTotalScrollOffset:0,
				onTotalScrollBackOffset:0,
				alwaysTriggerOffsets:true
			}
			/*
			add scrollbar(s) on all elements matching the current selector, now and in the future 
			values: boolean, string 
			string values: "on" (enable), "once" (disable after first invocation), "off" (disable)
			liveSelector values: string (selector)
				option						default
				-------------------------------------
				live						false
				liveSelector				null
			*/
		},
	
	
	
	
	
	/* 
	----------------------------------------
	VARS, CONSTANTS 
	----------------------------------------
	*/
	
		totalInstances=0, /* plugin instances amount */
		liveTimers={}, /* live option timers */
		oldIE=(window.attachEvent && !window.addEventListener) ? 1 : 0, /* detect IE < 9 */
		touchActive=false,touchable, /* global touch vars (for touch and pointer events) */
		/* general plugin classes */
		classes=[
			"mCSB_dragger_onDrag","mCSB_scrollTools_onDrag","mCS_img_loaded","mCS_disabled","mCS_destroyed","mCS_no_scrollbar",
			"mCS-autoHide","mCS-dir-rtl","mCS_no_scrollbar_y","mCS_no_scrollbar_x","mCS_y_hidden","mCS_x_hidden","mCSB_draggerContainer",
			"mCSB_buttonUp","mCSB_buttonDown","mCSB_buttonLeft","mCSB_buttonRight"
		],
		
	
	
	
	
	/* 
	----------------------------------------
	METHODS 
	----------------------------------------
	*/
	
		methods={
			
			/* 
			plugin initialization method 
			creates the scrollbar(s), plugin data object and options
			----------------------------------------
			*/
			
			init:function(options){
				
				var options=$.extend(true,{},defaults,options),
					selector=_selector.call(this); /* validate selector */
				
				/* 
				if live option is enabled, monitor for elements matching the current selector and 
				apply scrollbar(s) when found (now and in the future) 
				*/
				if(options.live){
					var liveSelector=options.liveSelector || this.selector || defaultSelector, /* live selector(s) */
						$liveSelector=$(liveSelector); /* live selector(s) as jquery object */
					if(options.live==="off"){
						/* 
						disable live if requested 
						usage: $(selector).mCustomScrollbar({live:"off"}); 
						*/
						removeLiveTimers(liveSelector);
						return;
					}
					liveTimers[liveSelector]=setTimeout(function(){
						/* call mCustomScrollbar fn on live selector(s) every half-second */
						$liveSelector.mCustomScrollbar(options);
						if(options.live==="once" && $liveSelector.length){
							/* disable live after first invocation */
							removeLiveTimers(liveSelector);
						}
					},500);
				}else{
					removeLiveTimers(liveSelector);
				}
				
				/* options backward compatibility (for versions < 3.0.0) and normalization */
				options.setWidth=(options.set_width) ? options.set_width : options.setWidth;
				options.setHeight=(options.set_height) ? options.set_height : options.setHeight;
				options.axis=(options.horizontalScroll) ? "x" : _findAxis(options.axis);
				options.scrollInertia=options.scrollInertia>0 && options.scrollInertia<17 ? 17 : options.scrollInertia;
				if(typeof options.mouseWheel!=="object" &&  options.mouseWheel==true){ /* old school mouseWheel option (non-object) */
					options.mouseWheel={enable:true,scrollAmount:"auto",axis:"y",preventDefault:false,deltaFactor:"auto",normalizeDelta:false,invert:false}
				}
				options.mouseWheel.scrollAmount=!options.mouseWheelPixels ? options.mouseWheel.scrollAmount : options.mouseWheelPixels;
				options.mouseWheel.normalizeDelta=!options.advanced.normalizeMouseWheelDelta ? options.mouseWheel.normalizeDelta : options.advanced.normalizeMouseWheelDelta;
				options.scrollButtons.scrollType=_findScrollButtonsType(options.scrollButtons.scrollType); 
				
				_theme(options); /* theme-specific options */
				
				/* plugin constructor */
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if(!$this.data(pluginPfx)){ /* prevent multiple instantiations */
					
						/* store options and create objects in jquery data */
						$this.data(pluginPfx,{
							idx:++totalInstances, /* instance index */
							opt:options, /* options */
							scrollRatio:{y:null,x:null}, /* scrollbar to content ratio */
							overflowed:null, /* overflowed axis */
							contentReset:{y:null,x:null}, /* object to check when content resets */
							bindEvents:false, /* object to check if events are bound */
							tweenRunning:false, /* object to check if tween is running */
							sequential:{}, /* sequential scrolling object */
							langDir:$this.css("direction"), /* detect/store direction (ltr or rtl) */
							cbOffsets:null, /* object to check whether callback offsets always trigger */
							/* 
							object to check how scrolling events where last triggered 
							"internal" (default - triggered by this script), "external" (triggered by other scripts, e.g. via scrollTo method) 
							usage: object.data("mCS").trigger
							*/
							trigger:null
						});
						
						var d=$this.data(pluginPfx),o=d.opt,
							/* HTML data attributes */
							htmlDataAxis=$this.data("mcs-axis"),htmlDataSbPos=$this.data("mcs-scrollbar-position"),htmlDataTheme=$this.data("mcs-theme");
						 
						if(htmlDataAxis){o.axis=htmlDataAxis;} /* usage example: data-mcs-axis="y" */
						if(htmlDataSbPos){o.scrollbarPosition=htmlDataSbPos;} /* usage example: data-mcs-scrollbar-position="outside" */
						if(htmlDataTheme){ /* usage example: data-mcs-theme="minimal" */
							o.theme=htmlDataTheme;
							_theme(o); /* theme-specific options */
						}
						
						_pluginMarkup.call(this); /* add plugin markup */
						
						$("#mCSB_"+d.idx+"_container img:not(."+classes[2]+")").addClass(classes[2]); /* flag loaded images */
						
						methods.update.call(null,$this); /* call the update method */
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/* 
			plugin update method 
			updates content and scrollbar(s) values, events and status 
			----------------------------------------
			usage: $(selector).mCustomScrollbar("update");
			*/
			
			update:function(el,cb){
				
				var selector=el || _selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
						
						var d=$this.data(pluginPfx),o=d.opt,
							mCSB_container=$("#mCSB_"+d.idx+"_container"),
							mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")];
						
						if(!mCSB_container.length){return;}
						
						if(d.tweenRunning){_stop($this);} /* stop any running tweens while updating */
						
						/* if element was disabled or destroyed, remove class(es) */
						if($this.hasClass(classes[3])){$this.removeClass(classes[3]);}
						if($this.hasClass(classes[4])){$this.removeClass(classes[4]);}
						
						_maxHeight.call(this); /* detect/set css max-height value */
						
						_expandContentHorizontally.call(this); /* expand content horizontally */
						
						if(o.axis!=="y" && !o.advanced.autoExpandHorizontalScroll){
							mCSB_container.css("width",_contentWidth(mCSB_container.children()));
						}
						
						d.overflowed=_overflowed.call(this); /* determine if scrolling is required */
						
						_scrollbarVisibility.call(this); /* show/hide scrollbar(s) */
						
						/* auto-adjust scrollbar dragger length analogous to content */
						if(o.autoDraggerLength){_setDraggerLength.call(this);}
						
						_scrollRatio.call(this); /* calculate and store scrollbar to content ratio */
						
						_bindEvents.call(this); /* bind scrollbar events */
						
						/* reset scrolling position and/or events */
						var to=[Math.abs(mCSB_container[0].offsetTop),Math.abs(mCSB_container[0].offsetLeft)];
						if(o.axis!=="x"){ /* y/yx axis */
							if(!d.overflowed[0]){ /* y scrolling is not required */
								_resetContentPosition.call(this); /* reset content position */
								if(o.axis==="y"){
									_unbindEvents.call(this);
								}else if(o.axis==="yx" && d.overflowed[1]){
									_scrollTo($this,to[1].toString(),{dir:"x",dur:0,overwrite:"none"});
								}
							}else if(mCSB_dragger[0].height()>mCSB_dragger[0].parent().height()){
								_resetContentPosition.call(this); /* reset content position */
							}else{ /* y scrolling is required */
								_scrollTo($this,to[0].toString(),{dir:"y",dur:0,overwrite:"none"});
								d.contentReset.y=null;
							}
						}
						if(o.axis!=="y"){ /* x/yx axis */
							if(!d.overflowed[1]){ /* x scrolling is not required */
								_resetContentPosition.call(this); /* reset content position */
								if(o.axis==="x"){
									_unbindEvents.call(this);
								}else if(o.axis==="yx" && d.overflowed[0]){
									_scrollTo($this,to[0].toString(),{dir:"y",dur:0,overwrite:"none"});
								}
							}else if(mCSB_dragger[1].width()>mCSB_dragger[1].parent().width()){
								_resetContentPosition.call(this); /* reset content position */
							}else{ /* x scrolling is required */
								_scrollTo($this,to[1].toString(),{dir:"x",dur:0,overwrite:"none"});
								d.contentReset.x=null;
							}
						}
						
						/* callbacks: onImageLoad, onSelectorChange, onUpdate */
						if(cb && d){
							if(cb===2 && o.callbacks.onImageLoad && typeof o.callbacks.onImageLoad==="function"){
								o.callbacks.onImageLoad.call(this);
							}else if(cb===3 && o.callbacks.onSelectorChange && typeof o.callbacks.onSelectorChange==="function"){
								o.callbacks.onSelectorChange.call(this);
							}else if(o.callbacks.onUpdate && typeof o.callbacks.onUpdate==="function"){
								o.callbacks.onUpdate.call(this);
							}
						}
						
						_autoUpdate.call(this); /* initialize automatic updating (for dynamic content, fluid layouts etc.) */
						
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/* 
			plugin scrollTo method 
			triggers a scrolling event to a specific value
			----------------------------------------
			usage: $(selector).mCustomScrollbar("scrollTo",value,options);
			*/
		
			scrollTo:function(val,options){
				
				/* prevent silly things like $(selector).mCustomScrollbar("scrollTo",undefined); */
				if(typeof val=="undefined" || val==null){return;}
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
					
						var d=$this.data(pluginPfx),o=d.opt,
							/* method default options */
							methodDefaults={
								trigger:"external", /* method is by default triggered externally (e.g. from other scripts) */
								scrollInertia:o.scrollInertia, /* scrolling inertia (animation duration) */
								scrollEasing:"mcsEaseInOut", /* animation easing */
								moveDragger:false, /* move dragger instead of content */
								timeout:60, /* scroll-to delay */
								callbacks:true, /* enable/disable callbacks */
								onStart:true,
								onUpdate:true,
								onComplete:true
							},
							methodOptions=$.extend(true,{},methodDefaults,options),
							to=_arr.call(this,val),dur=methodOptions.scrollInertia>0 && methodOptions.scrollInertia<17 ? 17 : methodOptions.scrollInertia;
						
						/* translate yx values to actual scroll-to positions */
						to[0]=_to.call(this,to[0],"y");
						to[1]=_to.call(this,to[1],"x");
						
						/* 
						check if scroll-to value moves the dragger instead of content. 
						Only pixel values apply on dragger (e.g. 100, "100px", "-=100" etc.) 
						*/
						if(methodOptions.moveDragger){
							to[0]*=d.scrollRatio.y;
							to[1]*=d.scrollRatio.x;
						}
						
						methodOptions.dur=dur;
						
						setTimeout(function(){ 
							/* do the scrolling */
							if(to[0]!==null && typeof to[0]!=="undefined" && o.axis!=="x" && d.overflowed[0]){ /* scroll y */
								methodOptions.dir="y";
								methodOptions.overwrite="all";
								_scrollTo($this,to[0].toString(),methodOptions);
							}
							if(to[1]!==null && typeof to[1]!=="undefined" && o.axis!=="y" && d.overflowed[1]){ /* scroll x */
								methodOptions.dir="x";
								methodOptions.overwrite="none";
								_scrollTo($this,to[1].toString(),methodOptions);
							}
						},methodOptions.timeout);
						
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin stop method 
			stops scrolling animation
			----------------------------------------
			usage: $(selector).mCustomScrollbar("stop");
			*/
			stop:function(){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
										
						_stop($this);
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin disable method 
			temporarily disables the scrollbar(s) 
			----------------------------------------
			usage: $(selector).mCustomScrollbar("disable",reset); 
			reset (boolean): resets content position to 0 
			*/
			disable:function(r){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
						
						var d=$this.data(pluginPfx);
						
						_autoUpdate.call(this,"remove"); /* remove automatic updating */
						
						_unbindEvents.call(this); /* unbind events */
						
						if(r){_resetContentPosition.call(this);} /* reset content position */
						
						_scrollbarVisibility.call(this,true); /* show/hide scrollbar(s) */
						
						$this.addClass(classes[3]); /* add disable class */
					
					}
					
				});
				
			},
			/* ---------------------------------------- */
			
			
			
			/*
			plugin destroy method 
			completely removes the scrollbar(s) and returns the element to its original state
			----------------------------------------
			usage: $(selector).mCustomScrollbar("destroy"); 
			*/
			destroy:function(){
				
				var selector=_selector.call(this); /* validate selector */
				
				return $(selector).each(function(){
					
					var $this=$(this);
					
					if($this.data(pluginPfx)){ /* check if plugin has initialized */
					
						var d=$this.data(pluginPfx),o=d.opt,
							mCustomScrollBox=$("#mCSB_"+d.idx),
							mCSB_container=$("#mCSB_"+d.idx+"_container"),
							scrollbar=$(".mCSB_"+d.idx+"_scrollbar");
					
						if(o.live){removeLiveTimers(o.liveSelector || $(selector).selector);} /* remove live timers */
						
						_autoUpdate.call(this,"remove"); /* remove automatic updating */
						
						_unbindEvents.call(this); /* unbind events */
						
						_resetContentPosition.call(this); /* reset content position */
						
						$this.removeData(pluginPfx); /* remove plugin data object */
						
						_delete(this,"mcs"); /* delete callbacks object */
						
						/* remove plugin markup */
						scrollbar.remove(); /* remove scrollbar(s) first (those can be either inside or outside plugin's inner wrapper) */
						mCSB_container.find("img."+classes[2]).removeClass(classes[2]); /* remove loaded images flag */
						mCustomScrollBox.replaceWith(mCSB_container.contents()); /* replace plugin's inner wrapper with the original content */
						/* remove plugin classes from the element and add destroy class */
						$this.removeClass(pluginNS+" _"+pluginPfx+"_"+d.idx+" "+classes[6]+" "+classes[7]+" "+classes[5]+" "+classes[3]).addClass(classes[4]);
					
					}
					
				});
				
			}
			/* ---------------------------------------- */
			
		},
	
	
	
	
		
	/* 
	----------------------------------------
	FUNCTIONS
	----------------------------------------
	*/
	
		/* validates selector (if selector is invalid or undefined uses the default one) */
		_selector=function(){
			return (typeof $(this)!=="object" || $(this).length<1) ? defaultSelector : this;
		},
		/* -------------------- */
		
		
		/* changes options according to theme */
		_theme=function(obj){
			var fixedSizeScrollbarThemes=["rounded","rounded-dark","rounded-dots","rounded-dots-dark"],
				nonExpandedScrollbarThemes=["rounded-dots","rounded-dots-dark","3d","3d-dark","3d-thick","3d-thick-dark","inset","inset-dark","inset-2","inset-2-dark","inset-3","inset-3-dark"],
				disabledScrollButtonsThemes=["minimal","minimal-dark"],
				enabledAutoHideScrollbarThemes=["minimal","minimal-dark"],
				scrollbarPositionOutsideThemes=["minimal","minimal-dark"];
			obj.autoDraggerLength=$.inArray(obj.theme,fixedSizeScrollbarThemes) > -1 ? false : obj.autoDraggerLength;
			obj.autoExpandScrollbar=$.inArray(obj.theme,nonExpandedScrollbarThemes) > -1 ? false : obj.autoExpandScrollbar;
			obj.scrollButtons.enable=$.inArray(obj.theme,disabledScrollButtonsThemes) > -1 ? false : obj.scrollButtons.enable;
			obj.autoHideScrollbar=$.inArray(obj.theme,enabledAutoHideScrollbarThemes) > -1 ? true : obj.autoHideScrollbar;
			obj.scrollbarPosition=$.inArray(obj.theme,scrollbarPositionOutsideThemes) > -1 ? "outside" : obj.scrollbarPosition;
		},
		/* -------------------- */
		
		
		/* live option timers removal */
		removeLiveTimers=function(selector){
			if(liveTimers[selector]){
				clearTimeout(liveTimers[selector]);
				_delete(liveTimers,selector);
			}
		},
		/* -------------------- */
		
		
		/* normalizes axis option to valid values: "y", "x", "yx" */
		_findAxis=function(val){
			return (val==="yx" || val==="xy" || val==="auto") ? "yx" : (val==="x" || val==="horizontal") ? "x" : "y";
		},
		/* -------------------- */
		
		
		/* normalizes scrollButtons.scrollType option to valid values: "stepless", "stepped" */
		_findScrollButtonsType=function(val){
			return (val==="stepped" || val==="pixels" || val==="step" || val==="click") ? "stepped" : "stepless";
		},
		/* -------------------- */
		
		
		/* generates plugin markup */
		_pluginMarkup=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				expandClass=o.autoExpandScrollbar ? " "+classes[1]+"_expand" : "",
				scrollbar=["<div id='mCSB_"+d.idx+"_scrollbar_vertical' class='mCSB_scrollTools mCSB_"+d.idx+"_scrollbar mCS-"+o.theme+" mCSB_scrollTools_vertical"+expandClass+"'><div class='"+classes[12]+"'><div id='mCSB_"+d.idx+"_dragger_vertical' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>","<div id='mCSB_"+d.idx+"_scrollbar_horizontal' class='mCSB_scrollTools mCSB_"+d.idx+"_scrollbar mCS-"+o.theme+" mCSB_scrollTools_horizontal"+expandClass+"'><div class='"+classes[12]+"'><div id='mCSB_"+d.idx+"_dragger_horizontal' class='mCSB_dragger' style='position:absolute;' oncontextmenu='return false;'><div class='mCSB_dragger_bar' /></div><div class='mCSB_draggerRail' /></div></div>"],
				wrapperClass=o.axis==="yx" ? "mCSB_vertical_horizontal" : o.axis==="x" ? "mCSB_horizontal" : "mCSB_vertical",
				scrollbars=o.axis==="yx" ? scrollbar[0]+scrollbar[1] : o.axis==="x" ? scrollbar[1] : scrollbar[0],
				contentWrapper=o.axis==="yx" ? "<div id='mCSB_"+d.idx+"_container_wrapper' class='mCSB_container_wrapper' />" : "",
				autoHideClass=o.autoHideScrollbar ? " "+classes[6] : "",
				scrollbarDirClass=(o.axis!=="x" && d.langDir==="rtl") ? " "+classes[7] : "";
			if(o.setWidth){$this.css("width",o.setWidth);} /* set element width */
			if(o.setHeight){$this.css("height",o.setHeight);} /* set element height */
			o.setLeft=(o.axis!=="y" && d.langDir==="rtl") ? "989999px" : o.setLeft; /* adjust left position for rtl direction */
			$this.addClass(pluginNS+" _"+pluginPfx+"_"+d.idx+autoHideClass+scrollbarDirClass).wrapInner("<div id='mCSB_"+d.idx+"' class='mCustomScrollBox mCS-"+o.theme+" "+wrapperClass+"'><div id='mCSB_"+d.idx+"_container' class='mCSB_container' style='position:relative; top:"+o.setTop+"; left:"+o.setLeft+";' dir="+d.langDir+" /></div>");
			var mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container");
			if(o.axis!=="y" && !o.advanced.autoExpandHorizontalScroll){
				mCSB_container.css("width",_contentWidth(mCSB_container.children()));
			}
			if(o.scrollbarPosition==="outside"){
				if($this.css("position")==="static"){ /* requires elements with non-static position */
					$this.css("position","relative");
				}
				$this.css("overflow","visible");
				mCustomScrollBox.addClass("mCSB_outside").after(scrollbars);
			}else{
				mCustomScrollBox.addClass("mCSB_inside").append(scrollbars);
				mCSB_container.wrap(contentWrapper);
			}
			_scrollButtons.call(this); /* add scrollbar buttons */
			/* minimum dragger length */
			var mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")];
			mCSB_dragger[0].css("min-height",mCSB_dragger[0].height());
			mCSB_dragger[1].css("min-width",mCSB_dragger[1].width());
		},
		/* -------------------- */
		
		
		/* calculates content width */
		_contentWidth=function(el){
			return Math.max.apply(Math,el.map(function(){return $(this).outerWidth(true);}).get());
		},
		/* -------------------- */
		
		
		/* expands content horizontally */
		_expandContentHorizontally=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mCSB_container=$("#mCSB_"+d.idx+"_container");
			if(o.advanced.autoExpandHorizontalScroll && o.axis!=="y"){
				/* 
				wrap content with an infinite width div and set its position to absolute and width to auto. 
				Setting width to auto before calculating the actual width is important! 
				We must let the browser set the width as browser zoom values are impossible to calculate.
				*/
				mCSB_container.css({"position":"absolute","width":"auto"})
					.wrap("<div class='mCSB_h_wrapper' style='position:relative; left:0; width:999999px;' />")
					.css({ /* set actual width, original position and un-wrap */
						/* 
						get the exact width (with decimals) and then round-up. 
						Using jquery outerWidth() will round the width value which will mess up with inner elements that have non-integer width
						*/
						"width":(Math.ceil(mCSB_container[0].getBoundingClientRect().right+0.4)-Math.floor(mCSB_container[0].getBoundingClientRect().left)),
						"position":"relative"
					}).unwrap();
			}
		},
		/* -------------------- */
		
		
		/* adds scrollbar buttons */
		_scrollButtons=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mCSB_scrollTools=$(".mCSB_"+d.idx+"_scrollbar:first"),
				tabindex=!_isNumeric(o.scrollButtons.tabindex) ? "" : "tabindex='"+o.scrollButtons.tabindex+"'",
				btnHTML=[
					"<a href='#' class='"+classes[13]+"' oncontextmenu='return false;' "+tabindex+" />",
					"<a href='#' class='"+classes[14]+"' oncontextmenu='return false;' "+tabindex+" />",
					"<a href='#' class='"+classes[15]+"' oncontextmenu='return false;' "+tabindex+" />",
					"<a href='#' class='"+classes[16]+"' oncontextmenu='return false;' "+tabindex+" />"
				],
				btn=[(o.axis==="x" ? btnHTML[2] : btnHTML[0]),(o.axis==="x" ? btnHTML[3] : btnHTML[1]),btnHTML[2],btnHTML[3]];
			if(o.scrollButtons.enable){
				mCSB_scrollTools.prepend(btn[0]).append(btn[1]).next(".mCSB_scrollTools").prepend(btn[2]).append(btn[3]);
			}
		},
		/* -------------------- */
		
		
		/* detects/sets css max-height value */
		_maxHeight=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mh=$this.css("max-height") || "none",pct=mh.indexOf("%")!==-1,
				bs=$this.css("box-sizing");
			if(mh!=="none"){
				var val=pct ? $this.parent().height()*parseInt(mh)/100 : parseInt(mh);
				/* if element's css box-sizing is "border-box", subtract any paddings and/or borders from max-height value */
				if(bs==="border-box"){val-=(($this.innerHeight()-$this.height())+($this.outerHeight()-$this.innerHeight()));}
				mCustomScrollBox.css("max-height",Math.round(val));
			}
		},
		/* -------------------- */
		
		
		/* auto-adjusts scrollbar dragger length */
		_setDraggerLength=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")],
				ratio=[mCustomScrollBox.height()/mCSB_container.outerHeight(false),mCustomScrollBox.width()/mCSB_container.outerWidth(false)],
				l=[
					parseInt(mCSB_dragger[0].css("min-height")),Math.round(ratio[0]*mCSB_dragger[0].parent().height()),
					parseInt(mCSB_dragger[1].css("min-width")),Math.round(ratio[1]*mCSB_dragger[1].parent().width())
				],
				h=oldIE && (l[1]<l[0]) ? l[0] : l[1],w=oldIE && (l[3]<l[2]) ? l[2] : l[3];
			mCSB_dragger[0].css({
				"height":h,"max-height":(mCSB_dragger[0].parent().height()-10)
			}).find(".mCSB_dragger_bar").css({"line-height":l[0]+"px"});
			mCSB_dragger[1].css({
				"width":w,"max-width":(mCSB_dragger[1].parent().width()-10)
			});
		},
		/* -------------------- */
		
		
		/* calculates scrollbar to content ratio */
		_scrollRatio=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")],
				scrollAmount=[mCSB_container.outerHeight(false)-mCustomScrollBox.height(),mCSB_container.outerWidth(false)-mCustomScrollBox.width()],
				ratio=[
					scrollAmount[0]/(mCSB_dragger[0].parent().height()-mCSB_dragger[0].height()),
					scrollAmount[1]/(mCSB_dragger[1].parent().width()-mCSB_dragger[1].width())
				];
			d.scrollRatio={y:ratio[0],x:ratio[1]};
		},
		/* -------------------- */
		
		
		/* toggles scrolling classes */
		_onDragClasses=function(el,action,xpnd){
			var expandClass=xpnd ? classes[0]+"_expanded" : "",
				scrollbar=el.closest(".mCSB_scrollTools");
			if(action==="active"){
				el.toggleClass(classes[0]+" "+expandClass); scrollbar.toggleClass(classes[1]); 
				el[0]._draggable=el[0]._draggable ? 0 : 1;
			}else{
				if(!el[0]._draggable){
					if(action==="hide"){
						el.removeClass(classes[0]); scrollbar.removeClass(classes[1]);
					}else{
						el.addClass(classes[0]); scrollbar.addClass(classes[1]);
					}
				}
			}
		},
		/* -------------------- */
		
		
		/* checks if content overflows its container to determine if scrolling is required */
		_overflowed=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				contentHeight=d.overflowed==null ? mCSB_container.height() : mCSB_container.outerHeight(false),
				contentWidth=d.overflowed==null ? mCSB_container.width() : mCSB_container.outerWidth(false);
			return [contentHeight>mCustomScrollBox.height(),contentWidth>mCustomScrollBox.width()];
		},
		/* -------------------- */
		
		
		/* resets content position to 0 */
		_resetContentPosition=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")];
			_stop($this); /* stop any current scrolling before resetting */
			if((o.axis!=="x" && !d.overflowed[0]) || (o.axis==="y" && d.overflowed[0])){ /* reset y */
				mCSB_dragger[0].add(mCSB_container).css("top",0);
				_scrollTo($this,"_resetY");
			}
			if((o.axis!=="y" && !d.overflowed[1]) || (o.axis==="x" && d.overflowed[1])){ /* reset x */
				var cx=dx=0;
				if(d.langDir==="rtl"){ /* adjust left position for rtl direction */
					cx=mCustomScrollBox.width()-mCSB_container.outerWidth(false);
					dx=Math.abs(cx/d.scrollRatio.x);
				}
				mCSB_container.css("left",cx);
				mCSB_dragger[1].css("left",dx);
				_scrollTo($this,"_resetX");
			}
		},
		/* -------------------- */
		
		
		/* binds scrollbar events */
		_bindEvents=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt;
			if(!d.bindEvents){ /* check if events are already bound */
				_draggable.call(this);
				if(o.contentTouchScroll){_contentDraggable.call(this);}
				_selectable.call(this);
				if(o.mouseWheel.enable){ /* bind mousewheel fn when plugin is available */
					function _mwt(){
						mousewheelTimeout=setTimeout(function(){
							if(!$.event.special.mousewheel){
								_mwt();
							}else{
								clearTimeout(mousewheelTimeout);
								_mousewheel.call($this[0]);
							}
						},100);
					}
					var mousewheelTimeout;
					_mwt();
				}
				_draggerRail.call(this);
				_wrapperScroll.call(this);
				if(o.advanced.autoScrollOnFocus){_focus.call(this);}
				if(o.scrollButtons.enable){_buttons.call(this);}
				if(o.keyboard.enable){_keyboard.call(this);}
				d.bindEvents=true;
			}
		},
		/* -------------------- */
		
		
		/* unbinds scrollbar events */
		_unbindEvents=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				sb=".mCSB_"+d.idx+"_scrollbar",
				sel=$("#mCSB_"+d.idx+",#mCSB_"+d.idx+"_container,#mCSB_"+d.idx+"_container_wrapper,"+sb+" ."+classes[12]+",#mCSB_"+d.idx+"_dragger_vertical,#mCSB_"+d.idx+"_dragger_horizontal,"+sb+">a"),
				mCSB_container=$("#mCSB_"+d.idx+"_container");
			if(o.advanced.releaseDraggableSelectors){sel.add($(o.advanced.releaseDraggableSelectors));}
			if(d.bindEvents){ /* check if events are bound */
				/* unbind namespaced events from document/selectors */
				$(document).unbind("."+namespace);
				sel.each(function(){
					$(this).unbind("."+namespace);
				});
				/* clear and delete timeouts/objects */
				clearTimeout($this[0]._focusTimeout); _delete($this[0],"_focusTimeout");
				clearTimeout(d.sequential.step); _delete(d.sequential,"step");
				clearTimeout(mCSB_container[0].onCompleteTimeout); _delete(mCSB_container[0],"onCompleteTimeout");
				d.bindEvents=false;
			}
		},
		/* -------------------- */
		
		
		/* toggles scrollbar visibility */
		_scrollbarVisibility=function(disabled){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				contentWrapper=$("#mCSB_"+d.idx+"_container_wrapper"),
				content=contentWrapper.length ? contentWrapper : $("#mCSB_"+d.idx+"_container"),
				scrollbar=[$("#mCSB_"+d.idx+"_scrollbar_vertical"),$("#mCSB_"+d.idx+"_scrollbar_horizontal")],
				mCSB_dragger=[scrollbar[0].find(".mCSB_dragger"),scrollbar[1].find(".mCSB_dragger")];
			if(o.axis!=="x"){
				if(d.overflowed[0] && !disabled){
					scrollbar[0].add(mCSB_dragger[0]).add(scrollbar[0].children("a")).css("display","block");
					content.removeClass(classes[8]+" "+classes[10]);
				}else{
					if(o.alwaysShowScrollbar){
						if(o.alwaysShowScrollbar!==2){mCSB_dragger[0].css("display","none");}
						content.removeClass(classes[10]);
					}else{
						scrollbar[0].css("display","none");
						content.addClass(classes[10]);
					}
					content.addClass(classes[8]);
				}
			}
			if(o.axis!=="y"){
				if(d.overflowed[1] && !disabled){
					scrollbar[1].add(mCSB_dragger[1]).add(scrollbar[1].children("a")).css("display","block");
					content.removeClass(classes[9]+" "+classes[11]);
				}else{
					if(o.alwaysShowScrollbar){
						if(o.alwaysShowScrollbar!==2){mCSB_dragger[1].css("display","none");}
						content.removeClass(classes[11]);
					}else{
						scrollbar[1].css("display","none");
						content.addClass(classes[11]);
					}
					content.addClass(classes[9]);
				}
			}
			if(!d.overflowed[0] && !d.overflowed[1]){
				$this.addClass(classes[5]);
			}else{
				$this.removeClass(classes[5]);
			}
		},
		/* -------------------- */
		
		
		/* returns input coordinates of pointer, touch and mouse events (relative to document) */
		_coordinates=function(e){
			var t=e.type;
			switch(t){
				case "pointerdown": case "MSPointerDown": case "pointermove": case "MSPointerMove": case "pointerup": case "MSPointerUp":
					return e.target.ownerDocument!==document ? [e.originalEvent.screenY,e.originalEvent.screenX,false] : [e.originalEvent.pageY,e.originalEvent.pageX,false];
					break;
				case "touchstart": case "touchmove": case "touchend":
					var touch=e.originalEvent.touches[0] || e.originalEvent.changedTouches[0],
						touches=e.originalEvent.touches.length || e.originalEvent.changedTouches.length;
					return e.target.ownerDocument!==document ? [touch.screenY,touch.screenX,touches>1] : [touch.pageY,touch.pageX,touches>1];
					break;
				default:
					return [e.pageY,e.pageX,false];
			}
		},
		/* -------------------- */
		
		
		/* 
		SCROLLBAR DRAG EVENTS
		scrolls content via scrollbar dragging 
		*/
		_draggable=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				draggerId=["mCSB_"+d.idx+"_dragger_vertical","mCSB_"+d.idx+"_dragger_horizontal"],
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				mCSB_dragger=$("#"+draggerId[0]+",#"+draggerId[1]),
				draggable,dragY,dragX,
				rds=o.advanced.releaseDraggableSelectors ? mCSB_dragger.add($(o.advanced.releaseDraggableSelectors)) : mCSB_dragger;
			mCSB_dragger.bind("mousedown."+namespace+" touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace,function(e){
				e.stopImmediatePropagation();
				e.preventDefault();
				if(!_mouseBtnLeft(e)){return;} /* left mouse button only */
				touchActive=true;
				if(oldIE){document.onselectstart=function(){return false;}} /* disable text selection for IE < 9 */
				_iframe(false); /* enable scrollbar dragging over iframes by disabling their events */
				_stop($this);
				draggable=$(this);
				var offset=draggable.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left,
					h=draggable.height()+offset.top,w=draggable.width()+offset.left;
				if(y<h && y>0 && x<w && x>0){
					dragY=y; 
					dragX=x;
				}
				_onDragClasses(draggable,"active",o.autoExpandScrollbar); 
			}).bind("touchmove."+namespace,function(e){
				e.stopImmediatePropagation();
				e.preventDefault();
				var offset=draggable.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left;
				_drag(dragY,dragX,y,x);
			});
			$(document).bind("mousemove."+namespace+" pointermove."+namespace+" MSPointerMove."+namespace,function(e){
				if(draggable){
					var offset=draggable.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left;
					if(dragY===y){return;} /* has it really moved? */
					_drag(dragY,dragX,y,x);
				}
			}).add(rds).bind("mouseup."+namespace+" touchend."+namespace+" pointerup."+namespace+" MSPointerUp."+namespace,function(e){
				if(draggable){
					_onDragClasses(draggable,"active",o.autoExpandScrollbar); 
					draggable=null;
				}
				touchActive=false;
				if(oldIE){document.onselectstart=null;} /* enable text selection for IE < 9 */
				_iframe(true); /* enable iframes events */
			});
			function _iframe(evt){
				var el=mCSB_container.find("iframe");
				if(!el.length){return;} /* check if content contains iframes */
				var val=!evt ? "none" : "auto";
				el.css("pointer-events",val); /* for IE11, iframe's display property should not be "block" */
			}
			function _drag(dragY,dragX,y,x){
				mCSB_container[0].idleTimer=o.scrollInertia<233 ? 250 : 0;
				if(draggable.attr("id")===draggerId[1]){
					var dir="x",to=((draggable[0].offsetLeft-dragX)+x)*d.scrollRatio.x;
				}else{
					var dir="y",to=((draggable[0].offsetTop-dragY)+y)*d.scrollRatio.y;
				}
				_scrollTo($this,to.toString(),{dir:dir,drag:true});
			}
		},
		/* -------------------- */
		
		
		/* 
		TOUCH SWIPE EVENTS
		scrolls content via touch swipe 
		Emulates the native touch-swipe scrolling with momentum found in iOS, Android and WP devices 
		*/
		_contentDraggable=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")],
				dragY,dragX,touchStartY,touchStartX,touchMoveY=[],touchMoveX=[],startTime,runningTime,endTime,distance,speed,amount,
				durA=0,durB,overwrite=o.axis==="yx" ? "none" : "all",touchIntent=[],touchDrag,docDrag,
				iframe=mCSB_container.find("iframe"),
				events=[
					"touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace, //start
					"touchmove."+namespace+" pointermove."+namespace+" MSPointerMove."+namespace, //move
					"touchend."+namespace+" pointerup."+namespace+" MSPointerUp."+namespace //end
				];
			mCSB_container.bind(events[0],function(e){
				_onTouchstart(e);
			}).bind(events[1],function(e){
				_onTouchmove(e);
			});
			mCustomScrollBox.bind(events[0],function(e){
				_onTouchstart2(e);
			}).bind(events[2],function(e){
				_onTouchend(e);
			});
			if(iframe.length){
				iframe.each(function(){
					$(this).load(function(){
						/* bind events on accessible iframes */
						if(_canAccessIFrame(this)){
							$(this.contentDocument || this.contentWindow.document).bind(events[0],function(e){
								_onTouchstart(e);
								_onTouchstart2(e);
							}).bind(events[1],function(e){
								_onTouchmove(e);
							}).bind(events[2],function(e){
								_onTouchend(e);
							});
						}
					});
				});
			}
			function _onTouchstart(e){
				if(!_pointerTouch(e) || touchActive || _coordinates(e)[2]){touchable=0; return;}
				touchable=1; touchDrag=0; docDrag=0;
				$this.removeClass("mCS_touch_action");
				var offset=mCSB_container.offset();
				dragY=_coordinates(e)[0]-offset.top;
				dragX=_coordinates(e)[1]-offset.left;
				touchIntent=[_coordinates(e)[0],_coordinates(e)[1]];
			}
			function _onTouchmove(e){
				if(!_pointerTouch(e) || touchActive || _coordinates(e)[2]){return;}
				e.stopImmediatePropagation();
				if(docDrag && !touchDrag){return;}
				runningTime=_getTime();
				var offset=mCustomScrollBox.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left,
					easing="mcsLinearOut";
				touchMoveY.push(y);
				touchMoveX.push(x);
				touchIntent[2]=Math.abs(_coordinates(e)[0]-touchIntent[0]); touchIntent[3]=Math.abs(_coordinates(e)[1]-touchIntent[1]);
				if(d.overflowed[0]){
					var limit=mCSB_dragger[0].parent().height()-mCSB_dragger[0].height(),
						prevent=((dragY-y)>0 && (y-dragY)>-(limit*d.scrollRatio.y) && (touchIntent[3]*2<touchIntent[2] || o.axis==="yx"));
				}
				if(d.overflowed[1]){
					var limitX=mCSB_dragger[1].parent().width()-mCSB_dragger[1].width(),
						preventX=((dragX-x)>0 && (x-dragX)>-(limitX*d.scrollRatio.x) && (touchIntent[2]*2<touchIntent[3] || o.axis==="yx"));
				}
				if(prevent || preventX){ /* prevent native document scrolling */
					e.preventDefault(); 
					touchDrag=1;
				}else{
					docDrag=1;
					$this.addClass("mCS_touch_action");
				}
				amount=o.axis==="yx" ? [(dragY-y),(dragX-x)] : o.axis==="x" ? [null,(dragX-x)] : [(dragY-y),null];
				mCSB_container[0].idleTimer=250;
				if(d.overflowed[0]){_drag(amount[0],durA,easing,"y","all",true);}
				if(d.overflowed[1]){_drag(amount[1],durA,easing,"x",overwrite,true);}
			}
			function _onTouchstart2(e){
				if(!_pointerTouch(e) || touchActive || _coordinates(e)[2]){touchable=0; return;}
				touchable=1;
				e.stopImmediatePropagation();
				_stop($this);
				startTime=_getTime();
				var offset=mCustomScrollBox.offset();
				touchStartY=_coordinates(e)[0]-offset.top;
				touchStartX=_coordinates(e)[1]-offset.left;
				touchMoveY=[]; touchMoveX=[];
			}
			function _onTouchend(e){
				if(!_pointerTouch(e) || touchActive || _coordinates(e)[2]){return;}
				e.stopImmediatePropagation();
				touchDrag=0; docDrag=0;
				endTime=_getTime();
				var offset=mCustomScrollBox.offset(),y=_coordinates(e)[0]-offset.top,x=_coordinates(e)[1]-offset.left;
				if((endTime-runningTime)>30){return;}
				speed=1000/(endTime-startTime);
				var easing="mcsEaseOut",slow=speed<2.5,
					diff=slow ? [touchMoveY[touchMoveY.length-2],touchMoveX[touchMoveX.length-2]] : [0,0];
				distance=slow ? [(y-diff[0]),(x-diff[1])] : [y-touchStartY,x-touchStartX];
				var absDistance=[Math.abs(distance[0]),Math.abs(distance[1])];
				speed=slow ? [Math.abs(distance[0]/4),Math.abs(distance[1]/4)] : [speed,speed];
				var a=[
					Math.abs(mCSB_container[0].offsetTop)-(distance[0]*_m((absDistance[0]/speed[0]),speed[0])),
					Math.abs(mCSB_container[0].offsetLeft)-(distance[1]*_m((absDistance[1]/speed[1]),speed[1]))
				];
				amount=o.axis==="yx" ? [a[0],a[1]] : o.axis==="x" ? [null,a[1]] : [a[0],null];
				durB=[(absDistance[0]*4)+o.scrollInertia,(absDistance[1]*4)+o.scrollInertia];
				var md=parseInt(o.contentTouchScroll) || 0; /* absolute minimum distance required */
				amount[0]=absDistance[0]>md ? amount[0] : 0;
				amount[1]=absDistance[1]>md ? amount[1] : 0;
				if(d.overflowed[0]){_drag(amount[0],durB[0],easing,"y",overwrite,false);}
				if(d.overflowed[1]){_drag(amount[1],durB[1],easing,"x",overwrite,false);}
			}
			function _m(ds,s){
				var r=[s*1.5,s*2,s/1.5,s/2];
				if(ds>90){
					return s>4 ? r[0] : r[3];
				}else if(ds>60){
					return s>3 ? r[3] : r[2];
				}else if(ds>30){
					return s>8 ? r[1] : s>6 ? r[0] : s>4 ? s : r[2];
				}else{
					return s>8 ? s : r[3];
				}
			}
			function _drag(amount,dur,easing,dir,overwrite,drag){
				if(!amount){return;}
				_scrollTo($this,amount.toString(),{dur:dur,scrollEasing:easing,dir:dir,overwrite:overwrite,drag:drag});
			}
		},
		/* -------------------- */
		
		
		/* 
		SELECT TEXT EVENTS 
		scrolls content when text is selected 
		*/
		_selectable=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,seq=d.sequential,
				namespace=pluginPfx+"_"+d.idx,
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent(),
				action;
			mCSB_container.bind("mousedown."+namespace,function(e){
				if(touchable){return;}
				if(!action){action=1; touchActive=true;}
			}).add(document).bind("mousemove."+namespace,function(e){
				if(!touchable && action && _sel()){
					var offset=mCSB_container.offset(),
						y=_coordinates(e)[0]-offset.top+mCSB_container[0].offsetTop,x=_coordinates(e)[1]-offset.left+mCSB_container[0].offsetLeft;
					if(y>0 && y<wrapper.height() && x>0 && x<wrapper.width()){
						if(seq.step){_seq("off",null,"stepped");}
					}else{
						if(o.axis!=="x" && d.overflowed[0]){
							if(y<0){
								_seq("on",38);
							}else if(y>wrapper.height()){
								_seq("on",40);
							}
						}
						if(o.axis!=="y" && d.overflowed[1]){
							if(x<0){
								_seq("on",37);
							}else if(x>wrapper.width()){
								_seq("on",39);
							}
						}
					}
				}
			}).bind("mouseup."+namespace,function(e){
				if(touchable){return;}
				if(action){action=0; _seq("off",null);}
				touchActive=false;
			});
			function _sel(){
				return 	window.getSelection ? window.getSelection().toString() : 
						document.selection && document.selection.type!="Control" ? document.selection.createRange().text : 0;
			}
			function _seq(a,c,s){
				seq.type=s && action ? "stepped" : "stepless";
				seq.scrollAmount=10;
				_sequentialScroll($this,a,c,"mcsLinearOut",s ? 60 : null);
			}
		},
		/* -------------------- */
		
		
		/* 
		MOUSE WHEEL EVENT
		scrolls content via mouse-wheel 
		via mouse-wheel plugin (https://github.com/brandonaaron/jquery-mousewheel)
		*/
		_mousewheel=function(){
			if(!$(this).data(pluginPfx)){return;} /* Check if the scrollbar is ready to use mousewheel events (issue: #185) */
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_dragger=[$("#mCSB_"+d.idx+"_dragger_vertical"),$("#mCSB_"+d.idx+"_dragger_horizontal")],
				iframe=$("#mCSB_"+d.idx+"_container").find("iframe");
			if(iframe.length){
				iframe.each(function(){
					$(this).load(function(){
						/* bind events on accessible iframes */
						if(_canAccessIFrame(this)){
							$(this.contentDocument || this.contentWindow.document).bind("mousewheel."+namespace,function(e,delta){
								_onMousewheel(e,delta);
							});
						}
					});
				});
			}
			mCustomScrollBox.bind("mousewheel."+namespace,function(e,delta){
				_onMousewheel(e,delta);
			});
			function _onMousewheel(e,delta){
				_stop($this);
				if(_disableMousewheel($this,e.target)){return;} /* disables mouse-wheel when hovering specific elements */
				var deltaFactor=o.mouseWheel.deltaFactor!=="auto" ? parseInt(o.mouseWheel.deltaFactor) : (oldIE && e.deltaFactor<100) ? 100 : e.deltaFactor || 100;
				if(o.axis==="x" || o.mouseWheel.axis==="x"){
					var dir="x",
						px=[Math.round(deltaFactor*d.scrollRatio.x),parseInt(o.mouseWheel.scrollAmount)],
						amount=o.mouseWheel.scrollAmount!=="auto" ? px[1] : px[0]>=mCustomScrollBox.width() ? mCustomScrollBox.width()*0.9 : px[0],
						contentPos=Math.abs($("#mCSB_"+d.idx+"_container")[0].offsetLeft),
						draggerPos=mCSB_dragger[1][0].offsetLeft,
						limit=mCSB_dragger[1].parent().width()-mCSB_dragger[1].width(),
						dlt=e.deltaX || e.deltaY || delta;
				}else{
					var dir="y",
						px=[Math.round(deltaFactor*d.scrollRatio.y),parseInt(o.mouseWheel.scrollAmount)],
						amount=o.mouseWheel.scrollAmount!=="auto" ? px[1] : px[0]>=mCustomScrollBox.height() ? mCustomScrollBox.height()*0.9 : px[0],
						contentPos=Math.abs($("#mCSB_"+d.idx+"_container")[0].offsetTop),
						draggerPos=mCSB_dragger[0][0].offsetTop,
						limit=mCSB_dragger[0].parent().height()-mCSB_dragger[0].height(),
						dlt=e.deltaY || delta;
				}
				if((dir==="y" && !d.overflowed[0]) || (dir==="x" && !d.overflowed[1])){return;}
				if(o.mouseWheel.invert || e.webkitDirectionInvertedFromDevice){dlt=-dlt;}
				if(o.mouseWheel.normalizeDelta){dlt=dlt<0 ? -1 : 1;}
				if((dlt>0 && draggerPos!==0) || (dlt<0 && draggerPos!==limit) || o.mouseWheel.preventDefault){
					e.stopImmediatePropagation();
					e.preventDefault();
				}
				_scrollTo($this,(contentPos-(dlt*amount)).toString(),{dir:dir});
			}
		},
		/* -------------------- */
		
		
		/* checks if iframe can be accessed */
		_canAccessIFrame=function(iframe){
			var html=null;
			try{
				var doc=iframe.contentDocument || iframe.contentWindow.document;
				html=doc.body.innerHTML;
			}catch(err){/* do nothing */}
			return(html!==null);
		},
		/* -------------------- */
		
		
		/* disables mouse-wheel when hovering specific elements like select, datalist etc. */
		_disableMousewheel=function(el,target){
			var tag=target.nodeName.toLowerCase(),
				tags=el.data(pluginPfx).opt.mouseWheel.disableOver,
				/* elements that require focus */
				focusTags=["select","textarea"];
			return $.inArray(tag,tags) > -1 && !($.inArray(tag,focusTags) > -1 && !$(target).is(":focus"));
		},
		/* -------------------- */
		
		
		/* 
		DRAGGER RAIL CLICK EVENT
		scrolls content via dragger rail 
		*/
		_draggerRail=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				namespace=pluginPfx+"_"+d.idx,
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent(),
				mCSB_draggerContainer=$(".mCSB_"+d.idx+"_scrollbar ."+classes[12]);
			mCSB_draggerContainer.bind("touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace,function(e){
				touchActive=true;
			}).bind("touchend."+namespace+" pointerup."+namespace+" MSPointerUp."+namespace,function(e){
				touchActive=false;
			}).bind("click."+namespace,function(e){
				if($(e.target).hasClass(classes[12]) || $(e.target).hasClass("mCSB_draggerRail")){
					_stop($this);
					var el=$(this),mCSB_dragger=el.find(".mCSB_dragger");
					if(el.parent(".mCSB_scrollTools_horizontal").length>0){
						if(!d.overflowed[1]){return;}
						var dir="x",
							clickDir=e.pageX>mCSB_dragger.offset().left ? -1 : 1,
							to=Math.abs(mCSB_container[0].offsetLeft)-(clickDir*(wrapper.width()*0.9));
					}else{
						if(!d.overflowed[0]){return;}
						var dir="y",
							clickDir=e.pageY>mCSB_dragger.offset().top ? -1 : 1,
							to=Math.abs(mCSB_container[0].offsetTop)-(clickDir*(wrapper.height()*0.9));
					}
					_scrollTo($this,to.toString(),{dir:dir,scrollEasing:"mcsEaseInOut"});
				}
			});
		},
		/* -------------------- */
		
		
		/* 
		FOCUS EVENT
		scrolls content via element focus (e.g. clicking an input, pressing TAB key etc.)
		*/
		_focus=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				namespace=pluginPfx+"_"+d.idx,
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent();
			mCSB_container.bind("focusin."+namespace,function(e){
				var el=$(document.activeElement),
					nested=mCSB_container.find(".mCustomScrollBox").length,
					dur=0;
				if(!el.is(o.advanced.autoScrollOnFocus)){return;}
				_stop($this);
				clearTimeout($this[0]._focusTimeout);
				$this[0]._focusTimer=nested ? (dur+17)*nested : 0;
				$this[0]._focusTimeout=setTimeout(function(){
					var	to=[_childPos(el)[0],_childPos(el)[1]],
						contentPos=[mCSB_container[0].offsetTop,mCSB_container[0].offsetLeft],
						isVisible=[
							(contentPos[0]+to[0]>=0 && contentPos[0]+to[0]<wrapper.height()-el.outerHeight(false)),
							(contentPos[1]+to[1]>=0 && contentPos[0]+to[1]<wrapper.width()-el.outerWidth(false))
						],
						overwrite=(o.axis==="yx" && !isVisible[0] && !isVisible[1]) ? "none" : "all";
					if(o.axis!=="x" && !isVisible[0]){
						_scrollTo($this,to[0].toString(),{dir:"y",scrollEasing:"mcsEaseInOut",overwrite:overwrite,dur:dur});
					}
					if(o.axis!=="y" && !isVisible[1]){
						_scrollTo($this,to[1].toString(),{dir:"x",scrollEasing:"mcsEaseInOut",overwrite:overwrite,dur:dur});
					}
				},$this[0]._focusTimer);
			});
		},
		/* -------------------- */
		
		
		/* sets content wrapper scrollTop/scrollLeft always to 0 */
		_wrapperScroll=function(){
			var $this=$(this),d=$this.data(pluginPfx),
				namespace=pluginPfx+"_"+d.idx,
				wrapper=$("#mCSB_"+d.idx+"_container").parent();
			wrapper.bind("scroll."+namespace,function(e){
				if(wrapper.scrollTop()!==0 || wrapper.scrollLeft()!==0){
					$(".mCSB_"+d.idx+"_scrollbar").css("visibility","hidden"); /* hide scrollbar(s) */
				}
			});
		},
		/* -------------------- */
		
		
		/* 
		BUTTONS EVENTS
		scrolls content via up, down, left and right buttons 
		*/
		_buttons=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,seq=d.sequential,
				namespace=pluginPfx+"_"+d.idx,
				sel=".mCSB_"+d.idx+"_scrollbar",
				btn=$(sel+">a");
			btn.bind("mousedown."+namespace+" touchstart."+namespace+" pointerdown."+namespace+" MSPointerDown."+namespace+" mouseup."+namespace+" touchend."+namespace+" pointerup."+namespace+" MSPointerUp."+namespace+" mouseout."+namespace+" pointerout."+namespace+" MSPointerOut."+namespace+" click."+namespace,function(e){
				e.preventDefault();
				if(!_mouseBtnLeft(e)){return;} /* left mouse button only */
				var btnClass=$(this).attr("class");
				seq.type=o.scrollButtons.scrollType;
				switch(e.type){
					case "mousedown": case "touchstart": case "pointerdown": case "MSPointerDown":
						if(seq.type==="stepped"){return;}
						touchActive=true;
						d.tweenRunning=false;
						_seq("on",btnClass);
						break;
					case "mouseup": case "touchend": case "pointerup": case "MSPointerUp":
					case "mouseout": case "pointerout": case "MSPointerOut":
						if(seq.type==="stepped"){return;}
						touchActive=false;
						if(seq.dir){_seq("off",btnClass);}
						break;
					case "click":
						if(seq.type!=="stepped" || d.tweenRunning){return;}
						_seq("on",btnClass);
						break;
				}
				function _seq(a,c){
					seq.scrollAmount=o.snapAmount || o.scrollButtons.scrollAmount;
					_sequentialScroll($this,a,c);
				}
			});
		},
		/* -------------------- */
		
		
		/* 
		KEYBOARD EVENTS
		scrolls content via keyboard 
		Keys: up arrow, down arrow, left arrow, right arrow, PgUp, PgDn, Home, End
		*/
		_keyboard=function(){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,seq=d.sequential,
				namespace=pluginPfx+"_"+d.idx,
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent(),
				editables="input,textarea,select,datalist,keygen,[contenteditable='true']",
				iframe=mCSB_container.find("iframe"),
				events=["blur."+namespace+" keydown."+namespace+" keyup."+namespace];
			if(iframe.length){
				iframe.each(function(){
					$(this).load(function(){
						/* bind events on accessible iframes */
						if(_canAccessIFrame(this)){
							$(this.contentDocument || this.contentWindow.document).bind(events[0],function(e){
								_onKeyboard(e);
							});
						}
					});
				});
			}
			mCustomScrollBox.attr("tabindex","0").bind(events[0],function(e){
				_onKeyboard(e);
			});
			function _onKeyboard(e){
				switch(e.type){
					case "blur":
						if(d.tweenRunning && seq.dir){_seq("off",null);}
						break;
					case "keydown": case "keyup":
						var code=e.keyCode ? e.keyCode : e.which,action="on";
						if((o.axis!=="x" && (code===38 || code===40)) || (o.axis!=="y" && (code===37 || code===39))){
							/* up (38), down (40), left (37), right (39) arrows */
							if(((code===38 || code===40) && !d.overflowed[0]) || ((code===37 || code===39) && !d.overflowed[1])){return;}
							if(e.type==="keyup"){action="off";}
							if(!$(document.activeElement).is(editables)){
								e.preventDefault();
								e.stopImmediatePropagation();
								_seq(action,code);
							}
						}else if(code===33 || code===34){
							/* PgUp (33), PgDn (34) */
							if(d.overflowed[0] || d.overflowed[1]){
								e.preventDefault();
								e.stopImmediatePropagation();
							}
							if(e.type==="keyup"){
								_stop($this);
								var keyboardDir=code===34 ? -1 : 1;
								if(o.axis==="x" || (o.axis==="yx" && d.overflowed[1] && !d.overflowed[0])){
									var dir="x",to=Math.abs(mCSB_container[0].offsetLeft)-(keyboardDir*(wrapper.width()*0.9));
								}else{
									var dir="y",to=Math.abs(mCSB_container[0].offsetTop)-(keyboardDir*(wrapper.height()*0.9));
								}
								_scrollTo($this,to.toString(),{dir:dir,scrollEasing:"mcsEaseInOut"});
							}
						}else if(code===35 || code===36){
							/* End (35), Home (36) */
							if(!$(document.activeElement).is(editables)){
								if(d.overflowed[0] || d.overflowed[1]){
									e.preventDefault();
									e.stopImmediatePropagation();
								}
								if(e.type==="keyup"){
									if(o.axis==="x" || (o.axis==="yx" && d.overflowed[1] && !d.overflowed[0])){
										var dir="x",to=code===35 ? Math.abs(wrapper.width()-mCSB_container.outerWidth(false)) : 0;
									}else{
										var dir="y",to=code===35 ? Math.abs(wrapper.height()-mCSB_container.outerHeight(false)) : 0;
									}
									_scrollTo($this,to.toString(),{dir:dir,scrollEasing:"mcsEaseInOut"});
								}
							}
						}
						break;
				}
				function _seq(a,c){
					seq.type=o.keyboard.scrollType;
					seq.scrollAmount=o.snapAmount || o.keyboard.scrollAmount;
					if(seq.type==="stepped" && d.tweenRunning){return;}
					_sequentialScroll($this,a,c);
				}
			}
		},
		/* -------------------- */
		
		
		/* scrolls content sequentially (used when scrolling via buttons, keyboard arrows etc.) */
		_sequentialScroll=function(el,action,trigger,e,s){
			var d=el.data(pluginPfx),o=d.opt,seq=d.sequential,
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				once=seq.type==="stepped" ? true : false,
				steplessSpeed=o.scrollInertia < 26 ? 26 : o.scrollInertia, /* 26/1.5=17 */
				steppedSpeed=o.scrollInertia < 1 ? 17 : o.scrollInertia;
			switch(action){
				case "on":
					seq.dir=[
						(trigger===classes[16] || trigger===classes[15] || trigger===39 || trigger===37 ? "x" : "y"),
						(trigger===classes[13] || trigger===classes[15] || trigger===38 || trigger===37 ? -1 : 1)
					];
					_stop(el);
					if(_isNumeric(trigger) && seq.type==="stepped"){return;}
					_on(once);
					break;
				case "off":
					_off();
					if(once || (d.tweenRunning && seq.dir)){
						_on(true);
					}
					break;
			}
			/* starts sequence */
			function _on(once){
				var c=seq.type!=="stepped", /* continuous scrolling */
					t=s ? s : !once ? 1000/60 : c ? steplessSpeed/1.5 : steppedSpeed, /* timer */
					m=!once ? 2.5 : c ? 7.5 : 40, /* multiplier */
					contentPos=[Math.abs(mCSB_container[0].offsetTop),Math.abs(mCSB_container[0].offsetLeft)],
					ratio=[d.scrollRatio.y>10 ? 10 : d.scrollRatio.y,d.scrollRatio.x>10 ? 10 : d.scrollRatio.x],
					amount=seq.dir[0]==="x" ? contentPos[1]+(seq.dir[1]*(ratio[1]*m)) : contentPos[0]+(seq.dir[1]*(ratio[0]*m)),
					px=seq.dir[0]==="x" ? contentPos[1]+(seq.dir[1]*parseInt(seq.scrollAmount)) : contentPos[0]+(seq.dir[1]*parseInt(seq.scrollAmount)),
					to=seq.scrollAmount!=="auto" ? px : amount,
					easing=e ? e : !once ? "mcsLinear" : c ? "mcsLinearOut" : "mcsEaseInOut",
					onComplete=!once ? false : true;
				if(once && t<17){
					to=seq.dir[0]==="x" ? contentPos[1] : contentPos[0];
				}
				_scrollTo(el,to.toString(),{dir:seq.dir[0],scrollEasing:easing,dur:t,onComplete:onComplete});
				if(once){
					seq.dir=false;
					return;
				}
				clearTimeout(seq.step);
				seq.step=setTimeout(function(){
					_on();
				},t);
			}
			/* stops sequence */
			function _off(){
				clearTimeout(seq.step);
				_delete(seq,"step");
				_stop(el);
			}
		},
		/* -------------------- */
		
		
		/* returns a yx array from value */
		_arr=function(val){
			var o=$(this).data(pluginPfx).opt,vals=[];
			if(typeof val==="function"){val=val();} /* check if the value is a single anonymous function */
			/* check if value is object or array, its length and create an array with yx values */
			if(!(val instanceof Array)){ /* object value (e.g. {y:"100",x:"100"}, 100 etc.) */
				vals[0]=val.y ? val.y : val.x || o.axis==="x" ? null : val;
				vals[1]=val.x ? val.x : val.y || o.axis==="y" ? null : val;
			}else{ /* array value (e.g. [100,100]) */
				vals=val.length>1 ? [val[0],val[1]] : o.axis==="x" ? [null,val[0]] : [val[0],null];
			}
			/* check if array values are anonymous functions */
			if(typeof vals[0]==="function"){vals[0]=vals[0]();}
			if(typeof vals[1]==="function"){vals[1]=vals[1]();}
			return vals;
		},
		/* -------------------- */
		
		
		/* translates values (e.g. "top", 100, "100px", "#id") to actual scroll-to positions */
		_to=function(val,dir){
			if(val==null || typeof val=="undefined"){return;}
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent(),
				t=typeof val;
			if(!dir){dir=o.axis==="x" ? "x" : "y";}
			var contentLength=dir==="x" ? mCSB_container.outerWidth(false) : mCSB_container.outerHeight(false),
				contentPos=dir==="x" ? mCSB_container[0].offsetLeft : mCSB_container[0].offsetTop,
				cssProp=dir==="x" ? "left" : "top";
			switch(t){
				case "function": /* this currently is not used. Consider removing it */
					return val();
					break;
				case "object": /* js/jquery object */
					var obj=val.jquery ? val : $(val);
					if(!obj.length){return;}
					return dir==="x" ? _childPos(obj)[1] : _childPos(obj)[0];
					break;
				case "string": case "number":
					if(_isNumeric(val)){ /* numeric value */
						return Math.abs(val);
					}else if(val.indexOf("%")!==-1){ /* percentage value */
						return Math.abs(contentLength*parseInt(val)/100);
					}else if(val.indexOf("-=")!==-1){ /* decrease value */
						return Math.abs(contentPos-parseInt(val.split("-=")[1]));
					}else if(val.indexOf("+=")!==-1){ /* inrease value */
						var p=(contentPos+parseInt(val.split("+=")[1]));
						return p>=0 ? 0 : Math.abs(p);
					}else if(val.indexOf("px")!==-1 && _isNumeric(val.split("px")[0])){ /* pixels string value (e.g. "100px") */
						return Math.abs(val.split("px")[0]);
					}else{
						if(val==="top" || val==="left"){ /* special strings */
							return 0;
						}else if(val==="bottom"){
							return Math.abs(wrapper.height()-mCSB_container.outerHeight(false));
						}else if(val==="right"){
							return Math.abs(wrapper.width()-mCSB_container.outerWidth(false));
						}else if(val==="first" || val==="last"){
							var obj=mCSB_container.find(":"+val);
							return dir==="x" ? _childPos(obj)[1] : _childPos(obj)[0];
						}else{
							if($(val).length){ /* jquery selector */
								return dir==="x" ? _childPos($(val))[1] : _childPos($(val))[0];
							}else{ /* other values (e.g. "100em") */
								mCSB_container.css(cssProp,val);
								methods.update.call(null,$this[0]);
								return;
							}
						}
					}
					break;
			}
		},
		/* -------------------- */
		
		
		/* calls the update method automatically */
		_autoUpdate=function(rem){
			var $this=$(this),d=$this.data(pluginPfx),o=d.opt,
				mCSB_container=$("#mCSB_"+d.idx+"_container");
			if(rem){
				/* 
				removes autoUpdate timer 
				usage: _autoUpdate.call(this,"remove");
				*/
				clearTimeout(mCSB_container[0].autoUpdate);
				_delete(mCSB_container[0],"autoUpdate");
				return;
			}
			var	wrapper=mCSB_container.parent(),
				scrollbar=[$("#mCSB_"+d.idx+"_scrollbar_vertical"),$("#mCSB_"+d.idx+"_scrollbar_horizontal")],
				scrollbarSize=function(){return [
					scrollbar[0].is(":visible") ? scrollbar[0].outerHeight(true) : 0, /* returns y-scrollbar height */
					scrollbar[1].is(":visible") ? scrollbar[1].outerWidth(true) : 0 /* returns x-scrollbar width */
				]},
				oldSelSize=sizesSum(),newSelSize,
				os=[mCSB_container.outerHeight(false),mCSB_container.outerWidth(false),wrapper.height(),wrapper.width(),scrollbarSize()[0],scrollbarSize()[1]],ns,
				oldImgsLen=imgSum(),newImgsLen;
			upd();
			function upd(){
				clearTimeout(mCSB_container[0].autoUpdate);
				if($this.parents("html").length===0){
					/* check element in dom tree */
					$this=null;
					return;
				}
				mCSB_container[0].autoUpdate=setTimeout(function(){
					/* update on specific selector(s) length and size change */
					if(o.advanced.updateOnSelectorChange){
						newSelSize=sizesSum();
						if(newSelSize!==oldSelSize){
							doUpd(3);
							oldSelSize=newSelSize;
							return;
						}
					}
					/* update on main element and scrollbar size changes */
					if(o.advanced.updateOnContentResize){
						ns=[mCSB_container.outerHeight(false),mCSB_container.outerWidth(false),wrapper.height(),wrapper.width(),scrollbarSize()[0],scrollbarSize()[1]];
						if(ns[0]!==os[0] || ns[1]!==os[1] || ns[2]!==os[2] || ns[3]!==os[3] || ns[4]!==os[4] || ns[5]!==os[5]){
							doUpd(ns[0]!==os[0] || ns[1]!==os[1]);
							os=ns;
						}
					}
					/* update on image load */
					if(o.advanced.updateOnImageLoad){
						newImgsLen=imgSum();
						if(newImgsLen!==oldImgsLen){
							mCSB_container.find("img").each(function(){
								imgLoader(this);
							});
							oldImgsLen=newImgsLen;
						}
					}
					if(o.advanced.updateOnSelectorChange || o.advanced.updateOnContentResize || o.advanced.updateOnImageLoad){upd();}
				},o.advanced.autoUpdateTimeout);
			}
			/* returns images amount */
			function imgSum(){
				var total=0;
				if(o.advanced.updateOnImageLoad){total=mCSB_container.find("img").length;}
				return total;
			}
			/* a tiny image loader */
			function imgLoader(el){
				if($(el).hasClass(classes[2])){doUpd(); return;}
				var img=new Image();
				function createDelegate(contextObject,delegateMethod){
					return function(){return delegateMethod.apply(contextObject,arguments);}
				}
				function imgOnLoad(){
					this.onload=null;
					$(el).addClass(classes[2]);
					doUpd(2);
				}
				img.onload=createDelegate(img,imgOnLoad);
				img.src=el.src;
			}
			/* returns the total height and width sum of all elements matching the selector */
			function sizesSum(){
				if(o.advanced.updateOnSelectorChange===true){o.advanced.updateOnSelectorChange="*";}
				var total=0,sel=mCSB_container.find(o.advanced.updateOnSelectorChange);
				if(o.advanced.updateOnSelectorChange && sel.length>0){sel.each(function(){total+=$(this).height()+$(this).width();});}
				return total;
			}
			/* calls the update method */
			function doUpd(cb){
				clearTimeout(mCSB_container[0].autoUpdate); 
				methods.update.call(null,$this[0],cb);
			}
		},
		/* -------------------- */
		
		
		/* snaps scrolling to a multiple of a pixels number */
		_snapAmount=function(to,amount,offset){
			return (Math.round(to/amount)*amount-offset); 
		},
		/* -------------------- */
		
		
		/* stops content and scrollbar animations */
		_stop=function(el){
			var d=el.data(pluginPfx),
				sel=$("#mCSB_"+d.idx+"_container,#mCSB_"+d.idx+"_container_wrapper,#mCSB_"+d.idx+"_dragger_vertical,#mCSB_"+d.idx+"_dragger_horizontal");
			sel.each(function(){
				_stopTween.call(this);
			});
		},
		/* -------------------- */
		
		
		/* 
		ANIMATES CONTENT 
		This is where the actual scrolling happens
		*/
		_scrollTo=function(el,to,options){
			var d=el.data(pluginPfx),o=d.opt,
				defaults={
					trigger:"internal",
					dir:"y",
					scrollEasing:"mcsEaseOut",
					drag:false,
					dur:o.scrollInertia,
					overwrite:"all",
					callbacks:true,
					onStart:true,
					onUpdate:true,
					onComplete:true
				},
				options=$.extend(defaults,options),
				dur=[options.dur,(options.drag ? 0 : options.dur)],
				mCustomScrollBox=$("#mCSB_"+d.idx),
				mCSB_container=$("#mCSB_"+d.idx+"_container"),
				wrapper=mCSB_container.parent(),
				totalScrollOffsets=o.callbacks.onTotalScrollOffset ? _arr.call(el,o.callbacks.onTotalScrollOffset) : [0,0],
				totalScrollBackOffsets=o.callbacks.onTotalScrollBackOffset ? _arr.call(el,o.callbacks.onTotalScrollBackOffset) : [0,0];
			d.trigger=options.trigger;
			if(wrapper.scrollTop()!==0 || wrapper.scrollLeft()!==0){ /* always reset scrollTop/Left */
				$(".mCSB_"+d.idx+"_scrollbar").css("visibility","visible");
				wrapper.scrollTop(0).scrollLeft(0);
			}
			if(to==="_resetY" && !d.contentReset.y){
				/* callbacks: onOverflowYNone */
				if(_cb("onOverflowYNone")){o.callbacks.onOverflowYNone.call(el[0]);}
				d.contentReset.y=1;
			}
			if(to==="_resetX" && !d.contentReset.x){
				/* callbacks: onOverflowXNone */
				if(_cb("onOverflowXNone")){o.callbacks.onOverflowXNone.call(el[0]);}
				d.contentReset.x=1;
			}
			if(to==="_resetY" || to==="_resetX"){return;}
			if((d.contentReset.y || !el[0].mcs) && d.overflowed[0]){
				/* callbacks: onOverflowY */
				if(_cb("onOverflowY")){o.callbacks.onOverflowY.call(el[0]);}
				d.contentReset.x=null;
			}
			if((d.contentReset.x || !el[0].mcs) && d.overflowed[1]){
				/* callbacks: onOverflowX */
				if(_cb("onOverflowX")){o.callbacks.onOverflowX.call(el[0]);}
				d.contentReset.x=null;
			}
			if(o.snapAmount){to=_snapAmount(to,o.snapAmount,o.snapOffset);} /* scrolling snapping */
			switch(options.dir){
				case "x":
					var mCSB_dragger=$("#mCSB_"+d.idx+"_dragger_horizontal"),
						property="left",
						contentPos=mCSB_container[0].offsetLeft,
						limit=[
							mCustomScrollBox.width()-mCSB_container.outerWidth(false),
							mCSB_dragger.parent().width()-mCSB_dragger.width()
						],
						scrollTo=[to,to===0 ? 0 : (to/d.scrollRatio.x)],
						tso=totalScrollOffsets[1],
						tsbo=totalScrollBackOffsets[1],
						totalScrollOffset=tso>0 ? tso/d.scrollRatio.x : 0,
						totalScrollBackOffset=tsbo>0 ? tsbo/d.scrollRatio.x : 0;
					break;
				case "y":
					var mCSB_dragger=$("#mCSB_"+d.idx+"_dragger_vertical"),
						property="top",
						contentPos=mCSB_container[0].offsetTop,
						limit=[
							mCustomScrollBox.height()-mCSB_container.outerHeight(false),
							mCSB_dragger.parent().height()-mCSB_dragger.height()
						],
						scrollTo=[to,to===0 ? 0 : (to/d.scrollRatio.y)],
						tso=totalScrollOffsets[0],
						tsbo=totalScrollBackOffsets[0],
						totalScrollOffset=tso>0 ? tso/d.scrollRatio.y : 0,
						totalScrollBackOffset=tsbo>0 ? tsbo/d.scrollRatio.y : 0;
					break;
			}
			if(scrollTo[1]<0 || (scrollTo[0]===0 && scrollTo[1]===0)){
				scrollTo=[0,0];
			}else if(scrollTo[1]>=limit[1]){
				scrollTo=[limit[0],limit[1]];
			}else{
				scrollTo[0]=-scrollTo[0];
			}
			if(!el[0].mcs){
				_mcs();  /* init mcs object (once) to make it available before callbacks */
				if(_cb("onInit")){o.callbacks.onInit.call(el[0]);} /* callbacks: onInit */
			}
			clearTimeout(mCSB_container[0].onCompleteTimeout);
			if(!d.tweenRunning && ((contentPos===0 && scrollTo[0]>=0) || (contentPos===limit[0] && scrollTo[0]<=limit[0]))){return;}
			_tweenTo(mCSB_dragger[0],property,Math.round(scrollTo[1]),dur[1],options.scrollEasing);
			_tweenTo(mCSB_container[0],property,Math.round(scrollTo[0]),dur[0],options.scrollEasing,options.overwrite,{
				onStart:function(){
					if(options.callbacks && options.onStart && !d.tweenRunning){
						/* callbacks: onScrollStart */
						if(_cb("onScrollStart")){_mcs(); o.callbacks.onScrollStart.call(el[0]);}
						d.tweenRunning=true;
						_onDragClasses(mCSB_dragger);
						d.cbOffsets=_cbOffsets();
					}
				},onUpdate:function(){
					if(options.callbacks && options.onUpdate){
						/* callbacks: whileScrolling */
						if(_cb("whileScrolling")){_mcs(); o.callbacks.whileScrolling.call(el[0]);}
					}
				},onComplete:function(){
					if(options.callbacks && options.onComplete){
						if(o.axis==="yx"){clearTimeout(mCSB_container[0].onCompleteTimeout);}
						var t=mCSB_container[0].idleTimer || 0;
						mCSB_container[0].onCompleteTimeout=setTimeout(function(){
							/* callbacks: onScroll, onTotalScroll, onTotalScrollBack */
							if(_cb("onScroll")){_mcs(); o.callbacks.onScroll.call(el[0]);}
							if(_cb("onTotalScroll") && scrollTo[1]>=limit[1]-totalScrollOffset && d.cbOffsets[0]){_mcs(); o.callbacks.onTotalScroll.call(el[0]);}
							if(_cb("onTotalScrollBack") && scrollTo[1]<=totalScrollBackOffset && d.cbOffsets[1]){_mcs(); o.callbacks.onTotalScrollBack.call(el[0]);}
							d.tweenRunning=false;
							mCSB_container[0].idleTimer=0;
							_onDragClasses(mCSB_dragger,"hide");
						},t);
					}
				}
			});
			/* checks if callback function exists */
			function _cb(cb){
				return d && o.callbacks[cb] && typeof o.callbacks[cb]==="function";
			}
			/* checks whether callback offsets always trigger */
			function _cbOffsets(){
				return [o.callbacks.alwaysTriggerOffsets || contentPos>=limit[0]+tso,o.callbacks.alwaysTriggerOffsets || contentPos<=-tsbo];
			}
			/* 
			populates object with useful values for the user 
			values: 
				content: this.mcs.content
				content top position: this.mcs.top 
				content left position: this.mcs.left 
				dragger top position: this.mcs.draggerTop 
				dragger left position: this.mcs.draggerLeft 
				scrolling y percentage: this.mcs.topPct 
				scrolling x percentage: this.mcs.leftPct 
				scrolling direction: this.mcs.direction
			*/
			function _mcs(){
				var cp=[mCSB_container[0].offsetTop,mCSB_container[0].offsetLeft], /* content position */
					dp=[mCSB_dragger[0].offsetTop,mCSB_dragger[0].offsetLeft], /* dragger position */
					cl=[mCSB_container.outerHeight(false),mCSB_container.outerWidth(false)], /* content length */
					pl=[mCustomScrollBox.height(),mCustomScrollBox.width()]; /* content parent length */
				el[0].mcs={
					content:mCSB_container, /* original content wrapper as jquery object */
					top:cp[0],left:cp[1],draggerTop:dp[0],draggerLeft:dp[1],
					topPct:Math.round((100*Math.abs(cp[0]))/(Math.abs(cl[0])-pl[0])),leftPct:Math.round((100*Math.abs(cp[1]))/(Math.abs(cl[1])-pl[1])),
					direction:options.dir
				};
				/* 
				this refers to the original element containing the scrollbar(s)
				usage: this.mcs.top, this.mcs.leftPct etc. 
				*/
			}
		},
		/* -------------------- */
		
		
		/* 
		CUSTOM JAVASCRIPT ANIMATION TWEEN 
		Lighter and faster than jquery animate() and css transitions 
		Animates top/left properties and includes easings 
		*/
		_tweenTo=function(el,prop,to,duration,easing,overwrite,callbacks){
			if(!el._mTween){el._mTween={top:{},left:{}};}
			var callbacks=callbacks || {},
				onStart=callbacks.onStart || function(){},onUpdate=callbacks.onUpdate || function(){},onComplete=callbacks.onComplete || function(){},
				startTime=_getTime(),_delay,progress=0,from=el.offsetTop,elStyle=el.style,_request,tobj=el._mTween[prop];
			if(prop==="left"){from=el.offsetLeft;}
			var diff=to-from;
			tobj.stop=0;
			if(overwrite!=="none"){_cancelTween();}
			_startTween();
			function _step(){
				if(tobj.stop){return;}
				if(!progress){onStart.call();}
				progress=_getTime()-startTime;
				_tween();
				if(progress>=tobj.time){
					tobj.time=(progress>tobj.time) ? progress+_delay-(progress-tobj.time) : progress+_delay-1;
					if(tobj.time<progress+1){tobj.time=progress+1;}
				}
				if(tobj.time<duration){tobj.id=_request(_step);}else{onComplete.call();}
			}
			function _tween(){
				if(duration>0){
					tobj.currVal=_ease(tobj.time,from,diff,duration,easing);
					elStyle[prop]=Math.round(tobj.currVal)+"px";
				}else{
					elStyle[prop]=to+"px";
				}
				onUpdate.call();
			}
			function _startTween(){
				_delay=1000/60;
				tobj.time=progress+_delay;
				_request=(!window.requestAnimationFrame) ? function(f){_tween(); return setTimeout(f,0.01);} : window.requestAnimationFrame;
				tobj.id=_request(_step);
			}
			function _cancelTween(){
				if(tobj.id==null){return;}
				if(!window.requestAnimationFrame){clearTimeout(tobj.id);
				}else{window.cancelAnimationFrame(tobj.id);}
				tobj.id=null;
			}
			function _ease(t,b,c,d,type){
				switch(type){
					case "linear": case "mcsLinear":
						return c*t/d + b;
						break;
					case "mcsLinearOut":
						t/=d; t--; return c * Math.sqrt(1 - t*t) + b;
						break;
					case "easeInOutSmooth":
						t/=d/2;
						if(t<1) return c/2*t*t + b;
						t--;
						return -c/2 * (t*(t-2) - 1) + b;
						break;
					case "easeInOutStrong":
						t/=d/2;
						if(t<1) return c/2 * Math.pow( 2, 10 * (t - 1) ) + b;
						t--;
						return c/2 * ( -Math.pow( 2, -10 * t) + 2 ) + b;
						break;
					case "easeInOut": case "mcsEaseInOut":
						t/=d/2;
						if(t<1) return c/2*t*t*t + b;
						t-=2;
						return c/2*(t*t*t + 2) + b;
						break;
					case "easeOutSmooth":
						t/=d; t--;
						return -c * (t*t*t*t - 1) + b;
						break;
					case "easeOutStrong":
						return c * ( -Math.pow( 2, -10 * t/d ) + 1 ) + b;
						break;
					case "easeOut": case "mcsEaseOut": default:
						var ts=(t/=d)*t,tc=ts*t;
						return b+c*(0.499999999999997*tc*ts + -2.5*ts*ts + 5.5*tc + -6.5*ts + 4*t);
				}
			}
		},
		/* -------------------- */
		
		
		/* returns current time */
		_getTime=function(){
			if(window.performance && window.performance.now){
				return window.performance.now();
			}else{
				if(window.performance && window.performance.webkitNow){
					return window.performance.webkitNow();
				}else{
					if(Date.now){return Date.now();}else{return new Date().getTime();}
				}
			}
		},
		/* -------------------- */
		
		
		/* stops a tween */
		_stopTween=function(){
			var el=this;
			if(!el._mTween){el._mTween={top:{},left:{}};}
			var props=["top","left"];
			for(var i=0; i<props.length; i++){
				var prop=props[i];
				if(el._mTween[prop].id){
					if(!window.requestAnimationFrame){clearTimeout(el._mTween[prop].id);
					}else{window.cancelAnimationFrame(el._mTween[prop].id);}
					el._mTween[prop].id=null;
					el._mTween[prop].stop=1;
				}
			}
		},
		/* -------------------- */
		
		
		/* deletes a property (avoiding the exception thrown by IE) */
		_delete=function(c,m){
			try{delete c[m];}catch(e){c[m]=null;}
		},
		/* -------------------- */
		
		
		/* detects left mouse button */
		_mouseBtnLeft=function(e){
			return !(e.which && e.which!==1);
		},
		/* -------------------- */
		
		
		/* detects if pointer type event is touch */
		_pointerTouch=function(e){
			var t=e.originalEvent.pointerType;
			return !(t && t!=="touch" && t!==2);
		},
		/* -------------------- */
		
		
		/* checks if value is numeric */
		_isNumeric=function(val){
			return !isNaN(parseFloat(val)) && isFinite(val);
		},
		/* -------------------- */
		
		
		/* returns element position according to content */
		_childPos=function(el){
			var p=el.parents(".mCSB_container");
			return [el.offset().top-p.offset().top,el.offset().left-p.offset().left];
		};
		/* -------------------- */
		
	
	
	
	
	/* 
	----------------------------------------
	PLUGIN SETUP 
	----------------------------------------
	*/
	
	/* plugin constructor functions */
	$.fn[pluginNS]=function(method){ /* usage: $(selector).mCustomScrollbar(); */
		if(methods[method]){
			return methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		}else if(typeof method==="object" || !method){
			return methods.init.apply(this,arguments);
		}else{
			$.error("Method "+method+" does not exist");
		}
	};
	$[pluginNS]=function(method){ /* usage: $.mCustomScrollbar(); */
		if(methods[method]){
			return methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		}else if(typeof method==="object" || !method){
			return methods.init.apply(this,arguments);
		}else{
			$.error("Method "+method+" does not exist");
		}
	};
	
	/* 
	allow setting plugin default options. 
	usage: $.mCustomScrollbar.defaults.scrollInertia=500; 
	to apply any changed default options on default selectors (below), use inside document ready fn 
	e.g.: $(document).ready(function(){ $.mCustomScrollbar.defaults.scrollInertia=500; });
	*/
	$[pluginNS].defaults=defaults;
	
	/* 
	add window object (window.mCustomScrollbar) 
	usage: if(window.mCustomScrollbar){console.log("custom scrollbar plugin loaded");}
	*/
	window[pluginNS]=true;
	
	$(window).on("load", function(){
		
		$(defaultSelector)[pluginNS](); /* add scrollbars automatically on default selector */
		
		/* extend jQuery expressions */
		$.extend($.expr[":"],{
			/* checks if element is within scrollable viewport */
			mcsInView:$.expr[":"].mcsInView || function(el){
				var $el=$(el),content=$el.parents(".mCSB_container"),wrapper,cPos;
				if(!content.length){return;}
				wrapper=content.parent();
				cPos=[content[0].offsetTop,content[0].offsetLeft];
				return 	cPos[0]+_childPos($el)[0]>=0 && cPos[0]+_childPos($el)[0]<wrapper.height()-$el.outerHeight(false) && 
						cPos[1]+_childPos($el)[1]>=0 && cPos[1]+_childPos($el)[1]<wrapper.width()-$el.outerWidth(false);
			},
			/* checks if element is overflowed having visible scrollbar(s) */
			mcsOverflow:$.expr[":"].mcsOverflow || function(el){
				var d=$(el).data(pluginPfx);
				if(!d){return;}
				return d.overflowed[0] || d.overflowed[1];
			}
		});
	
	});

}))}));
/*!
 * jquery.customSelect() - v0.4.1
 * http://adam.co/lab/jquery/customselect/
 * 2013-05-13
 *
 * Copyright 2013 Adam Coulombe
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @license http://www.gnu.org/licenses/gpl.html GPL2 License
 */
jQuery(document).ready(function(a) {a.fn.extend({customSelect:function(c){if(typeof document.body.style.maxHeight==="undefined"){return this}var e={customClass:"customSelect",mapClass:true,mapStyle:true},c=a.extend(e,c),d=c.customClass,f=function(h,k){var g=h.find(":selected"),j=k.children(":first"),i=g.html()||"&nbsp;";j.html(i);if(g.attr("disabled")){k.addClass(b("DisabledOption"))}else{k.removeClass(b("DisabledOption"))}setTimeout(function(){k.removeClass(b("Open"));a(document).off("mouseup."+b("Open"))},60)},b=function(g){return d+g};return this.each(function(){var g=a(this),i=a("<span />").addClass(b("Inner")),h=a("<span />");g.after(h.append(i));h.addClass(d);if(c.mapClass){h.addClass(g.attr("class"))}if(c.mapStyle){h.attr("style",g.attr("style"))}g.addClass("hasCustomSelect").on("update",function(){f(g,h);var k=parseInt(g.outerWidth(),10)-(parseInt(h.outerWidth(),10)-parseInt(h.width(),10));h.css({display:"inline-block"});var j=h.outerHeight();if(g.attr("disabled")){h.addClass(b("Disabled"))}else{h.removeClass(b("Disabled"))}i.css({width:k,display:"inline-block"});g.css({"-webkit-appearance":"menulist-button",width:h.outerWidth(),position:"absolute",opacity:0,height:j,fontSize:h.css("font-size")})}).on("change",function(){h.addClass(b("Changed"));f(g,h)}).on("keyup",function(j){if(!h.hasClass(b("Open"))){g.blur();g.focus()}else{if(j.which==13||j.which==27){f(g,h)}}}).on("mousedown",function(j){h.removeClass(b("Changed"))}).on("mouseup",function(j){if(!h.hasClass(b("Open"))){if(a("."+b("Open")).not(h).length>0&&typeof InstallTrigger!=="undefined"){g.focus()}else{h.addClass(b("Open"));j.stopPropagation();a(document).one("mouseup."+b("Open"),function(k){if(k.target!=g.get(0)&&a.inArray(k.target,g.find("*").get())<0){g.blur()}else{f(g,h)}})}}}).focus(function(){h.removeClass(b("Changed")).addClass(b("Focus"))}).blur(function(){h.removeClass(b("Focus")+" "+b("Open"))}).hover(function(){h.addClass(b("Hover"))},function(){h.removeClass(b("Hover"))}).trigger("update")})}})});
/*!
 * Isotope PACKAGED v3.0.0
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * http://isotope.metafizzy.co
 * Copyright 2016 Metafizzy
 */

/**
 * Bridget makes jQuery widgets
 * v2.0.0
 * MIT license
 */

/* jshint browser: true, strict: true, undef: true, unused: true */

( function( window, factory ) {
  'use strict';
  /* globals define: false, module: false, require: false */

  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'jquery-bridget/jquery-bridget',[ 'jquery' ], function( jQuery ) {
      factory( window, jQuery );
    });
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      window,
      require('jquery')
    );
  } else {
    // browser global
    window.jQueryBridget = factory(
      window,
      window.jQuery
    );
  }

}( window, function factory( window, jQuery ) {
'use strict';

// ----- utils ----- //

var arraySlice = Array.prototype.slice;

// helper function for logging errors
// $.error breaks jQuery chaining
var console = window.console;
var logError = typeof console == 'undefined' ? function() {} :
  function( message ) {
    console.error( message );
  };

// ----- jQueryBridget ----- //

function jQueryBridget( namespace, PluginClass, $ ) {
  $ = $ || jQuery || window.jQuery;
  if ( !$ ) {
    return;
  }

  // add option method -> $().plugin('option', {...})
  if ( !PluginClass.prototype.option ) {
    // option setter
    PluginClass.prototype.option = function( opts ) {
      // bail out if not an object
      if ( !$.isPlainObject( opts ) ){
        return;
      }
      this.options = $.extend( true, this.options, opts );
    };
  }

  // make jQuery plugin
  $.fn[ namespace ] = function( arg0 /*, arg1 */ ) {
    if ( typeof arg0 == 'string' ) {
      // method call $().plugin( 'methodName', { options } )
      // shift arguments by 1
      var args = arraySlice.call( arguments, 1 );
      return methodCall( this, arg0, args );
    }
    // just $().plugin({ options })
    plainCall( this, arg0 );
    return this;
  };

  // $().plugin('methodName')
  function methodCall( $elems, methodName, args ) {
    var returnValue;
    var pluginMethodStr = '$().' + namespace + '("' + methodName + '")';

    $elems.each( function( i, elem ) {
      // get instance
      var instance = $.data( elem, namespace );
      if ( !instance ) {
        logError( namespace + ' not initialized. Cannot call methods, i.e. ' +
          pluginMethodStr );
        return;
      }

      var method = instance[ methodName ];
      if ( !method || methodName.charAt(0) == '_' ) {
        logError( pluginMethodStr + ' is not a valid method' );
        return;
      }

      // apply method, get return value
      var value = method.apply( instance, args );
      // set return value if value is returned, use only first value
      returnValue = returnValue === undefined ? value : returnValue;
    });

    return returnValue !== undefined ? returnValue : $elems;
  }

  function plainCall( $elems, options ) {
    $elems.each( function( i, elem ) {
      var instance = $.data( elem, namespace );
      if ( instance ) {
        // set options & init
        instance.option( options );
        instance._init();
      } else {
        // initialize new instance
        instance = new PluginClass( elem, options );
        $.data( elem, namespace, instance );
      }
    });
  }

  updateJQuery( $ );

}

// ----- updateJQuery ----- //

// set $.bridget for v1 backwards compatibility
function updateJQuery( $ ) {
  if ( !$ || ( $ && $.bridget ) ) {
    return;
  }
  $.bridget = jQueryBridget;
}

updateJQuery( jQuery || window.jQuery );

// -----  ----- //

return jQueryBridget;

}));

/**
 * EvEmitter v1.0.2
 * Lil' event emitter
 * MIT License
 */

/* jshint unused: true, undef: true, strict: true */

( function( global, factory ) {
  // universal module definition
  /* jshint strict: false */ /* globals define, module */
  if ( typeof define == 'function' && define.amd ) {
    // AMD - RequireJS
    define( 'ev-emitter/ev-emitter',factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS - Browserify, Webpack
    module.exports = factory();
  } else {
    // Browser globals
    global.EvEmitter = factory();
  }

}( this, function() {



function EvEmitter() {}

var proto = EvEmitter.prototype;

proto.on = function( eventName, listener ) {
  if ( !eventName || !listener ) {
    return;
  }
  // set events hash
  var events = this._events = this._events || {};
  // set listeners array
  var listeners = events[ eventName ] = events[ eventName ] || [];
  // only add once
  if ( listeners.indexOf( listener ) == -1 ) {
    listeners.push( listener );
  }

  return this;
};

proto.once = function( eventName, listener ) {
  if ( !eventName || !listener ) {
    return;
  }
  // add event
  this.on( eventName, listener );
  // set once flag
  // set onceEvents hash
  var onceEvents = this._onceEvents = this._onceEvents || {};
  // set onceListeners object
  var onceListeners = onceEvents[ eventName ] = onceEvents[ eventName ] || {};
  // set flag
  onceListeners[ listener ] = true;

  return this;
};

proto.off = function( eventName, listener ) {
  var listeners = this._events && this._events[ eventName ];
  if ( !listeners || !listeners.length ) {
    return;
  }
  var index = listeners.indexOf( listener );
  if ( index != -1 ) {
    listeners.splice( index, 1 );
  }

  return this;
};

proto.emitEvent = function( eventName, args ) {
  var listeners = this._events && this._events[ eventName ];
  if ( !listeners || !listeners.length ) {
    return;
  }
  var i = 0;
  var listener = listeners[i];
  args = args || [];
  // once stuff
  var onceListeners = this._onceEvents && this._onceEvents[ eventName ];

  while ( listener ) {
    var isOnce = onceListeners && onceListeners[ listener ];
    if ( isOnce ) {
      // remove listener
      // remove before trigger to prevent recursion
      this.off( eventName, listener );
      // unset once flag
      delete onceListeners[ listener ];
    }
    // trigger listener
    listener.apply( this, args );
    // get next listener
    i += isOnce ? 0 : 1;
    listener = listeners[i];
  }

  return this;
};

return EvEmitter;

}));

/*!
 * getSize v2.0.2
 * measure size of elements
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true */
/*global define: false, module: false, console: false */

( function( window, factory ) {
  'use strict';

  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'get-size/get-size',[],function() {
      return factory();
    });
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory();
  } else {
    // browser global
    window.getSize = factory();
  }

})( window, function factory() {
'use strict';

// -------------------------- helpers -------------------------- //

// get a number from a string, not a percentage
function getStyleSize( value ) {
  var num = parseFloat( value );
  // not a percent like '100%', and a number
  var isValid = value.indexOf('%') == -1 && !isNaN( num );
  return isValid && num;
}

function noop() {}

var logError = typeof console == 'undefined' ? noop :
  function( message ) {
    console.error( message );
  };

// -------------------------- measurements -------------------------- //

var measurements = [
  'paddingLeft',
  'paddingRight',
  'paddingTop',
  'paddingBottom',
  'marginLeft',
  'marginRight',
  'marginTop',
  'marginBottom',
  'borderLeftWidth',
  'borderRightWidth',
  'borderTopWidth',
  'borderBottomWidth'
];

var measurementsLength = measurements.length;

function getZeroSize() {
  var size = {
    width: 0,
    height: 0,
    innerWidth: 0,
    innerHeight: 0,
    outerWidth: 0,
    outerHeight: 0
  };
  for ( var i=0; i < measurementsLength; i++ ) {
    var measurement = measurements[i];
    size[ measurement ] = 0;
  }
  return size;
}

// -------------------------- getStyle -------------------------- //

/**
 * getStyle, get style of element, check for Firefox bug
 * https://bugzilla.mozilla.org/show_bug.cgi?id=548397
 */
function getStyle( elem ) {
  var style = getComputedStyle( elem );
  if ( !style ) {
    logError( 'Style returned ' + style +
      '. Are you running this code in a hidden iframe on Firefox? ' +
      'See http://bit.ly/getsizebug1' );
  }
  return style;
}

// -------------------------- setup -------------------------- //

var isSetup = false;

var isBoxSizeOuter;

/**
 * setup
 * check isBoxSizerOuter
 * do on first getSize() rather than on page load for Firefox bug
 */
function setup() {
  // setup once
  if ( isSetup ) {
    return;
  }
  isSetup = true;

  // -------------------------- box sizing -------------------------- //

  /**
   * WebKit measures the outer-width on style.width on border-box elems
   * IE & Firefox<29 measures the inner-width
   */
  var div = document.createElement('div');
  div.style.width = '200px';
  div.style.padding = '1px 2px 3px 4px';
  div.style.borderStyle = 'solid';
  div.style.borderWidth = '1px 2px 3px 4px';
  div.style.boxSizing = 'border-box';

  var body = document.body || document.documentElement;
  body.appendChild( div );
  var style = getStyle( div );

  getSize.isBoxSizeOuter = isBoxSizeOuter = getStyleSize( style.width ) == 200;
  body.removeChild( div );

}

// -------------------------- getSize -------------------------- //

function getSize( elem ) {
  setup();

  // use querySeletor if elem is string
  if ( typeof elem == 'string' ) {
    elem = document.querySelector( elem );
  }

  // do not proceed on non-objects
  if ( !elem || typeof elem != 'object' || !elem.nodeType ) {
    return;
  }

  var style = getStyle( elem );

  // if hidden, everything is 0
  if ( style.display == 'none' ) {
    return getZeroSize();
  }

  var size = {};
  size.width = elem.offsetWidth;
  size.height = elem.offsetHeight;

  var isBorderBox = size.isBorderBox = style.boxSizing == 'border-box';

  // get all measurements
  for ( var i=0; i < measurementsLength; i++ ) {
    var measurement = measurements[i];
    var value = style[ measurement ];
    var num = parseFloat( value );
    // any 'auto', 'medium' value will be 0
    size[ measurement ] = !isNaN( num ) ? num : 0;
  }

  var paddingWidth = size.paddingLeft + size.paddingRight;
  var paddingHeight = size.paddingTop + size.paddingBottom;
  var marginWidth = size.marginLeft + size.marginRight;
  var marginHeight = size.marginTop + size.marginBottom;
  var borderWidth = size.borderLeftWidth + size.borderRightWidth;
  var borderHeight = size.borderTopWidth + size.borderBottomWidth;

  var isBorderBoxSizeOuter = isBorderBox && isBoxSizeOuter;

  // overwrite width and height if we can get it from style
  var styleWidth = getStyleSize( style.width );
  if ( styleWidth !== false ) {
    size.width = styleWidth +
      // add padding and border unless it's already including it
      ( isBorderBoxSizeOuter ? 0 : paddingWidth + borderWidth );
  }

  var styleHeight = getStyleSize( style.height );
  if ( styleHeight !== false ) {
    size.height = styleHeight +
      // add padding and border unless it's already including it
      ( isBorderBoxSizeOuter ? 0 : paddingHeight + borderHeight );
  }

  size.innerWidth = size.width - ( paddingWidth + borderWidth );
  size.innerHeight = size.height - ( paddingHeight + borderHeight );

  size.outerWidth = size.width + marginWidth;
  size.outerHeight = size.height + marginHeight;

  return size;
}

return getSize;

});

/**
 * matchesSelector v2.0.1
 * matchesSelector( element, '.selector' )
 * MIT license
 */

/*jshint browser: true, strict: true, undef: true, unused: true */

( function( window, factory ) {
  /*global define: false, module: false */
  'use strict';
  // universal module definition
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'desandro-matches-selector/matches-selector',factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory();
  } else {
    // browser global
    window.matchesSelector = factory();
  }

}( window, function factory() {
  'use strict';

  var matchesMethod = ( function() {
    var ElemProto = Element.prototype;
    // check for the standard method name first
    if ( ElemProto.matches ) {
      return 'matches';
    }
    // check un-prefixed
    if ( ElemProto.matchesSelector ) {
      return 'matchesSelector';
    }
    // check vendor prefixes
    var prefixes = [ 'webkit', 'moz', 'ms', 'o' ];

    for ( var i=0; i < prefixes.length; i++ ) {
      var prefix = prefixes[i];
      var method = prefix + 'MatchesSelector';
      if ( ElemProto[ method ] ) {
        return method;
      }
    }
  })();

  return function matchesSelector( elem, selector ) {
    return elem[ matchesMethod ]( selector );
  };

}));

/**
 * Fizzy UI utils v2.0.1
 * MIT license
 */

/*jshint browser: true, undef: true, unused: true, strict: true */

( function( window, factory ) {
  // universal module definition
  /*jshint strict: false */ /*globals define, module, require */

  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'fizzy-ui-utils/utils',[
      'desandro-matches-selector/matches-selector'
    ], function( matchesSelector ) {
      return factory( window, matchesSelector );
    });
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      window,
      require('desandro-matches-selector')
    );
  } else {
    // browser global
    window.fizzyUIUtils = factory(
      window,
      window.matchesSelector
    );
  }

}( window, function factory( window, matchesSelector ) {



var utils = {};

// ----- extend ----- //

// extends objects
utils.extend = function( a, b ) {
  for ( var prop in b ) {
    a[ prop ] = b[ prop ];
  }
  return a;
};

// ----- modulo ----- //

utils.modulo = function( num, div ) {
  return ( ( num % div ) + div ) % div;
};

// ----- makeArray ----- //

// turn element or nodeList into an array
utils.makeArray = function( obj ) {
  var ary = [];
  if ( Array.isArray( obj ) ) {
    // use object if already an array
    ary = obj;
  } else if ( obj && typeof obj.length == 'number' ) {
    // convert nodeList to array
    for ( var i=0; i < obj.length; i++ ) {
      ary.push( obj[i] );
    }
  } else {
    // array of single index
    ary.push( obj );
  }
  return ary;
};

// ----- removeFrom ----- //

utils.removeFrom = function( ary, obj ) {
  var index = ary.indexOf( obj );
  if ( index != -1 ) {
    ary.splice( index, 1 );
  }
};

// ----- getParent ----- //

utils.getParent = function( elem, selector ) {
  while ( elem != document.body ) {
    elem = elem.parentNode;
    if ( matchesSelector( elem, selector ) ) {
      return elem;
    }
  }
};

// ----- getQueryElement ----- //

// use element as selector string
utils.getQueryElement = function( elem ) {
  if ( typeof elem == 'string' ) {
    return document.querySelector( elem );
  }
  return elem;
};

// ----- handleEvent ----- //

// enable .ontype to trigger from .addEventListener( elem, 'type' )
utils.handleEvent = function( event ) {
  var method = 'on' + event.type;
  if ( this[ method ] ) {
    this[ method ]( event );
  }
};

// ----- filterFindElements ----- //

utils.filterFindElements = function( elems, selector ) {
  // make array of elems
  elems = utils.makeArray( elems );
  var ffElems = [];

  var isElement = function (elem) {
    return (
        typeof HTMLElement === "object" ? elem instanceof HTMLElement : elem && typeof elem === "object" && elem !== null && elem.nodeType === 1 && typeof elem.nodeName === "string"
    );
  };

  elems.forEach( function( elem ) {
    // check that elem is an actual element
    if ( !isElement( elem ) ) {
      return;
    }
    // add elem if no selector
    if ( !selector ) {
      ffElems.push( elem );
      return;
    }
    // filter & find items if we have a selector
    // filter
    if ( matchesSelector( elem, selector ) ) {
      ffElems.push( elem );
    }
    // find children
    var childElems = elem.querySelectorAll( selector );
    // concat childElems to filterFound array
    for ( var i=0; i < childElems.length; i++ ) {
      ffElems.push( childElems[i] );
    }
  });

  return ffElems;
};

// ----- debounceMethod ----- //

utils.debounceMethod = function( _class, methodName, threshold ) {
  // original method
  var method = _class.prototype[ methodName ];
  var timeoutName = methodName + 'Timeout';

  _class.prototype[ methodName ] = function() {
    var timeout = this[ timeoutName ];
    if ( timeout ) {
      clearTimeout( timeout );
    }
    var args = arguments;

    var _this = this;
    this[ timeoutName ] = setTimeout( function() {
      method.apply( _this, args );
      delete _this[ timeoutName ];
    }, threshold || 100 );
  };
};

// ----- docReady ----- //

utils.docReady = function( callback ) {
  if ( document.readyState == 'complete' ) {
    callback();
  } else {
    document.addEventListener( 'DOMContentLoaded', callback );
  }
};

// ----- htmlInit ----- //

// http://jamesroberts.name/blog/2010/02/22/string-functions-for-javascript-trim-to-camel-case-to-dashed-and-to-underscore/
utils.toDashed = function( str ) {
  return str.replace( /(.)([A-Z])/g, function( match, $1, $2 ) {
    return $1 + '-' + $2;
  }).toLowerCase();
};

var console = window.console;
/**
 * allow user to initialize classes via [data-namespace] or .js-namespace class
 * htmlInit( Widget, 'widgetName' )
 * options are parsed from data-namespace-options
 */
utils.htmlInit = function( WidgetClass, namespace ) {
  utils.docReady( function() {
    var dashedNamespace = utils.toDashed( namespace );
    var dataAttr = 'data-' + dashedNamespace;
    var dataAttrElems = document.querySelectorAll( '[' + dataAttr + ']' );
    var jsDashElems = document.querySelectorAll( '.js-' + dashedNamespace );
    var elems = utils.makeArray( dataAttrElems )
      .concat( utils.makeArray( jsDashElems ) );
    var dataOptionsAttr = dataAttr + '-options';
    var jQuery = window.jQuery;

    elems.forEach( function( elem ) {
      var attr = elem.getAttribute( dataAttr ) ||
        elem.getAttribute( dataOptionsAttr );
      var options;
      try {
        options = attr && JSON.parse( attr );
      } catch ( error ) {
        // log error, do not initialize
        if ( console ) {
          console.error( 'Error parsing ' + dataAttr + ' on ' + elem.className +
          ': ' + error );
        }
        return;
      }
      // initialize
      var instance = new WidgetClass( elem, options );
      // make available via $().data('layoutname')
      if ( jQuery ) {
        jQuery.data( elem, namespace, instance );
      }
    });

  });
};

// -----  ----- //

return utils;

}));

/**
 * Outlayer Item
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /* globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD - RequireJS
    define( 'outlayer/item',[
        'ev-emitter/ev-emitter',
        'get-size/get-size'
      ],
      factory
    );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS - Browserify, Webpack
    module.exports = factory(
      require('ev-emitter'),
      require('get-size')
    );
  } else {
    // browser global
    window.Outlayer = {};
    window.Outlayer.Item = factory(
      window.EvEmitter,
      window.getSize
    );
  }

}( window, function factory( EvEmitter, getSize ) {
'use strict';

// ----- helpers ----- //

function isEmptyObj( obj ) {
  for ( var prop in obj ) {
    return false;
  }
  prop = null;
  return true;
}

// -------------------------- CSS3 support -------------------------- //


var docElemStyle = document.documentElement.style;

var transitionProperty = typeof docElemStyle.transition == 'string' ?
  'transition' : 'WebkitTransition';
var transformProperty = typeof docElemStyle.transform == 'string' ?
  'transform' : 'WebkitTransform';

var transitionEndEvent = {
  WebkitTransition: 'webkitTransitionEnd',
  transition: 'transitionend'
}[ transitionProperty ];

// cache all vendor properties that could have vendor prefix
var vendorProperties = {
  transform: transformProperty,
  transition: transitionProperty,
  transitionDuration: transitionProperty + 'Duration',
  transitionProperty: transitionProperty + 'Property',
  transitionDelay: transitionProperty + 'Delay'
};

// -------------------------- Item -------------------------- //

function Item( element, layout ) {
  if ( !element ) {
    return;
  }

  this.element = element;
  // parent layout class, i.e. Masonry, Isotope, or Packery
  this.layout = layout;
  this.position = {
    x: 0,
    y: 0
  };

  this._create();
}

// inherit EvEmitter
var proto = Item.prototype = Object.create( EvEmitter.prototype );
proto.constructor = Item;

proto._create = function() {
  // transition objects
  this._transn = {
    ingProperties: {},
    clean: {},
    onEnd: {}
  };

  this.css({
    position: 'absolute'
  });
};

// trigger specified handler for event type
proto.handleEvent = function( event ) {
  var method = 'on' + event.type;
  if ( this[ method ] ) {
    this[ method ]( event );
  }
};

proto.getSize = function() {
  this.size = getSize( this.element );
};

/**
 * apply CSS styles to element
 * @param {Object} style
 */
proto.css = function( style ) {
  var elemStyle = this.element.style;

  for ( var prop in style ) {
    // use vendor property if available
    var supportedProp = vendorProperties[ prop ] || prop;
    elemStyle[ supportedProp ] = style[ prop ];
  }
};

 // measure position, and sets it
proto.getPosition = function() {
  var style = getComputedStyle( this.element );
  var isOriginLeft = this.layout._getOption('originLeft');
  var isOriginTop = this.layout._getOption('originTop');
  var xValue = style[ isOriginLeft ? 'left' : 'right' ];
  var yValue = style[ isOriginTop ? 'top' : 'bottom' ];
  // convert percent to pixels
  var layoutSize = this.layout.size;
  var x = xValue.indexOf('%') != -1 ?
    ( parseFloat( xValue ) / 100 ) * layoutSize.width : parseInt( xValue, 10 );
  var y = yValue.indexOf('%') != -1 ?
    ( parseFloat( yValue ) / 100 ) * layoutSize.height : parseInt( yValue, 10 );

  // clean up 'auto' or other non-integer values
  x = isNaN( x ) ? 0 : x;
  y = isNaN( y ) ? 0 : y;
  // remove padding from measurement
  x -= isOriginLeft ? layoutSize.paddingLeft : layoutSize.paddingRight;
  y -= isOriginTop ? layoutSize.paddingTop : layoutSize.paddingBottom;

  this.position.x = x;
  this.position.y = y;
};

// set settled position, apply padding
proto.layoutPosition = function() {
  var layoutSize = this.layout.size;
  var style = {};
  var isOriginLeft = this.layout._getOption('originLeft');
  var isOriginTop = this.layout._getOption('originTop');

  // x
  var xPadding = isOriginLeft ? 'paddingLeft' : 'paddingRight';
  var xProperty = isOriginLeft ? 'left' : 'right';
  var xResetProperty = isOriginLeft ? 'right' : 'left';

  var x = this.position.x + layoutSize[ xPadding ];
  // set in percentage or pixels
  style[ xProperty ] = this.getXValue( x );
  // reset other property
  style[ xResetProperty ] = '';

  // y
  var yPadding = isOriginTop ? 'paddingTop' : 'paddingBottom';
  var yProperty = isOriginTop ? 'top' : 'bottom';
  var yResetProperty = isOriginTop ? 'bottom' : 'top';

  var y = this.position.y + layoutSize[ yPadding ];
  // set in percentage or pixels
  style[ yProperty ] = this.getYValue( y );
  // reset other property
  style[ yResetProperty ] = '';

  this.css( style );
  this.emitEvent( 'layout', [ this ] );
};

proto.getXValue = function( x ) {
  var isHorizontal = this.layout._getOption('horizontal');
  return this.layout.options.percentPosition && !isHorizontal ?
    ( ( x / this.layout.size.width ) * 100 ) + '%' : x + 'px';
};

proto.getYValue = function( y ) {
  var isHorizontal = this.layout._getOption('horizontal');
  return this.layout.options.percentPosition && isHorizontal ?
    ( ( y / this.layout.size.height ) * 100 ) + '%' : y + 'px';
};

proto._transitionTo = function( x, y ) {
  this.getPosition();
  // get current x & y from top/left
  var curX = this.position.x;
  var curY = this.position.y;

  var compareX = parseInt( x, 10 );
  var compareY = parseInt( y, 10 );
  var didNotMove = compareX === this.position.x && compareY === this.position.y;

  // save end position
  this.setPosition( x, y );

  // if did not move and not transitioning, just go to layout
  if ( didNotMove && !this.isTransitioning ) {
    this.layoutPosition();
    return;
  }

  var transX = x - curX;
  var transY = y - curY;
  var transitionStyle = {};
  transitionStyle.transform = this.getTranslate( transX, transY );

  this.transition({
    to: transitionStyle,
    onTransitionEnd: {
      transform: this.layoutPosition
    },
    isCleaning: true
  });
};

proto.getTranslate = function( x, y ) {
  // flip cooridinates if origin on right or bottom
  var isOriginLeft = this.layout._getOption('originLeft');
  var isOriginTop = this.layout._getOption('originTop');
  x = isOriginLeft ? x : -x;
  y = isOriginTop ? y : -y;
  return 'translate3d(' + x + 'px, ' + y + 'px, 0)';
};

// non transition + transform support
proto.goTo = function( x, y ) {
  this.setPosition( x, y );
  this.layoutPosition();
};

proto.moveTo = proto._transitionTo;

proto.setPosition = function( x, y ) {
  this.position.x = parseInt( x, 10 );
  this.position.y = parseInt( y, 10 );
};

// ----- transition ----- //

/**
 * @param {Object} style - CSS
 * @param {Function} onTransitionEnd
 */

// non transition, just trigger callback
proto._nonTransition = function( args ) {
  this.css( args.to );
  if ( args.isCleaning ) {
    this._removeStyles( args.to );
  }
  for ( var prop in args.onTransitionEnd ) {
    args.onTransitionEnd[ prop ].call( this );
  }
};

/**
 * proper transition
 * @param {Object} args - arguments
 *   @param {Object} to - style to transition to
 *   @param {Object} from - style to start transition from
 *   @param {Boolean} isCleaning - removes transition styles after transition
 *   @param {Function} onTransitionEnd - callback
 */
proto.transition = function( args ) {
  // redirect to nonTransition if no transition duration
  if ( !parseFloat( this.layout.options.transitionDuration ) ) {
    this._nonTransition( args );
    return;
  }

  var _transition = this._transn;
  // keep track of onTransitionEnd callback by css property
  for ( var prop in args.onTransitionEnd ) {
    _transition.onEnd[ prop ] = args.onTransitionEnd[ prop ];
  }
  // keep track of properties that are transitioning
  for ( prop in args.to ) {
    _transition.ingProperties[ prop ] = true;
    // keep track of properties to clean up when transition is done
    if ( args.isCleaning ) {
      _transition.clean[ prop ] = true;
    }
  }

  // set from styles
  if ( args.from ) {
    this.css( args.from );
    // force redraw. http://blog.alexmaccaw.com/css-transitions
    var h = this.element.offsetHeight;
    // hack for JSHint to hush about unused var
    h = null;
  }
  // enable transition
  this.enableTransition( args.to );
  // set styles that are transitioning
  this.css( args.to );

  this.isTransitioning = true;

};

// dash before all cap letters, including first for
// WebkitTransform => -webkit-transform
function toDashedAll( str ) {
  return str.replace( /([A-Z])/g, function( $1 ) {
    return '-' + $1.toLowerCase();
  });
}

var transitionProps = 'opacity,' + toDashedAll( transformProperty );

proto.enableTransition = function(/* style */) {
  // HACK changing transitionProperty during a transition
  // will cause transition to jump
  if ( this.isTransitioning ) {
    return;
  }

  // make `transition: foo, bar, baz` from style object
  // HACK un-comment this when enableTransition can work
  // while a transition is happening
  // var transitionValues = [];
  // for ( var prop in style ) {
  //   // dash-ify camelCased properties like WebkitTransition
  //   prop = vendorProperties[ prop ] || prop;
  //   transitionValues.push( toDashedAll( prop ) );
  // }
  // munge number to millisecond, to match stagger
  var duration = this.layout.options.transitionDuration;
  duration = typeof duration == 'number' ? duration + 'ms' : duration;
  // enable transition styles
  this.css({
    transitionProperty: transitionProps,
    transitionDuration: duration,
    transitionDelay: this.staggerDelay || 0
  });
  // listen for transition end event
  this.element.addEventListener( transitionEndEvent, this, false );
};

// ----- events ----- //

proto.onwebkitTransitionEnd = function( event ) {
  this.ontransitionend( event );
};

proto.onotransitionend = function( event ) {
  this.ontransitionend( event );
};

// properties that I munge to make my life easier
var dashedVendorProperties = {
  '-webkit-transform': 'transform'
};

proto.ontransitionend = function( event ) {
  // disregard bubbled events from children
  if ( event.target !== this.element ) {
    return;
  }
  var _transition = this._transn;
  // get property name of transitioned property, convert to prefix-free
  var propertyName = dashedVendorProperties[ event.propertyName ] || event.propertyName;

  // remove property that has completed transitioning
  delete _transition.ingProperties[ propertyName ];
  // check if any properties are still transitioning
  if ( isEmptyObj( _transition.ingProperties ) ) {
    // all properties have completed transitioning
    this.disableTransition();
  }
  // clean style
  if ( propertyName in _transition.clean ) {
    // clean up style
    this.element.style[ event.propertyName ] = '';
    delete _transition.clean[ propertyName ];
  }
  // trigger onTransitionEnd callback
  if ( propertyName in _transition.onEnd ) {
    var onTransitionEnd = _transition.onEnd[ propertyName ];
    onTransitionEnd.call( this );
    delete _transition.onEnd[ propertyName ];
  }

  this.emitEvent( 'transitionEnd', [ this ] );
};

proto.disableTransition = function() {
  this.removeTransitionStyles();
  this.element.removeEventListener( transitionEndEvent, this, false );
  this.isTransitioning = false;
};

/**
 * removes style property from element
 * @param {Object} style
**/
proto._removeStyles = function( style ) {
  // clean up transition styles
  var cleanStyle = {};
  for ( var prop in style ) {
    cleanStyle[ prop ] = '';
  }
  this.css( cleanStyle );
};

var cleanTransitionStyle = {
  transitionProperty: '',
  transitionDuration: '',
  transitionDelay: ''
};

proto.removeTransitionStyles = function() {
  // remove transition
  this.css( cleanTransitionStyle );
};

// ----- stagger ----- //

proto.stagger = function( delay ) {
  delay = isNaN( delay ) ? 0 : delay;
  this.staggerDelay = delay + 'ms';
};

// ----- show/hide/remove ----- //

// remove element from DOM
proto.removeElem = function() {
  this.element.parentNode.removeChild( this.element );
  // remove display: none
  this.css({ display: '' });
  this.emitEvent( 'remove', [ this ] );
};

proto.remove = function() {
  // just remove element if no transition support or no transition
  if ( !transitionProperty || !parseFloat( this.layout.options.transitionDuration ) ) {
    this.removeElem();
    return;
  }

  // start transition
  this.once( 'transitionEnd', function() {
    this.removeElem();
  });
  this.hide();
};

proto.reveal = function() {
  delete this.isHidden;
  // remove display: none
  this.css({ display: '' });

  var options = this.layout.options;

  var onTransitionEnd = {};
  var transitionEndProperty = this.getHideRevealTransitionEndProperty('visibleStyle');
  onTransitionEnd[ transitionEndProperty ] = this.onRevealTransitionEnd;

  this.transition({
    from: options.hiddenStyle,
    to: options.visibleStyle,
    isCleaning: true,
    onTransitionEnd: onTransitionEnd
  });
};

proto.onRevealTransitionEnd = function() {
  // check if still visible
  // during transition, item may have been hidden
  if ( !this.isHidden ) {
    this.emitEvent('reveal');
  }
};

/**
 * get style property use for hide/reveal transition end
 * @param {String} styleProperty - hiddenStyle/visibleStyle
 * @returns {String}
 */
proto.getHideRevealTransitionEndProperty = function( styleProperty ) {
  var optionStyle = this.layout.options[ styleProperty ];
  // use opacity
  if ( optionStyle.opacity ) {
    return 'opacity';
  }
  // get first property
  for ( var prop in optionStyle ) {
    return prop;
  }
};

proto.hide = function() {
  // set flag
  this.isHidden = true;
  // remove display: none
  this.css({ display: '' });

  var options = this.layout.options;

  var onTransitionEnd = {};
  var transitionEndProperty = this.getHideRevealTransitionEndProperty('hiddenStyle');
  onTransitionEnd[ transitionEndProperty ] = this.onHideTransitionEnd;

  this.transition({
    from: options.visibleStyle,
    to: options.hiddenStyle,
    // keep hidden stuff hidden
    isCleaning: true,
    onTransitionEnd: onTransitionEnd
  });
};

proto.onHideTransitionEnd = function() {
  // check if still hidden
  // during transition, item may have been un-hidden
  if ( this.isHidden ) {
    this.css({ display: 'none' });
    this.emitEvent('hide');
  }
};

proto.destroy = function() {
  this.css({
    position: '',
    left: '',
    right: '',
    top: '',
    bottom: '',
    transition: '',
    transform: ''
  });
};

return Item;

}));

/*!
 * Outlayer v2.1.0
 * the brains and guts of a layout library
 * MIT license
 */

( function( window, factory ) {
  'use strict';
  // universal module definition
  /* jshint strict: false */ /* globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD - RequireJS
    define( 'outlayer/outlayer',[
        'ev-emitter/ev-emitter',
        'get-size/get-size',
        'fizzy-ui-utils/utils',
        './item'
      ],
      function( EvEmitter, getSize, utils, Item ) {
        return factory( window, EvEmitter, getSize, utils, Item);
      }
    );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS - Browserify, Webpack
    module.exports = factory(
      window,
      require('ev-emitter'),
      require('get-size'),
      require('fizzy-ui-utils'),
      require('./item')
    );
  } else {
    // browser global
    window.Outlayer = factory(
      window,
      window.EvEmitter,
      window.getSize,
      window.fizzyUIUtils,
      window.Outlayer.Item
    );
  }

}( window, function factory( window, EvEmitter, getSize, utils, Item ) {
'use strict';

// ----- vars ----- //

var console = window.console;
var jQuery = window.jQuery;
var noop = function() {};

// -------------------------- Outlayer -------------------------- //

// globally unique identifiers
var GUID = 0;
// internal store of all Outlayer intances
var instances = {};


/**
 * @param {Element, String} element
 * @param {Object} options
 * @constructor
 */
function Outlayer( element, options ) {
  var queryElement = utils.getQueryElement( element );
  if ( !queryElement ) {
    if ( console ) {
      console.error( 'Bad element for ' + this.constructor.namespace +
        ': ' + ( queryElement || element ) );
    }
    return;
  }
  this.element = queryElement;
  // add jQuery
  if ( jQuery ) {
    this.$element = jQuery( this.element );
  }

  // options
  this.options = utils.extend( {}, this.constructor.defaults );
  this.option( options );

  // add id for Outlayer.getFromElement
  var id = ++GUID;
  this.element.outlayerGUID = id; // expando
  instances[ id ] = this; // associate via id

  // kick it off
  this._create();

  var isInitLayout = this._getOption('initLayout');
  if ( isInitLayout ) {
    this.layout();
  }
}

// settings are for internal use only
Outlayer.namespace = 'outlayer';
Outlayer.Item = Item;

// default options
Outlayer.defaults = {
  containerStyle: {
    position: 'relative'
  },
  initLayout: true,
  originLeft: true,
  originTop: true,
  resize: true,
  resizeContainer: true,
  equalheight: false,
  // item options
  transitionDuration: '0.4s',
  hiddenStyle: {
    opacity: 0,
    transform: 'scale(0.001)'
  },
  visibleStyle: {
    opacity: 1,
    transform: 'scale(1)'
  }
};

var proto = Outlayer.prototype;
// inherit EvEmitter
utils.extend( proto, EvEmitter.prototype );

/**
 * set options
 * @param {Object} opts
 */
proto.option = function( opts ) {
  utils.extend( this.options, opts );
};

/**
 * get backwards compatible option value, check old name
 */
proto._getOption = function( option ) {
  var oldOption = this.constructor.compatOptions[ option ];
  return oldOption && this.options[ oldOption ] !== undefined ?
    this.options[ oldOption ] : this.options[ option ];
};

Outlayer.compatOptions = {
  // currentName: oldName
  initLayout: 'isInitLayout',
  horizontal: 'isHorizontal',
  layoutInstant: 'isLayoutInstant',
  originLeft: 'isOriginLeft',
  originTop: 'isOriginTop',
  resize: 'isResizeBound',
  resizeContainer: 'isResizingContainer'
};

proto._create = function() {
  // get items from children
  this.reloadItems();
  // elements that affect layout, but are not laid out
  this.stamps = [];
  this.stamp( this.options.stamp );
  // set container style
  utils.extend( this.element.style, this.options.containerStyle );

  // bind resize method
  var canBindResize = this._getOption('resize');
  if ( canBindResize ) {
    this.bindResize();
  }
};

// goes through all children again and gets bricks in proper order
proto.reloadItems = function() {
  // collection of item elements
  this.items = this._itemize( this.element.children );
};


/**
 * turn elements into Outlayer.Items to be used in layout
 * @param {Array or NodeList or HTMLElement} elems
 * @returns {Array} items - collection of new Outlayer Items
 */
proto._itemize = function( elems ) {

  var itemElems = this._filterFindItemElements( elems );
  var Item = this.constructor.Item;

  // create new Outlayer Items for collection
  var items = [];
  for ( var i=0; i < itemElems.length; i++ ) {
    var elem = itemElems[i];
    var item = new Item( elem, this );
    items.push( item );
  }

  return items;
};

/**
 * get item elements to be used in layout
 * @param {Array or NodeList or HTMLElement} elems
 * @returns {Array} items - item elements
 */
proto._filterFindItemElements = function( elems ) {
  return utils.filterFindElements( elems, this.options.itemSelector );
};

/**
 * getter method for getting item elements
 * @returns {Array} elems - collection of item elements
 */
proto.getItemElements = function() {
  return this.items.map( function( item ) {
    return item.element;
  });
};

// ----- init & layout ----- //

/**
 * lays out all items
 */
proto.layout = function() {
  this._resetLayout();
  this._manageStamps();

  // don't animate first layout
  var layoutInstant = this._getOption('layoutInstant');
  var isInstant = layoutInstant !== undefined ?
    layoutInstant : !this._isLayoutInited;
  this.layoutItems( this.items, isInstant );

  // flag for initalized
  this._isLayoutInited = true;
};

// _init is alias for layout
proto._init = proto.layout;

/**
 * logic before any new layout
 */
proto._resetLayout = function() {
  this.getSize();
};


proto.getSize = function() {
  this.size = getSize( this.element );
};

/**
 * get measurement from option, for columnWidth, rowHeight, gutter
 * if option is String -> get element from selector string, & get size of element
 * if option is Element -> get size of element
 * else use option as a number
 *
 * @param {String} measurement
 * @param {String} size - width or height
 * @private
 */
proto._getMeasurement = function( measurement, size ) {
  var option = this.options[ measurement ];
  var elem;
  if ( !option ) {
    // default to 0
    this[ measurement ] = 0;
  } else {
    // use option as an element
    if ( typeof option == 'string' ) {
      elem = this.element.querySelector( option );
    } else if ( option instanceof HTMLElement ) {
      elem = option;
    }
    // use size of element, if element
    this[ measurement ] = elem ? getSize( elem )[ size ] : option;
  }
};

/**
 * layout a collection of item elements
 * @api public
 */
proto.layoutItems = function( items, isInstant ) {
  items = this._getItemsForLayout( items );

  this._layoutItems( items, isInstant );

  this._postLayout();
};

/**
 * get the items to be laid out
 * you may want to skip over some items
 * @param {Array} items
 * @returns {Array} items
 */
proto._getItemsForLayout = function( items ) {
  return items.filter( function( item ) {
    return !item.isIgnored;
  });
};

/**
 * layout items
 * @param {Array} items
 * @param {Boolean} isInstant
 */
proto._layoutItems = function( items, isInstant ) {
  this._emitCompleteOnItems( 'layout', items );

  if ( !items || !items.length ) {
    // no items, emit event with empty array
    return;
  }

  var queue = [];

  items.forEach( function( item ) {
    // get x/y object from method
    var position = this._getItemLayoutPosition( item );
    // enqueue
    position.item = item;
    position.isInstant = isInstant || item.isLayoutInstant;
    queue.push( position );
  }, this );

  this._processLayoutQueue( queue );
};

/**
 * get item layout position
 * @param {Outlayer.Item} item
 * @returns {Object} x and y position
 */
proto._getItemLayoutPosition = function( /* item */ ) {
  return {
    x: 0,
    y: 0
  };
};

/**
 * iterate over array and position each item
 * Reason being - separating this logic prevents 'layout invalidation'
 * thx @paul_irish
 * @param {Array} queue
 */
proto._processLayoutQueue = function( queue ) {
  this.updateStagger();
  queue.forEach( function( obj, i ) {
    this._positionItem( obj.item, obj.x, obj.y, obj.isInstant, i );
  }, this );
};

// set stagger from option in milliseconds number
proto.updateStagger = function() {
  var stagger = this.options.stagger;
  if ( stagger === null || stagger === undefined ) {
    this.stagger = 0;
    return;
  }
  this.stagger = getMilliseconds( stagger );
  return this.stagger;
};

/**
 * Sets position of item in DOM
 * @param {Outlayer.Item} item
 * @param {Number} x - horizontal position
 * @param {Number} y - vertical position
 * @param {Boolean} isInstant - disables transitions
 */
proto._positionItem = function( item, x, y, isInstant, i ) {
  if ( isInstant ) {
    // if not transition, just set CSS
    item.goTo( x, y );
  } else {
    item.stagger( i * this.stagger );
    item.moveTo( x, y );
  }
};

/**
 * Any logic you want to do after each layout,
 * i.e. size the container
 */
proto._postLayout = function() {
  this.resizeContainer();
};

proto.resizeContainer = function() {
  var isResizingContainer = this._getOption('resizeContainer');
  if ( !isResizingContainer ) {
    return;
  }
  var size = this._getContainerSize();
  if ( size ) {
    this._setContainerMeasure( size.width, true );
    this._setContainerMeasure( size.height, false );
  }
};

/**
 * Sets width or height of container if returned
 * @returns {Object} size
 *   @param {Number} width
 *   @param {Number} height
 */
proto._getContainerSize = noop;

/**
 * @param {Number} measure - size of width or height
 * @param {Boolean} isWidth
 */
proto._setContainerMeasure = function( measure, isWidth ) {
  if ( measure === undefined ) {
    return;
  }

  var elemSize = this.size;
  // add padding and border width if border box
  if ( elemSize.isBorderBox ) {
    measure += isWidth ? elemSize.paddingLeft + elemSize.paddingRight +
      elemSize.borderLeftWidth + elemSize.borderRightWidth :
      elemSize.paddingBottom + elemSize.paddingTop +
      elemSize.borderTopWidth + elemSize.borderBottomWidth;
  }

  measure = Math.max( measure, 0 );
  this.element.style[ isWidth ? 'width' : 'height' ] = measure + 'px';
};

/**
 * emit eventComplete on a collection of items events
 * @param {String} eventName
 * @param {Array} items - Outlayer.Items
 */
proto._emitCompleteOnItems = function( eventName, items ) {
  var _this = this;
  function onComplete() {
    _this.dispatchEvent( eventName + 'Complete', null, [ items ] );
  }

  var count = items.length;
  if ( !items || !count ) {
    onComplete();
    return;
  }

  var doneCount = 0;
  function tick() {
    doneCount++;
    if ( doneCount == count ) {
      onComplete();
    }
  }

  // bind callback
  items.forEach( function( item ) {
    item.once( eventName, tick );
  });
};

/**
 * emits events via EvEmitter and jQuery events
 * @param {String} type - name of event
 * @param {Event} event - original event
 * @param {Array} args - extra arguments
 */
proto.dispatchEvent = function( type, event, args ) {
  // add original event to arguments
  var emitArgs = event ? [ event ].concat( args ) : args;
  this.emitEvent( type, emitArgs );

  if ( jQuery ) {
    // set this.$element
    this.$element = this.$element || jQuery( this.element );
    if ( event ) {
      // create jQuery event
      var $event = jQuery.Event( event );
      $event.type = type;
      this.$element.trigger( $event, args );
    } else {
      // just trigger with type if no event available
      this.$element.trigger( type, args );
    }
  }
};

// -------------------------- ignore & stamps -------------------------- //


/**
 * keep item in collection, but do not lay it out
 * ignored items do not get skipped in layout
 * @param {Element} elem
 */
proto.ignore = function( elem ) {
  var item = this.getItem( elem );
  if ( item ) {
    item.isIgnored = true;
  }
};

/**
 * return item to layout collection
 * @param {Element} elem
 */
proto.unignore = function( elem ) {
  var item = this.getItem( elem );
  if ( item ) {
    delete item.isIgnored;
  }
};

/**
 * adds elements to stamps
 * @param {NodeList, Array, Element, or String} elems
 */
proto.stamp = function( elems ) {
  elems = this._find( elems );
  if ( !elems ) {
    return;
  }

  this.stamps = this.stamps.concat( elems );
  // ignore
  elems.forEach( this.ignore, this );
};

/**
 * removes elements to stamps
 * @param {NodeList, Array, or Element} elems
 */
proto.unstamp = function( elems ) {
  elems = this._find( elems );
  if ( !elems ){
    return;
  }

  elems.forEach( function( elem ) {
    // filter out removed stamp elements
    utils.removeFrom( this.stamps, elem );
    this.unignore( elem );
  }, this );
};

/**
 * finds child elements
 * @param {NodeList, Array, Element, or String} elems
 * @returns {Array} elems
 */
proto._find = function( elems ) {
  if ( !elems ) {
    return;
  }
  // if string, use argument as selector string
  if ( typeof elems == 'string' ) {
    elems = this.element.querySelectorAll( elems );
  }
  elems = utils.makeArray( elems );
  return elems;
};

proto._manageStamps = function() {
  if ( !this.stamps || !this.stamps.length ) {
    return;
  }

  this._getBoundingRect();

  this.stamps.forEach( this._manageStamp, this );
};

// update boundingLeft / Top
proto._getBoundingRect = function() {
  // get bounding rect for container element
  var boundingRect = this.element.getBoundingClientRect();
  var size = this.size;
  this._boundingRect = {
    left: boundingRect.left + size.paddingLeft + size.borderLeftWidth,
    top: boundingRect.top + size.paddingTop + size.borderTopWidth,
    right: boundingRect.right - ( size.paddingRight + size.borderRightWidth ),
    bottom: boundingRect.bottom - ( size.paddingBottom + size.borderBottomWidth )
  };
};

/**
 * @param {Element} stamp
**/
proto._manageStamp = noop;

/**
 * get x/y position of element relative to container element
 * @param {Element} elem
 * @returns {Object} offset - has left, top, right, bottom
 */
proto._getElementOffset = function( elem ) {
  var boundingRect = elem.getBoundingClientRect();
  var thisRect = this._boundingRect;
  var size = getSize( elem );
  var offset = {
    left: boundingRect.left - thisRect.left - size.marginLeft,
    top: boundingRect.top - thisRect.top - size.marginTop,
    right: thisRect.right - boundingRect.right - size.marginRight,
    bottom: thisRect.bottom - boundingRect.bottom - size.marginBottom
  };
  return offset;
};

// -------------------------- resize -------------------------- //

// enable event handlers for listeners
// i.e. resize -> onresize
proto.handleEvent = utils.handleEvent;

/**
 * Bind layout to window resizing
 */
proto.bindResize = function() {
  window.addEventListener( 'resize', this );
  this.isResizeBound = true;
};

/**
 * Unbind layout to window resizing
 */
proto.unbindResize = function() {
  window.removeEventListener( 'resize', this );
  this.isResizeBound = false;
};

proto.onresize = function() {
  this.resize();
};

utils.debounceMethod( Outlayer, 'onresize', 100 );

proto.resize = function() {
  // don't trigger if size did not change
  // or if resize was unbound. See #9
  if ( !this.isResizeBound || !this.needsResizeLayout() ) {
    return;
  }

  this.layout();
};

/**
 * check if layout is needed post layout
 * @returns Boolean
 */
proto.needsResizeLayout = function() {
  var size = getSize( this.element );
  // check that this.size and size are there
  // IE8 triggers resize on body size change, so they might not be
  var hasSizes = this.size && size;
  return hasSizes && size.innerWidth !== this.size.innerWidth;
};

// -------------------------- methods -------------------------- //

/**
 * add items to Outlayer instance
 * @param {Array or NodeList or Element} elems
 * @returns {Array} items - Outlayer.Items
**/
proto.addItems = function( elems ) {
  var items = this._itemize( elems );
  // add items to collection
  if ( items.length ) {
    this.items = this.items.concat( items );
  }
  return items;
};

/**
 * Layout newly-appended item elements
 * @param {Array or NodeList or Element} elems
 */
proto.appended = function( elems ) {
  var items = this.addItems( elems );
  if ( !items.length ) {
    return;
  }
  // layout and reveal just the new items
  this.layoutItems( items, true );
  this.reveal( items );
};

/**
 * Layout prepended elements
 * @param {Array or NodeList or Element} elems
 */
proto.prepended = function( elems ) {
  var items = this._itemize( elems );
  if ( !items.length ) {
    return;
  }
  // add items to beginning of collection
  var previousItems = this.items.slice(0);
  this.items = items.concat( previousItems );
  // start new layout
  this._resetLayout();
  this._manageStamps();
  // layout new stuff without transition
  this.layoutItems( items, true );
  this.reveal( items );
  // layout previous items
  this.layoutItems( previousItems );
};

/**
 * reveal a collection of items
 * @param {Array of Outlayer.Items} items
 */
proto.reveal = function( items ) {
  this._emitCompleteOnItems( 'reveal', items );
  if ( !items || !items.length ) {
    return;
  }
  var stagger = this.updateStagger();
  items.forEach( function( item, i ) {
    item.stagger( i * stagger );
    item.reveal();
  });
};

/**
 * hide a collection of items
 * @param {Array of Outlayer.Items} items
 */
proto.hide = function( items ) {
  this._emitCompleteOnItems( 'hide', items );
  if ( !items || !items.length ) {
    return;
  }
  var stagger = this.updateStagger();
  items.forEach( function( item, i ) {
    item.stagger( i * stagger );
    item.hide();
  });
};

/**
 * reveal item elements
 * @param {Array}, {Element}, {NodeList} items
 */
proto.revealItemElements = function( elems ) {
  var items = this.getItems( elems );
  this.reveal( items );
};

/**
 * hide item elements
 * @param {Array}, {Element}, {NodeList} items
 */
proto.hideItemElements = function( elems ) {
  var items = this.getItems( elems );
  this.hide( items );
};

/**
 * get Outlayer.Item, given an Element
 * @param {Element} elem
 * @param {Function} callback
 * @returns {Outlayer.Item} item
 */
proto.getItem = function( elem ) {
  // loop through items to get the one that matches
  for ( var i=0; i < this.items.length; i++ ) {
    var item = this.items[i];
    if ( item.element == elem ) {
      // return item
      return item;
    }
  }
};

/**
 * get collection of Outlayer.Items, given Elements
 * @param {Array} elems
 * @returns {Array} items - Outlayer.Items
 */
proto.getItems = function( elems ) {
  elems = utils.makeArray( elems );
  var items = [];
  elems.forEach( function( elem ) {
    var item = this.getItem( elem );
    if ( item ) {
      items.push( item );
    }
  }, this );

  return items;
};

/**
 * remove element(s) from instance and DOM
 * @param {Array or NodeList or Element} elems
 */
proto.remove = function( elems ) {
  var removeItems = this.getItems( elems );

  this._emitCompleteOnItems( 'remove', removeItems );

  // bail if no items to remove
  if ( !removeItems || !removeItems.length ) {
    return;
  }

  removeItems.forEach( function( item ) {
    item.remove();
    // remove item from collection
    utils.removeFrom( this.items, item );
  }, this );
};

// ----- destroy ----- //

// remove and disable Outlayer instance
proto.destroy = function() {
  // clean up dynamic styles
  var style = this.element.style;
  style.height = '';
  style.position = '';
  style.width = '';
  // destroy items
  this.items.forEach( function( item ) {
    item.destroy();
  });

  this.unbindResize();

  var id = this.element.outlayerGUID;
  delete instances[ id ]; // remove reference to instance by id
  delete this.element.outlayerGUID;
  // remove data for jQuery
  if ( jQuery ) {
    jQuery.removeData( this.element, this.constructor.namespace );
  }

};

// -------------------------- data -------------------------- //

/**
 * get Outlayer instance from element
 * @param {Element} elem
 * @returns {Outlayer}
 */
Outlayer.data = function( elem ) {
  elem = utils.getQueryElement( elem );
  var id = elem && elem.outlayerGUID;
  return id && instances[ id ];
};


// -------------------------- create Outlayer class -------------------------- //

/**
 * create a layout class
 * @param {String} namespace
 */
Outlayer.create = function( namespace, options ) {
  // sub-class Outlayer
  var Layout = subclass( Outlayer );
  // apply new options and compatOptions
  Layout.defaults = utils.extend( {}, Outlayer.defaults );
  utils.extend( Layout.defaults, options );
  Layout.compatOptions = utils.extend( {}, Outlayer.compatOptions  );

  Layout.namespace = namespace;

  Layout.data = Outlayer.data;

  // sub-class Item
  Layout.Item = subclass( Item );

  // -------------------------- declarative -------------------------- //

  utils.htmlInit( Layout, namespace );

  // -------------------------- jQuery bridge -------------------------- //

  // make into jQuery plugin
  if ( jQuery && jQuery.bridget ) {
    jQuery.bridget( namespace, Layout );
  }

  return Layout;
};

function subclass( Parent ) {
  function SubClass() {
    Parent.apply( this, arguments );
  }

  SubClass.prototype = Object.create( Parent.prototype );
  SubClass.prototype.constructor = SubClass;

  return SubClass;
}

// ----- helpers ----- //

// how many milliseconds are in each unit
var msUnits = {
  ms: 1,
  s: 1000
};

// munge time-like parameter into millisecond number
// '0.4s' -> 40
function getMilliseconds( time ) {
  if ( typeof time == 'number' ) {
    return time;
  }
  var matches = time.match( /(^\d*\.?\d*)(\w*)/ );
  var num = matches && matches[1];
  var unit = matches && matches[2];
  if ( !num.length ) {
    return 0;
  }
  num = parseFloat( num );
  var mult = msUnits[ unit ] || 1;
  return num * mult;
}

// ----- fin ----- //

// back in global
Outlayer.Item = Item;

return Outlayer;

}));

/**
 * Isotope Item
**/

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'isotope/item',[
        'outlayer/outlayer'
      ],
      factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      require('outlayer')
    );
  } else {
    // browser global
    window.Isotope = window.Isotope || {};
    window.Isotope.Item = factory(
      window.Outlayer
    );
  }

}( window, function factory( Outlayer ) {
'use strict';

// -------------------------- Item -------------------------- //

// sub-class Outlayer Item
function Item() {
  Outlayer.Item.apply( this, arguments );
}

var proto = Item.prototype = Object.create( Outlayer.Item.prototype );

var _create = proto._create;
proto._create = function() {
  // assign id, used for original-order sorting
  this.id = this.layout.itemGUID++;
  _create.call( this );
  this.sortData = {};
};

proto.updateSortData = function() {
  if ( this.isIgnored ) {
    return;
  }
  // default sorters
  this.sortData.id = this.id;
  // for backward compatibility
  this.sortData['original-order'] = this.id;
  this.sortData.random = Math.random();
  // go thru getSortData obj and apply the sorters
  var getSortData = this.layout.options.getSortData;
  var sorters = this.layout._sorters;
  for ( var key in getSortData ) {
    var sorter = sorters[ key ];
    this.sortData[ key ] = sorter( this.element, this );
  }
};

var _destroy = proto.destroy;
proto.destroy = function() {
  // call super
  _destroy.apply( this, arguments );
  // reset display, #741
  this.css({
    display: ''
  });
};

return Item;

}));

/**
 * Isotope LayoutMode
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'isotope/layout-mode',[
        'get-size/get-size',
        'outlayer/outlayer'
      ],
      factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      require('get-size'),
      require('outlayer')
    );
  } else {
    // browser global
    window.Isotope = window.Isotope || {};
    window.Isotope.LayoutMode = factory(
      window.getSize,
      window.Outlayer
    );
  }

}( window, function factory( getSize, Outlayer ) {
  'use strict';

  // layout mode class
  function LayoutMode( isotope ) {
    this.isotope = isotope;
    // link properties
    if ( isotope ) {
      this.options = isotope.options[ this.namespace ];
      this.element = isotope.element;
      this.items = isotope.filteredItems;
      this.size = isotope.size;
    }
  }

  var proto = LayoutMode.prototype;

  /**
   * some methods should just defer to default Outlayer method
   * and reference the Isotope instance as `this`
  **/
  var facadeMethods = [
    '_resetLayout',
    '_getItemLayoutPosition',
    '_manageStamp',
    '_getContainerSize',
    '_getElementOffset',
    'needsResizeLayout',
    '_getOption'
  ];

  facadeMethods.forEach( function( methodName ) {
    proto[ methodName ] = function() {
      return Outlayer.prototype[ methodName ].apply( this.isotope, arguments );
    };
  });

  // -----  ----- //

  // for horizontal layout modes, check vertical size
  proto.needsVerticalResizeLayout = function() {
    // don't trigger if size did not change
    var size = getSize( this.isotope.element );
    // check that this.size and size are there
    // IE8 triggers resize on body size change, so they might not be
    var hasSizes = this.isotope.size && size;
    return hasSizes && size.innerHeight != this.isotope.size.innerHeight;
  };

  // ----- measurements ----- //

  proto._getMeasurement = function() {
    this.isotope._getMeasurement.apply( this, arguments );
  };

  proto.getColumnWidth = function() {
    this.getSegmentSize( 'column', 'Width' );
  };

  proto.getRowHeight = function() {
    this.getSegmentSize( 'row', 'Height' );
  };

  /**
   * get columnWidth or rowHeight
   * segment: 'column' or 'row'
   * size 'Width' or 'Height'
  **/
  proto.getSegmentSize = function( segment, size ) {
    var segmentName = segment + size;
    var outerSize = 'outer' + size;
    // columnWidth / outerWidth // rowHeight / outerHeight
    this._getMeasurement( segmentName, outerSize );
    // got rowHeight or columnWidth, we can chill
    if ( this[ segmentName ] ) {
      return;
    }
    // fall back to item of first element
    var firstItemSize = this.getFirstItemSize();
    this[ segmentName ] = firstItemSize && firstItemSize[ outerSize ] ||
      // or size of container
      this.isotope.size[ 'inner' + size ];
  };

  proto.getFirstItemSize = function() {
    var firstItem = this.isotope.filteredItems[0];
    return firstItem && firstItem.element && getSize( firstItem.element );
  };

  // ----- methods that should reference isotope ----- //

  proto.layout = function() {
    this.isotope.layout.apply( this.isotope, arguments );
  };

  proto.getSize = function() {
    this.isotope.getSize();
    this.size = this.isotope.size;
  };

  // -------------------------- create -------------------------- //

  LayoutMode.modes = {};

  LayoutMode.create = function( namespace, options ) {

    function Mode() {
      LayoutMode.apply( this, arguments );
    }

    Mode.prototype = Object.create( proto );
    Mode.prototype.constructor = Mode;

    // default options
    if ( options ) {
      Mode.options = options;
    }

    Mode.prototype.namespace = namespace;
    // register in Isotope
    LayoutMode.modes[ namespace ] = Mode;

    return Mode;
  };

  return LayoutMode;

}));

/*!
 * Masonry v4.1.0
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'masonry/masonry',[
        'outlayer/outlayer',
        'get-size/get-size'
      ],
      factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      require('outlayer'),
      require('get-size')
    );
  } else {
    // browser global
    window.Masonry = factory(
      window.Outlayer,
      window.getSize
    );
  }

}( window, function factory( Outlayer, getSize ) {



// -------------------------- masonryDefinition -------------------------- //

  // create an Outlayer layout class
  var Masonry = Outlayer.create('masonry');
  // isFitWidth -> fitWidth
  Masonry.compatOptions.fitWidth = 'isFitWidth';

  Masonry.prototype._resetLayout = function() {
    this.getSize();
    this._getMeasurement( 'columnWidth', 'outerWidth' );
    this._getMeasurement( 'gutter', 'outerWidth' );
    this.measureColumns();

    // reset column Y
    this.colYs = [];
    for ( var i=0; i < this.cols; i++ ) {
      this.colYs.push( 0 );
    }

    this.maxY = 0;
  };

  Masonry.prototype.measureColumns = function() {
    this.getContainerWidth();
    // if columnWidth is 0, default to outerWidth of first item
    if ( !this.columnWidth ) {
      var firstItem = this.items[0];
      var firstItemElem = firstItem && firstItem.element;
      // columnWidth fall back to item of first element
      this.columnWidth = firstItemElem && getSize( firstItemElem ).outerWidth ||
        // if first elem has no width, default to size of container
        this.containerWidth;
    }

    var columnWidth = this.columnWidth += this.gutter;

    // calculate columns
    var containerWidth = this.containerWidth + this.gutter;
    var cols = containerWidth / columnWidth;
    // fix rounding errors, typically with gutters
    var excess = columnWidth - containerWidth % columnWidth;
    // if overshoot is less than a pixel, round up, otherwise floor it
    var mathMethod = excess && excess < 1 ? 'round' : 'floor';
    cols = Math[ mathMethod ]( cols );
    this.cols = Math.max( cols, 1 );
  };

  Masonry.prototype.getContainerWidth = function() {
    // container is parent if fit width
    var isFitWidth = this._getOption('fitWidth');
    var container = isFitWidth ? this.element.parentNode : this.element;
    // check that this.size and size are there
    // IE8 triggers resize on body size change, so they might not be
    var size = getSize( container );
    this.containerWidth = size && size.innerWidth;
  };

  Masonry.prototype._getItemLayoutPosition = function( item ) {
    item.getSize();
    // how many columns does this brick span
    var remainder = item.size.outerWidth % this.columnWidth;
    var mathMethod = remainder && remainder < 1 ? 'round' : 'ceil';
    // round if off by 1 pixel, otherwise use ceil
    var colSpan = Math[ mathMethod ]( item.size.outerWidth / this.columnWidth );
    colSpan = Math.min( colSpan, this.cols );

    var colGroup = this._getColGroup( colSpan );
    // get the minimum Y value from the columns
    var minimumY = Math.min.apply( Math, colGroup );
    var shortColIndex = colGroup.indexOf( minimumY );

    // position the brick
    var position = {
      x: this.columnWidth * shortColIndex,
      y: minimumY
    };

    // apply setHeight to necessary columns
    var setHeight = minimumY + item.size.outerHeight;
    var setSpan = this.cols + 1 - colGroup.length;
    for ( var i = 0; i < setSpan; i++ ) {
      this.colYs[ shortColIndex + i ] = setHeight;
    }

    return position;
  };

  /**
   * @param {Number} colSpan - number of columns the element spans
   * @returns {Array} colGroup
   */
  Masonry.prototype._getColGroup = function( colSpan ) {
    if ( colSpan < 2 ) {
      // if brick spans only one column, use all the column Ys
      return this.colYs;
    }

    var colGroup = [];
    // how many different places could this brick fit horizontally
    var groupCount = this.cols + 1 - colSpan;
    // for each group potential horizontal position
    for ( var i = 0; i < groupCount; i++ ) {
      // make an array of colY values for that one group
      var groupColYs = this.colYs.slice( i, i + colSpan );
      // and get the max value of the array
      colGroup[i] = Math.max.apply( Math, groupColYs );
    }
    return colGroup;
  };

  Masonry.prototype._manageStamp = function( stamp ) {
    var stampSize = getSize( stamp );
    var offset = this._getElementOffset( stamp );
    // get the columns that this stamp affects
    var isOriginLeft = this._getOption('originLeft');
    var firstX = isOriginLeft ? offset.left : offset.right;
    var lastX = firstX + stampSize.outerWidth;
    var firstCol = Math.floor( firstX / this.columnWidth );
    firstCol = Math.max( 0, firstCol );
    var lastCol = Math.floor( lastX / this.columnWidth );
    // lastCol should not go over if multiple of columnWidth #425
    lastCol -= lastX % this.columnWidth ? 0 : 1;
    lastCol = Math.min( this.cols - 1, lastCol );
    // set colYs to bottom of the stamp

    var isOriginTop = this._getOption('originTop');
    var stampMaxY = ( isOriginTop ? offset.top : offset.bottom ) +
      stampSize.outerHeight;
    for ( var i = firstCol; i <= lastCol; i++ ) {
      this.colYs[i] = Math.max( stampMaxY, this.colYs[i] );
    }
  };

  Masonry.prototype._getContainerSize = function() {
    this.maxY = Math.max.apply( Math, this.colYs );
    var size = {
      height: this.maxY
    };

    if ( this._getOption('fitWidth') ) {
      size.width = this._getContainerFitWidth();
    }

    return size;
  };

  Masonry.prototype._getContainerFitWidth = function() {
    var unusedCols = 0;
    // count unused columns
    var i = this.cols;
    while ( --i ) {
      if ( this.colYs[i] !== 0 ) {
        break;
      }
      unusedCols++;
    }
    // fit container to columns that have been used
    return ( this.cols - unusedCols ) * this.columnWidth - this.gutter;
  };

  Masonry.prototype.needsResizeLayout = function() {
    var previousWidth = this.containerWidth;
    this.getContainerWidth();
    return previousWidth != this.containerWidth;
  };

  return Masonry;

}));

/*!
 * Masonry layout mode
 * sub-classes Masonry
 * http://masonry.desandro.com
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'isotope/layout-modes/masonry',[
        '../layout-mode',
        'masonry/masonry'
      ],
      factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      require('../layout-mode'),
      require('masonry-layout')
    );
  } else {
    // browser global
    factory(
      window.Isotope.LayoutMode,
      window.Masonry
    );
  }

}( window, function factory( LayoutMode, Masonry ) {
'use strict';

// -------------------------- masonryDefinition -------------------------- //

  // create an Outlayer layout class
  var MasonryMode = LayoutMode.create('masonry');

  var proto = MasonryMode.prototype;

  var keepModeMethods = {
    _getElementOffset: true,
    layout: true,
    _getMeasurement: true
  };

  // inherit Masonry prototype
  for ( var method in Masonry.prototype ) {
    // do not inherit mode methods
    if ( !keepModeMethods[ method ] ) {
      proto[ method ] = Masonry.prototype[ method ];
    }
  }

  var measureColumns = proto.measureColumns;
  proto.measureColumns = function() {
    // set items, used if measuring first item
    this.items = this.isotope.filteredItems;
    measureColumns.call( this );
  };

  // point to mode options for fitWidth
  var _getOption = proto._getOption;
  proto._getOption = function( option ) {
    if ( option == 'fitWidth' ) {
      return this.options.isFitWidth !== undefined ?
        this.options.isFitWidth : this.options.fitWidth;
    }
    return _getOption.apply( this.isotope, arguments );
  };

  return MasonryMode;

}));

/**
 * fitRows layout mode
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'isotope/layout-modes/fit-rows',[
        '../layout-mode'
      ],
      factory );
  } else if ( typeof exports == 'object' ) {
    // CommonJS
    module.exports = factory(
      require('../layout-mode')
    );
  } else {
    // browser global
    factory(
      window.Isotope.LayoutMode
    );
  }

}( window, function factory( LayoutMode ) {
'use strict';

var FitRows = LayoutMode.create('fitRows');

var proto = FitRows.prototype;

proto._resetLayout = function() {
  this.x = 0;
  this.y = 0;
  this.maxY = 0;
  this._getMeasurement( 'gutter', 'outerWidth' );
};

proto._getItemLayoutPosition = function( item ) {
  item.getSize();

  var itemWidth = item.size.outerWidth + this.gutter;
  // if this element cannot fit in the current row
  var containerWidth = this.isotope.size.innerWidth + this.gutter;
  if ( this.x !== 0 && itemWidth + this.x > containerWidth ) {
    this.x = 0;
    this.y = this.maxY;
  }

  var position = {
    x: this.x,
    y: this.y
  };

  this.maxY = Math.max( this.maxY, this.y + item.size.outerHeight );
  this.x += itemWidth;

  return position;
};

proto._getContainerSize = function() {
  return { height: this.maxY };
};

return FitRows;

}));

/**
 * vertical layout mode
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( 'isotope/layout-modes/vertical',[
        '../layout-mode'
      ],
      factory );
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      require('../layout-mode')
    );
  } else {
    // browser global
    factory(
      window.Isotope.LayoutMode
    );
  }

}( window, function factory( LayoutMode ) {
'use strict';

var Vertical = LayoutMode.create( 'vertical', {
  horizontalAlignment: 0
});

var proto = Vertical.prototype;

proto._resetLayout = function() {
  this.y = 0;
};

proto._getItemLayoutPosition = function( item ) {
  item.getSize();
  var x = ( this.isotope.size.innerWidth - item.size.outerWidth ) *
    this.options.horizontalAlignment;
  var y = this.y;
  this.y += item.size.outerHeight;
  return { x: x, y: y };
};

proto._getContainerSize = function() {
  return { height: this.y };
};

return Vertical;

}));

/*!
 * Isotope v3.0.0
 *
 * Licensed GPLv3 for open source use
 * or Isotope Commercial License for commercial use
 *
 * http://isotope.metafizzy.co
 * Copyright 2016 Metafizzy
 */

( function( window, factory ) {
  // universal module definition
  /* jshint strict: false */ /*globals define, module, require */
  if ( typeof define == 'function' && define.amd ) {
    // AMD
    define( [
        'outlayer/outlayer',
        'get-size/get-size',
        'desandro-matches-selector/matches-selector',
        'fizzy-ui-utils/utils',
        './item',
        './layout-mode',
        // include default layout modes
        './layout-modes/masonry',
        './layout-modes/fit-rows',
        './layout-modes/vertical'
      ],
      function( Outlayer, getSize, matchesSelector, utils, Item, LayoutMode ) {
        return factory( window, Outlayer, getSize, matchesSelector, utils, Item, LayoutMode );
      });
  } else if ( typeof module == 'object' && module.exports ) {
    // CommonJS
    module.exports = factory(
      window,
      require('outlayer'),
      require('get-size'),
      require('desandro-matches-selector'),
      require('fizzy-ui-utils'),
      require('./item'),
      require('./layout-mode'),
      // include default layout modes
      require('./layout-modes/masonry'),
      require('./layout-modes/fit-rows'),
      require('./layout-modes/vertical')
    );
  } else {
    // browser global
    window.Isotope = factory(
      window,
      window.Outlayer,
      window.getSize,
      window.matchesSelector,
      window.fizzyUIUtils,
      window.Isotope.Item,
      window.Isotope.LayoutMode
    );
  }

}( window, function factory( window, Outlayer, getSize, matchesSelector, utils,
  Item, LayoutMode ) {



// -------------------------- vars -------------------------- //

var jQuery = window.jQuery;

// -------------------------- helpers -------------------------- //

var trim = String.prototype.trim ?
  function( str ) {
    return str.trim();
  } :
  function( str ) {
    return str.replace( /^\s+|\s+$/g, '' );
  };

// -------------------------- isotopeDefinition -------------------------- //

  // create an Outlayer layout class
  var Isotope = Outlayer.create( 'isotope', {
    layoutMode: 'masonry',
    isJQueryFiltering: true,
    sortAscending: true
  });

  Isotope.Item = Item;
  Isotope.LayoutMode = LayoutMode;

  var proto = Isotope.prototype;

  proto._create = function() {
    this.itemGUID = 0;
    // functions that sort items
    this._sorters = {};
    this._getSorters();
    // call super
    Outlayer.prototype._create.call( this );

    // create layout modes
    this.modes = {};
    // start filteredItems with all items
    this.filteredItems = this.items;
    // keep of track of sortBys
    this.sortHistory = [ 'original-order' ];
    // create from registered layout modes
    for ( var name in LayoutMode.modes ) {
      this._initLayoutMode( name );
    }
  };

  proto.reloadItems = function() {
    // reset item ID counter
    this.itemGUID = 0;
    // call super
    Outlayer.prototype.reloadItems.call( this );
  };

  proto._itemize = function() {
    var items = Outlayer.prototype._itemize.apply( this, arguments );
    // assign ID for original-order
    for ( var i=0; i < items.length; i++ ) {
      var item = items[i];
      item.id = this.itemGUID++;
    }
    this._updateItemsSortData( items );
    return items;
  };


  // -------------------------- layout -------------------------- //

  proto._initLayoutMode = function( name ) {
    var Mode = LayoutMode.modes[ name ];
    // set mode options
    // HACK extend initial options, back-fill in default options
    var initialOpts = this.options[ name ] || {};
    this.options[ name ] = Mode.options ?
      utils.extend( Mode.options, initialOpts ) : initialOpts;
    // init layout mode instance
    this.modes[ name ] = new Mode( this );
  };


  proto.layout = function() {
    // if first time doing layout, do all magic
    if ( !this._isLayoutInited && this._getOption('initLayout') ) {
      this.arrange();
      return;
    }
    this._layout();
  };

  // private method to be used in layout() & magic()
  proto._layout = function() {
    // don't animate first layout
    var isInstant = this._getIsInstant();
    // layout flow
    this._resetLayout();
    this._manageStamps();
    this.layoutItems( this.filteredItems, isInstant );

    // flag for initalized
    this._isLayoutInited = true;
  };

  // filter + sort + layout
  proto.arrange = function( opts ) {
    // set any options pass
    this.option( opts );
    this._getIsInstant();
    // filter, sort, and layout

    // filter
    var filtered = this._filter( this.items );
    this.filteredItems = filtered.matches;

    this._bindArrangeComplete();

    if ( this._isInstant ) {
      this._noTransition( this._hideReveal, [ filtered ] );
    } else {
      this._hideReveal( filtered );
    }

    this._sort();
    this._layout();
  };
  // alias to _init for main plugin method
  proto._init = proto.arrange;

  proto._hideReveal = function( filtered ) {
    this.reveal( filtered.needReveal );
    this.hide( filtered.needHide );
  };

  // HACK
  // Don't animate/transition first layout
  // Or don't animate/transition other layouts
  proto._getIsInstant = function() {
    var isLayoutInstant = this._getOption('layoutInstant');
    var isInstant = isLayoutInstant !== undefined ? isLayoutInstant :
      !this._isLayoutInited;
    this._isInstant = isInstant;
    return isInstant;
  };

  // listen for layoutComplete, hideComplete and revealComplete
  // to trigger arrangeComplete
  proto._bindArrangeComplete = function() {
    // listen for 3 events to trigger arrangeComplete
    var isLayoutComplete, isHideComplete, isRevealComplete;
    var _this = this;
    function arrangeParallelCallback() {
      if ( isLayoutComplete && isHideComplete && isRevealComplete ) {
        _this.dispatchEvent( 'arrangeComplete', null, [ _this.filteredItems ] );
      }
    }
    this.once( 'layoutComplete', function() {
      isLayoutComplete = true;
      arrangeParallelCallback();
    });
    this.once( 'hideComplete', function() {
      isHideComplete = true;
      arrangeParallelCallback();
    });
    this.once( 'revealComplete', function() {
      isRevealComplete = true;
      arrangeParallelCallback();
    });
  };

  // -------------------------- filter -------------------------- //

  proto._filter = function( items ) {
    var filter = this.options.filter;
    filter = filter || '*';
    var matches = [];
    var hiddenMatched = [];
    var visibleUnmatched = [];

    var test = this._getFilterTest( filter );

    // test each item
    for ( var i=0; i < items.length; i++ ) {
      var item = items[i];
      if ( item.isIgnored ) {
        continue;
      }
      // add item to either matched or unmatched group
      var isMatched = test( item );
      // item.isFilterMatched = isMatched;
      // add to matches if its a match
      if ( isMatched ) {
        matches.push( item );
      }
      // add to additional group if item needs to be hidden or revealed
      if ( isMatched && item.isHidden ) {
        hiddenMatched.push( item );
      } else if ( !isMatched && !item.isHidden ) {
        visibleUnmatched.push( item );
      }
    }

    // return collections of items to be manipulated
    return {
      matches: matches,
      needReveal: hiddenMatched,
      needHide: visibleUnmatched
    };
  };

  // get a jQuery, function, or a matchesSelector test given the filter
  proto._getFilterTest = function( filter ) {
    if ( jQuery && this.options.isJQueryFiltering ) {
      // use jQuery
      return function( item ) {
        return jQuery( item.element ).is( filter );
      };
    }
    if ( typeof filter == 'function' ) {
      // use filter as function
      return function( item ) {
        return filter( item.element );
      };
    }
    // default, use filter as selector string
    return function( item ) {
      return matchesSelector( item.element, filter );
    };
  };

  // -------------------------- sorting -------------------------- //

  /**
   * @params {Array} elems
   * @public
   */
  proto.updateSortData = function( elems ) {
    // get items
    var items;
    if ( elems ) {
      elems = utils.makeArray( elems );
      items = this.getItems( elems );
    } else {
      // update all items if no elems provided
      items = this.items;
    }

    this._getSorters();
    this._updateItemsSortData( items );
  };

  proto._getSorters = function() {
    var getSortData = this.options.getSortData;
    for ( var key in getSortData ) {
      var sorter = getSortData[ key ];
      this._sorters[ key ] = mungeSorter( sorter );
    }
  };

  /**
   * @params {Array} items - of Isotope.Items
   * @private
   */
  proto._updateItemsSortData = function( items ) {
    // do not update if no items
    var len = items && items.length;

    for ( var i=0; len && i < len; i++ ) {
      var item = items[i];
      item.updateSortData();
    }
  };

  // ----- munge sorter ----- //

  // encapsulate this, as we just need mungeSorter
  // other functions in here are just for munging
  var mungeSorter = ( function() {
    // add a magic layer to sorters for convienent shorthands
    // `.foo-bar` will use the text of .foo-bar querySelector
    // `[foo-bar]` will use attribute
    // you can also add parser
    // `.foo-bar parseInt` will parse that as a number
    function mungeSorter( sorter ) {
      // if not a string, return function or whatever it is
      if ( typeof sorter != 'string' ) {
        return sorter;
      }
      // parse the sorter string
      var args = trim( sorter ).split(' ');
      var query = args[0];
      // check if query looks like [an-attribute]
      var attrMatch = query.match( /^\[(.+)\]$/ );
      var attr = attrMatch && attrMatch[1];
      var getValue = getValueGetter( attr, query );
      // use second argument as a parser
      var parser = Isotope.sortDataParsers[ args[1] ];
      // parse the value, if there was a parser
      sorter = parser ? function( elem ) {
        return elem && parser( getValue( elem ) );
      } :
      // otherwise just return value
      function( elem ) {
        return elem && getValue( elem );
      };

      return sorter;
    }

    // get an attribute getter, or get text of the querySelector
    function getValueGetter( attr, query ) {
      // if query looks like [foo-bar], get attribute
      if ( attr ) {
        return function getAttribute( elem ) {
          return elem.getAttribute( attr );
        };
      }

      // otherwise, assume its a querySelector, and get its text
      return function getChildText( elem ) {
        var child = elem.querySelector( query );
        return child && child.textContent;
      };
    }

    return mungeSorter;
  })();

  // parsers used in getSortData shortcut strings
  Isotope.sortDataParsers = {
    'parseInt': function( val ) {
      return parseInt( val, 10 );
    },
    'parseFloat': function( val ) {
      return parseFloat( val );
    }
  };

  // ----- sort method ----- //

  // sort filteredItem order
  proto._sort = function() {
    var sortByOpt = this.options.sortBy;
    if ( !sortByOpt ) {
      return;
    }
    // concat all sortBy and sortHistory
    var sortBys = [].concat.apply( sortByOpt, this.sortHistory );
    // sort magic
    var itemSorter = getItemSorter( sortBys, this.options.sortAscending );
    this.filteredItems.sort( itemSorter );
    // keep track of sortBy History
    if ( sortByOpt != this.sortHistory[0] ) {
      // add to front, oldest goes in last
      this.sortHistory.unshift( sortByOpt );
    }
  };

  // returns a function used for sorting
  function getItemSorter( sortBys, sortAsc ) {
    return function sorter( itemA, itemB ) {
      // cycle through all sortKeys
      for ( var i = 0; i < sortBys.length; i++ ) {
        var sortBy = sortBys[i];
        var a = itemA.sortData[ sortBy ];
        var b = itemB.sortData[ sortBy ];
        if ( a > b || a < b ) {
          // if sortAsc is an object, use the value given the sortBy key
          var isAscending = sortAsc[ sortBy ] !== undefined ? sortAsc[ sortBy ] : sortAsc;
          var direction = isAscending ? 1 : -1;
          return ( a > b ? 1 : -1 ) * direction;
        }
      }
      return 0;
    };
  }

  // -------------------------- methods -------------------------- //

  // get layout mode
  proto._mode = function() {
    var layoutMode = this.options.layoutMode;
    var mode = this.modes[ layoutMode ];
    if ( !mode ) {
      // TODO console.error
      throw new Error( 'No layout mode: ' + layoutMode );
    }
    // HACK sync mode's options
    // any options set after init for layout mode need to be synced
    mode.options = this.options[ layoutMode ];
    return mode;
  };

  proto._resetLayout = function() {
    // trigger original reset layout
    Outlayer.prototype._resetLayout.call( this );
    this._mode()._resetLayout();
  };

  proto._getItemLayoutPosition = function( item  ) {
    return this._mode()._getItemLayoutPosition( item );
  };

  proto._manageStamp = function( stamp ) {
    this._mode()._manageStamp( stamp );
  };

  proto._getContainerSize = function() {
    return this._mode()._getContainerSize();
  };

  proto.needsResizeLayout = function() {
    return this._mode().needsResizeLayout();
  };

  // -------------------------- adding & removing -------------------------- //

  // HEADS UP overwrites default Outlayer appended
  proto.appended = function( elems ) {
    var items = this.addItems( elems );
    if ( !items.length ) {
      return;
    }
    // filter, layout, reveal new items
    var filteredItems = this._filterRevealAdded( items );
    // add to filteredItems
    this.filteredItems = this.filteredItems.concat( filteredItems );
  };

  // HEADS UP overwrites default Outlayer prepended
  proto.prepended = function( elems ) {
    var items = this._itemize( elems );
    if ( !items.length ) {
      return;
    }
    // start new layout
    this._resetLayout();
    this._manageStamps();
    // filter, layout, reveal new items
    var filteredItems = this._filterRevealAdded( items );
    // layout previous items
    this.layoutItems( this.filteredItems );
    // add to items and filteredItems
    this.filteredItems = filteredItems.concat( this.filteredItems );
    this.items = items.concat( this.items );
  };

  proto._filterRevealAdded = function( items ) {
    var filtered = this._filter( items );
    this.hide( filtered.needHide );
    // reveal all new items
    this.reveal( filtered.matches );
    // layout new items, no transition
    this.layoutItems( filtered.matches, true );
    return filtered.matches;
  };

  /**
   * Filter, sort, and layout newly-appended item elements
   * @param {Array or NodeList or Element} elems
   */
  proto.insert = function( elems ) {
    var items = this.addItems( elems );
    if ( !items.length ) {
      return;
    }
    // append item elements
    var i, item;
    var len = items.length;
    for ( i=0; i < len; i++ ) {
      item = items[i];
      this.element.appendChild( item.element );
    }
    // filter new stuff
    var filteredInsertItems = this._filter( items ).matches;
    // set flag
    for ( i=0; i < len; i++ ) {
      items[i].isLayoutInstant = true;
    }
    this.arrange();
    // reset flag
    for ( i=0; i < len; i++ ) {
      delete items[i].isLayoutInstant;
    }
    this.reveal( filteredInsertItems );
  };

  var _remove = proto.remove;
  proto.remove = function( elems ) {
    elems = utils.makeArray( elems );
    var removeItems = this.getItems( elems );
    // do regular thing
    _remove.call( this, elems );
    // bail if no items to remove
    var len = removeItems && removeItems.length;
    // remove elems from filteredItems
    for ( var i=0; len && i < len; i++ ) {
      var item = removeItems[i];
      // remove item from collection
      utils.removeFrom( this.filteredItems, item );
    }
  };

  proto.shuffle = function() {
    // update random sortData
    for ( var i=0; i < this.items.length; i++ ) {
      var item = this.items[i];
      item.sortData.random = Math.random();
    }
    this.options.sortBy = 'random';
    this._sort();
    this._layout();
  };

  /**
   * trigger fn without transition
   * kind of hacky to have this in the first place
   * @param {Function} fn
   * @param {Array} args
   * @returns ret
   * @private
   */
  proto._noTransition = function( fn, args ) {
    // save transitionDuration before disabling
    var transitionDuration = this.options.transitionDuration;
    // disable transition
    this.options.transitionDuration = 0;
    // do it
    var returnValue = fn.apply( this, args );
    // re-enable transition for reveal
    this.options.transitionDuration = transitionDuration;
    return returnValue;
  };

  // ----- helper methods ----- //

  /**
   * getter method for getting filtered item elements
   * @returns {Array} elems - collection of item elements
   */
  proto.getFilteredItemElements = function() {
    return this.filteredItems.map( function( item ) {
      return item.element;
    });
  };

  // -----  ----- //
  function fitRowsDefinition( LayoutMode ) {

    var FitRows = LayoutMode.create('fitRows');

    FitRows.prototype._resetLayout = function() {
      this.x = 0;
      this.y = 0;
      this.maxY = 0;
      this.row = 0;
      this.rows = [];
      this._getMeasurement( 'gutter', 'outerWidth' );

      if (this.isotope.options.equalheight) {
        for (var i=0; i < this.isotope.items.length; i++) {
          this.isotope.items[i].css({
            height: 'auto'
          });
        }
      }
    };

    /**
     * Working but glicthy with newly appended element via ajax
     * must reinvoke isotope('layout') to properly realign the horizontal position
     * after isotope('appended), not sure why?
     */
    FitRows.prototype._getItemLayoutPosition = function( item ) {
      
      item.getSize();
      
      var itemWidth = item.size.outerWidth;
      
      // if this element cannot fit in the current row
      // need to add extra pixel to avoid layout dropping in some edge
      // bootstrap grid in firefox
      var containerWidth = Math.ceil(this.isotope.size.innerWidth + 1);

      if ( this.x !== 0 && itemWidth + this.x > containerWidth ) {
        this.x = 0;
        this.y = this.maxY;
      }
     
      // New row?
      if (this.x == 0 && this.y != 0) {
        this.row++;
      }

      var position = {
        x: this.x,
        y: this.y
      };

      this.maxY = Math.max(this.maxY, this.y + item.size.outerHeight);
      this.x += itemWidth;
      
      
      // Compare Y from this row and previous row
      if (typeof this.rows[this.row] == 'undefined') {
        this.rows[this.row] = [];
        this.rows[this.row].start = this.y;
        this.rows[this.row].end = this.maxY;
      }
      else {
        this.rows[this.row].end = Math.max(this.rows[this.row].end, this.maxY);
      }

      // Record row number to item
      item.row = this.row;

      return position;
    };


    FitRows.prototype._equalHeight = function() {
      
      // Should we use this.isotope.filteredItems or this.isotope.items?
      
      for (var i=0; i < this.isotope.items.length; i++) {
        var row = this.isotope.items[i].row,
            data = this.rows[row];
        
        if (data) {
          var height =  data.end - data.start;

          height -= this.isotope.items[i].size.borderTopWidth + this.isotope.items[i].size.borderBottomWidth;
          height -= this.isotope.items[i].size.marginTop + this.isotope.items[i].size.marginBottom;
          height -= this.gutter.height || 0;
          
          if (this.isotope.items[i].size.isBorderBox == false) {
            height -= this.isotope.items[i].size.paddingTop + this.isotope.items[i].size.paddingBottom;
          }
          
          this.isotope.items[i].size.height = height;
            this.isotope.items[i].css({
              height : height.toString() + 'px',
            });
        }
      }
    };


    FitRows.prototype._getContainerSize = function() {
      if (this.isotope.options.equalheight) {
        this._equalHeight();
      }
      return { height: this.maxY };
    };
    //this.layout();

    return FitRows;

  }

  if ( typeof define === 'function' && define.amd ) {
    // AMD
    define( [
        '../layout-mode'
      ],
      fitRowsDefinition );
  } else if ( typeof exports === 'object' ) {
    // CommonJS
    module.exports = fitRowsDefinition(
      require('../layout-mode')
    );
  } else {
    // browser global

    fitRowsDefinition(
      window.Isotope.LayoutMode
    );
  }

  return Isotope;


}));



/*!
# @author Fernando Lujan
#
# @title Filterade.js
# @url https://github.com/FernandoLujan/filterade-js
# @desc Filters and pagination with options, from Canada
# @desc Rewritten by Dream-Theme.com for The7 WordPress theme (the7.io)
*/

;(function ( $, window, document, undefined ) {
	var $document = $(document),
		$window = $(window);
	return $.fn.Filterade = function(options) {
		var activeFilter, 
			activePage,
			activeSort,
			activeOrder,
			$container, 
			defaults,
			filterControls, 
			sortControls,
			orderControls,
			controlsSelecter,
			controlsSelecterChecked,
			filterResults, 
			getPageCount, 
			initialize, 
			$nodes,
			paginationMode,
			pageControls, 
			pageCount, 
			paginateControls, 
			paginateResults,
			updateView,
			sortNodes;
	
		defaults = {
			useFilters: false,
			useSorting: false,
			filterControls: '.filter-controls',
			sortControls: '.sort-controls',
			orderControls: '.order-controls',
			controlsSelecter: 'input',
			controlsSelecterChecked: 'input[checked="checked"]',
			defaultFilter: 'all',
			defaultSort: 'date',
			defaultOrder: 'desc',
			selectAll: 'all',
			paginationMode: 'pages',
			pageLimit: 15,
			pageControls: '.page-controls',
			//previousButtonClass: 'previous',
			previousButtonClass: 'nav-prev',
			//previousButtonLabel: 'Previous',
			previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
			//nextButtonClass: 'next',
			nextButtonClass: 'nav-next',
			//nextButtonLabel: 'Next',
			nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
			//loadMoreButtonClass: 'load-more',
			loadMoreButtonClass: 'button-load-more',
			loadMoreButtonLabel: 'Load more',
			pagerClass: 'page',
			//activeClass: 'active',
			activeClass: 'act',
			log: false
		};
	
		//$container = $(this.selector);
		$container = $(this);
		paginationMode = options.paginationMode || defaults.paginationMode;
		pageControls = $(options.pageControls || defaults.pageControls);
		filterControls = $(options.filterControls || defaults.filterControls);
		sortControls = $(options.sortControls || defaults.sortControls);
		orderControls = $(options.orderControls || defaults.orderControls);
		controlsSelecter = options.controlsSelecter || defaults.controlsSelecter;
		controlsSelecterChecked = options.controlsSelecterChecked || defaults.controlsSelecterChecked;
		activePage = 1;
		var phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderHStrokeExists = $(".sticky-top-line").exists();
		if(phantomStickyExists || sideHeaderHStrokeExists){
			var $phantom = $(".masthead");
		}else{
			var $phantom = $("#phantom");
		}
	
		$nodes = $([]);
		$nodes.$nodesCache = $([]);
		$container.find("> article, .wf-cell").each(function() {
			var $this = $(this);
			$nodes.push({
				node: this,
				$node: $this,
				name: $this.attr("data-name"),
				date: new Date($this.attr("data-date"))
			});
			$nodes.$nodesCache.push(this);
		});
		pageCount = Math.ceil($nodes.length / options.pageLimit);
	
		/*
			# @getPageCount
			# Calculate page count
		*/
		getPageCount = function() {
		var nodeCount;
			if (paginationMode === "pages" || paginationMode === "load-more") {
				nodeCount = 0;
				$nodes.each(function() {
					if (this.$node.hasClass("visible")) {
						return nodeCount++;
					}
				});
	
				pageCount = Math.ceil(nodeCount / (options.pageLimit || defaults.pageLimit));
			}
		};
		
		/*
			# @paginateControls
			# Hide/display content based on pagination
		*/
		//Changed by Alla 13.09.2016 (remove li wrap from links)
		paginateControls = function() {
			if (paginationMode === "pages") {
				var i, _i;
				pageControls.empty();
				if (pageCount > 1) {
					if (activePage !== 1) {
					pageControls.prepend('<a href="#" class="' + (options.previousButtonClass || defaults.previousButtonClass) + '">' + (options.previousButtonLabel || defaults.previousButtonLabel) + '</a>');
					}

					var pagesToShow = 5;
                    var pagesToShowMinus1 = pagesToShow - 1;
					var pagesBefore = Math.floor(pagesToShowMinus1/2);
                    var pagesAfter = Math.ceil(pagesToShowMinus1/2);
                    var startPage = Math.max(activePage - pagesBefore, 1);
                    var endPage = activePage + pagesAfter;

                    if(startPage <= pagesBefore) {
                        endPage = startPage + pagesToShowMinus1;
                    }

                    if(endPage > pageCount) {
                        startPage = Math.max(pageCount - pagesToShowMinus1, 1);
                        endPage = pageCount;
                    }

                    var leftPagesPack = $('<div style="display: none;"></div>');
                    var rightPagesPack = $('<div style="display: none;"></div>');

					for (i = _i = 1; 1 <= pageCount ? _i <= pageCount : _i >= pageCount; i = 1 <= pageCount ? ++_i : --_i) {
					    if (i<startPage && i!=1) {
					        leftPagesPack.append('<a href="#" class="' + (options.pagerClass || defaults.pagerClass) + '" data-page="' + +i + '">' + i + '</a>');
                            continue;
                        }

                        if (i==startPage && leftPagesPack.children().length) {
                            pageControls.append(leftPagesPack);
                        }

                        if (i>endPage && i!=pageCount) {
                            rightPagesPack.append('<a href="#" class="' + (options.pagerClass || defaults.pagerClass) + '" data-page="' + +i + '">' + i + '</a>');
                            continue;
                        }

                        if (i==pageCount && rightPagesPack.children().length) {
                            pageControls.append(rightPagesPack);
                        }

					    pageControls.append('<a href="#" class="' + (options.pagerClass || defaults.pagerClass) + '" data-page="' + +i + '">' + i + '</a>');
					   
					}

					if (activePage < pageCount) {
						pageControls.append('<a href="#" class="' + (options.nextButtonClass || defaults.nextButtonClass) + '">' + (options.nextButtonLabel || defaults.nextButtonLabel) + '</a>');
					}
					pageControls.find('a[data-page="' + activePage + '"]').addClass(options.activeClass || defaults.activeClass);
					var pagerClass = options.pagerClass || defaults.pagerClass;
					pagerClass = pagerClass.trim().replace(" ", ".");
					pageControls.find('a.' + pagerClass).click(function(e) {
						e.preventDefault();
						activePage = parseInt($(this).attr('data-page'));
						pageControls.find('a.' + (options.activeClass || defaults.activeClass)).removeClass(options.activeClass || defaults.activeClass);
						pageControls.find('a[data-page="' + activePage + '"]').addClass(options.activeClass || defaults.activeClass);
						//Scroll to top of container
						if($container.hasClass("dt-css-grid")){
							var $scrollTo = $container.parent().offset().top - 40;
						}else{
							var $scrollTo = $container.offset().top - 40;
						}
						$("html, body").animate({
							scrollTop: $scrollTo - $phantom.height()
						}, 400);
						return updateView();

						
					});
					pageControls.find('a.' + (options.previousButtonClass || defaults.previousButtonClass)).click(function(e) {
						e.preventDefault();
						activePage--;
						//Scroll to top of container
						if($container.hasClass("dt-css-grid")){
							var $scrollTo = $container.parent().offset().top - 40;
						}else{
							var $scrollTo = $container.offset().top - 40;
						}

						
						$("html, body").animate({
							scrollTop: $scrollTo - $phantom.height()
						}, 400);
						return updateView();
					});
					return pageControls.find('a.' + (options.nextButtonClass || defaults.nextButtonClass)).click(function(e) {
						e.preventDefault();
						activePage++;
						//Scroll to top of container
						if($container.hasClass("dt-css-grid")){
							var $scrollTo = $container.parent().offset().top - 40;
						}else{
							var $scrollTo = $container.offset().top - 40;
						}

						$("html, body").animate({
							scrollTop: $scrollTo - $phantom.height()
						}, 400);
						return updateView();
					});
				}
			}
			else if (paginationMode === "load-more") {
				pageControls.addClass("hidden");

				if (pageCount > 1) {
					if (activePage < pageCount) {
						pageControls.removeClass("hidden");
					}

					var loadMoreClass = options.loadMoreButtonClass || defaults.loadMoreButtonClass;
					loadMoreClass = loadMoreClass.trim().replace(" ", ".");

					return pageControls.find('a:not(.filtrade-ready).' + loadMoreClass).click(function(e) {
						e.preventDefault();
						$(this).addClass("filtrade-ready");

						if (activePage >= pageCount) {
							return false;
						}

						activePage++;

						return updateView();
					});
				}
			}
		};
		
		/*
			# @paginateResults
			# Only displays results within the active page
		*/
		paginateResults = function() {
			if (paginationMode === "pages" || paginationMode === "load-more") {
				var nodeIndex = 0,
					$nodesHide = $([]),
					$nodesShow = $([]);
	
				 $nodes.each(function(i) {
					if (this.$node.hasClass("visible")) {
						nodeIndex++;
						if ((paginationMode === "pages") && nodeIndex > (activePage * (options.pageLimit || defaults.pageLimit) - (options.pageLimit || defaults.pageLimit)) && nodeIndex <= ((options.pageLimit || defaults.pageLimit) * activePage)) {
							$nodesShow.push(this.node);
						}
						else if ((paginationMode === "load-more") && nodeIndex <= ((options.pageLimit || defaults.pageLimit) * activePage)) {
							$nodesShow.push(this.node);
						} 
						else {
							$nodesHide.push(this.node);
						}
					}
				});
				$nodesHide.removeClass("visible").addClass("hidden");
				$nodesShow.removeClass("hidden").addClass("visible");
				$nodesShow.removeClass("first");
				$nodesShow.first().addClass("first");
				
			$container.trigger("updateReady");
				
			}
		};
		
		/*
			# @filterResults
			# Hide/display content based on the active filter
		*/
		filterResults = function() {
			var $nodesHide = $([]),
				$nodesShow = $([]);
	
			if (options.useFilters || defaults.useFilters) {
				if (activeFilter === (options.selectAll || defaults.selectAll)) {
					$nodesShow = $nodes.$nodesCache;
				}
				else {
					$nodes.each(function(i) {
						if (!this.$node.hasClass(activeFilter.replace(/^\./, ""))) {
							$nodesHide.push(this.node);
						}
						else {
							$nodesShow.push(this.node);
						}
					});
				}
			}
			else {
				$nodesShow = $nodes.$nodesCache;
			}
	
			$nodesHide.removeClass("visible").addClass("hidden");
			$nodesShow.removeClass("hidden").addClass("visible");
		};
	
		/*
			# @sortNodes
			# Sorts nodes and mekes changes to DOM
		*/
		sortNodes = function() {
			if (activeSort === "date" && activeOrder ==="desc") {
				$nodes.sort(function(a, b){return b.date - a.date});
			}
			else if (activeSort === "date" && activeOrder ==="asc") {
				$nodes.sort(function(a, b){return a.date - b.date});
			}
			else if (activeSort === "name" && activeOrder ==="desc") {
				$nodes.sort(function(a, b){
					var x = a.name.toLowerCase();
					var y = b.name.toLowerCase();
					if (x > y) {return -1;}
					if (x < y) {return 1;}
					return 0;
				});
			}
			else if (activeSort === "name" && activeOrder ==="asc") {
				$nodes.sort(function(a, b){
					var x = a.name.toLowerCase();
					var y = b.name.toLowerCase();
					if (x < y) {return -1;}
					if (x > y) {return 1;}
					return 0;
				});
			}
	
			$nodes.$nodesCache = $([]);
			$nodes.each(function() {
				$nodes.$nodesCache.push(this.node);
			});
			if($container.find(".paginator").length > 0){
				$nodes.$nodesCache.detach().insertBefore($container.find(".paginator"));
			}else{
	
				$nodes.$nodesCache.detach().appendTo($container);
			}
		};
	
		/*
			# @updateView
			# Update controls and containers
		*/
		updateView = function() {
			filterResults();
			getPageCount();
			paginateResults();
			paginateControls();
			
			if($container.hasClass("lazy-loading-mode")){
				var buttonOffset = $container.find('.button-load-more').offset();
				if ( buttonOffset && dtGlobals.winScrollTop > (buttonOffset.top - $window.height()) / 2){
					$container.find('.button-load-more').trigger('click');
				
				}	
			}
			$(".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible:not(.shown)").layzrBlogInitialisation();
			$(".layzr-loading-on .jquery-filter.dt-css-grid-wrap .wf-cell.visible").layzrBlogInitialisation();
			
			//$(".dt-css-grid").loadingCssEffects();
			$container.trigger("updateReady");
		};
	
		/*
			# @initialize
			# Configures plugin defaults and updates the document when done
		*/
		initialize = function() {
			if (options.useFilters || defaults.useFilters) {
				activeFilter = (filterControls.find(controlsSelecterChecked).attr("data-filter") || options.defaultFilter || defaults.defaultFilter);
	
				filterControls.find(controlsSelecter).click(function(e) {
					activeFilter = $(this).attr("data-filter");
					activePage = 1;
					updateView();
				});
			}
	
			if (options.useSorting || defaults.useSorting) {
				activeSort = (sortControls.find(controlsSelecterChecked).attr("data-by") || options.defaultSort || defaults.defaultSort);
				activeOrder = (orderControls.find(controlsSelecterChecked).attr("data-sort") || options.defaultOrder || defaults.defaultOrder);
	
				sortControls.find(controlsSelecter).click(function(e) {
					if (this.getAttribute("data-by") === "date") activeSort = "date";
					else activeSort = "name";
	
					sortNodes();
					activePage = 1;
					updateView();
				});
	
				orderControls.find(controlsSelecter).click(function(e) {
					if (this.getAttribute("data-sort") === "desc") activeOrder = "desc";
					else activeOrder = "asc";
	
					sortNodes();
					activePage = 1;
					updateView();
				});
			}
			return updateView();
		};
		return initialize();
	};
})( jQuery, window, document );
'use strict';

/**
 * Copyright Marc J. Schmidt. See the LICENSE file at the top-level
 * directory of this distribution and at
 * https://github.com/marcj/css-element-queries/blob/master/LICENSE.
 */
(function (root, factory) {
    if (typeof define === "function" && define.amd) {
        define(factory);
    } else if (typeof exports === "object") {
        module.exports = factory();
    } else {
        root.ResizeSensor = factory();
    }
}(typeof window !== 'undefined' ? window : this, function () {

    // Make sure it does not throw in a SSR (Server Side Rendering) situation
    if (typeof window === "undefined") {
        return null;
    }
    // Only used for the dirty checking, so the event callback count is limited to max 1 call per fps per sensor.
    // In combination with the event based resize sensor this saves cpu time, because the sensor is too fast and
    // would generate too many unnecessary events.
    var requestAnimationFrame = window.requestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        function (fn) {
            return window.setTimeout(fn, 20);
        };

    /**
     * Iterate over each of the provided element(s).
     *
     * @param {HTMLElement|HTMLElement[]} elements
     * @param {Function}                  callback
     */
    function forEachElement(elements, callback){
        var elementsType = Object.prototype.toString.call(elements);
        var isCollectionTyped = ('[object Array]' === elementsType
            || ('[object NodeList]' === elementsType)
            || ('[object HTMLCollection]' === elementsType)
            || ('[object Object]' === elementsType)
            || ('undefined' !== typeof jQuery && elements instanceof jQuery) //jquery
            || ('undefined' !== typeof Elements && elements instanceof Elements) //mootools
        );
        var i = 0, j = elements.length;
        if (isCollectionTyped) {
            for (; i < j; i++) {
                callback(elements[i]);
            }
        } else {
            callback(elements);
        }
    }

    /**
    * Get element size
    * @param {HTMLElement} element
    * @returns {Object} {width, height}
    */
    function getElementSize(element) {
        if (!element.getBoundingClientRect) {
            return {
                width: element.offsetWidth,
                height: element.offsetHeight
            }
        }

        var rect = element.getBoundingClientRect();
        return {
            width: Math.round(rect.width),
            height: Math.round(rect.height)
        }
    }

    /**
     * Class for dimension change detection.
     *
     * @param {Element|Element[]|Elements|jQuery} element
     * @param {Function} callback
     *
     * @constructor
     */
    var ResizeSensor = function(element, callback) {
        /**
         *
         * @constructor
         */
        function EventQueue() {
            var q = [];
            this.add = function(ev) {
                q.push(ev);
            };

            var i, j;
            this.call = function(sizeInfo) {
                for (i = 0, j = q.length; i < j; i++) {
                    q[i].call(this, sizeInfo);
                }
            };

            this.remove = function(ev) {
                var newQueue = [];
                for(i = 0, j = q.length; i < j; i++) {
                    if(q[i] !== ev) newQueue.push(q[i]);
                }
                q = newQueue;
            };

            this.length = function() {
                return q.length;
            }
        }

        /**
         *
         * @param {HTMLElement} element
         * @param {Function}    resized
         */
        function attachResizeEvent(element, resized) {
            if (!element) return;
            if (element.resizedAttached) {
                element.resizedAttached.add(resized);
                return;
            }

            element.resizedAttached = new EventQueue();
            element.resizedAttached.add(resized);

            element.resizeSensor = document.createElement('div');
            element.resizeSensor.dir = 'ltr';
            element.resizeSensor.className = 'resize-sensor';
            var style = 'pointer-events: none; position: absolute; left: 0px; top: 0px; right: 0; bottom: 0; ' +
                'overflow: hidden; z-index: -1; visibility: hidden; max-width: 100%;';
            var styleChild = 'position: absolute; left: 0; top: 0; transition: 0s;';

            element.resizeSensor.style.cssText = style;
            element.resizeSensor.innerHTML =
                '<div class="resize-sensor-expand" style="' + style + '">' +
                    '<div style="' + styleChild + '"></div>' +
                '</div>' +
                '<div class="resize-sensor-shrink" style="' + style + '">' +
                    '<div style="' + styleChild + ' width: 200%; height: 200%"></div>' +
                '</div>';
            element.appendChild(element.resizeSensor);

            var computedStyle = window.getComputedStyle(element);
            var position = computedStyle ? computedStyle.getPropertyValue('position') : null;
            if ('absolute' !== position && 'relative' !== position && 'fixed' !== position) {
                element.style.position = 'relative';
            }

            var expand = element.resizeSensor.childNodes[0];
            var expandChild = expand.childNodes[0];
            var shrink = element.resizeSensor.childNodes[1];
            var dirty, rafId;
            var size = getElementSize(element);
            var lastWidth = size.width;
            var lastHeight = size.height;
            var initialHiddenCheck = true;
            var lastAnimationFrame = 0;

            var resetExpandShrink = function () {
                var width = element.offsetWidth;
                var height = element.offsetHeight;

                expandChild.style.width = (width + 10) + 'px';
                expandChild.style.height = (height + 10) + 'px';

                expand.scrollLeft = width + 10;
                expand.scrollTop = height + 10;

                shrink.scrollLeft = width + 10;
                shrink.scrollTop = height + 10;
            };

            var reset = function() {
                // Check if element is hidden
                if (initialHiddenCheck) {
                    var invisible = element.offsetWidth === 0 && element.offsetHeight === 0;
                    if (invisible) {
                        // Check in next frame
                        if (!lastAnimationFrame){
                            lastAnimationFrame = requestAnimationFrame(function(){
                                lastAnimationFrame = 0;

                                reset();
                            });
                        }

                        return;
                    } else {
                        // Stop checking
                        initialHiddenCheck = false;
                    }
                }

                resetExpandShrink();
            };
            element.resizeSensor.resetSensor = reset;

            var onResized = function() {
                rafId = 0;

                if (!dirty) return;

                lastWidth = size.width;
                lastHeight = size.height;

                if (element.resizedAttached) {
                    element.resizedAttached.call(size);
                }
            };

            var onScroll = function() {
                size = getElementSize(element);
                dirty = size.width !== lastWidth || size.height !== lastHeight;

                if (dirty && !rafId) {
                    rafId = requestAnimationFrame(onResized);
                }

                reset();
            };

            var addEvent = function(el, name, cb) {
                if (el.attachEvent) {
                    el.attachEvent('on' + name, cb);
                } else {
                    el.addEventListener(name, cb);
                }
            };

            addEvent(expand, 'scroll', onScroll);
            addEvent(shrink, 'scroll', onScroll);

            // Fix for custom Elements
            requestAnimationFrame(reset);
        }

        forEachElement(element, function(elem){
            attachResizeEvent(elem, callback);
        });

        this.detach = function(ev) {
            ResizeSensor.detach(element, ev);
        };

        this.reset = function() {
            element.resizeSensor.resetSensor();
        };
    };

    ResizeSensor.reset = function(element) {
        forEachElement(element, function(elem){
            elem.resizeSensor.resetSensor();
        });
    };

    ResizeSensor.detach = function(element, ev) {
        forEachElement(element, function(elem){
            if (!elem) return;
            if(elem.resizedAttached && typeof ev === "function"){
                elem.resizedAttached.remove(ev);
                if(elem.resizedAttached.length()) return;
            }
            if (elem.resizeSensor) {
                if (elem.contains(elem.resizeSensor)) {
                    elem.removeChild(elem.resizeSensor);
                }
                delete elem.resizeSensor;
                delete elem.resizedAttached;
            }
        });
    };

    if (typeof MutationObserver !== "undefined") {
        var observer = new MutationObserver(function (mutations) {
            for (var i in mutations) {
                if (mutations.hasOwnProperty(i)) {
                    var items = mutations[i].addedNodes;
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].resizeSensor) {
                            ResizeSensor.reset(items[j]);
                        }
                    }
                }
            }
        });

        document.addEventListener("DOMContentLoaded", function (event) {
            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        });
    }

    return ResizeSensor;

}));
/**
 * sticky-sidebar - A JavaScript plugin for making smart and high performance.
 * @version v3.3.1
 * @link https://github.com/abouolia/sticky-sidebar
 * @author Ahmed Bouhuolia
 * @license The MIT License (MIT)
**/
!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(exports):"function"==typeof define&&define.amd?define(["exports"],e):e(t.StickySidebar={})}(this,function(t){"use strict";"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self&&self;var e,i,n=(function(t,e){(function(t){Object.defineProperty(t,"__esModule",{value:!0});var l,n,e=function(){function n(t,e){for(var i=0;i<e.length;i++){var n=e[i];n.enumerable=n.enumerable||!1,n.configurable=!0,"value"in n&&(n.writable=!0),Object.defineProperty(t,n.key,n)}}return function(t,e,i){return e&&n(t.prototype,e),i&&n(t,i),t}}(),i=(l=".stickySidebar",n={topSpacing:0,bottomSpacing:0,containerSelector:!1,innerWrapperSelector:".inner-wrapper-sticky",stickyClass:"is-affixed",resizeSensor:!0,minWidth:!1},function(){function c(t){var e=this,i=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{};if(function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,c),this.options=c.extend(n,i),this.sidebar="string"==typeof t?document.querySelector(t):t,void 0===this.sidebar)throw new Error("There is no specific sidebar element.");this.sidebarInner=!1,this.container=this.sidebar.parentElement,this.affixedType="STATIC",this.direction="down",this.support={transform:!1,transform3d:!1},this._initialized=!1,this._reStyle=!1,this._breakpoint=!1,this.dimensions={translateY:0,maxTranslateY:0,topSpacing:0,lastTopSpacing:0,bottomSpacing:0,lastBottomSpacing:0,sidebarHeight:0,sidebarWidth:0,containerTop:0,containerHeight:0,viewportHeight:0,viewportTop:0,lastViewportTop:0},["handleEvent"].forEach(function(t){e[t]=e[t].bind(e)}),this.initialize()}return e(c,[{key:"initialize",value:function(){var i=this;if(this._setSupportFeatures(),this.options.innerWrapperSelector&&(this.sidebarInner=this.sidebar.querySelector(this.options.innerWrapperSelector),null===this.sidebarInner&&(this.sidebarInner=!1)),!this.sidebarInner){var t=document.createElement("div");for(t.setAttribute("class","inner-wrapper-sticky"),this.sidebar.appendChild(t);this.sidebar.firstChild!=t;)t.appendChild(this.sidebar.firstChild);this.sidebarInner=this.sidebar.querySelector(".inner-wrapper-sticky")}if(this.options.containerSelector){var e=document.querySelectorAll(this.options.containerSelector);if((e=Array.prototype.slice.call(e)).forEach(function(t,e){t.contains(i.sidebar)&&(i.container=t)}),!e.length)throw new Error("The container does not contains on the sidebar.")}"function"!=typeof this.options.topSpacing&&(this.options.topSpacing=parseInt(this.options.topSpacing)||0),"function"!=typeof this.options.bottomSpacing&&(this.options.bottomSpacing=parseInt(this.options.bottomSpacing)||0),this._widthBreakpoint(),this.calcDimensions(),this.stickyPosition(),this.bindEvents(),this._initialized=!0}},{key:"bindEvents",value:function(){window.addEventListener("resize",this,{passive:!0,capture:!1}),window.addEventListener("scroll",this,{passive:!0,capture:!1}),this.sidebar.addEventListener("update"+l,this),this.options.resizeSensor&&"undefined"!=typeof ResizeSensor&&(new ResizeSensor(this.sidebarInner,this.handleEvent),new ResizeSensor(this.container,this.handleEvent))}},{key:"handleEvent",value:function(t){this.updateSticky(t)}},{key:"calcDimensions",value:function(){if(!this._breakpoint){var t=this.dimensions;t.containerTop=c.offsetRelative(this.container).top,t.containerHeight=this.container.clientHeight,t.containerBottom=t.containerTop+t.containerHeight,t.sidebarHeight=this.sidebarInner.offsetHeight,t.sidebarWidth=this.sidebarInner.offsetWidth,t.viewportHeight=window.innerHeight,t.maxTranslateY=t.containerHeight-t.sidebarHeight,this._calcDimensionsWithScroll()}}},{key:"_calcDimensionsWithScroll",value:function(){var t=this.dimensions;t.sidebarLeft=c.offsetRelative(this.sidebar).left,t.viewportTop=document.documentElement.scrollTop||document.body.scrollTop,t.viewportBottom=t.viewportTop+t.viewportHeight,t.viewportLeft=document.documentElement.scrollLeft||document.body.scrollLeft,t.topSpacing=this.options.topSpacing,t.bottomSpacing=this.options.bottomSpacing,"function"==typeof t.topSpacing&&(t.topSpacing=parseInt(t.topSpacing(this.sidebar))||0),"function"==typeof t.bottomSpacing&&(t.bottomSpacing=parseInt(t.bottomSpacing(this.sidebar))||0),"VIEWPORT-TOP"===this.affixedType?t.topSpacing<t.lastTopSpacing&&(t.translateY+=t.lastTopSpacing-t.topSpacing,this._reStyle=!0):"VIEWPORT-BOTTOM"===this.affixedType&&t.bottomSpacing<t.lastBottomSpacing&&(t.translateY+=t.lastBottomSpacing-t.bottomSpacing,this._reStyle=!0),t.lastTopSpacing=t.topSpacing,t.lastBottomSpacing=t.bottomSpacing}},{key:"isSidebarFitsViewport",value:function(){var t=this.dimensions,e="down"===this.scrollDirection?t.lastBottomSpacing:t.lastTopSpacing;return this.dimensions.sidebarHeight+e<this.dimensions.viewportHeight}},{key:"observeScrollDir",value:function(){var t=this.dimensions;if(t.lastViewportTop!==t.viewportTop){var e="down"===this.direction?Math.min:Math.max;t.viewportTop===e(t.viewportTop,t.lastViewportTop)&&(this.direction="down"===this.direction?"up":"down")}}},{key:"getAffixType",value:function(){this._calcDimensionsWithScroll();var t=this.dimensions,e=t.viewportTop+t.topSpacing,i=this.affixedType;return e<=t.containerTop||t.containerHeight<=t.sidebarHeight?(t.translateY=0,i="STATIC"):i="up"===this.direction?this._getAffixTypeScrollingUp():this._getAffixTypeScrollingDown(),t.translateY=Math.max(0,t.translateY),t.translateY=Math.min(t.containerHeight,t.translateY),t.translateY=Math.round(t.translateY),t.lastViewportTop=t.viewportTop,i}},{key:"_getAffixTypeScrollingDown",value:function(){var t=this.dimensions,e=t.sidebarHeight+t.containerTop,i=t.viewportTop+t.topSpacing,n=t.viewportBottom-t.bottomSpacing,o=this.affixedType;return this.isSidebarFitsViewport()?t.sidebarHeight+i>=t.containerBottom?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):i>=t.containerTop&&(t.translateY=i-t.containerTop,o="VIEWPORT-TOP"):t.containerBottom<=n?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):e+t.translateY<=n?(t.translateY=n-e,o="VIEWPORT-BOTTOM"):t.containerTop+t.translateY<=i&&0!==t.translateY&&t.maxTranslateY!==t.translateY&&(o="VIEWPORT-UNBOTTOM"),o}},{key:"_getAffixTypeScrollingUp",value:function(){var t=this.dimensions,e=t.sidebarHeight+t.containerTop,i=t.viewportTop+t.topSpacing,n=t.viewportBottom-t.bottomSpacing,o=this.affixedType;return i<=t.translateY+t.containerTop?(t.translateY=i-t.containerTop,o="VIEWPORT-TOP"):t.containerBottom<=n?(t.translateY=t.containerBottom-e,o="CONTAINER-BOTTOM"):this.isSidebarFitsViewport()||t.containerTop<=i&&0!==t.translateY&&t.maxTranslateY!==t.translateY&&(o="VIEWPORT-UNBOTTOM"),o}},{key:"_getStyle",value:function(t){if(void 0!==t){var e={inner:{},outer:{}},i=this.dimensions;switch(t){case"VIEWPORT-TOP":e.inner={position:"fixed",top:i.topSpacing,left:i.sidebarLeft-i.viewportLeft,width:i.sidebarWidth};break;case"VIEWPORT-BOTTOM":e.inner={position:"fixed",top:"auto",left:i.sidebarLeft,bottom:i.bottomSpacing,width:i.sidebarWidth};break;case"CONTAINER-BOTTOM":case"VIEWPORT-UNBOTTOM":var n=this._getTranslate(0,i.translateY+"px");e.inner=n?{transform:n}:{position:"absolute",top:i.translateY,width:i.sidebarWidth}}switch(t){case"VIEWPORT-TOP":case"VIEWPORT-BOTTOM":case"VIEWPORT-UNBOTTOM":case"CONTAINER-BOTTOM":e.outer={height:i.sidebarHeight,position:"relative"}}return e.outer=c.extend({height:"",position:""},e.outer),e.inner=c.extend({position:"relative",top:"",left:"",bottom:"",width:"",transform:""},e.inner),e}}},{key:"stickyPosition",value:function(t){if(!this._breakpoint){t=this._reStyle||t||!1,this.options.topSpacing,this.options.bottomSpacing;var e=this.getAffixType(),i=this._getStyle(e);if((this.affixedType!=e||t)&&e){var n="affix."+e.toLowerCase().replace("viewport-","")+l;for(var o in c.eventTrigger(this.sidebar,n),"STATIC"===e?c.removeClass(this.sidebar,this.options.stickyClass):c.addClass(this.sidebar,this.options.stickyClass),i.outer){var s="number"==typeof i.outer[o]?"px":"";this.sidebar.style[o]=i.outer[o]+s}for(var r in i.inner){var a="number"==typeof i.inner[r]?"px":"";this.sidebarInner.style[r]=i.inner[r]+a}var p="affixed."+e.toLowerCase().replace("viewport-","")+l;c.eventTrigger(this.sidebar,p)}else this._initialized&&(this.sidebarInner.style.left=i.inner.left);this.affixedType=e}}},{key:"_widthBreakpoint",value:function(){window.innerWidth<=this.options.minWidth?(this._breakpoint=!0,this.affixedType="STATIC",this.sidebar.removeAttribute("style"),c.removeClass(this.sidebar,this.options.stickyClass),this.sidebarInner.removeAttribute("style")):this._breakpoint=!1}},{key:"updateSticky",value:function(){var t,e=this,i=0<arguments.length&&void 0!==arguments[0]?arguments[0]:{};this._running||(this._running=!0,t=i.type,requestAnimationFrame(function(){switch(t){case"scroll":e._calcDimensionsWithScroll(),e.observeScrollDir(),e.stickyPosition();break;case"resize":default:e._widthBreakpoint(),e.calcDimensions(),e.stickyPosition(!0)}e._running=!1}))}},{key:"_setSupportFeatures",value:function(){var t=this.support;t.transform=c.supportTransform(),t.transform3d=c.supportTransform(!0)}},{key:"_getTranslate",value:function(){var t=0<arguments.length&&void 0!==arguments[0]?arguments[0]:0,e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:0,i=2<arguments.length&&void 0!==arguments[2]?arguments[2]:0;return this.support.transform3d?"translate3d("+t+", "+e+", "+i+")":!!this.support.translate&&"translate("+t+", "+e+")"}},{key:"destroy",value:function(){window.removeEventListener("resize",this,{capture:!1}),window.removeEventListener("scroll",this,{capture:!1}),this.sidebar.classList.remove(this.options.stickyClass),this.sidebar.style.minHeight="",this.sidebar.removeEventListener("update"+l,this);var t={inner:{},outer:{}};for(var e in t.inner={position:"",top:"",left:"",bottom:"",width:"",transform:""},t.outer={height:"",position:""},t.outer)this.sidebar.style[e]=t.outer[e];for(var i in t.inner)this.sidebarInner.style[i]=t.inner[i];this.options.resizeSensor&&"undefined"!=typeof ResizeSensor&&(ResizeSensor.detach(this.sidebarInner,this.handleEvent),ResizeSensor.detach(this.container,this.handleEvent))}}],[{key:"supportTransform",value:function(t){var i=!1,e=t?"perspective":"transform",n=e.charAt(0).toUpperCase()+e.slice(1),o=document.createElement("support").style;return(e+" "+["Webkit","Moz","O","ms"].join(n+" ")+n).split(" ").forEach(function(t,e){if(void 0!==o[t])return i=t,!1}),i}},{key:"eventTrigger",value:function(t,e,i){try{var n=new CustomEvent(e,{detail:i})}catch(t){(n=document.createEvent("CustomEvent")).initCustomEvent(e,!0,!0,i)}t.dispatchEvent(n)}},{key:"extend",value:function(t,e){var i={};for(var n in t)void 0!==e[n]?i[n]=e[n]:i[n]=t[n];return i}},{key:"offsetRelative",value:function(t){var e={left:0,top:0};do{var i=t.offsetTop,n=t.offsetLeft;isNaN(i)||(e.top+=i),isNaN(n)||(e.left+=n),t="BODY"===t.tagName?t.parentElement:t.offsetParent}while(t);return e}},{key:"addClass",value:function(t,e){c.hasClass(t,e)||(t.classList?t.classList.add(e):t.className+=" "+e)}},{key:"removeClass",value:function(t,e){c.hasClass(t,e)&&(t.classList?t.classList.remove(e):t.className=t.className.replace(new RegExp("(^|\\b)"+e.split(" ").join("|")+"(\\b|$)","gi")," "))}},{key:"hasClass",value:function(t,e){return t.classList?t.classList.contains(e):new RegExp("(^| )"+e+"( |$)","gi").test(t.className)}},{key:"defaults",get:function(){return n}}]),c}());t.default=i,window.StickySidebar=i})(e)}(e={exports:{}},e.exports),e.exports),o=(i=n)&&i.__esModule&&Object.prototype.hasOwnProperty.call(i,"default")?i.default:i;t.default=o,t.__moduleExports=n,Object.defineProperty(t,"__esModule",{value:!0})});
var the7Utils = {};

the7Utils.parseIntParam = function(param, def){
    def = typeof def !== 'undefined' ?  def : 0;
    return  param ? parseInt(param) : def;
};

the7Utils.parseParam = function(param, def){
    def = typeof def !== 'undefined' ?  def : "";
    return  param ? parseInt(param) : def;
};
(function($) {
    /* #Check if element exists
    ================================================== */
    $.fn.exists = function () {
        return $(this).length > 0;
    };

    /* !- Check if element is loaded */
    $.fn.loaded = function (callback, jointCallback, ensureCallback) {
        var len = this.length;
        if (len > 0) {
            return this.each(function () {
				var	el		= this,
					$el		= $(el);

				$el.on("load.dt", function(event) {
                    $(this).off("load.dt");
                    if (typeof callback == "function") {
                        callback.call(this);
                    }
                    if (--len <= 0 && (typeof jointCallback == "function")) {
                        jointCallback.call(this);
                    }
                });

                if (!(!el.complete || el.complete === undefined)) {
                    $el.trigger("load.dt")
                }
            });
        } else if (ensureCallback) {
            if (typeof jointCallback == "function") {
                jointCallback.call(this);
            }
            return this;
        }
    };
    dtGlobals.isInViewport = function ($item){
    //Window Object
    var win = $(window);
    //Object to Check
    var obj = $item;
    //the top Scroll Position in the page
    var scrollPosition = win.scrollTop();
    //the end of the visible area in the page, starting from the scroll position
    var visibleArea = win.scrollTop() + win.height();
    //the end of the object to check
    var objEndPos = (obj.offset().top + 20);
    return(visibleArea >= objEndPos && scrollPosition <= objEndPos ? true : false);
    };

    //Layzy img loading
    $.fn.layzrInitialisation = function(container) {
        return this.each(function() {
            var $this = $(this);

            var layzr = new Layzr({
                container: container,
                selector: '.lazy-load',
                attr: 'data-src',
                attrSrcSet: 'data-srcset',
                retinaAttr: 'data-src-retina',
                hiddenAttr: 'data-src-hidden',
                threshold: 0,
                before: function() {

                    this.style.willChange = 'opacity';

                    if($(this).parents(".blog-shortcode.mode-list").length > 0 || $(this).parents(".blog-media").length > 0){
                        this.setAttribute("sizes", this.width+"px");
                    }else if($(this).parents(".woocom-project").length > 0){
                        this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
                    }
                },
                callback: function() {

                    this.classList.add("is-loaded");

                    var $this =  $(this);
                    $this.parents('.fancy-media-wrap.photoswipe-wrapper').initPhotoswipe();
                    setTimeout(function(){
                        $this.parents().removeClass("layzr-bg");
                        $this.css("will-change",'auto');
                    }, 350)
                },
                after: function() {
                    var $this =  $(this);
                    if(this.complete && !$this.hasClass("is-loaded") ){
                        this.classList.add("is-loaded");
                        setTimeout(function(){
                            var $this =  $(this);

                            $this.parents().removeClass("layzr-bg");
                            $this.css("will-change",'auto');
                        }, 350)
                    }
                }
            });
        });
    };
})(jQuery);

jQuery(document).ready(function($) {
 	//Cache variables
	var $document = $(document),
		$window = $(window),
		$html = $("html"),
		$body = $("body"),
		$page = $("#page");

	/*!- Custom resize function*/
    var dtResizeTimeout;
    if(dtGlobals.isMobile && !dtGlobals.isWindowsPhone && !dtGlobals.isAndroid){
        $window.bind("orientationchange", function() {
            resizeHandler();
        });
    }else{
        $window.on("resize", function() {
            resizeHandler();
        });
    }

    function resizeHandler(){
        clearTimeout(dtResizeTimeout);
        dtResizeTimeout = setTimeout(function() {
            $(window).trigger( "debouncedresize" );
            //resize widgets in above the fold js
            $window[0].dispatchEvent(new CustomEvent('the7_widget_resize'));
        }, 200);
    }

    $window.trigger( "debouncedresize" );

	/* #Retina images using srcset polyfill
	================================================== */
	var layzrCarousel;
    $.fn.layzrCarouselUpdate = function() {
        var $this = $(this);
        var className = "owl-thumb-lazy-load-show";
        var classSelector = "."+className;
        var isRefresh = false;
        //optimized code for performance
        //search last element after active elements
        var elem = $this.last().next().find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        //if not found search prev element before active elements
        elem = $this.first().prev().find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        //if elements before or after active does not have class, add elements to all active elements and update layzr
        elem = $this.find("img").not(classSelector);
        if (elem.length){
            elem.addClass(className);
            isRefresh = true;
        }
        if (isRefresh)
        {
            layzrCarousel.updateSelector();
            layzrCarousel.update();
        }
    };
	function layzrCarouselInitialisation() {
        layzrCarousel = new Layzr({
            selector: ".owl-thumb-lazy-load-show",
            attr: 'data-src',
            attrSrcSet: 'data-srcset',
            retinaAttr: 'data-src-retina',
            hiddenAttr: 'data-src-hidden',
            threshold: 30,
            before: function() {
                this.setAttribute("sizes", $(this).attr('width')+"px");
                this.style.willChange = 'opacity';
            },
            callback: function() {
                //if($(this).parents(".post").first().hasClass("visible")){
                this.classList.add("is-loaded");

                var $this =  $(this);
                setTimeout(function(){
                    $this.parent().removeClass("layzr-bg");
                    $this.css("will-change",'auto');
                }, 350);
                //}
            }
        });
    };

	$(".layzr-loading-on, .vc_single_image-img").layzrInitialisation();
	

	$.fn.layzrBlogInitialisation = function(container) {
	  return this.each(function() {
	      var $this = $(this);
	      // $(".blog-shortcode.jquery-filter article").removeClass("shown");
	      // $this.addClass("shown");
	      $this.find("img").addClass("blog-thumb-lazy-load-show");

	      var layzrBlog = new Layzr({
	        container: container,
	        selector: ".blog-thumb-lazy-load-show",
	        attr: 'data-src',
	        attrSrcSet: 'data-srcset',
	        retinaAttr: 'data-src-retina',
	        hiddenAttr: 'data-src-hidden',
	        threshold: 30,
	        before: function() {
	        	this.setAttribute("sizes", this.width+"px");
	        	this.style.willChange = 'opacity';
	        	if($(this).parents(".woocom-project").length > 0){
					this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
	        	}
	        },
	        callback: function() {
	        	if($(this).parents(".post").first().hasClass("visible")){
	          		this.classList.add("is-loaded");
		         	var $this =  $(this);
		         	setTimeout(function(){
						$this.parent().removeClass("layzr-bg");
						$this.css("will-change",'auto');
					}, 350);
				}
	        }
	      });
	    });
	};
	$(".layzr-loading-on .blog-shortcode.jquery-filter.mode-list .visible").layzrBlogInitialisation();

	//Rewrite vc functions for row behavior (fix issue with vc full-with row and box layout/side header)
	window.vc_rowBehaviour = function() {
	    function fullWidthRow() {
	        var $elements = $('[data-vc-full-width="true"]');
	        $.each($elements, function(key, item) {
	            var $el = $(this);
	            $el.addClass("vc_hidden");
	            if($el.parents().hasClass('vc_ie-flexbox-fixer')){
	            	var $el_full = $el.parents('.vc_ie-flexbox-fixer').next(".vc_row-full-width");
	            }else{
	            	var $el_full = $el.next(".vc_row-full-width");
	            }
	            if ($el_full.length > 0 && typeof $el_full != 'undefined') {

		            var el_margin_left = parseInt($el.css("margin-left"), 10);
		            var el_margin_right = parseInt($el.css("margin-right"), 10);
		            var offset = 0 - $el_full.offset().left - el_margin_left;
			        var width = $(window).width();

		            if ($el.parent().hasClass("vc_section")) {
			            el_margin_left = parseInt($el.parent().css("margin-left"), 10);
			            el_margin_right = parseInt($el.parent().css("margin-right"), 10);
		            }

					var windowInnerW = window.innerWidth;
					var windowW = $window.width();
					var contentW = $('#content').width();
					var $offset_fs;
					var $width_fs;
		            var $mainWfWrap = $("#main > .wf-wrap");
		            var mainWfWrapCSSWidth = parseInt($mainWfWrap.css("width"));
		            var leftPadding = parseInt($mainWfWrap.css("padding-left"));
		            var responsivenessIsOff = $body.hasClass("responsive-off");
		            var showDesktopHeader = windowInnerW > dtLocal.themeSettings.mobileHeader.firstSwitchPoint;
		            var isStikyHeader = $body.hasClass("sticky-header");
		            var isHeaderSideLeft = $body.hasClass("header-side-left");
		            var isHeaderSideRight = $body.hasClass("header-side-right");

					if ($('.boxed').length > 0) {
						var $windowWidth = $('#main').width();
					}
					else if ($('.side-header-v-stroke').length && ( $('.side-header-v-stroke').css('display') !== 'none' && showDesktopHeader && !responsivenessIsOff || responsivenessIsOff ) ){
						var $windowWidth = windowInnerW <= contentW ? contentW : (windowW - $('.side-header-v-stroke').width());
					}
					else if (!isStikyHeader && (isHeaderSideLeft || isHeaderSideRight) && showDesktopHeader && $('.side-header').css('display') !== 'none'){
						var $windowWidth = windowInnerW <= contentW ? contentW : (windowW - $('.side-header').width());
					}
					else {
						var $windowWidth = windowW <= contentW ? contentW : windowW;
					};

		            var contentPadding = $windowWidth - mainWfWrapCSSWidth;
		            $offset_fs = Math.ceil((contentPadding + 2*leftPadding) / 2 );

					if($('.sidebar-left').length > 0 || $('.sidebar-right').length > 0){
						$width_fs = $("#content").width();
						$offset_fs = 0;
					}else{
						$width_fs = $("#main").innerWidth();
					}

					var offset = 0 - $offset_fs - el_margin_left;
					var $left = ( "rtl" == jQuery(document).attr( "dir" ) ) ? "right" : "left";
					$el.css($left, offset);

		            if ($el.css({
		                position: "relative",
		                //left: offset,
		                "box-sizing": "border-box",
		                width: $width_fs
		            }),
		            !$el.data("vcStretchContent")) {
		                var padding = -1 * offset;
		                0 > padding && (padding = 0);
		                var paddingRight = $width_fs - padding - $el_full.width() + el_margin_left + el_margin_right;
		                0 > paddingRight && (paddingRight = 0),
		                $el.css({
		                    "padding-left": padding + "px",
		                    "padding-right": paddingRight + "px"
		                })
		            }
		            if ($el.data("vcStretchContent") && $el.find('.upb_row_bg').length > 0){
						var selector = $el.find('.upb_row_bg'),
							ride = selector.data('bg-override'),
							w = $width_fs;
							if(ride=='full'){
								selector.css({'min-width':w+'px'});
								selector.css($left,0);
							}
					}
		            $el.attr("data-vc-full-width-init", "true"),
		            $el.removeClass("vc_hidden");

		            //Fix dt-scroller inside fullwidth vc row
		            $el.find(".ts-wrap").each(function(){
						var scroller = $(this).data("thePhotoSlider");
						if(typeof scroller!= "undefined"){
							scroller.update();
						};
					});
			
	        	}
	        })
	    }
	   
	    function parallaxRow() {
	        var vcSkrollrOptions, callSkrollInit = !1;
	        return window.vcParallaxSkroll && window.vcParallaxSkroll.destroy(),
	        $(".vc_parallax-inner").remove(),
	        $("[data-5p-top-bottom]").removeAttr("data-5p-top-bottom data-30p-top-bottom"),
	        $("[data-vc-parallax]").each(function() {
	            var skrollrSpeed, skrollrSize, skrollrStart, skrollrEnd, $parallaxElement, parallaxImage, youtubeId;
	            callSkrollInit = !0,
	            "on" === $(this).data("vcParallaxOFade") && $(this).children().attr("data-5p-top-bottom", "opacity:0;").attr("data-30p-top-bottom", "opacity:1;"),
	            skrollrSize = 100 * $(this).data("vcParallax"),
	            $parallaxElement = $("<div />").addClass("vc_parallax-inner").appendTo($(this)),
	            $parallaxElement.height(skrollrSize + "%"),
	            parallaxImage = $(this).data("vcParallaxImage"),
	            youtubeId = vcExtractYoutubeId(parallaxImage),
	            youtubeId ? insertYoutubeVideoAsBackground($parallaxElement, youtubeId) : "undefined" != typeof parallaxImage && $parallaxElement.css("background-image", "url(" + parallaxImage + ")"),
	            skrollrSpeed = skrollrSize - 100,
	            skrollrStart = -skrollrSpeed,
	            skrollrEnd = 0,
	            $parallaxElement.attr("data-bottom-top", "top: " + skrollrStart + "%;").attr("data-top-bottom", "top: " + skrollrEnd + "%;")
	        }),
	        callSkrollInit && window.skrollr ? (vcSkrollrOptions = {
	            forceHeight: !1,
	            smoothScrolling: !1,
	            mobileCheck: function() {
	                return !1
	            }
	        },
	        window.vcParallaxSkroll = skrollr.init(vcSkrollrOptions),
	        window.vcParallaxSkroll) : !1
	    }
	    function fullHeightRow() {
	        $(".vc_row-o-full-height:first").each(function() {
	            var $window, windowHeight, offsetTop, fullHeight;
	            $window = $(window),
	            windowHeight = $window.height(),
	            offsetTop = $(this).offset().top,
	            windowHeight > offsetTop && (fullHeight = 100 - offsetTop / (windowHeight / 100),
	            $(this).css("min-height", fullHeight + "vh"))
	        })
	    }
	    function fixIeFlexbox() {
	        var ua = window.navigator.userAgent
	          , msie = ua.indexOf("MSIE ");
	        (msie > 0 || navigator.userAgent.match(/Trident.*rv\:11\./)) && $(".vc_row-o-full-height").each(function() {
	            "flex" === $(this).css("display") && $(this).wrap('<div class="vc_ie-flexbox-fixer"></div>')
	        })
	    }
	    var $ = window.jQuery;
	    $(window).off("resize.vcRowBehaviour").on("resize.vcRowBehaviour", fullWidthRow).on("resize.vcRowBehaviour", fullHeightRow),
	    fullWidthRow(),
	    fullHeightRow(),
	    fixIeFlexbox(),
	    vc_initVideoBackgrounds(),
	    parallaxRow()
	};

	/*Call visual composer function for preventing full-width row conflict */
	if($('div[data-vc-stretch-content="true"]').length > 0 && $('div[data-vc-full-width-init="false"]' ).length > 0 || $('div[data-vc-full-width="true"]').length > 0 && $('div[data-vc-full-width-init="false"]' ).length > 0){
		vc_rowBehaviour();

	}

	//Blog
    $.fn.clickOverlayGradient = function () {
	    return this.each(function () {
		    var $this = $(this);
		    var $thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").innerHeight();

		    $this.data("the7OverlayLayoutContentOffset", $thisOfTop);
		    $this.css({
			    "transform": "translateY(" + $thisOfTop + "px)"
		    });

		    if (!$this.data("overlayLayoutEventsWasAdded")) {
			    $this.data("overlayLayoutEventsWasAdded", true);
			    $this.parents(".post").first()
				    .on("mouseenter tap", function () {
					    $this.css(
						    "transform", "translateY(0px)"
					    );
				    })
				    .on("mouseleave tap", function () {
					    $this.css(
						    "transform", "translateY(" + $this.data("the7OverlayLayoutContentOffset") + "px)"
					    );
				    });
		    }
	    })
    };
	addOnloadEvent(function(){
		$(".content-rollover-layout-list:not(.disable-layout-hover) .dt-css-grid .post-entry-wrapper").clickOverlayGradient();
	});

	


/* #Custom touch events
================================================== */

	/* !(we need to add swipe events here) */

	dtGlobals.touches = {};
	dtGlobals.touches.touching = false;
	dtGlobals.touches.touch = false;
	dtGlobals.touches.currX = 0;
	dtGlobals.touches.currY = 0;
	dtGlobals.touches.cachedX = 0;
	dtGlobals.touches.cachedY = 0;
	dtGlobals.touches.count = 0;
	dtGlobals.resizeCounter = 0;

	$document.on("touchstart",function(e) {
		if (e.originalEvent.touches.length == 1) {
			dtGlobals.touches.touch = e.originalEvent.touches[0];

			// caching the current x
			dtGlobals.touches.cachedX = dtGlobals.touches.touch.pageX;
			// caching the current y
			dtGlobals.touches.cachedY = dtGlobals.touches.touch.pageY;
			// a touch event is detected      
			dtGlobals.touches.touching = true;

			// detecting if after 200ms the finger is still in the same position
			setTimeout(function() {

				dtGlobals.touches.currX = dtGlobals.touches.touch.pageX;
				dtGlobals.touches.currY = dtGlobals.touches.touch.pageY;

				if ((dtGlobals.touches.cachedX === dtGlobals.touches.currX) && !dtGlobals.touches.touching && (dtGlobals.touches.cachedY === dtGlobals.touches.currY)) {
					// Here you get the Tap event
					dtGlobals.touches.count++;
					$(e.target).trigger("tap");
				}
			},200);
		}
	});

	$document.on("touchend touchcancel",function (e){
		// here we can consider finished the touch event
		dtGlobals.touches.touching = false;
	});

	$document.on("touchmove",function (e){
		dtGlobals.touches.touch = e.originalEvent.touches[0];

		if(dtGlobals.touches.touching) {
			// here you are swiping
		}
	});

	$document.on("tap", function(e) {
		$(".dt-hovered").trigger("mouseout");
	});

// jquery.event.move
//
// 1.3.6
//
// Stephen Band
//
// Triggers 'movestart', 'move' and 'moveend' events after
// mousemoves following a mousedown cross a distance threshold,
// similar to the native 'dragstart', 'drag' and 'dragend' events.
// Move events are throttled to animation frames. Move event objects
// have the properties:
//
// pageX:
// pageY:   Page coordinates of pointer.
// startX:
// startY:  Page coordinates of pointer at movestart.
// distX:
// distY:  Distance the pointer has moved since movestart.
// deltaX:
// deltaY:  Distance the finger has moved since last event.
// velocityX:
// velocityY:  Average velocity over last few events.


	(function (module) {
		if (typeof define === 'function' && define.amd) {
			// AMD. Register as an anonymous module.
			define(['jquery'], module);
		} else {
			// Browser globals
			module(jQuery);
		}
	})(function(jQuery, undefined){

		var // Number of pixels a pressed pointer travels before movestart
				// event is fired.
				threshold = 6,

				add = jQuery.event.add,

				remove = jQuery.event.remove,

				// Just sugar, so we can have arguments in the same order as
				// add and remove.
				trigger = function(node, type, data) {
					jQuery.event.trigger(type, data, node);
				},

				// Shim for requestAnimationFrame, falling back to timer. See:
				// see http://paulirish.com/2011/requestanimationframe-for-smart-animating/
				requestFrame = (function(){
					return (
						window.requestAnimationFrame ||
						window.webkitRequestAnimationFrame ||
						window.mozRequestAnimationFrame ||
						window.oRequestAnimationFrame ||
						window.msRequestAnimationFrame ||
						function(fn, element){
							return window.setTimeout(function(){
								fn();
							}, 25);
						}
					);
				})(),

				ignoreTags = {
					textarea: true,
					input: true,
					select: true,
					button: true
				},

				mouseevents = {
					move: 'mousemove',
					cancel: 'mouseup dragstart',
					end: 'mouseup'
				},

				touchevents = {
					move: 'touchmove',
					cancel: 'touchend',
					end: 'touchend'
				};


		// Constructors

		function Timer(fn){
			var callback = fn,
					active = false,
					running = false;

			function trigger(time) {
				if (active){
					callback();
					requestFrame(trigger);
					running = true;
					active = false;
				}
				else {
					running = false;
				}
			}

			this.kick = function(fn) {
				active = true;
				if (!running) { trigger(); }
			};

			this.end = function(fn) {
				var cb = callback;

				if (!fn) { return; }

				// If the timer is not running, simply call the end callback.
				if (!running) {
					fn();
				}
				// If the timer is running, and has been kicked lately, then
				// queue up the current callback and the end callback, otherwise
				// just the end callback.
				else {
					callback = active ?
						function(){ cb(); fn(); } :
						fn ;

					active = true;
				}
			};
		}


		// Functions

		function returnTrue() {
			return true;
		}

		function returnFalse() {
			return false;
		}

		function preventDefault(e) {
			e.preventDefault();
		}

		function preventIgnoreTags(e) {
			// Don't prevent interaction with form elements.
			if (ignoreTags[ e.target.tagName.toLowerCase() ]) { return; }

			e.preventDefault();
		}

		function isLeftButton(e) {
			// Ignore mousedowns on any button other than the left (or primary)
			// mouse button, or when a modifier key is pressed.
			return (e.which === 1 && !e.ctrlKey && !e.altKey);
		}

		function identifiedTouch(touchList, id) {
			var i, l;

			if (touchList.identifiedTouch) {
				return touchList.identifiedTouch(id);
			}

			// touchList.identifiedTouch() does not exist in
			// webkit yet… we must do the search ourselves...

			i = -1;
			l = touchList.length;

			while (++i < l) {
				if (touchList[i].identifier === id) {
					return touchList[i];
				}
			}
		}

		function changedTouch(e, event) {
			var touch = identifiedTouch(e.changedTouches, event.identifier);

			// This isn't the touch you're looking for.
			if (!touch) { return; }

			// Chrome Android (at least) includes touches that have not
			// changed in e.changedTouches. That's a bit annoying. Check
			// that this touch has changed.
			if (touch.pageX === event.pageX && touch.pageY === event.pageY) { return; }

			return touch;
		}


		// Handlers that decide when the first movestart is triggered

		function mousedown(e){
			var data;

			if (!isLeftButton(e)) { return; }

			data = {
				target: e.target,
				startX: e.pageX,
				startY: e.pageY,
				timeStamp: e.timeStamp
			};

			add(document, mouseevents.move, mousemove, data);
			add(document, mouseevents.cancel, mouseend, data);
		}

		function mousemove(e){
			var data = e.data;

			checkThreshold(e, data, e, removeMouse);
		}

		function mouseend(e) {
			removeMouse();
		}

		function removeMouse() {
			remove(document, mouseevents.move, mousemove);
			remove(document, mouseevents.cancel, mouseend);
		}

		function touchstart(e) {
			var touch, template;

			// Don't get in the way of interaction with form elements.
			if (ignoreTags[ e.target.tagName.toLowerCase() ]) { return; }

			touch = e.changedTouches[0];

			// iOS live updates the touch objects whereas Android gives us copies.
			// That means we can't trust the touchstart object to stay the same,
			// so we must copy the data. This object acts as a template for
			// movestart, move and moveend event objects.
			template = {
				target: touch.target,
				startX: touch.pageX,
				startY: touch.pageY,
				timeStamp: e.timeStamp,
				identifier: touch.identifier
			};

			// Use the touch identifier as a namespace, so that we can later
			// remove handlers pertaining only to this touch.
			add(document, touchevents.move + '.' + touch.identifier, touchmove, template);
			add(document, touchevents.cancel + '.' + touch.identifier, touchend, template);
		}

		function touchmove(e){
			var data = e.data,
					touch = changedTouch(e, data);

			if (!touch) { return; }

			checkThreshold(e, data, touch, removeTouch);
		}

		function touchend(e) {
			var template = e.data,
					touch = identifiedTouch(e.changedTouches, template.identifier);

			if (!touch) { return; }

			removeTouch(template.identifier);
		}

		function removeTouch(identifier) {
			remove(document, '.' + identifier, touchmove);
			remove(document, '.' + identifier, touchend);
		}


		// Logic for deciding when to trigger a movestart.

		function checkThreshold(e, template, touch, fn) {
			var distX = touch.pageX - template.startX,
					distY = touch.pageY - template.startY;

			// Do nothing if the threshold has not been crossed.
			if ((distX * distX) + (distY * distY) < (threshold * threshold)) { return; }

			triggerStart(e, template, touch, distX, distY, fn);
		}

		function handled() {
			// this._handled should return false once, and after return true.
			this._handled = returnTrue;
			return false;
		}

		function flagAsHandled(e) {
			e._handled();
		}

		function triggerStart(e, template, touch, distX, distY, fn) {
			var node = template.target,
					touches, time;

			touches = e.targetTouches;
			time = e.timeStamp - template.timeStamp;

			// Create a movestart object with some special properties that
			// are passed only to the movestart handlers.
			template.type = 'movestart';
			template.distX = distX;
			template.distY = distY;
			template.deltaX = distX;
			template.deltaY = distY;
			template.pageX = touch.pageX;
			template.pageY = touch.pageY;
			template.velocityX = distX / time;
			template.velocityY = distY / time;
			template.targetTouches = touches;
			template.finger = touches ?
				touches.length :
				1 ;

			// The _handled method is fired to tell the default movestart
			// handler that one of the move events is bound.
			template._handled = handled;

			// Pass the touchmove event so it can be prevented if or when
			// movestart is handled.
			template._preventTouchmoveDefault = function() {
				e.preventDefault();
			};

			// Trigger the movestart event.
			trigger(template.target, template);

			// Unbind handlers that tracked the touch or mouse up till now.
			fn(template.identifier);
		}


		// Handlers that control what happens following a movestart

		function activeMousemove(e) {
			var timer = e.data.timer;

			e.data.touch = e;
			e.data.timeStamp = e.timeStamp;
			timer.kick();
		}

		function activeMouseend(e) {
			var event = e.data.event,
					timer = e.data.timer;

			removeActiveMouse();

			endEvent(event, timer, function() {
				// Unbind the click suppressor, waiting until after mouseup
				// has been handled.
				setTimeout(function(){
					remove(event.target, 'click', returnFalse);
				}, 0);
			});
		}

		function removeActiveMouse(event) {
			remove(document, mouseevents.move, activeMousemove);
			remove(document, mouseevents.end, activeMouseend);
		}

		function activeTouchmove(e) {
			var event = e.data.event,
					timer = e.data.timer,
					touch = changedTouch(e, event);

			if (!touch) { return; }

			// Stop the interface from gesturing
			e.preventDefault();

			event.targetTouches = e.targetTouches;
			e.data.touch = touch;
			e.data.timeStamp = e.timeStamp;
			timer.kick();
		}

		function activeTouchend(e) {
			var event = e.data.event,
					timer = e.data.timer,
					touch = identifiedTouch(e.changedTouches, event.identifier);

			// This isn't the touch you're looking for.
			if (!touch) { return; }

			removeActiveTouch(event);
			endEvent(event, timer);
		}

		function removeActiveTouch(event) {
			remove(document, '.' + event.identifier, activeTouchmove);
			remove(document, '.' + event.identifier, activeTouchend);
		}


		// Logic for triggering move and moveend events

		function updateEvent(event, touch, timeStamp, timer) {
			var time = timeStamp - event.timeStamp;

			event.type = 'move';
			event.distX =  touch.pageX - event.startX;
			event.distY =  touch.pageY - event.startY;
			event.deltaX = touch.pageX - event.pageX;
			event.deltaY = touch.pageY - event.pageY;

			// Average the velocity of the last few events using a decay
			// curve to even out spurious jumps in values.
			event.velocityX = 0.3 * event.velocityX + 0.7 * event.deltaX / time;
			event.velocityY = 0.3 * event.velocityY + 0.7 * event.deltaY / time;
			event.pageX =  touch.pageX;
			event.pageY =  touch.pageY;
		}

		function endEvent(event, timer, fn) {
			timer.end(function(){
				event.type = 'moveend';

				trigger(event.target, event);

				return fn && fn();
			});
		}


		// jQuery special event definition

		function setup(data, namespaces, eventHandle) {
			// Stop the node from being dragged
			//add(this, 'dragstart.move drag.move', preventDefault);

			// Prevent text selection and touch interface scrolling
			//add(this, 'mousedown.move', preventIgnoreTags);

			// Tell movestart default handler that we've handled this
			add(this, 'movestart.move', flagAsHandled);

			// Don't bind to the DOM. For speed.
			return true;
		}

		function teardown(namespaces) {
			remove(this, 'dragstart drag', preventDefault);
			remove(this, 'mousedown touchstart', preventIgnoreTags);
			remove(this, 'movestart', flagAsHandled);

			// Don't bind to the DOM. For speed.
			return true;
		}

		function addMethod(handleObj) {
			// We're not interested in preventing defaults for handlers that
			// come from internal move or moveend bindings
			if (handleObj.namespace === "move" || handleObj.namespace === "moveend") {
				return;
			}

			// Stop the node from being dragged
			add(this, 'dragstart.' + handleObj.guid + ' drag.' + handleObj.guid, preventDefault, undefined, handleObj.selector);

			// Prevent text selection and touch interface scrolling
			add(this, 'mousedown.' + handleObj.guid, preventIgnoreTags, undefined, handleObj.selector);
		}

		function removeMethod(handleObj) {
			if (handleObj.namespace === "move" || handleObj.namespace === "moveend") {
				return;
			}

			remove(this, 'dragstart.' + handleObj.guid + ' drag.' + handleObj.guid);
			remove(this, 'mousedown.' + handleObj.guid);
		}

		jQuery.event.special.movestart = {
			setup: setup,
			teardown: teardown,
			add: addMethod,
			remove: removeMethod,

			_default: function(e) {
				var event, data;

				// If no move events were bound to any ancestors of this
				// target, high tail it out of here.
				if (!e._handled()) { return; }

				function update(time) {
					updateEvent(event, data.touch, data.timeStamp);
					trigger(e.target, event);
				}

				event = {
					target: e.target,
					startX: e.startX,
					startY: e.startY,
					pageX: e.pageX,
					pageY: e.pageY,
					distX: e.distX,
					distY: e.distY,
					deltaX: e.deltaX,
					deltaY: e.deltaY,
					velocityX: e.velocityX,
					velocityY: e.velocityY,
					timeStamp: e.timeStamp,
					identifier: e.identifier,
					targetTouches: e.targetTouches,
					finger: e.finger
				};

				data = {
					event: event,
					timer: new Timer(update),
					touch: undefined,
					timeStamp: undefined
				};

				if (e.identifier === undefined) {
					// We're dealing with a mouse
					// Stop clicks from propagating during a move
					add(e.target, 'click', returnFalse);
					add(document, mouseevents.move, activeMousemove, data);
					add(document, mouseevents.end, activeMouseend, data);
				}
				else {
					// We're dealing with a touch. Stop touchmove doing
					// anything defaulty.
					e._preventTouchmoveDefault();
					add(document, touchevents.move + '.' + e.identifier, activeTouchmove, data);
					add(document, touchevents.end + '.' + e.identifier, activeTouchend, data);
				}
			}
		};

		jQuery.event.special.move = {
			setup: function() {
				// Bind a noop to movestart. Why? It's the movestart
				// setup that decides whether other move events are fired.
				add(this, 'movestart.move', jQuery.noop);
			},

			teardown: function() {
				remove(this, 'movestart.move', jQuery.noop);
			}
		};

		jQuery.event.special.moveend = {
			setup: function() {
				// Bind a noop to movestart. Why? It's the movestart
				// setup that decides whether other move events are fired.
				add(this, 'movestart.moveend', jQuery.noop);
			},

			teardown: function() {
				remove(this, 'movestart.moveend', jQuery.noop);
			}
		};

		add(document, 'mousedown.move', mousedown);
		add(document, 'touchstart.move', touchstart);

		// Make jQuery copy touch event properties over to the jQuery event
		// object, if they are not already listed. But only do the ones we
		// really need. IE7/8 do not have Array#indexOf(), but nor do they
		// have touch events, so let's assume we can ignore them.
		if (typeof Array.prototype.indexOf === 'function') {
			(function(jQuery, undefined){
				var props = ["changedTouches", "targetTouches"],
						l = props.length;

				while (l--) {
					if (jQuery.event.props.indexOf(props[l]) === -1) {
						jQuery.event.props.push(props[l]);
					}
				}
			})(jQuery);
		};
	});
/* !Animation Core */

/*
 * Viewport - jQuery selectors for finding elements in viewport
 *
 * Copyright (c) 2008-2009 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *  http://www.appelsiini.net/projects/viewport
 *
 */

	$.belowthefold = function(element, settings) {
		var fold = $window.height() + $window.scrollTop();
		return fold <= $(element).offset().top - settings.threshold;
	};
	$.abovethetop = function(element, settings) {
		var top = $window.scrollTop();
		return top >= $(element).offset().top + $(element).height() - settings.threshold;
	};
	$.rightofscreen = function(element, settings) {
		var fold = $window.width() + $window.scrollLeft();
		return fold <= $(element).offset().left - settings.threshold;
	};
	$.leftofscreen = function(element, settings) {
		var left = $window.scrollLeft();
		return left >= $(element).offset().left + $(element).width() - settings.threshold;
	};
	$.inviewport = function(element, settings) {
		return !$.rightofscreen(element, settings) && !$.leftofscreen(element, settings) && !$.belowthefold(element, settings) && !$.abovethetop(element, settings);
	};

	$.extend($.expr[':'], {
		"below-the-fold": function(a, i, m) {
			return $.belowthefold(a, {threshold : 0});
		},
		"above-the-top": function(a, i, m) {
			return $.abovethetop(a, {threshold : 0});
		},
		"left-of-screen": function(a, i, m) {
			return $.leftofscreen(a, {threshold : 0});
		},
		"right-of-screen": function(a, i, m) {
			return $.rightofscreen(a, {threshold : 0});
		},
		"in-viewport": function(a, i, m) {
			return $.inviewport(a, {threshold : -30});
		}
	});


	// !- Animation "onScroll" loop
	function doAnimation() {
		if(!dtGlobals.isMobile){
			if($(".animation-at-the-same-time").length > 0 || $(".animate-element").length > 0){
				var j = -1;
				$(".animation-at-the-same-time:in-viewport").each(function () {
					var $this = $(this),
						$thisElem = $this.find(".animate-element");
					//if (!$thisElem.hasClass("start-animation") && !$thisElem.hasClass("animation-triggered")) {
						$thisElem.addClass("animation-triggered");
						$this.find(".animate-element:not(.start-animation)").addClass("start-animation");
					//};
				});
				$(".animate-element:not(.start-animation):in-viewport").each(function () {
					var $this = $(this);
					if (!$this.parents(".animation-at-the-same-time").length > 0) {

						if (!$this.hasClass("start-animation") && !$this.hasClass("animation-triggered")) {
							$this.addClass("animation-triggered");
							j++;
							setTimeout(function () {
								$this.addClass("start-animation");
								if($this.hasClass("skills")){
									$this.animateSkills();
								};
							}, 200 * j);
						};
					};
				});
			}
		}
		else if ($(".skills").length > 0) {
			if (typeof animateSkills !== 'undefined' && $.isFunction(animateSkills)) {
				$(".skills").animateSkills();
			}
		};
	};

	// !- Animation "onScroll" loop
	$.fn.checkInViewport = function() {
		if(!dtGlobals.isMobile){
			//if($(".animation-at-the-same-time").length > 0 || $(".animate-element").length > 0){
				var j = -1;
					return this.each(function() {
						var $this = $(this);
						if ($this.hasClass("animation-ready")) {
							return;
						}
						if ($this.parents(".animation-at-the-same-time").length > 0) {
							$thisElem = $this.find(".animate-element");
						//if (!$thisElem.hasClass("start-animation") && !$thisElem.hasClass("animation-triggered")) {
							$thisElem.addClass("animation-triggered");
							$this.find(".animate-element:not(.start-animation)").addClass("start-animation");
						}else{

							if (!$this.hasClass("start-animation") && !$this.hasClass("animation-triggered")) {
								$this.addClass("animation-triggered");
								j++;
								setTimeout(function () {
									$this.addClass("start-animation");
									if($this.hasClass("skills")){
										$this.animateSkills();
									};
								}, 200 * j);
							};
						};
						$this.addClass("animation-ready");
					})
				}
			// }
			if (typeof animateSkills !== 'undefined' && $.isFunction(animateSkills)) {
				$(".skills").animateSkills();
			};
	};
	

	// !- Fire animation
	var animationTimeoutShow;
	clearTimeout(animationTimeoutShow);
	// !- Fire animation
	animationTimeoutShow = setTimeout(function() {
		//doAnimation();
		doAnimation();
	}, 50);

	if (!dtGlobals.isMobile ){
		$window.on("scroll", function () {
			doAnimation();
		});
	};
	$window.on("scroll", function () {
		$('.dt-owl-carousel-call, .related-projects').each(function() {
			var $this = $(this),
			  	$autoPlay = ( 'true' === $this.attr("data-autoplay")) ? true : false,
        		$autoPlayTimeout = $this.attr("data-autoplay_speed") ? parseInt($this.attr("data-autoplay_speed")) : 6000;
			if(!dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('stop.owl.autoplay');
            }else if(dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })
	});
/* #Init photoswipe
================================================== */
    $.fn.addPhotoswipeWrap = function() {
        return this.each(function(k, link) {
            var $this = $(this);
            $this.on('click', function(e){
                e.preventDefault();
            })
            $this.parents('figure').first().addClass("photoswipe-item");
            if ($this.hasClass("pspw-wrap-ready")) {
                return;
            }
            if(!$this.parents().hasClass('dt-gallery-container')){
                $this.parent().addClass("photoswipe-wrapper");
            }
            $this.addClass("pspw-wrap-ready");
        });
    };

    $(".dt-pswp-item, figure .dt-gallery-container a").addPhotoswipeWrap();

    var parseHash = function() {
        var hash = window.location.hash.substring(1),
            params = {};

        if(hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if(pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        if(!params.hasOwnProperty('pid')) {
            return params;
        }
        params.pid = parseInt(params.pid, 10);
        return params;
    };

    //Share btns array
    var shareButtonsPattern = [
        {id:'facebook', label: '<i class="icomoon-the7-font-facebook" aria-hidden="true"></i> ' + dtShare.shareButtonText.facebook, url:'https://www.facebook.com/sharer/sharer.php?u={{url}}&picture={{raw_image_url}}&description={{text}}'},

        {id:'twitter', label: '<i class="icomoon-the7-font-twitter" aria-hidden="true"></i> ' + dtShare.shareButtonText.twitter, url:'https://twitter.com/intent/tweet?text={{text}}&url={{url}}'},

        {id:'pinterest', label: '<i class="icomoon-the7-font-pinterest" aria-hidden="true"></i> ' + dtShare.shareButtonText.pinterest, url:'http://www.pinterest.com/pin/create/button/?url={{url}}&media={{image_url}}&description={{text}}'},

        {id:'linkedin', label: '<i class="icomoon-the7-font-linkedin" aria-hidden="true"></i> ' + dtShare.shareButtonText.linkedin, url:'http://www.linkedin.com/shareArticle?mini=true&url={{url}}&title={{text}}'},

        {id:'whatsapp', label: '<i class="icomoon-the7-font-whatsapp" aria-hidden="true"></i> ' + dtShare.shareButtonText.whatsapp, url:'whatsapp://send?text={{url}}'},
    ];

    if (dtShare.shareButtonText.download) {
        shareButtonsPattern.push({id:'download', label: '<i class="dt-icon-the7-misc-006-244" aria-hidden="true"></i> ' + dtShare.shareButtonText.download, url:'{{raw_image_url}}', download:true});
    }

    //Videos array
    var patterns = {
        youtube: {
            index: 'youtube.com',
            id: 'v=',
            src: '//www.youtube.com/embed/%id%',
            type: 'youtube'
        },
        vimeo: {
            index: 'vimeo.com/',
            id: '/',
            src: '//player.vimeo.com/video/%id%',
            type: 'vimeo'
        },
        gmaps: {
            index: '//maps.google.',
            src: '%id%&output=embed'
        }
    };

    function showShareButtons($shareButtonsList) {
        for (var prop in $shareButtonsList) {
            var showShare = $shareButtonsList[prop];
            var $shareTooltip = $('.pswp__share-tooltip');
            switch (showShare) {
                case 'facebook':
                    $shareTooltip.addClass('show-share-fb');
                    break;
                case 'twitter':
                    $shareTooltip.addClass('show-share-tw');
                    break;
                case 'pinterest':
                    $shareTooltip.addClass('show-share-pin');
                    break;
                case 'linkedin':
                    $shareTooltip.addClass('show-share-in');
                    break;
                case 'whatsapp':
                    $shareTooltip.addClass('show-share-wp');
                    break;
                case 'download':
                    $shareTooltip.addClass('show-share-d');
                    break;
                default:
                    $shareTooltip.removeClass('show-share-in show-share-pin show-share-tw show-share-fb show-share-g show-share-wp');
                    break;
            }
            // return $shareButtonsList[prop];
        }
    }

    //Photos pspw
    $.fn.photoswipeGallery = function(gallerySelector){
        var parseThumbnailElements = function(el) {
            var thumbElements = $(el).find('.photoswipe-item').get(),
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for (var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i];

                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element
                var $this_data_w = (typeof $(linkEl).attr( 'data-large_image_width' )  != 'undefined'  && $(linkEl).attr( 'data-large_image_width' ).length > 0 && $(linkEl).attr( 'data-large_image_width' )  != '' )  ? $(linkEl).attr( 'data-large_image_width' ) : $(linkEl).find('img').attr('width'),

                    $this_data_h = (typeof $(linkEl).attr( 'data-large_image_height' )  != 'undefined'  && $(linkEl).attr( 'data-large_image_height' ).length > 0 && $(linkEl).attr( 'data-large_image_height' )  != '' )  ? $(linkEl).attr( 'data-large_image_height' ) : $(linkEl).find('img').attr('height'),

                    $this_data_title = (typeof $(linkEl).attr( 'title' )  != 'undefined'  && $(linkEl).attr( 'title' ).length > 0)  ? '<h5>' + $(linkEl).attr( 'title' ) + '</h5>\n' : "",

                    $this_data_desc_var = (typeof $(linkEl).attr( 'data-dt-img-description' )  != 'undefined')  ? $(linkEl).attr( 'data-dt-img-description' ) : "",

                    $this_data_desc = $this_data_title + $this_data_desc_var  || "";

                // create slide object
                if ($(linkEl).hasClass('pswp-video')) {
                    var embedSrc = linkEl.href,
                        //iframeSt = $('.video-wrapper iframe'),
                        embedType;

                    $.each(patterns, function() {
                        if(embedSrc.indexOf( this.index ) > -1) {
                            if(this.id) {
                                if(typeof this.id === 'string') {
                                    embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
                                } else {
                                    embedSrc = this.id.call( this, embedSrc );
                                }
                                embedType = this.type;
                            }
                            embedSrc = this.src.replace('%id%', embedSrc );
                            return false; // break;
                        }
                    });
                    var item = {
                        html: '<div class="pswp-video-wrap " data-type="'+ embedType+'"><div class="video-wrapper"><iframe class="pswp__video"src=" '+ embedSrc +' " frameborder="0" allowfullscreen></iframe></div></div>',
                        title: $this_data_desc
                    };
                } else {
                    var item = {
                        src: linkEl.getAttribute('href'),
                        w: $this_data_w,
                        h: $this_data_h,
                        title: $this_data_desc
                    };
                }

                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        function hasClass(element, cls) {
            return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
        }

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            // e = e || window.event;
            // e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (hasClass(el, 'photoswipe-item'));
            });

            if (!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = $(clickedListItem).closest('.dt-gallery-container')[0],
                childNodes = $($(clickedListItem).closest('.dt-gallery-container')[0]).find('.photoswipe-item').get(),
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;
            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }

            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }

            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if (hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;
            // $shareButtonsList = $(galleryElement).attr('data-pretty-share') ? $(galleryElement).attr('data-pretty-share').split(',') : new Array();

            items = parseThumbnailElements(galleryElement);
            var $shareButtonsList = $(galleryElement).attr('data-pretty-share') ? $(galleryElement).attr('data-pretty-share').split(',') : new Array();
            if ( $shareButtonsList.length <= 0 || typeof $shareButtonsList  == 'undefined'  ) {
                $('.pswp__scroll-wrap').addClass("hide-pspw-share");
            } else {
                $shareButtonsList.push('download');
            }
            showShareButtons($shareButtonsList);

            options = {
                closeOnScroll: false,
                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                bgOpacity: dtShare.overlayOpacity/100,
                loop: true,
                history:false,
                showHideOpacity:true,
                showAnimationDuration: 0,
                shareButtons: shareButtonsPattern,


                getImageURLForShare: function( shareButtonData ) {
                    return gallery.currItem.src || $(gallery.currItem.el).find('a').attr('data-dt-location') || '';
                },
                getPageURLForShare: function( shareButtonData ) {
                    return $(gallery.currItem.el).find('a').attr('data-dt-location') || window.location.href;
                },
                getTextForShare: function( shareButtonData ) {

                    var htmlString= gallery.currItem.title;
                    var stripedHtml = (typeof htmlString !="undefined") ? htmlString.replace(/<[^>]+>/g, '') : '';
                    return stripedHtml || '';
                },

                // Parse output of share links
                parseShareButtonOut: function(shareButtonData, shareButtonOut) {
                    return shareButtonOut;
                }
            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();

            $(".pswp__zoom-wrap").removeClass("active-item");
            $('.pswp__video').removeClass('active');

            var currItem = $(gallery.currItem.container);
            currItem.addClass("active-item");
            //start video
            if(currItem.find('.pswp__video').length > 0){
                currItem.find('.pswp__video').addClass('active');
                currItem.parents(".pswp").addClass("video-active");
                var videoURL = currItem.find('.pswp__video').prop('src');
                videoURL += "?autoplay=1";
                currItem.find('.pswp__video').prop('src',videoURL);
            }

            gallery.listen('beforeChange', function() {
                var currItem = $(gallery.currItem.container);
                $(".pswp__zoom-wrap").removeClass("active-item");
                currItem.addClass("active-item");
                $('.pswp__video').removeClass('active');
                $(".pswp").removeClass("video-active");
                currItem.find('.pswp__video').addClass('active')
                var currItemIframe = currItem.find('.pswp__video');
                if(currItem.find('.pswp__video').length > 0){
                    currItem.parents(".pswp").addClass("video-active");
                    $runVideo = 0;
                }
                $('.pswp__video').each(function() {
                    var $this = $(this);
                    if (!$this.hasClass('active')) {
                        var videoURL = $this.prop('src');
                        if($this.parents('.pswp-video-wrap ').attr('data-type') == "youtube" || $this.parents('.pswp-video-wrap ').attr('data-type') == "vimeo"){
                            videoURL = videoURL.replace("?autoplay=1", "?enablejsapi=1");
                        }else{
                            videoURL = videoURL.replace("?autoplay=1", "");
                        }

                        $this.prop('src','');
                        $this.prop('src',videoURL);
                        //$('.pswp__video').removeClass('active');
                        var iframe =  $this[0].contentWindow;
                        if($this.hasClass('active')){
                            func = 'playVideo';
                        }else{
                            func = 'pauseVideo';
                        }
                        iframe.postMessage('{"event":"command","func":"' + func + '","args":""}','*');
                    }
                });
            });

            var pswpVideoTimer,
                pswpdestroyTimer;
            gallery.listen('close', function() {
                $('.pswp__video').each(function() {
                    var $this = $(this);
                    $this.attr('src', $(this).attr('src'));
                    var videoURL = $this.prop('src');
                    // videoURL = videoURL.replace("?autoplay=1", "?enablejsapi=1");
                    if($this.parents('.pswp-video-wrap ').attr('data-type') == "youtube" || $this.parents('.pswp-video-wrap ').attr('data-type') == "vimeo"){
                        videoURL = videoURL.replace("?autoplay=1", "?enablejsapi=1");
                    }else{
                        videoURL = videoURL.replace("?autoplay=1", "");
                    }

                    $this.prop('src','');
                    $this.prop('src',videoURL);
                    $('.pswp__video').removeClass('active');
                    var iframe =  $this[0].contentWindow;
                    if($(this).hasClass('active')){
                        func = 'playVideo';
                    }else{
                        func = 'pauseVideo';
                    }
                    iframe.postMessage('{"event":"command","func":"' + func + '","args":""}','*');
                    clearTimeout( pswpVideoTimer );
                    pswpVideoTimer = setTimeout(function(){
                        $('.pswp-video-wrap').remove();
                    },200);
                });
            });
            gallery.listen('destroy', function() {
                clearTimeout( pswpdestroyTimer );
                pswpdestroyTimer = setTimeout(function() {
                    $('.pswp').removeClass().addClass('pswp');
                }, 100);
            });

        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
            openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
        }


    };

    $('.dt-gallery-container.wf-container').photoswipeGallery('.dt-gallery-container.wf-container');

    $.fn.photoswipe = function(options) {
        options.embedType = 'hosted';
        return photoswipeCarouselCommon(options, this);
    };

    addOnloadEvent(function(){
        $('.photoswipe-wrapper, .photoswipe-item .dt-gallery-container, .shortcode-gallery.dt-gallery-container:not(.owl-carousel), .dt-gallery-container.gallery, .instagram-photos.dt-gallery-container, .images-container .dt-gallery-container, .shortcode-instagram.dt-gallery-container, .gallery-shortcode:not(.owl-carousel)').initPhotoswipe();
    });

    $.fn.photoswipeCarousel = function(options){
        options.target = '.dt-owl-item.cloned .dt-pswp-item';
        return photoswipeCarouselCommon(options, this);
    };

    function photoswipeCarouselCommon(options, $elements){
        var galleries = [],
            _options = options;

        _options = $.extend( {
            'target'         : '.dt-pswp-item',
            'embedType' : ''
        }, _options);

        var init = function($this, el){
            galleries = [];
            $this.each(function(i, gallery){
                galleries.push({
                    id: i,
                    items: []
                });
                var $clickLink  = $(gallery).find(_options.target);
                $clickLink.each(function(k, link) {
                    var $link = $(link),
                        imageWidth = $link.attr( 'data-large_image_width' ),
                        $this_data_w = (typeof imageWidth  != 'undefined'  && imageWidth.length > 0 && imageWidth != '' && imageWidth != 0 ) ? imageWidth : $link.find('img').attr('width'),
                        imageHeight = $link.attr( 'data-large_image_height' ),
                        $this_data_h = (typeof imageHeight  != 'undefined'  && imageHeight.length > 0 && imageHeight  != '' && imageHeight  != 0)  ? imageHeight : $link.find('img').attr('height'),

                        $this_data_title = (typeof $link.attr( 'title' )  != 'undefined' && $link.attr( 'title' ).length > 0)  ? '<h5>' + $link.attr( 'title' ) + '</h5>' : "",
                        $this_data_desc_var = (typeof $link.attr( 'data-dt-img-description' )  != 'undefined')  ? $link.attr( 'data-dt-img-description' ) : "",
                        $this_data_desc = $this_data_title + $this_data_desc_var  || "";
                    $link.data('gallery-id',i+1);
                    $link.data('photo-id', k);
                    if(typeof $this_data_w === 'undefined') {
                        $this_data_w  = $link.find('img').width();
                    }
                    if(typeof $this_data_h === 'undefined') {
                        $this_data_h  = $link.find('img').height();
                    }

                    if ($(link).hasClass('pswp-video')) {

                        // we don't care and support only one default type of URL by default

                        var embedSrc = link.href,
                            //iframeSt = $('.video-wrapper iframe'),
                            embedType = _options.embedType;

                        $.each(patterns, function() {
                            if(embedSrc.indexOf( this.index ) > -1) {
                                if(this.id) {
                                    if(typeof this.id === 'string') {
                                        embedSrc = embedSrc.substr(embedSrc.lastIndexOf(this.id)+this.id.length, embedSrc.length);
                                    } else {
                                        embedSrc = this.id.call( this, embedSrc );
                                    }
                                    embedType = this.type;
                                }
                                embedSrc = this.src.replace('%id%', embedSrc );
                                return false; // break;
                            }
                        });
                        var item = {
                            html: '<div class="pswp-video-wrap " data-type="'+ embedType+'"><div class="video-wrapper"><iframe class="pswp__video"src="'+ embedSrc +' " frameborder="0" allowfullscreen></iframe></div></div>',
                            title: $this_data_desc,
                            shareLink: $link.attr('data-dt-location') || $link.parents('.fancy-media-wrap').find('img').attr('data-dt-location') || ''
                        };
                        if (embedType == 'hosted'){
                            item['html'] = '<div class="pswp-video-wrap " data-type="'+ embedType+'"><div class="video-wrapper"><video controls class="pswp__video" src="'+ embedSrc +'" type="video/mp4"</video ></div></div>';
                        }
                    } else {
                        var item = {
                            src: link.href,
                            w: $this_data_w,
                            h: $this_data_h,
                            title: $this_data_desc,
                            shareLink: $link.attr('data-dt-location') || $link.find('img').attr('data-dt-location') || ''
                        }
                    }
                    galleries[i].items.push(item);

                });

                if($(gallery).prev().hasClass('dt-gallery-pswp')){

                    $(gallery).prev('.dt-gallery-pswp').on('click', function(e){
                        e.preventDefault();
                        var $this = $(this);

                        var $dataItem = $(this).next($(gallery)).find(_options.target);
                        var gid = $dataItem.data('gallery-id'),
                            pid = $dataItem.data('photo-id');
                        if (!$this.parents(".ts-wrap").hasClass("ts-interceptClicks")) {
                            openGallery(gid,pid, $this);
                        }
                    });
                }else{
                    $(gallery).on('click', _options.target, function(e){
                        var $this = $(this);

                        e.preventDefault();
                        var gid = $(this).data('gallery-id'),
                            pid = $(this).data('photo-id');

                        if (!$this.parents(".ts-wrap").hasClass("ts-interceptClicks")) {
                            openGallery(gid,pid, $this);
                        }
                    });
                }
            });
        };

        var openGallery = function(gid,pid,$el){
            var pswpElement = document.querySelectorAll('.pswp')[0],
                items = galleries[gid-1].items,
                item,
                options = {
                    index: pid,
                    galleryUID: gid,
                    shareEl:               true,
                    closeOnScroll:         false,
                    history:               false,
                    shareButtons: shareButtonsPattern,
                    getImageURLForShare: function( shareButtonData ) {
                        return gallery.currItem.src || '';
                    },
                    getPageURLForShare: function( shareButtonData ) {
                        return gallery.currItem.shareLink || window.location.href;
                    },
                    getTextForShare: function( shareButtonData ) {
                        var htmlString= gallery.currItem.title;
                        var stripedHtml = (typeof htmlString !="undefined") ? htmlString.replace(/<[^>]+>/g, '') : '';
                        return stripedHtml || '';
                    },

                    // Parse output of share links
                    parseShareButtonOut: function(shareButtonData, shareButtonOut) {
                        return shareButtonOut;
                    }
                };
            var $shareButtonsList = "";
            if(typeof $($el).next(".dt-gallery-container").attr('data-pretty-share')  != 'undefined' ){
                $shareButtonsList = $($el).next(".dt-gallery-container").attr('data-pretty-share').split(',');
            } if(typeof $($el).parents(".dt-gallery-container").attr('data-pretty-share')  != 'undefined' ){
                $shareButtonsList = $($el).parents(".dt-gallery-container").attr('data-pretty-share').split(',');
            }else if(typeof $($el).parents('.shortcode-single-image-wrap').attr('data-pretty-share')  != 'undefined' ){
                $shareButtonsList = $($el).parents('.shortcode-single-image-wrap').attr('data-pretty-share').split(',')
            }else if(typeof $($el).attr('data-pretty-share')  != 'undefined' ){
                $shareButtonsList = $($el).attr('data-pretty-share').split(',')
            }
            if ( $shareButtonsList.length <= 0 || typeof $shareButtonsList  == 'undefined'  ) {
                $('.pswp__scroll-wrap').addClass("hide-pspw-share");
            } else {
                $shareButtonsList.push('download');
            }
            showShareButtons($shareButtonsList);

            $.extend(options,_options);
            var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();

            $('.pswp__video').removeClass('active');
            var currItem = $(gallery.currItem.container);
            if(currItem.find('.pswp__video').length > 0){
                currItem.parents(".pswp").addClass("video-active");
            }

            $(".pswp__zoom-wrap").removeClass("active-item");

            currItem.addClass("active-item");
            //start video
            var $video_element = currItem.find('.pswp__video');
            if($video_element.length > 0){
                $video_element.addClass('active');
                currItem.parents(".pswp").addClass("video-active");
                if($video_element.parents('.pswp-video-wrap ').attr('data-type') == "hosted" ){
                    $video_element.get(0).play();
                }
                else{
                    var videoURL = $video_element.prop('src');
                    videoURL += "?autoplay=1";
                    $video_element.prop('src',videoURL);
                }
            }

            gallery.listen('beforeChange', function() {
                var currItem = $(gallery.currItem.container);
                $(".pswp__zoom-wrap").removeClass("active-item");
                currItem.addClass("active-item");
                $('.pswp__video').removeClass('active');
                $(".pswp").removeClass("video-active");
                var currItemIframe = currItem.find('.pswp__video').addClass('active');
                if(currItem.find('.pswp__video').length > 0){
                    currItem.parents(".pswp").addClass("video-active");
                }
                $('.pswp__video').each(function() {
                    var $this = $(this);

                    if (!$this.hasClass('active')) {
                        if($this.parents('.pswp-video-wrap ').attr('data-type') == "hosted"){
                            $this.get(0).pause();
                        }
                        else {
                            var videoURL = $this.prop('src');
                            videoURL = videoURL.replace("?autoplay=1", "?enablejsapi=1");

                            $this.prop('src', '');
                            $this.prop('src', videoURL);
                            $('.pswp__video').removeClass('active');
                            var iframe = $(this)[0].contentWindow;
                            if ($this.hasClass('active')) {
                                func = 'playVideo';
                            } else {
                                func = 'pauseVideo';
                            }
                            iframe.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
                        }
                    }
                    else{
                        if($this.parents('.pswp-video-wrap ').attr('data-type') == "hosted"){
                            $this.get(0).play();
                        }
                    }
                });
            });

            var pswpVideoTimer,
                pswpdestroyTimer;
            gallery.listen('close', function() {
                $('.pswp__video').each(function() {
                    var $this = $(this);
                    if($this.parents('.pswp-video-wrap ').attr('data-type') == "hosted"){
                        $this.get(0).pause();
                    }
                    else {
                        $this.attr('src', $this.attr('src'));
                        var videoURL = $this.prop('src');
                        videoURL = videoURL.replace("?autoplay=1", "?enablejsapi=1");

                        $this.prop('src', '');
                        $this.prop('src', videoURL);
                        $('.pswp__video').removeClass('active');
                        var iframe = $(this)[0].contentWindow;
                        if ($this.hasClass('active')) {
                            func = 'playVideo';
                        } else {
                            func = 'stopVideo';
                        }
                        iframe.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
                    }
                    clearTimeout( pswpVideoTimer );
                    pswpVideoTimer = setTimeout(function(){
                        $('.pswp-video-wrap').remove();
                    },200);
                });
            });
            gallery.listen('destroy', function() {
                clearTimeout( pswpdestroyTimer );
                pswpdestroyTimer = setTimeout(function() {
                    $('.pswp').removeClass().addClass('pswp');
                }, 100);
            });
        };

        // initialize
        init($elements);

        //Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = parseHash();
        if(hashData.pid > 0 && hashData.gid > 0) {
            openGallery(hashData.gid,hashData.pid);
        }
        return this;
    };

    $.fn.initCarouselClonedPhotoswipe = function() {
        return initPhotoswipeCommon(this, 'photoswipeCarousel');
    };

    $.fn.initPhotoswipe = function() {
        return initPhotoswipeCommon(this, 'photoswipe');
    };

    function initPhotoswipeCommon($elements, funcName) {
        if ($.fn[funcName] === undefined) {
            return;
        }
        return $elements.each(function() {
            var $this = $(this);
            $this[funcName]({
                bgOpacity: dtShare.overlayOpacity/100,
                loop: true,
                showHideOpacity:true
            });
        });
    }

    $('.shortcode-gallery.dt-gallery-container:not(.owl-loaded), .gallery-shortcode:not(.owl-loaded)').initPhotoswipe();

    $('.dt-trigger-first-pswp').addClass('pspw-ready').on('click', function(e){
        //e.preventDefault();
        var $this = $(this),
            $container = $this.parents('article.post').first();
        //prevent click on moving scroller
        if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
        if ( $container.length > 0 ) {
            var $target;
            if($container.find('.dt-gallery-container').length > 0){
                //open gallery (more then one img)
                 $target = $container.find('.dt-gallery-container a.dt-pswp-item');
            }else{
                //open gallery (single img)
                 $target = $container.find('a.dt-pswp-item');
            }

            if ( $target.length > 0 ) {
               // $target.first().trigger('click');
                $container.find('.rollover-click-target').trigger('click');
            }
        }

        return false;
    });

 

/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
/**
 * Owl carousel
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 * @todo Lazy Load Icon
 * @todo prevent animationend bubling
 * @todo itemsScaleUp
 * @todo Test Zepto
 * @todo stagePadding calculate wrong active classes
 */
 
 if($('.dt-owl-carousel-call').length > 0 || $(".slider-content").length > 0 || $(".dt-owl-carousel-init").length > 0 || $('body').hasClass('elementor-page')) {

 var owlCarouselOrigin = $.fn.owlCarousel;
;(function($, window, document, undefined) {

	/**
	 * Creates a carousel.
	 * @class The Owl Carousel.
	 * @public
	 * @param {HTMLElement|jQuery} element - The element to create the carousel for.
	 * @param {Object} [options] - The options
	 */
	function Owl(element, options) {

		/**
		 * Current settings for the carousel.
		 * @public
		 */
		this.settings = null;

		/**
		 * Current options set by the caller including defaults.
		 * @public
		 */
		this.options = $.extend({}, Owl.Defaults, options);

		/**
		 * Plugin element.
		 * @public
		 */
		this.$element = $(element);

		/**
		 * Proxied event handlers.
		 * @protected
		 */
		this._handlers = {};

		/**
		 * References to the running plugins of this carousel.
		 * @protected
		 */
		this._plugins = {};

		/**
		 * Currently suppressed events to prevent them from being retriggered.
		 * @protected
		 */
		this._supress = {};

		/**
		 * Absolute current position.
		 * @protected
		 */
		this._current = null;

		/**
		 * Animation speed in milliseconds.
		 * @protected
		 */
		this._speed = null;

		/**
		 * Coordinates of all items in pixel.
		 * @todo The name of this member is missleading.
		 * @protected
		 */
		this._coordinates = [];

		/**
		 * Current breakpoint.
		 * @todo Real media queries would be nice.
		 * @protected
		 */
		this._breakpoint = null;

		/**
		 * Current width of the plugin element.
		 */
		this._width = null;

		/**
		 * All real items.
		 * @protected
		 */
		this._items = [];

		/**
		 * All cloned items.
		 * @protected
		 */
		this._clones = [];

		/**
		 * Merge values of all items.
		 * @todo Maybe this could be part of a plugin.
		 * @protected
		 */
		this._mergers = [];

		/**
		 * Widths of all items.
		 */
		this._widths = [];

		/**
		 * Invalidated parts within the update process.
		 * @protected
		 */
		this._invalidated = {};

		/**
		 * Ordered list of workers for the update process.
		 * @protected
		 */
		this._pipe = [];

		/**
		 * Current state information for the drag operation.
		 * @todo #261
		 * @protected
		 */
		this._drag = {
			time: null,
			target: null,
			pointer: null,
			stage: {
				start: null,
				current: null
			},
			direction: null
		};

		/**
		 * Current state information and their tags.
		 * @type {Object}
		 * @protected
		 */
		this._states = {
			current: {},
			tags: {
				'initializing': [ 'busy' ],
				'animating': [ 'busy' ],
				'dragging': [ 'interacting' ]
			}
		};

		$.each([ 'onResize', 'onThrottledResize' ], $.proxy(function(i, handler) {
			this._handlers[handler] = $.proxy(this[handler], this);
		}, this));

		$.each(Owl.Plugins, $.proxy(function(key, plugin) {
			this._plugins[key.charAt(0).toLowerCase() + key.slice(1)]
				= new plugin(this);
		}, this));

		$.each(Owl.Workers, $.proxy(function(priority, worker) {
			this._pipe.push({
				'filter': worker.filter,
				'run': $.proxy(worker.run, this)
			});
		}, this));

		this.setup();
		this.initialize();
	}

	/**
	 * Default options for the carousel.
	 * @public
	 */
	Owl.Defaults = {
		items: 3,
		loop: false,
		center: false,
		rewind: false,
		checkVisibility: true,

		mouseDrag: true,
		touchDrag: true,
		pullDrag: true,
		freeDrag: false,

		margin: 0,
		stagePadding: 0,

		merge: false,
		mergeFit: true,
		autoWidth: false,

		startPosition: 0,
		rtl: false,

		smartSpeed: 250,
		fluidSpeed: false,
		dragEndSpeed: false,

		responsive: {},
		responsiveRefreshRate: 200,
		responsiveBaseElement: window,

		fallbackEasing: 'swing',
		slideTransition: '',

		info: false,

		nestedItemSelector: false,
		itemElement: 'div',
		stageElement: 'div',

		refreshClass: 'owl-refresh',
		loadedClass: 'owl-loaded',
		loadingClass: 'owl-loading',
		rtlClass: 'owl-rtl',
		responsiveClass: 'owl-responsive',
		dragClass: 'owl-drag',
		itemClass: 'dt-owl-item',
		stageClass: 'owl-stage',
		stageOuterClass: 'owl-stage-outer',
		grabClass: 'owl-grab'
	};

	/**
	 * Enumeration for width.
	 * @public
	 * @readonly
	 * @enum {String}
	 */
	Owl.Width = {
		Default: 'default',
		Inner: 'inner',
		Outer: 'outer'
	};

	/**
	 * Enumeration for types.
	 * @public
	 * @readonly
	 * @enum {String}
	 */
	Owl.Type = {
		Event: 'event',
		State: 'state'
	};

	/**
	 * Contains all registered plugins.
	 * @public
	 */
	Owl.Plugins = {};

	/**
	 * List of workers involved in the update process.
	 */
	Owl.Workers = [ {
		filter: [ 'width', 'settings' ],
		run: function() {
			this._width = this.$element.width();
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = this._items && this._items[this.relative(this._current)];
		}
	}, {
		filter: [ 'items', 'settings' ],
		run: function() {
			this.$stage.children('.cloned').remove();
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var margin = this.settings.margin || '',
				grid = !this.settings.autoWidth,
				rtl = this.settings.rtl,
				css = {
					'width': 'auto',
					'margin-left': rtl ? margin : '',
					'margin-right': rtl ? '' : margin
				};

			!grid && this.$stage.children().css(css);

			cache.css = css;
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var width = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,
				merge = null,
				iterator = this._items.length,
				grid = !this.settings.autoWidth,
				widths = [];

			cache.items = {
				merge: false,
				width: width
			};

			while (iterator--) {
				merge = this._mergers[iterator];
				merge = this.settings.mergeFit && Math.min(merge, this.settings.items) || merge;

				cache.items.merge = merge > 1 || cache.items.merge;

				widths[iterator] = !grid ? this._items[iterator].width() : width * merge;
			}

			this._widths = widths;
		}
	}, {
		filter: [ 'items', 'settings' ],
		run: function() {
			var clones = [],
				items = this._items,
				settings = this.settings,
				// TODO: Should be computed from number of min width items in stage
				view = Math.max(settings.items * 2, 4),
				size = Math.ceil(items.length / 2) * 2,
				repeat = settings.loop && items.length ? settings.rewind ? view : Math.max(view, size) : 0,
				append = '',
				prepend = '';

			repeat /= 2;

			while (repeat > 0) {
				// Switch to only using appended clones
				clones.push(this.normalize(clones.length / 2, true));
				append = append + items[clones[clones.length - 1]][0].outerHTML;
				clones.push(this.normalize(items.length - 1 - (clones.length - 1) / 2, true));
				prepend = items[clones[clones.length - 1]][0].outerHTML + prepend;
				repeat -= 1;
			}

			this._clones = clones;

			$(append).addClass('cloned').appendTo(this.$stage);
			$(prepend).addClass('cloned').prependTo(this.$stage);
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				size = this._clones.length + this._items.length,
				iterator = -1,
				previous = 0,
				current = 0,
				coordinates = [];

			while (++iterator < size) {
				previous = coordinates[iterator - 1] || 0;
				current = this._widths[this.relative(iterator)] + this.settings.margin;
				coordinates.push(previous + current * rtl);
			}

			this._coordinates = coordinates;
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function() {
			var padding = this.settings.stagePadding,
				coordinates = this._coordinates,
				css = {
					'width': Math.ceil(Math.abs(coordinates[coordinates.length - 1])) + padding * 2,
					'padding-left': padding || '',
					'padding-right': padding || ''
				};

			this.$stage.css(css);
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			var iterator = this._coordinates.length,
				grid = !this.settings.autoWidth,
				items = this.$stage.children();

			if (grid && cache.items.merge) {
				while (iterator--) {
					cache.css.width = this._widths[this.relative(iterator)];
					items.eq(iterator).css(cache.css);
				}
			} else if (grid) {
				cache.css.width = cache.items.width;
				items.css(cache.css);
			}
		}
	}, {
		filter: [ 'items' ],
		run: function() {
			this._coordinates.length < 1 && this.$stage.removeAttr('style');
		}
	}, {
		filter: [ 'width', 'items', 'settings' ],
		run: function(cache) {
			cache.current = cache.current ? this.$stage.children().index(cache.current) : 0;
			cache.current = Math.max(this.minimum(), Math.min(this.maximum(), cache.current));
			this.reset(cache.current);
		}
	}, {
		filter: [ 'position' ],
		run: function() {
			this.animate(this.coordinates(this._current));
		}
	}, {
		filter: [ 'width', 'position', 'items', 'settings' ],
		run: function() {
			var rtl = this.settings.rtl ? 1 : -1,
				padding = this.settings.stagePadding * 2,
				begin = this.coordinates(this.current()) + padding,
				end = begin + this.width() * rtl,
				inner, outer, matches = [], i, n;

			for (i = 0, n = this._coordinates.length; i < n; i++) {
				inner = this._coordinates[i - 1] || 0;
				outer = Math.abs(this._coordinates[i]) + padding * rtl;

				if ((this.op(inner, '<=', begin) && (this.op(inner, '>', end)))
					|| (this.op(outer, '<', begin) && this.op(outer, '>', end))) {
					matches.push(i);
				}
			}

			this.$stage.children('.active').removeClass('active');
			this.$stage.children(':eq(' + matches.join('), :eq(') + ')').addClass('active');

			this.$stage.children('.center').removeClass('center');
			if (this.settings.center) {
				this.$stage.children().eq(this.current()).addClass('center');
			}
		}
	} ];

	/**
	 * Create the stage DOM element
	 */
	Owl.prototype.initializeStage = function() {
		this.$stage = this.$element.find('.' + this.settings.stageClass);

		// if the stage is already in the DOM, grab it and skip stage initialization
		if (this.$stage.length) {
			return;
		}

		this.$element.addClass(this.options.loadingClass);

		// create stage
		this.$stage = $('<' + this.settings.stageElement + '>', {
			"class": this.settings.stageClass
		}).wrap( $( '<div/>', {
			"class": this.settings.stageOuterClass
		}));

		// append stage
		this.$element.append(this.$stage.parent());
	};

	/**
	 * Create item DOM elements
	 */
	Owl.prototype.initializeItems = function() {
		var $items = this.$element.find('.dt-owl-item');

		// if the items are already in the DOM, grab them and skip item initialization
		if ($items.length) {
			this._items = $items.get().map(function(item) {
				return $(item);
			});

			this._mergers = this._items.map(function() {
				return 1;
			});

			this.refresh();

			return;
		}

		// append content
		this.replace(this.$element.children().not(this.$stage.parent()));

		// check visibility
		if (this.isVisible()) {
			// update view
			this.refresh();
		} else {
			// invalidate width
			this.invalidate('width');
		}

		this.$element
			.removeClass(this.options.loadingClass)
			.addClass(this.options.loadedClass);
	};

	/**
	 * Initializes the carousel.
	 * @protected
	 */
	Owl.prototype.initialize = function() {
		this.enter('initializing');
		this.trigger('initialize');

		this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl);

		if (this.settings.autoWidth && !this.is('pre-loading')) {
			var imgs, nestedSelector, width;
			imgs = this.$element.find('img');
			nestedSelector = this.settings.nestedItemSelector ? '.' + this.settings.nestedItemSelector : undefined;
			width = this.$element.children(nestedSelector).width();

			if (imgs.length && width <= 0) {
				this.preloadAutoWidthImages(imgs);
			}
		}

		this.initializeStage();
		this.initializeItems();

		// register event handlers
		this.registerEventHandlers();

		this.leave('initializing');
		this.trigger('initialized');
	};

	/**
	 * @returns {Boolean} visibility of $element
	 *                    if you know the carousel will always be visible you can set `checkVisibility` to `false` to
	 *                    prevent the expensive browser layout forced reflow the $element.is(':visible') does
	 */
	Owl.prototype.isVisible = function() {
		return this.settings.checkVisibility
			? this.$element.is(':visible')
			: true;
	};

	/**
	 * Setups the current settings.
	 * @todo Remove responsive classes. Why should adaptive designs be brought into IE8?
	 * @todo Support for media queries by using `matchMedia` would be nice.
	 * @public
	 */
	Owl.prototype.setup = function() {
		var viewport = this.viewport(),
			overwrites = this.options.responsive,
			match = -1,
			settings = null;

		if (!overwrites) {
			settings = $.extend({}, this.options);
		} else {
			$.each(overwrites, function(breakpoint) {
				if (breakpoint <= viewport && breakpoint > match) {
					match = Number(breakpoint);
				}
			});

			settings = $.extend({}, this.options, overwrites[match]);
			if (typeof settings.stagePadding === 'function') {
				settings.stagePadding = settings.stagePadding();
			}
			delete settings.responsive;

			// responsive class
			if (settings.responsiveClass) {
				this.$element.attr('class',
					this.$element.attr('class').replace(new RegExp('(' + this.options.responsiveClass + '-)\\S+\\s', 'g'), '$1' + match)
				);
			}
		}

		this.trigger('change', { property: { name: 'settings', value: settings } });
		this._breakpoint = match;
		this.settings = settings;
		this.invalidate('settings');
		this.trigger('changed', { property: { name: 'settings', value: this.settings } });
	};

	/**
	 * Updates option logic if necessery.
	 * @protected
	 */
	Owl.prototype.optionsLogic = function() {
		if (this.settings.autoWidth) {
			this.settings.stagePadding = false;
			this.settings.merge = false;
		}
	};

	/**
	 * Prepares an item before add.
	 * @todo Rename event parameter `content` to `item`.
	 * @protected
	 * @returns {jQuery|HTMLElement} - The item container.
	 */
	Owl.prototype.prepare = function(item) {
		var event = this.trigger('prepare', { content: item });

		if (!event.data) {
			event.data = $('<' + this.settings.itemElement + '/>')
				.addClass(this.options.itemClass).append(item)
		}

		this.trigger('prepared', { content: event.data });

		return event.data;
	};

	/**
	 * Updates the view.
	 * @public
	 */
	Owl.prototype.update = function() {
		var i = 0,
			n = this._pipe.length,
			filter = $.proxy(function(p) { return this[p] }, this._invalidated),
			cache = {};

		while (i < n) {
			if (this._invalidated.all || $.grep(this._pipe[i].filter, filter).length > 0) {
				this._pipe[i].run(cache);
			}
			i++;
		}

		this._invalidated = {};

		!this.is('valid') && this.enter('valid');
	};

	/**
	 * Gets the width of the view.
	 * @public
	 * @param {Owl.Width} [dimension=Owl.Width.Default] - The dimension to return.
	 * @returns {Number} - The width of the view in pixel.
	 */
	Owl.prototype.width = function(dimension) {
		dimension = dimension || Owl.Width.Default;
		switch (dimension) {
			case Owl.Width.Inner:
			case Owl.Width.Outer:
				return this._width;
			default:
				return this._width - this.settings.stagePadding * 2 + this.settings.margin;
		}
	};

	/**
	 * Refreshes the carousel primarily for adaptive purposes.
	 * @public
	 */
	Owl.prototype.refresh = function() {
		this.enter('refreshing');
		this.trigger('refresh');

		this.setup();

		this.optionsLogic();

		this.$element.addClass(this.options.refreshClass);

		this.update();

		this.$element.removeClass(this.options.refreshClass);

		this.leave('refreshing');
		this.trigger('refreshed');
	};

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onThrottledResize = function() {
		window.clearTimeout(this.resizeTimer);
		this.resizeTimer = window.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate);
	};

	/**
	 * Checks window `resize` event.
	 * @protected
	 */
	Owl.prototype.onResize = function() {
		if (!this._items.length) {
			return false;
		}

		if (this._width === this.$element.width()) {
			return false;
		}

		if (!this.isVisible()) {
			return false;
		}

		this.enter('resizing');

		if (this.trigger('resize').isDefaultPrevented()) {
			this.leave('resizing');
			return false;
		}

		this.invalidate('width');

		this.refresh();

		this.leave('resizing');
		this.trigger('resized');
	};

	/**
	 * Registers event handlers.
	 * @todo Check `msPointerEnabled`
	 * @todo #261
	 * @protected
	 */
	Owl.prototype.registerEventHandlers = function() {
		if ($.support.transition) {
			this.$stage.on($.support.transition.end + '.owl.core', $.proxy(this.onTransitionEnd, this));
		}

		if (this.settings.responsive !== false) {
			this.on(window, 'resize', this._handlers.onThrottledResize);
		}

		if (this.settings.mouseDrag) {
			this.$element.addClass(this.options.dragClass);
			this.$stage.on('mousedown.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('dragstart.owl.core selectstart.owl.core', function() { return false });
		}

		if (this.settings.touchDrag){
			this.$stage.on('touchstart.owl.core', $.proxy(this.onDragStart, this));
			this.$stage.on('touchcancel.owl.core', $.proxy(this.onDragEnd, this));
		}
	};

	/**
	 * Handles `touchstart` and `mousedown` events.
	 * @todo Horizontal swipe threshold as option
	 * @todo #261
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragStart = function(event) {
		var stage = null;

		if (event.which === 3) {
			return;
		}

		if ($.support.transform) {
			stage = this.$stage.css('transform').replace(/.*\(|\)| /g, '').split(',');
			stage = {
				x: stage[stage.length === 16 ? 12 : 4],
				y: stage[stage.length === 16 ? 13 : 5]
			};
		} else {
			stage = this.$stage.position();
			stage = {
				x: this.settings.rtl ?
					stage.left + this.$stage.width() - this.width() + this.settings.margin :
					stage.left,
				y: stage.top
			};
		}

		if (this.is('animating')) {
			$.support.transform ? this.animate(stage.x) : this.$stage.stop()
			this.invalidate('position');
		}

		this.$element.toggleClass(this.options.grabClass, event.type === 'mousedown');

		this.speed(0);

		this._drag.time = new Date().getTime();
		this._drag.target = $(event.target);
		this._drag.stage.start = stage;
		this._drag.stage.current = stage;
		this._drag.pointer = this.pointer(event);

		$(document).on('mouseup.owl.core touchend.owl.core', $.proxy(this.onDragEnd, this));

		$(document).one('mousemove.owl.core touchmove.owl.core', $.proxy(function(event) {
			var delta = this.difference(this._drag.pointer, this.pointer(event));

			$(document).on('mousemove.owl.core touchmove.owl.core', $.proxy(this.onDragMove, this));

			if (Math.abs(delta.x) < Math.abs(delta.y) && this.is('valid')) {
				return;
			}

			event.preventDefault();

			this.enter('dragging');
			this.trigger('drag');
		}, this));
	};

	/**
	 * Handles the `touchmove` and `mousemove` events.
	 * @todo #261
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragMove = function(event) {
		var minimum = null,
			maximum = null,
			pull = null,
			delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this.difference(this._drag.stage.start, delta);

		if (!this.is('dragging')) {
			return;
		}

		event.preventDefault();

		if (this.settings.loop) {
			minimum = this.coordinates(this.minimum());
			maximum = this.coordinates(this.maximum() + 1) - minimum;
			stage.x = (((stage.x - minimum) % maximum + maximum) % maximum) + minimum;
		} else {
			minimum = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum());
			maximum = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum());
			pull = this.settings.pullDrag ? -1 * delta.x / 5 : 0;
			stage.x = Math.max(Math.min(stage.x, minimum + pull), maximum + pull);
		}

		this._drag.stage.current = stage;

		this.animate(stage.x);
	};

	/**
	 * Handles the `touchend` and `mouseup` events.
	 * @todo #261
	 * @todo Threshold for click event
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onDragEnd = function(event) {
		var delta = this.difference(this._drag.pointer, this.pointer(event)),
			stage = this._drag.stage.current,
			direction = delta.x > 0 ^ this.settings.rtl ? 'left' : 'right';

		$(document).off('.owl.core');

		this.$element.removeClass(this.options.grabClass);

		if (delta.x !== 0 && this.is('dragging') || !this.is('valid')) {
			this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed);
			this.current(this.closest(stage.x, delta.x !== 0 ? direction : this._drag.direction));
			this.invalidate('position');
			this.update();

			this._drag.direction = direction;

			if (Math.abs(delta.x) > 3 || new Date().getTime() - this._drag.time > 300) {
				this._drag.target.one('click.owl.core', function() { return false; });
			}
		}

		if (!this.is('dragging')) {
			return;
		}

		this.leave('dragging');
		this.trigger('dragged');
	};

	/**
	 * Gets absolute position of the closest item for a coordinate.
	 * @todo Setting `freeDrag` makes `closest` not reusable. See #165.
	 * @protected
	 * @param {Number} coordinate - The coordinate in pixel.
	 * @param {String} direction - The direction to check for the closest item. Ether `left` or `right`.
	 * @return {Number} - The absolute position of the closest item.
	 */
	Owl.prototype.closest = function(coordinate, direction) {
		var position = -1,
			pull = 30,
			width = this.width(),
			coordinates = this.coordinates();

		if (!this.settings.freeDrag) {
			// check closest item
			$.each(coordinates, $.proxy(function(index, value) {
				// on a left pull, check on current index
				if (direction === 'left' && coordinate > value - pull && coordinate < value + pull) {
					position = index;
				// on a right pull, check on previous index
				// to do so, subtract width from value and set position = index + 1
				} else if (direction === 'right' && coordinate > value - width - pull && coordinate < value - width + pull) {
					position = index + 1;
				} else if (this.op(coordinate, '<', value)
					&& this.op(coordinate, '>', coordinates[index + 1] !== undefined ? coordinates[index + 1] : value - width)) {
					position = direction === 'left' ? index + 1 : index;
				}
				return position === -1;
			}, this));
		}

		if (!this.settings.loop) {
			// non loop boundries
			if (this.op(coordinate, '>', coordinates[this.minimum()])) {
				position = coordinate = this.minimum();
			} else if (this.op(coordinate, '<', coordinates[this.maximum()])) {
				position = coordinate = this.maximum();
			}
		}

		return position;
	};

	/**
	 * Animates the stage.
	 * @todo #270
	 * @public
	 * @param {Number} coordinate - The coordinate in pixels.
	 */
	Owl.prototype.animate = function(coordinate) {
		var animate = this.speed() > 0;

		this.is('animating') && this.onTransitionEnd();

		if (animate) {
			this.enter('animating');
			this.trigger('translate');
		}

		if ($.support.transform3d && $.support.transition) {
			this.$stage.css({
				transform: 'translate3d(' + coordinate + 'px,0px,0px)',
				transition: (this.speed() / 1000) + 's' + (
					this.settings.slideTransition ? ' ' + this.settings.slideTransition : ''
				)
			});
		} else if (animate) {
			this.$stage.animate({
				left: coordinate + 'px'
			}, this.speed(), this.settings.fallbackEasing, $.proxy(this.onTransitionEnd, this));
		} else {
			this.$stage.css({
				left: coordinate + 'px'
			});
		}
	};

	/**
	 * Checks whether the carousel is in a specific state or not.
	 * @param {String} state - The state to check.
	 * @returns {Boolean} - The flag which indicates if the carousel is busy.
	 */
	Owl.prototype.is = function(state) {
		return this._states.current[state] && this._states.current[state] > 0;
	};

	/**
	 * Sets the absolute position of the current item.
	 * @public
	 * @param {Number} [position] - The new absolute position or nothing to leave it unchanged.
	 * @returns {Number} - The absolute position of the current item.
	 */
	Owl.prototype.current = function(position) {
		if (position === undefined) {
			return this._current;
		}

		if (this._items.length === 0) {
			return undefined;
		}

		position = this.normalize(position);

		if (this._current !== position) {
			var event = this.trigger('change', { property: { name: 'position', value: position } });

			if (event.data !== undefined) {
				position = this.normalize(event.data);
			}

			this._current = position;

			this.invalidate('position');

			this.trigger('changed', { property: { name: 'position', value: this._current } });
		}

		return this._current;
	};

	/**
	 * Invalidates the given part of the update routine.
	 * @param {String} [part] - The part to invalidate.
	 * @returns {Array.<String>} - The invalidated parts.
	 */
	Owl.prototype.invalidate = function(part) {
		if ($.type(part) === 'string') {
			this._invalidated[part] = true;
			this.is('valid') && this.leave('valid');
		}
		return $.map(this._invalidated, function(v, i) { return i });
	};

	/**
	 * Resets the absolute position of the current item.
	 * @public
	 * @param {Number} position - The absolute position of the new item.
	 */
	Owl.prototype.reset = function(position) {
		position = this.normalize(position);

		if (position === undefined) {
			return;
		}

		this._speed = 0;
		this._current = position;

		this.suppress([ 'translate', 'translated' ]);

		this.animate(this.coordinates(position));

		this.release([ 'translate', 'translated' ]);
	};

	/**
	 * Normalizes an absolute or a relative position of an item.
	 * @public
	 * @param {Number} position - The absolute or relative position to normalize.
	 * @param {Boolean} [relative=false] - Whether the given position is relative or not.
	 * @returns {Number} - The normalized position.
	 */
	Owl.prototype.normalize = function(position, relative) {
		var n = this._items.length,
			m = relative ? 0 : this._clones.length;

		if (!this.isNumeric(position) || n < 1) {
			position = undefined;
		} else if (position < 0 || position >= n + m) {
			position = ((position - m / 2) % n + n) % n + m / 2;
		}

		return position;
	};

	/**
	 * Converts an absolute position of an item into a relative one.
	 * @public
	 * @param {Number} position - The absolute position to convert.
	 * @returns {Number} - The converted position.
	 */
	Owl.prototype.relative = function(position) {
		position -= this._clones.length / 2;
		return this.normalize(position, true);
	};

	/**
	 * Gets the maximum position for the current item.
	 * @public
	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number}
	 */
	Owl.prototype.maximum = function(relative) {
		var settings = this.settings,
			maximum = this._coordinates.length,
			iterator,
			reciprocalItemsWidth,
			elementWidth;

		if (settings.loop) {
			maximum = this._clones.length / 2 + this._items.length - 1;
		} else if (settings.autoWidth || settings.merge) {
			iterator = this._items.length;
			if (iterator) {
				reciprocalItemsWidth = this._items[--iterator].width();
				elementWidth = this.$element.width();
				while (iterator--) {
					reciprocalItemsWidth += this._items[iterator].width() + this.settings.margin;
					if (reciprocalItemsWidth > elementWidth) {
						break;
					}
				}
			}
			maximum = iterator + 1;
		} else if (settings.center) {
			maximum = this._items.length - 1;
		} else {
			maximum = this._items.length - settings.items;
		}

		if (relative) {
			maximum -= this._clones.length / 2;
		}

		return Math.max(maximum, 0);
	};

	/**
	 * Gets the minimum position for the current item.
	 * @public
	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.
	 * @returns {Number}
	 */
	Owl.prototype.minimum = function(relative) {
		return relative ? 0 : this._clones.length / 2;
	};

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.items = function(position) {
		if (position === undefined) {
			return this._items.slice();
		}

		position = this.normalize(position, true);
		return this._items[position];
	};

	/**
	 * Gets an item at the specified relative position.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.
	 */
	Owl.prototype.mergers = function(position) {
		if (position === undefined) {
			return this._mergers.slice();
		}

		position = this.normalize(position, true);
		return this._mergers[position];
	};

	/**
	 * Gets the absolute positions of clones for an item.
	 * @public
	 * @param {Number} [position] - The relative position of the item.
	 * @returns {Array.<Number>} - The absolute positions of clones for the item or all if no position was given.
	 */
	Owl.prototype.clones = function(position) {
		var odd = this._clones.length / 2,
			even = odd + this._items.length,
			map = function(index) { return index % 2 === 0 ? even + index / 2 : odd - (index + 1) / 2 };

		if (position === undefined) {
			return $.map(this._clones, function(v, i) { return map(i) });
		}

		return $.map(this._clones, function(v, i) { return v === position ? map(i) : null });
	};

	/**
	 * Sets the current animation speed.
	 * @public
	 * @param {Number} [speed] - The animation speed in milliseconds or nothing to leave it unchanged.
	 * @returns {Number} - The current animation speed in milliseconds.
	 */
	Owl.prototype.speed = function(speed) {
		if (speed !== undefined) {
			this._speed = speed;
		}

		return this._speed;
	};

	/**
	 * Gets the coordinate of an item.
	 * @todo The name of this method is missleanding.
	 * @public
	 * @param {Number} position - The absolute position of the item within `minimum()` and `maximum()`.
	 * @returns {Number|Array.<Number>} - The coordinate of the item in pixel or all coordinates.
	 */
	Owl.prototype.coordinates = function(position) {
		var multiplier = 1,
			newPosition = position - 1,
			coordinate;

		if (position === undefined) {
			return $.map(this._coordinates, $.proxy(function(coordinate, index) {
				return this.coordinates(index);
			}, this));
		}

		if (this.settings.center) {
			if (this.settings.rtl) {
				multiplier = -1;
				newPosition = position + 1;
			}

			coordinate = this._coordinates[position];
			coordinate += (this.width() - coordinate + (this._coordinates[newPosition] || 0)) / 2 * multiplier;
		} else {
			coordinate = this._coordinates[newPosition] || 0;
		}

		coordinate = Math.ceil(coordinate);

		return coordinate;
	};

	/**
	 * Calculates the speed for a translation.
	 * @protected
	 * @param {Number} from - The absolute position of the start item.
	 * @param {Number} to - The absolute position of the target item.
	 * @param {Number} [factor=undefined] - The time factor in milliseconds.
	 * @returns {Number} - The time in milliseconds for the translation.
	 */
	Owl.prototype.duration = function(from, to, factor) {
		if (factor === 0) {
			return 0;
		}

		return Math.min(Math.max(Math.abs(to - from), 1), 6) * Math.abs((factor || this.settings.smartSpeed));
	};

	/**
	 * Slides to the specified item.
	 * @public
	 * @param {Number} position - The position of the item.
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.to = function(position, speed) {
		var current = this.current(),
			revert = null,
			distance = position - this.relative(current),
			direction = (distance > 0) - (distance < 0),
			items = this._items.length,
			minimum = this.minimum(),
			maximum = this.maximum();

		if (this.settings.loop) {
			if (!this.settings.rewind && Math.abs(distance) > items / 2) {
				distance += direction * -1 * items;
			}

			position = current + distance;
			revert = ((position - minimum) % items + items) % items + minimum;

			if (revert !== position && revert - distance <= maximum && revert - distance > 0) {
				current = revert - distance;
				position = revert;
				this.reset(current);
			}
		} else if (this.settings.rewind) {
			maximum += 1;
			position = (position % maximum + maximum) % maximum;
		} else {
			position = Math.max(minimum, Math.min(maximum, position));
		}

		this.speed(this.duration(current, position, speed));
		this.current(position);

		if (this.isVisible()) {
			this.update();
		}
	};

	/**
	 * Slides to the next item.
	 * @public
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.next = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) + 1, speed);
	};

	/**
	 * Slides to the previous item.
	 * @public
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 */
	Owl.prototype.prev = function(speed) {
		speed = speed || false;
		this.to(this.relative(this.current()) - 1, speed);
	};

	/**
	 * Handles the end of an animation.
	 * @protected
	 * @param {Event} event - The event arguments.
	 */
	Owl.prototype.onTransitionEnd = function(event) {

		// if css2 animation then event object is undefined
		if (event !== undefined) {
			event.stopPropagation();

			// Catch only owl-stage transitionEnd event
			if ((event.target || event.srcElement || event.originalTarget) !== this.$stage.get(0)) {
				return false;
			}
		}

		this.leave('animating');
		this.trigger('translated');
	};

	/**
	 * Gets viewport width.
	 * @protected
	 * @return {Number} - The width in pixel.
	 */
	Owl.prototype.viewport = function() {
		var width;
		if (this.options.responsiveBaseElement !== window) {
			width = $(this.options.responsiveBaseElement).width();
		} else if (window.innerWidth) {
			width = window.innerWidth;
		} else if (document.documentElement && document.documentElement.clientWidth) {
			width = document.documentElement.clientWidth;
		} else {
			console.warn('Can not detect viewport width.');
		}
		return width;
	};

	/**
	 * Replaces the current content.
	 * @public
	 * @param {HTMLElement|jQuery|String} content - The new content.
	 */
	Owl.prototype.replace = function(content) {
		this.$stage.empty();
		this._items = [];

		if (content) {
			content = (content instanceof jQuery) ? content : $(content);
		}

		if (this.settings.nestedItemSelector) {
			content = content.find('.' + this.settings.nestedItemSelector);
		}

		content.filter(function() {
			return this.nodeType === 1;
		}).each($.proxy(function(index, item) {
			item = this.prepare(item);
			this.$stage.append(item);
			this._items.push(item);
			this._mergers.push(item.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		}, this));

		this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0);

		this.invalidate('items');
	};

	/**
	 * Adds an item.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {HTMLElement|jQuery|String} content - The item content to add.
	 * @param {Number} [position] - The relative position at which to insert the item otherwise the item will be added to the end.
	 */
	Owl.prototype.add = function(content, position) {
		var current = this.relative(this._current);

		position = position === undefined ? this._items.length : this.normalize(position, true);
		content = content instanceof jQuery ? content : $(content);

		this.trigger('add', { content: content, position: position });

		content = this.prepare(content);

		if (this._items.length === 0 || position === this._items.length) {
			this._items.length === 0 && this.$stage.append(content);
			this._items.length !== 0 && this._items[position - 1].after(content);
			this._items.push(content);
			this._mergers.push(content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		} else {
			this._items[position].before(content);
			this._items.splice(position, 0, content);
			this._mergers.splice(position, 0, content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);
		}

		this._items[current] && this.reset(this._items[current].index());

		this.invalidate('items');

		this.trigger('added', { content: content, position: position });
	};

	/**
	 * Removes an item by its position.
	 * @todo Use `item` instead of `content` for the event arguments.
	 * @public
	 * @param {Number} position - The relative position of the item to remove.
	 */
	Owl.prototype.remove = function(position) {
		position = this.normalize(position, true);

		if (position === undefined) {
			return;
		}

		this.trigger('remove', { content: this._items[position], position: position });

		this._items[position].remove();
		this._items.splice(position, 1);
		this._mergers.splice(position, 1);

		this.invalidate('items');

		this.trigger('removed', { content: null, position: position });
	};

	/**
	 * Preloads images with auto width.
	 * @todo Replace by a more generic approach
	 * @protected
	 */
	Owl.prototype.preloadAutoWidthImages = function(images) {
		images.each($.proxy(function(i, element) {
			this.enter('pre-loading');
			element = $(element);
			$(new Image()).one('load', $.proxy(function(e) {
				element.attr('src', e.target.src);
				element.css('opacity', 1);
				this.leave('pre-loading');
				!this.is('pre-loading') && !this.is('initializing') && this.refresh();
			}, this)).attr('src', element.attr('src') || element.attr('data-src') || element.attr('data-src-retina'));
		}, this));
	};

	/**
	 * Destroys the carousel.
	 * @public
	 */
	Owl.prototype.destroy = function() {

		this.$element.off('.owl.core');
		this.$stage.off('.owl.core');
		$(document).off('.owl.core');

		if (this.settings.responsive !== false) {
			window.clearTimeout(this.resizeTimer);
			this.off(window, 'resize', this._handlers.onThrottledResize);
		}

		for (var i in this._plugins) {
			this._plugins[i].destroy();
		}

		this.$stage.children('.cloned').remove();

		this.$stage.unwrap();
		this.$stage.children().contents().unwrap();
		this.$stage.children().unwrap();
		this.$stage.remove();
		this.$element
			.removeClass(this.options.refreshClass)
			.removeClass(this.options.loadingClass)
			.removeClass(this.options.loadedClass)
			.removeClass(this.options.rtlClass)
			.removeClass(this.options.dragClass)
			.removeClass(this.options.grabClass)
			.attr('class', this.$element.attr('class').replace(new RegExp(this.options.responsiveClass + '-\\S+\\s', 'g'), ''))
			.removeData('owl.carousel');
	};

	/**
	 * Operators to calculate right-to-left and left-to-right.
	 * @protected
	 * @param {Number} [a] - The left side operand.
	 * @param {String} [o] - The operator.
	 * @param {Number} [b] - The right side operand.
	 */
	Owl.prototype.op = function(a, o, b) {
		var rtl = this.settings.rtl;
		switch (o) {
			case '<':
				return rtl ? a > b : a < b;
			case '>':
				return rtl ? a < b : a > b;
			case '>=':
				return rtl ? a <= b : a >= b;
			case '<=':
				return rtl ? a >= b : a <= b;
			default:
				break;
		}
	};

	/**
	 * Attaches to an internal event.
	 * @protected
	 * @param {HTMLElement} element - The event source.
	 * @param {String} event - The event name.
	 * @param {Function} listener - The event handler to attach.
	 * @param {Boolean} capture - Wether the event should be handled at the capturing phase or not.
	 */
	Owl.prototype.on = function(element, event, listener, capture) {
		if (element.addEventListener) {
			element.addEventListener(event, listener, capture);
		} else if (element.attachEvent) {
			element.attachEvent('on' + event, listener);
		}
	};

	/**
	 * Detaches from an internal event.
	 * @protected
	 * @param {HTMLElement} element - The event source.
	 * @param {String} event - The event name.
	 * @param {Function} listener - The attached event handler to detach.
	 * @param {Boolean} capture - Wether the attached event handler was registered as a capturing listener or not.
	 */
	Owl.prototype.off = function(element, event, listener, capture) {
		if (element.removeEventListener) {
			element.removeEventListener(event, listener, capture);
		} else if (element.detachEvent) {
			element.detachEvent('on' + event, listener);
		}
	};

	/**
	 * Triggers a public event.
	 * @todo Remove `status`, `relatedTarget` should be used instead.
	 * @protected
	 * @param {String} name - The event name.
	 * @param {*} [data=null] - The event data.
	 * @param {String} [namespace=carousel] - The event namespace.
	 * @param {String} [state] - The state which is associated with the event.
	 * @param {Boolean} [enter=false] - Indicates if the call enters the specified state or not.
	 * @returns {Event} - The event arguments.
	 */
	Owl.prototype.trigger = function(name, data, namespace, state, enter) {
		var status = {
			item: { count: this._items.length, index: this.current() }
		}, handler = $.camelCase(
			$.grep([ 'on', name, namespace ], function(v) { return v })
				.join('-').toLowerCase()
		), event = $.Event(
			[ name, 'owl', namespace || 'carousel' ].join('.').toLowerCase(),
			$.extend({ relatedTarget: this }, status, data)
		);

		if (!this._supress[name]) {
			$.each(this._plugins, function(name, plugin) {
				if (plugin.onTrigger) {
					plugin.onTrigger(event);
				}
			});

			this.register({ type: Owl.Type.Event, name: name });
			this.$element.trigger(event);

			if (this.settings && typeof this.settings[handler] === 'function') {
				this.settings[handler].call(this, event);
			}
		}

		return event;
	};

	/**
	 * Enters a state.
	 * @param name - The state name.
	 */
	Owl.prototype.enter = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			if (this._states.current[name] === undefined) {
				this._states.current[name] = 0;
			}

			this._states.current[name]++;
		}, this));
	};

	/**
	 * Leaves a state.
	 * @param name - The state name.
	 */
	Owl.prototype.leave = function(name) {
		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {
			this._states.current[name]--;
		}, this));
	};

	/**
	 * Registers an event or state.
	 * @public
	 * @param {Object} object - The event or state to register.
	 */
	Owl.prototype.register = function(object) {
		if (object.type === Owl.Type.Event) {
			if (!$.event.special[object.name]) {
				$.event.special[object.name] = {};
			}

			if (!$.event.special[object.name].owl) {
				var _default = $.event.special[object.name]._default;
				$.event.special[object.name]._default = function(e) {
					if (_default && _default.apply && (!e.namespace || e.namespace.indexOf('owl') === -1)) {
						return _default.apply(this, arguments);
					}
					return e.namespace && e.namespace.indexOf('owl') > -1;
				};
				$.event.special[object.name].owl = true;
			}
		} else if (object.type === Owl.Type.State) {
			if (!this._states.tags[object.name]) {
				this._states.tags[object.name] = object.tags;
			} else {
				this._states.tags[object.name] = this._states.tags[object.name].concat(object.tags);
			}

			this._states.tags[object.name] = $.grep(this._states.tags[object.name], $.proxy(function(tag, i) {
				return $.inArray(tag, this._states.tags[object.name]) === i;
			}, this));
		}
	};

	/**
	 * Suppresses events.
	 * @protected
	 * @param {Array.<String>} events - The events to suppress.
	 */
	Owl.prototype.suppress = function(events) {
		$.each(events, $.proxy(function(index, event) {
			this._supress[event] = true;
		}, this));
	};

	/**
	 * Releases suppressed events.
	 * @protected
	 * @param {Array.<String>} events - The events to release.
	 */
	Owl.prototype.release = function(events) {
		$.each(events, $.proxy(function(index, event) {
			delete this._supress[event];
		}, this));
	};

	/**
	 * Gets unified pointer coordinates from event.
	 * @todo #261
	 * @protected
	 * @param {Event} - The `mousedown` or `touchstart` event.
	 * @returns {Object} - Contains `x` and `y` coordinates of current pointer position.
	 */
	Owl.prototype.pointer = function(event) {
		var result = { x: null, y: null };

		event = event.originalEvent || event || window.event;

		event = event.touches && event.touches.length ?
			event.touches[0] : event.changedTouches && event.changedTouches.length ?
				event.changedTouches[0] : event;

		if (event.pageX) {
			result.x = event.pageX;
			result.y = event.pageY;
		} else {
			result.x = event.clientX;
			result.y = event.clientY;
		}

		return result;
	};

	/**
	 * Determines if the input is a Number or something that can be coerced to a Number
	 * @protected
	 * @param {Number|String|Object|Array|Boolean|RegExp|Function|Symbol} - The input to be tested
	 * @returns {Boolean} - An indication if the input is a Number or can be coerced to a Number
	 */
	Owl.prototype.isNumeric = function(number) {
		return !isNaN(parseFloat(number));
	};

	/**
	 * Gets the difference of two vectors.
	 * @todo #261
	 * @protected
	 * @param {Object} - The first vector.
	 * @param {Object} - The second vector.
	 * @returns {Object} - The difference.
	 */
	Owl.prototype.difference = function(first, second) {
		return {
			x: first.x - second.x,
			y: first.y - second.y
		};
	};

	/**
	 * The jQuery Plugin for the Owl Carousel
	 * @todo Navigation plugin `next` and `prev`
	 * @public
	 */
	$.fn.owlCarousel = function(option) {
		var args = Array.prototype.slice.call(arguments, 1);

		return this.each(function() {
			var $this = $(this),
				data = $this.data('owl.carousel');

			if (!data) {
				data = new Owl(this, typeof option == 'object' && option);
				$this.data('owl.carousel', data);

				$.each([
					'next', 'prev', 'to', 'destroy', 'refresh', 'replace', 'add', 'remove'
				], function(i, event) {
					data.register({ type: Owl.Type.Event, name: event });
					data.$element.on(event + '.owl.carousel.core', $.proxy(function(e) {
						if (e.namespace && e.relatedTarget !== this) {
							this.suppress([ event ]);
							data[event].apply(this, [].slice.call(arguments, 1));
							this.release([ event ]);
						}
					}, data));
				});
			}

			if (typeof option == 'string' && option.charAt(0) !== '_') {
				data[option].apply(data, args);
			}
		});
	};

	/**
	 * The constructor for the jQuery Plugin
	 * @public
	 */
	$.fn.owlCarousel.Constructor = Owl;

})(window.Zepto || window.jQuery, window, document);

/**
 * AutoRefresh Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto refresh plugin.
	 * @class The Auto Refresh Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var AutoRefresh = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Refresh interval.
		 * @protected
		 * @type {number}
		 */
		this._interval = null;

		/**
		 * Whether the element is currently visible or not.
		 * @protected
		 * @type {Boolean}
		 */
		this._visible = null;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoRefresh) {
					this.watch();
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, AutoRefresh.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	AutoRefresh.Defaults = {
		autoRefresh: true,
		autoRefreshInterval: 500
	};

	/**
	 * Watches the element.
	 */
	AutoRefresh.prototype.watch = function() {
		if (this._interval) {
			return;
		}

		this._visible = this._core.isVisible();
		this._interval = window.setInterval($.proxy(this.refresh, this), this._core.settings.autoRefreshInterval);
	};

	/**
	 * Refreshes the element.
	 */
	AutoRefresh.prototype.refresh = function() {
		if (this._core.isVisible() === this._visible) {
			return;
		}

		this._visible = !this._visible;

		this._core.$element.toggleClass('owl-hidden', !this._visible);

		this._visible && (this._core.invalidate('width') && this._core.refresh());
	};

	/**
	 * Destroys the plugin.
	 */
	AutoRefresh.prototype.destroy = function() {
		var handler, property;

		window.clearInterval(this._interval);

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.AutoRefresh = AutoRefresh;

})(window.Zepto || window.jQuery, window, document);

/**
 * Lazy Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the lazy plugin.
	 * @class The Lazy Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Lazy = function(carousel) {

		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Already loaded items.
		 * @protected
		 * @type {Array.<jQuery>}
		 */
		this._loaded = [];

		/**
		 * Event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel change.owl.carousel resized.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				}

				if (!this._core.settings || !this._core.settings.lazyLoad) {
					return;
				}

				if ((e.property && e.property.name == 'position') || e.type == 'initialized') {
					var settings = this._core.settings,
						n = (settings.center && Math.ceil(settings.items / 2) || settings.items),
						i = ((settings.center && n * -1) || 0),
						position = (e.property && e.property.value !== undefined ? e.property.value : this._core.current()) + i,
						clones = this._core.clones().length,
						load = $.proxy(function(i, v) { this.load(v) }, this);
					//TODO: Need documentation for this new option
					if (settings.lazyLoadEager > 0) {
						n += settings.lazyLoadEager;
						// If the carousel is looping also preload images that are to the "left"
						if (settings.loop) {
              position -= settings.lazyLoadEager;
              n++;
            }
					}

					while (i++ < n) {
						this.load(clones / 2 + this._core.relative(position));
						clones && $.each(this._core.clones(this._core.relative(position)), load);
						position++;
					}
				}
			}, this)
		};

		// set the default options
		this._core.options = $.extend({}, Lazy.Defaults, this._core.options);

		// register event handler
		this._core.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	Lazy.Defaults = {
		lazyLoad: false,
		lazyLoadEager: 0
	};

	/**
	 * Loads all resources of an item at the specified position.
	 * @param {Number} position - The absolute position of the item.
	 * @protected
	 */
	Lazy.prototype.load = function(position) {
		var $item = this._core.$stage.children().eq(position),
			$elements = $item && $item.find('.owl-lazy');

		if (!$elements || $.inArray($item.get(0), this._loaded) > -1) {
			return;
		}

		$elements.each($.proxy(function(index, element) {
			var $element = $(element), image,
                url = (window.devicePixelRatio > 1 && $element.attr('data-src-retina')) || $element.attr('data-src') || $element.attr('data-srcset');

			this._core.trigger('load', { element: $element, url: url }, 'lazy');

			if ($element.is('img')) {
				$element.one('load.owl.lazy', $.proxy(function() {
					$element.css('opacity', 1);
					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
				}, this)).attr('src', url);
            } else if ($element.is('source')) {
                $element.one('load.owl.lazy', $.proxy(function() {
                    this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
                }, this)).attr('srcset', url);
			} else {
				image = new Image();
				image.onload = $.proxy(function() {
					$element.css({
						'background-image': 'url("' + url + '")',
						'opacity': '1'
					});
					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');
				}, this);
				image.src = url;
			}
		}, this));

		this._loaded.push($item.get(0));
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Lazy.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this._core.$element.off(handler, this.handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Lazy = Lazy;

})(window.Zepto || window.jQuery, window, document);

/**
 * AutoHeight Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the auto height plugin.
	 * @class The Auto Height Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var AutoHeight = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		this._previousHeight = null;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight) {
					this.update();
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight && e.property.name === 'position'){
					this.update();
				}
			}, this),
			'loaded.owl.lazy': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoHeight
					&& e.element.closest('.' + this._core.settings.itemClass).index() === this._core.current()) {
					this.update();
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, AutoHeight.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);
		this._intervalId = null;
		var refThis = this;

		// These changes have been taken from a PR by gavrochelegnou proposed in #1575
		// and have been made compatible with the latest jQuery version
		$(window).on('load', function() {
			if (refThis._core.settings.autoHeight) {
				refThis.update();
			}
		});

		// Autoresize the height of the carousel when window is resized
		// When carousel has images, the height is dependent on the width
		// and should also change on resize
		$(window).resize(function() {
			if (refThis._core.settings.autoHeight) {
				if (refThis._intervalId != null) {
					clearTimeout(refThis._intervalId);
				}

				refThis._intervalId = setTimeout(function() {
					refThis.update();
				}, 250);
			}
		});

	};

	/**
	 * Default options.
	 * @public
	 */
	AutoHeight.Defaults = {
		autoHeight: false,
		autoHeightClass: 'owl-height'
	};

	/**
	 * Updates the view.
	 */
	AutoHeight.prototype.update = function() {
		var start = this._core._current,
			end = start + this._core.settings.items,
			lazyLoadEnabled = this._core.settings.lazyLoad,
			visible = this._core.$stage.children().toArray().slice(start, end),
			heights = [],
			maxheight = 0;

		$.each(visible, function(index, item) {
			heights.push($(item).height());
		});

		maxheight = Math.max.apply(null, heights);

		if (maxheight <= 1 && lazyLoadEnabled && this._previousHeight) {
			maxheight = this._previousHeight;
		}

		this._previousHeight = maxheight;

		this._core.$stage.parent()
			.height(maxheight)
			.addClass(this._core.settings.autoHeightClass);
	};

	AutoHeight.prototype.destroy = function() {
		var handler, property;

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] !== 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.AutoHeight = AutoHeight;

})(window.Zepto || window.jQuery, window, document);

/**
 * Video Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the video plugin.
	 * @class The Video Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Video = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Cache all video URLs.
		 * @protected
		 * @type {Object}
		 */
		this._videos = {};

		/**
		 * Current playing item.
		 * @protected
		 * @type {jQuery}
		 */
		this._playing = null;

		/**
		 * All event handlers.
		 * @todo The cloned content removale is too late
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this._core.register({ type: 'state', name: 'playing', tags: [ 'interacting' ] });
				}
			}, this),
			'resize.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.video && this.isInFullScreen()) {
					e.preventDefault();
				}
			}, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.is('resizing')) {
					this._core.$stage.find('.cloned .owl-video-frame').remove();
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position' && this._playing) {
					this.stop();
				}
			}, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (!e.namespace) {
					return;
				}

				var $element = $(e.content).find('.owl-video');

				if ($element.length) {
					$element.css('display', 'none');
					this.fetch($element, $(e.content));
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Video.Defaults, this._core.options);

		// register event handlers
		this._core.$element.on(this._handlers);

		this._core.$element.on('click.owl.video', '.owl-video-play-icon', $.proxy(function(e) {
			this.play(e);
		}, this));
	};

	/**
	 * Default options.
	 * @public
	 */
	Video.Defaults = {
		video: false,
		videoHeight: false,
		videoWidth: false
	};

	/**
	 * Gets the video ID and the type (YouTube/Vimeo/vzaar only).
	 * @protected
	 * @param {jQuery} target - The target containing the video data.
	 * @param {jQuery} item - The item containing the video.
	 */
	Video.prototype.fetch = function(target, item) {
			var type = (function() {
					if (target.attr('data-vimeo-id')) {
						return 'vimeo';
					} else if (target.attr('data-vzaar-id')) {
						return 'vzaar'
					} else {
						return 'youtube';
					}
				})(),
				id = target.attr('data-vimeo-id') || target.attr('data-youtube-id') || target.attr('data-vzaar-id'),
				width = target.attr('data-width') || this._core.settings.videoWidth,
				height = target.attr('data-height') || this._core.settings.videoHeight,
				url = target.attr('href');

		if (url) {

			/*
					Parses the id's out of the following urls (and probably more):
					https://www.youtube.com/watch?v=:id
					https://youtu.be/:id
					https://vimeo.com/:id
					https://vimeo.com/channels/:channel/:id
					https://vimeo.com/groups/:group/videos/:id
					https://app.vzaar.com/videos/:id

					Visual example: https://regexper.com/#(http%3A%7Chttps%3A%7C)%5C%2F%5C%2F(player.%7Cwww.%7Capp.)%3F(vimeo%5C.com%7Cyoutu(be%5C.com%7C%5C.be%7Cbe%5C.googleapis%5C.com)%7Cvzaar%5C.com)%5C%2F(video%5C%2F%7Cvideos%5C%2F%7Cembed%5C%2F%7Cchannels%5C%2F.%2B%5C%2F%7Cgroups%5C%2F.%2B%5C%2F%7Cwatch%5C%3Fv%3D%7Cv%5C%2F)%3F(%5BA-Za-z0-9._%25-%5D*)(%5C%26%5CS%2B)%3F
			*/

			id = url.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

			if (id[3].indexOf('youtu') > -1) {
				type = 'youtube';
			} else if (id[3].indexOf('vimeo') > -1) {
				type = 'vimeo';
			} else if (id[3].indexOf('vzaar') > -1) {
				type = 'vzaar';
			} else {
				throw new Error('Video URL not supported.');
			}
			id = id[6];
		} else {
			throw new Error('Missing video URL.');
		}

		this._videos[url] = {
			type: type,
			id: id,
			width: width,
			height: height
		};

		item.attr('data-video', url);

		this.thumbnail(target, this._videos[url]);
	};

	/**
	 * Creates video thumbnail.
	 * @protected
	 * @param {jQuery} target - The target containing the video data.
	 * @param {Object} info - The video info object.
	 * @see `fetch`
	 */
	Video.prototype.thumbnail = function(target, video) {
		var tnLink,
			icon,
			path,
			dimensions = video.width && video.height ? 'width:' + video.width + 'px;height:' + video.height + 'px;' : '',
			customTn = target.find('img'),
			srcType = 'src',
			lazyClass = '',
			settings = this._core.settings,
			create = function(path) {
				icon = '<div class="owl-video-play-icon"></div>';

				if (settings.lazyLoad) {
					tnLink = $('<div/>',{
						"class": 'owl-video-tn ' + lazyClass,
						"srcType": path
					});
				} else {
					tnLink = $( '<div/>', {
						"class": "owl-video-tn",
						"style": 'opacity:1;background-image:url(' + path + ')'
					});
				}
				target.after(tnLink);
				target.after(icon);
			};

		// wrap video content into owl-video-wrapper div
		target.wrap( $( '<div/>', {
			"class": "owl-video-wrapper",
			"style": dimensions
		}));

		if (this._core.settings.lazyLoad) {
			srcType = 'data-src';
			lazyClass = 'owl-lazy';
		}

		// custom thumbnail
		if (customTn.length) {
			create(customTn.attr(srcType));
			customTn.remove();
			return false;
		}

		if (video.type === 'youtube') {
			path = "//img.youtube.com/vi/" + video.id + "/hqdefault.jpg";
			create(path);
		} else if (video.type === 'vimeo') {
			$.ajax({
				type: 'GET',
				url: '//vimeo.com/api/v2/video/' + video.id + '.json',
				jsonp: 'callback',
				dataType: 'jsonp',
				success: function(data) {
					path = data[0].thumbnail_large;
					create(path);
				}
			});
		} else if (video.type === 'vzaar') {
			$.ajax({
				type: 'GET',
				url: '//vzaar.com/api/videos/' + video.id + '.json',
				jsonp: 'callback',
				dataType: 'jsonp',
				success: function(data) {
					path = data.framegrab_url;
					create(path);
				}
			});
		}
	};

	/**
	 * Stops the current video.
	 * @public
	 */
	Video.prototype.stop = function() {
		this._core.trigger('stop', null, 'video');
		this._playing.find('.owl-video-frame').remove();
		this._playing.removeClass('owl-video-playing');
		this._playing = null;
		this._core.leave('playing');
		this._core.trigger('stopped', null, 'video');
	};

	/**
	 * Starts the current video.
	 * @public
	 * @param {Event} event - The event arguments.
	 */
	Video.prototype.play = function(event) {
		var target = $(event.target),
			item = target.closest('.' + this._core.settings.itemClass),
			video = this._videos[item.attr('data-video')],
			width = video.width || '100%',
			height = video.height || this._core.$stage.height(),
			html,
			iframe;

		if (this._playing) {
			return;
		}

		this._core.enter('playing');
		this._core.trigger('play', null, 'video');

		item = this._core.items(this._core.relative(item.index()));

		this._core.reset(item.index());

		html = $( '<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>' );
		html.attr( 'height', height );
		html.attr( 'width', width );
		if (video.type === 'youtube') {
			html.attr( 'src', '//www.youtube.com/embed/' + video.id + '?autoplay=1&rel=0&v=' + video.id );
		} else if (video.type === 'vimeo') {
			html.attr( 'src', '//player.vimeo.com/video/' + video.id + '?autoplay=1' );
		} else if (video.type === 'vzaar') {
			html.attr( 'src', '//view.vzaar.com/' + video.id + '/player?autoplay=true' );
		}

		iframe = $(html).wrap( '<div class="owl-video-frame" />' ).insertAfter(item.find('.owl-video'));

		this._playing = item.addClass('owl-video-playing');
	};

	/**
	 * Checks whether an video is currently in full screen mode or not.
	 * @todo Bad style because looks like a readonly method but changes members.
	 * @protected
	 * @returns {Boolean}
	 */
	Video.prototype.isInFullScreen = function() {
		var element = document.fullscreenElement || document.mozFullScreenElement ||
				document.webkitFullscreenElement;

		return element && $(element).parent().hasClass('owl-video-frame');
	};

	/**
	 * Destroys the plugin.
	 */
	Video.prototype.destroy = function() {
		var handler, property;

		this._core.$element.off('click.owl.video');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Video = Video;

})(window.Zepto || window.jQuery, window, document);

/**
 * Animate Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the animate plugin.
	 * @class The Navigation Plugin
	 * @param {Owl} scope - The Owl Carousel
	 */
	var Animate = function(scope) {
		this.core = scope;
		this.core.options = $.extend({}, Animate.Defaults, this.core.options);
		this.swapping = true;
		this.previous = undefined;
		this.next = undefined;

		this.handlers = {
			'change.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.previous = this.core.current();
					this.next = e.property.value;
				}
			}, this),
			'drag.owl.carousel dragged.owl.carousel translated.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					this.swapping = e.type == 'translated';
				}
			}, this),
			'translate.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn)) {
					this.swap();
				}
			}, this)
		};

		this.core.$element.on(this.handlers);
	};

	/**
	 * Default options.
	 * @public
	 */
	Animate.Defaults = {
		animateOut: false,
		animateIn: false
	};

	/**
	 * Toggles the animation classes whenever an translations starts.
	 * @protected
	 * @returns {Boolean|undefined}
	 */
	Animate.prototype.swap = function() {

		if (this.core.settings.items !== 1) {
			return;
		}

		if (!$.support.animation || !$.support.transition) {
			return;
		}

		this.core.speed(0);

		var left,
			clear = $.proxy(this.clear, this),
			previous = this.core.$stage.children().eq(this.previous),
			next = this.core.$stage.children().eq(this.next),
			incoming = this.core.settings.animateIn,
			outgoing = this.core.settings.animateOut;

		if (this.core.current() === this.previous) {
			return;
		}

		if (outgoing) {
			left = this.core.coordinates(this.previous) - this.core.coordinates(this.next);
			previous.one($.support.animation.end, clear)
				.css( { 'left': left + 'px' } )
				.addClass('animated owl-animated-out')
				.addClass(outgoing);
		}

		if (incoming) {
			next.one($.support.animation.end, clear)
				.addClass('animated owl-animated-in')
				.addClass(incoming);
		}
	};

	Animate.prototype.clear = function(e) {
		$(e.target).css( { 'left': '' } )
			.removeClass('animated owl-animated-out owl-animated-in')
			.removeClass(this.core.settings.animateIn)
			.removeClass(this.core.settings.animateOut);
		this.core.onTransitionEnd();
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Animate.prototype.destroy = function() {
		var handler, property;

		for (handler in this.handlers) {
			this.core.$element.off(handler, this.handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Animate = Animate;

})(window.Zepto || window.jQuery, window, document);

/**
 * Autoplay Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author Artus Kolanowski
 * @author David Deutsch
 * @author Tom De Caluwé
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	/**
	 * Creates the autoplay plugin.
	 * @class The Autoplay Plugin
	 * @param {Owl} scope - The Owl Carousel
	 */
	var Autoplay = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * The autoplay timeout id.
		 * @type {Number}
		 */
		this._call = null;

		/**
		 * Depending on the state of the plugin, this variable contains either
		 * the start time of the timer or the current timer value if it's
		 * paused. Since we start in a paused state we initialize the timer
		 * value.
		 * @type {Number}
		 */
		this._time = 0;

		/**
		 * Stores the timeout currently used.
		 * @type {Number}
		 */
		this._timeout = 0;

		/**
		 * Indicates whenever the autoplay is paused.
		 * @type {Boolean}
		 */
		this._paused = true;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'settings') {
					if (this._core.settings.autoplay) {
						this.play();
					} else {
						this.stop();
					}
				} else if (e.namespace && e.property.name === 'position' && this._paused) {
					// Reset the timer. This code is triggered when the position
					// of the carousel was changed through user interaction.
					this._time = 0;
				}
			}, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.autoplay) {
					this.play();
				}
			}, this),
			'play.owl.autoplay': $.proxy(function(e, t, s) {
				if (e.namespace) {
					this.play(t, s);
				}
			}, this),
			'stop.owl.autoplay': $.proxy(function(e) {
				if (e.namespace) {
					this.stop();
				}
			}, this),
			'mouseover.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.pause();
				}
			}, this),
			'mouseleave.owl.autoplay': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.play();
				}
			}, this),
			'touchstart.owl.core': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {
					this.pause();
				}
			}, this),
			'touchend.owl.core': $.proxy(function() {
				if (this._core.settings.autoplayHoverPause) {
					this.play();
				}
			}, this)
		};

		// register event handlers
		this._core.$element.on(this._handlers);

		// set default options
		this._core.options = $.extend({}, Autoplay.Defaults, this._core.options);
	};

	/**
	 * Default options.
	 * @public
	 */
	Autoplay.Defaults = {
		autoplay: false,
		autoplayTimeout: 5000,
		autoplayHoverPause: false,
		autoplaySpeed: false
	};

	/**
	 * Transition to the next slide and set a timeout for the next transition.
	 * @private
	 * @param {Number} [speed] - The animation speed for the animations.
	 */
	Autoplay.prototype._next = function(speed) {
		this._call = window.setTimeout(
			$.proxy(this._next, this, speed),
			this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()
		);

		if (this._core.is('interacting') || document.hidden) {
			return;
		}
		this._core.next(speed || this._core.settings.autoplaySpeed);
	}

	/**
	 * Reads the current timer value when the timer is playing.
	 * @public
	 */
	Autoplay.prototype.read = function() {
		return new Date().getTime() - this._time;
	};

	/**
	 * Starts the autoplay.
	 * @public
	 * @param {Number} [timeout] - The interval before the next animation starts.
	 * @param {Number} [speed] - The animation speed for the animations.
	 */
	Autoplay.prototype.play = function(timeout, speed) {
		var elapsed;

		if (!this._core.is('rotating')) {
			this._core.enter('rotating');
		}

		timeout = timeout || this._core.settings.autoplayTimeout;

		// Calculate the elapsed time since the last transition. If the carousel
		// wasn't playing this calculation will yield zero.
		elapsed = Math.min(this._time % (this._timeout || timeout), timeout);

		if (this._paused) {
			// Start the clock.
			this._time = this.read();
			this._paused = false;
		} else {
			// Clear the active timeout to allow replacement.
			window.clearTimeout(this._call);
		}

		// Adjust the origin of the timer to match the new timeout value.
		this._time += this.read() % timeout - elapsed;

		this._timeout = timeout;
		this._call = window.setTimeout($.proxy(this._next, this, speed), timeout - elapsed);
	};

	/**
	 * Stops the autoplay.
	 * @public
	 */
	Autoplay.prototype.stop = function() {
		if (this._core.is('rotating')) {
			// Reset the clock.
			this._time = 0;
			this._paused = true;

			window.clearTimeout(this._call);
			this._core.leave('rotating');
		}
	};

	/**
	 * Pauses the autoplay.
	 * @public
	 */
	Autoplay.prototype.pause = function() {
		if (this._core.is('rotating') && !this._paused) {
			// Pause the clock.
			this._time = this.read();
			this._paused = true;

			window.clearTimeout(this._call);
		}
	};

	/**
	 * Destroys the plugin.
	 */
	Autoplay.prototype.destroy = function() {
		var handler, property;

		this.stop();

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.autoplay = Autoplay;

})(window.Zepto || window.jQuery, window, document);

/**
 * Navigation Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the navigation plugin.
	 * @class The Navigation Plugin
	 * @param {Owl} carousel - The Owl Carousel.
	 */
	var Navigation = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Indicates whether the plugin is initialized or not.
		 * @protected
		 * @type {Boolean}
		 */
		this._initialized = false;

		/**
		 * The current paging indexes.
		 * @protected
		 * @type {Array}
		 */
		this._pages = [];

		/**
		 * All DOM elements of the user interface.
		 * @protected
		 * @type {Object}
		 */
		this._controls = {};

		/**
		 * Markup for an indicator.
		 * @protected
		 * @type {Array.<String>}
		 */
		this._templates = [];

		/**
		 * The carousel element.
		 * @type {jQuery}
		 */
		this.$element = this._core.$element;

		/**
		 * Overridden methods of the carousel.
		 * @protected
		 * @type {Object}
		 */
		this._overrides = {
			next: this._core.next,
			prev: this._core.prev,
			to: this._core.to
		};

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.push('<div class="' + this._core.settings.dotClass + '">' +
						$(e.content).find('[data-dot]').addBack('[data-dot]').attr('data-dot') + '</div>');
				}
			}, this),
			'added.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 0, this._templates.pop());
				}
			}, this),
			'remove.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.dotsData) {
					this._templates.splice(e.position, 1);
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name == 'position') {
					this.draw();
				}
			}, this),
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && !this._initialized) {
					this._core.trigger('initialize', null, 'navigation');
					this.initialize();
					this.update();
					this.draw();
					this._initialized = true;
					this._core.trigger('initialized', null, 'navigation');
				}
			}, this),
			'refreshed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._initialized) {
					this._core.trigger('refresh', null, 'navigation');
					this.update();
					this.draw();
					this._core.trigger('refreshed', null, 'navigation');
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Navigation.Defaults, this._core.options);

		// register event handlers
		this.$element.on(this._handlers);
	};

	/**
	 * Default options.
	 * @public
	 * @todo Rename `slideBy` to `navBy`
	 */
	Navigation.Defaults = {
		nav: false,
		navText: [
			'<span aria-label="' + 'Previous' + '">&#x2039;</span>',
			'<span aria-label="' + 'Next' + '">&#x203a;</span>'
		],
		navSpeed: false,
		navElement: 'button type="button" role="presentation"',
		navContainer: false,
		navContainerClass: 'owl-nav',
		navClass: [
			'owl-prev',
			'owl-next'
		],
		slideBy: 1,
		dotClass: 'owl-dot',
		dotsClass: 'owl-dots',
		dots: true,
		dotsEach: false,
		dotsData: false,
		dotsSpeed: false,
		dotsContainer: false
	};

	/**
	 * Initializes the layout of the plugin and extends the carousel.
	 * @protected
	 */
	Navigation.prototype.initialize = function() {
		var override,
			settings = this._core.settings;

		// create DOM structure for relative navigation
		this._controls.$relative = (settings.navContainer ? $(settings.navContainer)
			: $('<div>').addClass(settings.navContainerClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$previous = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[0])
			.html(settings.navText[0])
			.prependTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.prev(settings.navSpeed);
			}, this));
		this._controls.$next = $('<' + settings.navElement + '>')
			.addClass(settings.navClass[1])
			.html(settings.navText[1])
			.appendTo(this._controls.$relative)
			.on('click', $.proxy(function(e) {
				this.next(settings.navSpeed);
			}, this));

		// create DOM structure for absolute navigation
		if (!settings.dotsData) {
			this._templates = [ $('<button role="button">')
				.addClass(settings.dotClass)
				.append($('<span>'))
				.prop('outerHTML') ];
		}

		this._controls.$absolute = (settings.dotsContainer ? $(settings.dotsContainer)
			: $('<div>').addClass(settings.dotsClass).appendTo(this.$element)).addClass('disabled');

		this._controls.$absolute.on('click', 'button', $.proxy(function(e) {
			var index = $(e.target).parent().is(this._controls.$absolute)
				? $(e.target).index() : $(e.target).parent().index();

			e.preventDefault();

			this.to(index, settings.dotsSpeed);
		}, this));

		/*$el.on('focusin', function() {
			$(document).off(".carousel");

			$(document).on('keydown.carousel', function(e) {
				if(e.keyCode == 37) {
					$el.trigger('prev.owl')
				}
				if(e.keyCode == 39) {
					$el.trigger('next.owl')
				}
			});
		});*/

		// override public methods of the carousel
		for (override in this._overrides) {
			this._core[override] = $.proxy(this[override], this);
		}
	};

	/**
	 * Destroys the plugin.
	 * @protected
	 */
	Navigation.prototype.destroy = function() {
		var handler, control, property, override, settings;
		settings = this._core.settings;

		for (handler in this._handlers) {
			this.$element.off(handler, this._handlers[handler]);
		}
		for (control in this._controls) {
			if (control === '$relative' && settings.navContainer) {
				this._controls[control].html('');
			} else {
				this._controls[control].remove();
			}
		}
		for (override in this.overides) {
			this._core[override] = this._overrides[override];
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	/**
	 * Updates the internal state.
	 * @protected
	 */
	Navigation.prototype.update = function() {
		var i, j, k,
			lower = this._core.clones().length / 2,
			upper = lower + this._core.items().length,
			maximum = this._core.maximum(true),
			settings = this._core.settings,
			size = settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items;

		if (settings.slideBy !== 'page') {
			settings.slideBy = Math.min(settings.slideBy, settings.items);
		}

		if (settings.dots || settings.slideBy == 'page') {
			this._pages = [];

			for (i = lower, j = 0, k = 0; i < upper; i++) {
				if (j >= size || j === 0) {
					this._pages.push({
						start: Math.min(maximum, i - lower),
						end: i - lower + size - 1
					});
					if (Math.min(maximum, i - lower) === maximum) {
						break;
					}
					j = 0, ++k;
				}
				j += this._core.mergers(this._core.relative(i));
			}
		}
	};

	/**
	 * Draws the user interface.
	 * @todo The option `dotsData` wont work.
	 * @protected
	 */
	Navigation.prototype.draw = function() {
		var difference,
			settings = this._core.settings,
			disabled = this._core.items().length <= settings.items,
			index = this._core.relative(this._core.current()),
			loop = settings.loop || settings.rewind;

		this._controls.$relative.toggleClass('disabled', !settings.nav || disabled);

		if (settings.nav) {
			this._controls.$previous.toggleClass('disabled', !loop && index <= this._core.minimum(true));
			this._controls.$next.toggleClass('disabled', !loop && index >= this._core.maximum(true));
		}

		this._controls.$absolute.toggleClass('disabled', !settings.dots || disabled);

		if (settings.dots) {
			difference = this._pages.length - this._controls.$absolute.children().length;

			if (settings.dotsData && difference !== 0) {
				this._controls.$absolute.html(this._templates.join(''));
			} else if (difference > 0) {
				this._controls.$absolute.append(new Array(difference + 1).join(this._templates[0]));
			} else if (difference < 0) {
				this._controls.$absolute.children().slice(difference).remove();
			}

			this._controls.$absolute.find('.active').removeClass('active');
			this._controls.$absolute.children().eq($.inArray(this.current(), this._pages)).addClass('active');
		}
	};

	/**
	 * Extends event data.
	 * @protected
	 * @param {Event} event - The event object which gets thrown.
	 */
	Navigation.prototype.onTrigger = function(event) {
		var settings = this._core.settings;

		event.page = {
			index: $.inArray(this.current(), this._pages),
			count: this._pages.length,
			size: settings && (settings.center || settings.autoWidth || settings.dotsData
				? 1 : settings.dotsEach || settings.items)
		};
	};

	/**
	 * Gets the current page position of the carousel.
	 * @protected
	 * @returns {Number}
	 */
	Navigation.prototype.current = function() {
		var current = this._core.relative(this._core.current());
		return $.grep(this._pages, $.proxy(function(page, index) {
			return page.start <= current && page.end >= current;
		}, this)).pop();
	};

	/**
	 * Gets the current succesor/predecessor position.
	 * @protected
	 * @returns {Number}
	 */
	Navigation.prototype.getPosition = function(successor) {
		var position, length,
			settings = this._core.settings;

		if (settings.slideBy == 'page') {
			position = $.inArray(this.current(), this._pages);
			length = this._pages.length;
			successor ? ++position : --position;
			position = this._pages[((position % length) + length) % length].start;
		} else {
			position = this._core.relative(this._core.current());
			length = this._core.items().length;
			successor ? position += settings.slideBy : position -= settings.slideBy;
		}

		return position;
	};

	/**
	 * Slides to the next item or page.
	 * @public
	 * @param {Number} [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.next = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(true), speed);
	};

	/**
	 * Slides to the previous item or page.
	 * @public
	 * @param {Number} [speed=false] - The time in milliseconds for the transition.
	 */
	Navigation.prototype.prev = function(speed) {
		$.proxy(this._overrides.to, this._core)(this.getPosition(false), speed);
	};

	/**
	 * Slides to the specified item or page.
	 * @public
	 * @param {Number} position - The position of the item or page.
	 * @param {Number} [speed] - The time in milliseconds for the transition.
	 * @param {Boolean} [standard=false] - Whether to use the standard behaviour or not.
	 */
	Navigation.prototype.to = function(position, speed, standard) {
		var length;

		if (!standard && this._pages.length) {
			length = this._pages.length;
			$.proxy(this._overrides.to, this._core)(this._pages[((position % length) + length) % length].start, speed);
		} else {
			$.proxy(this._overrides.to, this._core)(position, speed);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Navigation = Navigation;

})(window.Zepto || window.jQuery, window, document);

/**
 * Hash Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {
	'use strict';

	/**
	 * Creates the hash plugin.
	 * @class The Hash Plugin
	 * @param {Owl} carousel - The Owl Carousel
	 */
	var Hash = function(carousel) {
		/**
		 * Reference to the core.
		 * @protected
		 * @type {Owl}
		 */
		this._core = carousel;

		/**
		 * Hash index for the items.
		 * @protected
		 * @type {Object}
		 */
		this._hashes = {};

		/**
		 * The carousel element.
		 * @type {jQuery}
		 */
		this.$element = this._core.$element;

		/**
		 * All event handlers.
		 * @protected
		 * @type {Object}
		 */
		this._handlers = {
			'initialized.owl.carousel': $.proxy(function(e) {
				if (e.namespace && this._core.settings.startPosition === 'URLHash') {
					$(window).trigger('hashchange.owl.navigation');
				}
			}, this),
			'prepared.owl.carousel': $.proxy(function(e) {
				if (e.namespace) {
					var hash = $(e.content).find('[data-hash]').addBack('[data-hash]').attr('data-hash');

					if (!hash) {
						return;
					}

					this._hashes[hash] = e.content;
				}
			}, this),
			'changed.owl.carousel': $.proxy(function(e) {
				if (e.namespace && e.property.name === 'position') {
					var current = this._core.items(this._core.relative(this._core.current())),
						hash = $.map(this._hashes, function(item, hash) {
							return item === current ? hash : null;
						}).join();

					if (!hash || window.location.hash.slice(1) === hash) {
						return;
					}

					window.location.hash = hash;
				}
			}, this)
		};

		// set default options
		this._core.options = $.extend({}, Hash.Defaults, this._core.options);

		// register the event handlers
		this.$element.on(this._handlers);

		// register event listener for hash navigation
		$(window).on('hashchange.owl.navigation', $.proxy(function(e) {
			var hash = window.location.hash.substring(1),
				items = this._core.$stage.children(),
				position = this._hashes[hash] && items.index(this._hashes[hash]);

			if (position === undefined || position === this._core.current()) {
				return;
			}

			this._core.to(this._core.relative(position), false, true);
		}, this));
	};

	/**
	 * Default options.
	 * @public
	 */
	Hash.Defaults = {
		URLhashListener: false
	};

	/**
	 * Destroys the plugin.
	 * @public
	 */
	Hash.prototype.destroy = function() {
		var handler, property;

		$(window).off('hashchange.owl.navigation');

		for (handler in this._handlers) {
			this._core.$element.off(handler, this._handlers[handler]);
		}
		for (property in Object.getOwnPropertyNames(this)) {
			typeof this[property] != 'function' && (this[property] = null);
		}
	};

	$.fn.owlCarousel.Constructor.Plugins.Hash = Hash;

})(window.Zepto || window.jQuery, window, document);

/**
 * Support Plugin
 *
 * @version 2.3.4
 * @author Vivid Planet Software GmbH
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
;(function($, window, document, undefined) {

	var style = $('<support>').get(0).style,
		prefixes = 'Webkit Moz O ms'.split(' '),
		events = {
			transition: {
				end: {
					WebkitTransition: 'webkitTransitionEnd',
					MozTransition: 'transitionend',
					OTransition: 'oTransitionEnd',
					transition: 'transitionend'
				}
			},
			animation: {
				end: {
					WebkitAnimation: 'webkitAnimationEnd',
					MozAnimation: 'animationend',
					OAnimation: 'oAnimationEnd',
					animation: 'animationend'
				}
			}
		},
		tests = {
			csstransforms: function() {
				return !!test('transform');
			},
			csstransforms3d: function() {
				return !!test('perspective');
			},
			csstransitions: function() {
				return !!test('transition');
			},
			cssanimations: function() {
				return !!test('animation');
			}
		};

	function test(property, prefixed) {
		var result = false,
			upper = property.charAt(0).toUpperCase() + property.slice(1);

		$.each((property + ' ' + prefixes.join(upper + ' ') + upper).split(' '), function(i, property) {
			if (style[property] !== undefined) {
				result = prefixed ? property : true;
				return false;
			}
		});

		return result;
	}

	function prefixed(property) {
		return test(property, true);
	}

	if (tests.csstransitions()) {
		/* jshint -W053 */
		$.support.transition = new String(prefixed('transition'))
		$.support.transition.end = events.transition.end[ $.support.transition ];
	}

	if (tests.cssanimations()) {
		/* jshint -W053 */
		$.support.animation = new String(prefixed('animation'))
		$.support.animation.end = events.animation.end[ $.support.animation ];
	}

	if (tests.csstransforms()) {
		/* jshint -W053 */
		$.support.transform = new String(prefixed('transform'));
		$.support.transform3d = tests.csstransforms3d();
	}

})(window.Zepto || window.jQuery, window, document);
}
/* #Shortcodes scroller
================================================== */
// setting width for scroller articles
    $.fn.scrollerSlideSize = function() {

        return this.each(function() {
            var $this = $(this),
                $img = $this.find("img").eq(0),
                imgW = parseInt($img.attr("width")),
                $container = $this.parents(".slider-wrapper"),
                $containerWidth = $container.width(),
                $maxWidth = $container.attr("data-max-width"),
                sideSpace = parseInt($container.attr("data-padding-side"));



            var leftPadding = parseInt($img.parents(".wf-td").eq(0).css("paddingLeft")),
                rightPadding = parseInt($img.parents(".wf-td").eq(0).css("paddingRight")),
                addedW = 0;

            if (leftPadding > 0 && rightPadding > 0) addedW = leftPadding + rightPadding;


            //determine if max width has px or %
            if(typeof $maxWidth != "undefined"){
                var dataMaxWidth = ($containerWidth * parseFloat($maxWidth))/100 - addedW - sideSpace;
            }

            if(imgW > dataMaxWidth){
                var colmnW = dataMaxWidth;
            }else{
                var colmnW = parseInt($img.attr("width"));
                if (!$img.exists()) colmnW = 280;
            }


            $this.parents('.slider-wrapper').attr("data-width", colmnW + addedW);
            $this.css({
                width: colmnW + addedW
            });
        })
    }
    $(".slider-wrapper.description-under-image:not(.related-projects) article").scrollerSlideSize();

    //Scroller shortcode init

    var $sliderWrapper = $(".slider-wrapper.owl-carousel:not(.related-projects)");

    $sliderWrapper.each(function(){
        var $this = $(this),
            $colGap = $this.attr("data-padding-side") ? parseInt($this.attr("data-padding-side")) : 0,
            $autoPlay = ( 'true' === $this.attr("data-autoslide")) ? true : false,
            $autoPlayTimeout = $this.attr("data-delay") ? parseInt($this.attr("data-delay")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $desktopCol =  $this.attr("data-width") ? $sliderWrapper.width() / parseInt($this.attr("data-width")) : $sliderWrapper.width()/$sliderWrapper.find('article img').attr('width'),
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-018-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-018-l',
            interceptClicksTimer;

        if($this.attr("data-width")) {
            $desktopCol =  $sliderWrapper.width() / parseInt($this.attr("data-width")) ;
        }else if ($this.attr("data-max-width")) {

            $desktopCol =   $sliderWrapper.width() / parseInt($this.attr("data-max-width"));
        }else {
            $desktopCol =   $sliderWrapper.width()/$sliderWrapper.find('article img').attr('width');
        }

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopCol,
            autoHeight: false,
            margin:$colGap,
            loadedClass: 'owl-loaded',
            slideBy: 'page',
            loop:false,
            smartSpeed: 600,
            merge:true,
            autoWidth:true,
            // onInitialized: callback,
            responsive:{
                678:{
                    mergeFit:true
                },
                1000:{
                    mergeFit:false
                }
            },
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
            nav: $enableArrows,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '"></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: false,
            onInitialize: callbackHeight,
            onInitialized: callback,
            onRefreshed: callback
        }).trigger('refresh.owl.carousel');
        function callbackHeight(event) {
            var $maxWidth = parseInt($this.attr("data-max-width")),
                dataMaxWidth = ($sliderWrapper.width() * parseFloat($maxWidth))/100 - $colGap,
                imgW = parseInt($this.find('img').attr('width')),
                imgH = parseInt($this.find('img').attr('height'));
            if($maxWidth && dataMaxWidth < imgW) {
                $this.find('article').css({
                    'max-width': dataMaxWidth + 'px'
                });
                $this.find('img').css({
                    'max-width': dataMaxWidth + 'px',
                    height: dataMaxWidth * imgH / imgW
                });
            }
        }
        function callback(event) {
            var $stage = $this.find('.owl-stage'),
                stageW = $stage.width(),
                $el = $this.find('.dt-owl-item'),
                elW = 0;
            elW = ($el.width()+ parseInt($el.css("margin-right"))) * event.item.count
            if ( elW > stageW ) {
                $stage.width( elW );
            };
        }

        //add class for preventing click while dragging
        $this.on('drag.owl.carousel translate.owl.carousel', function(event) {
            $this.addClass('ts-interceptClicks');
        })
        $this.on('dragged.owl.carousel translated.owl.carousel', function(event) {
            clearTimeout( interceptClicksTimer );
            interceptClicksTimer = setTimeout(function(){
                $this.removeClass('ts-interceptClicks');
            }, 400)
        });


        $this.on('changed.owl.carousel', function(event) {
            if($(".dt-owl-item.cloned .is-loaded", $this ).parents().hasClass("layzr-bg")){
                $(".dt-owl-item.cloned .is-loaded", $this ).parents().removeClass("layzr-bg");
            }
            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();
            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();
        })

        //Stop autoplay on hover
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        });
        //run autoplay on mouseleave
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        });
        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })


        //show hide arrows on hover
        $this.on("mouseenter", function(e) {
            $this.addClass("show-arrows");
        });
        $this.on("mouseleave", function(e) {
            $this.removeClass("show-arrows");
        });

    });


    //Slideshow
    $.fn.postTypeScroller = function() {

        var $this = $(this),
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-018-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-018-l',
            paddings = $this.attr("data-padding-side") ? parseInt($this.attr("data-padding-side")) : 0,
            $sliderAutoslideEnable = ( 'true' != $this.attr("data-paused") && typeof $this.attr("data-autoslide") != "undefined" ) ? true : false,
            $sliderAutoslide = ( 'true' === $this.attr("data-paused") ) ? false : true,
            $sliderAutoslideDelay = $this.attr("data-autoslide") && parseInt($this.attr("data-autoslide")) > 999 ? parseInt($this.attr("data-autoslide")) : 5000,
            $sliderLoop = (  typeof $this.attr("data-autoslide") != "undefined" ) ? true : false,
            $sliderWidth = $this.attr("data-width") ? parseInt($this.attr("data-width")) : 800,
            $sliderHight = $this.attr("data-height") ? parseInt($this.attr("data-height")) : 400,
            imgMode = $this.attr("data-img-mode") ? $this.attr("data-img-mode") : "fill";

        $this.owlCarousel({
            rtl: $enableRtl,
            items: 1,
            autoHeight: false,
            center: false,
            margin:0,
            loadedClass: 'owl-loaded',
            slideBy: 1,
            loop:true,
            smartSpeed: 600,
            autoplay: $sliderAutoslideEnable,
            autoplayTimeout: $sliderAutoslideDelay,
            //autoplayHoverPause:true,
            nav: true,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '"></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: false
        });
        $window.on("debouncedresize", function() {

            $this.find('.dt-owl-item').each(function(i) {

                var $slide = $(this),
                    tempCSS = {};
                var img = $slide.find("img");
                img.css({
                    'opacity': 0
                })

                if(!img) {
                    return false;
                }
                var ratioS = 1;
                ratioS = $sliderHight < $sliderWidth ? $sliderHight/$sliderWidth : $sliderHight/$sliderWidth;
                if(imgMode == "fit"){
                    $slide.css({
                        height: ratioS * $slide.width()
                    });
                }else{
                    $slide.css({
                        height: ratioS * $this.width()
                    });
                }
                var baseImageWidth = parseInt(img.attr("width")),
                    baseImageHeight = parseInt(img.attr("height"));

                var containerWidth = $slide.width(),
                    containerHeight = ratioS *  $slide.width(),
                    hRatio,
                    vRatio,
                    ratio,
                    nWidth,
                    nHeight,
                    cssObj = {};
                hRatio = containerWidth / baseImageWidth;
                vRatio = containerHeight / baseImageHeight;

                if ($this.attr("data-img-mode")  == "fill") {
                    ratio = hRatio > vRatio ? hRatio : vRatio;
                } else if ($this.attr("data-img-mode")  == "fit") {
                    ratio = hRatio < vRatio ? hRatio : vRatio;
                } else {
                    ratio = hRatio > vRatio ? hRatio : vRatio;
                }

                nWidth = Math.ceil(baseImageWidth * ratio, 10);
                nHeight = Math.ceil(baseImageHeight * ratio, 10);
                cssObj.width = nWidth;
                cssObj.height = nHeight;
                cssObj.opacity = 1;
                //}
                img.css(cssObj);
            });

        });

        if(typeof $this.attr("data-autoslide") != "undefined"){
            $('<div class="psPlay"></div>').appendTo($this);
        }

        if( 'true' === $this.attr("data-paused") ){
            $(".psPlay", $this).addClass("paused");
            $this.trigger('stop.owl.autoplay');
        };
        $(".psPlay", $this).on("click", function(e){
            e.preventDefault();
            var $this = $(this);
            if( $this.hasClass("paused")){
                $this.removeClass("paused");
                $sliderAutoslideEnable = true;
                $this.trigger('play.owl.autoplay',[$sliderAutoslideDelay, 600])
            }else{
                $this.addClass("paused");
                $this.trigger('stop.owl.autoplay');
            }
        });
    };
    $(".slider-simple:not(.slider-masonry)").each(function(){
        $(this).postTypeScroller();
    });

    //Widgets
    var $widgetSlider = $("#main .slider-content, #footer .slider-content, .side-header:not(.sub-downwards) .mega-full-width > .dt-mega-menu-wrap  .slider-content, .side-header:not(.sub-downwards) .mega-auto-width > .dt-mega-menu-wrap  .slider-content");
    $.fn.widgetScroller = function() {
        return this.each(function() {
            var $this = $(this),
                $autoPlay = ( typeof $this.attr("data-autoslide") != 'undefined') ? true : false,
                $autoPlayTimeout = $this.attr("data-autoslide") ? parseInt($this.attr("data-autoslide")) : 6000,
                $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false;

            $this.owlCarousel({
                rtl: $enableRtl,
                items: 1,
                autoHeight: true,
                margin: 0,
                loadedClass: 'owl-loaded',
                slideBy: 'page',
                //loop:true,
                loop:($this.children().length > 1) ? true : false,
                smartSpeed: 600,
                autoplay: $autoPlay,
                autoplayTimeout: $autoPlayTimeout,
                autoplayHoverPause: false,
                nav: false,
                dots: true,
                dotsEach:true
            });
        })
    }

    //$widgetSlider.each(function(){
    $widgetSlider.widgetScroller().css("visibility", "visible");
    //Carousels

    var sliders = [], timer;

    $.fn.the7OwlCarousel = function(){
        var $this = $(this);

        if ( ! $this.length ) {
            return;
        }

        var $slideAll,
            $colGap = $this.attr("data-col-gap") ? parseInt($this.attr("data-col-gap")) : 0,
            $autoHeight = ( 'true' === $this.attr("data-auto-height")) ? true : false,
            $animSpeed =  $this.attr("data-speed") ? parseInt($this.attr("data-speed")) : 600,
            $autoPlay = ( 'true' === $this.attr("data-autoplay")) ? true : false,
            $autoPlayTimeout = $this.attr("data-autoplay_speed") ? parseInt($this.attr("data-autoplay_speed")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $enableDots = ( 'true' === $this.attr("data-bullet")) ? true : false,
            $desktopWideCol =  $this.attr("data-wide-col-num") ? parseInt($this.attr("data-wide-col-num")) : 3,
            $desktopCol =  $this.attr("data-col-num") ? parseInt($this.attr("data-col-num")) : 3,
            $laptopCol =  $this.attr("data-laptop-col") ? parseInt($this.attr("data-laptop-col")) : 3,
            $hTabletCol =  $this.attr("data-h-tablet-columns-num") ? parseInt($this.attr("data-h-tablet-columns-num")) : 3,
            $vTabletCol =  $this.attr("data-v-tablet-columns-num") ? parseInt($this.attr("data-v-tablet-columns-num")) : 2,
            $phoneCol =  $this.attr("data-phone-columns-num") ? parseInt($this.attr("data-phone-columns-num")) : 1,
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $slideBy =  ('1' == $this.attr("data-scroll-mode")) ? parseInt($this.attr("data-scroll-mode")) : 'page',
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-002-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-001-l',
            $dotsEach = ('1' == $this.attr("data-scroll-mode") && $enableDots) ? true : false,
            reloadAnimTimer,
            reloadLayzTimer,
            refreshCarousTimer;
        if(typeof $this.attr("data-stage-padding") != 'undefined'){
            var $stagePadding = $this.hasClass('enable-img-shadow') ? parseInt($this.attr("data-stage-padding")) + parseInt($this.attr("data-col-gap"))/2 : parseInt($this.attr("data-stage-padding"));
        }else{
            var $stagePadding = 0;
        }

        if($this.attr("data-col-gap")){
            $colGap = parseInt($this.attr("data-col-gap"));
        }else if($this.attr("data-padding-side")){
            $colGap = parseInt($this.attr("data-padding-side"));
        }else{
            $colGap = 0;
        }

        $this.on('initialize.owl.carousel', function(event) {
            $($this[0]).find('script, style').each(function(){
                var $wrapTag = $(this),
                    $wrapTagSibling = $wrapTag.siblings().first();
                if($($wrapTag).prev().length > 0) {
                    $($wrapTag).prev().addBack().wrapAll("<div class='carousel-item-wrap' />");
                }else if($($wrapTag).next().length > 0) {
                    $($wrapTag).next().addBack().wrapAll("<div class='carousel-item-wrap' />")
                }
            })

            layzrCarouselInitialisation();
        })
        /*$this.on('refreshed.owl.carousel', function(event) {
            $(".layzr-loading-on .cloned  .vc_single_image-img").layzrInitialisation();
        })*/

        var switchPoints = {};
        if ($(this).hasClass('products-carousel-shortcode') && $this.parent('.elementor-widget-container').length && elementorFrontendConfig){ // only elementor product widget
            switchPoints[0] = {
                items:$phoneCol,
                loop:($this.children().length > $phoneCol) ? true : false,
                stagePadding: 0,
            };
            switchPoints[elementorFrontendConfig.breakpoints.md] = {
                loop:($this.children().length > $hTabletCol) ? true : false,
                items:$hTabletCol,
                stagePadding: 0,
            };
            switchPoints[elementorFrontendConfig.breakpoints.lg] = {
                loop:($this.children().length > $desktopCol) ? true : false,
                items:$desktopCol
            };
        }
        else{
            switchPoints = {
                0:{
                    items:$phoneCol,
                    loop:($this.children().length > $phoneCol) ? true : false,
                    stagePadding: 0,
                },
                481:{
                    loop:($this.children().length > $vTabletCol) ? true : false,
                    items:$vTabletCol,
                    stagePadding: 0,
                },
                769:{
                    loop:($this.children().length > $hTabletCol) ? true : false,
                    items:$hTabletCol,
                    stagePadding: 0,
                },
                992:{
                    loop:($this.children().length > $laptopCol) ? true : false,
                    items:$laptopCol
                },
                1199:{
                    loop:($this.children().length > $desktopCol) ? true : false,
                    items:$desktopCol
                },
                1450:{
                    loop:($this.children().length > $desktopWideCol) ? true : false,
                    items:$desktopWideCol
                }
            };
        }

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopWideCol,
            autoHeight: $autoHeight,
            margin:$colGap,
            stagePadding: $stagePadding,
            loadedClass: 'owl-loaded',
            slideBy: $slideBy,
            loop:true,
            smartSpeed: $animSpeed,
            responsive: switchPoints,
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
            nav: $enableArrows,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '" ></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: $enableDots,
            dotsEach:$dotsEach
        });
        //Blog: layout text on image
        if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
            $this.find(".post-entry-wrapper").clickOverlayGradient();
        }

        addOnloadEvent(function(){
            if(!$this.hasClass("refreshed")){
                $this.addClass("refreshed");
                $this.trigger("refresh.owl.carousel");
            }

            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
            clearTimeout( reloadAnimTimer );
            reloadAnimTimer = setTimeout(function(){
                $(".dt-owl-item.cloned .animate-element.animation-triggered:not(.start-animation)").addClass("start-animation");
            },50);
           
            if(!dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('stop.owl.autoplay');
            }else if(dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
	        

        });
        $this.on('changed.owl.carousel', function(event) {

            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();

            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();

            var $owlItemThumbnalWrap = $(" .dt-owl-item.cloned .post-thumbnail-wrap", $this);
            if ($this.hasClass("albums-shortcode")){
                if(($this.hasClass("gradient-overlay-layout-list") || $this.hasClass("content-rollover-layout-list"))){
                    if ( $.isFunction($.fn.triggerClonedOverlayAlbumsClick) ) {
                        $(" .dt-owl-item.cloned .post-entry-content", $this).triggerClonedOverlayAlbumsClick();
                    }
                }
                else{
                    if ( $.isFunction($.fn.triggerClonedAlbumsClick) ) {
                        $owlItemThumbnalWrap.triggerClonedAlbumsClick();
                    }
                }
            }
            if($this.hasClass("gallery-shortcode")) {

                $($this).initCarouselClonedPhotoswipe();
            }

        })
        $this.on('change.owl.carousel', function(event) {
            clearTimeout( reloadLayzTimer );
            reloadLayzTimer = setTimeout(function(){
                $this.find(".dt-owl-item.active").layzrCarouselUpdate();
                $('.dt-owl-item.cloned .lazy-load', $this).parent().removeClass('layzr-bg');
            },20);
        });
        $this.on('resized.owl.carousel', function(event) {
            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
        })
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })

        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })
    };

    $('.dt-owl-carousel-call, .related-projects').each(function() {
        $(this).the7OwlCarousel();
    });

    var dtResizeTimeout;
    if(dtGlobals.isMobile && !dtGlobals.isWindowsPhone && !dtGlobals.isAndroid){
        $window.bind("orientationchange", function(event) {
            clearTimeout(dtResizeTimeout);
            dtResizeTimeout = setTimeout(function() {
                $('.dt-owl-carousel-call, .related-projects').trigger('refresh.owl.carousel');
                 $(".slider-simple:not(.slider-masonry)").trigger('refresh.owl.carousel');

            }, 200);
        });
    }


    //Elementor's carousel
    $.fn.the7ElementorOwlCarousel = function(){
        var $this = $(this);

        if ( ! $this.length ) {
            return;
        }
        //console.log(elementorFrontendConfig[environmentMode])

        var $slideAll,
            $colGap = $this.attr("data-col-gap") ? parseInt($this.attr("data-col-gap")) : 0,
            $autoHeight = ( 'true' === $this.attr("data-auto-height")) ? true : false,
            $animSpeed =  $this.attr("data-speed") ? parseInt($this.attr("data-speed")) : 600,
            $autoPlay = ( 'true' === $this.attr("data-autoplay")) ? true : false,
            $autoPlayTimeout = $this.attr("data-autoplay_speed") ? parseInt($this.attr("data-autoplay_speed")) : 6000,
            $enableArrows = ( 'true' === $this.attr("data-arrows")) ? true : false,
            $enableTabletArrows = ( 'true' === $this.attr("data-arrows_tablet")) ? true : false,
            $enableMobileArrows = ( 'true' === $this.attr("data-arrows_mobile")) ? true : false,
            $enableDots = ( 'true' === $this.attr("data-bullet")) ? true : false,
            $enableTabletDots = ( 'true' === $this.attr("data-bullet_tablet")) ? true : false,
            $enableMobileDots = ( 'true' === $this.attr("data-bullet_mobile")) ? true : false,
           $switchPointsMobile = (typeof elementorFrontendConfig.breakpoints.md != 'undefined') ? elementorFrontendConfig.breakpoints.md : 481,
            $switchPointsTablet = (typeof elementorFrontendConfig.breakpoints.lg != 'undefined') ? elementorFrontendConfig.breakpoints.lg : 769,
            $desktopWideCol =  $this.attr("data-wide-col-num") ? parseInt($this.attr("data-wide-col-num")) : 3,
            $desktopCol =  $this.attr("data-col-num") ? parseInt($this.attr("data-col-num")) : 3,
            $laptopCol =  $this.attr("data-laptop-col") ? parseInt($this.attr("data-laptop-col")) : 3,
            $hTabletCol =  $this.attr("data-h-tablet-columns-num") ? parseInt($this.attr("data-h-tablet-columns-num")) : 3,
            $vTabletCol =  $this.attr("data-v-tablet-columns-num") ? parseInt($this.attr("data-v-tablet-columns-num")) : 2,
            $phoneCol =  $this.attr("data-phone-columns-num") ? parseInt($this.attr("data-phone-columns-num")) : 1,
            $enableRtl = ( "rtl" == jQuery(document).attr( "dir" ) ) ? true : false,
            $slideBy =  ('1' == $this.attr("data-scroll-mode")) ? parseInt($this.attr("data-scroll-mode")) : 'page',
            $nextIcon = $this.attr("data-next-icon") ? $this.attr("data-next-icon") : 'icon-ar-002-r',
            $prevIcon = $this.attr("data-prev-icon") ? $this.attr("data-prev-icon") : 'icon-ar-001-l',
            $dotsEach = ('1' == $this.attr("data-scroll-mode") && $enableDots) ? true : false,
            reloadAnimTimer,
            reloadLayzTimer,
            refreshCarousTimer;
        if(typeof $this.attr("data-stage-padding") != 'undefined'){
            var $stagePadding = $this.hasClass('enable-img-shadow') ? parseInt($this.attr("data-stage-padding")) + parseInt($this.attr("data-col-gap"))/2 : parseInt($this.attr("data-stage-padding"));
        }else{
            var $stagePadding = 0;
        }

        if(typeof $this.attr("data-arrows_tablet") === 'undefined'){
            $enableTabletArrows = $enableArrows;
        }
        if(typeof $this.attr("data-arrows_mobile") === 'undefined'){
            $enableMobileArrows = $enableArrows;
        }

        if($this.attr("data-col-gap")){
            $colGap = parseInt($this.attr("data-col-gap"));
        }else if($this.attr("data-padding-side")){
            $colGap = parseInt($this.attr("data-padding-side"));
        }else{
            $colGap = 0;
        }

        $this.on('initialize.owl.carousel', function(event) {
            $($this[0]).find('script, style').each(function(){
                var $wrapTag = $(this),
                    $wrapTagSibling = $wrapTag.siblings().first();
                if($($wrapTag).prev().length > 0) {
                    $($wrapTag).prev().addBack().wrapAll("<div class='carousel-item-wrap' />");
                }else if($($wrapTag).next().length > 0) {
                    $($wrapTag).next().addBack().wrapAll("<div class='carousel-item-wrap' />")
                }
            })

            layzrCarouselInitialisation();
        })
        var switchPoints = {};
        switchPoints[0] = {
            items:$phoneCol,
            loop:($this.children().length > $phoneCol) ? true : false,
            stagePadding: 0,
            nav: $enableMobileArrows,
            dots: $enableMobileDots,
        };
        switchPoints[$switchPointsMobile] = {
            loop:($this.children().length > $hTabletCol) ? true : false,
            items:$hTabletCol,
            stagePadding: 0,
            nav: $enableTabletArrows,
            dots: $enableTabletDots,
        };
        switchPoints[$switchPointsTablet] = {
            loop:($this.children().length > $desktopCol) ? true : false,
            items:$desktopCol,
            nav: $enableArrows,
            dots: $enableDots,
        };
        switchPoints[1450] = {
            loop:($this.children().length > $desktopWideCol) ? true : false,
            items:$desktopWideCol,
            nav: $enableArrows,
            dots: $enableDots,
        };

        $this.owlCarousel({
            rtl: $enableRtl,
            items: $desktopWideCol,
            autoHeight: $autoHeight,
            margin:$colGap,
            stagePadding: $stagePadding,
            loadedClass: 'owl-loaded',
            slideBy: $slideBy,
            loop:true,
            smartSpeed: $animSpeed,
            autoplay: $autoPlay,
            autoplayTimeout: $autoPlayTimeout,
            //autoplayHoverPause: true,
           // nav: $enableArrows,
            responsive: switchPoints,
            navElement: "a",
            navText: ['<i class="' + $prevIcon + '" ></i>', '<i class="'+ $nextIcon +'"></i>'],
            dots: $enableDots,
            dotsEach:$dotsEach
        });
        //Blog: layout text on image
        if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
            $this.find(".post-entry-wrapper").clickOverlayGradient();
        }

        addOnloadEvent(function(){
            if(!$this.hasClass("refreshed")){
                $this.addClass("refreshed");
                $this.trigger("refresh.owl.carousel");
            }

            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
            clearTimeout( reloadAnimTimer );
            reloadAnimTimer = setTimeout(function(){
                $(".dt-owl-item.cloned .animate-element.animation-triggered:not(.start-animation)").addClass("start-animation");
            },50);
           
            if(!dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('stop.owl.autoplay');
            }else if(dtGlobals.isInViewport($this) && $autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
            

        });
        $this.on('changed.owl.carousel', function(event) {

            $('.dt-owl-item.cloned .photoswipe-wrapper, .dt-owl-item.cloned .photoswipe-item .dt-gallery-container', $this).initPhotoswipe();

            $(".animate-element:not(.start-animation):in-viewport", $this).checkInViewport();

            var $owlItemThumbnalWrap = $(" .dt-owl-item.cloned .post-thumbnail-wrap", $this);
            if ($this.hasClass("albums-shortcode")){
                if(($this.hasClass("gradient-overlay-layout-list") || $this.hasClass("content-rollover-layout-list"))){
                    if ( $.isFunction($.fn.triggerClonedOverlayAlbumsClick) ) {
                        $(" .dt-owl-item.cloned .post-entry-content", $this).triggerClonedOverlayAlbumsClick();
                    }
                }
                else{
                    if ( $.isFunction($.fn.triggerClonedAlbumsClick) ) {
                        $owlItemThumbnalWrap.triggerClonedAlbumsClick();
                    }
                }
            }
            if($this.hasClass("gallery-shortcode")) {

                $($this).initCarouselClonedPhotoswipe();
            }

        })
        $this.on('change.owl.carousel', function(event) {
            clearTimeout( reloadLayzTimer );
            reloadLayzTimer = setTimeout(function(){
                $this.find(".dt-owl-item.active").layzrCarouselUpdate();
                $('.dt-owl-item.cloned .lazy-load', $this).parent().removeClass('layzr-bg');
            },20);
        });
        $this.on('resized.owl.carousel', function(event) {
            if($this.hasClass("content-rollover-layout-list") && ! $this.hasClass("disable-layout-hover")){
                $this.find(".post-entry-wrapper").clickOverlayGradient();
            }
        })
        $this.find('.dt-owl-item').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.dt-owl-item').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })

        $this.find('.owl-nav a').on('mouseenter',function(e){
            if($autoPlay){
                $this.trigger('stop.owl.autoplay');
            }
        })
        $this.find('.owl-nav a').on('mouseleave',function(e){
            if($autoPlay){
                $this.trigger('play.owl.autoplay',[$autoPlayTimeout]);
            }
        })
    };
     $('.elementor-owl-carousel-call').each(function() {
        $(this).the7ElementorOwlCarousel();
    });

/* #Header
================================================== */

	var $topBar = $(".top-bar"),
		$mastheadHeader = $(".masthead"),
		$overlayHeader = $(".overlay-navigation"),
		$stickyHeader = $(".sticky-header"),
		stickyTopLine = $(".sticky-top-line"),
		$mainSlider = $("#main-slideshow, .photo-scroller"),
		$leftHeader = $(".header-side-left").length > 0,
		$rightHeader = $(".header-side-right").length > 0,
		$main = $("#main, #main-slideshow, .photo-scroller, .page-title, .fancy-header, .footer"),
		$topHeader = $(".floating-logo.side-header-menu-icon .branding, .side-header-h-stroke, #phantom"),
		$sideHeader = $(".side-header"),
		$onePage = $(".page-template-template-microsite").length > 0,
		dtScrollTimeout,
		bodyTransparent = $body.hasClass("transparent"),
		headerBelowSliderExists = $(".floating-navigation-below-slider").exists();
		if($(".side-header-v-stroke").length > 0){			
			var $sideHeaderW = $sideHeader.width() - $(".side-header-v-stroke").width(),
				$delay = 200;
		}else{
			var $sideHeaderW = $sideHeader.width(),
				$delay = 0;
		}

	$.closeSideHeader = function(){
		$page.removeClass("show-header");
		$page.addClass("closed-header");
		$(".sticky-header-overlay").removeClass("active");
		
	}
	$.closeMobileHeader = function(){
		$page.removeClass("show-mobile-header");
		$page.addClass("closed-mobile-header");
		$body.removeClass("show-sticky-mobile-header show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
		$(".mobile-sticky-header-overlay, .dt-mobile-menu-icon, .menu-toggle, .menu-close-toggle").removeClass("active");
		
	}


	/*!-Show Hide side header*/
	if($stickyHeader.length > 0 || $overlayHeader.length > 0 ) {
		$('<div class="lines-button x"><span class="menu-line"></span><span class="menu-line"></span><span class="menu-line"></span></div>').appendTo(".menu-toggle");
		var ToggleCaptionOn = dtLocal.themeSettings.ToggleCaptionEnabled;
		if(ToggleCaptionOn != "disabled"){
			ToggleCaption = "<span class='menu-toggle-caption'>" + dtLocal.themeSettings.ToggleCaption + "</span>";
		}else{
			ToggleCaption='';
		}
		if($stickyHeader.length > 0) {
			$body.append('<div class="sticky-header-overlay"></div>');
		};
		/*hiding side header*/

		var $hamburger = $(".menu-toggle"),
			$hamburgerClose = $(".menu-close-toggle"),
			$menuToggle = $(".menu-toggle:not(.active), .menu-close-toggle:not(.active)"),
			$overlay = $(".sticky-header-overlay");

		$hamburger.on("click", function (){
			if(!$(".header-under-side-line").length > 0){
				var $this = $(".side-header .menu-toggle");
			}else{
				var $this = $(".menu-toggle");
			}
			if ($this.hasClass("active")){
				$this.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
				$(".hide-overlay").removeClass("active");
			}
			else{
				$menuToggle.removeClass("active");
				$this.addClass('active').css({left:"",right:""});
				$page.addClass("show-header").removeClass("closed-header");
				$hamburgerClose.addClass("active");
				$overlay.addClass("active");
				$(".hide-overlay").addClass("active");
				
			};
		});
		$hamburgerClose.on("click", function (){
			// if(!$(".header-under-side-line").length > 0){
			// 	var $this = $(".side-header .menu-close-toggle");
			// }else{
				var $this = $(this);
			//}
			if ($this.hasClass("active")){
				$this.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
				$(".hide-overlay").removeClass("active");
			}
			else{
			 	$menuToggle.removeClass("active");
			 	$this.addClass('active').css({left:"",right:""});
			 	$page.addClass("show-header").removeClass("closed-header");
				
			 	$overlay.addClass("active");
			 	$(".hide-overlay").addClass("active");
				
			 };
		});
		$overlay.on("click", function (){
			if($(this).hasClass("active")){
				$menuToggle.removeClass("active");
				$page.removeClass("show-header").addClass("closed-header");
				$overlay.removeClass("active");
			}
		});
		$(".hide-overlay").on("click", function (){
			if($(this).hasClass("active")){
				$menuToggle.removeClass("active");
				$page.removeClass("show-header");
				$page.addClass("closed-header");
				$overlay.removeClass("active");
				
			}
		});
	};

	/* !- Right-side header + boxed layout */
	function ofX() {

		var $windowW = $window.width(),
			$boxedHeaderPos = ($windowW - $page.innerWidth())/2,
			$sideHeaderToggleExist = $(".side-header-menu-icon").length > 0;

		if(($windowW - $page.innerWidth())/2 > 0){
			var $boxedHeaderPos = ($windowW - $page.innerWidth())/2;
		}else {
			var $boxedHeaderPos = "";
		}

		if ($body.hasClass("header-side-right") && $page.hasClass("boxed")) {
			if(!$stickyHeader.length > 0){
				$sideHeader.css({
					right: $boxedHeaderPos
				});
			};
		}
		if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
			$mastheadHeader.insertAfter($mainSlider);
			var $mastheadHeaderStyle = $mastheadHeader.attr("style");
			$mastheadHeader.not('.sticky-on').attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
		}
		if($(".floating-menu-icon-right").length > 0 && $page.hasClass("boxed")){
			$menuToggle.css({
				right: $boxedHeaderPos
			});
			$(".branding").css({
				left: $boxedHeaderPos
			});
		}
	
		if ($page.hasClass("boxed")) {
			
			if($sideHeaderToggleExist && !$(".floating-menu-icon-right").length > 0){
				
				$(".floating-logo .branding").css({
					right: $boxedHeaderPos
				});
				$menuToggle.css({
					left: $boxedHeaderPos
				});
			}
		};
		if($overlayHeader.length > 0 && $sideHeaderToggleExist  && $page.hasClass("boxed")){
			$menuToggle.css({
				right: $boxedHeaderPos
			});
			$(".floating-logo .branding").css({
				left: $boxedHeaderPos
			});

		};
	};

	ofX();
	$window.on("resize", function() {
		ofX();
	});
	
		if(headerBelowSliderExists && $body.hasClass("footer-overlap")){
			$mastheadHeader.insertAfter($mainSlider)
		}
		if(!!navigator.userAgent.match(/Trident.*rv\:11\./) && headerBelowSliderExists && bodyTransparent){
			$mastheadHeader.insertAfter($mainSlider);
			var $mastheadHeaderStyle = $mastheadHeader.attr("style")
			$mastheadHeader.attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
		}

	/*Default scroll for mobile*/
	if($(".mixed-header").length > 0){
		var $activeHeader = $(".mixed-header");
	}else{
		var $activeHeader = $mastheadHeader;
	}

	/*Side header scrollbar for desctop*/
	$(".side-header .header-bar").wrap("<div class='header-scrollbar-wrap'></div>");
	if($sideHeader.length > 0 && !dtGlobals.isMobile){
		$(".header-scrollbar-wrap").mCustomScrollbar({
			scrollInertia:150,
			callbacks:{
		        whileScrolling:function(){
					$(".header-scrollbar-wrap").layzrInitialisation();
		        }
		    }
		});
		$(".sub-downwards .main-nav").find('.slider-content').widgetScroller().css("visibility", "visible");

	};
	if($sideHeader.length > 0){
		if(!$(".mCSB_container").length > 0){
			$(".side-header .header-scrollbar-wrap .header-bar").wrap("<div class='mCSB_container'></div>");
		}
	}
	
	

/* #Mobile header
================================================== */
	if(!$body.hasClass("responsive-off")){
	
		var $mixedHeader = $(".mixed-header"),

			//Mobile header widgets
			 $firstSwitchWidgetsNearLogo = $(".masthead .near-logo-first-switch").clone(true).addClass("show-on-first-switch"),
			 $secondSwitchWidgetsNearLogo = $(".masthead .near-logo-second-switch").clone(true).addClass("show-on-second-switch"),

			 //Mobile navigation widgets
			$mobileWidgetsInMenu = $mastheadHeader.find(".in-menu-first-switch").clone(true).addClass("hide-on-desktop hide-on-second-switch show-on-first-switch"),
			$mobileWidgetsInMenuSeocndSwitch = $mastheadHeader.find(".in-menu-second-switch").clone(true).addClass("hide-on-desktop hide-on-first-switch show-on-second-switch"),

			//Mobile top bar widgets
			$mobileWidgetsInTopBar = $mastheadHeader.find(".in-top-bar").clone(true).addClass("hide-on-desktop hide-on-first-switch show-on-second-switch"),
			$mobileWidgetsInTopBarLeft = $mastheadHeader.find(".in-top-bar-left").clone(true).addClass("hide-on-desktop show-on-first-switch"),
			$mobileWidgetsInTopBarRight = $mastheadHeader.find(".in-top-bar-right").clone(true).addClass("hide-on-desktop  show-on-first-switch");

		if($mixedHeader.length > 0){
			var $mobileLogo = $mixedHeader.find(".branding > a, .branding > img").clone(true),
				$activeHeader = $mixedHeader
		}else{
			var $mobileLogo = $(".masthead:not(.mixed-header)").find(".branding > a, .branding > img").clone(true),
				$activeHeader = $mastheadHeader;
		}
		if($topBar.length > 0 && $topBar.css('display') != 'none'){
			var topBarH = $topBar.innerHeight();
		}else{
			var topBarH = 0;
		}
		var mobileToggleCaptionOn = dtLocal.themeSettings.mobileHeader.mobileToggleCaptionEnabled;
		if(mobileToggleCaptionOn != "disabled"){
			mobileToggleCaption = "<span class='menu-toggle-caption'>" + dtLocal.themeSettings.mobileHeader.mobileToggleCaption + "</span>";
		}else{
			mobileToggleCaption='';
		}

		/*Append mobile header-bar to masthead*/
		$("<div class='mobile-header-bar'><div class='mobile-navigation'></div><div class='mobile-mini-widgets'></div><div class='mobile-branding'></div></div>").appendTo(".masthead");
		/*Mobile menu toggle icon*/
		$(".mobile-header-bar .mobile-navigation").append("<a href='#' class='dt-mobile-menu-icon' aria-label='Mobile menu icon'>" + mobileToggleCaption + "<div class='lines-button '><span class='menu-line'></span><span class='menu-line'></span><span class='menu-line'></span></div></a>");
		

		/*Append mini widgets to mobile header-bar*/

		$($firstSwitchWidgetsNearLogo).appendTo(".mobile-header-bar .mobile-mini-widgets");
		$($secondSwitchWidgetsNearLogo).appendTo(".mobile-header-bar .mobile-mini-widgets");

		/*Append mini widgets to mobile top-bar*/
		$(".left-widgets", $topBar).append($mobileWidgetsInTopBar);
		$(".left-widgets", $topBar).append($mobileWidgetsInTopBarLeft);
		$(".right-widgets", $topBar).append($mobileWidgetsInTopBarRight).removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		$(".right-widgets", $topBar).append($mobileWidgetsInTopBarRight).removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch")

		/*Mobile navigation widgets*/
		$($mobileWidgetsInMenu).appendTo(".mobile-mini-widgets-in-menu");
		$($mobileWidgetsInMenuSeocndSwitch).appendTo(".mobile-mini-widgets-in-menu");
		 $mobileWidgetsInMenu.removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		 $mobileWidgetsInMenuSeocndSwitch.removeClass("select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch");

		/*Append logo to mobile header-bar*/
		$(".mobile-header-bar .mobile-branding").append($mobileLogo);

		var $mobileMenu = $(".dt-mobile-header");
		if($mobileMenu.siblings().hasClass("dt-parent-menu-clickable")){
			$mobileMenu.addClass("dt-parent-menu-clickable");
		}
		if(!$(".mobile-mini-widgets-in-menu").find(".in-menu-first-switch ").length > 0){
			$(".mobile-mini-widgets-in-menu").addClass('first-switch-no-widgets')
		}
		if(!$(".mobile-mini-widgets-in-menu").find(".in-menu-second-switch ").length > 0){
			$(".mobile-mini-widgets-in-menu").addClass('second-switch-no-widgets')
		}

		$firstSwitchWidgetsNearLogo.removeClass("select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch");
		 $secondSwitchWidgetsNearLogo.removeClass("select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch");
		 $mobileWidgetsInTopBar.removeClass('show-on-desktop select-type-menu list-type-menu select-type-menu-first-switch list-type-menu-first-switch in-top-bar-left').addClass('hide-on-desktop hide-on-first-switch');
		 $mobileWidgetsInTopBarLeft.removeClass('show-on-desktop select-type-menu list-type-menu select-type-menu-second-switch list-type-menu-second-switch in-top-bar').addClass('hide-on-desktop hide-on-second-switch');
		 $mobileWidgetsInTopBarRight.removeClass('show-on-desktop select-type-menu list-type-menu  select-type-menu-second-switch list-type-menu-second-switch').addClass('hide-on-desktop');
		$(".header-bar .mini-widgets > .mini-nav ").removeClass('select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch');

		$(".mini-nav.show-on-desktop:not(.show-on-first-switch):not(.show-on-second-switch)", $topBar).removeClass('select-type-menu-second-switch list-type-menu-second-switch select-type-menu-first-switch list-type-menu-first-switch');
		$(".masthead .hide-on-desktop").addClass("display-none");
		
		/*Remove mega menu settings from mobile*/
		$(".mobile-main-nav ").find("li").each(function(){
			var $this = $(this),
				$this_sub = $this.find(" > .dt-mega-menu-wrap > .sub-nav");
			if($this.hasClass("new-column")){
				var $thisPrev = $this.prev().find(" > .sub-nav");
				$(" > .sub-nav > *", $this).appendTo($thisPrev)
			}
			$this_sub.unwrap();		
		}).removeClass('dt-mega-menu dt-mega-parent hide-mega-title').find(" > .sub-nav").removeClass(" hover-style-bg");


		/*!-Show Hide mobile header*/
		if($mobileMenu.length > 0 ) {
			dtGlobals.mobileMenuPoint = 50;
			var $Mobilehamburger = $(".dt-mobile-menu-icon"),
				isbtnMoved = false,
				$activeHeaderTop = $activeHeader.offset().top;
			
			/*Mobile floating menu toggle*/
			if(!$(".floating-btn").length > 0 && $(".floating-mobile-menu-icon").length > 0){
				var $hamburgerFloat = $Mobilehamburger.first().clone(true).insertBefore($Mobilehamburger).addClass("floating-btn");
				//var $hamburgerFloat = '<a href="#" class="dt-mobile-menu-icon floating-btn" aria-label="Mobile menu icon"><span class="lines"></span></a>';
				//$hamburgerFloat.insertBefore($Mobilehamburger).addClass("floating-btn");
				//$('<a href="#" class="dt-mobile-menu-icon" aria-label="Mobile menu icon"><span class="lines"></span></a>').appendTo(".masthead:not(#phantom)").addClass("floating-btn");
			}
			var $floatMobBtn = $(".floating-btn");
			
			var mobilePhantomAnimate = false;


			$window.scroll(function () {
				dtGlobals.mobileMenuPoint = $activeHeaderTop + $activeHeader.height() + 50;

				if(dtGlobals.winScrollTop > dtGlobals.mobileMenuPoint && isbtnMoved === false){
					$floatMobBtn.parents(".masthead").addClass("show-floating-icon");
					isbtnMoved = true;
				}
				else if(dtGlobals.winScrollTop <= dtGlobals.mobileMenuPoint && isbtnMoved === true) {
					$floatMobBtn.parents(".masthead").removeClass("show-floating-icon");
					isbtnMoved = false;
				}
			});
			var $Mobilehamburger = $(".dt-mobile-menu-icon");

			/*Append overlay for mobile menu*/
			if(!$(".mobile-sticky-header-overlay").length > 0){
				$body.append('<div class="mobile-sticky-header-overlay"></div>');
			}
					
			 var $mobileOverlay = $(".mobile-sticky-header-overlay");

			/*Click on mobile menu toggle*/
			$Mobilehamburger.on("click", function (e){
				e.preventDefault();
				
				var $this = $(this);

				if ($this.hasClass("active")){
					$this.removeClass("active");
					$page.removeClass("show-mobile-header").addClass("closed-mobile-header");
					$body.removeClass("show-mobile-overlay-header").addClass("closed-overlay-mobile-header");
					$this.parents("body").removeClass("show-sticky-mobile-header");
					$mobileOverlay.removeClass("active");
				}else{
					$Mobilehamburger.removeClass("active");
					$this.addClass('active');
					$page.addClass("show-mobile-header").removeClass("closed-mobile-header");
					$body.removeClass("closed-overlay-mobile-header").addClass("show-overlay-mobile-header");
					$mobileOverlay.removeClass("active");
					$this.parents("body").addClass("show-sticky-mobile-header");
					$mobileOverlay.addClass("active");
				};

			
			});
			$mobileOverlay.on("click", function (){
				if($(this).hasClass("active")){
					$Mobilehamburger.removeClass("active");
					$page.removeClass("show-mobile-header").addClass("closed-mobile-header");
					$body.removeClass("show-sticky-mobile-header").addClass("closed-overlay-mobile-header").addClass("closed-overlay-mobile-header");
					$mobileOverlay.removeClass("active");
					$page.removeClass("show-mobile-sidebar");
					
				}
			});
			$(".dt-close-mobile-menu-icon").on("click", function (){
				
				$page.removeClass("show-mobile-header");
				$page.addClass("closed-mobile-header");
				$body.removeClass("show-sticky-mobile-header");
				$body.removeClass("show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
				$mobileOverlay.removeClass("active");
				$Mobilehamburger.removeClass("active");
								
			});
			
			////!--Return with old header
			$(".dt-mobile-header").wrapInner("<div class='mobile-header-scrollbar-wrap'></div>");
		
				$mobileMenu.on('scroll', function () {
					$(".mobile-header-scrollbar-wrap").layzrInitialisation();
				})
			
			$mobileMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
			if(!$(".touchevents").length > 0){
				$mobileMenu.on("mouseenter", function(e) {
					$mobileMenu.css("overflow-y", "auto");
				});
				$mobileMenu.on("mouseleave", function(e) {
					$mobileMenu.css("overflow-y", "hidden");
				});
			}
		};
		
	}


/* #Main menu
================================================== */
	/* We need to fine-tune timings and do something about the usage of jQuery "animate" function */

	//Menu decoration Underline > Left to right

	$(".l-to-r-line > li:not(.menu-item-language) > a > span:last-child").not(".l-to-r-line > li > a > span.mega-icon").append("<i class='underline'></i>");

	
	$(".not-clickable-item").on("click", function(e){
		e.preventDefault();
		e.stopPropagation();
	});

	//Menu decoration Background / outline / line > Hover/Active line
	if($(".active-line-decoration").length > 0 || $(".hover-line-decoration").length > 0){
		$(".main-nav > .menu-item > a").append("<span class='decoration-line'></span>");
	};

	//declare vars
	var $mainNav = $(".main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"),
		$mainMenu = $(".masthead:not(.sub-downwards) .main-nav, .mini-nav, .mini-wpml .wpml-ls-item-legacy-dropdown"),
		$mainNavMob = $(".main-nav"),
		$sideHeader = $(".side-header");

	/*Wpml menu item*/
	$(".menu-item-language").each(function(){
		var $this = $(this);
		if($this.children('.submenu-languages').length > 0){
			$this.addClass("has-children");
		}
	});

	var	$mobileNav = $mainNavMob.clone();
	var	$mobileTopNav = $(".mini-nav").clone();
	

	$(".mini-nav select").change(function() {
		window.location.href = $(this).val();
	});

	dtGlobals.isHovering = false;
	$(".main-nav li", $sideHeader).each(function(){
		var $this = $(this);
		if($this.hasClass("new-column")){
			var $thisPrev = $this.prev().find(" > .sub-nav");
			$(" > .sub-nav > *", $this).appendTo($thisPrev)
		}
	})
	$(".sub-downwards .main-nav > li").each(function(){
		var $this = $(this),
			$this_sub = $this.find(" > .dt-mega-menu-wrap > .sub-nav");
			$this_sub.unwrap();
	});

	/*Top bar select type menu menu*/
	var droupdownCustomMenu = $(".select-type-menu, .select-type-menu-first-switch, .select-type-menu-second-switch, .mini-wpml .wpml-ls-item-legacy-dropdown");
	var subMenuClassList = "mini-sub-nav";
	droupdownCustomMenu.find("> ul").addClass(subMenuClassList );
	$(".mini-wpml .wpml-ls-item-legacy-dropdown").find("> ul").addClass(subMenuClassList );
	/*Sub menu*/
	$mainMenu.each(function() {
		var $this = $(this);
		$(".act", $this).parents("li").addClass("act");
		$(" li.has-children ", $this).each(function() {
			var $this = $(this);
			var $thisHover = $this.find("> a");

			if($this.parent().hasClass("main-nav") && !$this.parents().hasClass("side-header") && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this.find("> a");
			}else if($this.parent().hasClass("main-nav") && $this.parents().hasClass("side-header") && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this;
			}else if(($this.parent().hasClass("sub-nav") || $this.parents().hasClass("mini-nav")) && $(".masthead").hasClass('show-sub-menu-on-hover')){
				var $thisHover = $this;
			};

			if(dtGlobals.isMobile || dtGlobals.isWindowsPhone){
				$this.find("> a").on("click", function(e) {
					if (!$(this).hasClass("dt-clicked")) {
						e.preventDefault();
						$mainNav.find(".dt-clicked").removeClass("dt-clicked");
						$(this).addClass("dt-clicked");
					} else {
						e.stopPropagation();
					}
				});
			};
			var menuTimeoutShow,
				menuTimeoutHide;

			//set width for sidebar within mega menu
			if($mainNav.parents().hasClass('full-width') && $this.hasClass("mega-full-width")){
				if($mainNav.parents(".header-bar").length > 0){
					var $_this_par_w = $mainNav.parents(".header-bar").innerWidth();
				}else{
					var $_this_par_w = $mainNav.parents(".ph-wrap").innerWidth();
					
				}
				if(!$sideHeader.length > 0){
					$this.find('.sub-nav-widgets').css({
						width: $_this_par_w,
					})
				}
			}

			function showSubMenu(el){
				
				
				if(el.parent("li").length > 0){
					var $thisPar = el.parent(),
						$subMenu = el.siblings("div.dt-mega-menu-wrap, ul");
				}else{
					var $thisPar = el,
						$this_a = el.find("> a"),
						$subMenu = $this_a.siblings("div.dt-mega-menu-wrap, ul");
				}
				var $this_of_l = el.offset().left,
					$this_a = el.offset().left,
					$masthead = el.parents(".masthead");
				

				$thisPar.addClass("dt-hovered");
				if($thisPar.hasClass("dt-mega-menu")) $thisPar.addClass("show-mega-menu");

				dtGlobals.isHovering = true;

				/*Right overflow menu*/
				if ($page.width() - ($subMenu.offset().left - $page.offset().left) - $subMenu.width() < 0) {
					$subMenu.addClass("right-overflow");
				}				
				/*Bottom overflow menu*/
				if ($window.height() - ($subMenu.offset().top - dtGlobals.winScrollTop) - $subMenu.innerHeight() < 0 && !$subMenu.parents().hasClass('sub-sideways')) {
					$subMenu.addClass("bottom-overflow");
				};
				if ($window.height() - ($subMenu.offset().top - dtGlobals.winScrollTop) - $subMenu.innerHeight() < 0 && !$thisPar.hasClass("dt-mega-menu")) {
					$subMenu.addClass("bottom-overflow");
				};
				if(($thisPar.find(".dt-mega-menu-wrap").length > 0 && $thisPar.find(".dt-mega-menu-wrap").offset().top + $thisPar.find(".dt-mega-menu-wrap").innerHeight()) > $window.height() && $subMenu.parents().hasClass('sub-sideways') && $thisPar.hasClass("dt-mega-menu")){

					if(el.find(".dt-mega-menu-wrap").height() <= $window.height()){
						
						$thisPar.find(".dt-mega-menu-wrap").css({
							top: -(($thisPar.position().top + $thisPar.height() + el.find(".dt-mega-menu-wrap").height()) - ($window.height() ))
						});
						
					}else{
						$thisPar.find(".dt-mega-menu-wrap").css({
							top: -(el.position().top - 5)
						});
					}

				}
				/*Left position*/
				if(!$sideHeader.length > 0){
					$subMenu.not(".right-overflow").css({
						left: $this_a - $this_of_l
					});
				};
				if(el.parents(".dt-mobile-header").length > 0) {
		            $subMenu.css({
		                top: el.position().top - 13 - $subMenu.height()
		            });
		        };
				/*Mega menu auto width */
				if($thisPar.hasClass("mega-auto-width")){
					var $_this_par_width = $thisPar.width(),
						$_this_par_of_l = $masthead.offset().left,
						$_this_of_l = $thisPar.offset().left;
						$_this_parents_ofs = $thisPar.offset().left - $_this_par_of_l;

					if(!$sideHeader.length){
						var $pageW = $page.width();
						if($(".boxed").length > 0){
							var $_this_of_l = $thisPar.position().left;
							if($subMenu.innerWidth()  > ($pageW - $thisPar.position().left)){
								$subMenu.css({
									left: -( $subMenu.innerWidth()  - ($pageW - $_this_of_l) + 20 )
								});

							}
						}else{
							var $_this_of_l = $thisPar.offset().left;
							if($subMenu.innerWidth()  > ($pageW - $thisPar.offset().left)){
								$subMenu.css({
									left: -( $subMenu.innerWidth()  - ($pageW - $_this_of_l) + 20 )
								});

							}
						}	

						if($subMenu.innerWidth() > $pageW){
							if($(".boxed").length > 0){
								$subMenu.css({
									width: $masthead.width() - 40,
									left: -($thisPar.position().left + 20)
								});
							}else{
								$subMenu.css({
									width: $masthead.width() - 40,
									left: -($_this_of_l - $_this_par_of_l + 20)
								});
							}
						}
					}
					if(typeof $subMenu.find('.slider-content') != undefined) {
						$subMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
					}
					$subMenu.layzrInitialisation();
				};

				/*Mega menu -> full width*/
				if($thisPar.hasClass("mega-full-width")){
					var $_this_of_l = $thisPar.offset().left;
					if(el.parents(".header-bar").length > 0){
						if(el.parents(".masthead").hasClass('full-width')){
							var $_this_par_w = el.parents(".header-bar").innerWidth() - 40;
							var $_this_par_of_l = el.parents(".header-bar").offset().left + 20;
						}else{
							var $_this_par_w = el.parents(".header-bar").innerWidth();
							var $_this_par_of_l = el.parents(".header-bar").offset().left;
						}
					}else{
						if(el.parents(".masthead").hasClass('full-width')){
							var $_this_par_w = el.parents(".ph-wrap").innerWidth() - 40;
							var $_this_par_of_l = el.parents(".ph-wrap").offset().left + 20;
						}else{
							var $_this_par_w = el.parents(".ph-wrap").innerWidth();
							var $_this_par_of_l = el.parents(".ph-wrap").offset().left;
						}
						
					}
					if(!$sideHeader.length > 0){
						$subMenu.css({
							width: $_this_par_w,
							left: -($_this_of_l - $_this_par_of_l)
						})
					}

					if(typeof $subMenu.find('.slider-content') != undefined) {
						$subMenu.find('.slider-content').widgetScroller().css("visibility", "visible");
					}
					$subMenu.layzrInitialisation();
				}

				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutShow = setTimeout(function() {
					if($thisPar.hasClass("dt-hovered")){
						$subMenu.stop().css("visibility", "visible").animate({
							"opacity": 1
						}, 150, function() {

			               $thisPar.addClass("show-mega-menu-content");
						});
						
						/*hide search*/
			            $(".searchform .submit", $header).removeClass("act");
			            $(".mini-search").removeClass("act");
			            $(".mini-search.popup-search .popup-search-wrap", $header).stop().animate({
			                "opacity": 0
			            }, 150, function() {
			                $(this).css("visibility", "hidden");
			            });
					}
				}, 100);
			}
			function hideSubMenu(el){
				var $thisLink = el.find("> a"),
					$subMenu = $thisLink.siblings("div.dt-mega-menu-wrap, ul");

				el.removeClass("dt-hovered");
				dtGlobals.isHovering = false;
				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutHide = setTimeout(function() {
					if(!el.hasClass("dt-hovered")){
						$subMenu.stop().animate({
							"opacity": 0
						}, 150, function() {
							$(this).css("visibility", "hidden");
						});

						el.removeClass("show-mega-menu");

			            el.removeClass("show-mega-menu-content");
						
						setTimeout(function() {
							if(!el.hasClass("dt-hovered")){
								$subMenu.removeClass("right-overflow");
								$subMenu.removeClass("bottom-overflow");
								el.find(".dt-mega-menu-wrap").css({
									top: ""
								});
								if(el.hasClass("mega-auto-width")){
									$subMenu.css({
										width: "",
										left: ""
									});
								}
							}
						}, 400);
					}
				}, 150);

				el.find("> a").removeClass("dt-clicked");
			}
			$this.find("> a").on("focus", function(e) {
				if(e.type == "tap") e.stopPropagation();
				var $this = $(this);
				showSubMenu($this);

				$(" li.has-children").removeClass("parent-clicked");
				$this.parent().addClass("parent-clicked");
				if(!$(e.target).parents().hasClass('sub-nav')){
					$(" li.has-children").removeClass("dt-hovered");
					$this.parent().addClass("dt-hovered");
				}
				$(".main-nav > li:not(.dt-hovered) > .sub-nav, .main-nav >  li:not(.dt-hovered) > .dt-mega-menu-wrap").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				$(" .main-nav .sub-nav li:not(.parent-clicked) .sub-nav").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
			});

			$this.find("> a").on("focusout", function(e) {
				var $this = $(this);
				//hideSubMenu($this);
				var $thisLink = $('this'),
					$subMenu = $thisLink.siblings("div.dt-mega-menu-wrap, ul");

				//$this.parent().removeClass("dt-hovered");
				dtGlobals.isHovering = false;
				clearTimeout(menuTimeoutShow);
				clearTimeout(menuTimeoutHide);

				menuTimeoutHide = setTimeout(function() {
					if(!$this.parent().hasClass("dt-hovered")){
						$subMenu.stop().animate({
							"opacity": 0
						}, 150, function() {
							$(this).css("visibility", "hidden");
						});

						$this.parent().removeClass("show-mega-menu");

			            $this.parent().removeClass("show-mega-menu-content");
						
						setTimeout(function() {
							if(!$this.parent().hasClass("dt-hovered")){
								$subMenu.removeClass("right-overflow");
								$subMenu.removeClass("bottom-overflow");
								$this.parent().find(".dt-mega-menu-wrap").css({
									top: ""
								});
								if($this.parent().hasClass("mega-auto-width")){
									$subMenu.css({
										width: "",
										left: ""
									});
								}
							}
						}, 400);
					}
				}, 150);

				$this.parent().removeClass("parent-clicked");
			});
			if($(".masthead").hasClass('show-sub-menu-on-hover')){
				$thisHover.on("mouseenter tap", function(e) {
					if(e.type == "tap") e.stopPropagation();
					var $this = $(this);
					showSubMenu($this);
				});

				$this.on("mouseleave", function(e) {
					var $this = $(this);
					hideSubMenu($this);
				});
			}else{
				$body.on("click", function(e) {
					if(!$(e.target).hasClass('sub-nav') || !$(e.target).hasClass('dt-mega-menu-wrap')){
						$(" #primary-menu li.dt-hovered:not(.dt-mega-menu) > .sub-nav").animate({
							"opacity": 0
						}, 100, function() {
							$(this).css("visibility", "hidden");
						});
						$(" #primary-menu li.dt-mega-menu > .is-clicked").siblings(" .dt-mega-menu-wrap").animate({
							"opacity": 0
						}, 100, function() {
							$(this).css("visibility", "hidden");
						});
						$(" li.has-children").removeClass("dt-hovered");
						$(" li.has-children > a").removeClass("is-clicked");
					}
	            });
	          
				$thisHover.on("click", function(e) {
					if(!$(this).parents().hasClass('mobile-main-nav')){
						if(e.type == "tap") e.stopPropagation();
						var $this = $(this),
							$thisLink = $this.parent("li");

						if ($this.hasClass("is-clicked")) {
							hideSubMenu($thisLink);
							$this.removeClass("is-clicked");
							$this.parent().removeClass("parent-clicked");
						}else{
							showSubMenu($this);
							$(" li.has-children > a").removeClass("is-clicked");
							$(" li.has-children").removeClass("parent-clicked");
							$this.parent().addClass("parent-clicked");
							if(!$(e.target).parents().hasClass('sub-nav')){
								$(" li.has-children").removeClass("dt-hovered");
								$this.parent().addClass("dt-hovered");
							}
							$(".main-nav > li:not(.dt-hovered) > .sub-nav, .main-nav >  li:not(.dt-hovered) > .dt-mega-menu-wrap").stop().animate({
								"opacity": 0
							}, 150, function() {
								$(this).css("visibility", "hidden");
							});
							$(".main-nav .sub-nav li:not(.parent-clicked) .sub-nav").stop().animate({
								"opacity": 0
							}, 150, function() {
								$(this).css("visibility", "hidden");
							});
							$this.addClass("is-clicked");
							return false;
						}
					}
				})

			}

		});
	});
	$.fn.touchMenuItem = function() {
		return this.each(function() {
			var $item = $(this);
			if ($item.hasClass("item-ready")) {
				return;
			}

			$body.on("touchend", function(e) {
				$(".mobile-true .has-children > a").removeClass("is-clicked");
			});
			var $this = $(this),
				$thisTarget = $this.attr("target") ? $this.attr("target") : "_self";
			$this.on("touchstart", function(e) { 
				origY = e.originalEvent.touches[0].pageY;
				origX = e.originalEvent.touches[0].pageX;
			});
			$this.on("touchend", function(e) {
				var touchEX = e.originalEvent.changedTouches[0].pageX,
					touchEY = e.originalEvent.changedTouches[0].pageY;
				if( origY == touchEY || origX == touchEX ){
					if ($this.hasClass("is-clicked")) {
					} else {
						if($this.parent().hasClass("dt-hovered")){
							e.preventDefault();
							$(".mobile-true .has-children > a").removeClass("is-clicked");
							$this.addClass("is-clicked");
							window.open($this.attr("href"), $thisTarget);
							return false;
						}
					};
				};
			});

			$item.addClass("item-ready");
		});
	};
	$(".mobile-true .has-children > a").touchMenuItem();

	var menuTimeoutShow,
		menuTimeoutHide;
	droupdownCustomMenu.on("mouseenter tap", function(e) {
		if(e.type == "tap") e.stopPropagation();

		var $this = $(this);
		$this.addClass("dt-hovered");

		if ($page.width() - ($this.children(".mini-sub-nav").offset().left - $page.offset().left) - $this.find(" > .mini-sub-nav").width() < 0) {
			$this.children(".mini-sub-nav").addClass("right-overflow");
		}

		if (($window.height() - ($this.children(".mini-sub-nav").offset().top - dtGlobals.winScrollTop) - $this.children(".mini-sub-nav").height() < 0) && !$this.parents(".dt-mobile-header").length > 0) {
			$this.children(".mini-sub-nav").addClass("bottom-overflow");
		};
		if($this.parents(".dt-mobile-header").length > 0) {
            $this.children(".mini-sub-nav").css({
                top: $this.position().top - 13 - $this.children(".mini-sub-nav").height()
            });
        };

		dtGlobals.isHovering = true;
		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutShow = setTimeout(function() {
			if($this.hasClass("dt-hovered")){
				$(".mini-sub-nav").stop().animate({
					"opacity": 0
				}, 50, function() {
					$(this).css("visibility", "hidden");
				});
				$this.children('.mini-sub-nav').stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 150);
			}
		}, 100);
	});

	droupdownCustomMenu.on("mouseleave", function(e) {
		var $this = $(this);
		$this.removeClass("dt-hovered");

		dtGlobals.isHovering = false;
		clearTimeout(menuTimeoutShow);
		clearTimeout(menuTimeoutHide);

		menuTimeoutHide = setTimeout(function() {
			if(!$this.hasClass("dt-hovered")){
				if(!$this.parents().hasClass("dt-mega-menu")){
					$this.children(".mini-sub-nav").stop().animate({
						"opacity": 0
					}, 150, function() {
						$(this).css("visibility", "hidden");
					});
				}
				
				setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.children(".mini-sub-nav").removeClass("right-overflow");
						$this.children(".mini-sub-nav").removeClass("bottom-overflow");
					}
				}, 400);
			}
		}, 150);
	});

/* #Floating menu
================================================== */
	dtGlobals.desktopProcessed = false;
	dtGlobals.mobileProcessed = false;

	var stickyMobileHeaderExists = $(".sticky-mobile-header").exists();


	if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
		$('.masthead:not(.side-header):not(#phantom)').addClass("masthead-mobile-header");
		$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass("masthead-mobile-header").addClass('desktop-side-header');
	}
	if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")){
		//Check if top bar not empty on mobile
		if($('.left-widgets', $topBar).find(".in-top-bar-left").length > 0 || $('.right-widgets', $topBar).find(".in-top-bar-right").length > 0){
			$topBar.removeClass('top-bar-empty');
		}else{
			$topBar.addClass('top-bar-empty');
		}
	}else if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")) {
		if($('.left-widgets', $topBar).find(".in-top-bar").length > 0){
			$topBar.removeClass('top-bar-empty');
		}else{
			$topBar.addClass('top-bar-empty');
		}
	}

	/*
	// Mobile sticky header
	// variables $mastheadHeader, $mainSlider are defined in header.js atom
	*/
	var floatingNavigationBelowSliderExists = $(".floating-navigation-below-slider").exists();

	if($('.sticky-mobile-header').exists() && !$body.hasClass("responsive-off")){

		var $stickyMobileHeader =  $(".masthead:not(.side-header):not(#phantom), body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)"),
			$mobileHeader = $stickyMobileHeader.find(".mobile-header-bar");
			$stickyMobileLogo = $stickyMobileHeader.find(".mobile-branding"),
			mobileLogoURL = $(".mobile-branding a").attr("href");

		// Logo for mobile sticky floating header: first switch point
		if(!$(".sticky-mobile-logo-first-switch").exists()) {
			if (dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html) {
				if (mobileLogoURL == undefined) {
					console.log($(dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html))
					$(dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html).addClass("sticky-mobile-logo-first-switch").prependTo($stickyMobileLogo)
				}
				else {
					$('<a class="sticky-mobile-logo-first-switch" href="'+mobileLogoURL+'">' + dtLocal.themeSettings.stickyMobileHeaderFirstSwitch.logo.html +' </a>').prependTo($stickyMobileLogo);
				};
			};
		};


		// Logo for mobile sticky floating header: second switch point
		if(!$(".sticky-mobile-logo-second-switch").exists()) {
			if (dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html) {
				if (mobileLogoURL == undefined) {
					$(dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html).addClass("sticky-mobile-logo-second-switch").prependTo($stickyMobileLogo)
				}
				else {
					$('<a class="sticky-mobile-logo-second-switch" href="'+mobileLogoURL+'">' + dtLocal.themeSettings.stickyMobileHeaderSecondSwitch.logo.html +' </a>').prependTo($stickyMobileLogo);
				};
			};
		};


		var mobileTopBarH = 0,
			mobileAdminBarH = 0,
			sliderH = $mainSlider.height(),
			mobileHeaderH = 0,
			mobileMenuH = 0,
			mobileMenuT = 0,
			mobileHeaderDocked = false;

		if (!bodyTransparent) {
			$("<div class='mobile-header-space'></div>").insertBefore($stickyMobileHeader);
			var $MobileHeaderSpace = $(".mobile-header-space");
		}
		if($(".no-cssgridlegacy.no-cssgrid").length > 0  && floatingNavigationBelowSliderExists){
			if (bodyTransparent) {
				$stickyMobileHeader.css({
					"top":  sliderH
				});
				$MobileHeaderSpace.css({
					"top":  sliderH
				});
			}else{
				$MobileHeaderSpace.insertAfter($mainSlider);
				$stickyMobileHeader.insertAfter($mainSlider);
			}
		}

		dtGlobals.resetMobileSizes = function (sliderHeihgt) {
			if (window.innerWidth > dtLocal.themeSettings.mobileHeader.firstSwitchPoint) {
				if($(".is-safari").length > 0){
					$stickyMobileHeader.css({
						"width": "",
						"max-width": ""
					});
				}

				$stickyMobileHeader.removeClass('sticky-mobile-off sticky-mobile-on');
				mobileHeaderDocked = false;
				return false;
			};

			// Admin bar height
			if ($("#wpadminbar").exists() && !Modernizr.mq('only screen and (max-width:600px)')) {
				mobileAdminBarH = $("#wpadminbar").height();
			} else {
				mobileAdminBarH = 0;
			};
	
			// Top-bar height
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" ) && !$topBar.hasClass( "hide-top-bar" )) {
				mobileTopBarH = $topBar.innerHeight();
			}
			else {
				mobileTopBarH = 0;
			};
			// Full & sticky part header height
			if (window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint) {
				mobileHeaderH = dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight + mobileTopBarH;
				mobileMenuH = dtLocal.themeSettings.mobileHeader.firstSwitchPointHeight;
			}
			else {
				mobileHeaderH = dtLocal.themeSettings.mobileHeader.secondSwitchPointHeight + mobileTopBarH;
				mobileMenuH = dtLocal.themeSettings.mobileHeader.secondSwitchPointHeight;
			};
			
			// Sticky menu position
			if (!floatingNavigationBelowSliderExists) {
				mobileMenuT = mobileTopBarH;
			}
			else if (floatingNavigationBelowSliderExists && !bodyTransparent) {
				mobileMenuT = sliderHeihgt;
			}
			else if (floatingNavigationBelowSliderExists && bodyTransparent) {
				mobileMenuT = sliderHeihgt - mobileHeaderH + mobileTopBarH;
			}
			else {
				$mobileHeader.offset().top;
			}
			if ($stickyMobileHeader.hasClass('sticky-mobile-on')){
				$stickyMobileHeader.css({
					"top":  mobileAdminBarH - mobileTopBarH
				});
			}
	
			if (!bodyTransparent) {
				$MobileHeaderSpace.css({
					"height": mobileHeaderH
				});
				$MobileHeaderSpace.css({
					"top":  sliderHeihgt
				});
			};
			if($(".is-safari").length > 0){
				$stickyMobileHeader.css({
					"width":  document.documentElement.clientWidth,
					"max-width":  document.documentElement.clientWidth
				});
			}

		};
		dtGlobals.resetMobileSizes($mainSlider.height());
		$window.on("resize debouncedresize", function() {
			dtGlobals.resetMobileSizes($mainSlider.height());
		});

		// Main loop: listening for the scroll event
		$window.on("scroll", function() {
			// Stop execution when on mobile devices
			if (window.innerWidth > dtLocal.themeSettings.mobileHeader.firstSwitchPoint) {
				return false;
			}

			var posScrollTop = dtGlobals.winScrollTop;

			// Making header sticky (rewrite relative to $stickyHeader position)

			if ((posScrollTop > mobileMenuT) && (!mobileHeaderDocked) && $(document).height() > $(window).height()) {
				$stickyMobileHeader.removeClass('sticky-mobile-off').addClass('sticky-mobile-on');
				if(headerBelowSliderExists && stickyMobileHeaderExists){	
					$stickyMobileHeader.addClass("fixed-mobile-header");
				};
				$stickyMobileHeader.css({
					"top":  mobileAdminBarH - mobileTopBarH
				});
				mobileHeaderDocked = true;
			}
			else if ((posScrollTop <= mobileMenuT) && (mobileHeaderDocked)) {
				$stickyMobileHeader.removeClass('sticky-mobile-on').addClass('sticky-mobile-off');
				if(headerBelowSliderExists && stickyMobileHeaderExists){	
					$stickyMobileHeader.removeClass("fixed-mobile-header");
				};				
				$stickyMobileHeader.css({
					"top": 0
				});
				if($(".no-cssgridlegacy.no-cssgrid").length > 0  && floatingNavigationBelowSliderExists){
					if (bodyTransparent) {
						$stickyMobileHeader.css({
							"top":  sliderH
						});
					}else{
						$stickyMobileHeader.css({
							"top":  sliderH
						});
					}
				}
				mobileHeaderDocked = false;
			};
		});
	};


	/* Set variable for floating menu */

	if ((dtGlobals.isMobile && window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint)  && !dtGlobals.isiPad && !$body.hasClass("responsive-off")){
		if(dtLocal.themeSettings.floatingHeader.showMenu && $(".phantom-sticky").exists() && bodyTransparent) {
			$mastheadHeader.addClass('fixed-masthead');
		}

		dtLocal.themeSettings.floatingHeader.showMenu = false;
	} 

	var bodyTransparent = $body.hasClass("transparent"),
		phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderExists = $(".side-header").exists();


	/* Floating navigation -> Style -> Sticky */

	if(dtLocal.themeSettings.floatingHeader.showMenu && phantomStickyExists) {
		var logoURL = $(".branding a", $mastheadHeader).attr("href"),
			$stickyHeader = $mastheadHeader,
			$stickyMenu = $stickyHeader.find(".header-bar"),
			$branding = $stickyHeader.find(".branding"),
			$logo = $branding.find("img");

		// Using same or different logo?
		if ($branding.find("a.same-logo").length > 0) {
		}
		else {
			if(!$(".sticky-logo").exists()) {
				if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
					if (logoURL == undefined) {
						$(dtLocal.themeSettings.floatingHeader.logo.html).addClass("sticky-logo").prependTo($branding);
					}
					else {
						$('<a class="sticky-logo" href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>').prependTo($branding);
					};
				};
			};
		};

		var topBarH = 0,
			FtopBarH = 0,
			adminBarH = 0,
			stickyHeaderH = 0,
			stickyMenuH = 0,
			stickyMenuT = 0,
			headerDocked = false,
			headerTransition = "";

		// Appending empty div for sticky header placeholder

		if (!bodyTransparent) {
			$("<div class='header-space'></div>").insertAfter($stickyHeader);
			var $headerSpace = $(".header-space");
		};

		// Adding initial classes
		$stickyHeader.addClass('sticky-off fixed-masthead');

		var mobileReset = false;
		dtGlobals.resetSizes = function (sliderHeihgt) {
			// Stop execution when on mobile devices
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				if (!mobileReset) {
					mobileReset = true;
					$stickyHeader.removeClass('sticky-off sticky-on');
					if (!bodyTransparent) {
						$headerSpace.removeClass('sticky-space-off sticky-space-on');
					}
					$stickyHeader.css({
						"top":  "",
						"transform" : ""
					});
					headerDocked = false,
					headerTransition = "";
					if($(".is-safari").length > 0){
						$stickyHeader.css({
							"width":  "",
							"max-width":  ""
						});
					}
				}
				return false;
			}
			else if (mobileReset) {
				mobileReset = false;
			}
			
			if(!headerDocked && headerTransition === "") {
				$stickyHeader.addClass('sticky-off');
				if (!bodyTransparent) {
					$headerSpace.addClass('sticky-space-off');
				}	
			}

			// Admin bar height
			if ($("#wpadminbar").exists()) {
				adminBarH = $("#wpadminbar").height();
			}
			else {
				adminBarH = 0;
			};
	
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
				topBarH = $topBar.innerHeight();
			}else {
				topBarH = 0;
			};

			// Full header height
			stickyHeaderH = dtLocal.themeSettings.desktopHeader.height + topBarH;
			
			// Sticky part height 
			stickyMenuH = dtLocal.themeSettings.desktopHeader.height;
			
			// Sticky menu position
			if (!floatingNavigationBelowSliderExists) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = 0;
				}else{
					stickyMenuT = topBarH;
				}
			}
			else if (floatingNavigationBelowSliderExists && !bodyTransparent) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = sliderHeihgt - topBarH;
				}else{
					stickyMenuT = sliderHeihgt;
				}
			}
			else if (floatingNavigationBelowSliderExists && bodyTransparent) {
				if($body.hasClass("floating-top-bar")){
					stickyMenuT = sliderHeihgt - stickyMenuH - topBarH;
				}else{
					stickyMenuT = sliderHeihgt - stickyMenuH;
				}
			}
			else {
				$stickyMenu.offset().top;
			}
	
			if (!bodyTransparent) {
				$headerSpace.css({
					"height": stickyHeaderH
				});
			};
			// $stickyMenu
			// .css({
			// 	height : stickyMenuH
			// });


			if($(".is-safari").length > 0){
				if ($page.hasClass("boxed")) {
					$stickyHeader.css({
						"width":  $page.width(),
						"max-width":  $page.width()
					});
				}else{
					$stickyHeader.css({
						"width":  document.documentElement.clientWidth,
						"max-width":  document.documentElement.clientWidth
					});
				}
			}
		};

		dtGlobals.resetSizes($mainSlider.height());
		$window.on(" debouncedresize", function() {
			dtGlobals.resetSizes($mainSlider.height());
		});
		function showStickyMenu(){
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				return false;
			}
			var posScrollTop = dtGlobals.winScrollTop;

			// Making header sticky (rewrite relative to $stickyHeader position)
			if ((posScrollTop > (stickyMenuT + 1)) && (!headerDocked && !dtGlobals.isHovering)) {
				$stickyHeader.removeClass("sticky-off").addClass("sticky-on");
				if (!bodyTransparent) {
					$headerSpace.removeClass("sticky-space-off").addClass("sticky-space-on");
				}

				if($body.hasClass("floating-top-bar")){
					$stickyHeader.css({
						"top":  adminBarH
					});
				}else{
					$stickyHeader.css({
						"top":  adminBarH - topBarH
					});
				}
				headerDocked = true;

				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					$stickyHeader.css({
						"transform" : "translateY(0)"
					});
					if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){
						var $mastheadHeaderStyle = $stickyHeader.attr("style");
						$stickyHeader.attr("style", $mastheadHeaderStyle + "; top:" + topBarH + "px !important;");
					}
				};
			}
			else if ((posScrollTop <= (stickyMenuT + 1)) && (headerDocked)) {
				$stickyHeader.removeClass("sticky-on").addClass("sticky-off");
				if (!bodyTransparent) {
					$headerSpace.removeClass("sticky-space-on").addClass("sticky-space-off");
				}
				$stickyHeader.css({
					"top": 0
				});
				headerDocked = false;
			
				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					$stickyHeader.css({
						"transform" : "translateY(-100%)"
					});
					if(!!navigator.userAgent.match(/Trident.*rv\:11\./)){
						var $mastheadHeaderStyle = $stickyHeader.attr("style");
						$stickyHeader.not('.sticky-on').attr("style", $mastheadHeaderStyle + "; top:" + $mainSlider.height() + "px !important;");
					}
				};
			};

			// Transition
			if ((posScrollTop > (stickyMenuT + 1)) && (posScrollTop <= ((stickyMenuT + 1) + stickyMenuH - dtLocal.themeSettings.floatingHeader.height))) {
				headerTransition = "changing";
				$stickyMenu
				.css({
					"transition" : "none",
					height : stickyMenuT + stickyMenuH - posScrollTop,
				});
			}
			else if (posScrollTop > ((stickyMenuT + 1) + dtLocal.themeSettings.floatingHeader.height) && headerTransition !== "end") {
				headerTransition = "end";
				$stickyMenu
				.css({
					height : dtLocal.themeSettings.floatingHeader.height,
					"transition" : "all 0.3s ease" 
				});
			}
			else if (posScrollTop <= (stickyMenuT + 1) && headerTransition !== "start") {
				headerTransition = "start";
				$stickyMenu
				.css({
					height : stickyMenuH,
					"transition" : "all 0.1s ease"
				});
			};
		}
		showStickyMenu()
		// Scroll
		$window.on("scroll", function() {
			// Stop execution when on mobile devices
			showStickyMenu();
		});		
	};

	//Sticky top line
	if(stickyTopLine.exists()) {

		var stickyTopLineH = 0,
			adminBarH = 0,
			topBarH = 0,
			topLineDocked = false;
		stickyTopLine.addClass("sticky-top-line-off");

		if (!$('.top-line-space').exists() && !bodyTransparent) {
			$("<div class='top-line-space'></div>").insertBefore(stickyTopLine);
		}
		var logoURL = $(".branding a", stickyTopLine).attr("href"),
			$branding = stickyTopLine.find(".branding"),
			$logo = $branding.find("img");

		// Using same or different logo?
		if ($branding.find("a.same-logo").length > 0) {
		}
		else {
			if(!$(".sticky-logo").exists()) {
				if (dtLocal.themeSettings.topLine.floatingTopLine.logo.html && dtLocal.themeSettings.topLine.floatingTopLine.logo.showLogo) {
					if (logoURL == undefined) {
						$(dtLocal.themeSettings.topLine.floatingTopLine.logo.html).addClass("sticky-logo").prependTo($branding);
					}
					else {
						$('<a class="sticky-logo" href="'+logoURL+'">' + dtLocal.themeSettings.topLine.floatingTopLine.logo.html +' </a>').prependTo($branding);
					};
				};
			};
		};

	
		var mobileReset = false;
		dtGlobals.resetTopLineSizes = function (sliderHeihgt) {
			// Stop execution when on mobile devices
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				if (!mobileReset) {
					mobileReset = true;
					stickyTopLine.removeClass('sticky-top-line-on');
					
					stickyTopLine.css({
						"top":  ""
					});
					topLineDocked = false;
				}
				return false;
			}
			else if (mobileReset) {
				mobileReset = false;
			}
			

			// Admin bar height
			if ($("#wpadminbar").exists()) {
				adminBarH = $("#wpadminbar").height();
			}
			else {
				adminBarH = 0;
			};
	
			if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
				topBarH = $topBar.innerHeight();
			}else {
				topBarH = 0;
			};
			stickyTopLineH = stickyTopLine.find('.header-bar').height() + topBarH;

			$('.top-line-space').css({
				height: stickyTopLineH
			});

			if($(".is-safari").length > 0){
				if($page.hasClass("boxed")){
					stickyTopLine.css({
						"width": dtLocal.themeSettings.boxedWidth,
						"max-width": dtLocal.themeSettings.boxedWidth
					})
				}else{
					stickyTopLine.css({
						"width":  document.documentElement.clientWidth,
						"max-width":  document.documentElement.clientWidth
					});
				}
			}
		};

		dtGlobals.resetTopLineSizes($mainSlider.height());
		$window.on("resize debouncedresize", function() {
			dtGlobals.resetTopLineSizes($mainSlider.height());
		});

		$window.on("scroll", function() {
			if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
				return false;
			}
			// When sticky navigation should be shown
			var posScrollTop = dtGlobals.winScrollTop, //window scroll top position
				stickyTopLineH = stickyTopLine.height(),
				showstickyTopLineAfter = posScrollTop > stickyTopLineH;
				if (showstickyTopLineAfter && !topLineDocked){
					stickyTopLine.removeClass("sticky-top-line-off").addClass("sticky-top-line-on");
					if(stickyTopLine.hasClass("mixed-floating-top-bar")){
						stickyTopLine.css({
							"top":  adminBarH
						});
					}else{
						stickyTopLine.css({
							"top":  adminBarH - topBarH
						});
					}
					topLineDocked = true;
				}
				else if(!showstickyTopLineAfter && topLineDocked){
					stickyTopLine.removeClass("sticky-top-line-on").addClass("sticky-top-line-off");
					stickyTopLine.css({
						"top": adminBarH
					});
					topLineDocked = false;
				}
		});
	}

	/* Floating navigation -> Style -> fade, Slide */

	if(dtLocal.themeSettings.floatingHeader.showMenu) {

		if (dtLocal.themeSettings.floatingHeader.showMenu && !phantomStickyExists ) {

			var phantomFadeExists = $(".phantom-fade").exists(),
				phantomSlideExists = $(".phantom-slide").exists(),
				splitHeaderExists = $(".split-header").exists();

			if( phantomFadeExists || phantomSlideExists) {


				var $headerMenu = $(".masthead:not(#phantom) .main-nav").clone(true).removeAttr('id'),
					logoURL = $(".branding a", $mastheadHeader).attr("href"),
					$topbarFloating = $body.hasClass("floating-top-bar") ? $(".masthead:not(#phantom) .top-bar").clone(true) : "",
					isMoved = false;

				if (splitHeaderExists) {
					var headerClass = $mastheadHeader.attr("class");
					var $headerTopLine = $(".side-header-h-stroke, .split-header"),
						$phantom = $('<div id="phantom" class="'+headerClass+'"><div class="ph-wrap"></div></div>').appendTo("body"),
						$menuBox = $phantom.find(".ph-wrap"),
						$widgetBox = $phantom.find(".widget-box"),
						$widget = $headerMenu.find(".mini-widgets"),
						$phantomLogo = $headerTopLine.find(".branding");
					

					/*Phantom logo*/

					if($(".phantom-custom-logo-on").length > 0){

						if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
							if (logoURL == undefined){
								$(dtLocal.themeSettings.floatingHeader.logo.html).prependTo($phantomLogo)
							}
							else {
								$('<a class="phantom-top-line-logo" href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>').prependTo($phantomLogo);
							};
						};

						
					};
					//Generate floating content on load
					var $headerMenu = $(".split-header .header-bar").clone(true);
					$headerMenu.appendTo($menuBox).find('.main-nav').removeAttr('id');
					if($body.hasClass("floating-top-bar")){
						$topbarFloating.insertBefore($menuBox);
					}
				}
				else {
					var headerClass = $mastheadHeader.attr("class"),
						$phantom = $('<div id="phantom" class="'+headerClass+'"><div class="ph-wrap"><div class="logo-box"></div><div class="menu-box"></div><div class="widget-box"></div></div></div>').appendTo("body"),
						$menuBox = $phantom.find(".menu-box"),
						$widgetBox = $phantom.find(".widget-box");

					if ($(".classic-header").length > 0) {
						var $widget = $(".header-bar .navigation .mini-widgets").clone(true);
					}
					else if (splitHeaderExists) {}
					else {
						var $widget = $(".header-bar .mini-widgets").clone(true);
					};
					//Generate floating content on load
					$headerMenu.appendTo($menuBox);
					$widget.appendTo($widgetBox);
					if($body.hasClass("floating-top-bar")){
						$topbarFloating.prependTo($phantom);
					}

					/*Phantom logo*/
					if (dtLocal.themeSettings.floatingHeader.logo.html && dtLocal.themeSettings.floatingHeader.logo.showLogo) {
						$phantom.find(".ph-wrap").addClass("with-logo");

						if(logoURL == undefined){
							$phantom.find(".logo-box").html('<a href="'+dtLocal.themeSettings.floatingHeader.logo.url+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>');
						}
						else {
							$phantom.find(".logo-box").html('<a href="'+logoURL+'">' + dtLocal.themeSettings.floatingHeader.logo.html +' </a>');
						};
					};

					
				};
				var $floatingMenu =  $("#phantom");
				
				if ($page.hasClass("boxed")) {
					$phantom.addClass("boxed").find(".ph-wrap").addClass("boxed");
				}

				/* Hide floating on load */
				var phantomShowTimer;
				$floatingMenu.removeClass('show-phantom').addClass('hide-phantom').css("visibility", "hidden");
				addOnloadEvent(function(){
					clearTimeout( phantomShowTimer );
        			phantomShowTimer = setTimeout(function(){
						$floatingMenu.css("visibility", "");
					},150);
				})
				$menuBox.layzrInitialisation();

				var phantomAnimate = false;

				var phantomTimeoutShow,
					phantomTimeoutHide;	
				var tempScrTop = dtGlobals.winScrollTop,
					sliderH = $mainSlider.height(),
					headerH = $mastheadHeader.height();

				if (floatingNavigationBelowSliderExists && bodyTransparent) {
					var showFloatingAfter = tempScrTop <= sliderH;

				}
				else if (floatingNavigationBelowSliderExists) {
					var showFloatingAfter = tempScrTop <= (sliderH + headerH);
				}
				else {
					var showFloatingAfter = tempScrTop <= dtLocal.themeSettings.floatingHeader.showAfter;
				};
				$window.on("scroll", function() {

					// Stop execution when on mobile devices
					if (window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
						return false;
					}
					
					var tempScrTop = dtGlobals.winScrollTop,
						sliderH = $mainSlider.height(),
						headerH = $mastheadHeader.height();

					if (floatingNavigationBelowSliderExists && bodyTransparent) {
						var showFloatingAfter = tempScrTop > sliderH && isMoved === false,
							hideFloatingAfter = tempScrTop <= sliderH && isMoved === true;

					}
					else if (floatingNavigationBelowSliderExists) {
						var showFloatingAfter = tempScrTop > (sliderH + headerH) && isMoved === false,
							hideFloatingAfter = tempScrTop <= (sliderH + headerH) && isMoved === true;
					}
					else {
						var showFloatingAfter = tempScrTop > dtLocal.themeSettings.floatingHeader.showAfter && isMoved === false,
							hideFloatingAfter = tempScrTop <= dtLocal.themeSettings.floatingHeader.showAfter && isMoved === true;
					};

					if (showFloatingAfter) {
						if(!$html.hasClass("menu-open")){	

							if( !dtGlobals.isHovering && !phantomAnimate ) {
								phantomAnimate = true;
								$floatingMenu.removeClass("hide-phantom").addClass("show-phantom");
								isMoved = true;
							};
						}
					}
					else if (hideFloatingAfter) {

						if(phantomAnimate) {
							if(!$html.hasClass("menu-open")){	
								phantomAnimate = false;
								$floatingMenu.removeClass("show-phantom").addClass("hide-phantom");
				
								isMoved = false;
							}
						}

					};
					
				});
			};
		};
	};
	var loaderShowTimer;
	addOnloadEvent(function(){
		clearTimeout( loaderShowTimer );
		loaderShowTimer = setTimeout(function(){
			var load = document.getElementById("load");
			if (load !== null && !load.classList.contains('loader-removed')) {
				
				load.className += " loader-removed";
			}
		},150);
	});

/* #Custom menu
================================================== */
	var customTimeoutShow;

	

	var item = $('.main-nav li.has-children > a:not(.not-clickable-item), .level-arrows-on > li.has-children > a, .mobile-main-nav li.has-children > a');
	$("<i class='next-level-button'></i>").insertAfter(item);
	var itemMenu = $(' .dt-sub-menu-display-on_click li.has-children > a');
	$("<i class='next-level-button'></i>").appendTo(itemMenu);

	$(".sub-downwards .main-nav li.has-children, .mobile-main-nav li.has-children").each(function(){
		var $this = $(this);
		var subMenu = $this.find(" > .sub-nav, .sub-menu, .vertical-sub-nav");
		if($this.find(".sub-nav li, .sub-menu li, .vertical-sub-nav li").hasClass("act")){
			$this.addClass('active');
		};

		if($this.find(".sub-nav li.act, .sub-menu li.act, .vertical-sub-nav li.act").hasClass("act")){
			$this.addClass('open-sub');
			subMenu.stop(true, true).slideDown(100);

			subMenu.layzrInitialisation();
		};
		// $this.find("> a").on("focus", function(e) {
		// 	if(!$this.parents().hasClass("mobile-main-nav")){
		// 		$this.siblings().find(" .sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
		// 		subMenu.stop(true, true).slideDown(500);
		// 		$this.siblings().removeClass("active");
		// 		$this.addClass('active');
		// 		$this.siblings().removeClass('open-sub');
		// 		$this.addClass('open-sub');

		// 		$this.siblings().find("> a").removeClass("act");
		// 		$this.find('a').addClass('act');

		// 		$(" .main-nav").layzrInitialisation();
		// 	}
		// })
		$this.find(" > .next-level-button").on("click", function(e){
			var $this = $(this).parent();
			if ($this.hasClass("active")){
				subMenu.stop(true, true).slideUp(500, function(){
					$(" .main-nav").layzrInitialisation();
				});
				$this.removeClass("active");
				$this.removeClass('open-sub');
				$this.find('a').removeClass('act');

			}else{
				$this.siblings().find(" .sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
				subMenu.stop(true, true).slideDown(500);
				$this.siblings().removeClass("active");
				$this.addClass('active');
				$this.siblings().removeClass('open-sub');
				$this.addClass('open-sub');

				$this.siblings().find("> a").removeClass("act");
				$this.find('a').addClass('act');

				$(" .main-nav").layzrInitialisation();
			};

		})
	});

	$(" .dt-sub-menu-display-on_click li.has-children, .dt-sub-menu-display-on_item_click li.has-children").each(function(){
			var $this = $(this),
				itemLink = $this.find('> a'),
                iconData = itemLink.find('.next-level-button i').attr('class')
                iconDataAct = itemLink.find('.next-level-button').attr('data-icon');
		  	$this_sub = $this.find(" > .dt-mega-menu-wrap > .vertical-sub-nav");
            $this_sub.unwrap();
			var subMenu = $this.find(" > .vertical-sub-nav");
			if($this.find(".vertical-sub-nav li").hasClass("act")){
				$this.addClass('active');
			};

			if($this.find(".vertical-sub-nav li").hasClass("act")){
				$this.addClass('open-sub');
				subMenu.stop(true, true).slideDown(100);
				$this.find(' > a').addClass('active');
				$this.find(' > a .next-level-button i').attr('class', iconDataAct);
				subMenu.layzrInitialisation();
			};
			if(itemLink.hasClass('not-clickable-item') && $this.parents('nav').hasClass("dt-sub-menu-display-on_item_click")){
                var clickItem = itemLink;
            }else{
                 var clickItem =  itemLink.find(" > .next-level-button");
            }
			clickItem.on("click", function(e){
				e.stop
				//var $this = $(this);
				if(itemLink.hasClass('not-clickable-item') && itemLink.parents('nav').hasClass("dt-sub-menu-display-on_item_click")){
                    var $this = $(this),
                        openIcon = $(this).find('.next-level-button i');
                }else{
                    var $this = $(this).parent(),
                        openIcon = $(this).find('i');
                }
				e = window.event || e; 
    			if(!$(e.target).parent().hasClass('next-level-button') && itemLink.parents('nav').hasClass("dt-sub-menu-display-on_click")) {
    				return true;
    			}else{
    				e.stopPropagation();
    				e.preventDefault();
					if ($this.hasClass("active")){
						openIcon.attr('class', iconData);
						subMenu.stop(true, true).slideUp(500, function(){
							$(" .main-nav").layzrInitialisation();
						});
						$this.removeClass("active");
						$this.removeClass('open-sub');
						$this.find('a').removeClass('act');
					
					}else{
						openIcon.attr('class', iconDataAct);
						$this.siblings().find(" .vertical-sub-nav").stop(true, true).slideUp(400);
						subMenu.stop(true, true).slideDown(500);
						$this.siblings().removeClass("active");
						$this.addClass('active');
						$this.siblings().removeClass('open-sub');
						$this.addClass('open-sub');

						$this.siblings().find("> a").removeClass("act");
						$this.find('a').addClass('act');
						
						$(" .main-nav").layzrInitialisation();
					};
				}

			})
		});


	if(!$(".dt-parent-menu-clickable").length > 0){
		$(".sub-downwards .main-nav li > a, .mobile-main-nav li.has-children > a").each(function(){
			var $this = $(this);
			if($this.parent("li").find(".sub-nav li, .sub-menu li").hasClass("act")){
				$this.addClass('act');
			};
			if($this.parent("li").find(".sub-nav li.act, .sub-menu li.act").hasClass("act")){
				$this.parent("li").addClass('open-sub');
				$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideDown(100,function() {
					$this.siblings(".sub-nav, .sub-menu").layzrInitialisation();
				});
			};
			$this.on("click", function(e){
				$menuItem = $this.parent();
				if ($menuItem.hasClass("has-children menu-item-language")) e.preventDefault();
				
				if ($this.hasClass("act")){
					$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideUp(500);
					$this.removeClass("act");
					$this.parent("li").removeClass('open-sub');
				}else{
					$this.parent().siblings().find(".sub-nav, .dt-mega-menu-wrap, .sub-menu").stop(true, true).slideUp(400);
					$this.siblings(".sub-nav, .sub-menu").stop(true, true).slideDown(500);
					$this.parent().siblings().find("> a").removeClass("act");
					$this.addClass('act');
					$this.parent("li").siblings().removeClass('open-sub active');
					$this.parent("li").addClass('open-sub active');
					//$this.parent().layzrInitialisation();
				};
				$(".header-bar").mCustomScrollbar("update");
			});
		});

	};


	$(".custom-nav > li > a").click(function(e){
		var $menuItem = $(this).parent(),
			$this = $(this);
		if ($menuItem.hasClass("has-children")) e.preventDefault();
		
		
			if (!$this.hasClass("active")){
					$(".custom-nav > li > ul").stop(true).slideUp(400);
					$this.next().stop(true).slideDown(500);
					$(".custom-nav > li > a").removeClass("active");
					$this.addClass('active');
			}else{
					$this.next().stop(true).slideUp(500);
					$this.removeClass("active");
			}

			$menuItem.siblings().removeClass("act");
			$menuItem.addClass("act");
	});

	$(".custom-nav > li > ul").each(function(){
		clearTimeout(customTimeoutShow);
		$this = $(this);
		$thisChildren = $this.find("li");
		if($thisChildren.hasClass("act")){
			$this.prev().addClass("active");
			$this.parent().siblings().removeClass("act");
			$this.parent().addClass("act");
			$this.slideDown(500);
		}
	});

/* #Filter
================================================== */

	/*!-categories filter*/
	window.the7ApplyGeneralFilterHandlers = function($element) {
		if (!$element.exists()) {
			return;
		}

		$element.find("> a").on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();
				arguments.callee.dtPreventD = true;

				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax");
				}
			}

			e.preventDefault();

			$this.trigger("mouseleave");

			if ($this.hasClass("act") && !$this.hasClass("show-all")) {
				e.stopImmediatePropagation();
				$this.removeClass("act");
				$this.siblings("a.show-all").trigger("click");
			} else {
				$this.siblings().removeClass("act");
				$this.addClass("act");

				if ( !arguments.callee.dtPreventD ) {
					window.location.href = $this.attr("href");
				}
			}
		});
	}

	window.the7ApplyGeneralOrderingSwitchHandlers = function($element) {
		if (!$element.exists()) {
			return;
		}

		if ($element.prev(".act").length > 0) {
			$element.addClass("left-act");
		} else if ($element.next(".act").length > 0) {
			$element.addClass("right-act");
		} else {
			$element.removeClass("right-act");
			$element.removeClass("left-act");
		}

		var $filter = $element.parents(".filter").first();
		$element.on("click", function () {
			if ($filter.hasClass("without-isotope")) {
				if ($element.hasClass("right-act")) {
					$element.prev("a")[0].click();
				} else if ($element.hasClass("left-act")) {
					$element.next("a")[0].click();
				}
			} else {
				if ($element.hasClass("right-act")) {
					$element.prev("a").trigger("click");
				} else if ($element.hasClass("left-act")) {
					$element.next("a").trigger("click");
				}
			}
		});
	}

	window.the7ApplyGeneralOrderingSwitchEffects = function ($filter) {
		if (!$filter.exists()) {
			return;
		}

		var $switch = $(".filter-switch", $filter);

		$switch.append("<span class='filter-switch-toggle'></span>");

		$switch.each(function() {
			the7ApplyGeneralOrderingSwitchHandlers($(this));
		});

		$(".filter-switch .filter-switch-toggle", $filter).on("animationend webkitAnimationEnd oanimationend MSAnimationEnd", function (e) {
			$(this).parent().removeClass("pressed");
		});

		$(".filter-extras a", $filter).on("animationend webkitAnimationEnd oanimationend MSAnimationEnd", function (e) {
			$(this).removeClass("pressed");
		});

		if (Modernizr.touch) {
			$switch.on("touchstart", function (e) {
				$(".filter-switch").removeClass("pressed")
				$(this).addClass("pressed");
			});

			$(".filter-extras a", $filter).on("touchstart", function (e) {
				$(".filter-extras").removeClass("pressed")
				$(this).parent(".filter-extras").addClass("pressed");
			});
		} else {
			$switch.on("mousedown", function (e) {
				$(".filter-switch").removeClass("pressed")
				$(this).addClass("pressed");
				setTimeout(function () {
					$(this).removeClass("pressed");
				}, 600);
			});
			$(".filter-extras a", $filter).each(function () {
				$(this).on("mousedown", function (e) {
					$(".filter-extras").removeClass("pressed")
					$(this).addClass("pressed");
					setTimeout(function () {
						$(this).removeClass("pressed");
					}, 600);
				});
			});
		}

		$(".filter-extras a", $filter).on("click", function(e) {
			var $this = $(this);

			if ( typeof arguments.callee.dtPreventD == 'undefined' ) {
				var $filter = $this.parents(".filter").first();

				arguments.callee.dtPreventD = true;
				if ( $filter.hasClass("without-isotope") ) {
					arguments.callee.dtPreventD = $filter.hasClass("with-ajax");
				}
			}

			if ( arguments.callee.dtPreventD ) {
				e.preventDefault();
			}

			$this.siblings().removeClass("act");
			$this.addClass("act");

			$switch.each(function(){
				var $_this = $(this);
				if($_this.prev($this).hasClass('act')){
					$_this.addClass('left-act');
					$_this.removeClass('right-act');
				}else if($_this.next($this).hasClass('act')){
					$_this.addClass('right-act');
					$_this.removeClass('left-act');
				}else{
					$_this.removeClass('right-act');
					$_this.removeClass('left-act');
				}
			});
		});
	}

	$(".filter-categories").each(function() {
		the7ApplyGeneralFilterHandlers($(this));
	});

	$(".filter").each(function() {
		the7ApplyGeneralOrderingSwitchEffects($(this));
	});

		//List filter
		$(".mode-list .filter-categories > a:not(.show-all), .dt-css-grid-wrap .filter-categories > a:not(.show-all)").each(function(){
			$this = $(this),
			$dataFiltr = $this.attr("data-filter");
			$newDataFilter = $dataFiltr.substring(1, $dataFiltr.length);
			$this.attr("data-filter", $newDataFilter);
			$this.parents().removeClass('iso-filter');
		})

	window.the7ShortcodesFilterConfig = function ($container) {
		var config = {};

		if ($container.hasClass("dt-css-grid")) {
			config.filterControls = $container.parent().find(".filter-categories");
			config.pageControls = $container.parent().find(".paginator");
			config.sortControls = $container.parent().find(".filter-by");
			config.orderControls = $container.parent().find(".filter-sorting");
			config.defaultSort = $container.parent().find(".filter-by .act").attr("data-by");
			config.defaultOrder = $container.parent().find(".filter-sorting .act").attr("data-sort");
			config.paginationMode = $container.parent().attr("data-pagination-mode");
			config.pageLimit = $container.parent().attr("data-post-limit");
		} else {
			config.filterControls = $container.find(".filter-categories");
			config.pageControls = $container.find(".paginator");
			config.sortControls = $container.find(".filter-by");
			config.orderControls = $container.find(".filter-sorting");
			config.defaultSort = $container.find(".filter-by .act").attr("data-by");
			config.defaultOrder = $container.find(".filter-sorting .act").attr("data-sort");
			config.paginationMode = $container.attr("data-pagination-mode");
			config.pageLimit = $container.attr("data-post-limit");
		}

		config.useFilters = true;
		config.useSorting = true;
		config.controlsSelecter = "a";
		config.controlsSelecterChecked = "a.act";
		config.defaultFilter = "*";
		config.selectAll = "*";
		config.loadMoreButtonLabel = dtLocal.moreButtonText.loadMore;

		return config;
	}

		$.fn.shortcodesFilter = function(config) {
			var $el = $(this);

			$el.Filterade(config);
			$el.on('updateReady', function(){
				loadingEffects();
				$el.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
			})
			function lazyLoading() {
				if($el.hasClass("dt-css-grid")){
					$element = $el.parent();
				}else{
					$element = $el;
				}

				if( !$element.length || !$element.hasClass("lazy-loading-mode") ){
					return;
				}
				var $loadMoreButton = $element.find('.button-load-more');
				var buttonOffset = $loadMoreButton.offset();

				if ( buttonOffset && (($window.scrollTop() + $window.height()) > (buttonOffset.top - $window.height()*2))){
					$loadMoreButton.trigger('click');
				}
			}
			$window.on('scroll', function () {
				lazyLoading();
			});
			lazyLoading();
		}

		$('.blog-shortcode.mode-list.jquery-filter, .jquery-filter .dt-css-grid:not(.custom-pagination-handler)').each(function(){
			var $this = $(this);
			$this.shortcodesFilter(the7ShortcodesFilterConfig($this));
		});

/* #Images Styling & Hovers
================================================== */



/**
 * jquery.hoverdir.js v1.1.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */

    
    'use strict';

    $.HoverDir = function( options, element ) {
        
        this.$el = $( element );
        this._init( options );

    };

    // the options
    $.HoverDir.defaults = {
        speed : 300,
        easing : 'ease',
        hoverDelay : 0,
        inverse : false
    };

    $.HoverDir.prototype = {

        _init : function( options ) {
            
            // options
            this.options = $.extend( true, {}, $.HoverDir.defaults, options );
            // transition properties
            this.transitionProp = 'all ' + this.options.speed + 'ms ' + this.options.easing;
            // support for CSS transitions
            this.support = Modernizr.csstransitions;
            // load the events
            this._loadEvents();

        },
        
        _loadEvents : function() {

            var self = this;
            
            this.$el.on( 'mouseenter.hoverdir, mouseleave.hoverdir', function( event ) {
                
                var $el = $( this ),
                    $hoverElem = $el.find( '.rollover-content, .gallery-rollover, .post-entry-content' ),
                    direction = self._getDir( $el, { x : event.pageX, y : event.pageY } ),
                    styleCSS = self._getStyle( direction );
                
                if( event.type === 'mouseenter' ) {
                    
                    $hoverElem.hide().css( styleCSS.from );
                    clearTimeout( self.tmhover );

                    self.tmhover = setTimeout( function() {
                        
                        $hoverElem.show( 0, function() {
                            
                            var $el = $( this );
                            if( self.support ) {
                                $el.css( 'transition', self.transitionProp );
                            }
                            self._applyAnimation( $el, styleCSS.to, self.options.speed );

                        } );
                        
                    
                    }, self.options.hoverDelay );
                    
                }
                else {
                
                    if( self.support ) {
                        $hoverElem.css( 'transition', self.transitionProp );
                    }
                    clearTimeout( self.tmhover );
                    self._applyAnimation( $hoverElem, styleCSS.from, self.options.speed );
                    
                }
                    
            } );

        },
        // credits : http://stackoverflow.com/a/3647634
        _getDir : function( $el, coordinates ) {
            
            // the width and height of the current div
            var w = $el.width(),
                h = $el.height(),

                // calculate the x and y to get an angle to the center of the div from that x and y.
                // gets the x value relative to the center of the DIV and "normalize" it
                x = ( coordinates.x - $el.offset().left - ( w/2 )) * ( w > h ? ( h/w ) : 1 ),
                y = ( coordinates.y - $el.offset().top  - ( h/2 )) * ( h > w ? ( w/h ) : 1 ),
            
                // the angle and the direction from where the mouse came in/went out clockwise (TRBL=0123);
                // first calculate the angle of the point,
                // add 180 deg to get rid of the negative values
                // divide by 90 to get the quadrant
                // add 3 and do a modulo by 4  to shift the quadrants to a proper clockwise TRBL (top/right/bottom/left) **/
                direction = Math.round( ( ( ( Math.atan2(y, x) * (180 / Math.PI) ) + 180 ) / 90 ) + 3 ) % 4;
            
            return direction;
            
        },
        _getStyle : function( direction ) {
            
            var fromStyle, toStyle,
                slideFromTop = { left : '0px', top : '-100%' },
                slideFromBottom = { left : '0px', top : '100%' },
                slideFromLeft = { left : '-100%', top : '0px' },
                slideFromRight = { left : '100%', top : '0px' },
                slideTop = { top : '0px' },
                slideLeft = { left : '0px' };
            
            switch( direction ) {
                case 0:
                    // from top
                    fromStyle = !this.options.inverse ? slideFromTop : slideFromBottom;
                    toStyle = slideTop;
                    break;
                case 1:
                    // from right
                    fromStyle = !this.options.inverse ? slideFromRight : slideFromLeft;
                    toStyle = slideLeft;
                    break;
                case 2:
                    // from bottom
                    fromStyle = !this.options.inverse ? slideFromBottom : slideFromTop;
                    toStyle = slideTop;
                    break;
                case 3:
                    // from left
                    fromStyle = !this.options.inverse ? slideFromLeft : slideFromRight;
                    toStyle = slideLeft;
                    break;
            };
            
            return { from : fromStyle, to : toStyle };
                    
        },
        // apply a transition or fallback to jquery animate based on Modernizr.csstransitions support
        _applyAnimation : function( el, styleCSS, speed ) {

            $.fn.applyStyle = this.support ? $.fn.css : $.fn.animate;
            el.stop().applyStyle( styleCSS, $.extend( true, [], { duration : speed + 'ms' } ) );

        },

    };
    
    var logError = function( message ) {

        if ( window.console ) {

            window.console.error( message );
        
        }

    };
    
    $.fn.hoverdir = function( options ) {

        var instance = $.data( this, 'hoverdir' );
        
        if ( typeof options === 'string' ) {
            
            var args = Array.prototype.slice.call( arguments, 1 );
            
            this.each(function() {
            
                if ( !instance ) {

                    logError( "cannot call methods on hoverdir prior to initialization; " +
                    "attempted to call method '" + options + "'" );
                    return;
                
                }
                
                if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

                    logError( "no such method '" + options + "' for hoverdir instance" );
                    return;
                
                }
                
                instance[ options ].apply( instance, args );
            
            });
        
        } 
        else {
        
            this.each(function() {
                
                if ( instance ) {

                    instance._init();
                
                }
                else {

                    instance = $.data( this, 'hoverdir', new $.HoverDir( options, this ) );
                
                }

            });
        
        }
        
        return instance;
        
    };

	/* !Append tag </i> to rolovers*/
	$.fn.addRollover = function() {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("this-ready")) {
				return;
			}

			$this.append("<i></i>");
			if($this.find(".rollover-thumbnails").length){
				$this.addClass("rollover-thumbnails-on");
			}
			if($this.parent().find(".links-container").length){
				$this.addClass("rollover-buttons-on");
			}

			$this.addClass("this-ready");
		});
	};

	/* #Hover layouts
	================================================== */

	/*!-Scale in hover*/
	$.fn.scaleInHover = function() {
		return this.each(function() {

			var $this = $(this);
			if ($this.hasClass("scale-ready")) {
				return;
			}
			var $img = $this.find("img.preload-me"),
				imgWidth = parseInt($img.attr('width')),
				imgHeight = parseInt($img.attr('height')),
				imgRatio = imgWidth/imgHeight;
			if(imgRatio < 2 && imgRatio >= 1.5){
				$this.addClass("ratio_3-2");
			}else if(imgRatio < 1.5 && imgRatio >= 1){
				$this.addClass("ratio_4-3");
			}else if(imgRatio < 1 && imgRatio >= 0.75){
				$this.addClass("ratio_3-4");
			}else if(imgRatio < 0.75 && imgRatio >= 0.6){
				$this.addClass("ratio_2-3");
			}else{
				$this.removeClass("ratio_2-3").removeClass("ratio_3-2").removeClass("ratio-2").removeClass("ratio_4-3").removeClass("ratio_3-4");
			};
			if(imgRatio >= 2){
				$this.addClass("ratio-2");
			};
			if(imgRatio == 0.5){
				$this.addClass("ratio_0-5");
			};
			if(imgRatio == 1){
				$this.removeClass("ratio_2-3").removeClass("ratio-2").removeClass("ratio_3-2").removeClass("ratio_4-3").removeClass("ratio_3-4");
			};

			$this.addClass("scale-ready");
		});
	};

	$.fn.touchNewHover = function() {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("this-ready")) {
				return;
			}

			if( $(".rollover-content", this).length > 0 ){
				$body.on("touchend", function(e) {
					$(".mobile-true .rollover-content, .mobile-true .rollover-project, .mobile-true .woocom-project").removeClass("is-clicked");
				});
				
				$this.on("touchstart", function(e) {
					origY = e.originalEvent.touches[0].pageY;
					origX = e.originalEvent.touches[0].pageX;
				});
				$this.on("touchend", function(e) {
					var touchEX = e.originalEvent.changedTouches[0].pageX,
						touchEY = e.originalEvent.changedTouches[0].pageY;
					if( origY == touchEY || origX == touchEX ){
			
						if ($this.hasClass("is-clicked")) {
							if($this.find(".dt-gallery-container").length > 0){
								$this.find(".rollover-content").on("click.dtAlbums", function(e){
									$this.find(".rollover-content").off("click.dtAlbums");
									$(this).find("a.dt-gallery-pspw, .dt-trigger-first-pspw, .dt-pswp-item").first().trigger('click');
								});
							}
							if($(this).find(".rollover-click-target.go-to").length > 0){
								window.location.href = $(this).find(".rollover-click-target.go-to").attr('href');
							}else if($(this).hasClass("woocom-project")){
								if ( $(e.target).is(".add_to_cart_button") ) {
									return true
								}else{
									window.location.href = $(this).find(" > a").attr('href');
								}
							}
						} else {

							$('.links-container > a', $this).on('touchend', function(e) {
								e.stopPropagation();
								$this.addClass("is-clicked");
							});
							e.preventDefault();
							$(".mobile-true .rollover-content, .mobile-true .rollover-project,.mobile-true .woocom-project").removeClass("is-clicked");
							$this.addClass("is-clicked");
							$this.find(".rollover-content").addClass("is-clicked");
							return false;
						};
					};
				});
			};

			$this.addClass("this-ready");
		});
	};



	/*!Trigger post click for blog Overlay (background)/Overlay (gradient) layouts */
    $.fn.triggerPostClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("post-ready")) {
                return;
            }

            var $thisSingleLink = $this.find(".post-thumbnail-rollover").first(),
                $thisCategory = $this.find(".entry-meta a, .fancy-date a, .fancy-categories a");

            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                });

                var alreadyTriggered = false;

                $this.on("click", function(){

                    if ($this.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;

                    if ( !alreadyTriggered ) {
                        alreadyTriggered = true;

                       // $thisSingleLink.trigger("click");
                         window.location.href = $thisSingleLink.attr('href');
                        
                        alreadyTriggered = false;
                    }
                    return false;
                })
                $this.find($thisCategory).click(function(e) {

                     e.stopPropagation();
                    window.location.href = $thisCategory.attr('href');
                });
            }
            $this.addClass("post-ready");
        });
    };

   $.fn.touchTriggerPostClick = function() {
        return this.each(function() {
            var $this = $(this);
            if ($this.hasClass("touch-post-ready")) {
                return;
            }
            var $thisSingleLink = $this.find(".post-thumbnail-rollover").first(),
			    $thisCategory = $this.find(".entry-meta a, .fancy-date a, .fancy-categories a"),
			    $thisOfTop = $this.find(".entry-excerpt").height() + $this.find(".post-details").height();

            $body.on("touchend", function(e) {
                $(".mobile-true .post").removeClass("is-clicked");
            });
          
            $this.on("touchstart", function(e) { 
                origY = e.originalEvent.touches[0].pageY;
                origX = e.originalEvent.touches[0].pageX;
            });
            $this.on("touchend", function(e) {
                var touchEX = e.originalEvent.changedTouches[0].pageX,
                    touchEY = e.originalEvent.changedTouches[0].pageY;
                if( origY == touchEY || origX == touchEX ){
                	if($this.parents().hasClass("disable-layout-hover")){
                		if(e.target.tagName.toLowerCase() === 'a'){
                			$(e.target).trigger("click");
                		}else{
                			window.location.href = $thisSingleLink.attr('href');
                		}
                	}else {
						 if ($this.hasClass("is-clicked")) {
	                            window.location.href = $thisSingleLink.attr('href');
	                    } else {
	                        e.preventDefault();
	                       	if(e.target.tagName.toLowerCase() === 'a'){
	                			$(e.target).trigger("click");
	                		}
	                        $(".mobile-ture .post").removeClass("is-clicked");
	                        $this.addClass("is-clicked");
	                        $this.parent().siblings().find(".post").removeClass("is-clicked");
	                        return false;
	                    };
	                };
                };
            });

            $this.addClass("touch-post-ready");
        });
    };
	
    //Gradient overlap layout
	 $.fn.triggerPostClickOnBefore = function() {
        return this.each(function() {
            var $this = $(this),
            	$thisPar = $this.parents(".post");
            if ($this.hasClass("post-before-ready")) {
                return;
            }

            var $thisSingleLink = $thisPar.find(".post-thumbnail-rollover").first(),
                $thisCategory = $thisPar.find(".entry-meta a, .fancy-date a, .fancy-categories a");

            if( $thisSingleLink.length > 0 ){
                $thisSingleLink.on("click", function(event) {
                    // event.preventDefault();
                    // event.stopPropagation();
                     if ($thisSingleLink.parents(".ts-wrap").hasClass("ts-interceptClicks")) return;
                });

                var alreadyTriggered = false;
                $this.on("mouseenter mousemove", function(e){
                	var elOfTop = $this.offset().top,
                		origY = e.pageY;
                	if((elOfTop - 10) <= origY && (elOfTop + 125) >= (origY)){
                		if(!$thisPar.hasClass("on-hover")){
                			$thisPar.addClass("on-hover");
                		}
                	}else{
                		$thisPar.removeClass("on-hover");
                	}
                });
                
                $this.on("mouseleave", function(e) {
                	var elOfTop = $this.offset().top,
                		origY = e.pageY;
                	$thisPar.removeClass("on-hover");
                });

                $this.on("click", function(){

                   if($thisPar.hasClass("on-hover")){
	                    if ( !alreadyTriggered ) {
	                        alreadyTriggered = true;
	                         window.location.href = $thisSingleLink.attr('href');
	                        
	                        alreadyTriggered = false;
	                    }
	                    return false;
	                }
                })
                $this.find($thisCategory).click(function(e) {
                	if($thisPar.hasClass("on-hover")){
	                    e.stopPropagation();
	                    window.location.href = $thisCategory.attr('href');
	                }
                });
            }
            $this.addClass("post-before-ready");
        });
    };

    window.the7AddHovers = function ($context) {
        $(".rollover, .rollover-video, .post-rollover, .rollover-project .show-content, .vc-item .vc-inner > a", $context).addRollover();
        /* !- Grayscale */
        $(".filter-grayscale .slider-masonry", $context).on("mouseenter tap", function (e) {
            if (e.type == "tap") {
                e.stopPropagation();
            }
            $(this).addClass("dt-hovered");
        });
        $(".filter-grayscale .slider-masonry", $context).on("mouseleave", function (e) {
            $(this).removeClass("dt-hovered");
        });
        $(".hover-scale .rollover-project, .hover-scale .post", $context).scaleInHover();
    };

    window.the7AddMobileHovers = function($context) {
        /*TOUCH DEVICE*/
        /*!Description on hover show content on click(albums projects touch device)*/
        $(".rollover-project, .woocom-project", $context).touchNewHover();
        $(".content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post", $context).touchTriggerPostClick();
    };

    window.the7AddDesktopHovers = function($context) {
        /*!-Hover Direction aware init*/
        $(".hover-grid.gallery-shortcode figure, .hover-grid .rollover-project, .hover-grid.portfolio-shortcode .post", $context).each(function () {
            $(this).hoverdir();
        });
        $(".hover-grid-reverse.gallery-shortcode figure, .hover-grid-reverse .rollover-project, .hover-grid-reverse.portfolio-shortcode .post", $context).each(function () {
            $(this).hoverdir({
                inverse: true
            });
        });

        $(".albums .rollover-content a:not(.portfolio-categories a), .media .rollover-content, .dt-gallery-container .rollover-content", $context).on("click", function (e) {
            if ($(e.target).is("a")) {
                return true
            }
            $(this).siblings("a.dt-pswp-item").first().click();
        });
        $(".content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post", $context).triggerPostClick();
        $(".gradient-overlap-layout-list:not(.portfolio-shortcode):not(.albums-shortcode)  .post-entry-content", $context).triggerPostClickOnBefore();
    };

    the7AddMobileHovers($("html.mobile-true"));
    the7AddDesktopHovers($("html.mobile-false"));
    the7AddHovers(document);

/* #Comment form
================================================== */
	var $commentForm = $('#commentform');

	$commentForm.on('click', 'a.clear-form', function (e) {
		e.preventDefault();
		$commentForm.find('input[type="text"], textarea').val('');
		return false;
	});

	$commentForm.on('click', ' a.dt-btn.dt-btn-m', function(e) {
		e.preventDefault();
		$commentForm.find('#submit').trigger('click');
		return false;
	});

	

/* #Fullwidth row for shortcodes & templates
================================================== */
	function fullWidthWrap(){
		if( $(".full-width-wrap").length > 0 ){
			$(".full-width-wrap").each(function(){
				var $_this = $(this),
					windowInnerW = window.innerWidth,
					windowW = $window.width(),
					contentW = $('.content').width();

					var $offset_fs,
						$width_fs;
				 
					if ($('.boxed').length > 0) {
						$offset_fs = ((parseInt($('#main').width()) - parseInt(contentW)) / 2);
					}
					else if ($('.side-header-v-stroke').length && windowInnerW > dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off") || $('.side-header-v-stroke').length && $body.hasClass("responsive-off")){
						var $windowWidth = (windowInnerW <= parseInt(contentW)) ? parseInt(contentW) : (windowW - $('.side-header-v-stroke').width());
						$offset_fs = Math.ceil( (($windowWidth - parseInt(contentW)) / 2) );
					}
					else if ($('.sticky-header .side-header').length && windowInnerW > dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off") || $('.sticky-header .side-header').length && $body.hasClass("responsive-off")){
						var $windowWidth = (windowW <= parseInt(contentW)) ? parseInt(contentW) : windowW;
						$offset_fs = Math.ceil( ((windowW - parseInt(contentW)) / 2) );
					}
					else if (($('.header-side-left').length && windowInnerW || $('.header-side-right').length && windowInnerW ) > dtLocal.themeSettings.mobileHeader.firstSwitchPoint){
						var $windowWidth = (windowInnerW <= parseInt(contentW)) ? parseInt(contentW) : (windowW - $('.side-header').width());
						$offset_fs = Math.ceil( (($windowWidth - parseInt(contentW)) / 2) );
					}
					else {
						var $windowWidth = (windowW <= parseInt(contentW)) ? parseInt(contentW) : windowW;
						$offset_fs = Math.ceil( ((windowW - parseInt(contentW)) / 2) );
					};

					if($('.sidebar-left').length > 0 || $('.sidebar-right').length > 0){
						$width_fs = $(".content").width();
						$offset_fs = 0;
					}else{
						$width_fs = $("#main").innerWidth();
					}
					var $marginSide = $body.hasClass("rtl") ? "margin-right" : "margin-left";
					$_this.css({
						width: $width_fs,
						//$marginSide: -$offset_fs,
						"opacity": 1
					});
					$_this.css($marginSide, -$offset_fs);
					$_this.find(".full-width-wrap").css({
						width: "",
						//$marginSide: "",
						"opacity": 1,
						"padding-left": $offset_fs
					});
					$_this.find(".full-width-wrap").css($marginSide, "");

					$_this.find(".ts-wrap").each(function(){
						var scroller = $(this).data("thePhotoSlider");
						if(typeof scroller!= "undefined"){
							scroller.update();
						};
					});
					
			});
		};
	};

	if( $(".full-width-wrap").length > 0 ){
		if(dtGlobals.isiOS){
			$window.bind("orientationchange", function() {
				fullWidthWrap();
			}).trigger( "orientationchange" );
		}
		else {
			$window.on("resize", function(){
				fullWidthWrap();
			});
			fullWidthWrap();
		};
	};
	

/* #Misc
================================================== */

	$window.trigger("dt.removeLoading");

	var $mainSlideshow = $("#main-slideshow");
	if(!$mainSlideshow.find("> div").length > 0){
		$mainSlideshow.addClass("empty-slider");
	};
	/*!-Revolution slider*/
	if ($(".rev_slider_wrapper").length > 0){
		if( $mainSlideshow.find("> .rev_slider_wrapper")){
			$mainSlideshow.addClass("fix rv-slider");
		};
		if ($(".rev_slider_wrapper").hasClass("fullscreen-container") || $(".rev_slider_wrapper").hasClass("fullwidthbanner-container")){
			$mainSlideshow.removeClass("fix");
		};
	};





	/*!-Search*/
	var $header = $(".masthead, .dt-mobile-header");
	var $searchMicrowidget = $(".popup-search", $header);
	if($searchMicrowidget.length > 0){

		$body.on("click", function(e){
			var target = $(e.target);
			if(!target.is(".field", $searchMicrowidget)) {
				$(".searchform .submit", $header).removeClass("act");
				$searchMicrowidget.removeClass("act");
				//$(".mini-search .field", $header).fadeOut(100);
				$(".popup-search-wrap", $searchMicrowidget).stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				setTimeout(function() {
					$(".popup-search-wrap", $searchMicrowidget).removeClass("right-overflow bottom-overflow left-overflow").css({
						right: "",
						left: "",
						'max-width': ""
					});
				}, 400);
			}
		})
		$(".searchform .submit", $header).on("click", function(e){
			e.preventDefault();
			e.stopPropagation();
			var $_this = $(this);
			if($_this.hasClass("act")){
				$_this.removeClass("act");
				$_this.parents(".mini-search").removeClass("act");
				$_this.siblings(".popup-search-wrap").stop().animate({
					"opacity": 0
				}, 150, function() {
					$(this).css("visibility", "hidden");
				});
				setTimeout(function() {
					$_this.siblings(".popup-search-wrap").removeClass("right-overflow bottom-overflow left-overflow").css({
						right: "",
						left: "",
						'max-width': ""
					});
				}, 400);
			}else{
				$_this.addClass("act");
				$_this.parents(".mini-search").addClass("act");
				if($_this.parents(".dt-mobile-header").length > 0) {
					$_this.siblings(".popup-search-wrap").css({
						top: $_this.parents(".mini-search").position().top  - $_this.siblings(".popup-search-wrap").innerHeight()
					});

				}
				if ($_this.parents(".searchform").offset().left - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("left-overflow");
				};
				if ($page.width() - ($_this.parents(".searchform").offset().left - $page.offset().left) - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("right-overflow");
					$_this.siblings(".popup-search-wrap").removeClass("left-overflow");
				}
				if ($page.width() - ($_this.parents(".searchform").offset().left - $page.offset().left) - $_this.siblings(".popup-search-wrap").innerWidth() < 0 && $_this.parents(".searchform").offset().left - $_this.siblings(".popup-search-wrap").innerWidth() < 0) {
					$_this.siblings(".popup-search-wrap").css({
						'max-width': $_this.parents(".searchform").offset().left
					})
				}
				/*Bottom overflow menu*/
				if ($window.height() - ($_this.siblings(".popup-search-wrap").offset().top - dtGlobals.winScrollTop) - $_this.siblings(".popup-search-wrap").innerHeight() < 0) {
					$_this.siblings(".popup-search-wrap").addClass("bottom-overflow");
				};
				$_this.siblings(".popup-search-wrap").stop().css("visibility", "visible").animate({
					"opacity": 1
				}, 150)
				$_this.siblings(".popup-search-wrap").find("input.searchform-s").focus();

			}
		});
	}

	if($(".overlay-search").length > 0){
		var searchHtml = $(".overlay-search .searchform").first(),
			searchHtmlClone = searchHtml.clone();
		$("body").append("<div class='overlay-search-microwidget'><i class='overlay-close icomoon-the7-font-the7-cross-01'></i></div>");

		var overlay = $(".overlay-search-microwidget");
		overlay.append(searchHtmlClone);
		if($(".overlay-search").hasClass('default-icon')){
			overlay.addClass('default-icon');
		}
		$(".mini-search .submit").on("click", function(e){
			e.preventDefault();
			overlay.addClass("open");
			$("#page").addClass("overlay-open");

			overlay.find("input.searchform-s").focus();
		});
		$(".overlay-close", overlay).on("click", function(){
			$("#page").removeClass("overlay-open");
			$(this).parent(overlay).removeClass("open");

		});
	}



	/* #Shortcodes
	================================================== */


	/*!-Before After*/
	$(".twentytwenty-container .preload-me").loaded(null, function() {
		$(".twentytwenty-container").each(function(){
			var $this = $(this),
				$thisOrient = $this.attr("data-orientation").length > 0 ? $this.attr("data-orientation") : 'horizontal',
				$pctOffset = (typeof $this.attr("data-offset") != 'undefined' && $this.attr("data-offset").length > 0) ? $this.attr("data-offset") : 0.5,
				$navigationType = $this.attr("data-navigation") ? true : false;
			$this.twentytwenty({
				default_offset_pct: $pctOffset,
				orientation: $thisOrient,
				navigation_follow: $navigationType
			});
		});
	}, true);

	/*!-Isotope fix for tabs*/
	if($('.wpb_tabs .iso-container').length > 0){
		var tabResizeTimeout;
		$('.wpb_tour_tabs_wrapper').each(function(){
			var $this = $(this),
				isoInside = $this.parents(".wpb_tabs").find(".iso-container");
			$this.tabs( {
				activate: function( event, ui ) {
					isoInside.isotope("layout");
				}
			});
			$this.find("li").each(function(){
				$(this).on("click", function(){
					clearTimeout(tabResizeTimeout);
					$window.trigger( "debouncedresize" );
					$(this).parents(".wpb_tabs").find(".iso-container").isotope("layout");
				});
			});
		});
	}


	/* #Widgets
	================================================== */


	// /*!Instagram style photos*/

	$.fn.calcPics = function() {
			var $collection = $(".instagram-photos");
			if ($collection.length < 1) return false;

			return this.each(function() {
				var maxitemwidth = maxitemwidth ? maxitemwidth : parseInt($(this).attr("data-image-max-width")),
					itemmarg = parseInt($(this).find("> a").css("margin-left"));
				$(this).find(" > a").css({
					"max-width": maxitemwidth,
					"opacity": 1
				});

				// Cahce everything
				var $container = $(this),
					containerwidth = $container.width(),
					itemperc = (100/(Math.ceil(containerwidth/maxitemwidth)));

				$container.find("a").css({ "width": itemperc+'%' });
		});
	};
	$(".instagram-photos").calcPics();

	$('.st-accordion').each(function(){
		var accordion = $(this);
		accordion.find('ul > li > a').on("click", function(e){
			e.preventDefault();
			var $this = $(this),
				$thisNext = $this.next();
			$(".st-content", accordion).not($thisNext).slideUp('fast');
			$thisNext.slideToggle('fast');
		});
	});
	simple_tooltip(".shortcode-tooltip","shortcode-tooltip-content");

	/*!-search widget*/
	$('.widget .searchform .submit, .search-icon, form.searchform:not(.mini-widget-searchform) .submit').on('click', function(e) {
		e.preventDefault();
		$(this).closest('form').find('input.searchsubmit').click();
		return false;
	});

	// !- Skills
	$.fn.animateSkills = function() {
		$(".skill-value", this).each(function () {
			var $this = $(this),
				$this_data = $this.data("width");

			$this.css({
				width: $this_data + '%'
			});
		});
	};

	// !- Animation "onScroll" loop
	function doSkillsAnimation() {

		if(dtGlobals.isMobile){
			$(".skills").animateSkills();
		}
	};
	// !- Fire animation
	doSkillsAnimation();


	/* #Posts
	================================================== */
	var socTimeoutShow,
		socTimeoutHide;

	/*!-Show share buttons*/
	$(".project-share-overlay.allways-visible-icons .share-button").on("click", function(e){
		e.preventDefault();
	});
	//Solve multiple window.onload conflict
	function addOnloadEvent(fnc){
	  if ( typeof window.addEventListener != "undefined" )
		window.addEventListener( "load", fnc, false );
	  else if ( typeof window.attachEvent != "undefined" ) {
		window.attachEvent( "onload", fnc );
	  }
	  else {
		if ( window.onload != null ) {
		  var oldOnload = window.onload;
		  window.onload = function ( e ) {
			oldOnload( e );
			window[fnc]();
		  };
		}
		else
		  window.onload = fnc;
	  }
	}
	function showShareBut() {
		$(".album-share-overlay, .project-share-overlay:not(.allways-visible-icons)").each(function(){
			var $this = $(this);
			$this.find(".share-button").on("click", function(e){
				e.preventDefault();
			});

			$this.on("mouseover tap", function(e) {
				if(e.type == "tap") e.stopPropagation();

				var $this = $(this);
				$this.addClass("dt-hovered");

				clearTimeout(socTimeoutShow);
				clearTimeout(socTimeoutHide);

				socTimeoutShow = setTimeout(function() {
					if($this.hasClass("dt-hovered")){
						$this.find('.soc-ico a').css("display", "inline-block");
						$this.find('.soc-ico').stop().css("visibility", "visible").animate({
							"opacity": 1
						}, 200);
					}
				}, 100);
			});

			$this.on("mouseleave ", function(e) {
				var $this = $(this);
				$this.removeClass("dt-hovered");

				clearTimeout(socTimeoutShow);
				clearTimeout(socTimeoutHide);

				socTimeoutHide = setTimeout(function() {
					if(!$this.hasClass("dt-hovered")){
						$this.find('.soc-ico').stop().animate({
							"opacity": 0
						}, 150, function() {
							$this.find('.soc-ico a').css("display", "none");
							$(this).css("visibility", "hidden");
						});
					}
				}, 50);

			});
		});
	};
	addOnloadEvent(function(){ showShareBut() });

	/*!-Project floating content*/
	var $floatContent = $(".floating-content"),
		projectPost = $(".project-post");
	var $parentHeight,
		$floatContentHeight,
		phantomHeight = 0;

	//var $scrollHeight;

	function setFloatinProjectContent() {
		$(".preload-me").loaded(null, function() {
			var $sidebar = $(".floating-content");
			var $parentHeight = $floatContent.siblings(".project-wide-col").height();
        	var $floatContentHeight = $floatContent.height();
			if ($(".floating-content").length > 0) {
				var offset = $sidebar.offset();
				if($topBar.length > 0 && $(".phantom-sticky").length > 0){
					var topBarH = $topBar.height();
				}else{
					var topBarH = 0;
				}
					//$scrollHeight = $(".project-post").height();
				var $scrollOffset = $(".project-post").offset();
				//var $headerHeight = $phantom.height();
				$window.on("scroll", function () {
					if (window.innerWidth > 1050) {
						if (dtGlobals.winScrollTop + $phantom.height() > offset.top) {
							if (dtGlobals.winScrollTop + $phantom.height() + $floatContentHeight + 40 < $scrollOffset.top + $parentHeight) {
								$sidebar.css(
									'transform', 'translateY(' + (dtGlobals.winScrollTop - offset.top + $phantom.height() + 5 - topBarH) + 'px)'
								);
							} else {
								$sidebar.css(
									'transform', 'translateY(' + ($parentHeight - $floatContentHeight - 40 - topBarH) + 'px)'
								);
							}
						} else {
							$sidebar.css(
								'transform', 'translateY(0px)'
							);
						}
					} else {
						$sidebar
							.css({
								"transform": "translateY(0)",
							});
					}
				})
			}
		}, true);
	}
	setFloatinProjectContent();

	
	/* !Fancy header*/
	var fancyFeaderOverlap = $(".transparent #fancy-header").exists(),
		titleOverlap = $(".transparent .page-title").exists(),
		checkoutOverlap = $(".transparent .checkout-page-title").exists();


	$.fancyFeaderCalc = function() {
		$(".branding .preload-me").loaded(null, function() {
			if (fancyFeaderOverlap) {
				$(".transparent #fancy-header").css({
					"padding-top" : $(".masthead:not(.side-header)").height()
				});
			};
			if (titleOverlap) {
				$(".transparent .page-title").css({
					"padding-top" : $(".masthead:not(.side-header)").height()
				});
				$(".transparent .page-title").css("visibility", "visible");
			};
		}, true);
	};


	/*!-Paginator*/
	var $paginator = $('.paginator[role="navigation"]'),
		$dots = $paginator.find('a.dots');
	$dots.on('click', function() {
		$paginator.find('div:hidden').show().find('a').unwrap();
		$dots.remove();
	});

	// pin it
	$(".share-buttons a.pinit-marklet").click(function(event){
		event.preventDefault();
		$("#pinmarklet").remove();
		var e = document.createElement('script');
		e.setAttribute('type','text/javascript');
		e.setAttribute('charset','UTF-8');
		e.setAttribute('id','pinmarklet');
		e.setAttribute('async','async');
		e.setAttribute('defer','defer');
		e.setAttribute('src','//assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e);
	});

	/*!-Scroll to Top*/
	$window.on("debouncedresize", function() {
		if(window.innerWidth  > dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off") || $body.hasClass("responsive-off")) {
			if($(".masthead:not(.side-header):not(.mixed-header)").length > 0){
				dtGlobals.showTopBtn = $(".masthead:not(.side-header):not(.mixed-header)").height() + 150;
			}else if($(".masthead.side-header-h-stroke").length > 0){
				dtGlobals.showTopBtn = $(".side-header-h-stroke").height() + 150;
			}else{
				dtGlobals.showTopBtn = 500;
			}
		}else{
			dtGlobals.showTopBtn = 500;
		}
	});
	$window.scroll(function () {
		
		if (dtGlobals.winScrollTop > dtGlobals.showTopBtn) {
			$('.scroll-top').removeClass('off').addClass('on');
		}
		else {
			$('.scroll-top').removeClass('on').addClass('off');
		}
	});
	$(".scroll-top").click(function(e) {
		e.preventDefault();
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});

	var $dtscrollElement  = $( '.woocommerce-NoticeGroup-updateOrderReview, .woocommerce-NoticeGroup-checkout' );
	if ( ! $dtscrollElement.length && $( 'form.checkout' ).exists() ) {
		$dtscrollElement = $( 'form.checkout' ).parents('.content').offset().top;
	}
	//$.scroll_to_notices( scrollElement );
	$( document.body ).on( 'checkout_error', function() {
	   // jQuery( 'html, body' ).scrollTop($dtscrollElement - 50);
	    $("html, body").animate({ scrollTop: $dtscrollElement - ($headerBar, $phantom).height() }, "slow");
	} );

	/*!-Custom select*/

	// Create the dropdown base
	$("<select aria-label=\"Dropdown menu\"/>").prependTo("#bottom-bar .mini-nav .menu-select");

	// Create default option "Select"
	$("<option />", {
		"selected"  :  "selected",
		"value"     :  "",
		"text"      :  "———"
	}).appendTo(".mini-nav .menu-select select");

	// Populate dropdown with menu items
	$("#bottom-bar .mini-nav").each(function() {
		var elPar = $(this),
			thisSelect = elPar.find("select");
		$("a", elPar).each(function() {
			var el = $(this);
			$("<option />", {
				"value"   : el.attr("href"),
				"text"    : el.text(),
				"data-level": el.attr("data-level")
			}).appendTo(thisSelect);
		});
	});

	$(".mini-nav select").change(function() {
		window.location = $(this).find("option:selected").val();
	});
	$(".mini-nav select option").each(function(){
		var $this = $(this),
			winHref = window.location.href;
		 if($this.attr('value') == winHref){
			$this.attr('selected','selected');
		};
	})
	/*!-Appearance for custom select*/
	$(' #bottom-bar .mini-nav select').each(function(){
		$(this).customSelect();
	});
	$(".menu-select select, .mini-nav .customSelect1, .vc_pie_chart .vc_pie_wrapper").css("visibility", "visible");

	$(".mini-nav option").each(function(){
		var $this	= $(this),
			text	= $this.text(),

			prefix	= "";

		switch ( parseInt($this.attr("data-level"))) {
			case 1:
				prefix = "";
			break;
			case 2:
				prefix = "— ";
			break;
			case 3:
				prefix = "—— ";
			break;
			case 4:
				prefix = "——— ";
			break;
			case 5:
				prefix = "———— ";
			break;
		}
		$this.text(prefix+text);
	});

	/*!-Material click for menu and buttons*/
	var ua = navigator.userAgent,
		event = (ua.match(/iPhone/i)) ? "touchstart" : "click";

	$(".project-navigation a, .mobile-sticky-header-overlay").bind(event, function(e) {});

	

	

	$(function(){
		$.fn.clickMaterialEffect = function() {
			return this.each(function() {
				var ink, d, x, y;
				var $this = $(this),
			        $this_timer = null,
			         $link_timer = null;
				if($this.find(".ink").length === 0){
					$this.prepend("<span class='ink'></span>");
				}
				
				$this.addClass("ripplelink");

				ink = $this.find(".ink");
				ink.removeClass("animate");

				if(!ink.height() && !ink.width()){
					d = Math.max($(this).outerWidth(), $this.outerHeight());
					ink.css({height: d, width: d});
				}
				
				$this.bind( 'mousedown', function( e ) {
					clearTimeout( $this_timer );
					x = e.pageX - $this.offset().left - ink.width()/2;
					y = e.pageY - $this.offset().top - ink.height()/2;

						ink.css({top: y+'px', left: x+'px'}).addClass("animate");

				} );
				$this.bind( 'mouseup mouseleave', function( e ) {
					clearTimeout( $link_timer );
					clearTimeout( $this_timer );
					$this._timer = setTimeout( function() {
						ink.removeClass("animate");
					},400)
				} );
				
			});
		};

		$(".rollover.material-click-effect, .post-rollover.material-click-effect, .rollover-video.material-click-effect").clickMaterialEffect();
	});

	/* #Misc(desctop only)
	================================================== */
	
		
	if(!dtGlobals.isMobile){
			/*!-parallax initialisation*/
		$('.stripe-parallax-bg, .fancy-parallax-bg, .page-title-parallax-bg').each(function(){
			var $_this = $(this),
				speed_prl = $_this.data("prlx-speed");
			$_this.parallax("50%", speed_prl);
			$_this.addClass("parallax-bg-done");
			$_this.css("opacity", "1")
		});
	

		/*!-Animate fancy header elements*/
		var j = -1;
		$("#fancy-header .fancy-title:not(.start-animation), #fancy-header .fancy-subtitle:not(.start-animation), #fancy-header .breadcrumbs:not(.start-animation)").each(function () {
			var $this = $(this);
			var animateTimeout;
			if (!$this.hasClass("start-animation") && !$this.hasClass("start-animation-done")) {
				$this.addClass("start-animation-done");
				j++;
				setTimeout(function () {
					$this.addClass("start-animation");
					
				}, 300 * j);
			};
		});
	};

	jQuery('.wpcf7').each(function(){
		var $this = $(this);
		$this.on('wpcf7submit', function(e) {
			$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>").addClass('run-animation');
			setTimeout(function() {
				$this.find(".wpcf7-response-output").removeClass('run-animation');
			},12000);
		})
		$this.on('wpcf7invalid', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>")
			},100);
		});
		$this.on('wpcf7mailsent', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-response-output").wrapInner( "<div class='wpcf7-valid-tip-text'></div>").addClass('wpcf7-mail-sent-ok')
			},100);
			setTimeout(function() {
				$this.find(".wpcf7-response-output").removeClass('wpcf7-mail-sent-ok');
			},12000);
		});
		$this.on('invalid.wpcf7', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-validation-errors").wrapInner( "<div class='wpcf7-not-valid-tip-text'></div>")
			},100);
		});
		$this.on('mailsent.wpcf7', function(e) {
    		setTimeout(function() {
				$this.find(".wpcf7-mail-sent-ok").wrapInner( "<div class='wpcf7-valid-tip-text'></div>")
			},100);
		});
	});




	/* #sidebar sticky
	================================================== */
	if($(".dt-sticky-sidebar").length > 0 ){
		if (headerDocked) {
			var $headerBar = $(".sticky-on");
		}else{
			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar");
		}
		if ($topBar.exists() && !$topBar.is( ":hidden" ) && !$topBar.hasClass( "top-bar-empty" )  && !$topBar.hasClass( "hide-top-bar" ) ) {
			topBarH = $topBar.innerHeight();
		}else {
			topBarH = 0;
		};
		if( phantomFadeExists || phantomSlideExists) {
			var headerHeight = $($phantom).height() + 20;
		}else if(dtLocal.themeSettings.floatingHeader.showMenu && phantomStickyExists) {
			if($body.hasClass("floating-top-bar")){
				var headerHeight = dtLocal.themeSettings.floatingHeader.height + topBarH + 20;
			}else{
				var headerHeight = dtLocal.themeSettings.floatingHeader.height + 20;
			}
		}else if(stickyTopLine.exists()){
			var headerHeight = stickyTopLine.find('.header-bar').height() + topBarH + 20
		}else{
			var headerHeight = 0;
		}
		

		var stickySidebar = new StickySidebar('#sidebar', {
			topSpacing: headerHeight,
			bottomSpacing: 20,
			viewportTop: 0,
			containerSelector: '.wf-container-main',
			innerWrapperSelector: '.sidebar-content',
			minWidth: dtLocal.themeSettings.sidebar.switchPoint
		});

		
	}




	/*Booking plugin*/
	
	$('#mphb-booking-details').find('.mphb-booking-details-title, .mphb-check-in-date, .mphb-check-out-date').wrapAll('<div class="mphb-details-sidebar"></div>');
	$('#mphb-price-details').appendTo('.mphb-details-sidebar');
	/* #Footer
	================================================== */


	/*Adding class if footer is empty*/
	if(!$(".footer .widget").length > 0) {
		$(".footer").addClass("empty-footer");
	}


/* #Masonry
================================================== */
	// !- Calculate columns size
	window.the7GetMasonryColumnsConfig = function ($container) {
		var $dataAttrContainer = $container.parent().hasClass("mode-masonry") ? $container.parent() : $container;
		var containerWidth = $container.width() - 1;
		var columns = {
			mobile: parseInt($dataAttrContainer.attr("data-phone-columns-num")),
			desktop: parseInt($dataAttrContainer.attr("data-desktop-columns-num")),
			tabletV: parseInt($dataAttrContainer.attr("data-v-tablet-columns-num")),
			tabletH: parseInt($dataAttrContainer.attr("data-h-tablet-columns-num"))
		};

		if (Modernizr.mq("only screen and (max-width:767px)")) {
			singleWidth = Math.floor(containerWidth / columns.mobile) + "px";
			doubleWidth = Math.floor(containerWidth / columns.mobile) * 2 + "px";
			columnsNum = columns.mobile;
		} else if (Modernizr.mq("(min-width:768px) and (max-width:991px)")) {
			singleWidth = Math.floor(containerWidth / columns.tabletV) + "px";
			doubleWidth = Math.floor(containerWidth / columns.tabletV) * 2 + "px";
			columnsNum = columns.tabletV;
		} else if (Modernizr.mq("(min-width:992px) and (max-width:1199px)")) {
			singleWidth = Math.floor(containerWidth / columns.tabletH) + "px";
			doubleWidth = Math.floor(containerWidth / columns.tabletH) * 2 + "px";
			columnsNum = columns.tabletH;
		} else {
			singleWidth = Math.floor(containerWidth / columns.desktop) + "px";
			doubleWidth = Math.floor(containerWidth / columns.desktop) * 2 + "px";
			columnsNum = columns.desktop;
		}

		return {
			singleWidth: singleWidth,
			doubleWidth: doubleWidth,
			columnsNum: columnsNum
		};
	};

	$.fn.simpleCalculateColumns = function($dataAttrContainer, columnsConfigFunction, mode) {
		var contWidth = parseInt($dataAttrContainer.attr("data-width"));
        var contNum = parseInt($dataAttrContainer.attr("data-columns"));
        var contPadding = parseInt($dataAttrContainer.attr("data-padding"));
		if (typeof mode === 'undefined' ){
            mode = 'px';
		}
        this.calculateColumns(contWidth, contNum, contPadding, null, null, null, null, mode, columnsConfigFunction);
	};

	$.fn.calculateColumns = function(minWidth, colNum, padding, switchD, switchTH, switchTV, switchP, mode, columnsConfigFunction) {
		return this.each(function() {
			var columns;
			var tempCSS = "";
			var containerWidth;
			var $container = $(this);
			var $classesContainer = $container;
			var containerID = $container.attr("data-cont-id");
			var $containerIDN = $(".cont-id-" + containerID + "");
			var containerPadding = (padding !== false) ? padding : 20;
			var singleWidth;
			var doubleWidth;
			var columnsNum;
			var normalizedMargin = -containerPadding;
			var normalizedPadding = containerPadding - 10;
			var normalizedPaddingTop = containerPadding - 5;

			if (containerPadding < 10) {
				normalizedPadding = 0;
				normalizedPaddingTop = 0;
			}
			if (containerPadding === 0) {
				normalizedMargin = 0;
			}

			if ($container.parent().hasClass("mode-masonry")) {
				$classesContainer = $classesContainer.parent();
				$containerIDN = $containerIDN.parent();
			}

			var isDescriptionUnderImage = $containerIDN.not(".bg-under-post, .content-bg-on").hasClass("description-under-image");

			if (!$("#col-style-id-" + containerID).exists()) {
				var jsStyle = document.createElement("style");
				jsStyle.id = "col-style-id-" + containerID;
				jsStyle.appendChild(document.createTextNode(""));
				document.head.appendChild(jsStyle);
			} else {
				var jsStyle = document.getElementById("col-style-id-" + containerID);
			}

			var $style = $("#col-style-id-" + containerID);

			// Add container margins to use updated container width in calculations.
			if (isDescriptionUnderImage) {
				tempCSS = " \
							.cont-id-" + containerID + " { margin: -" + normalizedPaddingTop + "px  -" + containerPadding + "px -" + normalizedPadding + "px ; } \
							.full-width-wrap .cont-id-" + containerID + " { margin: " + (-normalizedPaddingTop) + "px " + containerPadding + "px " + (-normalizedPadding) + "px ; }";
			} else {
				tempCSS = " \
							.cont-id-" + containerID + " { margin: -" + containerPadding + "px; } \
							.full-width-wrap .cont-id-" + containerID + " { margin: " + normalizedMargin + "px  " + containerPadding + "px; } \
						";
			}
			$style.html(tempCSS);

			if ($classesContainer.hasClass("resize-by-browser-width")) {
				if (typeof columnsConfigFunction === "undefined") {
					columnsConfigFunction = the7GetMasonryColumnsConfig;
				}

				columns = columnsConfigFunction.call(this, $container);

				singleWidth = columns.singleWidth;
				doubleWidth = columns.doubleWidth;
				columnsNum = columns.columnsNum;
			} else {
				containerWidth = $container.width() - 1;

				minWidth = minWidth ? minWidth : 200;
				colNum = colNum ? colNum : 6;

				for (; Math.floor(containerWidth / colNum) < minWidth;) {
					colNum--;
					if (colNum <= 1) break;
				}

				if (mode === "px") {
					singleWidth = Math.floor(containerWidth / colNum) + "px";
					doubleWidth = Math.floor(containerWidth / colNum) * 2 + "px";
					columnsNum = colNum;
				} else {
					singleWidth = Math.floor(100000 / colNum) / 1000 + "%";
					doubleWidth = Math.floor(100000 / colNum) * 2 / 1000 + "%";
				}
			}

			if (isDescriptionUnderImage) {
				if (columnsNum > 1) {
					tempCSS += " \
							.cont-id-" + containerID + "  .wf-cell { width: " + singleWidth + "; padding: " + normalizedPaddingTop + "px " + containerPadding + "px " + normalizedPadding + "px; } \
							.cont-id-" + containerID + "  .wf-cell.double-width { width: " + doubleWidth + "; } \
						";
				} else {
					tempCSS += " \
							.cont-id-" + containerID + "  .wf-cell { width: " + singleWidth + "; padding: " + normalizedPaddingTop + "px " + normalizedPadding + "px " + containerPadding + "px; } \
						";
				}
			} else {
				if (columnsNum > 1) {
					tempCSS += " \
							.cont-id-" + containerID + " .wf-cell { width: " + singleWidth + ";  padding: " + containerPadding + "px; } \
							.cont-id-" + containerID + " .wf-cell.double-width { width: " + doubleWidth + "; } \
						";
				} else {
					tempCSS += " \
							.cont-id-" + containerID + " .wf-cell { width: " + singleWidth + "; padding: " + containerPadding + "px; } \
						";
				}
			}
			$style.html(tempCSS);
			var newRuleID = jsStyle.sheet.cssRules.length;
			jsStyle.sheet.insertRule(".webkit-hack { }", newRuleID);
			jsStyle.sheet.deleteRule(newRuleID);

			$container.trigger("columnsReady");
		});
	};

	// !- Initialise slider
	$.fn.initSlider = function() {
		return this.each(function() {
		
			var $_this = $(this),
				attrW = $_this.data('width'),
				attrH = $_this.data('height');

			if ($_this.hasClass("royalReady")) {
				return;
			}

			$_this.postTypeScroller();

			$_this.addClass("royalReady");
			
		});
	};
	//disable isotope animation
	var positionFunc = Isotope.prototype._positionItem;
	Isotope.prototype._positionItem = function( item, x, y, isInstant ) {
	  // ignore isInstant, pass in true;
	  positionFunc(item, x, y, true);
	};

	$.fn.IsoLayzrInitialisation = function(container) {
        return IsoLayzrCommonInitialisation(this, container, "img[class*=iso-]", "iso-item-lazy-load");
	};

	$.fn.IsoLayzrJqInitialisation = function(container) {
		return IsoLayzrCommonInitialisation(this, container, "img", "thumb-lazy-load-show");
	};

	function IsoLayzrCommonInitialisation(elements, layzrContainer, imgSelector, imgClass) {
		var flag = true;

		return elements.each(function() {
			var $this = $(this);
			$this.find(imgSelector).addClass(imgClass);
			new Layzr({
				container: layzrContainer,
				selector: '.' + imgClass,
				attr: 'data-src',
				attrSrcSet: 'data-srcset',
				retinaAttr: 'data-src-retina',
				threshold: 30,
				before: function() {
					var ext = $(this).attr("data-src").substring($(this).attr("data-src").lastIndexOf(".")+1);
					if(ext == "png"){
						$(this).parent().addClass("layzr-bg-transparent");
					}
					$(this).one("load",function() {
						// For fixed-size images with srcset; or have to be updated on window resize.

						if($(this).parents(".woocom-project").length > 0 ){
							this.setAttribute("sizes", "(max-width:" + $(this).attr('width')+"px) 100vw," + $(this).attr('width')+"px" );
						}else{
							this.setAttribute("sizes", this.width+"px");
						}
						this.style.willChange = 'opacity';
					});
				},
				callback: function() {
					this.classList.add("iso-layzr-loaded");
					var $this =  $(this);
					$this.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(e) {
						setTimeout(function(){
							$this.parent().removeClass("layzr-bg");
							$this.css("will-change",'auto');
						}, 200)
					});
					if($this.parents(".dt-isotope").length > 0 && flag ){
						$this.parents(".dt-isotope").isotope("layout");
						flag = false;
					}
				}
			});
		});
	};

	/* !Containers of masonry and grid content */
	
	var	$isoCollection = $(".iso-container");
	var	$gridCollection = $(".iso-grid:not(.jg-container, .iso-container), .blog.layout-grid .wf-container.description-under-image:not(.jg-container, .iso-container), .grid-masonry:not(.iso-container), .shortcode-blog-posts.iso-grid"),
		//$flexGrid = $(".blog-grid-shortcode"),
		$combinedCollection = $isoCollection.add($gridCollection),
		$isoPreloader = dtGlobals.isoPreloader = $('<div class="iso-preloader dt-posts-preload dt-posts-preload-active"><div class="dt-posts-preload-activity"></div></div>').appendTo("body").hide();
		$combinedCollection.not(".blog-grid-shortcode").addClass("dt-isotope");

	window.the7ApplyColumns = function(i, $container, columnsConfigFunction) {
		i = i || 0;

		var	$dataAttrContainer = $container.parent().hasClass("mode-masonry") ? $container.parent() : $container;
        var contPadding = parseInt($dataAttrContainer.attr("data-padding"));

		$container.addClass("cont-id-"+i).attr("data-cont-id", i);

		$container.simpleCalculateColumns($dataAttrContainer, columnsConfigFunction);
		if(contPadding > 10){
			$container.addClass("mobile-paddings");
		}

		$window.on("debouncedresize", function () {
            $container.simpleCalculateColumns($dataAttrContainer, columnsConfigFunction);

			if(contPadding > 10){
				$container.addClass("mobile-paddings");
			}
		});
	};

	if ($combinedCollection.exists()) {
		$combinedCollection.not(".custom-iso-columns").each(function(i) {
			the7ApplyColumns(i, $(this), the7GetMasonryColumnsConfig);
		});
	}

	//if(!dtGlobals.isPhone){
	// !- Responsive height hack
	$.fn.heightHack = function() {
		//if(!$(".layzr-loading-on").length > 0){

			return this.each(function() {
				var $img = $(this).not(".back-image");
				if ($img.hasClass("height-ready") || $img.parents(".testimonial-thumb").exists() || $img.parents(".post-rollover").exists() || $img.parents(".slider-masonry").exists() || $img.parents(".rollover-thumbnails").exists()) {
					return;
				}
				var	imgWidth = parseInt($img.attr('width')),
					imgHeight = parseInt($img.attr('height')),
					imgRatio = imgWidth/imgHeight;

				if($img.parents(".testimonial-vcard, .dt-format-gallery, .shortcode-blog-posts.iso-grid ").exists()) {
					$img.wrap("<div />");
				};

					if ( isNaN( imgRatio ) && $img[0] ) {
						imgRatio = $img[0].naturalWidth/$img[0].naturalHeight;
					}

					$img.parent().css({
						"padding-bottom" : 100/imgRatio+"%",
						"height" : 0,
						"display" : "block"
					});

					if($img.parents(".woocom-project").exists() && $img.parents(".woocom-project").width() > imgWidth && $img.parents(".wc-img-hover").exists() ){
						$img.parent().css({
							"padding-bottom" : (100/ ($img.parents(".woocom-project").width()/imgWidth) )/imgRatio+"%",
							"height" : 0,
							"display" : "block"
						});
					}
					if($img.parents(".dt-team-masonry-shortcode").exists()){
						if($img.parent().css('max-width') != 'none'){
							$img.parents(".team-media").addClass('apply-max-width');
						}
					}

				$img.attr("data-ratio", imgRatio).addClass("height-ready");

			});
		//}
	};


	/* !Isotope initialization */
	$.fn.IsoInitialisation = function(item, mode, trans, equalh) {
		return this.each(function() {
			var $this = $(this);
			if ($this.hasClass("iso-item-ready")) {
				return;
			}
			$this.isotope({
				itemSelector : item,
				layoutMode : mode,
				stagger: 30,
				resize: false,
				transitionDuration: 0,
				equalheight: equalh,
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				},
				masonry: { columnWidth: 1 },
				getSortData : {
					date : function( $elem ) {
						return $($elem).attr('data-date');
					},
					name : function( $elem ) {
						return $($elem).attr('data-name');
					}
				}
			});
			$this.addClass("iso-item-ready");

		});

	};



	/* !Masonry and grid layout */

	/* !Filter: */
	//var $container = $('.iso-container, .portfolio-grid');
	$('.iso-container, .portfolio-grid').each(function(){
		if($(this).parent().hasClass("mode-masonry")){
			var $container = null;
		}else{
			var $container = $(this);
		}

		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-categories a').on('click.presscorFilterCategories', function(e) {
			var selector = $(this).attr('data-filter');
			if ($container != null){
				$container.isotope({ filter: selector });
			}
			return false;
		});

		// !- filtering
		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-by a').on('click', function(e) {
			var sorting = $(this).attr('data-by'),
				sort = $(this).parents('.filter-extras').find('.filter-sorting > a.act').first().attr('data-sort');
			if ($container != null){
				$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
			}
			return false;
		});

		// !- sorting
		$('.filter:not(.iso-filter):not(.without-isotope):not(.with-ajax) .filter-extras .filter-sorting a').on('click', function(e) {
			var sort = $(this).attr('data-sort'),
				sorting = $(this).parents('.filter-extras').find('.filter-by > a.act').first().attr('data-by');
			if ($container != null){
				$container.isotope({ sortBy : sorting, sortAscending : 'asc' == sort });
			}
			return false;
		});
	});
	$('.dt-css-grid .wf-cell.visible').IsoLayzrJqInitialisation();


	/* !Masonry layout */
	if ($isoCollection.exists() || $gridCollection.exists() ) {

		// Show preloader
		$isoPreloader.fadeIn(50);

		$combinedCollection.not(".blog-grid-shortcode").each(function() {
			var $this = $(this);
			var	$isoContainer = $this;
			if($this.hasClass("mode-masonry")){
				$isoContainer = $this.find(".dt-isotope");
			}
			// Hack to make sure that masonry will correctly calculate columns with responsive images height.
			$(".preload-me", $isoContainer).heightHack();
			// Slider initialization
			$(".slider-masonry", $isoContainer).initSlider();

			$isoContainer.one("columnsReady", function() {

				//Call isotope
				if($isoContainer.hasClass("iso-container")){
					$isoContainer.IsoInitialisation('.iso-item', 'masonry', 400);
				}else{
					var equalheight = true;
					if($isoContainer.parent().hasClass("gradient-overlay-layout-list") || $isoContainer.parent().hasClass("content-rollover-layout-list")){
						equalheight = false;
					}
					$isoContainer.IsoInitialisation('.wf-cell', 'fitRows', 400, equalheight);
				}

				$isoContainer.isotope('on', 'layoutComplete', function (objArray){
					//callback isotope on load ...
					for(var i = 0; i < objArray.length; i++){
						var obj = objArray[i];
						var  $container = $(this);
					   $isoContainer.trigger("IsoReady");
					}
				});
				$isoContainer.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
				/* !Call layzr on isotope layoutComplete */
				$isoContainer.one("IsoReady", function() {
					/*Init layzr*/
					var	$layzrContainer = $isoContainer;
					if($isoContainer.parent().hasClass("jquery-filter") && $isoContainer.parent().attr('data-pagination-mode') != "none"){
						$layzrContainer = $isoContainer.find(".wf-cell.visible");
					}
					$layzrContainer.IsoLayzrJqInitialisation();
					setTimeout(function () {
						$isoContainer.isotope("layout");
					}, 350);
				});
			});

			// Recalculate everything on window resize
			$isoContainer.on("columnsReady", function () {
				if($(".slider-masonry", $isoContainer).hasClass("royalReady")){
					$(".slider-masonry", $isoContainer).each(function(){
						var scroller = $(this).parents(".ts-wrap").data("thePhotoSlider");
						if(typeof scroller!= "undefined"){
							scroller.update();
						}
					});
				}
				$isoContainer.parent(".content-rollover-layout-list:not(.disable-layout-hover)").find(".post-entry-wrapper").clickOverlayGradient();
				$isoContainer.isotope("layout");
			});

		});

		// Hide preloader
		$isoPreloader.stop().fadeOut(300);
	}

	$window.on("debouncedresize", function( event ) {
		dtGlobals.resizeCounter++;

		//Photos widget
		if ( $.isFunction($.fn.calcPics) ) {
			$(".instagram-photos").calcPics();
		}
		//set correct width for header in boxed layout
		if($page.hasClass('boxed')){
			var value = $page.css("maxWidth");
			var hasPx = value.indexOf('px') >= 0;
			var hasPct = value.indexOf('%') >= 0;
			if(hasPx) {
				$mastheadHeader.addClass("width-in-pixel");
				if( typeof $phantom != 'undefined'){
					$phantom.addClass("width-in-pixel");
				}
			}
			if(hasPct){
				$(".masthead.full-width:not(.side-header)").css({
					width: $page.width()
				});
				if(typeof $phantom != 'undefined' && $phantom.find('.top-bar-bg').length > 0){
					$phantom.find('.top-bar-bg').css({
						width: $page.width()
					})
				}
				if($body.hasClass('phantom-sticky') && $('.top-bar-bg').length > 0){
					$('.top-bar-bg').css({
						width: $page.width()
					})
				}
			}

		}
		$(".content-rollover-layout-list:not(.disable-layout-hover) .dt-css-grid .post-entry-wrapper").clickOverlayGradient();

		/*Mobile header*/
		if(window.innerWidth >= dtLocal.themeSettings.mobileHeader.firstSwitchPoint){
			$page.removeClass("show-mobile-header");
			$page.addClass("closed-mobile-header");
			$body.removeClass("show-sticky-mobile-header");
			$body.removeClass("show-overlay-mobile-header").addClass("closed-overlay-mobile-header");
			$(".mobile-sticky-header-overlay").removeClass("active");
			$(".dt-mobile-menu-icon").removeClass("active");
			$html.removeClass("menu-open");

		}

		if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){

			//Add mobile class to header to avoid conflict with floating menu
			if(!$('.masthead').hasClass("masthead-mobile")){
				$('.masthead:not(.mixed-header):not(#phantom)').addClass("masthead-mobile");
			}
			//Add class to header after mobile switch
			if(!$('.masthead').hasClass("masthead-mobile-header")){
				$('.masthead:not(.side-header):not(#phantom)').addClass("masthead-mobile-header");
				$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass("masthead-mobile-header");
			}
			if(stickyTopLine.exists()) {
				stickyTopLine.removeClass("sticky-top-line-on sticky-top-line-on");
				topLineDocked = false;
			}
			$('.mobile-header-scrollbar-wrap').css({
				'max-width': $(".dt-mobile-header ").width() - 13
			})
		}else{
			$('.masthead:not(.mixed-header):not(#phantom)').removeClass("masthead-mobile");
			//$('.masthead:not(#phantom)').removeClass("masthead-mobile-header");
			$('.masthead:not(.side-header):not(#phantom)').removeClass("masthead-mobile-header");
			$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').removeClass("masthead-mobile-header");
			if(!$('.masthead').hasClass("desktop-side-header")){
				$('body:not(.overlay-navigation):not(.sticky-header) .side-header:not(#phantom)').addClass('desktop-side-header');
			}
		}

		if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.firstSwitchPoint && window.innerWidth > dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")){
			//Check if top bar not empty on mobile
			if($('.left-widgets', $topBar).find(".in-top-bar-left").length > 0 || $('.top-bar .right-widgets').find(".in-top-bar-right").length > 0){
				$topBar.removeClass('top-bar-empty');
			}else{
				$topBar.addClass('top-bar-empty');
			}
		}else if(window.innerWidth <= dtLocal.themeSettings.mobileHeader.secondSwitchPoint && !$body.hasClass("responsive-off")) {
			if($('.left-widgets', $topBar).find(".in-top-bar").length > 0){
				$topBar.removeClass('top-bar-empty');
			}else{
				$topBar.addClass('top-bar-empty');
			}
		}else{
			if(!$('.mini-widgets', $topBar).find(".show-on-desktop").length > 0){
				$topBar.addClass('top-bar-empty');
			}else{
				$topBar.removeClass('top-bar-empty');
			}
		}
		if ($topBar.exists()) {
			topBarMobH = $topBar.innerHeight();
		};
		//Custom select
		$('.mini-nav select').trigger('render');
		
		//Fancy headers
		$.fancyFeaderCalc();

		//Set full height stripe
		$(".dt-default").each(function(){
			var $_this = $(this),
				$_this_min_height = $_this.attr("data-min-height");
			if($.isNumeric($_this_min_height)){
				$_this.css({
					"minHeight": $_this_min_height + "px"
				});
			}else if(!$_this_min_height){
				$_this.css({
					"minHeight": 0
				});
			}else if($_this_min_height.search( '%' ) > 0){
				$_this.css({
					"minHeight": $window.height() * (parseInt($_this_min_height)/100) + "px"
				});
			}else{
				$_this.css({
					"minHeight": $_this_min_height
				});
			};
		});
		/*Floating content*/
		
		$parentHeight = $floatContent.siblings(".project-wide-col").height();
        $floatContentHeight = $floatContent.height();
        setFloatinProjectContent();

        /*Floating sidebar*/
  //       dtGlobals.sidebarWidth = $(".sidebar").width();
		// dtGlobals.windowH = $(window).height();
		//setFloatinSidebar();
		/* Sticky footer */
		if($(".boxed").length > 0){
			var $pageBoxed = $(".boxed");
			$(".header-side-left.footer-overlap:not(.sticky-header) .boxed .footer, .left-side-line.footer-overlap .boxed .footer").css({
				right: ($window.width() - ($pageBoxed.offset().left + $pageBoxed.outerWidth()))
			})
		}
		$(".footer-overlap .footer").css({
			'opacity': 1
		});

		$(".mobile-false .footer-overlap .page-inner").css({
			'min-height': window.innerHeight - $(".footer").innerHeight(),
			'margin-bottom': $(".footer").innerHeight()
		});

        $(".mobile-false .footer-overlap .footer").css({
            'bottom': parseInt($body.css('padding-bottom')) + parseInt($body.css('margin-bottom'))
        });

	}).trigger( "debouncedresize" );

	//resize widgets in above the fold js second time
    $window[0].dispatchEvent(new CustomEvent('the7_widget_resize'));

/* #One-page
================================================== */

	var $moveBody = $("html, body");
	var phantomStickyExists = $(".phantom-sticky").exists(),
		sideHeaderHStrokeExists = $(".sticky-top-line").exists(),
		stickyMobileHeader = $(".sticky-mobile-header").exists(),
		floatMenuH = 0;
	var floatingHeaderExists = phantomStickyExists || sideHeaderHStrokeExists;

	/*Detect floating header*/
	if(floatingHeaderExists){
		var $phantom = $(".masthead"),
			$phantomVisibility = 1;
	}else{
		var $phantom = $("#phantom"),
			$phantomVisibility = $phantom.css("display")=="block";
	}


	// One page scrolling effect
	
	if ($(".mobile-header-bar").length > 0 && $(".mobile-header-bar").css('display') != 'none') {
		var $headerBar = $(".mobile-header-bar");
		if($(".sticky-top-line").exists()){
			var $headerBar = $(".sticky-top-line.masthead-mobile-header .mobile-header-bar");
		}
		if($(".phantom-sticky").length > 0 || $(".sticky-top-line").exists()){
			if($(".sticky-header .masthead.side-header").length > 0 || $(".overlay-navigation .masthead.side-header").length > 0){
				var $phantom = $(".mobile-header-bar").parent(".masthead:not(.side-header)");
			}else{
				var $phantom = $(".mobile-header-bar").parent();
			}
		}
	}else{
		if($body.hasClass("floating-top-bar")){

			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke)");
		}else{
			var $headerBar = $(".masthead:not(.side-header):not(.side-header-v-stroke) .header-bar");
		}
	}

	/*Floating header height*/
	function set_sticky_header_height() {
		if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
			if(stickyMobileHeader){
				floatMenuH = $phantom.height();
			}else{
				floatMenuH = 0;
			}
		}else{
			if($phantom.css("display")=="block" || $phantom.css("display")=="-ms-flexbox" || phantomStickyExists){		
				floatMenuH = $phantom.height();
			}else if(sideHeaderHStrokeExists){
				floatMenuH = $(".sticky-top-line").height();
			}else{
				floatMenuH = 0;
			}
		}
	}
	set_sticky_header_height();

	/**
	 * Set current menu item and scroll to top/element on load.
	 */
	addOnloadEvent(function () {
		var locHash = window.location.hash;
		var urlHash = "";

		if (locHash.match("^#!")) {
			urlHash = locHash.substring(3);
		}

		setTimeout(function () {
			if (!urlHash) {
				// Set menu item, assotiated with the top position, active?
				if ($(".menu-item > a[href='#!/up']").length > 0) {
					$(".menu-item > a[href='#!/up']").parent("li").addClass("act");
				}

				return;
			}

			// Set menu item active if it is related to urlHash.
			$(".menu-item a").parent("li").removeClass("act");
			$(".menu-item a[href='" + locHash + "']").parent("li").addClass("act");
			$(".menu-item a[href*='" + locHash + "']").parent("li").addClass("act");

			// Scroll to top.
			if (urlHash === "up") {
				$.closeMobileHeader();
				$moveBody.stop().animate({scrollTop: 0}, 600, "swing", function () {
					$.closeSideHeader();
				});

				return;
			}

			// Scroll to the element.
			setTimeout(function () {
				var $targetContainer = $("#" + urlHash);

				var scrollToPosition = function (position) {
					$moveBody.stop().animate({scrollTop: position}, 650, "swing");
				};

				var getContainerOffsetOnMobile = function () {
					return $targetContainer.offset().top - $(".masthead-mobile-header .mobile-header-bar").height();
				};

				var getContainerOffsetOnDesktop = function () {
					var offset = $targetContainer.offset().top - $($headerBar, $phantom).height();

					if (floatingHeaderExists && $phantom.css("border-bottom-style") === "solid") {
						offset += 1;
					}

					return offset;
				};

				var addSomeSeriesScrollingAfterAnimation = function (curVal, computeNewVal) {
					$targetContainer.one("animationend", function () {
						var newVal = computeNewVal();
						if (newVal !== curVal) {
							scrollToPosition(newVal);
						}
					})
				};

				$moveBody
					.stop()
					.animate(
						{
							scrollTop: $targetContainer.offset().top - floatMenuH
						},
						600,
						"swing",
						function () {
							var curDesktopOffset = getContainerOffsetOnDesktop();
							var curMobileOffset = getContainerOffsetOnMobile();

							if (window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")) {
								if (stickyMobileHeader) {
									if (mobileHeaderDocked) {
										scrollToPosition(curMobileOffset);
										addSomeSeriesScrollingAfterAnimation(curMobileOffset, getContainerOffsetOnMobile);
									} else {
										scrollToPosition(curDesktopOffset);
										addSomeSeriesScrollingAfterAnimation(curDesktopOffset, getContainerOffsetOnDesktop);
									}
								}
							} else if (floatingHeaderExists) {
								scrollToPosition(curDesktopOffset);
								addSomeSeriesScrollingAfterAnimation(curDesktopOffset, getContainerOffsetOnDesktop);
							}
						}
					);
			}, 300);
		}, 300);
	});

	jQuery( window ).on('resize', function() {
		set_sticky_header_height();
	});

	
	var $menus = $( '.menu-item > a[href*="#!"]' );


	/*!-scroll to anchor*/
	window.clickAnchorLink = function( $a, e ) {
		var url = $a.attr( 'href' ),
			hash = url,
			$target = url.substring(3),
			base_speed  = 600,
			speed       = base_speed;
		if(url.match("^#!")){
			var $target = url.substring(3);
		}else{
			var $target = (url.substring(url.indexOf('#'))).substring(3);
		}
		set_sticky_header_height();

		if ( typeof $target != 'undefined' && $target && $target.length > 0 ) {
			location.hash = url;
			if($("#" + $target).length > 0) {
				var top = $("#" + $target).offset().top + 1,
					this_offset = $a.offset(),
					that_offset = $("#" + $target).offset(),
					offset_diff = Math.abs(that_offset.top - this_offset.top),
					speed = 150 * Math.log(offset_diff^2/1000 + 1.02);
					$newScrollPosition = top - floatMenuH;
			};
			if($target == "up") {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing');
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: 0
					}, speed, 'swing',
					function() { $.closeSideHeader(); }
					);
				}
			}else {
				if($body.hasClass("overlay-navigation")){
					$.closeMobileHeader();
					$.closeSideHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 
							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');

								}
							}else{
								if(sideHeaderHStrokeExists){
									$newScrollPosition = ( top - $(".sticky-top-line").height() )

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}
						
					});
				}else{
					$.closeMobileHeader();
					$moveBody.stop().animate({
						scrollTop: top - floatMenuH
					}, speed, 'swing',
						function() { 

							$.closeSideHeader();

							if(window.innerWidth < dtLocal.themeSettings.mobileHeader.firstSwitchPoint && !$body.hasClass("responsive-off")){
								if(stickyMobileHeader){
									if(mobileHeaderDocked){
										$newScrollPosition = ( top - $(".masthead-mobile-header .mobile-header-bar").height() )
									}else if(topLineDocked){
										$newScrollPosition = ( top - $(".sticky-top-line").height() )
									}else{
										$newScrollPosition = ( top - $($headerBar, $phantom).height() );
									}

									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								}
							}else{
								if(phantomStickyExists || sideHeaderHStrokeExists){
									if(headerDocked){
										if($body.hasClass("floating-top-bar")){
											var $newScrollPosition = ( top - $(".masthead").height() );
										}else{
											$newScrollPosition = ( top - $(".header-bar").height() );
										}
									}else{
										if($('.masthead').hasClass("mixed-floating-top-bar")){
											$newScrollPosition = ( top - $(".sticky-top-line").height() )
										}else{
											$newScrollPosition = ( top - $(".sticky-top-line .header-bar").height() );
										}
									}


									$moveBody.stop().animate({
										scrollTop: $newScrollPosition
									}, 650, 'swing');
								
								}
							}

						
						//}
					});
				}
			};

			$('.menu-item a').parent("li").removeClass('act');
			$a.parent("li").addClass('act');
		};

	};

	$body.on( 'click', '.anchor-link[href^="#!"], .anchor-link a[href^="#!"], .logo-box a[href^="#!"], .branding a[href^="#!"], #branding-bottom a[href^="#!"], .mobile-branding a[href^="#!"]', function( e ) {
		clickAnchorLink( $( this ), e );
		e.preventDefault();
		return false;
	});

	$menus.on( 'click', function( e ) {
		if(!$(e.target).parent().hasClass('next-level-button')) {
			clickAnchorLink( $( this ), e );
			if($(this).attr('href').match("^#!")){
				e.preventDefault();
				return false;
			}
		}
	});
	/*!-set active menu item on scroll*/
	//if(($('.one-page-row div[data-anchor^="#"]').length > 0 || $('.vc_row[id]').length > 0 || $('.vc_section[id]').length > 0 || $('.elementor-top-section[id]').length > 0) && $(".one-page-row").length > 0){
		$window.scroll(function (e) {
			var currentNode = null;
			if(!$body.hasClass("is-scroll")){
				var currentNode;
				//for vc row id
				
				if(isMoved && $($phantom).css("border-bottom-style")=='solid'){
					var headerHeight = $($phantom).height() + 1;
				}else if(isMoved){
					var headerHeight = $($phantom).height();
				}else{
					var headerHeight = $($headerBar).height();
				}

				 $('.one-page-row .vc_row[id], .elementor-top-section[id], .one-page-row .vc_section[id], .one-page-row div[data-anchor^="#"]').each(function(){
                    var $_this = $(this),
                        activeSection = $_this,
                        currentId = $_this.attr('id');
                    if($_this.hasClass('wpb_animate_when_almost_visible')){
	                    $_this.one('webkitAnimationEnd oanimationend msAnimationEnd animationend',   
	    function(e) {
		                    if($_this.is(":visible") && dtGlobals.winScrollTop >= Math.floor($_this.offset().top - headerHeight)){
		                        currentNode = "#!/" + currentId;
		                    };

		                	$('.menu-item a[href^="#!"]').parent("li").removeClass('act');
		                	$('.menu-item a[href="'+currentNode+'"]').parent("li").addClass('act');
						})
					}
						if($_this.is(":visible") && dtGlobals.winScrollTop >= Math.floor($_this.offset().top - headerHeight)){
	                        currentNode = "#!/" + currentId;
	                   

					}
                });

        		$('.menu-item a[href^="#!"]').parent("li").removeClass('act');
        		$('.menu-item a[href="'+currentNode+'"]').parent("li").addClass('act');

                if($(".one-page-row div[data-anchor^='#']").length > 0){

                    if(dtGlobals.winScrollTop < ($(".one-page-row div[data-anchor^='#']").first().offset().top - headerHeight)&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
                        $( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
                    }

                }else if( $('.vc_row[id]').length > 0 || $('.vc_section[id]').length > 0 || $('.elementor-top-section[id]').length > 0){
                    //for vc row id
                   if( $('.one-page-row .vc_row[id], .one-page-row .vc_section[id], .elementor-top-section[id]').length > 0 ){
	                    var vcAnchor = $('.one-page-row .vc_row[id], .one-page-row .vc_section[id], .elementor-top-section[id]')
	                    if(dtGlobals.winScrollTop < (vcAnchor.first().offset().top - headerHeight)&& $( '.menu-item > a[href="#!/up"]' ).length > 0) {
	                        $( '.menu-item > a[href="#!/up"]' ).parent("li").addClass("act");
	                    };
	                }
                }
            };
		});
	//};

/* #AJAX
================================================== */

	// 4 Alla & Danil: we need to unify all ajax and masonry and other stuff in this manner:
	function loadingEffects() {

		var $isotope = $(".dt-isotope"),
			$grid = $(".iso-grid .wf-cell:not(.shown), .dt-css-grid .wf-cell:not(.shown)");

		if ($grid.exists()) {
			precessEffects($grid);
		}

		if (!$isotope.exists()) {
			var $isoFallback = $(".iso-item:not(.shown)");

			if (!$isoFallback.exists()) return;
			precessEffects($isoFallback);
		}
		else {
			var t = 0;

			$isotope.each(function() {
				t++;
				var $atoms = $(this).find(".wf-cell");
				if (!$atoms.exists()) return;
				precessEffects($atoms, function(){});
				
			});
		};
	};

	function precessEffects($atoms, callback) {
		var k = 0;
		// $.fn.isInViewport = function() {
		//     var elementTop = $(this).offset().top;
		//     var elementBottom = elementTop + $(this).outerHeight();

		//     var viewportTop = $(window).scrollTop();
		//     var viewportBottom = viewportTop + $(window).height();

		//     return elementBottom > viewportTop && elementTop < viewportBottom;
		// };

		$atoms.each(function () {
			var $this = $(this);
			if($(".mobile-true").length > 0 || $this.parents(".loading-effect-none").length > 0){
				if (!$this.hasClass("shown") && !$this.hasClass("animation-triggered")) {
					$this.addClass("animation-triggered");
					setTimeout(function () {
						if ($this.hasClass("animation-triggered")) { 
							$this.removeClass("animation-triggered").addClass("shown");
						};
					}, 200);
				};
			}else{
				//if(typeof inView != 'undefined' &&  $.isFunction(inView)){
					if (!$this.hasClass("shown") && !$this.hasClass("animation-triggered")  && dtGlobals.isInViewport($this) && !$this.hasClass("hidden") ) {
						$this.addClass("animation-triggered");
						k++;
						setTimeout(function () {
							if ($this.hasClass("animation-triggered")) { 
								$this.removeClass("animation-triggered").addClass("shown");
							};
						}, 100 * k);
					};

				//}
			}
			if (typeof callback == "function") {
					callback.call(this);
				}
		});
		
	};
	$.fn.resetEffects = function(container) {
		return this.each(function() {
			var $this = $(this);
			$this.find(".iso-item.shown, .wf-cell.shown").removeClass("start-animation").removeClass("animation-triggered").removeClass("shown");

		})
		
	};

	var dtAjaxing = {
		xhr: false,
		settings: false,
		launch: function( settings ) {

			var ajaxObj = this;

			if ( settings ) {
				this.settings = settings;
			}

			if ( this.xhr ) {
				this.xhr.abort();
			}

			var action = 'presscore_template_ajax';

			this.xhr = $.post(
				settings.ajaxurl,
				{
					action : action,
					postID : settings.postID,
					paged : settings.paged,
					targetPage : settings.targetPage,
					term : settings.term,
					orderby : settings.orderBy,
					order : settings.order,
					nonce : settings.nonce,
					visibleItems : settings.visibleItems,
					contentType : settings.contentType,
					pageData : settings.pageData,
					sender : settings.sender
				},
				function( responce ) {

					if ( responce.success ) {

						var $responceItems = jQuery(responce.html),
							$isoContainer = settings.targetContainer,

							contWidth = parseInt($isoContainer.attr("data-width")),
							contMaxWidth = parseInt($isoContainer.attr("data-max-width")),
							contPadding = parseInt($isoContainer.attr("data-padding"));
							isIsotope = 'grid' == settings.layout || 'masonry' == settings.layout,
							itemsToDeleteLength = 0,
							trashItems = new Array(),
							sortBy = responce.orderby.replace('title', 'name'),
							sortAscending = ('asc' == responce.order.toString());

	
						if ( responce.newNonce ) {
							dtLocal.ajaxNonce = responce.newNonce;
						}

						if ( typeof responce.itemsToDelete != 'undefined' ) {
							itemsToDeleteLength = responce.itemsToDelete.length;
						}

						// if not mobile isotope with spare parts
						if ( isIsotope && itemsToDeleteLength > 0 ) {

							for( var i = 0; i < responce.itemsToDelete.length; i++ ) {
								trashItems.push('.wf-cell[data-post-id="' + responce.itemsToDelete[i] + '"]');
							}

							$isoContainer.isotope('remove', $isoContainer.find(trashItems.join(',')));

						// if mobile or not isotope and sender is filter or paginator
						} else if ( !isIsotope && ('filter' == settings.sender || 'paginator' == settings.sender) ) {

							$isoContainer.find('.wf-cell, article').remove();
						}

						if ( $responceItems.length > 0 ) {

							// append new items
							$isoContainer.append($responceItems);
							dtGlobals.ajaxContainerItems = $isoContainer.find('div.wf-cell, .project-even, .project-odd').not('.animation-triggered');

							// for isotope - insert new elements
							if ( isIsotope ) {

								$(".preload-me", $isoContainer).heightHack();
								$(".slider-masonry", $isoContainer).initSlider();
								$(".slider-masonry", $isoContainer).css("visibility", "visible");


								$isoContainer.isotope('addItems', $responceItems);

								if ( 'media' != settings.contentType ) {
									$isoContainer.isotope({ sortBy : sortBy, sortAscending : sortAscending });
								} else {
									$isoContainer.isotope({ sortBy: 'original-order' });
								}

								$isoContainer.isotope("layout");

								ajaxObj.init();

								
								$isoContainer.layzrInitialisation();

								$isoContainer.IsoLayzrInitialisation();

							// all other cases - append new elements
							} else {


								$(".slider-masonry", $isoContainer).initSlider();
								$("ul.photoSlider:not(.slider-masonry)").each(function(){
						    		$(this).postTypeScroller();
						    	});
						    	$("ul.photoSlider").css("visibility", "visible");

								if ( 'jgrid' == settings.layout ) {
									$isoContainer.collagePlus(dtGlobals.jGrid);
								}

								ajaxObj.init();

								$isoContainer.layzrInitialisation();
								$isoContainer.IsoLayzrInitialisation(".mobile-true");

							}

							if ( typeof settings.afterSuccessInit != 'undefined' ) {
								settings.afterSuccessInit( responce );
							}

							$window.trigger('dt.ajax.content.appended');

						} else if ( isIsotope ) {

							// if no responce items - reorder isotope
							$isoContainer.isotope({ sortBy : sortBy, sortAscending : sortAscending });
						}

					}

					if ( typeof settings.afterResponce != 'undefined' ) {
						settings.afterResponce( responce );
					}

					loadingEffects();
				}
			);
		},
		init : function() {
			switch ( this.settings.contentType ) {
				case 'portfolio' :
					this.initPortfolio();
					break;

				case 'albums' :
					this.initAlbums();
					break;

				case 'media' :
					this.initMedia();
					break;

				case 'blog':
					this.basicInit();
					break;
				 case 'testimonials':
					this.basicInit();
					break;
			}
		},
		initPortfolio : function() {
			this.basicInit();
		},
		initAlbums : function() {
			this.basicInit();
		},
		initMedia : function() {
			this.basicInit();
		},
		basicInit : function() {
			var $container = this.settings.targetContainer;

			$(".dt-pswp-item, .dt-gallery-container a", $container).addPhotoswipeWrap();

			 $('.dt-gallery-container', $container).initPhotoswipe();
			 $('.photoswipe-wrapper', $container).initPhotoswipe();
			$container.photoswipeGallery('.dt-gallery-container.wf-container');


			$(".rollover, .rollover-video, .post-rollover, .rollover-project .show-content", $container).addRollover();
			if ( $.isFunction($.fn.hoverdir) ) {
				$('.mobile-false .hover-grid .rollover-project').each( function() { $(this).hoverdir(); } );
			
				$('.mobile-false .hover-grid-reverse .rollover-project ').each( function() { $(this).hoverdir({
					inverse : true
				}); } );
			}
			$(".mobile-true .rollover-project a.link.show-content, .hover-style-one article:not(.description-off) .rollover-project > a, .hover-style-two article:not(.description-off) .rollover-project > a, .hover-style-three article:not(.description-off) .rollover-project > a").on("click", function(e){
				e.preventDefault();
			});
			

			$('.dt-trigger-first-pswp', $container).not('.pspw-ready').on('click', function(){
				var $this = $(this),
					$container = $this.parents('article.post');

				if ( $container.length > 0 ) {
					var $target = $container.find('a.dt-pswp-item');

					if ( $target.length > 0 ) {
						$target.first().trigger('click');
					}
				}

				return false;
			}).addClass('mfp-ready');


			$(".mobile-true .rollover-project").touchNewHover();
			if ( $.isFunction($.fn.triggerHoverClick) ) {
				$(".mobile-false .rollover-project:not(.rollover-active) .rollover-content, .buttons-on-img:not(.rollover-active) .rollover-content").triggerHoverClick();
			}
			if ( $.isFunction($.fn.triggerHoverClick) ) {
				$(".mobile-false .rollover-project.forward-post").triggerHoverClick();
			}
			if ( $.isFunction($.fn.triggerHoverClick) ) {
				$(".mobile-false .rollover-project.rollover-active, .mobile-false .buttons-on-img.rollover-active").followCurentLink();
			}
			if ( $.isFunction($.fn.triggerAlbumsClick) ) {
				$(".mobile-false .albums .rollover-project, .mobile-false .albums .buttons-on-img, .mobile-false .archive .type-dt_gallery .buttons-on-img").triggerAlbumsClick();
			}
			if ( $.isFunction($.fn.triggerAlbumsTouch) ) {
			 	$(".mobile-true .albums .rollover-project, .mobile-true .albums .buttons-on-img, .mobile-true .archive .type-dt_gallery .buttons-on-img").triggerAlbumsTouch();
			 }
			if ( $.isFunction($.fn.triggerPostClick) ) {
				$(".mobile-false .content-rollover-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post, .mobile-false .gradient-overlay-layout-list:not(.portfolio-shortcode):not(.albums-shortcode) .post").triggerPostClick();
			}
			if ( $.isFunction($.fn.touchforwardToPost) ) {
				$(".mobile-true .rollover-project.forward-post").touchforwardToPost();
			}
			if ( $.isFunction($.fn.touchHoverImage) ) {
				$(".mobile-true .buttons-on-img").touchHoverImage();
			}

			$(".hover-scale .rollover-project").scaleInHover();

			if ( $.isFunction($.fn.addIconToLinks) ) {
				$(".links-container a").addIconToLinks();
			}

		}
	};

	// get ajax data
	function dtGetAjaxData( $parentContainer ) {
		var	$filtersContainer = $parentContainer.find('.filter.with-ajax').first(),
			$itemsContainer = $parentContainer.find('.wf-container.with-ajax, .articles-list.with-ajax').first(),
			$currentCategory = $filtersContainer.find('.filter-categories a.act'),
			$currentOrderBy = $filtersContainer.find('.filter-by a.act'),
			$currentOrder = $filtersContainer.find('.filter-sorting a.act'),
			paged = parseInt($itemsContainer.attr('data-cur-page')),
			nonce = null,
			visibleItems = new Array(),
			term = ( $currentCategory.length > 0 ) ? $currentCategory.attr('data-filter').replace('.category-', '').replace('*', '') : '';

		if ( '0' == term ) {
			term = 'none';
		}

		if ( $itemsContainer.hasClass('dt-isotope') ) {

			$('.wf-cell', $itemsContainer).each( function(){
				visibleItems.push( $(this).attr('data-post-id') );
			});
		}

		return {
			visibleItems : visibleItems,
			postID : dtLocal.postID,
			paged : paged,
			term : term,
			orderBy : ( $currentOrderBy.length > 0 ) ? $currentOrderBy.attr('data-by') : '',
			order : ( $currentOrder.length > 0 ) ? $currentOrder.attr('data-sort') : '',
			ajaxurl : dtLocal.ajaxurl,
			nonce : dtLocal.ajaxNonce,
			pageData : dtLocal.pageData,
			layout : dtLocal.pageData.layout,
			targetContainer : $itemsContainer,
			isPhone : dtGlobals.isPhone
		}
	}

	// paginator
	$('#content').on('click', '.paginator.with-ajax a', function(e){
		e.preventDefault();

		if ( $(e.target).hasClass('dots') || $(e.target).hasClass('disabled') ) {
			return;
		}

		var $this = $(this),
			$paginatorContainer = $this.closest('.paginator'),
			$parentContainer = $paginatorContainer.parent(),
			$itemsContainer = $parentContainer.find('.wf-container.with-ajax, .articles-list.with-ajax').first(),

			$loadMoreButton = $(".button-load-more"),
			loadMoreButtonCaption = $loadMoreButton.find('.button-caption').text(),

			paginatorType = $paginatorContainer.hasClass('paginator-more-button') ? 'more' : 'paginator',
			isMore = ('more' == paginatorType),

			ajaxData = dtGetAjaxData($parentContainer),
			targetPage = isMore ? ajaxData.paged + 1 : $this.attr('data-page-num'),
			isoPreloaderExists = dtGlobals.isoPreloader;

		$loadMoreButton.addClass("animate-load").find('.button-caption').text(dtLocal.moreButtonText.loading);

		// show preloader
		if ( isoPreloaderExists && !$(".paginator-more-button").length ) {
			dtGlobals.isoPreloader.fadeIn(50);
		}
		
		if ( !isMore ) {
			var $scrollTo = $parentContainer.find('.filter.with-ajax').first(),
				paddingTop = 44;

			if (!$scrollTo.exists()) {
				$scrollTo = $itemsContainer;
				paddingTop = 50;
			}

			// scroll to top
			$("html, body").animate({
				scrollTop: $scrollTo.offset().top - $("#phantom").height() - paddingTop
			}, 400);
		}else{
			$("html, body").scrollTop($window.scrollTop() + 1);
		}

		// launch ajax
		dtAjaxing.launch($.extend({}, ajaxData, {
			contentType : ajaxData.pageData.template,
			targetPage : targetPage,
			sender : paginatorType,
			visibleItems : isMore ? new Array() : ajaxData.visibleItems,
			afterResponce : function( responce ) {

				// we have paginator
				if ( $paginatorContainer.length > 0 ) {

					if ( responce.paginationHtml ) {

						// update paginator with responce content
						$paginatorContainer.html($(responce.paginationHtml).html()).show();

					} else {

						if ( false && isMore ) {
							$paginatorContainer.html('<span class="loading-ready">' + dtLocal.moreButtonAllLoadedText + '</span>');
						} else {
							// clear paginator and hide it
							$paginatorContainer.html('').hide();
						}
					}
					setTimeout (function(){
						$(".button-load-more").removeClass("animate-load").find('.button-caption').text(loadMoreButtonCaption);
					}, 200);

				} else if ( responce.paginationHtml ) {

					// if there are no paginator on page but ajax responce have it
					$itemsContainer.parent().append($(responce.paginationHtml));
				}
				
 			
				// add dots onclick event handler
				$paginatorContainer.find('.dots').on('click', function() {
					$paginatorContainer.find('div:hidden').show().find('a').unwrap();
					$(this).remove();
				});

				// update current page field
				$itemsContainer.attr('data-cur-page', responce.currentPage);

				// hide preloader
				dtGlobals.isoPreloader.stop().fadeOut(300);

				// update load more button
				dtGlobals.loadMoreButton = $(".button-load-more");
			}
		}));
	});

	// filter
	$('.filter.with-ajax .filter-categories a, .filter.with-ajax .filter-extras a').on('click', function(e){
		e.preventDefault();


		var $this = $(this),
			$filterContainer = $this.closest('.filter'),
			$parentContainer = $filterContainer.parent(),
			$itemsContainer = $parentContainer.find('.wf-container.with-ajax').first(),
			$paginatorContainer = $parentContainer.find('.paginator').first(),

			ajaxData = dtGetAjaxData($parentContainer),
			isoPreloaderExists = dtGlobals.isoPreloader;

		$itemsContainer.resetEffects();

		// show preloader
		if ( isoPreloaderExists ) {
			dtGlobals.isoPreloader.fadeIn(50);
		}

		// launch ajax
		dtAjaxing.launch($.extend({}, ajaxData, {
			contentType : ajaxData.pageData.template,
			targetPage : 1,
			paged : 1,
			sender : 'filter',
			afterResponce : function( responce ) {

				// we have paginator
				if ( $paginatorContainer.length > 0 ) {

					if ( responce.paginationHtml ) {

						// update paginator with responce content
						$paginatorContainer.html($(responce.paginationHtml).html()).show();
					} else {

						// clear paginator and hide it
						$paginatorContainer.html('').hide();
					}

				} else if ( responce.paginationHtml ) {

					// if there are no paginator on page but ajax responce have it
					$itemsContainer.parent().append($(responce.paginationHtml));
				}
				

				// add dots onclick event handler
				$paginatorContainer.find('.dots').on('click', function() {
					$paginatorContainer.find('div:hidden').show().find('a').unwrap();
					$(this).remove();
				});

				// update current page field
				$itemsContainer.attr('data-cur-page', responce.currentPage);

				// hide preloader
				dtGlobals.isoPreloader.stop().fadeOut(300);

				// update load more button
				dtGlobals.loadMoreButton = $(".button-load-more");
			}
		}));
		
	});

	function lazyLoading() {
		if ( dtGlobals.loadMoreButton && dtGlobals.loadMoreButton.exists() ) {

			var buttonOffset = dtGlobals.loadMoreButton.offset();
			if ( buttonOffset && $window.scrollTop() > (buttonOffset.top - $window.height()) / 2 && !dtGlobals.loadMoreButton.hasClass('animate-load') ) {
				dtGlobals.loadMoreButton.trigger('click');
			}

		}
	}

	// lazy loading
	if ( typeof dtLocal.themeSettings.lazyLoading != 'undefined' && dtLocal.themeSettings.lazyLoading ) {

		dtGlobals.loadMoreButton = $(".button-load-more");
		//var timer = null;
		$window.on('scroll', function () {
			lazyLoading();
		});
		lazyLoading();
	}

	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) {
				uniqueId = "Don't call this twice without a uniqueId";
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		};
	})();
	
	// Usage
	$window.resize(function () {
		
		/*Animate iso-items on resize*/
		$(".iso-item, .iso-grid .wf-cell").addClass("animate-position");
		waitForFinalEvent(function(){
			$(".iso-item, .iso-grid .wf-cell").removeClass("animate-position");
		}, 2500, "");

	});

	var $isotope = $(".dt-isotope"),
		$isoFallback = $(".iso-item:not(.shown):not(.is-visible)"),
		$grid = $(".iso-grid .wf-cell:not(.shown):not(.is-visible), .dt-css-grid .wf-cell:not(.shown):not(.is-visible)");

	if ($isotope.exists() || $isoFallback.exists() || $grid.exists()) {
		setTimeout(function () {
			loadingEffects();
		}, 100);

		$window.on("scroll", function() {
			loadingEffects();
		});
	};
 
/* #Filter for posts shortcode
================================================== */
    var DTMasonryControls = (function () {
        function DTMasonryControls(config) {
            var defaults = {
                paginatorContainer: null,
                postLimit: 1,
                curPage: 1,
                items: [],
            filter: null,
                onPaginate: function () {
                }
            };

            this.config = $.extend(defaults, config);
        }

        DTMasonryControls.prototype.setCurPage = function (curPage) {
            this.config.curPage = parseInt(curPage);
        };

        DTMasonryControls.prototype.getCurPage = function () {
            return this.config.curPage;
        };

        DTMasonryControls.prototype.reset = function (items) {
            this.config.items = items;
            this.setCurPage(1);
            this.appendControls();
            this._filterByCurPage();
        };

        DTMasonryControls.prototype.appendControls = function () {
        };

        DTMasonryControls.prototype._filterByCurPage = function () {
            this.showItem(this.config.items);
        };

        DTMasonryControls.prototype.hideItem = function (item) {
            item.removeClass('visible').addClass('hidden').hide();
        };

        DTMasonryControls.prototype.showItem = function (item) {
            item.addClass('visible').removeClass('hidden').show();
        };

        DTMasonryControls.prototype.applyLoadingEffects = function () {
            this.lazyLoadImages();
            loadingEffects();
        };

        DTMasonryControls.prototype.lazyLoadImages = function () {
            if (this.config.items) {
                this.config.items.filter('.visible').IsoLayzrJqInitialisation();
            }
        };

        DTMasonryControls.prototype.layoutItems = function () {
            this._filterByCurPage();

            if (this.config.filter && typeof this.config.filter.layoutItems === "function") {
                this.config.filter.layoutItems();
            }
        };

        return DTMasonryControls;
    }());

    var DTMasonryPaginationControls = (function () {
        function DTMasonryPaginationControls(config) {
            DTMasonryControls.call(this, config);

            var defaults = {
                previousButtonClass: '',
                previousButtonLabel: '',
                pagerClass: '',
                nextButtonClass: '',
                nextButtonLabel: '',
                activeClass: 'act',
                pagesToShow: 5
            };

            this.config = $.extend(defaults, this.config);

            this.appendControls();

            $('a.act', this.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
        }

        DTMasonryPaginationControls.prototype = new DTMasonryControls();

        DTMasonryPaginationControls.prototype.addEvents = function () {
            var self = this;
            $('a', this.config.paginatorContainer).not('.dots').on('click.dtPostsPaginationFilter', {self: this}, function(event, onSetup) {
                self.config.onPaginate.call(this, event, onSetup);
            });
            $('a.dots', this.config.paginatorContainer).on('click.dtPostsPaginationDots', {self: this}, function(event) {
                event.preventDefault();
                event.data.self.config.paginatorContainer.find('div:hidden a').unwrap();
                event.data.self.config.paginatorContainer.find('a.dots').remove();
            });
        };

        DTMasonryPaginationControls.prototype.appendControls = function () {
            var pageControls = this.config.paginatorContainer;
            var pageCount = Math.ceil(this.config.items.length / this.config.postLimit);
            var activePage = this.config.curPage;

            pageControls.empty();

            if (pageCount <= 1) {
                pageControls.addClass("hidden");
                return;
            } else {
                pageControls.removeClass("hidden");
            }

            var i, _i;

            if (activePage !== 1) {
                pageControls.prepend('<a href="#" class="' + this.config.previousButtonClass + '" data-page-num="' + (activePage - 1) + '">' + this.config.previousButtonLabel + '</a>');
            }

            var pagesToShow = this.config.pagesToShow | 5;
            var pagesToShowMinus1 = pagesToShow - 1;
            var pagesBefore = Math.floor(pagesToShowMinus1 / 2);
            var pagesAfter = Math.ceil(pagesToShowMinus1 / 2);
            var startPage = Math.max(activePage - pagesBefore, 1);
            var endPage = activePage + pagesAfter;

            if (startPage <= pagesBefore) {
                endPage = startPage + pagesToShowMinus1;
            }

            if (endPage > pageCount) {
                startPage = Math.max(pageCount - pagesToShowMinus1, 1);
                endPage = pageCount;
            }

            var dots = '<a href="javascript:void(0);" class="dots">…</a>';
            var leftPagesPack = $('<div style="display: none;"></div>');
            var rightPagesPack = $('<div style="display: none;"></div>');

            for (i = _i = 1; 1 <= pageCount ? _i <= pageCount : _i >= pageCount; i = 1 <= pageCount ? ++_i : --_i) {
                if (i < startPage && i != 1) {
                    leftPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                    continue;
                }

                if (i == startPage && leftPagesPack.children().length) {
                    pageControls.append(leftPagesPack).append($(dots));
                }

                if (i > endPage && i != pageCount) {
                    rightPagesPack.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
                    continue;
                }

                if (i == pageCount && rightPagesPack.children().length) {
                    pageControls.append(rightPagesPack).append($(dots));
                }

                pageControls.append('<a href="#" class="' + this.config.pagerClass + '" data-page-num="' + +i + '">' + i + '</a>');
            }

            if (activePage < pageCount) {
                pageControls.append('<a href="#" class="' + this.config.nextButtonClass + '" data-page-num="' + (activePage + 1) + '">' + this.config.nextButtonLabel + '</a>');
            }
            pageControls.find('a[data-page-num="' + activePage + '"]').addClass(this.config.activeClass);

            this.addEvents();
        };

        DTMasonryPaginationControls.prototype._filterByCurPage = function () {
            var self = this;
            this.config.items.get().map(function (item, index) {
                if (self._showOnCurPage(index + 1)) {
                    self.showItem($(item));
                } else {
                    self.hideItem($(item));
                }
            });
        };

        DTMasonryPaginationControls.prototype._showOnCurPage = function (index) {
            return this.config.postLimit <= 0 || ( this.config.postLimit * (this.getCurPage() - 1) < index && index <= this.config.postLimit * this.getCurPage() );
        };

        DTMasonryPaginationControls.prototype._setAsActive = function (item) {
            item.addClass('act').siblings().removeClass('act');
        };

        return DTMasonryPaginationControls;
    }());

    var DTMasonryLoadMoreControls = (function () {
        function DTMasonryLoadMoreControls(config) {
            DTMasonryControls.call(this, config);

            this.appendControls();
            this.addEvents();
            this.layoutItems();
            this.applyLoadingEffects();
        }

        DTMasonryLoadMoreControls.prototype = new DTMasonryControls();

        DTMasonryLoadMoreControls.prototype.addEvents = function () {
            $('a', this.config.paginatorContainer).on('click.dtPostsPaginationFilter', {self: this}, this.config.onPaginate);
        };

        DTMasonryLoadMoreControls.prototype.appendControls = function () {
            var pageControls = this.config.paginatorContainer;
            var maxPages = Math.ceil(this.config.items.length / this.config.postLimit);

            if (this.config.curPage < maxPages) {
                pageControls.removeClass("hidden");
            } else {
                pageControls.addClass("hidden");
            }
        };

        DTMasonryLoadMoreControls.prototype._filterByCurPage = function () {
            var self = this;
            var postsToShow = self.getCurPage() * self.config.postLimit;

            this.config.items.get().map(function (item, index) {
                if (index < postsToShow) {
                    self.showItem($(item));
                } else {
                    self.hideItem($(item));
                }
            });
        };

        return DTMasonryLoadMoreControls;
    }());

    var DTIsotopeFilter = (function () {
        function DTIsotopeFilter(config) {
            var defaults = {
                onCategoryFilter: function () {
                },
                onOrderFilter: function () {
                },
                onOrderByFilter: function () {
                },
                categoryContainer: null,
                orderContainer: null,
                orderByContainer: null,
                postsContainer: null,
                order: 'desc',
                orderBy: 'date',
                curCategory: '*'
            };
            this.config = $.extend(defaults, config);

            this.addEvents();
        }

        DTIsotopeFilter.prototype.addEvents = function () {
            var self = this;
            this.config.categoryContainer && $('a', this.config.categoryContainer).on('click.dtPostsCategoryFilter', {self: this}, function(event) {
                self.config.onCategoryFilter.call(this, event);
            });
            this.config.orderContainer && $('a', this.config.orderContainer).on('click.dtPostsOrderFilter', {self: this}, function(event) {
                self.config.onOrderFilter.call(this, event);
            });
            this.config.orderByContainer && $('a', this.config.orderByContainer).on('click.dtPostsOrderByFilter', {self: this}, function(event) {
                self.config.onOrderByFilter.call(this, event);
            });
        };

        DTIsotopeFilter.prototype.setOrder = function (order) {
            this.config.order = order;
        };

        DTIsotopeFilter.prototype.setOrderBy = function (orderBy) {
            this.config.orderBy = orderBy;
        };

        DTIsotopeFilter.prototype.setCurCategory = function (curCategory) {
            this.config.curCategory = curCategory;
        };

        DTIsotopeFilter.prototype.getFilteredItems = function () {
            return $(this.config.postsContainer.isotope('getFilteredItemElements'));
        };

        DTIsotopeFilter.prototype.getItems = function () {
            return $(this.config.postsContainer.isotope('getItemElements'));
        };

        DTIsotopeFilter.prototype.layoutItems = function () {
            this.layout();
            this.config.postsContainer.trigger("updateReady");
        };

        DTIsotopeFilter.prototype.layout = function () {
            this.config.postsContainer.isotope('layout');
        };

        DTIsotopeFilter.prototype.scrollToTopOfContainer = function (onComplite, bindTo) {
            var scrollTo = this.config.postsContainer.parent();
            var phantomStickyExists = $(".phantom-sticky").exists(),
                sideHeaderHStrokeExists = $(".sticky-top-line").exists();
                if(phantomStickyExists || sideHeaderHStrokeExists){
                    var $phantom = $(".masthead");
                }else{
                    var $phantom = $("#phantom");
                }
            $("html, body").animate({
                scrollTop: scrollTo.offset().top - $phantom.height() - 50
            }, 400, onComplite ? onComplite.bind(bindTo | this) : undefined);
        };

        DTIsotopeFilter.prototype._filterPosts = function () {
            this.config.postsContainer && this.config.postsContainer.isotope({
                filter: this.config.curCategory,
                sortAscending: 'asc' == this.config.order,
                sortBy: this.config.orderBy
            });
        };

        DTIsotopeFilter.prototype._setAsActive = function (item) {
            item.addClass('act').siblings().removeClass('act');
        };

        return DTIsotopeFilter;
    }());

    var DTJGridFilter = (function () {
        function DTJGridFilter(config) {
            DTIsotopeFilter.call(this, config);

            var defaults = {
                showOnCurPage: function() {}
            };
            this.config = $.extend(defaults, this.config);
            this.items = this.config.postsContainer.find('.wf-cell');
            this.filteredItems = this.items;
        }

        DTJGridFilter.prototype = new DTIsotopeFilter();

        DTJGridFilter.prototype.getFilteredItems = function () {
            return this.filteredItems;
        };

        DTJGridFilter.prototype.getItems = function () {
            return this.items;
        };

        DTJGridFilter.prototype.layout = function () {
            var self = this;

            // category filter emulation
            self.items.css("display", "none");
            var itemsCount = 0;
            var visibleItems = [];
            self.filteredItems.each(function() {
                if ( self.config.showOnCurPage( ++itemsCount ) ) {
                    $(this).css("display", "block");
                    visibleItems.push( this );
                }
            });

            visibleItems = $(visibleItems);
            self.config.postsContainer.data('visibleItems', visibleItems);
            self.config.postsContainer.collage({ images: visibleItems });
        };

        DTJGridFilter.prototype._filterPosts = function() {
            var self = this;
            self.filteredItems = self.items.filter(self.config.curCategory);
        };

        return DTJGridFilter;
    }());

    var DTJQueryFilter = (function() {
        function DTJQueryFilter(config) {
            DTIsotopeFilter.call(this, config);

            this.items = this.config.postsContainer.find('.wf-cell');
            this.filteredItems = this.items;
        }

        DTJQueryFilter.prototype = new DTIsotopeFilter();

        DTJQueryFilter.prototype.getFilteredItems = function () {
            return this.filteredItems;
        };

        DTJQueryFilter.prototype.getItems = function () {
            return this.items;
        };

        DTJQueryFilter.prototype.layout = function () {};

         DTJQueryFilter.prototype._filterPosts = function() {
             this.items.hide();
             this.filteredItems = this._sortItems(this.items.filter(this.config.curCategory));
             this.filteredItems.detach().prependTo(this.config.postsContainer);
             this.filteredItems.show();
        };

        DTJQueryFilter.prototype._sortItems = function(items) {
            var activeSort = this.config.orderBy;
            var activeOrder = this.config.order;
            var $nodes = $([]);
            $nodes.$nodesCache = $([]);

            items.each(function() {
                var $this = $(this);
                $nodes.push({
                    node: this,
                    $node: $this,
                    name: $this.attr("data-name"),
                    date: new Date($this.attr("data-date"))
                });
            });

            if (activeSort === "date" && activeOrder ==="desc") {
                $nodes.sort(function(a, b){return b.date - a.date});
            }
            else if (activeSort === "date" && activeOrder ==="asc") {
                $nodes.sort(function(a, b){return a.date - b.date});
            }
            else if (activeSort === "name" && activeOrder ==="desc") {
                $nodes.sort(function(a, b){
                    var x = a.name.toLowerCase();
                    var y = b.name.toLowerCase();
                    if (x > y) {return -1;}
                    if (x < y) {return 1;}
                    return 0;
                });
            }
            else if (activeSort === "name" && activeOrder ==="asc") {
                $nodes.sort(function(a, b){
                    var x = a.name.toLowerCase();
                    var y = b.name.toLowerCase();
                    if (x < y) {return -1;}
                    if (x > y) {return 1;}
                    return 0;
                });
            }

            $nodes.each(function() {
                $nodes.$nodesCache.push(this.node);
            });

            return $nodes.$nodesCache;
        };

        return DTJQueryFilter;
    }());

    $('.dt-shortcode.with-isotope').each(function () {
        var $this = $(this);
        var $container = $this.find('.iso-grid, .iso-container');
        var isIsotopeContainer = $container.hasClass('dt-isotope');
        var filterConfig = {
            postsContainer: $container,
            categoryContainer: $this.find('.filter-categories'),
            curCategory: $this.find('.filter-categories a.act').attr('data-filter'),
        };

        if (isIsotopeContainer) {
            var order = $this.find('.filter-extras .filter-sorting a.act').attr('data-sort');
            if (!order) {
                order = $this.find('.filter-categories').attr('data-default-order');
            }

            var orderBy = $this.find('.filter-extras .filter-by a.act').attr('data-by');
            if (!orderBy) {
                orderBy = $this.find('.filter-categories').attr('data-default-orderby');
            }

            // Masonry short code.
            $.extend(filterConfig, {
                order: order,
                orderBy: orderBy,
                orderByContainer: $this.find('.filter-extras .filter-by'),
                orderContainer: $this.find('.filter-extras .filter-sorting'),
                onCategoryFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setCurCategory(item.attr('data-filter'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                },
                onOrderFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setOrder(item.attr('data-sort'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                },
                onOrderByFilter: function (event) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self.config.postsContainer.resetEffects();

                    self._setAsActive(item);
                    self.setOrderBy(item.attr('data-by'));
                    self._filterPosts();

                    paginator.hideItem(self.getItems());
                    paginator.reset(self.getFilteredItems());

                    self.layout();
                    self.config.postsContainer.IsoLayzrInitialisation();
                    lazyLoading();
                    loadingEffects();
                }
            });
            var isoFilter = new DTIsotopeFilter(filterConfig);
            var paginator = new DTMasonryPaginationControls({
                previousButtonClass: 'nav-prev',
                previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
                nextButtonClass: 'nav-next',
                nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
                postLimit: $container.attr('data-posts-per-page'),
                curPage: 1,
                pagesToShow: ($container.hasClass('show-all-pages') ? 999 : 5),
                items: isoFilter.getFilteredItems(),
                paginatorContainer: $this.find('.paginator'),
                onPaginate: function (event, onSetup) {
                    event.preventDefault();

                    var item = $(this);
                    var self = event.data.self;

                    self._setAsActive(item);
                    self.setCurPage(item.attr('data-page-num'));
                    self._filterByCurPage();
                    isoFilter.layout();

                    if (!onSetup) {
                        self.appendControls();
                        isoFilter.scrollToTopOfContainer();
                    }
                }
            });
        } else {
            // JGrid short code.
            var isoFilter = new DTJGridFilter(filterConfig);
            var paginator = new DTMasonryPaginationControls({
                previousButtonClass: 'nav-prev',
                previousButtonLabel: '<i class="dt-icon-the7-arrow-0-42" aria-hidden="true"></i>',
                nextButtonClass: 'nav-next',
                nextButtonLabel: '<i class="dt-icon-the7-arrow-0-41" aria-hidden="true"></i>',
                postLimit: $container.attr('data-posts-per-page'),
                curPage: 1,
                pagesToShow: ($container.hasClass('show-all-pages') ? 999 : 5),
                items: isoFilter.getFilteredItems(),
                paginatorContainer: $this.find('.paginator'),
            });
            isoFilter.config.onCategoryFilter = function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setCurCategory(item.attr('data-filter'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layout();
                lazyLoading();
                loadingEffects();
            };
            isoFilter.config.showOnCurPage = function (index) {
                return paginator._showOnCurPage(index);
            };
            paginator.config.onPaginate = function (event, onSetup) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self._setAsActive(item);
                self.setCurPage(item.attr('data-page-num'));
                self._filterByCurPage();
                isoFilter.layout();

                if (!onSetup) {
                    self.appendControls();
                    isoFilter.scrollToTopOfContainer();
                }
            };

            // Trigger pagination after setup once again after providing proper callback.
            $('a.act', paginator.config.paginatorContainer).trigger('click.dtPostsPaginationFilter', {onSetup: true});
        }
    });

    window.the7ApplyMasonryJsFiltering = function($element) {
        var $container = $element.find('.iso-grid, .iso-container');
        var $paginator = $element.find(".paginator");
        var isLazyLoading = $element.hasClass("lazy-loading-mode");

        var order = $element.find('.filter-extras .filter-sorting a.act').attr('data-sort');
        if (!order) {
            order = $element.find('.filter-categories').attr('data-default-order');
        }

        var orderBy = $element.find('.filter-extras .filter-by a.act').attr('data-by');
        if (!orderBy) {
            orderBy = $element.find('.filter-categories').attr('data-default-orderby');
        }

        if ($element.is(".content-rollover-layout-list:not(.disable-layout-hover)")) {
            $container.on("updateReady", function() {
                $(this).find(".wf-cell.visible .post-entry-wrapper").clickOverlayGradient();
            });
        }

        var filterConfig = {
            order: order,
            orderBy: orderBy,
            curCategory: $element.find('.filter-categories a.act').attr('data-filter'),
            postsContainer: $container,
            categoryContainer: $element.find('.filter-categories'),
            orderByContainer: $element.find('.filter-extras .filter-by'),
            orderContainer: $element.find('.filter-extras .filter-sorting'),
            onCategoryFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setCurCategory(item.attr('data-filter'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            },
            onOrderFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setOrder(item.attr('data-sort'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            },
            onOrderByFilter: function (event) {
                event.preventDefault();

                var item = $(this);
                var self = event.data.self;

                self.config.postsContainer.resetEffects();

                self._setAsActive(item);
                self.setOrderBy(item.attr('data-by'));
                self._filterPosts();

                paginator.hideItem(self.getItems());
                paginator.reset(self.getFilteredItems());

                self.layoutItems();
                self.config.postsContainer.IsoLayzrInitialisation();
                applyLazyLoadingPagination();
                loadingEffects();
            }
        };

        var isoFilter = new DTIsotopeFilter(filterConfig);

        switch ($element.attr('data-pagination-mode')) {
            case 'load-more':
                var paginator = new DTMasonryLoadMoreControls({
                    postLimit: $element.attr("data-post-limit"),
                    curPage: 1,
                    items: isoFilter.getFilteredItems(),
                    filter: isoFilter,
                    paginatorContainer: $paginator,
                    onPaginate: function (event) {
                        var self = event.data.self;

                        event.preventDefault();
                        self.setCurPage(self.getCurPage() + 1);
                        self.layoutItems();
                        self.applyLoadingEffects();
                        self.appendControls();
                    }
                });
                break;
            case 'pages':
                var previousButtonLabel = "<i class=\"dt-icon-the7-arrow-0-42\" aria-hidden=\"true\"></i>";
                var nextButtonLabel = "<i class=\"dt-icon-the7-arrow-0-41\" aria-hidden=\"true\"></i>";
                var pagerClass = "page";

                // It's ugly but simple enough.
                if ($element.is("[class*='the7_elements-']")) {
                    previousButtonLabel = "<i class=\"dt-icon-the7-arrow-35-1\" aria-hidden=\"true\"></i>";
                    nextButtonLabel = "<i class=\"dt-icon-the7-arrow-35-2\" aria-hidden=\"true\"></i>";
                    pagerClass = "page-numbers filter-item";
                }

                var paginator = new DTMasonryPaginationControls({
                    previousButtonClass: 'nav-prev',
                    previousButtonLabel: previousButtonLabel,
                    nextButtonClass: 'nav-next',
                    nextButtonLabel: nextButtonLabel,
                    pagerClass: pagerClass,
                    postLimit: $element.attr('data-post-limit'),
                    curPage: 1,
                    pagesToShow: ($element.hasClass('show-all-pages') ? 999 : 5),
                    items: isoFilter.getFilteredItems(),
                    filter: isoFilter,
                    paginatorContainer: $paginator,
                    onPaginate: function (event, onSetup) {
                        var item = $(this);
                        var self = event.data.self;

                        event.preventDefault();
                        self._setAsActive(item);
                        self.setCurPage(item.attr('data-page-num'));
                        self.layoutItems();

                        if (!onSetup) {
                            self.appendControls();
                            isoFilter.scrollToTopOfContainer();
                        }

                        self.applyLoadingEffects();
                    }
                });
                break;
            default:
                // Dummy pagination.
                var paginator = new DTMasonryControls();
        }

        function lazyLoading() {
            var $button = $paginator.find(".button-load-more");
            var buttonOffset = $button.offset();

            if ( $paginator.hasClass("hidden") ) {
                removeLazyLoadingPagination();
            }

            if (buttonOffset && $window.scrollTop() > (buttonOffset.top - $window.height()) / 2) {
                $button.trigger("click");
            }
        }

        function removeLazyLoadingPagination() {
            $window.off("scroll", lazyLoading);
        }

        function applyLazyLoadingPagination() {
            if (isLazyLoading) {
                removeLazyLoadingPagination();
                $window.on("scroll", lazyLoading);
                lazyLoading();
            }
        }

        applyLazyLoadingPagination();
    };

    $('.mode-masonry.jquery-filter, .mode-grid.jquery-filter:not(.dt-css-grid-wrap)').one("IsoReady", function() {
        the7ApplyMasonryJsFiltering($(this));
    });

    if(typeof owlCarouselOrigin != 'undefined'){
        $.fn.owlCarousel = owlCarouselOrigin;
    }

});
