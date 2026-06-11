@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-[#FFFFFF] border border-[#C5A880]/50 text-[#1B120D] placeholder-[#8D6E63] focus:border-[#9A7D3A] focus:ring-1 focus:ring-[#9A7D3A] rounded-xl shadow-sm transition-all px-4 py-3 text-base']) }}>
