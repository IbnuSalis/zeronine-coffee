<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zero Nine Coffee Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Hero Background ── */
        .hero-bg {
            background-color: #FDF6EC;
            background-image:
                radial-gradient(ellipse 80% 60% at 70% 50%, rgba(197,168,128,0.2) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 20% 80%, rgba(139,99,64,0.1) 0%, transparent 50%);
        }

        /* ── Coffee ring decorative element ── */
        .coffee-ring {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(197,168,128,0.12);
        }

        /* ── Grain texture overlay ── */
        .grain::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.4;
        }

        /* ── Nav link hover underline ── */
        .nav-link {
            position: relative;
            color: #BCAAA4;
            font-size: 0.9375rem;
            font-weight: 400;
            letter-spacing: 0.01em;
            transition: color 0.25s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #C5A880;
            transition: width 0.3s;
        }
        .nav-link:hover { color: #FFF8F0; }
        .nav-link:hover::after { width: 100%; }

        /* ── Horizontal divider line ── */
        .divider-line {
            width: 48px;
            height: 1px;
            background: linear-gradient(90deg, #C5A880, transparent);
        }

        /* ── Feature card ── */
        .feature-card {
            background: rgba(255,255,255,0.6);
            border: 1px solid rgba(197,168,128,0.3);
            border-radius: 1rem;
            padding: 2rem;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .feature-card:hover {
            background: rgba(255,255,255,0.9);
            border-color: rgba(197,168,128,0.5);
            transform: translateY(-4px);
        }

        /* ── Menu preview card ── */
        .menu-preview {
            background: rgba(253,246,236,0.9);
            border: 1px solid rgba(197,168,128,0.25);
            border-radius: 1rem;
            overflow: hidden;
            transition: all 0.35s;
        }
        .menu-preview:hover {
            border-color: rgba(197,168,128,0.5);
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.1);
        }

        /* ── Stat number ── */
        .stat-number {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #C5A880;
            line-height: 1;
        }

        /* ── Scroll indicator ── */
        @keyframes scrollBounce {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(6px); opacity: 0.5; }
        }
        .scroll-indicator { animation: scrollBounce 1.8s ease-in-out infinite; }

        /* ── Testimonial card ── */
        .testimonial-card {
            background: rgba(255,255,255,0.7);
            border: 1px solid rgba(197,168,128,0.3);
            border-radius: 1rem;
            padding: 1.75rem;
        }

        /* ── CTA Section ── */
        .cta-section {
            background: rgba(253,246,236,0.95);
            border: 1px solid rgba(197,168,128,0.3);
            border-radius: 1.5rem;
        }

        /* ── Footer ── */
        .footer-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(197,168,128,0.2), transparent);
        }

        /* ── Fade in on scroll (pure CSS fallback) ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s ease-out forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body class="antialiased grain" style="background:#FDF6EC; color:#1B120D; font-family:'Inter',system-ui,sans-serif; overflow-x:hidden;">

{{-- ═══════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════ --}}
<nav style="position:fixed; top:0; left:0; right:0; z-index:50; backdrop-filter:blur(20px); -webkit-backdrop-filter:blur(20px); background:rgba(27,18,13,0.85); border-bottom:1px solid rgba(197,168,128,0.08);">
    <div style="max-width:1280px; margin:0 auto; padding:0 2rem; display:flex; align-items:center; justify-content:space-between; height:72px;">

        {{-- Logo --}}
        <a href="/" style="display:flex; align-items:center; gap:0.875rem; text-decoration:none;">
            <div style="width:42px; height:42px; background:linear-gradient(135deg,#C5A880,#9A7D3A); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <span style="font-family:'Playfair Display',serif; font-weight:700; font-size:1rem; color:#1B120D;">09</span>
            </div>
            <div>
                <div style="font-family:'Playfair Display',serif; font-weight:700; font-size:1.125rem; color:#FFF8F0; line-height:1.1;">Zero Nine</div>
                <div style="font-size:0.7rem; color:#8D6E63; letter-spacing:0.12em; text-transform:uppercase;">Coffee Shop</div>
            </div>
        </a>

        {{-- Nav Links --}}
        <div style="display:flex; align-items:center; gap:2.5rem;" class="hidden-mobile">
            <a href="#menu" class="nav-link">Menu</a>
            <a href="#about" class="nav-link">Tentang Kami</a>
            <a href="#reservasi" class="nav-link">Reservasi</a>
        </div>

        {{-- Auth Buttons --}}
        <div style="display:flex; align-items:center; gap:0.75rem;">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary" style="padding:0.5rem 1.25rem; font-size:0.875rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" style="color:#BCAAA4; font-size:0.9rem; font-weight:500; text-decoration:none; padding:0.5rem 1rem; border-radius:0.5rem; transition:color 0.25s;" onmouseover="this.style.color='#FFF8F0'" onmouseout="this.style.color='#BCAAA4'">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; font-size:0.875rem; font-weight:700; padding:0.5rem 1.25rem; border-radius:0.625rem; text-decoration:none; transition:all 0.3s; display:inline-block;" onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-1px)'" onmouseout="this.style.opacity='1'; this.style.transform='translateY(0)'">Daftar</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

{{-- ═══════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════ --}}
<section class="hero-bg" style="min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center; position:relative; padding:8rem 2rem 4rem; overflow:hidden;">

    {{-- Decorative rings --}}
    <div class="coffee-ring" style="width:600px; height:600px; right:-200px; top:-100px; opacity:0.5;"></div>
    <div class="coffee-ring" style="width:300px; height:300px; left:-80px; bottom:10%; opacity:0.3;"></div>
    <div class="coffee-ring" style="width:900px; height:900px; right:-350px; top:-250px; opacity:0.2;"></div>

    {{-- Content --}}
    <div style="max-width:1280px; width:100%; margin:0 auto; display:grid; grid-template-columns:1fr 1fr; align-items:center; gap:4rem; position:relative; z-index:1;">

        {{-- Left: Text --}}
        <div>
            {{-- Eyebrow --}}
            <div class="fade-up" style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1.75rem;">
                <div class="divider-line"></div>
                <span style="font-size:0.75rem; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#C5A880;">Specialty Coffee · Est. 2019</span>
            </div>

            {{-- Headline --}}
            <h1 class="fade-up delay-1" style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(3rem,5.5vw,5rem); font-weight:700; line-height:1.08; color:#1B120D; margin-bottom:1.5rem;">
                Di Setiap<br>
                <em style="color:#C5A880; font-style:italic;">Tegukan</em><br>
                Ada Cerita
            </h1>

            {{-- Body --}}
            <p class="fade-up delay-2" style="font-size:1.0625rem; line-height:1.75; color:#3E2C1C; max-width:480px; margin-bottom:2.5rem;">
                Dari biji Arabika pilihan petani Gayo dan Toraja, kami sajikan pengalaman kopi premium yang menceritakan keindahan Nusantara dalam setiap cangkir.
            </p>

            {{-- CTAs --}}
            <div class="fade-up delay-3" style="display:flex; gap:1rem; flex-wrap:wrap; margin-bottom:3rem;">
                <a href="{{ route('menu.index') ?? '#menu' }}" style="background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; font-weight:700; font-size:0.9375rem; padding:0.875rem 1.75rem; border-radius:0.625rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s; letter-spacing:0.02em;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(197,168,128,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Lihat Menu
                </a>
                <a href="#reservasi" style="background:rgba(255,255,255,0.1); color:#ffffff; border:1.5px solid rgba(255,255,255,0.6); font-weight:600; font-size:0.9375rem; padding:0.875rem 1.75rem; border-radius:0.625rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.18)'; this.style.borderColor='#ffffff'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.6)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Reservasi Meja
                </a>
            </div>

            {{-- Stats --}}
            <div class="fade-up delay-4" style="display:flex; gap:2.5rem;">
                <div>
                    <div class="stat-number">2.500+</div>
                    <div style="font-size:0.8125rem; color:#8D6E63; margin-top:0.25rem; letter-spacing:0.04em;">Pelanggan Setia</div>
                </div>
                <div style="width:1px; background:rgba(197,168,128,0.15);"></div>
                <div>
                    <div class="stat-number">14</div>
                    <div style="font-size:0.8125rem; color:#8D6E63; margin-top:0.25rem; letter-spacing:0.04em;">Menu Premium</div>
                </div>
                <div style="width:1px; background:rgba(197,168,128,0.15);"></div>
                <div>
                    <div class="stat-number">4.9★</div>
                    <div style="font-size:0.8125rem; color:#8D6E63; margin-top:0.25rem; letter-spacing:0.04em;">Rating Pelanggan</div>
                </div>
            </div>
        </div>

        {{-- Right: Visual --}}
        <div style="position:relative; display:flex; justify-content:center; align-items:center;">
            {{-- Large coffee cup SVG illustration --}}
            <div style="position:relative; width:420px; height:420px;">
                {{-- Glow behind --}}
                <div style="position:absolute; inset:0; background:radial-gradient(circle at 50% 60%, rgba(197,168,128,0.15) 0%, transparent 65%); border-radius:50%;"></div>
                {{-- Cup visual --}}
                <svg viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%; height:100%;">
                    {{-- Saucer --}}
                    <ellipse cx="200" cy="310" rx="140" ry="22" fill="rgba(197,168,128,0.12)" stroke="rgba(197,168,128,0.2)" stroke-width="1"/>
                    <ellipse cx="200" cy="310" rx="100" ry="14" fill="rgba(197,168,128,0.08)"/>

                    {{-- Cup body --}}
                    <path d="M110 180 Q105 290 150 302 Q200 314 250 302 Q295 290 290 180 Z" fill="rgba(62,39,35,0.9)" stroke="rgba(197,168,128,0.25)" stroke-width="1.5"/>

                    {{-- Cup highlight --}}
                    <path d="M130 185 Q128 240 148 270" stroke="rgba(197,168,128,0.15)" stroke-width="8" stroke-linecap="round"/>

                    {{-- Coffee surface --}}
                    <ellipse cx="200" cy="180" rx="90" ry="18" fill="#3E2723" stroke="rgba(197,168,128,0.2)" stroke-width="1"/>

                    {{-- Coffee swirl --}}
                    <path d="M180 178 Q190 172 200 178 Q210 184 220 178" stroke="rgba(197,168,128,0.4)" stroke-width="2" stroke-linecap="round" fill="none"/>
                    <path d="M175 182 Q187 176 200 182 Q213 188 225 182" stroke="rgba(197,168,128,0.25)" stroke-width="1.5" stroke-linecap="round" fill="none"/>

                    {{-- Handle --}}
                    <path d="M290 200 Q330 200 330 230 Q330 265 290 265" stroke="rgba(197,168,128,0.3)" stroke-width="12" fill="none" stroke-linecap="round"/>
                    <path d="M290 200 Q320 200 320 230 Q320 258 290 258" stroke="rgba(62,39,35,0.8)" stroke-width="6" fill="none" stroke-linecap="round"/>

                    {{-- Steam --}}
                    <path d="M175 160 Q178 140 175 120 Q172 100 175 80" stroke="rgba(197,168,128,0.25)" stroke-width="2.5" fill="none" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="translate" values="0,0;3,-5;0,0" dur="3s" repeatCount="indefinite"/>
                    </path>
                    <path d="M200 155 Q204 133 200 110 Q196 88 200 65" stroke="rgba(197,168,128,0.2)" stroke-width="2" fill="none" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="translate" values="0,0;-3,-6;0,0" dur="3.5s" repeatCount="indefinite"/>
                    </path>
                    <path d="M225 160 Q228 140 225 118 Q222 97 226 78" stroke="rgba(197,168,128,0.15)" stroke-width="2" fill="none" stroke-linecap="round">
                        <animateTransform attributeName="transform" type="translate" values="0,0;4,-4;0,0" dur="2.8s" repeatCount="indefinite"/>
                    </path>

                    {{-- Decorative beans --}}
                    <ellipse cx="80" cy="120" rx="14" ry="9" fill="rgba(111,78,55,0.4)" transform="rotate(-20 80 120)"/>
                    <path d="M80 113 Q80 129" stroke="rgba(197,168,128,0.2)" stroke-width="1" fill="none"/>

                    <ellipse cx="330" cy="150" rx="12" ry="8" fill="rgba(111,78,55,0.35)" transform="rotate(15 330 150)"/>

                    <ellipse cx="320" cy="100" rx="10" ry="6.5" fill="rgba(111,78,55,0.3)" transform="rotate(-10 320 100)"/>
                    <ellipse cx="70" cy="200" rx="11" ry="7" fill="rgba(111,78,55,0.25)" transform="rotate(25 70 200)"/>
                </svg>

                {{-- Floating badge --}}
                <div style="position:absolute; top:10%; right:0; background:rgba(46,28,18,0.9); border:1px solid rgba(197,168,128,0.2); border-radius:0.875rem; padding:0.875rem 1.25rem; backdrop-filter:blur(12px);">
                    <div style="font-size:0.7rem; color:#8D6E63; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:0.25rem;">Single Origin</div>
                    <div style="font-family:'Playfair Display',serif; font-size:0.9375rem; color:#C5A880; font-weight:600;">Arabika Gayo</div>
                </div>

                <div style="position:absolute; bottom:18%; left:-5%; background:rgba(46,28,18,0.9); border:1px solid rgba(197,168,128,0.15); border-radius:0.875rem; padding:0.75rem 1rem; backdrop-filter:blur(12px);">
                    <div style="display:flex; align-items:center; gap:0.5rem;">
                        <div style="width:8px; height:8px; background:#22C55E; border-radius:50%; animation:pulse 1.5s infinite;"></div>
                        <span style="font-size:0.8125rem; color:#86EFAC; font-weight:600; letter-spacing:0.04em;">Buka Sekarang</span>
                    </div>
                    <div style="font-size:0.75rem; color:#6F4E37; margin-top:0.2rem;">08.00 – 22.00 WIB</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div style="position:absolute; bottom:2.5rem; left:50%; transform:translateX(-50%); display:flex; flex-direction:column; align-items:center; gap:0.5rem;">
        <span style="font-size:0.6875rem; letter-spacing:0.15em; text-transform:uppercase; color:#6F4E37;">Scroll</span>
        <div class="scroll-indicator" style="color:#C5A880;">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     WHY ZERO NINE
═══════════════════════════════════════════ --}}
<section id="about" style="padding:6rem 2rem; background:#FDF6EC;">
    <div style="max-width:1280px; margin:0 auto;">

        {{-- Section header --}}
        <div style="text-align:center; margin-bottom:4rem;">
            <div style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div style="width:32px; height:1px; background:linear-gradient(90deg,transparent,#C5A880);"></div>
                <span style="font-size:0.75rem; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#C5A880;">Mengapa Zero Nine</span>
                <div style="width:32px; height:1px; background:linear-gradient(90deg,#C5A880,transparent);"></div>
            </div>
            <h2 style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(2rem,3.5vw,2.75rem); font-weight:700; color:#1B120D; line-height:1.2;">
                Kopi Bukan Sekadar Minuman,<br>
                <em style="color:#C5A880;">Ini adalah Ritual</em>
            </h2>
        </div>

        {{-- Feature grid --}}
        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem;">

            <div class="feature-card">
                <div style="width:52px; height:52px; background:rgba(197,168,128,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; border:1px solid rgba(197,168,128,0.15);">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#C5A880" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:600; color:#1B120D; margin-bottom:0.75rem;">Biji Pilihan Petani</h3>
                <p style="font-size:0.9rem; line-height:1.7; color:#6F4E37;">Kami bermitra langsung dengan petani Arabika terbaik dari Gayo dan Toraja, memastikan kesegaran dan kualitas di setiap biji yang kami gunakan.</p>
            </div>

            <div class="feature-card">
                <div style="width:52px; height:52px; background:rgba(197,168,128,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; border:1px solid rgba(197,168,128,0.15);">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#C5A880" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:600; color:#1B120D; margin-bottom:0.75rem;">Pemesanan Real-Time</h3>
                <p style="font-size:0.9rem; line-height:1.7; color:#6F4E37;">Pesan langsung dari meja dengan scan QR Code. Pantau status pesanan Anda secara langsung tanpa perlu bertanya ke kasir.</p>
            </div>

            <div class="feature-card">
                <div style="width:52px; height:52px; background:rgba(197,168,128,0.1); border-radius:12px; display:flex; align-items:center; justify-content:center; margin-bottom:1.5rem; border:1px solid rgba(197,168,128,0.15);">
                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#C5A880" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                </div>
                <h3 style="font-family:'Playfair Display',serif; font-size:1.25rem; font-weight:600; color:#1B120D; margin-bottom:0.75rem;">Program Loyalitas</h3>
                <p style="font-size:0.9rem; line-height:1.7; color:#6F4E37;">Kumpulkan poin di setiap transaksi. Tukar dengan diskon eksklusif atau minuman gratis. Semakin sering, semakin besar reward-mu.</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     MENU PREVIEW
═══════════════════════════════════════════ --}}
<section id="menu" style="padding:6rem 2rem; background:linear-gradient(180deg, #FDF6EC 0%, #F5ECD7 50%, #FDF6EC 100%);">
    <div style="max-width:1280px; margin:0 auto;">

        <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:3rem;">
            <div>
                <div style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                    <div style="width:32px; height:1px; background:linear-gradient(90deg,transparent,#C5A880);"></div>
                    <span style="font-size:0.75rem; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#C5A880;">Menu Kami</span>
                </div>
                <h2 style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(2rem,3.5vw,2.75rem); font-weight:700; color:#1B120D; line-height:1.2;">Menu <em style="color:#C5A880;">Unggulan</em></h2>
            </div>
            <a href="#" style="color:#C5A880; font-size:0.875rem; font-weight:500; text-decoration:none; display:flex; align-items:center; gap:0.4rem; border-bottom:1px solid rgba(197,168,128,0.3); padding-bottom:2px;">
                Lihat semua menu
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Menu cards grid --}}
        <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1.25rem;">

            @php
            $menus = [
                ['name'=>'Signature Gayo Latte','category'=>'Signature','price'=>'38.000','tag'=>'Best Seller','emoji'=>'☕'],
                ['name'=>'Cold Brew Toraja','category'=>'Cold Brew','price'=>'35.000','tag'=>'New','emoji'=>'🧋'],
                ['name'=>'Caramel Macchiato','category'=>'Espresso','price'=>'42.000','tag'=>null,'emoji'=>'☕'],
                ['name'=>'Matcha Latte','category'=>'Non Coffee','price'=>'38.000','tag'=>null,'emoji'=>'🍵'],
            ];
            @endphp

            @foreach($menus as $menu)
            <div class="menu-preview">
                {{-- Image placeholder --}}
                <div style="height:180px; background:linear-gradient(135deg, rgba(62,39,35,0.8), rgba(27,18,13,0.9)); display:flex; align-items:center; justify-content:center; position:relative;">
                    <span style="font-size:4rem;">{{ $menu['emoji'] }}</span>
                    @if($menu['tag'])
                    <span style="position:absolute; top:0.75rem; left:0.75rem; background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; font-size:0.7rem; font-weight:700; padding:0.25rem 0.625rem; border-radius:999px; letter-spacing:0.05em;">{{ $menu['tag'] }}</span>
                    @endif
                </div>
                {{-- Info --}}
                <div style="padding:1.25rem;">
                    <div style="font-size:0.7rem; color:#6F4E37; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:0.375rem;">{{ $menu['category'] }}</div>
                    <div style="font-family:'Playfair Display',serif; font-size:1.0625rem; font-weight:600; color:#1B120D; margin-bottom:0.75rem; line-height:1.3;">{{ $menu['name'] }}</div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#C5A880; font-weight:600; font-size:0.9375rem;">Rp {{ $menu['price'] }}</span>
                        <button style="width:34px; height:34px; background:rgba(197,168,128,0.1); border:1px solid rgba(197,168,128,0.2); border-radius:8px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.25s; color:#C5A880;" onmouseover="this.style.background='rgba(197,168,128,0.2)'" onmouseout="this.style.background='rgba(197,168,128,0.1)'">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     TESTIMONIALS
═══════════════════════════════════════════ --}}
<section style="padding:6rem 2rem; background:#FDF6EC;">
    <div style="max-width:1280px; margin:0 auto;">

        <div style="text-align:center; margin-bottom:3.5rem;">
            <div style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div style="width:32px; height:1px; background:linear-gradient(90deg,transparent,#C5A880);"></div>
                <span style="font-size:0.75rem; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#C5A880;">Ulasan Pelanggan</span>
                <div style="width:32px; height:1px; background:linear-gradient(90deg,#C5A880,transparent);"></div>
            </div>
            <h2 style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(1.75rem,3vw,2.5rem); font-weight:700; color:#1B120D;">Kata Mereka</h2>
        </div>

        <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem;">

            @php
            $reviews = [
                ['name'=>'Anisa R.','tier'=>'Gold Member','text'=>'Kopinya benar-benar beda. Gayo Latte-nya smooth banget, nggak pahit tapi juga nggak terlalu manis. Suasananya bikin betah berlama-lama.','rating'=>5,'initial'=>'A'],
                ['name'=>'Ibnu T.','tier'=>'Platinum Member','text'=>'Fitur scan QR Code-nya sangat memudahkan. Pesan dari meja, bayar lewat aplikasi, pesanan langsung datang. Pengalaman yang sangat modern!','rating'=>5,'initial'=>'I'],
                ['name'=>'Septiana D.','tier'=>'Silver Member','text'=>'Cold Brew Toraja-nya juara! Poin loyaltasnya juga cepat terkumpul. Sudah beberapa kali tukar poin dengan minuman gratis.','rating'=>5,'initial'=>'S'],
            ];
            @endphp

            @foreach($reviews as $r)
            <div class="testimonial-card">
                {{-- Stars --}}
                <div style="display:flex; gap:0.25rem; margin-bottom:1rem;">
                    @for($i=0;$i<5;$i++)
                    <svg width="16" height="16" fill="#C5A880" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    @endfor
                </div>
                <p style="font-size:0.9375rem; line-height:1.75; color:#3E2C1C; margin-bottom:1.25rem; font-style:italic;">"{{ $r['text'] }}"</p>
                <div style="display:flex; align-items:center; gap:0.75rem;">
                    <div style="width:40px; height:40px; background:linear-gradient(135deg,#C5A880,#9A7D3A); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <span style="font-weight:700; font-size:0.9375rem; color:#1B120D;">{{ $r['initial'] }}</span>
                    </div>
                    <div>
                        <div style="font-weight:600; font-size:0.9375rem; color:#1B120D;">{{ $r['name'] }}</div>
                        <div style="font-size:0.75rem; color:#C5A880;">{{ $r['tier'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     CTA / RESERVASI
═══════════════════════════════════════════ --}}
<section id="reservasi" style="padding:6rem 2rem; background:#FDF6EC;">
    <div style="max-width:1280px; margin:0 auto;">
        <div class="cta-section" style="padding:4rem; text-align:center; position:relative; overflow:hidden;">
            {{-- Background decoration --}}
            <div style="position:absolute; top:-60px; right:-60px; width:240px; height:240px; border-radius:50%; border:1px solid rgba(197,168,128,0.2);"></div>
            <div style="position:absolute; bottom:-40px; left:-40px; width:160px; height:160px; border-radius:50%; border:1px solid rgba(197,168,128,0.15);"></div>

            <div style="position:relative; z-index:1;">
                <div style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1.25rem;">
                    <div style="width:32px; height:1px; background:linear-gradient(90deg,transparent,#C5A880);"></div>
                    <span style="font-size:0.75rem; font-weight:600; letter-spacing:0.15em; text-transform:uppercase; color:#C5A880;">Kunjungi Kami</span>
                    <div style="width:32px; height:1px; background:linear-gradient(90deg,#C5A880,transparent);"></div>
                </div>
                <h2 style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(2rem,3.5vw,3rem); font-weight:700; color:#1B120D; line-height:1.2; margin-bottom:1rem;">
                    Reservasi Meja Sekarang,<br>
                    <em style="color:#C5A880;">Nikmati Pengalaman Terbaik</em>
                </h2>
                <p style="font-size:1rem; color:#6F4E37; margin-bottom:2.5rem; max-width:480px; margin-left:auto; margin-right:auto; line-height:1.7;">
                    Pastikan meja favoritmu tersedia. Booking online, konfirmasi instan, langsung menikmati kopi terbaik bersama orang-orang tersayang.
                </p>
                <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
                    @auth
                    <a href="{{ url('/reservasi') }}" style="background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; font-weight:700; font-size:1rem; padding:0.9rem 2rem; border-radius:0.625rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(197,168,128,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Reservasi Sekarang
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @else
                    <a href="{{ route('login') }}" style="background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; font-weight:700; font-size:1rem; padding:0.9rem 2rem; border-radius:0.625rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.5rem; transition:all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(197,168,128,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Masuk untuk Reservasi
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    @endauth
                    <a href="#menu" style="background:transparent; color:#C5A880; border:1px solid rgba(197,168,128,0.4); font-weight:600; font-size:1rem; padding:0.9rem 2rem; border-radius:0.625rem; text-decoration:none; transition:all 0.3s;" onmouseover="this.style.background='rgba(197,168,128,0.1)'" onmouseout="this.style.background='transparent'">
                        Lihat Menu Dulu
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ --}}
<footer style="background:#1B120D; padding:3rem 2rem 2rem; border-top:1px solid rgba(197,168,128,0.08);">
    <div style="max-width:1280px; margin:0 auto;">
        <div style="display:grid; grid-template-columns:2fr 1fr 1fr 1fr; gap:3rem; margin-bottom:3rem;">

            {{-- Brand --}}
            <div>
                <div style="display:flex; align-items:center; gap:0.875rem; margin-bottom:1.25rem;">
                    <div style="width:40px; height:40px; background:linear-gradient(135deg,#C5A880,#9A7D3A); border-radius:9px; display:flex; align-items:center; justify-content:center;">
                        <span style="font-family:'Playfair Display',serif; font-weight:700; font-size:0.9375rem; color:#1B120D;">09</span>
                    </div>
                    <div>
                        <div style="font-family:'Playfair Display',serif; font-weight:700; color:#FFF8F0; font-size:1.0625rem;">Zero Nine</div>
                        <div style="font-size:0.65rem; color:#6F4E37; letter-spacing:0.1em; text-transform:uppercase;">Coffee Shop</div>
                    </div>
                </div>
                <p style="font-size:0.875rem; color:#6F4E37; line-height:1.7; max-width:260px;">Menyajikan kopi specialty Nusantara dengan standar barista profesional sejak 2019.</p>
                <div style="display:flex; gap:0.75rem; margin-top:1.25rem;">
                    @foreach(['instagram','twitter','facebook'] as $s)
                    <a href="#" style="width:36px; height:36px; background:rgba(197,168,128,0.08); border:1px solid rgba(197,168,128,0.12); border-radius:8px; display:flex; align-items:center; justify-content:center; transition:all 0.25s; color:#8D6E63; text-decoration:none;" onmouseover="this.style.background='rgba(197,168,128,0.15)'; this.style.color='#C5A880'" onmouseout="this.style.background='rgba(197,168,128,0.08)'; this.style.color='#8D6E63'">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 style="font-size:0.8125rem; font-weight:600; color:#C5A880; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1.25rem;">Menu</h4>
                @foreach(['Signature Drinks','Non Coffee','Makanan','Snacks'] as $item)
                <a href="#" style="display:block; font-size:0.875rem; color:#6F4E37; text-decoration:none; margin-bottom:0.625rem; transition:color 0.25s;" onmouseover="this.style.color='#BCAAA4'" onmouseout="this.style.color='#6F4E37'">{{ $item }}</a>
                @endforeach
            </div>

            <div>
                <h4 style="font-size:0.8125rem; font-weight:600; color:#C5A880; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1.25rem;">Layanan</h4>
                @foreach(['Dine In','Take Away','Reservasi Meja','Pre-Order'] as $item)
                <a href="#" style="display:block; font-size:0.875rem; color:#6F4E37; text-decoration:none; margin-bottom:0.625rem; transition:color 0.25s;" onmouseover="this.style.color='#BCAAA4'" onmouseout="this.style.color='#6F4E37'">{{ $item }}</a>
                @endforeach
            </div>

            <div>
                <h4 style="font-size:0.8125rem; font-weight:600; color:#C5A880; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:1.25rem;">Kunjungi</h4>
                <p style="font-size:0.875rem; color:#6F4E37; line-height:1.7; margin-bottom:0.75rem;">Jl. Kopi Nusantara No. 09<br>Surabaya, Jawa Timur</p>
                <p style="font-size:0.875rem; color:#6F4E37;">Senin – Minggu<br>08.00 – 22.00 WIB</p>
            </div>
        </div>

        <div class="footer-divider" style="margin-bottom:1.5rem;"></div>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <p style="font-size:0.8125rem; color:#4E342E;">© 2026 Zero Nine Coffee Shop. All rights reserved.</p>
            <p style="font-size:0.75rem; color:#4E342E;">Dibuat dengan ☕ oleh Kelompok 6</p>
        </div>
    </div>
</footer>

{{-- Mobile nav hide --}}
<style>
@media(max-width:768px){
    .hidden-mobile { display:none !important; }
    section > div { grid-template-columns: 1fr !important; }
    .feature-card { grid-template-columns: 1fr !important; }
}
</style>

</body>
</html>