@php
    use App\Models\User;
    use App\Models\Destination;
    use App\Models\Gallery;
    use App\Models\Booking;
    use Illuminate\Support\Facades\DB;

    $totalDestinations = Destination::where('is_active', true)->count();
    $totalGallery      = Gallery::count();
    $availableDestinations = Destination::where('is_active', true)->orderBy('created_at', 'desc')->get();
    $galleryItems      = Gallery::with('user')->latest()->get();
    $userBookings      = Booking::with(['destination', 'hotel', 'room'])->where('user_id', Auth::id())->latest()->get();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard — USER</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── TOKENS ─────────────────────────────────── */
:root {
  --g1:#0A1F11; --g2:#0F2D18; --g3:#163D22;
  --accent:#22C55E; --accent2:#16A34A; --accent3:#4ADE80;
  --card:#122119; --card2:#172C1F;
  --border:rgba(34,197,94,.13);
  --border2:rgba(34,197,94,.22);
  --text:#E8F5EC; --muted:#6EAF82; --dim:#3D6B4F;
  --danger:#F87171; --amber:#FCD34D; --sky:#67E8F9;
  --sidebar-w:280px;
  --topbar-h:70px;
}
.light {
  --g1:#F0F9F3; --g2:#FFFFFF; --g3:#E8F5EC;
  --card:#FFFFFF; --card2:#F5FBF7;
  --border:rgba(46,125,82,.14); --border2:rgba(46,125,82,.28);
  --text:#0D1F14; --muted:#4A7A5C; --dim:#9EC4AC;
}

/* ─── RESET & BASE ───────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html,body{height:100%;overflow:hidden}
body{
  font-family:'Plus Jakarta Sans',sans-serif;
  background:var(--g1);
  color:var(--text);
  display:flex;
  transition:background 0.3s ease;
}
.serif{font-family:'Instrument Serif',serif;}

/* noise overlay */
body::after{
  content:'';position:fixed;inset:0;pointer-events:none;z-index:999;
  opacity:.02;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size:160px;
}

/* scrollbar */
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-track{background:transparent}
::-webkit-scrollbar-thumb{background:var(--dim);border-radius:9px}
::-webkit-scrollbar-thumb:hover{background:var(--accent2);}

/* ─── ANIMATIONS ─────────────────────────────── */
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes spin{from{transform:rotate(0)}to{transform:rotate(360deg)}}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}
@keyframes slideRight{from{transform:translateX(-8px);opacity:0}to{transform:translateX(0);opacity:1}}
@keyframes shimmer{0%{background-position:-400px 0}100%{background-position:400px 0}}
@keyframes glowPulse{0%,100%{box-shadow:0 0 5px rgba(34,197,94,.2)}50%{box-shadow:0 0 20px rgba(34,197,94,.4)}}

.fu{animation:fadeUp .6s cubic-bezier(.22,1,.36,1) both}
.fu1{animation-delay:.04s}.fu2{animation-delay:.1s}.fu3{animation-delay:.16s}
.fu4{animation-delay:.22s}.fu5{animation-delay:.28s}.fu6{animation-delay:.34s}

/* ─── SIDEBAR ────────────────────────────────── */
.sidebar{
  width:var(--sidebar-w);
  height:100vh;
  background:var(--g2);
  border-right:1px solid var(--border);
  display:flex;flex-direction:column;
  flex-shrink:0;
  position:relative;
  z-index:20;
  backdrop-filter: blur(10px);
}
.sidebar::before{
  content:'';position:absolute;top:0;right:0;width:1px;height:100%;
  background:linear-gradient(to bottom,transparent,var(--accent2),transparent);
  opacity:.4;
}

.sb-logo{
  padding:0 24px;height:var(--topbar-h);
  display:flex;align-items:center;gap:12px;
  border-bottom:1px solid var(--border);
}
.sb-logo-icon{
  width:40px;height:40px;border-radius:12px;
  background:linear-gradient(135deg,var(--accent2),var(--accent3));
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 0 16px rgba(34,197,94,.3);
  flex-shrink:0;
  animation: glowPulse 2s infinite;
}

.sb-nav{flex:1;padding:20px 16px;overflow-y:auto;display:flex;flex-direction:column;gap:4px}

.sb-section-label{
  font-size:.65rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;
  color:var(--dim);padding:16px 12px 8px;
}

.sb-item{
  display:flex;align-items:center;gap:12px;
  padding:10px 14px;border-radius:12px;
  font-size:.85rem;font-weight:500;color:var(--muted);
  text-decoration:none;cursor:pointer;
  transition:all .25s cubic-bezier(.4,0,.2,1);
  position:relative;
  border:1px solid transparent;
}
.sb-item:hover{
  color:var(--text);
  background:linear-gradient(135deg,rgba(34,197,94,.08),rgba(34,197,94,.03));
  transform:translateX(3px);
}
.sb-item.active{
  color:var(--accent3);
  background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(34,197,94,.05));
  border-color:var(--border2);
  font-weight:600;
}
.sb-item.active::before{
  content:'';position:absolute;left:0;top:20%;bottom:20%;
  width:3px;border-radius:0 3px 3px 0;
  background:linear-gradient(135deg,var(--accent),var(--accent3));
}
.sb-item svg{flex-shrink:0;opacity:.7;transition:transform 0.2s;}
.sb-item:hover svg{transform:scale(1.05);opacity:1;}
.sb-item.active svg{opacity:1}

.sb-badge{
  margin-left:auto;
  background:linear-gradient(135deg,rgba(34,197,94,.15),rgba(34,197,94,.05));
  color:var(--accent3);
  font-size:.62rem;font-weight:700;
  padding:2px 8px;border-radius:99px;
  border:1px solid rgba(34,197,94,.2);
}

.sb-footer{
  padding:20px;border-top:1px solid var(--border);
}
.sb-user{
  display:flex;align-items:center;gap:12px;
  padding:12px 14px;border-radius:14px;
  background:linear-gradient(135deg,rgba(34,197,94,.08),rgba(34,197,94,.02));
  border:1px solid var(--border);
  transition:all 0.2s;
}
.sb-user:hover{
  background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(34,197,94,.04));
  transform:translateY(-2px);
}
.sb-avatar{
  width:38px;height:38px;border-radius:12px;flex-shrink:0;
  background:linear-gradient(135deg,var(--accent2),var(--accent3));
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;font-weight:700;color:white;
}

/* ─── MAIN AREA ──────────────────────────────── */
.main-wrap{
  flex:1;min-width:0;
  display:flex;flex-direction:column;
  height:100vh;overflow:hidden;
}

/* ─── TOP BAR ────────────────────────────────── */
.topbar{
  height:var(--topbar-h);flex-shrink:0;
  background:rgba(18,33,25,.8);
  backdrop-filter: blur(12px);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 32px;gap:16px;
  position:relative;z-index:10;
}

.topbar-search{
  display:flex;align-items:center;gap:10px;
  background:rgba(34,197,94,.05);
  border:1px solid var(--border);
  border-radius:14px;padding:8px 16px;
  flex:1;max-width:360px;
  transition:all 0.2s;
}
.topbar-search:focus-within{
  border-color:var(--accent2);
  background:rgba(34,197,94,.08);
  box-shadow:0 0 0 3px rgba(34,197,94,.1);
}
.topbar-search input{
  background:transparent;border:none;outline:none;
  font-size:.85rem;color:var(--text);
  font-family:'Plus Jakarta Sans',sans-serif;width:100%;
}
.topbar-search input::placeholder{color:var(--dim);}

.topbar-right{display:flex;align-items:center;gap:12px;}

.icon-btn{
  width:40px;height:40px;border-radius:12px;
  background:rgba(34,197,94,.05);border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;transition:all .25s;color:var(--muted);
  position:relative;
}
.icon-btn:hover{
  border-color:var(--border2);
  color:var(--accent3);
  transform:translateY(-2px);
  background:rgba(34,197,94,.1);
}

.logout-btn{
  display:flex;align-items:center;gap:8px;
  padding:8px 16px;border-radius:12px;
  font-size:.8rem;font-weight:600;
  background:rgba(248,113,113,.08);
  border:1px solid rgba(248,113,113,.2);
  color:var(--danger);cursor:pointer;
  transition:all .25s;
}
.logout-btn:hover{
  background:rgba(248,113,113,.15);
  transform:translateY(-2px);
  border-color:rgba(248,113,113,.3);
}

/* ─── CONTENT AREA ───────────────────────────── */
.content{
  flex:1;overflow-y:auto;
  padding:32px 40px 48px;
  display:flex;flex-direction:column;gap:32px;
}

/* ─── HERO BANNER ────────────────────────────── */
.hero{
  position:relative;border-radius:28px;overflow:hidden;
  background:linear-gradient(135deg,#071A0D 0%,#0D2E18 40%,#1A5432 72%,#22763D 100%);
  padding:40px 48px;
  box-shadow:0 25px 50px -12px rgba(0,0,0,.5),inset 0 1px 0 rgba(255,255,255,.05);
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:24px;
  transition:transform 0.3s ease;
}
.hero:hover{
  transform:translateY(-3px);
}
.hero::before{
  content:'';position:absolute;inset:0;
  background:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='200'%3E%3Cellipse cx='350' cy='100' rx='200' ry='180' fill='none' stroke='rgba(34,197,94,0.08)' stroke-width='1'/%3E%3Cellipse cx='350' cy='100' rx='150' ry='130' fill='none' stroke='rgba(34,197,94,0.06)' stroke-width='1'/%3E%3Cellipse cx='350' cy='100' rx='100' ry='80' fill='none' stroke='rgba(34,197,94,0.04)' stroke-width='1'/%3E%3C/svg%3E") no-repeat right center / 400px;
  pointer-events:none;
}
.hero-glow{
  position:absolute;top:-40px;right:-40px;
  width:280px;height:280px;border-radius:50%;
  background:radial-gradient(circle,rgba(34,197,94,.15) 0%,transparent 70%);
  pointer-events:none;
  animation: pulse 4s infinite;
}
.hero-tag{
  font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;
  color:rgba(74,222,128,.6);font-weight:700;margin-bottom:12px;
}
.hero h1{
  font-family:'Instrument Serif',serif;
  font-size:clamp(2rem,3.5vw,3rem);
  color:white;line-height:1.1;font-weight:400;
  margin-bottom:8px;
}
.hero h1 em{color:#86EFAC;font-style:italic;}
.hero p{color:rgba(255,255,255,.5);font-size:.9rem;margin-top:8px;max-width:350px;line-height:1.6;}
.hero-cta{
  display:inline-flex;align-items:center;gap:10px;
  margin-top:24px;padding:12px 28px;border-radius:99px;
  background:white;color:#071A0D;
  font-size:.85rem;font-weight:700;
  text-decoration:none;
  box-shadow:0 4px 16px rgba(0,0,0,.25);
  transition:all .3s cubic-bezier(.34,1.56,.64,1);
}
.hero-cta:hover{
  transform:translateY(-3px) scale(1.02);
  box-shadow:0 12px 28px rgba(0,0,0,.35);
  gap:14px;
}

.hero-meta{
  display:flex;flex-direction:column;gap:12px;
  background:rgba(0,0,0,.3);backdrop-filter:blur(12px);
  border:1px solid rgba(255,255,255,.1);
  border-radius:20px;padding:20px 24px;
  flex-shrink:0;
}
.hero-meta-row{
  display:flex;align-items:center;gap:10px;
  font-size:.85rem;color:rgba(134,239,172,.8);
}

/* ─── STAT CARDS ─────────────────────────────── */
.stats-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
.stat{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:24px;
  padding:24px;
  position:relative;
  overflow:hidden;
  transition:all .4s cubic-bezier(.34,1.56,.64,1);
}
.stat:hover{
  transform:translateY(-6px);
  border-color:var(--border2);
  box-shadow:0 20px 40px -12px rgba(0,0,0,.3);
}
.stat-shine{
  position:absolute;top:-30px;right:-30px;
  width:120px;height:120px;border-radius:50%;
  filter:blur(40px);opacity:.12;
  transition:opacity 0.3s;
}
.stat:hover .stat-shine{opacity:.2;}
.stat-icon{
  width:48px;height:48px;border-radius:16px;
  display:flex;align-items:center;justify-content:center;
  margin-bottom:18px;
  transition:transform 0.3s;
}
.stat:hover .stat-icon{transform:scale(1.05) rotate(-3deg);}
.stat-num{
  font-family:'Instrument Serif',serif;
  font-size:2.8rem;line-height:1;
  font-weight:400;
  margin-bottom:6px;
}
.stat-label{font-size:.75rem;color:var(--muted);font-weight:500;letter-spacing:.02em;}

/* ─── SECTION HEAD ───────────────────────────── */
.sec-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;}
.sec-title{display:flex;align-items:center;gap:12px;}
.sec-title-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;}
.sec-title-text{font-size:.7rem;font-weight:800;letter-spacing:.15em;text-transform:uppercase;color:var(--muted);}
.sec-line{flex:1;height:1px;background:linear-gradient(90deg,var(--border),transparent);margin-left:12px;}
.sec-link{
  font-size:.8rem;font-weight:600;color:var(--accent);
  text-decoration:none;display:flex;align-items:center;gap:6px;
  transition:all .25s;
  padding:6px 12px;
  border-radius:10px;
  background:rgba(34,197,94,.05);
}
.sec-link:hover{gap:12px;background:rgba(34,197,94,.1);}

/* ─── TABLE PANEL ───────────────── */
.tpanel{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:24px;
  overflow:hidden;
  transition:all 0.3s;
}
.tpanel:hover{box-shadow:0 8px 24px rgba(0,0,0,.15);}

.thead{
  display:grid;
  align-items:center;
  gap:12px;
  padding:14px 24px;
  background:linear-gradient(90deg,rgba(34,197,94,.06),rgba(34,197,94,.02));
  border-bottom:1px solid var(--border);
}
.th{
  font-size:.65rem;font-weight:800;
  letter-spacing:.12em;text-transform:uppercase;
  color:var(--dim);
}

.trow{
  display:grid;
  align-items:center;
  gap:12px;
  padding:16px 24px;
  border-bottom:1px solid var(--border);
  transition:all .25s;
  position:relative;
}
.trow:last-child{border-bottom:none;}
.trow:hover{
  background:linear-gradient(90deg,rgba(34,197,94,.06),rgba(34,197,94,.01));
}

.trow::after{
  content:'';
  position:absolute;left:0;top:50%;
  transform:translateY(-50%) scaleY(0);
  width:3px;height:50%;border-radius:0 4px 4px 0;
  background:linear-gradient(135deg,var(--accent),var(--accent3));
  transition:transform .3s cubic-bezier(.34,1.56,.64,1);
}
.trow:hover::after{transform:translateY(-50%) scaleY(1);}

.tcell{display:flex;flex-direction:column;gap:4px;min-width:0;overflow:hidden;}
.tcell-label{display:none;font-size:.6rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--dim);}
.tv{font-size:.85rem;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
.tv-bold{font-weight:600;}
.tv-muted{color:var(--muted);}
.tv-sub{font-size:.72rem;color:var(--muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}

.thumb{
  width:44px;height:44px;border-radius:12px;overflow:hidden;flex-shrink:0;
  background:linear-gradient(135deg,var(--accent2),var(--accent3));
  display:flex;align-items:center;justify-content:center;
}
.thumb img{width:100%;height:100%;object-fit:cover;}

.av{
  width:28px;height:28px;border-radius:10px;flex-shrink:0;
  background:linear-gradient(135deg,var(--accent2),var(--accent3));
  display:flex;align-items:center;justify-content:center;
  font-size:.7rem;font-weight:700;color:white;
}

.badge{
  display:inline-flex;align-items:center;gap:6px;
  padding:4px 12px;border-radius:8px;
  font-size:.7rem;font-weight:700;letter-spacing:.02em;
}
.badge-dot{width:6px;height:6px;border-radius:50%;background:currentColor;animation:pulse 2s infinite;}
.b-green {background:rgba(34,197,94,.12);color:#4ADE80;border:1px solid rgba(34,197,94,.2);}
.b-amber {background:rgba(252,211,77,.1);color:#FCD34D;border:1px solid rgba(252,211,77,.2);}
.b-sky   {background:rgba(103,232,249,.1);color:#67E8F9;border:1px solid rgba(103,232,249,.2);}
.b-red   {background:rgba(248,113,113,.1);color:#F87171;border:1px solid rgba(248,113,113,.2);}
.b-gray  {background:rgba(110,175,130,.08);color:var(--muted);border:1px solid var(--border);}

.vbtn{
  display:inline-flex;align-items:center;gap:6px;
  padding:6px 14px;border-radius:10px;
  font-size:.75rem;font-weight:600;
  border:1px solid var(--border);color:var(--muted);
  text-decoration:none;white-space:nowrap;
  transition:all .2s;background:transparent;
}
.vbtn:hover{
  background:var(--accent);
  color:#071A0D;
  border-color:var(--accent);
  transform:translateY(-2px);
}

.price{color:var(--accent3);font-weight:700;font-size:1rem;}

.tfoot{
  padding:14px 24px;
  border-top:1px solid var(--border);
  background:linear-gradient(90deg,rgba(34,197,94,.04),rgba(34,197,94,.01));
  display:flex;align-items:center;justify-content:space-between;
}
.tfoot-count{font-size:.75rem;color:var(--dim);}
.tfoot-link{
  display:inline-flex;align-items:center;gap:6px;
  font-size:.8rem;font-weight:700;color:var(--accent);
  text-decoration:none;transition:all .25s;
  padding:6px 12px;
  border-radius:10px;
}
.tfoot-link:hover{gap:12px;background:rgba(34,197,94,.08);}

.empty{padding:4rem 2rem;text-align:center;}
.empty-icon{
  width:64px;height:64px;margin:0 auto 16px;border-radius:20px;
  background:rgba(34,197,94,.07);border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;color:var(--dim);
}

/* ─── QUICK ACTIONS ──────────────────────────── */
.qa-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
.qa{
  display:flex;align-items:center;gap:16px;
  background:var(--card);border:1px solid var(--border);
  border-radius:20px;padding:20px 24px;
  text-decoration:none;color:inherit;
  position:relative;overflow:hidden;
  transition:all .35s cubic-bezier(.34,1.56,.64,1);
}
.qa::before{
  content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--accent),var(--accent3),transparent);
  transform:scaleX(0);transform-origin:left;transition:transform .35s;
}
.qa:hover{
  transform:translateY(-6px);
  border-color:var(--border2);
  box-shadow:0 20px 32px -12px rgba(0,0,0,.3);
}
.qa:hover::before{transform:scaleX(1);}
.qa-icon{
  width:56px;height:56px;border-radius:16px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  transition:all .3s cubic-bezier(.34,1.56,.64,1);
}
.qa:hover .qa-icon{
  transform:scale(1.1) rotate(-5deg);
}

/* ─── RESPONSIVE ─────────────────────────────── */
@media(max-width:1024px){
  .content{padding:24px;}
  .stats-grid{gap:16px;}
}
@media(max-width:768px){
  .sidebar{display:none;}
  .stats-grid{grid-template-columns:1fr 1fr;}
  .qa-grid{grid-template-columns:1fr;}
  .thead{display:none;}
  .trow{display:flex;flex-direction:column;gap:12px;padding:20px;}
  .tcell-label{display:block;}
  .tv{white-space:normal;}
  .hero{padding:32px;}
  .hero-meta{margin-top:20px;width:100%;}
}
@media(max-width:480px){
  .stats-grid{grid-template-columns:1fr;}
  .content{padding:20px;}
  .topbar{padding:0 20px;}
  .topbar-search{max-width:200px;}
}

/* ─── LIGHT MODE OVERRIDES ───────────────────── */
.light body{background:var(--g1);}
.light .sidebar,.light .topbar{background:rgba(255,255,255,.9);backdrop-filter:blur(12px);}
.light .hero{background:linear-gradient(135deg,#064E1A 0%,#166534 40%,#16A34A 72%,#22C55E 100%);}
.light .tpanel,.light .stat,.light .qa{background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.04);}
</style>
</head>

<body x-data="{ darkMode: true }" :class="darkMode ? '' : 'light'">

<!-- SIDEBAR -->
<aside class="sidebar fu fu1">

  <div class="sb-logo">
    <div class="sb-logo-icon">
      <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>
    <span class="serif" style="font-size:1.3rem;color:var(--text);letter-spacing:-.01em;font-weight:600;">USER</span>
  </div>

  <nav class="sb-nav">
    <span class="sb-section-label">Main</span>

    <a href="#" class="sb-item active">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
      Dashboard
    </a>

    <a href="{{ route('bookings.user.index') }}" class="sb-item">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      My Bookings
      <span class="sb-badge">{{ $userBookings->count() }}</span>
    </a>

    <span class="sb-section-label" style="margin-top:12px;">Account</span>

    <a href="#" class="sb-item">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      Profile
    </a>

    <a href="#" class="sb-item">
      <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
      Settings
    </a>
  </nav>

  <div class="sb-footer">
    <div class="sb-user">
      <div class="sb-avatar">{{ substr(Auth::user()->name,0,1) }}</div>
      <div style="flex:1;min-width:0;">
        <p style="font-size:.8rem;font-weight:700;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</p>
        <p style="font-size:.68rem;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->email }}</p>
      </div>
    </div>
  </div>
</aside>

<!-- MAIN WRAPPER -->
<div class="main-wrap">

  <!-- TOP BAR -->
  <header class="topbar fu fu1">
    <div class="topbar-search">
      <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--dim);flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
      <input type="text" placeholder="Search destinations, bookings…">
    </div>

    <div class="topbar-right">
      <button class="icon-btn" @click="darkMode = !darkMode">
        <svg x-show="darkMode" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <svg x-show="!darkMode" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
      </button>

      <button class="icon-btn" style="position:relative;">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <span style="position:absolute;top:10px;right:10px;width:8px;height:8px;border-radius:50%;background:var(--accent);box-shadow:0 0 8px var(--accent);"></span>
      </button>

      <div style="width:1px;height:32px;background:var(--border);"></div>

      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="logout-btn">
          <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Sign out
        </button>
      </form>
    </div>
  </header>

  <!-- SCROLLABLE CONTENT -->
  <div class="content">

    <!-- HERO -->
    <div class="hero fu fu2">
      <div class="hero-glow"></div>
      <div style="position:relative;z-index:1;">
        <p class="hero-tag">✨ Your Travel Hub</p>
        <h1>Welcome back,<br><em>{{ Auth::user()->name }}.</em></h1>
        <p>Your next adventure is just a booking away. Ready to explore?</p>
        <a href="{{ route('user.destinations.index') }}" class="hero-cta">
          Explore now
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
      <div class="hero-meta">
        <div class="hero-meta-row">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          {{ now()->format('l, F j, Y') }}
        </div>
        <div class="hero-meta-row">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          {{ now()->format('g:i A') }}
        </div>
        <div class="hero-meta-row" style="margin-top:6px;padding-top:12px;border-top:1px solid rgba(255,255,255,.1);">
          <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:rgba(74,222,128,.7)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <span style="color:rgba(74,222,128,.8);font-size:.8rem;font-weight:500;">{{ $userBookings->count() }} active {{ Str::plural('booking',$userBookings->count()) }}</span>
        </div>
      </div>
    </div>

    <!-- STAT CARDS -->
    <div class="stats-grid fu fu3">
      <div class="stat">
        <div class="stat-shine" style="background:var(--accent);"></div>
        <div class="stat-icon" style="background:linear-gradient(135deg,rgba(34,197,94,.12),rgba(34,197,94,.05));color:var(--accent3);">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="stat-num" style="color:var(--accent3);">{{ $totalDestinations }}</div>
        <div class="stat-label">Active Destinations</div>
      </div>

      <div class="stat">
        <div class="stat-shine" style="background:var(--sky);"></div>
        <div class="stat-icon" style="background:linear-gradient(135deg,rgba(103,232,249,.08),rgba(103,232,249,.03));color:var(--sky);">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
        <div class="stat-num" style="color:var(--sky);">{{ $totalGallery }}</div>
        <div class="stat-label">Gallery Photos</div>
      </div>

      <div class="stat">
        <div class="stat-shine" style="background:var(--amber);"></div>
        <div class="stat-icon" style="background:linear-gradient(135deg,rgba(252,211,77,.08),rgba(252,211,77,.03));color:var(--amber);">
          <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="stat-num" style="color:var(--amber);">{{ $userBookings->count() }}</div>
        <div class="stat-label">Total Bookings</div>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="fu fu3">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--accent);box-shadow:0 0 8px var(--accent);"></div>
          <span class="sec-title-text">Quick Actions</span>
          <div class="sec-line"></div>
        </div>
      </div>
      <div class="qa-grid">
        <a href="{{ route('user.destinations.index') }}" class="qa">
          <div class="qa-icon" style="background:linear-gradient(135deg,rgba(34,197,94,.1),rgba(34,197,94,.04));border:1px solid rgba(34,197,94,.15);">
            <svg width="26" height="26" fill="none" stroke="var(--accent3)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
          </div>
          <div style="flex:1;"><p style="font-weight:700;font-size:.95rem;color:var(--text);">Explore Destinations</p><p style="font-size:.75rem;color:var(--muted);margin-top:4px;">Discover new places worldwide</p></div>
          <svg width="16" height="16" fill="none" stroke="var(--dim)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ route('user.gallery.index') }}" class="qa">
          <div class="qa-icon" style="background:linear-gradient(135deg,rgba(103,232,249,.08),rgba(103,232,249,.03));border:1px solid rgba(103,232,249,.12);">
            <svg width="26" height="26" fill="none" stroke="var(--sky)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
          </div>
          <div style="flex:1;"><p style="font-weight:700;font-size:.95rem;color:var(--text);">Browse Gallery</p><p style="font-size:.75rem;color:var(--muted);margin-top:4px;">View stunning travel photos</p></div>
          <svg width="16" height="16" fill="none" stroke="var(--dim)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
        <a href="{{ route('bookings.user.index') }}" class="qa">
          <div class="qa-icon" style="background:linear-gradient(135deg,rgba(252,211,77,.08),rgba(252,211,77,.03));border:1px solid rgba(252,211,77,.12);">
            <svg width="26" height="26" fill="none" stroke="var(--amber)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          </div>
          <div style="flex:1;"><p style="font-weight:700;font-size:.95rem;color:var(--text);">My Bookings</p><p style="font-size:.75rem;color:var(--muted);margin-top:4px;">Manage your reservations</p></div>
          <svg width="16" height="16" fill="none" stroke="var(--dim)" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>

    <!-- AVAILABLE DESTINATIONS -->
    <div class="fu fu4">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--accent3);box-shadow:0 0 8px var(--accent3);"></div>
          <span class="sec-title-text">Available Destinations</span>
          <div class="sec-line"></div>
        </div>
        <a href="{{ route('user.destinations.index') }}" class="sec-link">
          View all <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <div class="tpanel">
        @if($availableDestinations->count() > 0)

        <div class="thead" style="grid-template-columns:2.2fr 1.8fr 1.1fr 1fr 80px;">
          <span class="th">Destination</span>
          <span class="th">Location</span>
          <span class="th">Price</span>
          <span class="th">Status</span>
          <span class="th" style="text-align:right;">Action</span>
        </div>

        @foreach($availableDestinations as $dest)
        <div class="trow" style="grid-template-columns:2.2fr 1.8fr 1.1fr 1fr 80px;">

          <div class="tcell" style="flex-direction:row;align-items:center;gap:14px;">
            <div class="thumb">
              @if($dest->image)
                <img src="{{ asset('storage/'.$dest->image) }}" alt="{{ $dest->name }}">
              @else
                <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
              @endif
            </div>
            <div class="tcell">
              <span class="tcell-label">Destination</span>
              <span class="tv tv-bold">{{ $dest->name }}</span>
            </div>
          </div>

          <div class="tcell">
            <span class="tcell-label">Location</span>
            <span class="tv" style="display:flex;align-items:center;gap:6px;color:var(--muted);">
              <svg width="12" height="12" fill="none" stroke="#F87171" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
              {{ $dest->location }}
            </span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Price</span>
            @if($dest->price)
              <span class="tv price">₱{{ number_format($dest->price,2) }}</span>
            @else
              <span class="tv tv-muted">—</span>
            @endif
          </div>

          <div class="tcell">
            <span class="tcell-label">Status</span>
            <span class="tv"><span class="badge b-green"><span class="badge-dot"></span>Active</span></span>
          </div>

          <div class="tcell" style="align-items:flex-end;">
            <span class="tcell-label">Action</span>
            <a href="{{ route('destinations.show', $dest) }}" class="vbtn">
              <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              View
            </a>
          </div>

        </div>
        @endforeach

        <div class="tfoot">
          <span class="tfoot-count">{{ $availableDestinations->count() }} destinations available</span>
          <a href="{{ route('user.destinations.index') }}" class="tfoot-link">All destinations <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></a>
        </div>

        @else
        <div class="empty">
          <div class="empty-icon"><svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
          <p style="font-weight:700;color:var(--text);font-size:.9rem;">No destinations available</p>
          <p style="font-size:.8rem;color:var(--muted);margin-top:6px;">Check back soon for new adventures.</p>
        </div>
        @endif
      </div>
    </div>

    <!-- MY BOOKINGS -->
    <div class="fu fu5">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--amber);box-shadow:0 0 8px var(--amber);"></div>
          <span class="sec-title-text">My Bookings</span>
          <div class="sec-line"></div>
        </div>
        <a href="{{ route('bookings.user.index') }}" class="sec-link" style="color:var(--amber);">
          View all <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <div class="tpanel">
        @if($userBookings->count() > 0)

        <div class="thead" style="grid-template-columns:1.2fr 1.8fr 1.3fr 0.7fr 1.2fr 1fr;">
          <span class="th">ID</span>
          <span class="th">Destination</span>
          <span class="th">Check-in</span>
          <span class="th">Guests</span>
          <span class="th">Total</span>
          <span class="th">Status</span>
        </div>

        @foreach($userBookings->take(5) as $booking)
        <div class="trow" style="grid-template-columns:1.2fr 1.8fr 1.3fr 0.7fr 1.2fr 1fr;">

          <div class="tcell">
            <span class="tcell-label">Booking ID</span>
            <span class="tv serif" style="font-size:.9rem;font-weight:700;">{{ $booking->booking_id ?? '#' . $booking->id }}</span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Destination</span>
            <span class="tv tv-bold">{{ $booking->destination->name ?? '—' }}</span>
            @if($booking->hotel)<span class="tv-sub">{{ $booking->hotel->name }}</span>@endif
          </div>

          <div class="tcell">
            <span class="tcell-label">Check-in</span>
            <span class="tv tv-muted">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') : '—' }}</span>
            @if($booking->check_out_date)<span class="tv-sub">to {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>@endif
          </div>

          <div class="tcell">
            <span class="tcell-label">Guests</span>
            <span class="tv tv-muted">{{ $booking->number_of_guests ?? 0 }} {{ Str::plural('guest', $booking->number_of_guests ?? 0) }}</span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Total</span>
            <span class="tv price">₱{{ number_format($booking->total_price ?? 0,2) }}</span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Status</span>
            <span class="tv">
              @if($booking->status=='pending')
                <span class="badge b-amber"><span class="badge-dot"></span>Pending</span>
              @elseif($booking->status=='confirmed')
                <span class="badge b-sky"><span class="badge-dot"></span>Confirmed</span>
              @elseif($booking->status=='cancelled')
                <span class="badge b-red">Cancelled</span>
              @elseif($booking->status=='completed')
                <span class="badge b-green">Completed</span>
              @else
                <span class="badge b-gray">{{ ucfirst($booking->status) }}</span>
              @endif
            </span>
          </div>

        </div>
        @endforeach

        <div class="tfoot">
          <span class="tfoot-count">Showing {{ min(5,$userBookings->count()) }} of {{ $userBookings->count() }} bookings</span>
          <a href="{{ route('bookings.user.index') }}" class="tfoot-link" style="color:var(--amber);">All bookings <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></a>
        </div>

        @else
        <div class="empty">
          <div class="empty-icon"><svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
          <p style="font-weight:700;color:var(--text);font-size:.9rem;">No bookings yet</p>
          <p style="font-size:.8rem;margin-top:6px;"><a href="{{ route('destinations.index') }}" style="color:var(--accent);font-weight:700;text-decoration:none;">Book your first destination →</a></p>
        </div>
        @endif
      </div>
    </div>

    <!-- GALLERY -->
    <div class="fu fu6">
      <div class="sec-head">
        <div class="sec-title">
          <div class="sec-title-dot" style="background:var(--sky);box-shadow:0 0 8px var(--sky);"></div>
          <span class="sec-title-text">Gallery</span>
          <div class="sec-line"></div>
        </div>
        <a href="{{ route('user.gallery.index') }}" class="sec-link" style="color:var(--sky);">
          View all <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>

      <div class="tpanel">
        @if($galleryItems->count() > 0)

        <div class="thead" style="grid-template-columns:48px 1.5fr 2fr 1.5fr 1.2fr 80px;">
          <span class="th">—</span>
          <span class="th">Title</span>
          <span class="th">Description</span>
          <span class="th">Uploaded By</span>
          <span class="th">Date</span>
          <span class="th" style="text-align:right;">Action</span>
        </div>

        @foreach($galleryItems as $gal)
        <div class="trow" style="grid-template-columns:48px 1.5fr 2fr 1.5fr 1.2fr 80px;">

          <div class="tcell">
            <div class="thumb" style="width:42px;height:42px;">
              @if($gal->image_path)
                <img src="{{ asset('storage/'.$gal->image_path) }}" alt="{{ $gal->title }}" style="width:100%;height:100%;object-fit:cover;">
              @else
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              @endif
            </div>
          </div>

          <div class="tcell">
            <span class="tcell-label">Title</span>
            <span class="tv tv-bold">{{ $gal->title }}</span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Description</span>
            <span class="tv tv-muted">{{ Str::limit($gal->description,65) ?? 'No description' }}</span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Uploaded By</span>
            <span class="tv" style="display:flex;align-items:center;gap:8px;">
              <div class="av">{{ substr($gal->user ? $gal->user->name : 'U',0,1) }}</div>
              <span style="color:var(--muted);">{{ $gal->user ? $gal->user->name : 'Unknown' }}</span>
            </span>
          </div>

          <div class="tcell">
            <span class="tcell-label">Date</span>
            <span class="tv tv-muted">{{ $gal->created_at->format('M d, Y') }}</span>
          </div>

          <div class="tcell" style="align-items:flex-end;">
            <span class="tcell-label">Action</span>
            <a href="{{ route('user.gallery.index') }}" class="vbtn" style="border-color:rgba(103,232,249,.2);color:var(--sky);">
              <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              View
            </a>
          </div>

        </div>
        @endforeach

        <div class="tfoot">
          <span class="tfoot-count">{{ $galleryItems->count() }} beautiful photos</span>
          <a href="{{ route('user.gallery.index') }}" class="tfoot-link" style="color:var(--sky);">All photos <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg></a>
        </div>

        @else
        <div class="empty">
          <div class="empty-icon"><svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
          <p style="font-weight:700;color:var(--text);font-size:.9rem;">Gallery is empty</p>
          <p style="font-size:.8rem;color:var(--muted);margin-top:6px;">No photos uploaded yet.</p>
        </div>
        @endif
      </div>
    </div>

    <!-- Footer -->
    <div style="padding-top:16px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;margin-top:8px;">
      <p style="font-size:.7rem;color:var(--dim);">Signed in as <span style="color:var(--accent);font-weight:700;">{{ Auth::user()->email }}</span></p>
      <p class="serif" style="font-size:.7rem;color:var(--dim);">USER Dashboard &copy; {{ date('Y') }}</p>
    </div>

  </div>
</div>

<script>
  // Smooth scroll behavior
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
</script>
</body>
</html>