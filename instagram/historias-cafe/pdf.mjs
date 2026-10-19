import { chromium } from '/opt/node22/lib/node_modules/playwright/index.mjs';
const [,, html, pdf] = process.argv;
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 1080, height: 1920 } });
await p.goto('file://' + html);
await p.addStyleTag({ content: '@page{size:1080px 1920px;margin:0} body{background:none!important} .story{margin:0!important;page-break-after:always} .story:last-child{page-break-after:auto}' });
await p.evaluate(() => document.fonts.ready); await p.waitForTimeout(300);
await p.pdf({ path: pdf, width: '1080px', height: '1920px', printBackground: true, preferCSSPageSize: true });
await b.close();
