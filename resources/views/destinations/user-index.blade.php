@php
    use App\Models\Destination;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Destinations — Wandr</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
:root{
  --g1:#0A1F11;--g2:#0F2D18;--g3:#163D22;
  --accent:#22C55E;--accent2:#16A34A;--accent3:#4ADE80;
  --card:#122119;--card2:#172C1F;
  --border:rgba(34,197,94,.13);--border2:rgba(34,197,94,.22);
  --text:#E8F5EC;--muted:#6EAF82;--dim:#3D6B4F;
  --danger:#F87171;--amber:#FCD34D;--sky:#67E8F9;
  --sidebar-w:260px;--topbar-h:64px;
}
.light{
  --g1:#F0F9F3;--g2:#FFFFFF;--g3:#E8F5EC;
  --card:#FFFFFF;--card2:#F5FBF7;
  --border:rgba(46,125,82,.14);--border2:rgba(46,125,82,.28);
  --text:#0D1F14;--muted:#4A7A5C;--dim:#9EC4AC;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--g1);color:var(--text);display:flex;}
.serif{font-family:'Instrument Serif',serif;}
body::after{content:'';position:fixed;inset:0;pointer-events:none;z-index:999;opacity:.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");background-size:160px;}
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:var(--dim);border-radius:9px}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}
@keyframes gradShift{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
@keyframes imgReveal{from{opacity:0;transform:scale(1.04)}to{opacity:1;transform:scale(1)}}
.fu{animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both}
.fu1{animation-delay:.04s}.fu2{animation-delay:.1s}.fu3{animation-delay:.16s}
.fu4{animation-delay:.22s}.fu5{animation-delay:.28s}

/* ── SIDEBAR ── */
.sidebar{width:var(--sidebar-w);height:100vh;background:var(--g2);border-right:1px solid var(--border);display:flex;flex-direction:column;flex-shrink:0;position:relative;z-index:20;}
.sidebar::before{content:'';position:absolute;top:0;right:0;width:1px;height:100%;background:linear-gradient(to bottom,transparent,var(--accent2),transparent);opacity:.4;}
.sb-logo{padding:0 20px;height:var(--topbar-h);display:flex;align-items:center;gap:12px;border-bottom:1px solid var(--border);}
.sb-logo-icon{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--accent2),var(--accent3));display:flex;align-items:center;justify-content:center;box-shadow:0 0 16px rgba(34,197,94,.3);flex-shrink:0;}
.sb-nav{flex:1;padding:16px 12px;overflow-y:auto;display:flex;flex-direction:column;gap:2px}
.sb-section-label{font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--dim);padding:12px 10px 6px;}
.sb-item{display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:10px;font-size:.82rem;font-weight:500;color:var(--muted);text-decoration:none;cursor:pointer;transition:all .2s;position:relative;border:1px solid transparent;}
.sb-item:hover{color:var(--text);background:rgba(34,197,94,.07);}
.sb-item.active{color:var(--accent3);background:rgba(34,197,94,.1);border-color:var(--border2);font-weight:600;}
.sb-item.active::before{content:'';position:absolute;left:0;top:25%;bottom:25%;width:3px;border-radius:0 3px 3px 0;background:var(--accent);}
.sb-item svg{flex-shrink:0;opacity:.7}.sb-item.active svg{opacity:1}
.sb-badge{margin-left:auto;background:rgba(34,197,94,.15);color:var(--accent3);font-size:.62rem;font-weight:700;padding:2px 7px;border-radius:99px;border:1px solid rgba(34,197,94,.2);}
.sb-footer{padding:16px;border-top:1px solid var(--border);}
.sb-user{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;background:rgba(34,197,94,.06);border:1px solid var(--border);}
.sb-avatar{width:34px;height:34px;border-radius:10px;flex-shrink:0;background:linear-gradient(135deg,var(--accent2),var(--accent3));display:flex;align-items:center;justify-content:center;font-size:.8rem;font-weight:700;color:white;}

/* ── MAIN ── */
.main-wrap{flex:1;min-width:0;display:flex;flex-direction:column;height:100vh;overflow:hidden;}
.topbar{height:var(--topbar-h);flex-shrink:0;background:var(--g2);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 28px;gap:16px;position:relative;z-index:10;}
.topbar-left{display:flex;align-items:center;gap:14px;}
.page-icon{width:38px;height:38px;border-radius:11px;display:flex;align-items:center;justify-content:center;}
.topbar-right{display:flex;align-items:center;gap:8px;}
.icon-btn{width:38px;height:38px;border-radius:10px;background:rgba(34,197,94,.05);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;color:var(--muted);}
.icon-btn:hover{border-color:var(--border2);color:var(--accent3);}
.back-btn{display:flex;align-items:center;gap:7px;padding:8px 16px;border-radius:10px;font-size:.78rem;font-weight:600;background:rgba(34,197,94,.1);border:1px solid var(--border2);color:var(--accent3);text-decoration:none;transition:all .2s;}
.back-btn:hover{background:rgba(34,197,94,.18);}
.logout-btn{display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;font-size:.78rem;font-weight:600;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.18);color:var(--danger);cursor:pointer;transition:all .2s;}
.logout-btn:hover{background:rgba(248,113,113,.13);}
.content{flex:1;overflow-y:auto;padding:28px 32px 40px;display:flex;flex-direction:column;gap:24px;}

/* ── PAGE HERO ── */
.page-hero{
  position:relative;border-radius:20px;overflow:hidden;
  background:linear-gradient(120deg,#071A0D 0%,#0D2E18 40%,#1A5432 72%,#22763D 100%);
  padding:28px 32px;
  box-shadow:0 16px 40px -10px rgba(0,0,0,.5),inset 0 0 0 1px rgba(34,197,94,.1);
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;
}
.page-hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='200'%3E%3Cellipse cx='350' cy='100' rx='200' ry='180' fill='none' stroke='rgba(34,197,94,0.07)' stroke-width='1'/%3E%3Cellipse cx='350' cy='100' rx='130' ry='120' fill='none' stroke='rgba(34,197,94,0.05)' stroke-width='1'/%3E%3C/svg%3E") no-repeat right center / 380px;}
.page-hero-glow{position:absolute;top:-40px;right:-40px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(34,197,94,.13) 0%,transparent 70%);pointer-events:none;}
.hero-eyebrow{font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(74,222,128,.5);font-weight:600;margin-bottom:8px;}
.hero-title{font-family:'Instrument Serif',serif;font-size:clamp(1.6rem,2.5vw,2.4rem);color:white;line-height:1.15;font-weight:400;}
.hero-title em{color:#86EFAC;font-style:italic;}
.hero-sub{color:rgba(255,255,255,.42);font-size:.82rem;margin-top:6px;line-height:1.6;max-width:280px;}

/* ── DEST CARDS ── */
.dest-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:18px;}
.dest-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:18px;overflow:hidden;
  transition:all .32s cubic-bezier(.34,1.56,.64,1);
  position:relative;
}
.dest-card:hover{transform:translateY(-5px);border-color:var(--border2);box-shadow:0 20px 44px rgba(0,0,0,.35);}
.dest-card-img{
  position:relative;height:196px;overflow:hidden;
  background:var(--card2);
}
.dest-card-img img{
  width:100%;height:100%;object-fit:cover;
  opacity:0;transition:opacity .4s,transform .5s;
  animation:none;
}
.dest-card-img img.loaded{opacity:1;}
.dest-card:hover .dest-card-img img{transform:scale(1.06);}
.dest-img-placeholder{
  position:absolute;inset:0;display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  background:linear-gradient(135deg,#0D2E18,#163D22,#1D4E2B);
  background-size:300% 300%;animation:gradShift 8s ease infinite;
}
.dest-status{
  position:absolute;top:12px;right:12px;
  padding:4px 10px;border-radius:6px;
  font-size:.64rem;font-weight:700;letter-spacing:.04em;
  background:rgba(34,197,94,.2);color:#4ADE80;
  border:1px solid rgba(34,197,94,.25);
  backdrop-filter:blur(6px);
}
.dest-price{
  position:absolute;bottom:12px;left:12px;
  background:rgba(10,31,17,.85);backdrop-filter:blur(8px);
  border:1px solid rgba(34,197,94,.2);
  border-radius:10px;padding:7px 11px;
}
.dest-price-label{font-size:.6rem;color:var(--muted);text-transform:uppercase;letter-spacing:.08em;}
.dest-price-val{font-size:1.05rem;font-weight:800;color:var(--accent3);line-height:1.1;}
.dest-img-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.5) 0%,transparent 50%);opacity:0;transition:opacity .3s;}
.dest-card:hover .dest-img-overlay{opacity:1;}
.dest-body{padding:18px 20px;}
.dest-name{font-size:.98rem;font-weight:700;color:var(--text);margin-bottom:4px;}
.dest-loc{display:flex;align-items:center;gap:5px;font-size:.76rem;color:var(--muted);margin-bottom:8px;}
.dest-desc{font-size:.78rem;color:var(--dim);line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.dest-coords{display:inline-flex;align-items:center;gap:5px;margin-top:10px;padding:4px 9px;border-radius:6px;background:rgba(34,197,94,.06);border:1px solid var(--border);font-size:.64rem;color:var(--muted);}
.dest-actions{display:flex;gap:8px;margin-top:14px;padding-top:14px;border-top:1px solid var(--border);}
.btn-view{
  flex:1;display:flex;align-items:center;justify-content:center;gap:6px;
  padding:9px 12px;border-radius:9px;
  font-size:.76rem;font-weight:600;text-decoration:none;
  background:rgba(34,197,94,.08);border:1px solid var(--border2);color:var(--accent3);
  transition:all .2s;
}
.btn-view:hover{background:rgba(34,197,94,.18);}
.btn-book{
  flex:1;display:flex;align-items:center;justify-content:center;gap:6px;
  padding:9px 12px;border-radius:9px;
  font-size:.76rem;font-weight:700;text-decoration:none;
  background:var(--accent2);color:white;
  border:1px solid transparent;
  transition:all .2s;
  box-shadow:0 4px 12px rgba(22,163,74,.25);
}
.btn-book:hover{background:var(--accent);box-shadow:0 6px 18px rgba(34,197,94,.3);}

/* ── STAT PILLS ── */
.stat-pills{display:flex;gap:12px;flex-wrap:wrap;}
.stat-pill{
  display:flex;align-items:center;gap:10px;
  background:var(--card);border:1px solid var(--border);
  border-radius:14px;padding:14px 18px;flex:1;min-width:140px;
  transition:all .25s;
}
.stat-pill:hover{border-color:var(--border2);}
.stat-pill-icon{width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-pill-num{font-family:'Instrument Serif',serif;font-size:1.8rem;line-height:1;}
.stat-pill-label{font-size:.68rem;color:var(--muted);margin-top:1px;}

/* ── MAP ── */
.map-panel{background:var(--card);border:1px solid var(--border);border-radius:18px;overflow:hidden;}
.map-header{padding:18px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;}
.map-title{font-size:.88rem;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
.map-reset{display:flex;align-items:center;gap:6px;padding:7px 12px;border-radius:8px;background:rgba(34,197,94,.07);border:1px solid var(--border);font-size:.72rem;font-weight:600;color:var(--muted);cursor:pointer;transition:all .2s;}
.map-reset:hover{border-color:var(--border2);color:var(--text);}
#wandr-map{height:420px;width:100%;}

/* ── EMPTY ── */
.empty{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 2rem;text-align:center;}
.empty-icon{width:72px;height:72px;border-radius:20px;background:rgba(34,197,94,.07);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--dim);margin-bottom:1.25rem;}

/* ── SECTION ── */
.sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.sec-title{display:flex;align-items:center;gap:10px;}
.sec-title-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.sec-title-text{font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);}
.sec-line{flex:1;height:1px;background:var(--border);margin-left:10px;}
.sec-count{font-size:.72rem;color:var(--dim);padding:3px 9px;border-radius:6px;background:var(--card2);border:1px solid var(--border);}

@media(max-width:768px){.sidebar{display:none;}.dest-grid{grid-template-columns:1fr;}.stat-pills{grid-template-columns:1fr 1fr;}}
</style>
</head>
<body x-data="{ darkMode: true }" :class="darkMode ? '' : 'light'">

<!-- ══════ SIDEBAR ══════ -->
<aside class="sidebar fu fu1">
  <div class="sb-logo">
    <div class="sb-logo-icon">
      <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <span class="serif" style="font-size:1.25rem;color:var(--text);letter-spacing:-.01em;">Wandr</span>
  </div>
  <nav class="sb-nav">
    <span class="sb-section-label">Main</span>
    <a href="{{ route('dashboard') }}" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      Dashboard
    </a>
    <a href="{{ route('user.destinations.index') }}" class="sb-item active">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
      Destinations
      <span class="sb-badge">{{ $destinations->count() }}</span>
    </a>
    <a href="{{ route('bookings.user.index') }}" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      My Bookings
    </a>
    <a href="{{ route('user.gallery.index') }}" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
      Gallery
    </a>
    <span class="sb-section-label" style="margin-top:8px;">Account</span>
    <a href="#" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      Profile
    </a>
    <a href="#" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
      Settings
    </a>
  </nav>
  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">{{ substr(Auth::user()->name,0,1) }}</div>
      <div style="flex:1;min-width:0;">
        <p style="font-size:.78rem;font-weight:600;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</p>
        <p style="font-size:.65rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</p>
      </div>
    </div>
  </div>
</aside>

<!-- ══════ MAIN ══════ -->
<div class="main-wrap">

  <!-- TOPBAR -->
  <header class="topbar fu fu1">
    <div class="topbar-left">
      <div class="page-icon" style="background:rgba(34,197,94,.1);border:1px solid var(--border2);">
        <svg width="18" height="18" fill="none" stroke="var(--accent3)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
      </div>
      <div>
        <p style="font-size:.9rem;font-weight:700;color:var(--text);">Destinations</p>
        <p style="font-size:.7rem;color:var(--muted);">{{ $destinations->count() }} places to explore</p>
      </div>
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
      <button class="icon-btn" @click="darkMode = !darkMode">
        <svg x-show="darkMode" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <svg x-show="!darkMode" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      </button>
      <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:7px;padding:8px 16px;border-radius:10px;font-size:.78rem;font-weight:600;background:rgba(34,197,94,.1);border:1px solid var(--border2);color:var(--accent3);text-decoration:none;transition:all .2s;" onmouseover="this.style.background='rgba(34,197,94,.18)'" onmouseout="this.style.background='rgba(34,197,94,.1)'">
        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Dashboard
      </a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;font-size:.78rem;font-weight:600;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.18);color:#F87171;cursor:pointer;transition:all .2s;">
          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Sign out
        </button>
      </form>
    </div>
  </header>

  <!-- CONTENT -->
  <div class="content">

    <!-- Page hero -->
    <div class="page-hero fu fu2">
      <div class="page-hero-glow"></div>
      <div style="position:relative;z-index:1;">
        <p class="hero-eyebrow">Explore the World</p>
        <h1 class="hero-title">Tourist <em>Destinations</em></h1>
        <p class="hero-sub">Discover breathtaking places and plan your perfect getaway.</p>
      </div>
      <div style="display:flex;gap:16px;flex-wrap:wrap;position:relative;z-index:1;">
        <div style="background:rgba(0,0,0,.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:14px 18px;text-align:center;">
          <p style="font-family:'Instrument Serif',serif;font-size:2rem;color:white;line-height:1;">{{ $destinations->count() }}</p>
          <p style="font-size:.66rem;color:rgba(134,239,172,.6);text-transform:uppercase;letter-spacing:.1em;margin-top:2px;">Destinations</p>
        </div>
        <div style="background:rgba(0,0,0,.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:14px 18px;text-align:center;">
          <p style="font-family:'Instrument Serif',serif;font-size:2rem;color:white;line-height:1;">{{ $destinations->where('is_active',true)->count() }}</p>
          <p style="font-size:.66rem;color:rgba(134,239,172,.6);text-transform:uppercase;letter-spacing:.1em;margin-top:2px;">Active</p>
        </div>
      </div>
    </div>

    <!-- Cards -->
    @if($destinations->count() > 0)
    <div class="fu fu3">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--accent3);"></div>
          <span class="sec-title-text">All Destinations</span>
          <div class="sec-line"></div>
        </div>
        <span class="sec-count">{{ $destinations->count() }} total</span>
      </div>
      <div class="dest-grid">
        @foreach($destinations as $i => $destination)
        <div class="dest-card fu" style="animation-delay:{{ $i * 0.06 }}s;">
          <div class="dest-card-img">
            @if($destination->image)
              <img src="{{ asset('storage/'.$destination->image) }}"
                   alt="{{ $destination->name }}"
                   onload="this.classList.add('loaded')"
                   onerror="this.style.display='none'">
            @endif
            <div class="dest-img-placeholder" @if($destination->image) style="display:none;" @endif>
              <svg width="32" height="32" fill="none" stroke="var(--accent)" opacity=".4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
              <p style="font-size:.72rem;color:var(--muted);margin-top:8px;text-align:center;padding:0 12px;">{{ $destination->name }}</p>
            </div>
            <div class="dest-img-overlay"></div>
            @if($destination->is_active)
              <div class="dest-status">
                <span style="display:inline-block;width:5px;height:5px;border-radius:50%;background:#4ADE80;margin-right:4px;vertical-align:middle;"></span>
                Active
              </div>
            @endif
            @if($destination->price)
              <div class="dest-price">
                <p class="dest-price-label">From</p>
                <p class="dest-price-val">₱{{ number_format($destination->price,2) }}</p>
              </div>
            @endif
          </div>
          <div class="dest-body">
            <h3 class="dest-name">{{ $destination->name }}</h3>
            <div class="dest-loc">
              <svg width="11" height="11" fill="none" stroke="#F87171" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
              {{ $destination->location }}
            </div>
            @if($destination->description)
              <p class="dest-desc">{{ $destination->description }}</p>
            @endif
            @if($destination->latitude && $destination->longitude)
              <div class="dest-coords">
                <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                {{ number_format($destination->latitude,4) }}°, {{ number_format($destination->longitude,4) }}°
              </div>
            @endif
            <div class="dest-actions">
              <a href="{{ route('destinations.show', $destination) }}" class="btn-view">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                View Details
              </a>
              <a href="{{ route('bookings.create', $destination) }}" class="btn-book">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Book Now
              </a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Map -->
    <div class="map-panel fu fu4">
      <div class="map-header">
        <div class="map-title">
          <svg width="16" height="16" fill="none" stroke="var(--accent3)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
          Interactive Map
          <span style="font-size:.65rem;color:var(--muted);font-weight:400;">Click markers to preview</span>
        </div>
        <button class="map-reset" id="mapResetBtn">
          <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
          Reset View
        </button>
      </div>
      <div id="wandr-map"></div>
    </div>

    @else
    <div class="empty fu fu3">
      <div class="empty-icon">
        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
      </div>
      <p style="font-weight:700;font-size:.96rem;color:var(--text);">No destinations yet</p>
      <p style="font-size:.8rem;color:var(--muted);margin-top:6px;">Check back soon for amazing places to explore!</p>
      <a href="{{ route('dashboard') }}" style="margin-top:20px;display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:10px;font-size:.8rem;font-weight:600;background:rgba(34,197,94,.1);border:1px solid var(--border2);color:var(--accent3);text-decoration:none;">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Back to Dashboard
      </a>
    </div>
    @endif

    <!-- Footer -->
    <div style="padding-top:8px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
      <p style="font-size:.7rem;color:var(--dim);">Signed in as <span style="color:var(--accent);font-weight:600;">{{ Auth::user()->email }}</span></p>
      <p class="serif" style="font-size:.7rem;color:var(--dim);">Wandr &copy; {{ date('Y') }}</p>
    </div>

  </div><!-- /content -->
</div><!-- /main-wrap -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  @if($destinations->count() > 0)
  const isDark = !document.body.classList.contains('light');
  const tileUrl = 'https://{s}.basemaps.cartocdn.com/dark_matter/{z}/{x}/{y}{r}.png';
  const map = L.map('wandr-map').setView([10.3157, 123.8854], 6);
  L.tileLayer(tileUrl,{attribution:'© CartoDB',maxZoom:19}).addTo(map);

  const markerHtml = `<div style="width:28px;height:28px;background:linear-gradient(135deg,#16A34A,#4ADE80);border-radius:50% 50% 50% 0;transform:rotate(-45deg);border:2px solid rgba(255,255,255,.3);box-shadow:0 4px 10px rgba(0,0,0,.35);"></div>`;
  const icon = L.divIcon({html:markerHtml,iconSize:[28,28],iconAnchor:[14,28],popupAnchor:[0,-32],className:''});

  const dests = @json($destinations);
  const markers = [];
  dests.forEach(d=>{
    const m = L.marker([d.latitude,d.longitude],{icon}).addTo(map);
    m.bindPopup(`
      <div style="font-family:'Plus Jakarta Sans',sans-serif;min-width:220px;padding:4px;">
        <p style="font-weight:700;font-size:15px;margin-bottom:5px;color:#0D1F14;">${d.name}</p>
        <p style="font-size:12px;color:#6b7280;margin-bottom:8px;">📍 ${d.location}</p>
        ${d.price?`<p style="font-weight:800;color:#16A34A;font-size:16px;">₱${parseFloat(d.price).toLocaleString('en-PH',{minimumFractionDigits:2})}</p>`:''}
        <span style="background:#dcfce7;color:#166534;font-size:11px;font-weight:600;padding:3px 8px;border-radius:5px;">${d.is_active?'✓ Active':'Inactive'}</span>
      </div>
    `,{maxWidth:280});
    markers.push(m);
  });
  if(markers.length>0){
    const g = new L.featureGroup(markers);
    map.fitBounds(g.getBounds().pad(0.12));
  }
  document.getElementById('mapResetBtn').onclick=()=>{
    if(markers.length>0){const g=new L.featureGroup(markers);map.fitBounds(g.getBounds().pad(0.12));}
  };
  @endif
</script>
</body>
</html>