import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
const [,, html, pdf] = process.argv;
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 1200, height: 1000 } });
await p.goto('file://' + html); await p.waitForTimeout(300);
await p.pdf({ path: pdf, width: '1200px', height: '1000px', printBackground: true, preferCSSPageSize: true });
await b.close();
