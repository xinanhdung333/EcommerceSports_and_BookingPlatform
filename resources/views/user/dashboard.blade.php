@extends('layouts.app')
@section('content')
<style>
:root{--az-dark:#131921;--az-navy:#232f3e;--az-yellow:#f0c14b;--az-orange:#ff9900;--az-red:#cc0c39;--az-bg:#eaeded;--az-card:#fff;--az-border:#ddd;--az-muted:#767676;--az-text:#0f1111;--az-link:#007185;--az-lh:#c7511f;}
*,*::before,*::after{box-sizing:border-box;}
.az-topbar{background:var(--az-dark);padding:8px 0;width:100vw;margin-left:calc(50% - 50vw);}
.az-topbar-inner{max-width:1500px;margin:0 auto;padding:0 16px;display:flex;align-items:center;gap:8px;}
.az-logo{color:#fff;font-size:1.35rem;font-weight:900;text-decoration:none;display:flex;align-items:center;gap:6px;white-space:nowrap;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-logo:hover{color:#fff;border-color:#fff;}.az-logo .vn{font-size:.6rem;opacity:.75;display:block;line-height:1;}
.az-deliver{color:#ccc;font-size:.7rem;display:flex;flex-direction:column;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-deliver:hover{border-color:#fff;}.az-deliver strong{color:#fff;font-size:.82rem;}
.az-search{flex:1;display:flex;border-radius:4px;overflow:hidden;min-width:0;}
.az-search-cat{background:#f3f3f3;border:none;padding:0 10px;font-size:.8rem;color:var(--az-text);}
.az-search input{flex:1;border:none;outline:none;padding:0 12px;font-size:.95rem;}
.az-search-btn{background:var(--az-orange);border:none;padding:0 16px;font-size:1.1rem;color:#111;cursor:pointer;border-radius:0 4px 4px 0;}
.az-search-btn:hover{background:#e88900;}
.az-actions{display:flex;align-items:center;gap:4px;flex-shrink:0;}
.az-action-btn{color:#fff;text-decoration:none;font-size:.75rem;display:flex;flex-direction:column;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;background:none;cursor:pointer;}
.az-action-btn:hover{color:#fff;border-color:#fff;}.az-action-btn span:first-child{color:#ccc;font-size:.7rem;}.az-action-btn strong{color:#fff;font-size:.82rem;}
.az-cart-btn{color:#fff;text-decoration:none;display:flex;align-items:flex-end;gap:4px;font-size:.82rem;font-weight:700;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-cart-btn:hover{color:#fff;border-color:#fff;}.az-cart-btn i{font-size:1.5rem;position:relative;}
.az-cart-count{position:absolute;top:-6px;right:-4px;background:var(--az-orange);color:#111;font-size:.7rem;font-weight:800;border-radius:50%;width:16px;height:16px;display:flex;align-items:center;justify-content:center;}
.az-navrow{background:var(--az-navy);padding:6px 0;width:100vw;margin-left:calc(50% - 50vw);}
.az-navrow-inner{max-width:1500px;margin:0 auto;padding:0 8px;display:flex;align-items:center;gap:2px;overflow-x:auto;scrollbar-width:none;}
.az-navrow-inner::-webkit-scrollbar{display:none;}
.az-navlink{color:#fff;text-decoration:none;font-size:.82rem;padding:5px 10px;white-space:nowrap;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-navlink:hover{color:#fff;border-color:#fff;}.az-navlink.hl{border-color:#febd69;color:#febd69;}
.az-flash-pill{margin-left:auto;background:var(--az-red);color:#fff;font-size:.78rem;font-weight:700;padding:4px 12px;border-radius:2px;white-space:nowrap;display:flex;align-items:center;gap:6px;flex-shrink:0;}
.az-wrap{width:100vw;margin-left:calc(50% - 50vw);background:var(--az-bg);}
.az-main{max-width:1500px;margin:0 auto;padding:12px 16px 32px;display:flex;gap:16px;align-items:flex-start;}
.az-sidebar{width:210px;flex-shrink:0;display:flex;flex-direction:column;gap:12px;position:sticky;top:16px;align-self:flex-start;max-height:calc(100vh - 32px);overflow-y:auto;}
.az-sb-box{background:var(--az-card);border:1px solid var(--az-border);border-radius:4px;padding:14px;}
.az-sb-title{font-size:.95rem;font-weight:700;color:var(--az-text);margin:0 0 10px;padding-bottom:8px;border-bottom:1px solid var(--az-border);}
.az-cat-list{list-style:none;margin:0;padding:0;}
.az-cat-item{display:flex;align-items:center;justify-content:space-between;padding:7px 0;font-size:.87rem;color:var(--az-text);text-decoration:none;border-bottom:1px solid #f2f2f2;transition:color .12s;}
.az-cat-item:last-child{border-bottom:none;}.az-cat-item:hover{color:var(--az-lh);}.az-cat-item.all{font-weight:700;}
.az-cat-count{font-size:.75rem;color:var(--az-muted);background:#f0f0f0;padding:1px 7px;border-radius:999px;}
.az-price-list{list-style:none;margin:0;padding:0;}
.az-price-item{display:flex;align-items:center;gap:8px;padding:6px 0;font-size:.86rem;color:var(--az-text);cursor:pointer;border-bottom:1px solid #f5f5f5;}
.az-price-item:last-child{border-bottom:none;}.az-price-item:hover{color:var(--az-lh);}
.az-price-item input[type=checkbox]{accent-color:var(--az-orange);}
.az-content{flex:1;min-width:0;display:flex;flex-direction:column;gap:12px;}
.az-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;}
.az-dashboard-stat{min-height:118px;background:#0f172a;color:#fff;border:0;border-radius:14px;padding:18px 16px;position:relative;overflow:hidden;box-shadow:0 7px 16px rgba(15,23,42,.14);}
.az-dashboard-stat::after{content:"";position:absolute;width:90px;height:90px;right:-35px;top:-35px;border-radius:50%;background:rgba(255,255,255,.035);}
.az-dashboard-stat .az-stat-label{color:#94a3b8;font-size:.62rem;font-weight:800;letter-spacing:.12em;}
.az-dashboard-stat .az-stat-value{color:#fff;font-size:1.65rem;font-weight:900;margin:20px 0 6px;}
.az-dashboard-stat .az-stat-note{color:#a8b3c7;font-size:.62rem;}
.az-dashboard-stat .az-stat-note .up,.az-dashboard-stat .az-stat-note .confirmed-dot,.az-dashboard-stat .az-stat-note .shipping-dot{display:inline-block;padding:3px 7px;border-radius:999px;background:#d1fae5;color:#047857;font-weight:800;}
.az-dashboard-stat .az-stat-note .confirmed-dot{margin-right:3px;}
.az-dashboard-stat .az-stat-note .shipping-dot{background:#fef3c7;color:#b45309;}
.az-dashboard-stat-icon{position:absolute;top:16px;right:16px;width:24px;height:24px;border-radius:50%;background:#283247;display:grid;place-items:center;font-size:12px;z-index:1;}
.az-dashboard-stat-icon.is-confirmed{background:#065f46;color:#22c55e;font-weight:900;}
.az-dashboard-panel{background:#fff;border:1px solid #edf0f5;border-radius:16px;padding:16px;box-shadow:0 3px 12px rgba(15,23,42,.035);}
.az-court-grid,.az-dashboard-products{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px;}
.az-court-card{display:block;padding:12px;background:#fbfcfe;border:1px solid #edf0f5;border-radius:12px;color:var(--az-text);text-decoration:none;transition:border-color .15s,transform .15s;position:relative;}
.az-court-card:hover{border-color:#cbd5e1;color:var(--az-text);transform:translateY(-2px);}
.az-court-icon{width:36px;height:36px;margin-bottom:8px;border-radius:8px;display:grid;place-items:center;font-size:18px;}
.az-court-card::after{content:"";position:absolute;right:12px;top:20px;width:6px;height:6px;border-radius:50%;background:#22c55e;}
.az-court-card:nth-child(2)::after{background:#3b82f6}.az-court-card:nth-child(3)::after{background:#eab308}.az-court-card:nth-child(4)::after{background:#f97316}
.az-court-book{display:inline-block;margin-top:8px;padding:3px 9px;border-radius:999px;background:#0f172a;color:#fff;font-size:.58rem;font-weight:800;}
.az-dashboard-product{min-width:0;background:#fff;border:1px solid #f1f5f9;border-radius:12px;overflow:hidden;}
.az-dashboard-products .az-dashboard-product{border-radius:12px;}
.az-dashboard-product-link{display:block;color:var(--az-text);text-decoration:none;}
.az-dashboard-product-link:hover{color:var(--az-text);}
.az-dashboard-product-image{display:block;width:100%;height:190px;object-fit:contain;background:#f0f3ff;padding:4px;}
.az-dashboard-product:nth-child(2) .az-dashboard-product-image{background:#fff0ee}
.az-dashboard-product:nth-child(3) .az-dashboard-product-image{background:#e9fbf1}
.az-dashboard-product:nth-child(4) .az-dashboard-product-image{background:#fff8df}
.az-dashboard-product-info{padding:10px;}
.az-dashboard-product-name{min-height:34px;margin:4px 0;font-size:.82rem;font-weight:600;line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.az-dashboard-add-cart{width:100%;margin-top:10px;padding:8px;border:0;border-radius:8px;background:#0f172a;color:#fff;font-size:.75rem;font-weight:700;}
.az-dashboard-add-cart:hover{background:#232f3e;}
.az-dashboard-add-cart:disabled{opacity:.6;cursor:wait;}
.az-stat-card{background:var(--az-card);border:1px solid var(--az-border);border-radius:4px;padding:20px 18px;position:relative;overflow:hidden;}
.az-stat-label{font-size:.8rem;color:var(--az-muted);text-transform:uppercase;letter-spacing:.4px;margin:0 0 6px;}
.az-stat-value{font-size:1.85rem;font-weight:700;color:var(--az-text);line-height:1.1;margin:0 0 6px;}
.az-stat-note{font-size:.78rem;color:var(--az-muted);margin:0;display:flex;align-items:center;gap:4px;}
.az-stat-note .up{color:#067d62;}.az-stat-ico{position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:2.4rem;opacity:.08;color:var(--az-text);}
.az-flash{position:relative;overflow:hidden;background:linear-gradient(105deg,#ff6b00,#ff8500);border:0;border-radius:15px;padding:14px 18px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;color:#fff;box-shadow:0 7px 18px rgba(255,107,0,.2);}
.az-flash-mark{width:40px;height:40px;flex:0 0 40px;display:grid;place-items:center;background:#fff;color:#ff6b00;border-radius:11px;font-size:18px;}
.az-flash-copy{flex:1;min-width:200px;}
.az-flash-topline{display:flex;align-items:center;gap:6px;margin-bottom:4px;}
.az-flash-badge{background:#121827;color:#fff;font-weight:900;font-size:.62rem;padding:4px 8px;border-radius:999px;display:flex;align-items:center;gap:5px;white-space:nowrap;}
.az-flash-applies{background:rgba(255,255,255,.24);color:#fff;font-size:.62rem;font-weight:700;padding:4px 8px;border-radius:999px;}
.az-flash-title{font-size:.88rem;color:#fff;font-weight:900;margin:0 0 2px;}.az-flash-title strong{color:#fff;font-size:1.1em;}
.az-flash-meta{font-size:.63rem;color:rgba(255,255,255,.9);margin:0;}
.az-flash-right{display:flex;align-items:center;gap:12px;margin-left:auto;}
.az-flash-timer{display:flex;align-items:center;gap:5px;padding:6px 10px;border-radius:10px;background:rgba(139,62,0,.45);font-size:.58rem;font-weight:800;white-space:nowrap;}
.az-flash-time-unit{display:inline-grid;min-width:23px;place-items:center;padding:4px 5px;border-radius:5px;background:#111827;color:#fff;font-size:.78rem;font-variant-numeric:tabular-nums;}
.az-buy-btn{background:#fff;color:#c2410c;border:0;border-radius:999px;padding:7px 13px;font-size:.72rem;font-weight:800;text-decoration:none;white-space:nowrap;transition:background .15s;}
.az-buy-btn:hover{background:#fff7ed;color:#9a3412;}
.az-sec-hd{display:flex;align-items:baseline;justify-content:space-between;gap:12px;margin-bottom:10px;}
.az-sec-title{font-size:1.05rem;font-weight:700;color:var(--az-text);margin:0;}
.az-sec-link{font-size:.82rem;color:var(--az-link);text-decoration:none;white-space:nowrap;}
.az-sec-link:hover{color:var(--az-lh);text-decoration:underline;}
.az-filter-bar{display:flex;align-items:center;justify-content:flex-end;gap:6px;flex-wrap:wrap;margin-bottom:10px;}
.az-filter-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:999px;border:1px solid #e5e7eb;background:var(--az-card);color:var(--az-text);font-size:.7rem;cursor:pointer;transition:all .15s;}
.az-filter-btn:hover{border-color:#aaa;}.az-filter-btn.active{background:#ffdc35;color:#111;border-color:#ffdc35;}
.az-product-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;}
.az-product-card{background:var(--az-card);border:1px solid var(--az-border);border-radius:4px;overflow:hidden;text-decoration:none;color:var(--az-text);transition:box-shadow .2s;position:relative;display:block;}
.az-product-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.15);color:var(--az-text);}
.az-product-img-wrap{position:relative;width:100%;aspect-ratio:1/1;background:#f7f7f7;overflow:hidden;}
.az-product-img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .3s;}
.az-product-card:hover .az-product-img{transform:scale(1.04);}
.az-product-badge{position:absolute;top:8px;left:8px;background:var(--az-red);color:#fff;font-size:.68rem;font-weight:700;padding:2px 7px;border-radius:2px;text-transform:uppercase;}
.az-product-badge.sale{background:var(--az-orange);}.az-product-badge.hot{background:#067d62;}
.az-product-info{padding:10px 10px 12px;}
.az-product-name{font-size:.84rem;color:var(--az-text);margin:0 0 6px;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.az-price-row{display:flex;align-items:baseline;gap:6px;flex-wrap:wrap;}
.az-price{color:var(--az-red);font-weight:700;font-size:.97rem;margin:0;}
.az-price-old{color:var(--az-muted);font-size:.76rem;text-decoration:line-through;}
.az-product-meta{font-size:.73rem;color:var(--az-muted);margin-top:4px;}
.az-cat-group{margin-top:4px;}
.az-cat-group-hd{display:flex;align-items:center;justify-content:space-between;padding:10px 0 8px;border-bottom:2px solid var(--az-orange);margin-bottom:10px;}
.az-cat-group-title{font-size:.98rem;font-weight:700;color:var(--az-text);margin:0;display:flex;align-items:center;gap:8px;}
.az-cat-group-title::before{content:'';width:4px;height:18px;background:var(--az-orange);border-radius:2px;}
.az-orders{background:var(--az-card);border:1px solid var(--az-border);border-radius:4px;overflow:hidden;}
.az-orders-hd{background:var(--az-navy);color:#fff;padding:12px 16px;font-size:.88rem;font-weight:700;display:flex;align-items:center;gap:8px;}
.az-table{width:100%;border-collapse:collapse;font-size:.86rem;}
.az-table thead th{background:#f9f9f9;color:var(--az-muted);font-weight:600;font-size:.78rem;text-transform:uppercase;letter-spacing:.3px;padding:10px 14px;border-bottom:1px solid var(--az-border);text-align:left;}
.az-table tbody td{padding:10px 14px;border-bottom:1px solid #f5f5f5;color:var(--az-text);}
.az-table tbody tr:hover{background:#fafafa;}.az-table tbody tr:last-child td{border-bottom:none;}
.az-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:3px;font-size:.74rem;font-weight:700;}
.az-badge-ok{background:#e6f3ee;color:#067d62;}.az-badge-wait{background:#fff3e0;color:#e65100;}.az-badge-no{background:#fde8e8;color:var(--az-red);}
.az-orders-ft{padding:10px 16px;text-align:right;border-top:1px solid var(--az-border);}
.az-view-all{color:var(--az-link);font-size:.84rem;text-decoration:none;font-weight:600;}
.az-view-all:hover{color:var(--az-lh);text-decoration:underline;}
.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;padding:16px;z-index:99999;opacity:0;transition:opacity .3s;pointer-events:none;}
.modal-overlay.is-open{opacity:1;pointer-events:auto;}.modal-overlay.is-closing{opacity:0;pointer-events:none;}
.voucher-modal,.shipping-modal{position:relative;width:min(440px,100%);background:#fff;border-radius:12px;box-shadow:0 20px 60px rgba(0,0,0,.18);overflow:hidden;transform:translateY(40px) scale(.93);opacity:0;transition:transform .45s cubic-bezier(.22,1,.36,1),opacity .35s;}
.modal-overlay.is-open .voucher-modal,.modal-overlay.is-open .shipping-modal{transform:translateY(0) scale(1);opacity:1;}
.voucher-modal-header{background:var(--az-red);padding:20px 24px 16px;text-align:center;position:relative;}
.shipping-modal-header{background:#1a73e8;padding:24px 24px 20px;text-align:center;position:relative;}
.voucher-modal-header .close-btn,.shipping-modal-header .close-btn{position:absolute;top:10px;right:12px;border:none;background:rgba(255,255,255,.2);color:#fff;font-size:1.1rem;width:28px;height:28px;border-radius:50%;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;}
.voucher-modal-header .close-btn:hover,.shipping-modal-header .close-btn:hover{background:rgba(255,255,255,.35);}
.voucher-modal-header-label{display:inline-block;background:rgba(255,255,255,.2);color:#fff;font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:4px 10px;border-radius:999px;margin-bottom:10px;}
.voucher-modal-header h3{margin:0 0 4px;font-size:1.5rem;font-weight:800;color:#fff;}.voucher-modal-header p{margin:0;color:rgba(255,255,255,.85);font-size:.88rem;}
.voucher-modal-body{padding:20px 24px 24px;text-align:center;}
.voucher-code-box{display:flex;align-items:center;justify-content:center;margin:0 auto 18px;border:2px dashed var(--az-red);background:#fff5f5;border-radius:8px;padding:12px 18px;max-width:280px;font-size:1.2rem;font-weight:800;color:var(--az-red);letter-spacing:.1em;}
.voucher-copy-btn{border:none;background:var(--az-yellow);color:#111;border-radius:4px;padding:12px 28px;font-weight:700;font-size:.95rem;cursor:pointer;transition:background .2s,transform .15s;width:100%;max-width:280px;}
.voucher-copy-btn:hover{background:#dba52e;transform:translateY(-1px);}.voucher-note{margin-top:12px;color:#888;font-size:.78rem;}
.shipping-icon{display:inline-flex;width:60px;height:60px;align-items:center;justify-content:center;margin-bottom:12px;border-radius:50%;background:rgba(255,255,255,.18);font-size:1.8rem;color:#fff;}
.shipping-modal-header h3{margin:0;font-size:1.4rem;font-weight:800;color:#fff;}
.shipping-modal-body{padding:20px 24px 24px;text-align:center;}
.shipping-modal-body p{margin:0 0 18px;color:#555;font-size:.95rem;line-height:1.7;}.shipping-modal-body strong{color:#1a73e8;}
.shipping-modal-cta{display:inline-block;background:#1a73e8;color:#fff;border:none;border-radius:4px;padding:12px 28px;font-weight:700;font-size:.95rem;cursor:pointer;text-decoration:none;transition:background .2s;width:100%;max-width:280px;text-align:center;}
.shipping-modal-cta:hover{background:#1558c0;color:#fff;}
.toast-noti{position:fixed;top:-100px;right:20px;width:300px;background:#fff;border-left:4px solid var(--az-orange);box-shadow:0 4px 16px rgba(0,0,0,.12);border-radius:4px;display:flex;align-items:center;padding:12px;gap:10px;z-index:9999;transition:opacity .35s,transform .55s;transform:translate3d(0,-24px,0) scale(.96);opacity:0;}
.toast-noti.show{top:80px;opacity:1;transform:translate3d(0,0,0) scale(1);}
.toast-content{flex:1;font-size:.82rem;}.toast-content strong{display:block;margin-bottom:2px;}.toast-content p{margin:0;font-size:.78rem;color:var(--az-muted);}
.toast-close{cursor:pointer;font-size:1.1rem;color:#bbb;padding:4px;}.toast-close:hover{color:var(--az-text);}
@media(max-width:1100px){.az-product-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:900px){.az-sidebar{display:none;}.az-product-grid{grid-template-columns:repeat(3,1fr);}.az-court-grid,.az-dashboard-products{grid-template-columns:repeat(2,minmax(0,1fr));}}
@media(max-width:640px){.az-product-grid{grid-template-columns:repeat(2,1fr);}.az-stats{grid-template-columns:1fr;}.az-topbar-inner{flex-wrap:wrap;}.az-search{order:3;flex:0 0 100%;}.az-deliver{display:none;}.az-dashboard-panel{padding:12px;}.az-dashboard-product-image{height:160px;}}
</style>


{{-- MODALS --}}
@if($homeVoucher)
<div id="voucherOverlay" class="modal-overlay">
    <div class="voucher-modal" role="dialog" aria-modal="true">
        <div class="voucher-modal-header">
            <button type="button" class="close-btn" onclick="closeVoucherOverlay()">×</button>
            <div class="voucher-modal-header-label">🎟 Voucher đặc biệt</div>
            <h3>Ưu đãi dành cho bạn!</h3>
            <p>Giảm <strong style="color:#fff;font-size:1.1em;">{{ number_format($homeVoucher->discount_amount,0,',','.') }}đ</strong> cho đơn từ {{ number_format($homeVoucher->min_order_amount,0,',','.') }}đ</p>
        </div>
        <div class="voucher-modal-body">
            <div class="voucher-code-box"><span id="voucherCodeText">{{ $homeVoucher->code }}</span></div>
            <button type="button" class="voucher-copy-btn" onclick="copyVoucherCode()">Sao chép mã</button>
            <div class="voucher-note">HSD: {{ $homeVoucher->expires_at ? \Carbon\Carbon::parse($homeVoucher->expires_at)->format('d/m/Y') : 'Không giới hạn' }}</div>
        </div>
    </div>
</div>
@endif
@if($freeShippingThreshold > 0)
<div id="shippingOverlay" class="modal-overlay">
    <div class="shipping-modal" role="dialog" aria-modal="true">
        <div class="shipping-modal-header">
            <button type="button" class="close-btn" onclick="closeShippingOverlay()">×</button>
            <div class="shipping-icon"><i class="bi bi-truck"></i></div>
            <h3>Free Ship cho bạn!</h3>
        </div>
        <div class="shipping-modal-body">
            <p>Đơn hàng từ <strong>{{ number_format($freeShippingThreshold,0,',','.') }}đ</strong><br>được miễn phí vận chuyển.</p>
            <a href="{{ route('user.services') }}" class="shipping-modal-cta">Mua ngay</a>
        </div>
    </div>
</div>
@endif

{{-- MAIN --}}
<div class="az-wrap">
<div class="az-main">

{{-- SIDEBAR --}}
<aside class="az-sidebar">
    <div class="az-sb-box">
        <p class="az-sb-title"><i class="bi bi-grid-3x3-gap" style="color:var(--az-orange);"></i> DANH MỤC</p>
        <ul class="az-cat-list">
            <a href="{{ route('user.services') }}" class="az-cat-item all">Tất cả sản phẩm <span class="az-cat-count">{{ $categories->sum(fn($c) => $c->services->count()) }}</span></a>
            @foreach($categories as $cat)
            <a href="{{ route('user.services', ['category' => $cat->id]) }}" class="az-cat-item">{{ $cat->name }}<span class="az-cat-count">{{ $cat->services->count() }}</span></a>
            @endforeach
        </ul>
        <div style="padding-top:10px;border-top:1px solid #f0f0f0;margin-top:4px;"><a href="{{ route('user.services') }}" style="color:var(--az-link);font-size:.82rem;text-decoration:none;">Xem thêm ▼</a></div>
    </div>
    <div class="az-sb-box az-user-menu-box">
        <p class="az-sb-title">MENU TÀI KHOẢN</p>
        <ul class="az-cat-list">
            <a href="{{ route('user.dashboard') }}" class="az-cat-item">Trang chủ <span>›</span></a>
            <a href="{{ route('user.profile') }}" class="az-cat-item">Hồ sơ của tôi <span>›</span></a>
            <a href="{{ route('user.myServices') }}" class="az-cat-item">Đơn hàng đã mua <span>›</span></a>
            <a href="{{ route('user.wishlist') }}" class="az-cat-item">Yêu thích <span>›</span></a>
            <a href="{{ route('user.vouchers') }}" class="az-cat-item">Voucher của tôi <span class="az-cat-count">HOT</span></a>
            <a href="{{ route('user.fields') }}" class="az-cat-item">Đặt sân <span>›</span></a>
            <a href="{{ route('user.chat.index') }}" class="az-cat-item">Hỗ trợ <span>›</span></a>
        </ul>
    </div>
    <div class="az-sb-box">
        <p class="az-sb-title">Giá</p>
        <ul class="az-price-list">
            <li class="az-price-item"><input type="checkbox"> Dưới 500.000đ</li>
            <li class="az-price-item"><input type="checkbox"> 500k - 1 triệu</li>
            <li class="az-price-item"><input type="checkbox"> 1 - 5 triệu</li>
            <li class="az-price-item"><input type="checkbox"> Trên 5 triệu</li>
        </ul>
    </div>
    <div class="az-sb-box">
        <p class="az-sb-title">Đánh giá</p>
        <ul class="az-price-list">
            @foreach([5,4,3] as $star)
            <li class="az-price-item"><input type="checkbox">
                @for($i=1;$i<=$star;$i++)<i class="bi bi-star-fill" style="color:#ff9900;font-size:.82rem;"></i>@endfor
                @for($i=$star+1;$i<=5;$i++)<i class="bi bi-star" style="color:#ddd;font-size:.82rem;"></i>@endfor
                @if($star < 5)<span style="font-size:.75rem;color:var(--az-muted);">&amp; lên</span>@endif
            </li>
            @endforeach
        </ul>
    </div>
</aside>

{{-- CONTENT --}}
<div class="az-content">
    <div class="az-stats">
        <div class="az-dashboard-stat">
            <p class="az-stat-label">TỔNG ĐƠN HÀNG</p>
            <p class="az-stat-value">{{ $stats_total }}</p>
            <p class="az-stat-note"><span class="up">● {{ $stats_pending }} chờ xác nhận</span></p>
            <span class="az-dashboard-stat-icon" aria-hidden="true">📦</span>
        </div>
        <div class="az-dashboard-stat">
            <p class="az-stat-label">ĐÃ XÁC NHẬN</p>
            <p class="az-stat-value">{{ $stats_confirmed }}</p>
            <p class="az-stat-note"><span class="confirmed-dot">●</span> Đơn hàng đã được xác nhận</p>
            <span class="az-dashboard-stat-icon is-confirmed" aria-hidden="true">✓</span>
        </div>
        <div class="az-dashboard-stat">
            <p class="az-stat-label">ĐANG GIAO HÀNG</p>
            <p class="az-stat-value">{{ $stats_shipping }}</p>
            <p class="az-stat-note"><span class="shipping-dot">↗</span> Đơn đang trên đường giao</p>
            <span class="az-dashboard-stat-icon" aria-hidden="true">🚚</span>
        </div>
    </div>

    <div class="az-flash">
        <span class="az-flash-mark"><i class="bi bi-fire"></i></span>
        <div class="az-flash-copy">
            <div class="az-flash-topline">
                <span class="az-flash-badge">FLASH SALE</span>
                <span class="az-flash-applies">Ưu đãi sản phẩm thể thao</span>
            </div>
            @if(($flashSaleInfo['percent'] ?? 0) > 0)
                <p class="az-flash-title">Giảm đến {{ round($flashSaleInfo['percent']) }}% hôm nay! @if(!empty($flashSaleInfo['note'])){{ $flashSaleInfo['note'] }}@endif</p>
                <p class="az-flash-meta">Ưu đãi kết thúc khi hết khung giờ · Miễn phí vận chuyển cho đơn từ {{ number_format($freeShippingThreshold, 0, ',', '.') }}đ</p>
            @else
                <p class="az-flash-title">Flash Sale hiện chưa diễn ra</p>
                <p class="az-flash-meta">Quay lại sau để không bỏ lỡ ưu đãi sản phẩm thể thao</p>
            @endif
        </div>
        <div class="az-flash-right">
            @if(($flashSaleInfo['percent'] ?? 0) > 0 && !empty($flashSaleInfo['end']))
                <div class="az-flash-timer" data-flash-end="{{ $flashSaleInfo['end'] }}">
                    <i class="bi bi-stopwatch"></i> KẾT THÚC SAU:
                    <span class="az-flash-time-unit" data-time-hours>00</span>:
                    <span class="az-flash-time-unit" data-time-minutes>00</span>:
                    <span class="az-flash-time-unit" data-time-seconds>00</span>
                </div>
            @endif
        </div>
    </div>

    <section class="az-dashboard-panel">
        <div class="az-sec-hd" style="align-items:center;">
            <div>
                <h4 class="az-sec-title">Dịch Vụ Đặt Sân Thể Thao Trực Tuyến</h4>
                <p style="margin:3px 0 0;font-size:.68rem;color:var(--az-muted);">Giảm thêm <strong style="padding:1px 4px;border-radius:3px;background:#ffdc35;color:#111;">10%</strong> khi đặt qua ứng dụng SportsHub!</p>
            </div>
            <a href="{{ route('user.fields') }}" class="az-sec-link">Xem tất cả <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="az-court-grid">
            @php($courts = [
                ['icon' => '⚽', 'name' => 'Sân bóng đá', 'color' => '#dbeafe'],
                ['icon' => '🏸', 'name' => 'Sân cầu lông', 'color' => '#fef3c7'],
                ['icon' => '🎾', 'name' => 'Sân tennis', 'color' => '#e0e7ff'],
                ['icon' => '🏓', 'name' => 'Sân pickleball', 'color' => '#dcfce7'],
            ])
            @foreach($courts as $court)
                <a href="{{ route('user.fields') }}" class="az-court-card">
                    <span class="az-court-icon" style="background:{{ $court['color'] }};">{{ $court['icon'] }}</span>
                    <strong style="display:block;font-size:.82rem;">{{ $court['name'] }}</strong>
                    <small style="color:var(--az-muted);">Xem sân và lịch trống</small>
                    <span class="az-court-book">Đặt ngay</span>
                </a>
            @endforeach
        </div>
    </section>

    <section class="az-dashboard-panel">
        <div class="az-sec-hd" style="align-items:center;flex-wrap:wrap;">
            <div>
                <h4 class="az-sec-title">Gợi Ý Sản Phẩm</h4>
                <p style="margin:3px 0 0;font-size:.68rem;color:var(--az-muted);">Dựa trên sở thích của bạn</p>
            </div>
            <a href="{{ route('user.services') }}" class="az-sec-link">Xem tất cả sản phẩm <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="az-filter-bar">
            <button type="button" class="az-filter-btn active" onclick="setFilter(this,'all')">Tất cả</button>
            @foreach($categories->take(3) as $cat)
                <button type="button" class="az-filter-btn" onclick="setFilter(this,'{{ $cat->id }}')">{{ $cat->name }}</button>
            @endforeach
        </div>
        <div class="az-dashboard-products" id="suggested-grid">
            @forelse($featuredServices->take(4) as $service)
                <article class="az-dashboard-product az-product-card" data-cat="{{ $service->category_id ?? '' }}">
                    <a href="{{ route('user.serviceDetail', $service->id) }}" class="az-dashboard-product-link">
                        <div style="position:relative;">
                            <img loading="lazy" src="{{ $service->image ? asset('uploads/services/' . $service->image) : asset('assets/images/default.png') }}" alt="{{ $service->name }}" class="az-dashboard-product-image">
                            @if(($service->discount_percent ?? 0) > 0)
                                <span class="az-product-badge sale">-{{ round($service->discount_percent) }}%</span>
                            @endif
                        </div>
                        <div class="az-dashboard-product-info">
                            <small style="color:var(--az-muted);">{{ $service->category?->name ?? 'Tổng hợp' }}</small>
                            <p class="az-dashboard-product-name">{{ $service->name }}</p>
                            <div class="az-price-row">
                                @if(($service->discount_percent ?? 0) > 0)
                                    <span class="az-price">{{ formatCurrency($service->final_price) }}</span>
                                    <span class="az-price-old">{{ formatCurrency($service->price) }}</span>
                                @else
                                    <span class="az-price">{{ formatCurrency($service->price) }}</span>
                                @endif
                            </div>
                            <p class="az-product-meta">{{ $service->quantity > 0 ? 'Còn ' . $service->quantity . ' sản phẩm' : 'Hết hàng' }}</p>
                        </div>
                    </a>
                    <div style="padding:0 10px 10px;">
                        <button type="button" class="az-dashboard-add-cart" data-service-id="{{ $service->id }}" data-stock="{{ $service->quantity }}" @disabled($service->quantity <= 0)>
                            <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                        </button>
                    </div>
                </article>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:24px;color:var(--az-muted);">Chưa có sản phẩm gợi ý. <a href="{{ route('user.services') }}" class="az-sec-link">Xem cửa hàng</a></div>
            @endforelse
        </div>
    </section>

    @foreach($categories as $category)
        @if($category->services->isNotEmpty())
            <section class="az-dashboard-panel">
                <div class="az-sec-hd" style="align-items:center;">
                    <h4 class="az-sec-title">{{ $category->name }}</h4>
                    <a href="{{ route('user.services', ['category_id' => $category->id]) }}" class="az-sec-link">Xem tất cả <i class="bi bi-arrow-right"></i></a>
                </div>
                <div class="az-dashboard-products">
                    @foreach($category->services->take(4) as $service)
                        <article class="az-dashboard-product">
                            <a href="{{ route('user.serviceDetail', $service->id) }}" class="az-dashboard-product-link">
                                <div style="position:relative;">
                                    <img loading="lazy" src="{{ $service->image ? asset('uploads/services/' . $service->image) : asset('assets/images/default.png') }}" alt="{{ $service->name }}" class="az-dashboard-product-image">
                                    @if(($service->discount_percent ?? 0) > 0)
                                        <span class="az-product-badge sale">-{{ round($service->discount_percent) }}%</span>
                                    @endif
                                </div>
                                <div class="az-dashboard-product-info">
                                    <p class="az-dashboard-product-name">{{ $service->name }}</p>
                                    <div class="az-price-row">
                                        @if(($service->discount_percent ?? 0) > 0)
                                            <span class="az-price">{{ formatCurrency($service->final_price) }}</span>
                                            <span class="az-price-old">{{ formatCurrency($service->price) }}</span>
                                        @else
                                            <span class="az-price">{{ formatCurrency($service->price) }}</span>
                                        @endif
                                    </div>
                                    <p class="az-product-meta">Còn {{ $service->quantity }} sản phẩm</p>
                                </div>
                            </a>
                            <div style="padding:0 10px 10px;">
                                <button type="button" class="az-dashboard-add-cart" data-service-id="{{ $service->id }}" data-stock="{{ $service->quantity }}">
                                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach
</div>
</div>
</div>

{{-- TOAST --}}
<a href="{{ route('user.fields') }}">
    <div id="toast-rule" class="toast-noti">
        <i class="bi bi-megaphone-fill" style="color:var(--az-orange);font-size:1.2rem;"></i>
        <div class="toast-content"><strong>Thông báo</strong><p>🔥 Giờ cao điểm {{ optional($rule)->start_time }} - {{ optional($rule)->end_time }} (giá x{{ optional($rule)->multiplier }})</p></div>
        <span class="toast-close" onclick="event.preventDefault();hideToast('toast-rule')">×</span>
    </div>
</a>
<a href="{{ route('user.services') }}">
    <div id="toast-news" class="toast-noti">
        <i class="bi bi-info-circle-fill" style="color:var(--az-orange);font-size:1.2rem;"></i>
        <div class="toast-content"><strong>Ưu đãi mới</strong><p>🔥 {{ optional($ruleService)->note }}</p></div>
        <span class="toast-close" onclick="event.preventDefault();hideToast('toast-news')">×</span>
    </div>
</a>
<script>
function _openOverlay(o){if(!o)return;o.style.display='flex';o.offsetHeight;o.classList.add('is-open');}
function _closeOverlay(o,cb){if(!o)return;o.classList.remove('is-open');o.classList.add('is-closing');setTimeout(()=>{o.style.display='none';o.classList.remove('is-closing');if(typeof cb==='function')cb();},350);}
function closeVoucherOverlay(){const v=document.getElementById('voucherOverlay'),s=document.getElementById('shippingOverlay');_closeOverlay(v,()=>{if(s)setTimeout(()=>_openOverlay(s),150);});}
function closeShippingOverlay(){_closeOverlay(document.getElementById('shippingOverlay'));}
function copyVoucherCode(){const code=document.getElementById('voucherCodeText')?.innerText?.trim();if(!code)return;const btn=document.querySelector('.voucher-copy-btn');const doCopy=()=>{if(btn){btn.textContent='✓ Đã sao chép!';setTimeout(()=>{btn.textContent='Sao chép mã';},1400);}};if(navigator.clipboard&&window.isSecureContext){navigator.clipboard.writeText(code).then(doCopy).catch(()=>{});return;}const t=document.createElement('textarea');t.value=code;document.body.appendChild(t);t.select();document.execCommand('copy');document.body.removeChild(t);doCopy();}
function showToast(id,idx=0){const t=document.getElementById(id);if(!t)return;t.style.top=((window.innerWidth<=576?60:80)+idx*90)+'px';t.classList.add('show');setTimeout(()=>hideToast(id),8000);}
function hideToast(id){const t=document.getElementById(id);if(!t)return;t.classList.remove('show');}
function setFilter(btn,catId){document.querySelectorAll('.az-filter-btn').forEach(b=>b.classList.remove('active'));btn.classList.add('active');const grid=document.getElementById('suggested-grid');if(!grid)return;grid.querySelectorAll('.az-dashboard-product').forEach(card=>{card.style.display=(catId==='all'||card.dataset.cat==catId)?'':'none';});}
document.addEventListener('DOMContentLoaded',function(){
    document.querySelectorAll('.az-flash-timer[data-flash-end]').forEach(timer=>{
        const [hours,minutes]=timer.dataset.flashEnd.split(':').map(Number);
        const end=new Date();
        end.setHours(hours,minutes,0,0);
        if(end<=new Date())end.setDate(end.getDate()+1);
        const updateCountdown=()=>{
            const secondsLeft=Math.max(0,Math.floor((end.getTime()-Date.now())/1000));
            timer.querySelector('[data-time-hours]').textContent=String(Math.floor(secondsLeft/3600)).padStart(2,'0');
            timer.querySelector('[data-time-minutes]').textContent=String(Math.floor((secondsLeft%3600)/60)).padStart(2,'0');
            timer.querySelector('[data-time-seconds]').textContent=String(secondsLeft%60).padStart(2,'0');
        };
        updateCountdown();
        setInterval(updateCountdown,1000);
    });
    setTimeout(()=>showToast('toast-rule',0),1200);
    setTimeout(()=>showToast('toast-news',1),1700);
    const v=document.getElementById('voucherOverlay'),s=document.getElementById('shippingOverlay');
    if(v)setTimeout(()=>_openOverlay(v),600);else if(s)setTimeout(()=>_openOverlay(s),600);
    document.querySelectorAll('.az-dashboard-add-cart').forEach(button=>{
        button.addEventListener('click',async function(){
            if(this.disabled)return;
            const stock=Number(this.dataset.stock||0);
            if(stock<1){alert('Sản phẩm đã hết hàng.');return;}
            const originalText=this.innerHTML;
            this.disabled=true;
            this.innerHTML='<i class="bi bi-hourglass-split"></i> Đang thêm...';
            try{
                const response=await fetch("{{ route('user.cart.add.ajax') }}",{
                    method:'POST',
                    headers:{
                        'Content-Type':'application/json',
                        'Accept':'application/json',
                        'X-CSRF-TOKEN':"{{ csrf_token() }}"
                    },
                    body:JSON.stringify({service_id:this.dataset.serviceId,quantity:1})
                });
                const data=await response.json();
                if(!response.ok||!data.success)throw new Error(data.error||'Không thể thêm sản phẩm vào giỏ hàng.');
                const cartCount=document.querySelector('.az-cart-count');
                if(cartCount)cartCount.textContent=data.totalItems;
                this.innerHTML='<i class="bi bi-check2"></i> Đã thêm';
                setTimeout(()=>{this.innerHTML=originalText;this.disabled=false;},1200);
            }catch(error){
                alert(error.message||'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.');
                this.innerHTML=originalText;
                this.disabled=false;
            }
        });
    });
});
</script>
@endsection
