import './bootstrap';

// ── Alpine.js Setup via Livewire ───────────────────────────
document.addEventListener('livewire:init', () => {
    const Alpine = window.Alpine;

    // Cart badge reactive store
    Alpine.store('cart', {
        count: parseInt(document.querySelector('[data-cart-count]')?.textContent ?? '0'),
        update(count) {
            this.count = count;
        },
    });

    // Toast notification store
    Alpine.store('toasts', {
        items: [],
        add(message, type = 'success') {
            const id = Date.now();
            this.items.push({ id, message, type });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            this.items = this.items.filter(t => t.id !== id);
        },
    });
});

// ── Global AJAX helper ────────────────────────────────────
window.apiPost = async (url, data = {}) => {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return response.json();
};

window.apiPatch = async (url, data = {}) => {
    const response = await fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data),
    });
    return response.json();
};

window.apiDelete = async (url) => {
    const response = await fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            'Accept': 'application/json',
        },
    });
    return response.json();
};
