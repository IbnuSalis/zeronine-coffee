<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    /**
     * Get or create a cart for the authenticated user.
     */
    public function getOrCreate(User $user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Add item to cart or increment quantity if already exists.
     */
    public function addItem(User $user, int $menuId, int $quantity = 1, ?string $notes = null, array $customizations = []): CartItem
    {
        $menu = Menu::findOrFail($menuId);

        abort_if(! $menu->is_available, 422, 'Menu ini sedang tidak tersedia.');
        abort_if($menu->stock < $quantity, 422, 'Stok tidak mencukupi.');

        $cart = $this->getOrCreate($user);

        $cartItem = $cart->items()->where('menu_id', $menuId)->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $quantity;
            abort_if($menu->stock < $newQty, 422, 'Stok tidak mencukupi.');
            $cartItem->update(['quantity' => $newQty, 'notes' => $notes ?? $cartItem->notes]);
        } else {
            $cartItem = $cart->items()->create([
                'menu_id' => $menuId,
                'quantity' => $quantity,
                'notes' => $notes,
                'customizations' => $customizations,
            ]);
        }

        return $cartItem->load('menu');
    }

    /**
     * Update cart item quantity.
     */
    public function updateItem(User $user, int $cartItemId, int $quantity): CartItem
    {
        $cart = $this->getOrCreate($user);
        $cartItem = $cart->items()->with('menu')->findOrFail($cartItemId);

        if ($quantity <= 0) {
            $this->removeItem($user, $cartItemId);
            return $cartItem;
        }

        abort_if($cartItem->menu->stock < $quantity, 422, 'Stok tidak mencukupi.');
        $cartItem->update(['quantity' => $quantity]);

        return $cartItem;
    }

    /**
     * Remove a single item from cart.
     */
    public function removeItem(User $user, int $cartItemId): void
    {
        $cart = $this->getOrCreate($user);
        $cart->items()->where('id', $cartItemId)->delete();
    }

    /**
     * Clear all items from cart.
     */
    public function clear(User $user): void
    {
        $cart = $this->getOrCreate($user);
        $cart->items()->delete();
        $cart->update(['promo_id' => null, 'table_id' => null]);
    }

    /**
     * Apply a promo code to the cart.
     * Returns the promo and calculated discount.
     */
    public function applyPromo(User $user, string $code): array
    {
        $promo = Promo::where('code', strtoupper($code))->active()->firstOrFail();
        $cart = $this->getOrCreate($user);
        $subtotal = $cart->subtotal;

        abort_if($subtotal < $promo->min_spend, 422,
            'Minimum belanja Rp ' . number_format($promo->min_spend, 0, ',', '.') . ' untuk menggunakan promo ini.');

        abort_if($user->hasUsedPromo($promo), 422, 'Kamu sudah menggunakan promo ini.');

        $discount = $promo->calculateDiscount($subtotal);
        $cart->update(['promo_id' => $promo->id]);

        return [
            'promo' => $promo,
            'discount' => $discount,
            'subtotal' => $subtotal,
            'final' => $subtotal - $discount,
        ];
    }

    /**
     * Remove promo from cart.
     */
    public function removePromo(User $user): void
    {
        $this->getOrCreate($user)->update(['promo_id' => null]);
    }

    /**
     * Set table for dine-in orders.
     */
    public function setTable(User $user, ?int $tableId): void
    {
        $this->getOrCreate($user)->update(['table_id' => $tableId]);
    }

    /**
     * Get cart summary with pricing breakdown.
     */
    public function getSummary(User $user): array
    {
        $cart = $this->getOrCreate($user)->load(['items.menu', 'promo', 'table']);
        $subtotal = $cart->subtotal;
        $discount = $cart->promo ? $cart->promo->calculateDiscount($subtotal) : 0;
        $taxRate = 0.10; // 10% PPN
        $serviceRate = 0.05; // 5% service charge
        $afterDiscount = $subtotal - $discount;
        $tax = round($afterDiscount * $taxRate, 2);
        $service = round($afterDiscount * $serviceRate, 2);
        $total = $afterDiscount + $tax + $service;

        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'service' => $service,
            'total' => $total,
            'item_count' => $cart->item_count,
        ];
    }
}
