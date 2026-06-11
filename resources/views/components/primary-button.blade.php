<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-gold-500 to-gold-600 border border-transparent rounded-lg font-bold text-xs text-coffee-950 uppercase tracking-widest hover:from-gold-600 hover:to-gold-700 focus:outline-none focus:ring-2 focus:ring-gold-500 shadow-lg shadow-gold-500/10 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
