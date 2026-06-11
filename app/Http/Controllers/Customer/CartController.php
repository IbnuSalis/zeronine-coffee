<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    public function index()
    {
        $summary = $this->cartService->getSummary(auth()->user());
        return view('customer.cart.index', compact('summary'));
    }

    public function add(AddToCartRequest $request)
    {
        $cartItem = $this->cartService->addItem(
            auth()->user(),
            $request->menu_id,
            $request->quantity ?? 1,
            $request->notes,
            $request->customizations ?? []
        );

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Menu berhasil ditambahkan ke keranjang!',
                'cart_count' => auth()->user()->cart?->item_count ?? 0,
            ]);
        }

        return back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, int $item)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:99']);

        $this->cartService->updateItem(auth()->user(), $item, $request->quantity);

        return response()->json(['message' => 'Keranjang diperbarui.']);
    }

    public function remove(int $item)
    {
        $this->cartService->removeItem(auth()->user(), $item);
        return response()->json(['message' => 'Item dihapus dari keranjang.']);
    }

    public function applyPromo(Request $request)
    {
        $request->validate(['code' => 'required|string|max:50']);

        $result = $this->cartService->applyPromo(auth()->user(), $request->code);

        return response()->json([
            'message' => 'Promo berhasil diterapkan! Kamu hemat Rp ' . number_format($result['discount'], 0, ',', '.'),
            'discount' => $result['discount'],
            'final' => $result['final'],
        ]);
    }

    public function removePromo()
    {
        $this->cartService->removePromo(auth()->user());
        return response()->json(['message' => 'Promo dihapus.']);
    }

    /**
     * Handle QR code table scan — set table and redirect to cart.
     */
    public function fromQr(string $number)
    {
        if (! auth()->check()) {
            session(['qr_table' => $number]);
            return redirect()->route('login')->with('info', 'Login terlebih dahulu untuk melanjutkan pesanan dari meja ' . $number);
        }

        $table = \App\Models\Table::where('number', $number)->where('is_active', true)->firstOrFail();
        $this->cartService->setTable(auth()->user(), $table->id);

        return redirect()->route('menu.index')
            ->with('success', "Kamu memesan dari Meja {$table->number} — {$table->name}");
    }
}
