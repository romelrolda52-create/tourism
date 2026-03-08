@php
    use App\Models\Booking;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookings — Wandr</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
.fu{animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both}
.fu1{animation-delay:.04s}.fu2{animation-delay:.1s}.fu3{animation-delay:.16s}
.fu4{animation-delay:.22s}.fu5{animation-delay:.28s}

/* SIDEBAR */
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

/* MAIN */
.main-wrap{flex:1;min-width:0;display:flex;flex-direction:column;height:100vh;overflow:hidden;}
.topbar{height:var(--topbar-h);flex-shrink:0;background:var(--g2);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 28px;gap:16px;position:relative;z-index:10;}
.icon-btn{width:38px;height:38px;border-radius:10px;background:rgba(34,197,94,.05);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .2s;color:var(--muted);}
.icon-btn:hover{border-color:var(--border2);color:var(--accent3);}
.content{flex:1;overflow-y:auto;padding:28px 32px 40px;display:flex;flex-direction:column;gap:20px;}

/* PAGE HERO */
.page-hero{position:relative;border-radius:20px;overflow:hidden;background:linear-gradient(120deg,#1A0A00 0%,#2D1A06 40%,#7C4A10 72%,#B87333 100%);padding:28px 32px;box-shadow:0 16px 40px -10px rgba(0,0,0,.5),inset 0 0 0 1px rgba(252,211,77,.08);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;}
.page-hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='200'%3E%3Cellipse cx='350' cy='100' rx='200' ry='180' fill='none' stroke='rgba(252,211,77,0.06)' stroke-width='1'/%3E%3Cellipse cx='350' cy='100' rx='130' ry='120' fill='none' stroke='rgba(252,211,77,0.04)' stroke-width='1'/%3E%3C/svg%3E") no-repeat right center / 380px;}
.hero-glow-amber{position:absolute;top:-40px;right:-40px;width:220px;height:220px;border-radius:50%;background:radial-gradient(circle,rgba(252,211,77,.1) 0%,transparent 70%);pointer-events:none;}
.hero-eyebrow{font-size:.62rem;letter-spacing:.2em;text-transform:uppercase;color:rgba(252,211,77,.5);font-weight:600;margin-bottom:8px;}
.hero-title{font-family:'Instrument Serif',serif;font-size:clamp(1.6rem,2.5vw,2.4rem);color:white;line-height:1.15;font-weight:400;}
.hero-title em{color:#FCD34D;font-style:italic;}
.hero-sub{color:rgba(255,255,255,.42);font-size:.82rem;margin-top:6px;line-height:1.6;max-width:280px;}

/* BOOKING CARDS */
.booking-card{
  background:var(--card);border:1px solid var(--border);border-radius:18px;
  overflow:hidden;transition:all .28s cubic-bezier(.34,1.56,.64,1);
  position:relative;
}
.booking-card:hover{border-color:var(--border2);box-shadow:0 12px 32px rgba(0,0,0,.25);transform:translateY(-2px);}
.booking-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;border-radius:0;background:var(--accent);opacity:0;transition:opacity .2s;}
.booking-card:hover::before{opacity:1;}
.bc-header{padding:18px 20px 0;display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.bc-icon{width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,rgba(252,211,77,.15),rgba(252,211,77,.08));border:1px solid rgba(252,211,77,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.bc-id{font-family:'Instrument Serif',serif;font-size:.88rem;color:var(--muted);}
.bc-name{font-size:1.02rem;font-weight:700;color:var(--text);margin-top:3px;}
.bc-sub{font-size:.76rem;color:var(--muted);margin-top:2px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.bc-body{padding:16px 20px;display:flex;flex-wrap:wrap;gap:18px;}
.bc-stat{display:flex;flex-direction:column;gap:2px;}
.bc-stat-label{font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}
.bc-stat-val{font-size:.86rem;font-weight:600;color:var(--text);}
.bc-divider{width:1px;background:var(--border);flex-shrink:0;align-self:stretch;}
.bc-arrow{display:flex;align-items:center;color:var(--dim);padding-top:10px;}
.bc-footer{padding:12px 20px;border-top:1px solid var(--border);background:rgba(34,197,94,.02);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;}
.bc-special{font-size:.76rem;color:var(--muted);display:flex;align-items:flex-start;gap:7px;flex:1;}
.bc-price{font-family:'Instrument Serif',serif;font-size:1.35rem;color:var(--accent3);font-weight:400;}

/* BADGES */
.badge{display:inline-flex;align-items:center;gap:5px;padding:3px 9px;border-radius:6px;font-size:.67rem;font-weight:700;letter-spacing:.02em;}
.badge-dot{width:5px;height:5px;border-radius:50%;background:currentColor;animation:pulse 2s infinite;}
.b-amber{background:rgba(252,211,77,.1);color:#FCD34D;border:1px solid rgba(252,211,77,.15);}
.b-sky{background:rgba(103,232,249,.1);color:#67E8F9;border:1px solid rgba(103,232,249,.15);}
.b-red{background:rgba(248,113,113,.1);color:#F87171;border:1px solid rgba(248,113,113,.15);}
.b-green{background:rgba(34,197,94,.12);color:#4ADE80;border:1px solid rgba(34,197,94,.15);}
.b-gray{background:rgba(110,175,130,.08);color:var(--muted);border:1px solid var(--border);}

/* SEC */
.sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
.sec-title{display:flex;align-items:center;gap:10px;}
.sec-title-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
.sec-title-text{font-size:.68rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);}
.sec-line{flex:1;height:1px;background:var(--border);margin-left:10px;}

/* EMPTY */
.empty{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:5rem 2rem;text-align:center;background:var(--card);border:1px solid var(--border);border-radius:18px;}
.empty-icon{width:72px;height:72px;border-radius:20px;background:rgba(34,197,94,.07);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--dim);margin-bottom:1.25rem;}

/* ALERT */
.alert-success{background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;}
.alert-icon{width:36px;height:36px;border-radius:10px;background:rgba(34,197,94,.15);display:flex;align-items:center;justify-content:center;flex-shrink:0;}

@media(max-width:768px){.sidebar{display:none;}.bc-body{flex-direction:column;}.bc-divider{display:none;}.bc-arrow{display:none;}}
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
    <a href="{{ route('user.destinations.index') }}" class="sb-item">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
      Destinations
    </a>
    <a href="{{ route('bookings.user.index') }}" class="sb-item active">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      My Bookings
      <span class="sb-badge">{{ $bookings->count() }}</span>
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
    <div style="display:flex;align-items:center;gap:14px;">
      <div style="width:38px;height:38px;border-radius:11px;background:rgba(252,211,77,.1);border:1px solid rgba(252,211,77,.2);display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="none" stroke="#FCD34D" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      </div>
      <div>
        <p style="font-size:.9rem;font-weight:700;color:var(--text);">My Bookings</p>
        <p style="font-size:.7rem;color:var(--muted);">{{ $bookings->count() }} {{ Str::plural('reservation',$bookings->count()) }}</p>
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
        <button type="submit" style="display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;font-size:.78rem;font-weight:600;background:rgba(248,113,113,.07);border:1px solid rgba(248,113,113,.18);color:#F87171;cursor:pointer;">
          <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Sign out
        </button>
      </form>
    </div>
  </header>

  <!-- CONTENT -->
  <div class="content">

    <!-- Hero -->
    <div class="page-hero fu fu2">
      <div class="hero-glow-amber"></div>
      <div style="position:relative;z-index:1;">
        <p class="hero-eyebrow">Your Reservations</p>
        <h1 class="hero-title">My <em>Bookings</em></h1>
        <p class="hero-sub">Track all your travel reservations and booking history.</p>
      </div>
      <div style="display:flex;gap:12px;flex-wrap:wrap;position:relative;z-index:1;">
        @php
          $pending   = $bookings->where('status','pending')->count();
          $confirmed = $bookings->where('status','confirmed')->count();
          $cancelled = $bookings->where('status','cancelled')->count();
        @endphp
        <div style="background:rgba(0,0,0,.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:13px 16px;text-align:center;">
          <p style="font-family:'Instrument Serif',serif;font-size:1.8rem;color:white;line-height:1;">{{ $bookings->count() }}</p>
          <p style="font-size:.62rem;color:rgba(252,211,77,.6);text-transform:uppercase;letter-spacing:.1em;margin-top:2px;">Total</p>
        </div>
        <div style="background:rgba(0,0,0,.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:13px 16px;text-align:center;">
          <p style="font-family:'Instrument Serif',serif;font-size:1.8rem;color:#67E8F9;line-height:1;">{{ $confirmed }}</p>
          <p style="font-size:.62rem;color:rgba(103,232,249,.55);text-transform:uppercase;letter-spacing:.1em;margin-top:2px;">Confirmed</p>
        </div>
        <div style="background:rgba(0,0,0,.2);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:13px 16px;text-align:center;">
          <p style="font-family:'Instrument Serif',serif;font-size:1.8rem;color:#FCD34D;line-height:1;">{{ $pending }}</p>
          <p style="font-size:.62rem;color:rgba(252,211,77,.55);text-transform:uppercase;letter-spacing:.1em;margin-top:2px;">Pending</p>
        </div>
      </div>
    </div>

    @if(session('success'))
    <div class="alert-success fu fu2">
      <div class="alert-icon">
        <svg width="18" height="18" fill="none" stroke="var(--accent3)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <div>
        <p style="font-weight:700;font-size:.84rem;color:var(--accent3);">Success!</p>
        <p style="font-size:.78rem;color:var(--muted);margin-top:2px;">{{ session('success') }}</p>
      </div>
    </div>
    @endif

    @if($bookings->count() > 0)

    <div class="fu fu3">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--amber);"></div>
          <span class="sec-title-text">All Bookings</span>
          <div class="sec-line"></div>
        </div>
        <span style="font-size:.72rem;color:var(--dim);padding:3px 9px;border-radius:6px;background:var(--card2);border:1px solid var(--border);">{{ $bookings->count() }} total</span>
      </div>

      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($bookings as $i => $booking)
        <div class="booking-card fu" style="animation-delay:{{ $i * 0.06 + 0.18 }}s;">

          <div class="bc-header">
            <div style="display:flex;align-items:flex-start;gap:14px;">
              <div class="bc-icon">
                <svg width="22" height="22" fill="none" stroke="#FCD34D" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
              </div>
              <div>
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:4px;">
                  <span class="bc-id">{{ $booking->booking_id ?? '—' }}</span>
                  @switch($booking->status)
                    @case('pending') <span class="badge b-amber"><span class="badge-dot"></span>Pending</span> @break
                    @case('confirmed') <span class="badge b-sky"><span class="badge-dot"></span>Confirmed</span> @break
                    @case('cancelled') <span class="badge b-red">Cancelled</span> @break
                    @case('completed') <span class="badge b-green"><span class="badge-dot"></span>Completed</span> @break
                    @default <span class="badge b-gray">{{ ucfirst($booking->status) }}</span>
                  @endswitch
                </div>
                <p class="bc-name">{{ $booking->destination ? $booking->destination->name : 'Destination' }}</p>
                <div class="bc-sub">
                  <span style="display:flex;align-items:center;gap:4px;">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $booking->guest_name }}
                  </span>
                  <span style="display:flex;align-items:center;gap:4px;">
                    <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $booking->number_of_guests }} {{ Str::plural('guest',$booking->number_of_guests) }}
                  </span>
                </div>
              </div>
            </div>
            <div class="bc-price">₱{{ number_format($booking->total_price, 2) }}</div>
          </div>

          <div class="bc-body">
            <div class="bc-stat">
              <span class="bc-stat-label">Check-in</span>
              <span class="bc-stat-val">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
            </div>
            <div class="bc-arrow">
              <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
            <div class="bc-stat">
              <span class="bc-stat-label">Check-out</span>
              <span class="bc-stat-val">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
            </div>
            @if($booking->hotel)
            <div class="bc-divider"></div>
            <div class="bc-stat">
              <span class="bc-stat-label">Hotel</span>
              <span class="bc-stat-val">{{ $booking->hotel->name }}</span>
            </div>
            @endif
            @if($booking->room)
            <div class="bc-divider"></div>
            <div class="bc-stat">
              <span class="bc-stat-label">Room</span>
              <span class="bc-stat-val">{{ $booking->room->name ?? 'Room '.$booking->room->id }}</span>
            </div>
            @endif
          </div>

          @if($booking->special_requests)
          <div class="bc-footer">
            <div class="bc-special">
              <svg width="13" height="13" fill="none" stroke="var(--accent3)" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
              {{ $booking->special_requests }}
            </div>
          </div>
          @endif
        </div>
        @endforeach
      </div>
    </div>

    @else
    <div class="empty fu fu3">
      <div class="empty-icon">
        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      </div>
      <p style="font-weight:700;font-size:.96rem;color:var(--text);">No bookings yet</p>
      <p style="font-size:.8rem;color:var(--muted);margin-top:6px;">Start exploring and make your first reservation!</p>
      <a href="{{ route('user.destinations.index') }}" style="margin-top:20px;display:inline-flex;align-items:center;gap:7px;padding:10px 20px;border-radius:10px;font-size:.8rem;font-weight:600;background:rgba(34,197,94,.1);border:1px solid var(--border2);color:var(--accent3);text-decoration:none;">
        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        Explore Destinations
      </a>
    </div>
    @endif

    <div style="padding-top:8px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
      <p style="font-size:.7rem;color:var(--dim);">Signed in as <span style="color:var(--accent);font-weight:600;">{{ Auth::user()->email }}</span></p>
      <p class="serif" style="font-size:.7rem;color:var(--dim);">Wandr &copy; {{ date('Y') }}</p>
    </div>

  </div>
</div>

</body>
</html>