import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
const [,, html, png, pdf] = process.argv;
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 1080, height: 1350 } });
await p.goto('file://' + html); await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(300);
const over = await p.evaluate(() => { const t = document.querySelector('.tabla').getBoundingClientRect(); const l = document.querySelector('.pie').getBoundingClientRect(); return [Math.round(t.bottom), Math.round(l.top), [...document.querySelectorAll('.fila')].map(f => Math.round(f.getBoundingClientRect().height))]; });
console.log(JSON.stringify(over));
await p.locator('.post').screenshot({ path: png });
if (pdf) await p.pdf({ path: pdf, width: '1080px', height: '1350px', printBackground: true, preferCSSPageSize: true });
await b.close();
