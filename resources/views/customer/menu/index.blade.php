@extends('layouts.customer')

@section('title', 'Katalog Menu — Zero Nine Coffee Shop')

@section('content')

{{-- ═══════════════════════════════════════════
     MENU PAGE — Redesigned for breathing room
     - Looser grid gap
     - Compact image height
     - Cleaner card footer
     - More whitespace in sections
═══════════════════════════════════════════ --}}

<div class="min-h-screen" style="background:#FDF6EC; padding-top:6rem; padding-bottom:5rem;">
<div style="max-width:1200px; margin:0 auto; padding:0 2rem;">

    {{-- ─────────────────────────────────────
         PAGE HEADER
    ───────────────────────────────────── --}}
    <div style="text-align:center; padding:3rem 0 2.5rem;">

        {{-- Eyebrow --}}
        <div style="display:inline-flex; align-items:center; gap:0.75rem; margin-bottom:1.25rem;">
            <div style="width:36px; height:1px; background:linear-gradient(90deg,transparent,#C5A880);"></div>
            <span style="font-size:0.7rem; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:#C5A880;">
                Specialty Coffee & More
            </span>
            <div style="width:36px; height:1px; background:linear-gradient(90deg,#C5A880,transparent);"></div>
        </div>

        <h1 style="font-family:'Playfair Display',Georgia,serif; font-size:clamp(2.25rem,4vw,3.25rem); font-weight:700; color:#1B120D; line-height:1.15; margin-bottom:1rem;">
            Artisan <em style="color:#C5A880; font-style:italic;">Menu</em>
        </h1>

        <p style="font-size:1rem; line-height:1.75; color:#6F4E37; max-width:520px; margin:0 auto;">
            Setiap seduhan dibuat dengan bahan premium oleh barista ahli kami untuk menghadirkan rasa terbaik Nusantara.
        </p>
    </div>

    {{-- ─────────────────────────────────────
         FILTER BAR
    ───────────────────────────────────── --}}
    <div style="
        background:rgba(255,255,255,0.7);
        backdrop-filter:blur(16px);
        -webkit-backdrop-filter:blur(16px);
        border:1px solid rgba(197,168,128,0.25);
        border-radius:1rem;
        padding:1.25rem 1.5rem;
        margin-bottom:2.5rem;
        display:flex;
        flex-wrap:wrap;
        gap:1rem;
        align-items:center;
        justify-content:space-between;
    ">

        {{-- Category Pills --}}
        <div style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center;">
            <a href="{{ route('menu.index') }}"
               style="
                   display:inline-block;
                   padding:0.4rem 1rem;
                   border-radius:999px;
                   font-size:0.8125rem;
                   font-weight:600;
                   text-decoration:none;
                   transition:all 0.25s;
                   {{ !request('category')
                       ? 'background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; box-shadow:0 2px 8px rgba(197,168,128,0.3);'
                       : 'background:transparent; color:#6F4E37; border:1px solid rgba(197,168,128,0.3);' }}
               "
               @if(request('category')) onmouseover="this.style.background='rgba(197,168,128,0.12)'; this.style.color='#1B120D';" onmouseout="this.style.background='transparent'; this.style.color='#6F4E37';" @endif
            >
                Semua
            </a>

            @foreach($categories as $category)
            <a href="{{ route('menu.index', ['category' => $category->id] + request()->except('category')) }}"
               style="
                   display:inline-block;
                   padding:0.4rem 1rem;
                   border-radius:999px;
                   font-size:0.8125rem;
                   font-weight:600;
                   text-decoration:none;
                   transition:all 0.25s;
                   {{ request('category') == $category->id
                       ? 'background:linear-gradient(135deg,#C5A880,#9A7D3A); color:#1B120D; box-shadow:0 2px 8px rgba(197,168,128,0.3);'
                       : 'background:transparent; color:#6F4E37; border:1px solid rgba(197,168,128,0.3);' }}
               "
               @if(request('category') != $category->id) onmouseover="this.style.background='rgba(197,168,128,0.12)'; this.style.color='#1B120D';" onmouseout="this.style.background='transparent'; this.style.color='#6F4E37';" @endif
            >
                {{ $category->name }}
            </a>
            @endforeach
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('menu.index') }}" style="display:flex; gap:0.5rem; align-items:center;">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div style="position:relative;">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari menu..."
                    style="
                        background:rgba(255,255,255,0.9);
                        border:1px solid rgba(197,168,128,0.35);
                        border-radius:0.625rem;
                        color:#1B120D;
                        padding:0.5rem 2.5rem 0.5rem 0.875rem;
                        font-size:0.875rem;
                        width:220px;
                        outline:none;
                        transition:all 0.25s;
                        font-family:'Inter',sans-serif;
                    "
                    onfocus="this.style.borderColor='#C5A880'; this.style.boxShadow='0 0 0 3px rgba(197,168,128,0.15)';"
                    onblur="this.style.borderColor='rgba(197,168,128,0.35)'; this.style.boxShadow='none';"
                >
                <span style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); color:#A1887F; pointer-events:none;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
            </div>

            @if(request('search'))
            <a href="{{ route('menu.index', request()->except('search')) }}"
               style="
                   display:inline-flex; align-items:center; justify-content:center;
                   width:36px; height:36px;
                   background:rgba(197,168,128,0.1);
                   border:1px solid rgba(197,168,128,0.25);
                   border-radius:0.5rem;
                   color:#8D6E63;
                   text-decoration:none;
                   font-size:0.875rem;
                   transition:all 0.25s;
               "
               title="Bersihkan pencarian"
               onmouseover="this.style.background='rgba(197,168,128,0.2)'; this.style.color='#1B120D';"
               onmouseout="this.style.background='rgba(197,168,128,0.1)'; this.style.color='#8D6E63';"
            >✕</a>
            @endif
        </form>
    </div>

    {{-- ─────────────────────────────────────
         RESULT COUNT (jika ada filter aktif)
    ───────────────────────────────────── --}}
    @if(request('search') || request('category'))
    <div style="margin-bottom:1.5rem; display:flex; align-items:center; gap:0.5rem;">
        <span style="font-size:0.875rem; color:#8D6E63;">
            Menampilkan
            <strong style="color:#3E2C1C;">{{ $menus->total() }}</strong>
            hasil
            @if(request('search'))
                untuk <em style="color:#C5A880;">"{{ request('search') }}"</em>
            @endif
        </span>
    </div>
    @endif

    {{-- ─────────────────────────────────────
         MENU GRID
    ───────────────────────────────────── --}}
    @if($menus->isEmpty())

        {{-- Empty State --}}
        <div style="
            text-align:center;
            padding:5rem 2rem;
            background:rgba(255,255,255,0.6);
            border:1px solid rgba(197,168,128,0.2);
            border-radius:1.25rem;
        ">
            <div style="font-size:3.5rem; margin-bottom:1.25rem; opacity:0.6;">☕</div>
            <h3 style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:#1B120D; margin-bottom:0.625rem;">
                Menu tidak ditemukan
            </h3>
            <p style="font-size:0.9375rem; color:#6F4E37; margin-bottom:1.75rem;">
                Coba kata kunci atau kategori yang berbeda.
            </p>
            <a href="{{ route('menu.index') }}"
               style="
                   display:inline-flex; align-items:center; gap:0.5rem;
                   background:linear-gradient(135deg,#C5A880,#9A7D3A);
                   color:#1B120D; font-weight:700; font-size:0.9rem;
                   padding:0.75rem 1.5rem; border-radius:0.625rem;
                   text-decoration:none; transition:all 0.3s;
               "
               onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(197,168,128,0.3)';"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
            >
                Tampilkan Semua Menu
            </a>
        </div>

    @else

        {{-- ── Card Grid: 3 kolom, gap longgar ── --}}
        <div class="menu-grid" style="
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap:2rem;
            margin-bottom:3rem;
        ">
            @foreach($menus as $menu)
            <article style="
                background:#FFFFFF;
                border:1px solid rgba(197,168,128,0.22);
                border-radius:1.125rem;
                overflow:hidden;
                transition:all 0.35s cubic-bezier(0.4,0,0.2,1);
                display:flex;
                flex-direction:column;
            "
            onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='rgba(197,168,128,0.45)'; this.style.boxShadow='0 16px 40px rgba(139,99,64,0.1)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='rgba(197,168,128,0.22)'; this.style.boxShadow='none';"
            >

                {{-- ── Image ── --}}
                <div style="position:relative; height:200px; overflow:hidden; background:linear-gradient(135deg,#3E2723,#1B120D); flex-shrink:0;">
                    @if($menu->image)
                        <img
                            src="{{ $menu->image_url }}"
                            alt="{{ $menu->name }}"
                            style="width:100%; height:100%; object-fit:cover; transition:transform 0.5s ease;"
                            onmouseover="this.style.transform='scale(1.06)';"
                            onmouseout="this.style.transform='scale(1)';"
                        >
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; opacity:0.2; font-size:4rem;">☕</div>
                    @endif

                    {{-- Gradient overlay at bottom --}}
                    <div style="position:absolute; bottom:0; left:0; right:0; height:60px; background:linear-gradient(transparent, rgba(27,18,13,0.25)); pointer-events:none;"></div>

                    {{-- Badges --}}
                    @if($menu->is_best_seller || $menu->is_new || $menu->stock <= 0)
                    <div style="position:absolute; top:0.75rem; left:0.75rem; display:flex; flex-wrap:wrap; gap:0.375rem;">
                        @if($menu->is_best_seller)
                            <span style="
                                background:linear-gradient(135deg,#C5A880,#9A7D3A);
                                color:#1B120D;
                                font-size:0.65rem; font-weight:700;
                                padding:0.25rem 0.625rem;
                                border-radius:999px;
                                letter-spacing:0.04em;
                            ">⭐ Best Seller</span>
                        @endif
                        @if($menu->is_new)
                            <span style="
                                background:rgba(21,128,61,0.85);
                                color:#FFFFFF;
                                font-size:0.65rem; font-weight:700;
                                padding:0.25rem 0.625rem;
                                border-radius:999px;
                                letter-spacing:0.04em;
                                backdrop-filter:blur(4px);
                            ">✨ Baru</span>
                        @endif
                        @if($menu->stock <= 0)
                            <span style="
                                background:rgba(185,28,28,0.85);
                                color:#FFFFFF;
                                font-size:0.65rem; font-weight:700;
                                padding:0.25rem 0.625rem;
                                border-radius:999px;
                                backdrop-filter:blur(4px);
                            ">Habis</span>
                        @endif
                    </div>
                    @endif
                </div>

                {{-- ── Body ── --}}
                <div style="padding:1.25rem 1.375rem 0.875rem; flex:1; display:flex; flex-direction:column;">

                    {{-- Category label + Price --}}
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:0.75rem; margin-bottom:0.625rem;">
                        <span style="
                            font-size:0.65rem; font-weight:700;
                            letter-spacing:0.12em; text-transform:uppercase;
                            color:#A1887F;
                        ">{{ $menu->category->name }}</span>
                        <span style="
                            font-size:1.0625rem; font-weight:700;
                            color:#8B6340;
                            white-space:nowrap;
                            flex-shrink:0;
                        ">{{ $menu->formatted_price }}</span>
                    </div>

                    {{-- Name --}}
                    <h3 style="
                        font-family:'Playfair Display',Georgia,serif;
                        font-size:1.0625rem; font-weight:700;
                        color:#1B120D; line-height:1.3;
                        margin-bottom:0.625rem;
                        transition:color 0.2s;
                    ">{{ $menu->name }}</h3>

                    {{-- Description --}}
                    <p style="
                        font-size:0.8375rem; line-height:1.65;
                        color:#6F4E37;
                        display:-webkit-box;
                        -webkit-line-clamp:2;
                        -webkit-box-orient:vertical;
                        overflow:hidden;
                        flex:1;
                        margin-bottom:1rem;
                    ">{{ $menu->description }}</p>

                </div>

                {{-- ── Footer ── --}}
                <div style="
                    padding:0.875rem 1.375rem 1.125rem;
                    border-top:1px solid rgba(197,168,128,0.15);
                    display:flex;
                    align-items:center;
                    justify-content:space-between;
                ">
                    {{-- Prep time --}}
                    <span style="display:flex; align-items:center; gap:0.375rem; font-size:0.8rem; color:#A1887F;">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $menu->preparation_time }} menit
                    </span>

                    {{-- CTA --}}
                    <a href="{{ route('menu.show', $menu->slug) }}"
                       style="
                           display:inline-flex; align-items:center; gap:0.3rem;
                           background:rgba(197,168,128,0.1);
                           border:1px solid rgba(197,168,128,0.3);
                           color:#8B6340;
                           font-size:0.8rem; font-weight:600;
                           padding:0.45rem 0.875rem;
                           border-radius:0.5rem;
                           text-decoration:none;
                           transition:all 0.25s;
                       "
                       onmouseover="this.style.background='rgba(197,168,128,0.2)'; this.style.borderColor='#C5A880'; this.style.color='#3E2C1C';"
                       onmouseout="this.style.background='rgba(197,168,128,0.1)'; this.style.borderColor='rgba(197,168,128,0.3)'; this.style.color='#8B6340';"
                    >
                        Lihat Detail
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </article>
            @endforeach
        </div>

        {{-- ── Pagination ── --}}
        <div style="
            display:flex;
            justify-content:center;
            padding-top:0.5rem;
        ">
            {{ $menus->links() }}
        </div>

    @endif

</div>
</div>

{{-- Responsive grid --}}
<style>
@media (max-width: 1024px) {
    .menu-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
@media (max-width: 640px) {
    .menu-grid { grid-template-columns: 1fr !important; }
}
</style>

@endsection