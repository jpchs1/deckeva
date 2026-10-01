// Una captura del cotizador de deckeva.cl por cada tamaño, más el precio que muestra.
// Uso: npm i playwright · node capturas.js (con HTTPS_PROXY si hay proxy). Deja out/*.jpg y out/manifiesto.json:
// las imágenes van a staging/img/valores-wa/ y los precios a DECKEVA_WA_VALORES (deckeva-whatsapp-valores.php).
const { chromium } = require('playwright');
const fs = require('fs');
(async () => {
  const proxy = process.env.HTTPS_PROXY ? { server: process.env.HTTPS_PROXY } : undefined;
  const b = await chromium.launch({ proxy, args: ['--ignore-certificate-errors'] });
  const p = await b.newPage({ viewport: { width: 1280, height: 1000 }, deviceScaleFactor: 1.5, ignoreHTTPSErrors: true });
  await p.goto('https://deckeva.cl/#cotizar', { waitUntil: 'networkidle', timeout: 90000 }).catch(() => {});
  // Fuera lo que flota encima (barras, header fijo, botón de subir, chat).
  await p.evaluate(() => {
    for (const el of document.querySelectorAll('body *')) {
      const pos = getComputedStyle(el).position;
      if (pos === 'fixed' || pos === 'sticky') el.style.setProperty('display', 'none', 'important');
    }
  });
  const ops = await p.$$eval('#sizeSelect option', os => os.map(o => o.value).filter(v => /^(\d{2}|moto-normal|moto-grande)\|\d+$/.test(v)));
  const manifiesto = {};
  for (const v of ops) {
    const [clave, clp] = v.split('|');
    await p.selectOption('#sizeSelect', v);
    await p.waitForTimeout(600);
    const caja = await p.evaluate(() => {
      const sec = document.getElementById('cotizar');
      const precio = [...sec.querySelectorAll('*')].find(e => /PRECIO ESTIMADO/i.test(e.textContent) && e.children.length > 2 && e.getBoundingClientRect().height < 400);
      const s = sec.getBoundingClientRect(), pr = (precio || sec).getBoundingClientRect();
      return { top: s.top + window.scrollY, bottom: pr.bottom + window.scrollY, left: s.left, width: s.width };
    });
    const archivo = clave + '.jpg';
    await p.screenshot({ path: 'out/' + archivo, type: 'jpeg', quality: 82, fullPage: true,
      clip: { x: Math.max(caja.left + 150, 0), y: caja.top + 40, width: Math.min(980, caja.width), height: caja.bottom - caja.top - 10 } });
    manifiesto[clave] = { clp: parseInt(clp, 10), archivo };
    console.log(clave, clp);
  }
  fs.writeFileSync('out/manifiesto.json', JSON.stringify(manifiesto, null, 2));
  await b.close();
})();
