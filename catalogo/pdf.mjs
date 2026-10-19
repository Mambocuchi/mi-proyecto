import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
const [,, html, pdf, png] = process.argv;
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 794, height: 1123 }, deviceScaleFactor: 1.5 });
await p.goto('file://' + html); await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(400);
const over = await p.evaluate(() => [...document.querySelectorAll('.page')].map((pg, i) => { const f = pg.querySelector('.foot'); const prev = f && f.previousElementSibling; return [i + 1, prev ? Math.round(pg.getBoundingClientRect().bottom - prev.getBoundingClientRect().bottom - f.offsetHeight) : null]; }));
console.log('espacio libre sobre el pie (px):', JSON.stringify(over));
await p.pdf({ path: pdf, format: 'A4', printBackground: true, preferCSSPageSize: true });
if (png) await p.screenshot({ path: png, fullPage: true });
await b.close();
