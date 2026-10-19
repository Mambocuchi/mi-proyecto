import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
const [,, html, outdir] = process.argv;
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 1080, height: 1920 } });
await p.goto('file://' + html); await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(300);
const n = await p.locator('.story').count();
for (let i = 0; i < n; i++) await p.locator('.story').nth(i).screenshot({ path: `${outdir}/historia-cafe-${i + 1}.png` });
await b.close(); console.log(n);
