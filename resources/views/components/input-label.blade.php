@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-[#3E2C1C] uppercase tracking-wider mb-2']) }}>
    {{ $value ?? $slot }}
</label>
