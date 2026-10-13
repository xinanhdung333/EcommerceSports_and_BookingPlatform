

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="icon" type="image/png" sizes="256x256" href="{{ asset('assets/images/logo.jpg') }}">
    <title>SportsHub</title>

    {{-- DNS prefetch & preconnect for faster CDN resolution --}}
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>

    {{-- Critical CSS first --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sports-theme.css') }}?v={{ filemtime(public_path('assets/css/sports-theme.css')) }}">

    {{-- Bootstrap Icons loaded async (non-render-blocking) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"></noscript>

    @stack('styles')

    {{-- Page transition overlay --}}
    <style>
        .page-transition-overlay {
            position: fixed; inset: 0; z-index: 99999;
            background: #fff;
            opacity: 0; pointer-events: none;
            transition: opacity .18s ease;
        }
        .page-transition-overlay.active {
            opacity: 1; pointer-events: all;
        }
        /* Fade-in on page load */
        body { animation: fadeInPage .25s ease; }
        @keyframes fadeInPage { from { opacity: 0; } to { opacity: 1; } }
    </style>

    <style>
        /* ===== Admin Nav ===== */
        .admin-nav {
            display: flex;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
            align-items: center;
            flex-wrap: wrap;
        }
        .admin-nav li a {
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.2s;
            display: block;
        }
        .admin-nav li a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Keep the desktop navigation on one clean horizontal line. */
        .navbar > .container-fluid {
            gap: 24px;
            min-height: 64px;
        }
        .navbar .navbar-brand {
            flex: 0 0 auto;
            white-space: nowrap;
        }
        .navbar .offcanvas-body {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 0;
            padding: 0;
        }
        .navbar .offcanvas-body > .navbar-nav {
            flex-wrap: nowrap;
            gap: 3px;
            min-width: 0;
        }
        .navbar .offcanvas-body > .navbar-nav > .nav-item {
            flex: 0 0 auto;
        }
        .navbar .offcanvas-body > .navbar-nav > .nav-item.w-100 {
            width: auto !important;
        }
        .navbar .offcanvas-body > .navbar-nav .nav-link {
            padding: 8px 9px;
            font-size: .86rem;
            white-space: nowrap;
        }
        .navbar .offcanvas-body > .navbar-nav .dropdown-toggle::after {
            margin-left: 4px;
        }

        /* ===== Dark Dropdown hover ===== */
        .dropdown-menu[style*="background:#1e1e1e"] .dropdown-item:hover,
        .dropdown-menu[style*="background:#1e1e1e"] .dropdown-item:focus {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
        }

        /* Admin menus use a light surface so their dark labels remain readable. */
        .navbar .admin-nav-dropdown {
            background: #fff !important;
            color: #303740;
            border: 1px solid #e5e7eb !important;
        }
        .navbar .admin-nav-dropdown .dropdown-item {
            color: #303740 !important;
        }
        .navbar .admin-nav-dropdown .dropdown-item:hover,
        .navbar .admin-nav-dropdown .dropdown-item:focus {
            color: #d94108 !important;
            background: #fff1e9 !important;
        }
        .navbar .admin-nav-dropdown .dropdown-divider {
            border-color: #e5e7eb !important;
        }

        /* Keep the account menu inside the viewport when the desktop nav is full. */
        @media (min-width: 992px) {
            .navbar > .container-fluid {
                gap: 12px;
            }

            .navbar .offcanvas-body > .navbar-nav {
                gap: 0;
            }

            .navbar .offcanvas-body > .navbar-nav .nav-link {
                padding-left: 6px;
                padding-right: 6px;
                font-size: .8rem;
            }

            .navbar .admin-account-menu {
                right: 0 !important;
                left: auto !important;
                transform: none !important;
                min-width: 190px;
                max-width: calc(100vw - 24px);
                margin-top: 4px;
            }
        }

        /* ===== Mascot / Chatbot ===== */
        #mascot {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: auto; /* Fix stretching distortion */
            cursor: grab;
            z-index: 9999;
        }

        /* ===== Prevent horizontal scroll ===== */
        html,
        body {
            width: 100%;
            overflow-x: hidden;
        }

        /* ===== Sticky Navbar Wrapper ===== */
        .desktop-layout {
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        /* ===== Site Content ===== */
        .site-content {
            width: 100%;
            max-width: none;
        }

        .site-content-inner {
            width: 100%;
            padding-left: clamp(10px, 3vw, 32px);
            padding-right: clamp(10px, 3vw, 32px);
        }

        /* ===== TABLET (≤ 991px) ===== */
        @media (max-width: 991px) {
            .navbar > .container-fluid {
                min-height: 56px;
            }

            .navbar-nav {
                flex-direction: column;
                width: 100%;
            }

            .navbar-nav .nav-item,
            .navbar-nav > li {
                width: 100%;
            }

            .navbar-nav .nav-link {
                padding: 0.6rem 0.75rem;
                width: 100%;
                font-size: 0.92rem;
            }

            .dropdown-menu {
                width: 100%;
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: none;
                background: rgba(255,255,255,0.05);
            }

            .container-fluid,
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            .admin-nav {
                flex-wrap: wrap;
                gap: 6px;
            }

            .navbar .offcanvas-body {
                display: block;
                padding: 1rem;
            }

            .navbar .offcanvas-body > .navbar-nav {
                align-items: stretch !important;
                gap: 0;
            }
        }

        /* ===== MOBILE (≤ 576px) ===== */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-toggler {
                margin-left: auto;
            }

            .navbar-nav .nav-link {
                padding: 0.5rem 0.6rem;
                font-size: 0.88rem;
            }

            .container-fluid,
            .container {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            main.container {
                padding-top: 0.5rem;
            }

            .site-content-inner {
                padding-left: 8px;
                padding-right: 8px;
            }

            #mascot {
                width: 70px !important;
                height: 70px !important;
                bottom: 14px !important;
                right: 14px !important;
            }

            /* Offcanvas Mobile Menu Spacing */
            .offcanvas-end {
                width: 75vw !important;
                max-width: 320px;
            }
            .offcanvas-body .nav-link {
                padding: 14px 10px !important;
                font-size: 16px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .offcanvas-body .dropdown-menu {
                background: transparent !important;
                border: none;
                padding-left: 15px;
            }
            .offcanvas-body .dropdown-item {
                padding: 12px 10px;
                color: #c1b6b6;
            }
            .offcanvas-body .dropdown-item:hover {
                background: rgb(239, 237, 237)!important;
                color: #fff;
            }
        }
    </style>





<style>
/* ===== Floating mascot button ===== */
#mascot {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(238,77,45,.45);
    cursor: pointer;
    z-index: 9999;
    transition: transform .2s;
}
#mascot:hover { transform: scale(1.08); }

/* ===== Chat container ===== */
#chat-box {
    position: fixed;
    bottom: 88px;
    right: 24px;
    width: 370px;
    height: 545px;
    flex-direction: column;
    box-sizing: border-box;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    display: none;
    box-shadow: 0 12px 40px rgba(0,0,0,.22);
    font-family: 'Segoe UI', system-ui, sans-serif;
    z-index: 999999;
    animation: chatSlideIn .22s ease;
}
@keyframes chatSlideIn { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }

/* ===== Header ===== */
.chat-header {
    background: linear-gradient(135deg, #ff6b1a 0%, #ff8c42 100%);
    color: #fff;
    padding: 16px 16px 50px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-shrink: 0;
}
.chat-brand { display:flex; align-items:center; gap:11px; }
.chat-brand-icon {
    width: 40px; height: 40px;
    border: 2px solid rgba(255,255,255,.6);
    border-radius: 50%;
    display: grid; place-items: center;
    font-size: 19px;
    background: rgba(255,255,255,.15);
    flex-shrink: 0;
}
.chat-brand-title { font-size: 14.5px; font-weight: 700; line-height: 1.2; }
.chat-brand-subtitle { font-size: 11.5px; opacity: .88; margin-top: 2px; }
.chat-brand .dot-green { color: #a7f3d0; }
#close-chat {
    cursor: pointer;
    font-size: 18px;
    opacity: .85;
    transition: opacity .15s;
    line-height: 1;
    margin-top: 2px;
}
#close-chat:hover { opacity: 1; }

/* ===== Tabs ===== */
.chat-tabs {
    position: relative;
    z-index: 2;
    display: flex;
    gap: 4px;
    margin: -28px 14px 0;
    padding: 4px;
    background: #e85d17;
    border-radius: 999px;
    width: calc(100% - 28px);
    flex-shrink: 0;
}
.chat-tab {
    flex: 1;
    border: 0;
    border-radius: 999px;
    padding: 7px 8px;
    color: rgba(255,255,255,.85);
    background: transparent;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    transition: background .18s, color .18s;
}
.chat-tab.active {
    background: #fff;
    color: #1a1a1a;
    box-shadow: 0 2px 8px rgba(0,0,0,.18);
}
.chat-tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #ef4444;
    color: #fff;
    border-radius: 999px;
    font-size: 10px;
    font-weight: 700;
    min-width: 17px;
    height: 17px;
    padding: 0 4px;
    line-height: 1;
}

/* ===== Panels ===== */
.chat-panel { display:none; flex:1 1 auto; min-height:0; flex-direction:column; }
.chat-panel.active { display:flex; }

/* ===== Chat body ===== */
.chat-body,
.admin-chat-body {
    flex: 1 1 auto;
    min-height: 0;
    overflow-y: auto;
    overflow-anchor: auto;   /* pin scroll to bottom anchor */
    display: flex;
    flex-direction: column;
    padding: 16px 14px 10px;
    background: #f7f8fc;
    scrollbar-width: thin;
    scrollbar-color: #ddd transparent;
}
.chat-body::-webkit-scrollbar,
.admin-chat-body::-webkit-scrollbar { width: 4px; }
.chat-body::-webkit-scrollbar-thumb,
.admin-chat-body::-webkit-scrollbar-thumb { background:#ddd; border-radius:4px; }

/* Message row */
.msg-row { display:flex; margin-bottom:10px; align-items:flex-end; gap:7px; }
.msg-row.me { flex-direction: row-reverse; }

/* Avatar letter */
.msg-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: #ff6b1a;
    color: #fff;
    font-size: 13px; font-weight: 700;
    display: grid; place-items: center;
    flex-shrink: 0;
    text-transform: uppercase;
}

/* Bubble */
.msg-bubble {
    max-width: 220px;
    min-width: 0;
    padding: 10px 13px;
    border-radius: 18px 18px 18px 4px;
    font-size: 13px;
    line-height: 1.45;
    background: #fff;
    color: #1a1a1a;
    border: 1px solid #edf0f4;
    box-shadow: 0 2px 6px rgba(15,23,42,.06);
    word-break: break-word;
    overflow: hidden;
}
.msg-row.me .msg-bubble {
    border-radius: 18px 18px 4px 18px;
    background: linear-gradient(135deg,#ff6b1a,#ff8c42);
    color: #fff;
    border: none;
    box-shadow: 0 4px 12px rgba(255,107,26,.3);
}
.msg-time {
    font-size: 10.5px;
    opacity: .55;
    margin-top: 4px;
    display: block;
    text-align: right;
}
.msg-row:not(.me) .msg-time { text-align: left; }

/* Legacy classes kept for JS compatibility */
.message-user { background: linear-gradient(135deg,#ff6b1a,#ff8c42); color:#fff; padding:10px 14px; border-radius:18px 18px 4px 18px; margin-bottom:10px; max-width:72%; margin-left:auto; font-size:13px; line-height:1.45; word-break:break-word; }
.message-bot  { background:#fff; padding:10px 14px; border-radius:18px 18px 18px 4px; margin-bottom:10px; max-width:72%; border:1px solid #edf0f4; font-size:13px; line-height:1.45; box-shadow:0 2px 6px rgba(15,23,42,.06); word-break:break-word; }

/* Quick replies */
.chat-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 8px 14px 6px;
    background: #f7f8fc;
    flex-shrink: 0;
}
.quick-reply-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 999px;
    border: 1px solid #e0e4ef;
    background: #fff;
    color: #374151;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all .16s;
    white-space: nowrap;
}
.quick-reply-btn:hover { background: #ff6b1a; color: #fff; border-color: #ff6b1a; }

/* Link button inside bot bubble */
.chat-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 8px;
    padding: 7px 14px;
    border-radius: 999px;
    background: linear-gradient(135deg, #ff6b1a, #ff8c42);
    color: #fff !important;
    font-size: 12.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: opacity .15s, transform .15s;
    box-shadow: 0 3px 8px rgba(255,107,26,.35);
}
.chat-link-btn:hover { opacity: .88; transform: translateY(-1px); }

/* Inline image thumbnail inside bubble */
.chat-img-thumb {
    display: block;
    width: 100%;
    max-width: 200px;
    max-height: 180px;
    border-radius: 10px;
    margin-top: 6px;
    object-fit: cover;
    cursor: zoom-in;
    border: 1px solid rgba(0,0,0,.08);
    transition: transform .15s, box-shadow .15s;
}
.chat-img-thumb:hover { transform: scale(1.03); box-shadow: 0 6px 18px rgba(0,0,0,.18); }

/* ===== Footer input ===== */
.chat-footer, .admin-chat-footer {
    flex: 0 0 auto;
    padding: 10px 12px 6px;
    border-top: 1px solid #eef0f6;
    background: #fff;
}
.chat-input-bar {
    display: flex;
    align-items: center;
    gap: 4px;
    background: #f3f4f8;
    border-radius: 999px;
    padding: 5px 5px 5px 14px;
    border: 1px solid #e8ecf5;
}
.chat-input-bar input {
    flex: 1;
    border: none;
    background: transparent;
    outline: none;
    font-size: 13.5px;
    color: #1a1a1a;
    min-width: 0;
}
.chat-input-bar input::placeholder { color: #aab0be; }
.chat-icon-btn {
    width: 32px; height: 32px;
    border: none; background: transparent;
    color: #94a3b8;
    display: grid; place-items: center;
    border-radius: 50%;
    font-size: 16px;
    cursor: pointer;
    transition: color .15s;
    flex-shrink: 0;
}
.chat-icon-btn:hover { color: #ff6b1a; }
.chat-send-btn {
    width: 36px; height: 36px;
    border: none;
    background: linear-gradient(135deg,#ff6b1a,#ff8c42);
    color: #fff;
    border-radius: 50%;
    display: grid; place-items: center;
    font-size: 15px;
    cursor: pointer;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(255,107,26,.4);
    transition: transform .15s, box-shadow .15s;
}
.chat-send-btn:hover { transform: scale(1.07); box-shadow: 0 5px 14px rgba(255,107,26,.5); }
.chat-footer-brand {
    font-size: 10.5px;
    color: #94a3b8;
    text-align: center;
    margin-top: 6px;
    padding-bottom: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}
.chat-footer-brand span { display:inline-flex; align-items:center; gap:3px; }
.dot-green2 { width:6px; height:6px; background:#22c55e; border-radius:50%; display:inline-block; }

/* Admin panel compat */
.admin-chat-form { display:flex; gap:6px; }
.admin-message { display:table; max-width:82%; padding:10px 13px; border-radius:16px 16px 16px 4px; background:#fff; border:1px solid #edf0f3; margin:0 0 10px; font-size:12px; line-height:1.35; box-shadow:0 2px 5px rgba(15,23,42,.05); }
.admin-message.mine { margin-left:auto; border-radius:16px 16px 4px 16px; background:linear-gradient(135deg,#ff6b1a,#ff8c42); color:#fff; border:0; }
.admin-chat-link { display:inline-block; padding:10px 18px; border-radius:999px; background:#ff6b1a; color:#fff; font-size:13px; font-weight:700; text-decoration:none; }
.admin-chat-panel { align-items:stretch; justify-content:flex-start; text-align:left; padding:0; background:#f7f8fc; }

/* Mobile */
@media (max-width:768px) {
    #chat-box { right:10px; left:10px; width:auto; height:72vh; bottom:80px; }
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
</head>
<body class="{{ auth()->check() && auth()->user()->role === 'user' ? 'user-amazon-surface' : (auth()->check() && auth()->user()->role === 'admin' ? 'admin-amazon-surface' : '') }}">
<div class="page-transition-overlay" id="pageTransition"></div>
{{-- ===== NAVBAR WRAPPER ===== --}}
@if(auth()->check() && auth()->user()->role === 'user')
{{-- ===== AMAZON-STYLE USER NAVBAR ===== --}}
<style>
:root{--az-dark:#131921;--az-navy:#232f3e;--az-yellow:#f0c14b;--az-orange:#ff9900;--az-red:#cc0c39;--az-text:#0f1111;--az-link:#007185;--az-border:#ddd;--az-muted:#767676;}
.az-topbar{background:var(--az-dark);padding:7px 0;width:100%;position:sticky;top:0;z-index:1060;}
.az-topbar-inner{max-width:1500px;margin:0 auto;padding:0 16px;display:flex;align-items:center;gap:8px;}
.az-logo{color:#fff;font-size:1.3rem;font-weight:900;text-decoration:none;display:flex;align-items:center;gap:8px;white-space:nowrap;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-logo-mark{width:40px;height:40px;border-radius:8px;background:#ffd814;color:#0f1111;display:grid;place-items:center;font-size:20px;line-height:1;}
.az-logo-copy{display:flex;flex-direction:column;line-height:1.05;}
.az-logo-copy small{font-size:8px;letter-spacing:1.5px;color:#aeb4bc;margin-top:5px;font-weight:600;}
.az-logo:hover{color:#fff;border-color:#fff;}.az-logo .vn{font-size:.58rem;opacity:.75;display:block;line-height:1;}
.az-deliver{color:#ccc;font-size:.7rem;display:flex;flex-direction:column;padding:4px 8px;border:1px solid transparent;border-radius:2px;cursor:pointer;transition:border-color .15s;}
.az-deliver:hover{border-color:#fff;}.az-deliver strong{color:#fff;font-size:.82rem;}
.az-search{flex:1;display:flex;border-radius:4px;overflow:hidden;min-width:0;}
.az-search-cat{background:#f3f3f3;border:none;padding:0 10px;font-size:.78rem;color:var(--az-text);cursor:pointer;}
.az-search input{flex:1;border:none;outline:none;padding:0 12px;font-size:.93rem;color:var(--az-text);}
.az-search-btn{background:var(--az-orange);border:none;padding:0 16px;font-size:1.1rem;color:#111;cursor:pointer;transition:background .15s;}
.az-search-btn:hover{background:#e88900;}
.az-actions{display:flex;align-items:center;gap:2px;flex-shrink:0;}
.az-action-btn{color:#fff;text-decoration:none;font-size:.72rem;display:flex;flex-direction:column;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;background:none;cursor:pointer;line-height:1.3;}
.az-action-btn:hover{color:#fff;border-color:#fff;}.az-action-btn .top{color:#ccc;font-size:.68rem;}.az-action-btn .bot{color:#fff;font-size:.8rem;font-weight:700;}
.az-cart-btn{color:#fff;text-decoration:none;display:flex;align-items:center;gap:5px;font-size:.82rem;font-weight:700;padding:4px 8px;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-cart-btn:hover{color:#fff;border-color:#fff;}.az-cart-btn i{font-size:1.6rem;position:relative;}
.az-cart-count{position:absolute;top:-6px;right:-4px;background:var(--az-orange);color:#111;font-size:.68rem;font-weight:800;border-radius:50%;min-width:16px;height:16px;display:flex;align-items:center;justify-content:center;padding:0 3px;}
/* NAV ROW */
.az-navrow{background:var(--az-navy);padding:5px 0;width:100%;}
.az-navrow-inner{max-width:1500px;margin:0 auto;padding:0 8px;display:flex;align-items:center;gap:2px;overflow-x:auto;scrollbar-width:none;}
.az-navrow-inner::-webkit-scrollbar{display:none;}
.az-navlink{color:#fff;text-decoration:none;font-size:.82rem;padding:5px 10px;white-space:nowrap;border:1px solid transparent;border-radius:2px;transition:border-color .15s;}
.az-navlink:hover{color:#fff;border-color:#fff;}.az-navlink.hl{border-color:#febd69;color:#febd69;}
.az-all-btn{background:transparent;border:1px solid transparent;color:#fff;font-size:.82rem;font-weight:700;padding:5px 10px;border-radius:2px;cursor:pointer;display:flex;align-items:center;gap:5px;white-space:nowrap;transition:border-color .15s;}
.az-all-btn:hover{border-color:#fff;}
/* MEGA MENU */
.az-mega{position:fixed;top:0;left:0;width:280px;height:100vh;background:#fff;z-index:9998;box-shadow:4px 0 20px rgba(0,0,0,.25);transform:translateX(-100%);transition:transform .28s cubic-bezier(.22,1,.36,1);display:flex;flex-direction:column;}
.az-mega.open{transform:translateX(0);}
.az-mega-overlay{position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9997;opacity:0;pointer-events:none;transition:opacity .28s;}
.az-mega-overlay.open{opacity:1;pointer-events:auto;}
.az-mega-header{background:var(--az-dark);color:#fff;padding:16px 18px;display:flex;align-items:center;gap:10px;font-weight:700;font-size:.95rem;flex-shrink:0;}
.az-mega-header i{font-size:1.1rem;}
.az-mega-close{margin-left:auto;cursor:pointer;font-size:1.1rem;opacity:.8;}
.az-mega-close:hover{opacity:1;}
.az-mega-body{flex:1;overflow-y:auto;padding:8px 0;}
.az-mega-section{padding:10px 18px 4px;font-size:.75rem;font-weight:700;color:var(--az-muted);text-transform:uppercase;letter-spacing:.5px;}
.az-mega-item{display:flex;align-items:center;justify-content:space-between;padding:10px 18px;font-size:.9rem;color:var(--az-text);text-decoration:none;transition:background .12s;}
.az-mega-item:hover{background:#f5f5f5;color:var(--az-text);}
.az-mega-item .badge2{font-size:.68rem;color:var(--az-muted);background:#f0f0f0;padding:2px 7px;border-radius:999px;}
.az-mega-item .new-badge{font-size:.65rem;color:#fff;background:#067d62;padding:1px 6px;border-radius:2px;font-weight:700;}
.az-mega-footer{border-top:1px solid var(--az-border);padding:12px 18px;}
.az-mega-footer a{display:block;color:var(--az-link);font-size:.85rem;text-decoration:none;padding:4px 0;}
.az-mega-footer a:hover{color:#c7511f;text-decoration:underline;}
@media(max-width:576px){.az-deliver{display:none;}.az-action-btn.hide-sm{display:none;}.az-search{order:3;flex:0 0 calc(100% - 32px);}
.az-topbar-inner{flex-wrap:wrap;}.az-actions{order:2;margin-left:auto;}}
</style>

{{-- TOP BAR --}}
<div class="az-topbar">
<div class="az-topbar-inner">
    <a href="{{ route('user.dashboard') }}" class="az-logo"><span class="az-logo-mark">ϟ</span><span class="az-logo-copy">SPORTSHUB<small>SPORTS EQUIPMENT &amp; SERVICES</small></span></a>
    <div class="az-deliver"><span><i class="bi bi-geo-alt-fill"></i> Giao đến</span><strong>Việt Nam</strong></div>
    <form class="az-search" action="{{ route('user.services') }}" method="GET">
        @php $cats = \App\Models\Category::take(10)->get(); @endphp
        <select class="az-search-cat" name="_cat">
            <option value="">Tất cả ▾</option>
            @foreach($cats as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
        <input type="text" name="search" placeholder="Tìm kiếm SportsHub" autocomplete="off">
        <button type="submit" class="az-search-btn"><i class="bi bi-search"></i></button>
    </form>
    <div class="az-actions">
        <div class="az-action-btn hide-sm">
            <span class="top">Xin chào, {{ auth()->user()->name }}</span>
            <span class="bot">Tài khoản &amp; DS ▾</span>
        </div>
        <a href="{{ route('user.myServices') }}" class="az-action-btn hide-sm"><span class="top">Trả hàng</span><span class="bot">&amp; Đơn hàng</span></a>
        <a href="{{ route('cart.index') }}" class="az-cart-btn">
            <span style="position:relative;"><i class="bi bi-cart3"></i><span class="az-cart-count">0</span></span>
            <span>Giỏ hàng</span>
        </a>
    </div>
</div>
</div>

{{-- NAV ROW --}}
<div class="az-navrow">
<div class="az-navrow-inner">
    <button class="az-all-btn" onclick="toggleMega()"><i class="bi bi-list"></i> Tất cả</button>
    <a href="{{ route('user.dashboard') }}" class="az-navlink">Trang chủ</a>
    <a href="{{ route('user.services') }}" class="az-navlink">Sản phẩm</a>
    <a href="{{ route('user.vouchers') }}" class="az-navlink">Ưu đãi</a>
    <a href="{{ route('user.myServices') }}" class="az-navlink hl">Đã mua</a>
    <a href="{{ route('cart.index') }}" class="az-navlink">Giỏ hàng</a>
    <a href="{{ route('user.fields') }}" class="az-navlink">Đặt sân</a>
    <a href="{{ route('user.profile') }}" class="az-navlink">Hồ sơ</a>
    <form method="POST" action="{{ route('logout') }}" style="margin:0;">@csrf<button type="submit" class="az-navlink" style="background:none;border:none;cursor:pointer;color:#fff;font-size:.82rem;padding:5px 10px;">Đăng xuất</button></form>
</div>
</div>

{{-- MEGA MENU OVERLAY --}}
<div class="az-mega-overlay" id="megaOverlay" onclick="closeMega()"></div>
<div class="az-mega" id="megaMenu">
    <div class="az-mega-header">
        <i class="bi bi-person-circle"></i>
        <span>Xin chào, {{ auth()->user()->name }}</span>
        <span class="az-mega-close" onclick="closeMega()"><i class="bi bi-x-lg"></i></span>
    </div>
    <div class="az-mega-body">
        <div class="az-mega-section">Tài khoản</div>
        <a href="{{ route('user.dashboard') }}" class="az-mega-item"><span><i class="bi bi-house me-2"></i>Trang chủ</span></a>
        <a href="{{ route('user.profile') }}" class="az-mega-item"><span><i class="bi bi-person me-2"></i>Hồ sơ của tôi</span></a>
        <a href="{{ route('user.myServices') }}" class="az-mega-item"><span><i class="bi bi-bag-check me-2"></i>Đơn hàng đã mua</span></a>
        <a href="{{ route('user.wishlist') }}" class="az-mega-item"><span><i class="bi bi-heart me-2"></i>Yêu thích</span></a>
        <a href="{{ route('user.vouchers') }}" class="az-mega-item"><span><i class="bi bi-ticket-perforated me-2"></i>Voucher của tôi</span><span class="new-badge">HOT</span></a>

        <div class="az-mega-section">Mua sắm</div>
        <a href="{{ route('user.services') }}" class="az-mega-item"><span><i class="bi bi-shop me-2"></i>Tất cả sản phẩm</span></a>
        @foreach($cats as $c)
        <a href="{{ route('user.services', ['category' => $c->id]) }}" class="az-mega-item"><span><i class="bi bi-tag me-2"></i>{{ $c->name }}</span><span class="badge2">{{ $c->services_count ?? '' }}</span></a>
        @endforeach
        <a href="{{ route('cart.index') }}" class="az-mega-item"><span><i class="bi bi-cart3 me-2"></i>Giỏ hàng</span></a>

        <div class="az-mega-section">Dịch vụ khác</div>
        <a href="{{ route('user.fields') }}" class="az-mega-item"><span><i class="bi bi-trophy me-2"></i>Đặt sân thể thao</span></a>
        <a href="{{ route('user.myBookings') }}" class="az-mega-item"><span><i class="bi bi-calendar-check me-2"></i>Sân đã đặt</span></a>
        <a href="{{ route('user.chat.index') }}" class="az-mega-item"><span><i class="bi bi-chat-left-text me-2"></i>Chat hỗ trợ</span></a>
        <a href="{{ route('user.feedback') }}" class="az-mega-item"><span><i class="bi bi-chat-dots me-2"></i>Đánh giá</span></a>
        <a href="{{ route('about') }}" class="az-mega-item"><span><i class="bi bi-info-circle me-2"></i>Giới thiệu</span></a>
    </div>
    <div class="az-mega-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="az-mega-item" style="background:none;border:none;width:100%;text-align:left;padding:6px 0;cursor:pointer;color:var(--az-red);font-size:.88rem;"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button></form>
    </div>
</div>
<script>
function toggleMega(){const m=document.getElementById('megaMenu'),o=document.getElementById('megaOverlay');m.classList.toggle('open');o.classList.toggle('open');document.body.style.overflow=m.classList.contains('open')?'hidden':'';}
function closeMega(){document.getElementById('megaMenu').classList.remove('open');document.getElementById('megaOverlay').classList.remove('open');document.body.style.overflow='';}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeMega();});
</script>

@else
{{-- ===== OLD NAVBAR (admin / boss / shipper / guest) ===== --}}
<div class="desktop-layout">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    @if(auth()->check() && auth()->user()->role === 'boss')
      <a class="navbar-brand" href="{{ route('boss.home') }}"><span class="az-logo-mark d-inline-grid me-2">ϟ</span> SportsHub</a>
    @elseif(auth()->check() && auth()->user()->role === 'admin')
      <a class="navbar-brand" href="{{ route('admin.home') }}"><span class="az-logo-mark d-inline-grid me-2">ϟ</span> SportsHub</a>
    @elseif(auth()->check() && auth()->user()->role === 'shipper')
      <a class="navbar-brand" href="{{ route('shipper.dashboard') }}"><span class="az-logo-mark d-inline-grid me-2">ϟ</span> SportsHub</a>
    @else
      <a class="navbar-brand" href="{{ route('user.home') }}"><span class="az-logo-mark d-inline-grid me-2">ϟ</span> SportsHub</a>
    @endif
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><i class="bi bi-dribbble"></i> SportsHub Menu</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-boxes"></i> Quản lý dịch vụ</a>
                            <ul class="dropdown-menu admin-nav-dropdown shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('admin.manage.services') }}"><i class="bi bi-bag me-2"></i>Sản phẩm</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.manage.categories') }}"><i class="bi bi-tags me-2"></i>Danh mục</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.manage.fields') }}"><i class="bi bi-trophy me-2"></i>Sân bóng</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.manage.bookings') }}"><i class="bi bi-calendar-check me-2"></i>Đặt sân</a></li>
                            </ul>
                        </li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('admin.manage.orders') }}"><i class="bi bi-bag-check"></i> Chi tiết mua hàng</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('admin.manage.feedback') }}"><i class="bi bi-chat-dots"></i> Quản lý Feedback</a></li>
                        <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-chat-left-text"></i> Chat Admin</a>
                            <ul class="dropdown-menu admin-nav-dropdown shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('admin.chat.index') }}"><i class="bi bi-chat-left-text me-2"></i>Chat với người dùng</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.chatbot.index') }}"><i class="bi bi-robot me-2"></i>Quản lý Chatbot</a></li>
                            </ul>
                        </li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('admin.invoices') }}"><i class="bi bi-file-earmark-pdf"></i> Quản lý hóa đơn</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('admin.manage.users') }}"><i class="bi bi-people"></i> Quản lý người dùng</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('admin.statistics') }}"><i class="bi bi-bar-chart"></i> Thống kê</a></li>
                        <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person"></i> {{ auth()->user()->name }}</a>
                            <ul class="dropdown-menu admin-nav-dropdown dropdown-menu-end admin-account-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="bi bi-gear me-2"></i>Pricing Settings</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Hồ sơ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item">Đăng xuất</button></form></li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'shipper')
                        <li class="nav-item"><a class="nav-link" href="{{ route('shipper.dashboard') }}"><i class="bi bi-truck"></i> Đơn giao hàng</a></li>
                        <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person"></i> {{ auth()->user()->name }}</a>
                            <ul class="dropdown-menu dropdown-menu-end admin-nav-dropdown">
                                <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item">Đăng xuất</button></form></li>
                            </ul>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'boss')
                        <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-boxes"></i> Quản lý dịch vụ</a>
                            <ul class="dropdown-menu admin-nav-dropdown shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('boss.manage.services') }}"><i class="bi bi-bag me-2"></i>Sản phẩm</a></li>
                                <li><a class="dropdown-item" href="{{ route('boss.manage.categories') }}"><i class="bi bi-tags me-2"></i>Danh mục</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('boss.manage.fields') }}"><i class="bi bi-trophy me-2"></i>Sân bóng</a></li>
                                <li><a class="dropdown-item" href="{{ route('boss.manage.bookings') }}"><i class="bi bi-calendar-check me-2"></i>Đặt sân</a></li>
                            </ul>
                        </li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('boss.user.service.history') }}"><i class="bi bi-bag-check"></i> Chi tiết mua hàng</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('boss.manage.feedback') }}"><i class="bi bi-chat-dots"></i> Quản lý Feedback</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('boss.invoices') }}"><i class="bi bi-file-earmark-pdf"></i> Quản lý hóa đơn</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('boss.manage.users') }}"><i class="bi bi-people"></i> Quản lý người dùng</a></li>
                        <li class="nav-item w-100"><a class="nav-link" href="{{ route('boss.statistics') }}"><i class="bi bi-bar-chart"></i> Thống kê</a></li>
                        <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-person"></i> {{ auth()->user()->name }}</a>
                            <ul class="dropdown-menu admin-nav-dropdown dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('boss.profile') }}">Hồ sơ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="dropdown-item">Đăng xuất</button></form></li>
                            </ul>
                        </li>
                    @endif
                @else
                    <li class="nav-item w-100"><a class="nav-link" href="{{ route('visitor.dashboard') }}"><i class="bi bi-house"></i> Trang chủ</a></li>
                    <li class="nav-item w-100"><a class="nav-link" href="{{ route('myServices') }}"><i class="bi bi-bag"></i> Sản phẩm</a></li>
                    <li class="nav-item dropdown w-100"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-grid-3x3-gap"></i> Dịch vụ khác</a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 text-bg-dark text-lg-bg-light">
                            <li><a class="dropdown-item" href="{{ route('visitor.fields') }}"><i class="bi bi-trophy me-2"></i>Đặt sân</a></li>
                            <li><a class="dropdown-item" href="{{ route('visitor.feedback') }}"><i class="bi bi-chat-dots me-2"></i>Đánh giá</a></li>
                            <li><a class="dropdown-item" href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i>Giới thiệu</a></li>
                        </ul>
                    </li>
                    <li class="nav-item w-100"><a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a></li>
                    <li class="nav-item w-100"><a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus"></i> Đăng ký</a></li>
                @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
</div>
@endif
{{-- ===== END NAVBAR WRAPPER ===== --}}



<!-- Chat button -->
<img class="chatbot" src="{{ asset('assets/images/chatbot.png') }}" id="mascot" alt="Mở chat hỗ trợ">

<!-- ===== Chat box ===== -->
<div id="chat-box">

    <!-- Header -->
    <div class="chat-header">
        <div class="chat-brand">
            <span class="chat-brand-icon"><i class="bi bi-headset"></i></span>
            <span>
                <div class="chat-brand-title">Hỗ trợ trực tuyến <span class="dot-green">●</span></div>
                <div class="chat-brand-subtitle">Phản hồi trong vài phút ✓</div>
            </span>
        </div>
        <span id="close-chat"><i class="bi bi-x-lg"></i></span>
    </div>

    <!-- Tabs -->
    <div class="chat-tabs" role="tablist" aria-label="Kênh hỗ trợ">
        <button type="button" class="chat-tab active" data-chat-tab="bot" role="tab" aria-selected="true">
            <i class="bi bi-robot"></i> Chatbot
        </button>
        <button type="button" class="chat-tab" data-chat-tab="admin" role="tab" aria-selected="false">
            <i class="bi bi-person-headset"></i> Chat Admin
            @auth
                @if(auth()->user()->role === 'user')
                    <span class="chat-tab-badge" id="admin-tab-badge" style="display:none">0</span>
                @endif
            @endauth
        </button>
    </div>

    <!-- ===== CHATBOT PANEL ===== -->
    <div class="chat-panel active" id="chatbot-panel">
        <div class="chat-body" id="chat-body">
            <!-- Welcome message -->
            <div class="msg-row">
                <div class="msg-avatar" style="background:#ff6b1a; font-size:16px;">🤖</div>
                <div>
                    <div class="msg-bubble">Xin chào 👋 Tôi có thể giúp gì cho bạn?</div>
                </div>
            </div>
            <div id="chat-scroll-anchor" style="height:1px;flex-shrink:0;overflow-anchor:auto;"></div>
        </div>

        <!-- Quick replies -->
        <div class="chat-quick-replies" id="chatbot-quick-replies">
            <button class="quick-reply-btn"
                data-label="Kiểm tra đơn hàng"
                data-reply="Bạn có thể xem lịch sử đơn hàng tại đây 👇"
                data-link="{{ route('user.myServices') }}"
                data-link-text="📦 Xem đơn hàng của tôi"
                onclick="sendQuickReplyLink(this)">⚡ Kiểm tra đơn hàng</button>
            <button class="quick-reply-btn"
                data-label="Chính sách đổi trả"
                data-reply="Xem chi tiết chính sách đổi trả và đánh giá của chúng tôi 👇"
                data-link="{{ route('user.feedback') }}"
                data-link-text="💬 Xem chính sách đổi trả"
                onclick="sendQuickReplyLink(this)">⚡ Chính sách đổi trả</button>
            <button class="quick-reply-btn"
                data-label="Liên hệ hỗ trợ"
                data-reply="Bạn cần hỗ trợ trực tiếp? Chat với Admin ngay 👇"
                data-link="{{ route('user.chat.index') }}"
                data-link-text="💬 Chat với Admin"
                onclick="sendQuickReplyLink(this)">⚡ Liên hệ</button>
        </div>

        <!-- Input bar -->
        <div class="chat-footer">
            <div class="chat-input-bar">
                <input type="text" id="message" placeholder="Nhập tin nhắn..." autocomplete="off">
                <button class="chat-icon-btn" type="button" title="Đính kèm"><i class="bi bi-paperclip"></i></button>
                <button class="chat-icon-btn" type="button" title="Emoji"><i class="bi bi-emoji-smile"></i></button>
                <button class="chat-send-btn" onclick="sendMessage()" title="Gửi"><i class="bi bi-send-fill" style="font-size:14px;margin-left:2px"></i></button>
            </div>
            <div class="chat-footer-brand">
                <span>••• Tổng hợp – Chưa có đánh giá</span>
                <span><span class="dot-green2"></span> Được hỗ trợ bởi SportsHub</span>
            </div>
        </div>
    </div>

    <!-- ===== ADMIN CHAT PANEL ===== -->
    <div class="chat-panel admin-chat-panel" id="admin-chat-panel">
        @auth
            @if(auth()->user()->role === 'user')
                <div class="admin-chat-body" id="widget-admin-body">
                    <div class="text-center text-muted small p-3">Đang tải hội thoại...</div>
                </div>
                <div class="admin-chat-footer">
                    <!-- Image preview bar (hidden by default) -->
                    <div id="widget-img-preview" style="display:none;padding:6px 12px;background:#f7f8fc;border-top:1px solid #edf0f4;">
                        <div style="position:relative;display:inline-block;">
                            <img id="widget-img-preview-img" src="" alt="preview" style="max-height:72px;max-width:140px;border-radius:8px;border:1px solid #e0e4ef;object-fit:cover;">
                            <button onclick="clearWidgetImage()" style="position:absolute;top:-6px;right:-6px;width:18px;height:18px;border-radius:50%;background:#ef4444;border:none;color:#fff;font-size:10px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;">✕</button>
                        </div>
                    </div>
                    <form class="admin-chat-form" id="widget-admin-form" enctype="multipart/form-data">
                        <input type="file" id="widget-img-input" accept="image/*" style="display:none">
                        <div class="chat-input-bar" style="flex:1">
                            <button class="chat-icon-btn" type="button" title="Gửi ảnh" onclick="document.getElementById('widget-img-input').click()">
                                <i class="bi bi-image"></i>
                            </button>
                            <input id="widget-admin-input" placeholder="Nhập tin nhắn..." autocomplete="off" style="flex:1;border:none;background:transparent;outline:none;font-size:13.5px;">
                            <button class="chat-send-btn" type="submit" title="Gửi"><i class="bi bi-send-fill" style="font-size:14px;margin-left:2px"></i></button>
                        </div>
                    </form>
                    <div class="chat-footer-brand">
                        <span>••• Tổng hợp – Chưa có đánh giá</span>
                        <span><span class="dot-green2"></span> Được hỗ trợ bởi SportsHub</span>
                    </div>
                </div>
            @else
                <div style="padding:28px 20px;text-align:center">
                    <i class="bi bi-headset" style="font-size:40px;color:#ff6b1a"></i>
                    <p class="mb-0 mt-3" style="color:#64748b;font-size:13px">Tài khoản quản trị sử dụng khu vực Chat Admin trong menu quản lý.</p>
                </div>
            @endif
        @else
            <div style="padding:28px 20px;text-align:center">
                <i class="bi bi-headset" style="font-size:40px;color:#ff6b1a"></i>
                <p style="color:#64748b;font-size:13px;margin:12px 0 16px">Đăng nhập để bắt đầu chat trực tiếp với Admin.</p>
                <a class="admin-chat-link" href="{{ route('login') }}">Đăng nhập để chat Admin</a>
            </div>
        @endauth
    </div>

    <p id="reply" style="display:none"></p>
</div>
 
<main class="site-content container-fluid mt-4 px-0">
    <!-- NOTE: Images in the main content body should use loading="lazy" -->
    <div class="site-content-inner">

    @yield('content')

    </div>

@if(auth()->check() && auth()->user()->role === 'user')
<style id="user-amazon-design-system">
:root{--az-primary:#131921;--az-secondary:#232f3e;--az-page:#eaeded;--az-card:#fff;--az-border:#d5d9d9;--az-text:#0f1111;--az-muted:#565959;--az-link:#007185;--az-yellow:#ffd814;--az-yellow-border:#fcd200;--az-orange:#ff9900;--az-danger:#cc0c39;--az-success:#067d62;--az-star:#ffa41c}
.user-amazon-surface{background:#fff!important;color:var(--az-text);font-family:Inter,Roboto,Arial,sans-serif;font-size:14px;line-height:20px}
.user-amazon-surface .site-content,.user-amazon-surface .site-content-inner{max-width:1480px;margin:0 auto!important;padding:16px!important;background:#fff!important}
.user-amazon-surface .az-wrap{background:#fff!important}
.user-amazon-surface .navbar{background:var(--az-primary)!important;box-shadow:none!important;border:0!important}
.user-amazon-surface .navbar .nav-link,.user-amazon-surface .navbar .navbar-brand{color:#fff!important;font-size:14px}
.user-amazon-surface .navbar .nav-link:hover{border:1px solid #fff;background:transparent!important}
.user-amazon-surface .az-navlink{color:#fff!important}
.user-amazon-surface .az-navlink:hover{color:#fff!important;border-color:#fff!important}
.user-amazon-surface .az-navlink.hl{background:var(--az-yellow)!important;border-color:var(--az-yellow-border)!important;color:var(--az-text)!important}
.user-amazon-surface .az-action-btn,.user-amazon-surface .az-cart-btn{color:#fff!important}
.user-amazon-surface .az-action-btn span,.user-amazon-surface .az-action-btn strong{color:#fff!important}
.user-amazon-surface .az-search-cat{color:var(--az-text)!important}
.user-amazon-surface .offcanvas,.user-amazon-surface .dropdown-menu{background:var(--az-secondary)!important;border:1px solid #3a4553!important;border-radius:4px!important}
.user-amazon-surface .card,.user-amazon-surface .ad-card,.user-amazon-surface .product-card{background:var(--az-card)!important;border:1px solid var(--az-border)!important;border-radius:8px!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.user-amazon-surface h1{font-size:21px!important;font-weight:700!important;color:var(--az-text)!important}
.user-amazon-surface h2,.user-amazon-surface h3,.user-amazon-surface h4,.user-amazon-surface h5,.user-amazon-surface h6{color:var(--az-text)}
.user-amazon-surface a{color:var(--az-link)}
.user-amazon-surface .btn-primary,.user-amazon-surface .btn-warning,.user-amazon-surface button[type=submit]{background:var(--az-yellow)!important;border:1px solid var(--az-yellow-border)!important;color:var(--az-text)!important;border-radius:8px!important;box-shadow:none!important}
.user-amazon-surface .btn-secondary,.user-amazon-surface .btn-outline-secondary{background:#fff!important;border:1px solid var(--az-border)!important;color:var(--az-text)!important;border-radius:8px!important;box-shadow:none!important}
.user-amazon-surface input,.user-amazon-surface select,.user-amazon-surface textarea{border:1px solid var(--az-border)!important;border-radius:4px!important;box-shadow:none!important}
.user-amazon-surface .text-muted{color:var(--az-muted)!important}
.user-amazon-surface .az-mega{background:#fff!important;color:var(--az-text)!important;border-right:1px solid var(--az-border);box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.user-amazon-surface .az-mega-header{background:var(--az-primary)!important;color:#fff!important}
.user-amazon-surface .az-mega-section{color:var(--az-muted)!important;font-size:12px!important;font-weight:700!important;text-transform:uppercase;border-bottom:1px solid #eaeded;padding:14px 0 8px}
.user-amazon-surface .az-mega-item{color:var(--az-link)!important;border-radius:4px!important;padding:9px 6px!important;font-size:14px!important}
.user-amazon-surface .az-mega-item:hover{background:#f0f2f2!important;color:var(--az-text)!important}
.user-amazon-surface .az-mega-item i{color:var(--az-muted)!important}
.user-amazon-surface .az-mega-footer{background:#fff!important;border-top:1px solid var(--az-border)!important}
.user-amazon-surface .az-mega-footer .az-mega-item{color:var(--az-text)!important;background:var(--az-yellow)!important;border:1px solid var(--az-yellow-border)!important;border-radius:8px!important;text-align:center!important}
.user-amazon-surface .badge.bg-danger,.user-amazon-surface .bg-danger{background:var(--az-danger)!important}
.user-amazon-surface .bg-success{background:var(--az-success)!important}
/* User chat widget */
.user-amazon-surface #mascot{width:56px;height:56px;background:#fff;border:1px solid var(--az-border);padding:10px;box-shadow:0 2px 5px rgba(0,0,0,.15)!important}
.user-amazon-surface #chat-box{border:1px solid var(--az-border);border-radius:8px!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important;background:#fff}
.user-amazon-surface .chat-header{background:var(--az-primary)!important;border-radius:0!important}
.user-amazon-surface .chat-tabs{background:var(--az-secondary)!important;margin:0!important;width:100%!important;border-radius:0!important}
.user-amazon-surface .chat-tab.active{background:#fff!important;color:var(--az-text)!important}
.user-amazon-surface .chat-body,.user-amazon-surface .admin-chat-body{background:#fff!important}
.user-amazon-surface .message-user,.user-amazon-surface .admin-message.mine{background:#f0f2f2!important;color:var(--az-text)!important;border:1px solid var(--az-border)!important;border-radius:8px!important;box-shadow:none!important}
.user-amazon-surface .message-bot,.user-amazon-surface .admin-message{background:#fff!important;color:var(--az-text)!important;border:1px solid var(--az-border)!important;border-radius:8px!important;box-shadow:none!important}
.user-amazon-surface .chat-footer,.user-amazon-surface .admin-chat-footer{background:#fff!important;border-top:1px solid var(--az-border)!important}
.user-amazon-surface .chat-input input,.user-amazon-surface .admin-chat-form input{border-radius:8px!important}
.user-amazon-surface .chat-input button,.user-amazon-surface .admin-chat-form button{background:var(--az-yellow)!important;border:1px solid var(--az-yellow-border)!important;color:var(--az-text)!important;border-radius:8px!important}
/* Cross-page user normalization: keep legacy page-specific components in the same system. */
.user-amazon-surface [style*="linear-gradient"]{background:var(--az-card)!important;color:var(--az-text)!important}
.user-amazon-surface .flash-sale-banner,.user-amazon-surface .ad-card.orange{background:var(--az-card)!important;color:var(--az-text)!important;border:1px solid var(--az-border)!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.user-amazon-surface .flash-sale-banner .flash-sale-inner{color:var(--az-danger)!important}
.user-amazon-surface .product-card,.user-amazon-surface .voucher-card,.user-amazon-surface .wishlist-card,.user-amazon-surface .order-card{border:1px solid var(--az-border)!important;border-radius:8px!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important;background:#fff!important}
.user-amazon-surface .product-card:hover,.user-amazon-surface .voucher-card:hover{transform:none!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.user-amazon-surface .btn-danger,.user-amazon-surface .btn-success{border-radius:8px!important;box-shadow:none!important}
.user-amazon-surface .btn-danger{background:var(--az-danger)!important;border-color:var(--az-danger)!important}
.user-amazon-surface .btn-success{background:var(--az-success)!important;border-color:var(--az-success)!important}
.user-amazon-surface .modal-content,.user-amazon-surface .modal-dialog>div{border:1px solid var(--az-border)!important;border-radius:8px!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.user-amazon-surface .modal-header{background:var(--az-secondary)!important;color:#fff!important}
.user-amazon-surface .form-control:focus,.user-amazon-surface select:focus{border-color:#007185!important;box-shadow:0 0 0 2px rgba(0,113,133,.15)!important}
.user-amazon-surface .order-btn-row{display:flex!important;flex-wrap:wrap;gap:6px;min-width:0}
.user-amazon-surface .order-btn-row .btn{border-radius:8px!important;white-space:nowrap!important;max-width:100%}
.user-amazon-surface .shipping-status-badge{background:#f0f2f2!important;color:#0f1111!important;border:1px solid #d5d9d9!important;border-radius:8px!important}
.user-amazon-surface .order-price{color:var(--az-text)!important}
.user-amazon-surface .card-body,.user-amazon-surface .col-sm-8{min-width:0;overflow-wrap:anywhere}
@media(max-width:768px){.user-amazon-surface .site-content{padding:10px!important}.user-amazon-surface #chat-box{right:10px;left:10px;width:auto}}
</style>
@endif

@if(auth()->check() && auth()->user()->role === 'admin')
<style id="admin-amazon-design-system">
.admin-amazon-surface{background:#eaeded!important;color:#0f1111;font-family:Inter,Roboto,Arial,sans-serif}
.admin-amazon-surface .site-content{max-width:1480px;margin:0 auto!important;padding:16px!important;background:#eaeded!important}
.admin-amazon-surface .navbar{background:#131921!important;box-shadow:none!important}
.admin-amazon-surface .navbar .nav-link,.admin-amazon-surface .navbar .navbar-brand{color:#fff!important}
.admin-amazon-surface .offcanvas,.admin-amazon-surface .dropdown-menu{background:#232f3e!important;border-radius:4px!important}
.admin-amazon-surface .card,.admin-amazon-surface .section,.admin-amazon-surface .table-responsive{background:#fff!important;border:1px solid #d5d9d9!important;border-radius:8px!important;box-shadow:0 2px 5px rgba(15,17,17,.15)!important}
.admin-amazon-surface .settings-wrapper{max-width:1200px!important;margin:0 auto!important;display:flex;gap:20px;align-items:flex-start}
.admin-amazon-surface .settings-wrapper .sidebar{width:260px;flex:0 0 260px;background:#fff;border:1px solid #d5d9d9;border-radius:8px;padding:16px;box-shadow:0 2px 5px rgba(15,17,17,.15);position:sticky;top:16px}
.admin-amazon-surface .settings-wrapper .sidebar a{display:block;padding:10px 12px;border-radius:4px;color:#0f1111;text-decoration:none;margin-bottom:4px}
.admin-amazon-surface .settings-wrapper .sidebar a:hover{background:#f0f2f2}.admin-amazon-surface .settings-wrapper .sidebar a.active{background:#f0f2f2;color:#0f1111;border-left:3px solid #ff9900;font-weight:700}
.admin-amazon-surface .settings-wrapper .content{flex:1;min-width:0}.admin-amazon-surface .section{padding:20px;margin-bottom:16px}.admin-amazon-surface .section h3{font-size:16px;font-weight:700;margin-bottom:16px}
.admin-amazon-surface .section .item{border-bottom:1px solid #eaeded;border-radius:4px;padding:12px}.admin-amazon-surface .section .item:hover{background:#f7f8f8}.admin-amazon-surface .section .item i{color:#565959}
.admin-amazon-surface .btn-primary,.admin-amazon-surface .btn-warning{background:#ffd814!important;border:1px solid #fcd200!important;color:#0f1111!important;border-radius:8px!important;box-shadow:none!important}
.admin-amazon-surface .btn-secondary,.admin-amazon-surface .btn-outline-secondary,.admin-amazon-surface .btn-outline-primary{background:#fff!important;border:1px solid #d5d9d9!important;color:#0f1111!important;border-radius:8px!important}
.admin-amazon-surface .btn-danger{background:#cc0c39!important;border-color:#cc0c39!important}.admin-amazon-surface .btn-success{background:#067d62!important;border-color:#067d62!important}
.admin-amazon-surface input,.admin-amazon-surface select,.admin-amazon-surface textarea{border:1px solid #d5d9d9!important;border-radius:4px!important;box-shadow:none!important}
.admin-amazon-surface .table thead th{background:#f0f2f2!important;color:#565959!important;font-size:12px;text-transform:uppercase}.admin-amazon-surface .table tbody tr:hover{background:#f7f8f8!important}
.admin-amazon-surface [style*="linear-gradient"]{background:#fff!important;color:#0f1111!important}
@media(max-width:768px){.admin-amazon-surface .site-content{padding:10px!important}.admin-amazon-surface .settings-wrapper{display:block}.admin-amazon-surface .settings-wrapper .sidebar{width:100%;position:static;margin-bottom:16px}}
</style>
@endif

@include('partials.visitor.footer')

<script>

/* ── Helper: render a chat row with avatar + bubble ── */
function appendChatRow(chatBody, text, isUser) {
    const now = new Date();
    const timeStr = now.toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});
    const row = document.createElement('div');
    row.className = 'msg-row' + (isUser ? ' me' : '');
    if (isUser) {
        row.innerHTML = `<div><div class="msg-bubble">${escapeHtmlChat(text)}</div><span class="msg-time">${timeStr} ✓✓</span></div>`;
    } else {
        row.innerHTML = `<div class="msg-avatar" style="background:#ff6b1a;font-size:16px;">🤖</div><div><div class="msg-bubble">${escapeHtmlChat(text)}</div><span class="msg-time">${timeStr}</span></div>`;
    }
    chatBody.appendChild(row);
    chatBody.scrollTop = chatBody.scrollHeight;
    return row;
}

function escapeHtmlChat(v) {
    return String(v||'').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[c]));
}

async function sendMessage(textOverride) {
    let input = document.getElementById("message");
    let text = textOverride || input.value.trim();
    if (!text) return;

    let chatBody = document.getElementById("chat-body");
    if (!textOverride) input.value = "";

    /* User bubble */
    appendChatRow(chatBody, text, true);

    /* Bot typing bubble */
    const botRow = document.createElement('div');
    botRow.className = 'msg-row';
    botRow.innerHTML = `<div class="msg-avatar" style="background:#ff6b1a;font-size:16px;">🤖</div><div><div class="msg-bubble" id="bot-typing-bubble" style="color:#94a3b8;">Đang xử lý...</div></div>`;
    chatBody.appendChild(botRow);
    chatBody.scrollTop = chatBody.scrollHeight;

    const typingBubble = botRow.querySelector('#bot-typing-bubble');

    try {
        const history = Array.from(chatBody.querySelectorAll('.msg-row:not(:last-child)'))
            .slice(-10)
            .map(row => ({
                role: row.classList.contains('me') ? 'user' : 'model',
                text: row.querySelector('.msg-bubble')?.textContent?.trim() || ''
            })).filter(m => m.text);

        let response = await fetch("{{ route('chatbot.message') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: text, history })
        });

        let data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Không thể kết nối chatbot.');

        typingBubble.id = '';
        typingBubble.style.color = '';
        typingBubble.textContent = data.reply || 'Mình chưa có câu trả lời phù hợp.';
        const now = new Date();
        const timeStr = now.toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});
        const timeEl = document.createElement('span');
        timeEl.className = 'msg-time';
        timeEl.textContent = timeStr;
        botRow.querySelector('div:last-child').appendChild(timeEl);
    } catch (error) {
        typingBubble.style.color = '#ef4444';
        typingBubble.textContent = error.message || 'Không thể kết nối chatbot. Vui lòng thử lại.';
    }
    chatBody.scrollTop = chatBody.scrollHeight;
}

/* Quick reply shortcut – gửi tin nhắn user rồi gọi API */
function sendQuickReply(text) {
    document.getElementById('message').value = text;
    sendMessage();
}

/* Quick reply với link – hiển thị bubble trả lời trực tiếp kèm link */
function sendQuickReplyLink(btn) {
    const label    = btn.dataset.label    || btn.textContent.trim();
    const reply    = btn.dataset.reply    || 'Bạn có thể truy cập tại đây:';
    const link     = btn.dataset.link     || '#';
    const linkText = btn.dataset.linkText || 'Bấm vào đây';

    const chatBody = document.getElementById('chat-body');
    const now = new Date();
    const timeStr = now.toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});

    /* 1. Bubble của user */
    const userRow = document.createElement('div');
    userRow.className = 'msg-row me';
    userRow.innerHTML = `<div><div class="msg-bubble">${escapeHtmlChat(label)}</div><span class="msg-time">${timeStr} ✓✓</span></div>`;
    chatBody.appendChild(userRow);

    /* 2. Bubble của bot với link */
    const botRow = document.createElement('div');
    botRow.className = 'msg-row';
    botRow.innerHTML = `
        <div class="msg-avatar" style="background:#ff6b1a;font-size:16px;">🤖</div>
        <div>
            <div class="msg-bubble">
                ${escapeHtmlChat(reply)}<br>
                <a href="${link}" class="chat-link-btn" target="_self">${linkText} →</a>
            </div>
            <span class="msg-time">${timeStr}</span>
        </div>`;
    chatBody.appendChild(botRow);
    chatBody.scrollTop = chatBody.scrollHeight;
}

/* Enter to send */
const inputMessage = document.getElementById("message");
if (inputMessage) {
    inputMessage.addEventListener("keydown", function(e) {
        if (e.key === "Enter") { e.preventDefault(); sendMessage(); }
    });
}

</script>


<script>
const mascot = document.getElementById('mascot');
const chatBox = document.getElementById('chat-box');
const closeChat = document.getElementById('close-chat');

document.querySelectorAll('[data-chat-tab]').forEach(tab => {
    tab.addEventListener('click', () => {
        const target = tab.dataset.chatTab;
        document.querySelectorAll('[data-chat-tab]').forEach(item => {
            const active = item === tab;
            item.classList.toggle('active', active);
            item.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        document.getElementById('chatbot-panel').classList.toggle('active', target === 'bot');
        document.getElementById('admin-chat-panel').classList.toggle('active', target === 'admin');
    });
});

const widgetAdminBody = document.getElementById('widget-admin-body');
const widgetAdminForm = document.getElementById('widget-admin-form');
const widgetAdminInput = document.getElementById('widget-admin-input');
let widgetConversationId = null;
function renderWidgetAdminMessage(m){
    const isMe = String(m.sender_id) === '{{ auth()->id() }}';
    const now = m.created_at ? m.created_at.substring(11,16) : new Date().toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'});
    const text = m.message || '';
    const el = document.createElement('div');
    el.className = 'msg-row' + (isMe ? ' me' : '');

    /* Build bubble content: text + optional image */
    let bubbleInner = text ? `<span>${escapeHtmlChat(text)}</span>` : '';
    if (m.attachment_is_image && m.attachment_url) {
        bubbleInner += `<br><a href="${m.attachment_url}" target="_blank"><img src="${m.attachment_url}" alt="${escapeHtmlChat(m.attachment_name||'ảnh')}" class="chat-img-thumb"></a>`;
    } else if (m.attachment_url) {
        bubbleInner += `<br><a href="${m.attachment_url}" target="_blank" class="chat-link-btn" style="margin-top:6px;">📎 ${escapeHtmlChat(m.attachment_name||'Tệp đính kèm')}</a>`;
    }

    if (isMe) {
        el.innerHTML = `<div><div class="msg-bubble">${bubbleInner}</div><span class="msg-time">${now} ✓✓</span></div>`;
    } else {
        const initials = (m.sender_name||'A').charAt(0).toUpperCase();
        el.innerHTML = `<div class="msg-avatar" style="background:#6366f1;">${initials}</div><div><div class="msg-bubble">${bubbleInner}</div><span class="msg-time">${now}</span></div>`;
    }
    widgetAdminBody.appendChild(el);
    widgetAdminBody.scrollTop = widgetAdminBody.scrollHeight;
}

async function loadWidgetAdmin(){
    if(!widgetAdminBody) return;
    try {
        const r = await fetch('/user/chat/widget-data', {headers:{'Accept':'application/json'}});
        const d = await r.json();
        widgetConversationId = d.conversation_id;
        widgetAdminBody.innerHTML = '';
        d.messages.forEach(renderWidgetAdminMessage);
        if (!d.messages.length) widgetAdminBody.innerHTML = '<div class="text-center text-muted small p-3">Chưa có tin nhắn. Hãy gửi lời nhắn cho Admin.</div>';
        /* Thêm anchor vô hình ở cuối để scroll */
        let anchor = document.getElementById('widget-scroll-anchor');
        if (!anchor) {
            anchor = document.createElement('div');
            anchor.id = 'widget-scroll-anchor';
            anchor.style.cssText = 'height:1px;flex-shrink:0;';
        }
        widgetAdminBody.appendChild(anchor);
        widgetAdminBody.scrollTop = widgetAdminBody.scrollHeight;
    } catch(e) {
        widgetAdminBody.innerHTML = '<div class="text-center text-danger small p-3">Không tải được hội thoại.</div>';
    }
}

/* Image picker preview */
const widgetImgInput = document.getElementById('widget-img-input');
if (widgetImgInput) {
    widgetImgInput.addEventListener('change', () => {
        const file = widgetImgInput.files[0];
        if (!file) return;
        const preview = document.getElementById('widget-img-preview');
        const previewImg = document.getElementById('widget-img-preview-img');
        previewImg.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });
}
function clearWidgetImage() {
    const widgetImgInput = document.getElementById('widget-img-input');
    widgetImgInput.value = '';
    document.getElementById('widget-img-preview').style.display = 'none';
    document.getElementById('widget-img-preview-img').src = '';
}

if(widgetAdminForm){
    widgetAdminForm.addEventListener('submit', async e => {
        e.preventDefault();
        const text = widgetAdminInput.value.trim();
        const imgFile = widgetImgInput ? widgetImgInput.files[0] : null;
        if (!text && !imgFile) return;

        /* --- Optimistic render: show bubble immediately --- */
        const now = new Date().toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});
        const tempRow = document.createElement('div');
        tempRow.className = 'msg-row me';
        let optimisticInner = text ? `<span>${escapeHtmlChat(text)}</span>` : '';
        let blobUrl = null;
        if (imgFile) {
            blobUrl = URL.createObjectURL(imgFile);
            optimisticInner += `<br><img src="${blobUrl}" class="chat-img-thumb" alt="ảnh">`;
        }
        tempRow.innerHTML = `<div><div class="msg-bubble">${optimisticInner}</div><span class="msg-time">${now} ⏳</span></div>`;
        widgetAdminBody.querySelector('.text-center')?.remove();
        widgetAdminBody.appendChild(tempRow);
        widgetAdminBody.scrollTop = widgetAdminBody.scrollHeight;

        /* Clear inputs immediately */
        widgetAdminInput.value = '';
        clearWidgetImage();

        /* --- Send to server --- */
        const fd = new FormData();
        fd.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        if (text) fd.append('message', text);
        if (imgFile) fd.append('attachment', imgFile);
        fd.append('client_temp_id', 'widget-' + Date.now());
        try {
            const r = await fetch('{{ route('user.chat.send') }}', {
                method: 'POST',
                headers: {'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                body: fd
            });
            const d = await r.json();
            if (d.status === 'ok') {
                /* Replace optimistic row with real server row */
                const realRow = document.createElement('div');
                realRow.className = 'msg-row me';
                let realInner = d.message.message ? `<span>${escapeHtmlChat(d.message.message)}</span>` : '';
                if (d.message.attachment_is_image && d.message.attachment_url) {
                    realInner += `<br><a href="${d.message.attachment_url}" target="_blank"><img src="${d.message.attachment_url}" class="chat-img-thumb" alt="ảnh"></a>`;
                } else if (d.message.attachment_url) {
                    realInner += `<br><a href="${d.message.attachment_url}" target="_blank" class="chat-link-btn" style="margin-top:6px;">📎 ${escapeHtmlChat(d.message.attachment_name||'Tệp đính kèm')}</a>`;
                }
                const t = d.message.created_at ? d.message.created_at.substring(11,16) : now;
                realRow.innerHTML = `<div><div class="msg-bubble">${realInner}</div><span class="msg-time">${t} ✓✓</span></div>`;
                tempRow.replaceWith(realRow);
                if (blobUrl) URL.revokeObjectURL(blobUrl);
            } else {
                /* Mark failed */
                tempRow.querySelector('.msg-time').textContent += ' ❌';
            }
        } catch {
            tempRow.querySelector('.msg-time').textContent += ' ❌';
        }
    });
}
loadWidgetAdmin();

let isDragging = false;
let offsetX = 0, offsetY = 0;

// click mở chat – scroll to bottom
let chatAlreadyOpened = false;
mascot.addEventListener('click', () => {
    chatBox.style.display = 'flex';
    setTimeout(() => {
        /* chatbot panel */
        const botAnchor = document.getElementById('chat-scroll-anchor');
        if (botAnchor) botAnchor.scrollIntoView(false);
        else { const cb = document.getElementById('chat-body'); if(cb) cb.scrollTop = cb.scrollHeight; }
        /* admin panel */
        const adminAnchor = document.getElementById('widget-scroll-anchor');
        if (adminAnchor) adminAnchor.scrollIntoView(false);
        else if (widgetAdminBody) widgetAdminBody.scrollTop = widgetAdminBody.scrollHeight;
    }, 80);
});


// kéo mascot
mascot.addEventListener('mousedown', (e) => {
    isDragging = true;
    offsetX = e.clientX - mascot.offsetLeft;
    offsetY = e.clientY - mascot.offsetTop;
    mascot.style.cursor = 'grabbing';
});

document.addEventListener('mouseup', () => {
    isDragging = false;
    mascot.style.cursor = 'grab';
});

document.addEventListener('mousemove', (e) => {
    if (!isDragging) return;

    mascot.style.left = (e.clientX - offsetX) + 'px';
    mascot.style.top  = (e.clientY - offsetY) + 'px';
});

// đóng chat
closeChat.addEventListener('click', () => {
    chatBox.style.display = 'none';
});
</script>
<script>
// Update wishlist badge count in navbar
(function() {
    const badge = document.getElementById('navWishlistBadge');
    if (!badge) return;
    try {
        const items = JSON.parse(localStorage.getItem('sportsHubWishlist') || '[]');
        const count = Array.isArray(items) ? items.length : 0;
        if (count > 0) {
            badge.textContent = count;
            badge.style.display = '';
        } else {
            badge.style.display = 'none';
        }
    } catch(e) {
        badge.style.display = 'none';
    }
})();
</script>
<script>
document.querySelectorAll('form[action="{{ route('logout') }}"]').forEach(form => {
    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const button = this.querySelector('button[type="submit"]');
        const originalText = button ? button.innerHTML : '';
        if (button) {
            button.disabled = true;
            button.innerHTML = 'Dang dang xuat...';
        }

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: new FormData(this),
            });
            const data = await response.json().catch(() => ({}));

            if (!response.ok) {
                throw new Error(data.message || 'Khong the dang xuat');
            }

            window.location.href = data.redirect_url || "{{ route('home') }}";
        } catch (error) {
            alert(error.message);
            if (button) {
                button.disabled = false;
                button.innerHTML = originalText;
            }
        }
    });
});
</script>
@stack('scripts')

{{-- Page transition & prefetch on hover --}}
<script>
(function(){
    const overlay = document.getElementById('pageTransition');
    const origin = location.origin;
    const prefetched = new Set();

    // Prefetch links on hover (load page into browser cache before click)
    document.addEventListener('mouseover', function(e) {
        const a = e.target.closest('a[href]');
        if (!a) return;
        const href = a.href;
        if (!href || prefetched.has(href)) return;
        if (!href.startsWith(origin)) return;
        if (a.target === '_blank' || a.hasAttribute('download')) return;
        if (href.includes('#') && href.split('#')[0] === location.href.split('#')[0]) return;

        prefetched.add(href);
        const link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = href;
        link.as = 'document';
        document.head.appendChild(link);
    }, {passive: true});

    // Smooth fade-out on internal link click
    document.addEventListener('click', function(e) {
        const a = e.target.closest('a[href]');
        if (!a) return;
        const href = a.href;
        if (!href || !href.startsWith(origin)) return;
        if (a.target === '_blank' || a.hasAttribute('download')) return;
        if (href.includes('#') && href.split('#')[0] === location.href.split('#')[0]) return;
        if (e.ctrlKey || e.metaKey || e.shiftKey) return;

        e.preventDefault();
        overlay.classList.add('active');
        setTimeout(function(){ window.location.href = href; }, 150);
    });

    // Handle back/forward navigation
    window.addEventListener('pageshow', function(e) {
        overlay.classList.remove('active');
    });
})();
</script>

</body>
</html>
