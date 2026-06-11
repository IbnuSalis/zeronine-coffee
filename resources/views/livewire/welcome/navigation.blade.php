{{-- ════════════════════════════════════════════════════════
     ZERO NINE — Dark Navigation Bar
     Background : #1B120D (deep espresso)
     Text        : #FDF6EC (cream) / #BCAAA4 (muted)
     Accent      : #C5A880 (gold)
════════════════════════════════════════════════════════ --}}

<nav
    x-data="{ open: false }"
    style="
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(27, 18, 13, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(197, 168, 128, 0.1);
        box-shadow: 0 1px 12px rgba(0,0,0,0.15);
    "
>
    <div style="max-width:1280px; margin:0 auto; padding:0 1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; height:72px;">

            {{-- ── Logo ── --}}
            <a href="{{ route('dashboard') }}" style="display:flex; align-items:center; gap:0.875rem; text-decoration:none; flex-shrink:0;">
                <div style="
                    width:40px; height:40px;
                    background:linear-gradient(135deg,#C5A880,#9A7D3A);
                    border-radius:10px;
                    display:flex; align-items:center; justify-content:center;
                ">
                    <span style="font-family:'Playfair Display',serif; font-weight:700; font-size:0.9375rem; color:#1B120D;">09</span>
                </div>
                <div>
                    <div style="font-family:'Playfair Display',serif; font-weight:700; font-size:1.0625rem; color:#FFF8F0; line-height:1.15;">Zero Nine</div>
                    <div style="font-size:0.65rem; color:#6F4E37; letter-spacing:0.12em; text-transform:uppercase;">Coffee Shop</div>
                </div>
            </a>

            {{-- ── Desktop Nav Links ── --}}
            <div style="display:flex; align-items:center; gap:0.25rem;" class="hidden sm:flex">

                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    style="
                        color:{{ request()->routeIs('dashboard') ? '#C5A880' : '#BCAAA4' }};
                        font-size:0.875rem;
                        font-weight:500;
                        padding:0.5rem 0.875rem;
                        border-radius:0.5rem;
                        text-decoration:none;
                        transition:all 0.25s;
                        background:{{ request()->routeIs('dashboard') ? 'rgba(197,168,128,0.12)' : 'transparent' }};
                    "
                    onmouseover="if(!{{ request()->routeIs('dashboard') ? 'true' : 'false' }}) { this.style.color='#FFF8F0'; this.style.background='rgba(197,168,128,0.08)'; }"
                    onmouseout="if(!{{ request()->routeIs('dashboard') ? 'true' : 'false' }}) { this.style.color='#BCAAA4'; this.style.background='transparent'; }"
                >
                    {{ __('Dashboard') }}
                </x-nav-link>

            </div>

            {{-- ── Right: User Dropdown ── --}}
            <div style="display:flex; align-items:center; gap:0.75rem;">

                {{-- Desktop dropdown --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button style="
                                display:inline-flex; align-items:center; gap:0.625rem;
                                background:rgba(197,168,128,0.08);
                                border:1px solid rgba(197,168,128,0.2);
                                border-radius:0.625rem;
                                padding:0.5rem 0.875rem;
                                color:#BCAAA4;
                                font-size:0.875rem;
                                font-weight:500;
                                cursor:pointer;
                                transition:all 0.25s;
                            "
                            onmouseover="this.style.background='rgba(197,168,128,0.15)'; this.style.color='#FFF8F0'; this.style.borderColor='rgba(197,168,128,0.35)';"
                            onmouseout="this.style.background='rgba(197,168,128,0.08)'; this.style.color='#BCAAA4'; this.style.borderColor='rgba(197,168,128,0.2)';"
                            >
                                {{-- Avatar circle --}}
                                <div style="
                                    width:28px; height:28px;
                                    background:linear-gradient(135deg,#C5A880,#9A7D3A);
                                    border-radius:50%;
                                    display:flex; align-items:center; justify-content:center;
                                    flex-shrink:0;
                                ">
                                    <span style="font-size:0.75rem; font-weight:700; color:#1B120D;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>

                                <span>{{ Auth::user()->name }}</span>

                                <svg style="width:14px; height:14px; transition:transform 0.25s;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Dropdown styled: dark bg --}}
                            <div style="
                                background:#2C1A0E;
                                border:1px solid rgba(197,168,128,0.15);
                                border-radius:0.75rem;
                                overflow:hidden;
                                box-shadow:0 12px 32px rgba(0,0,0,0.3);
                                padding:0.375rem;
                                min-width:200px;
                            ">
                                {{-- Profile info header --}}
                                <div style="padding:0.875rem 1rem; border-bottom:1px solid rgba(197,168,128,0.1); margin-bottom:0.375rem;">
                                    <div style="font-size:0.8125rem; font-weight:600; color:#FFF8F0; margin-bottom:0.125rem;">{{ Auth::user()->name }}</div>
                                    <div style="font-size:0.75rem; color:#6F4E37; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ Auth::user()->email }}</div>
                                </div>

                                <x-dropdown-link :href="route('profile.edit')"
                                    style="
                                        display:flex; align-items:center; gap:0.625rem;
                                        padding:0.625rem 0.875rem;
                                        border-radius:0.5rem;
                                        color:#BCAAA4;
                                        font-size:0.875rem;
                                        text-decoration:none;
                                        transition:all 0.2s;
                                    "
                                    onmouseover="this.style.background='rgba(197,168,128,0.12)'; this.style.color='#FDF6EC';"
                                    onmouseout="this.style.background='transparent'; this.style.color='#BCAAA4';"
                                >
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ __('Profil Saya') }}
                                </x-dropdown-link>

                                <div style="height:1px; background:rgba(197,168,128,0.08); margin:0.375rem 0;"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        style="
                                            display:flex; align-items:center; gap:0.625rem;
                                            padding:0.625rem 0.875rem;
                                            border-radius:0.5rem;
                                            color:#F87171;
                                            font-size:0.875rem;
                                            text-decoration:none;
                                            transition:all 0.2s;
                                        "
                                        onmouseover="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#FCA5A5';"
                                        onmouseout="this.style.background='transparent'; this.style.color='#F87171';"
                                    >
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        {{ __('Keluar') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>

                {{-- ── Mobile Hamburger ── --}}
                <div class="flex items-center sm:hidden">
                    <button @click="open = ! open"
                        style="
                            background:rgba(197,168,128,0.08);
                            border:1px solid rgba(197,168,128,0.2);
                            border-radius:0.5rem;
                            padding:0.5rem;
                            color:#BCAAA4;
                            cursor:pointer;
                            transition:all 0.25s;
                        "
                        onmouseover="this.style.background='rgba(197,168,128,0.15)'; this.style.color='#FFF8F0';"
                        onmouseout="this.style.background='rgba(197,168,128,0.08)'; this.style.color='#BCAAA4';"
                    >
                        <svg x-show="!open" style="width:20px; height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="open" style="width:20px; height:20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Mobile Menu Panel ── --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        style="
            background:#1B120D;
            border-top:1px solid rgba(197,168,128,0.1);
            padding:1rem 1.5rem 1.5rem;
        "
        class="sm:hidden"
    >
        {{-- Navigation --}}
        <div style="margin-bottom:1rem;">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                style="
                    display:block;
                    padding:0.75rem 1rem;
                    border-radius:0.5rem;
                    color:{{ request()->routeIs('dashboard') ? '#C5A880' : '#BCAAA4' }};
                    background:{{ request()->routeIs('dashboard') ? 'rgba(197,168,128,0.12)' : 'transparent' }};
                    font-size:0.9375rem;
                    font-weight:500;
                    text-decoration:none;
                    transition:all 0.2s;
                "
            >
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div style="height:1px; background:rgba(197,168,128,0.1); margin-bottom:1rem;"></div>

        {{-- User info --}}
        <div style="padding:0.75rem 1rem; margin-bottom:0.75rem;">
            <div style="font-size:0.9rem; font-weight:600; color:#FFF8F0;">{{ Auth::user()->name }}</div>
            <div style="font-size:0.8rem; color:#6F4E37; margin-top:0.125rem;">{{ Auth::user()->email }}</div>
        </div>

        <x-responsive-nav-link :href="route('profile.edit')"
            style="
                display:flex; align-items:center; gap:0.625rem;
                padding:0.75rem 1rem; border-radius:0.5rem;
                color:#BCAAA4; font-size:0.875rem; text-decoration:none;
                transition:all 0.2s;
            "
        >
            {{ __('Profil Saya') }}
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();"
                style="
                    display:flex; align-items:center; gap:0.625rem;
                    padding:0.75rem 1rem; border-radius:0.5rem;
                    color:#F87171; font-size:0.875rem; text-decoration:none;
                    transition:all 0.2s; margin-top:0.25rem;
                "
            >
                {{ __('Keluar') }}
            </x-responsive-nav-link>
        </form>
    </div>
</nav>