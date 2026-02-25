<?php
add_action("wp_head", function() {
    if (is_page(9862)) {
        echo '<style>
body.page-id-9862 { background: #fff !important; }
body.page-id-9862 .site-main { background: #fff !important; }
body.page-id-9862 .entry-content, body.page-id-9862 article { background: #fff !important; }

.imporlan-page { max-width: 960px; margin: 0 auto; padding: 40px 20px; font-family: "Atkinson Hyperlegible", -apple-system, BlinkMacSystemFont, sans-serif; color: #1a1a2e; background: #fff; }

.imporlan-hero { background: linear-gradient(135deg, #0a1628 0%, #0d2847 60%, #0a1628 100%); border-radius: 16px; padding: 50px 40px; text-align: center; margin-bottom: 40px; position: relative; overflow: hidden; }
.imporlan-hero::before { content: ""; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(0,212,255,0.08) 0%, transparent 60%); animation: heroGlow 6s ease-in-out infinite; }
@keyframes heroGlow { 0%,100% { transform: scale(1); opacity: 0.5; } 50% { transform: scale(1.1); opacity: 1; } }
.imporlan-hero h1 { color: #fff; font-size: 32px; font-weight: 800; margin: 0 0 12px; position: relative; }
.imporlan-hero h1 span { color: #00d4ff; }
.imporlan-hero p { color: rgba(255,255,255,0.85); font-size: 17px; line-height: 1.6; margin: 0 0 25px; position: relative; max-width: 700px; margin-left: auto; margin-right: auto; }
.imporlan-hero-img { width: 100%; max-width: 600px; border-radius: 12px; margin-bottom: 25px; position: relative; box-shadow: 0 8px 32px rgba(0,212,255,0.2); }

.imporlan-cta-row { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; position: relative; }
.imporlan-cta { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 10px; font-weight: 700; font-size: 15px; text-decoration: none !important; transition: all 0.3s ease; }
.imporlan-cta-primary { background: #00d4ff; color: #0a1628 !important; }
.imporlan-cta-primary:hover { background: #33e0ff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,212,255,0.4); color: #0a1628 !important; }
.imporlan-cta-secondary { background: transparent; color: #fff !important; border: 2px solid rgba(255,255,255,0.3); }
.imporlan-cta-secondary:hover { border-color: #00d4ff; color: #00d4ff !important; transform: translateY(-2px); }
.imporlan-cta-wp { background: #25D366; color: #fff !important; }
.imporlan-cta-wp:hover { background: #20bd5a; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.4); color: #fff !important; }

.imporlan-section { margin-bottom: 36px; }
.imporlan-section h2 { font-size: 26px; font-weight: 800; color: #0a1628; margin: 0 0 16px; padding-bottom: 10px; border-bottom: 3px solid #00d4ff; display: inline-block; }
.imporlan-section h3 { font-size: 20px; font-weight: 700; color: #0d2847; margin: 28px 0 14px; }
.imporlan-section p { font-size: 16px; line-height: 1.7; color: #333; margin: 0 0 14px; }
.imporlan-section a { color: #00d4ff; text-decoration: none; font-weight: 600; transition: color 0.2s; }
.imporlan-section a:hover { color: #0099cc; text-decoration: underline; }

.imporlan-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin: 20px 0; }
.imporlan-card { background: #f0f9ff; border-radius: 12px; padding: 22px; border-left: 4px solid #00d4ff; transition: transform 0.2s, box-shadow 0.2s; }
.imporlan-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
.imporlan-card strong { color: #0a1628; font-size: 16px; display: block; margin-bottom: 6px; }
.imporlan-card p { font-size: 14px; color: #555; margin: 0; line-height: 1.5; }

.imporlan-benefits { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin: 20px 0; }
.imporlan-benefit { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 20px; text-align: center; transition: all 0.3s; }
.imporlan-benefit:hover { border-color: #00d4ff; box-shadow: 0 4px 16px rgba(0,212,255,0.15); }
.imporlan-benefit-icon { font-size: 36px; margin-bottom: 10px; }
.imporlan-benefit strong { color: #0a1628; font-size: 15px; display: block; margin-bottom: 6px; }
.imporlan-benefit p { font-size: 13px; color: #666; margin: 0; line-height: 1.5; }

.imporlan-steps { counter-reset: step; margin: 20px 0; }
.imporlan-step { display: flex; gap: 16px; align-items: flex-start; margin-bottom: 18px; padding: 18px; background: #fff; border-radius: 12px; border: 1px solid #e8e8e8; transition: all 0.3s; }
.imporlan-step:hover { border-color: #00d4ff; box-shadow: 0 2px 12px rgba(0,212,255,0.1); }
.imporlan-step::before { counter-increment: step; content: counter(step); background: linear-gradient(135deg, #0a1628, #0d2847); color: #00d4ff; font-size: 20px; font-weight: 800; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.imporlan-step div strong { color: #0a1628; font-size: 15px; display: block; margin-bottom: 4px; }
.imporlan-step div p { font-size: 14px; color: #555; margin: 0; line-height: 1.5; }

.imporlan-boats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin: 20px 0; }
.imporlan-boat-type { background: linear-gradient(135deg, #0a1628, #0d2847); border-radius: 12px; padding: 20px; text-align: center; color: #fff; transition: transform 0.3s; }
.imporlan-boat-type:hover { transform: translateY(-4px); }
.imporlan-boat-type .boat-emoji { font-size: 32px; display: block; margin-bottom: 8px; }
.imporlan-boat-type strong { color: #00d4ff; font-size: 14px; }
.imporlan-boat-type p { font-size: 12px; color: rgba(255,255,255,0.7); margin: 4px 0 0; }

.imporlan-panel-box { background: linear-gradient(135deg, #0a1628 0%, #0d2847 100%); border-radius: 16px; padding: 35px; text-align: center; margin: 30px 0; }
.imporlan-panel-box h3 { color: #fff; font-size: 22px; margin: 0 0 12px; }
.imporlan-panel-box p { color: rgba(255,255,255,0.8); margin: 0 0 8px; font-size: 15px; }
.imporlan-panel-box ul { list-style: none; padding: 0; margin: 16px 0 20px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
.imporlan-panel-box ul li { background: rgba(0,212,255,0.1); border: 1px solid rgba(0,212,255,0.3); border-radius: 8px; padding: 8px 16px; color: #00d4ff; font-size: 13px; }

.imporlan-bottom-cta { background: #fff; border: 2px solid #00d4ff; border-radius: 16px; padding: 35px; text-align: center; margin-top: 30px; }
.imporlan-bottom-cta h3 { color: #0a1628; font-size: 22px; margin: 0 0 10px; }
.imporlan-bottom-cta p { color: #555; font-size: 15px; margin: 0 0 20px; }

@media (max-width: 768px) {
  .imporlan-hero { padding: 30px 20px; }
  .imporlan-hero h1 { font-size: 24px; }
  .imporlan-hero p { font-size: 15px; }
  .imporlan-section h2 { font-size: 22px; }
  .imporlan-cta { padding: 12px 20px; font-size: 14px; }
  .imporlan-boats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>';
    }
});
