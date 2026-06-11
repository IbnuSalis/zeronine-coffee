<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\BookingController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\LoyaltyController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\PaymentController;

// ── Public Landing Page ────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');

// ── Google OAuth ───────────────────────────────────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/google', [GoogleController::class, 'redirect'])->name('google');
    Route::get('/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// ── Midtrans Payment Webhook (no auth, verified by Midtrans signature) ─────
Route::post('/payment/notification', [PaymentController::class, 'notification'])
    ->name('payment.notification')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// ── Tripay Payment Callback (no auth, verified by X-Callback-Signature header) ─
Route::post('/payment/tripay/callback', [PaymentController::class, 'tripayCallback'])
    ->name('payment.tripay.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// ── QR Table Ordering ──────────────────────────────────────────────────────
Route::get('/table/{number}/order', [CartController::class, 'fromQr'])->name('table.qr-order');

// ── All Customer Routes — auth only, NO email verification required ────────
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsActive::class])
    ->group(function () {

        // Cart
        Route::prefix('cart')->name('customer.cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::patch('/items/{item}', [CartController::class, 'update'])->name('update');
            Route::delete('/items/{item}', [CartController::class, 'remove'])->name('remove');
            Route::post('/promo', [CartController::class, 'applyPromo'])->name('apply-promo');
            Route::delete('/promo', [CartController::class, 'removePromo'])->name('remove-promo');
        });

        // Checkout & Payment
        Route::prefix('checkout')->name('customer.checkout.')->group(function () {
            Route::get('/', [CheckoutController::class, 'index'])->name('index');
            Route::post('/', [CheckoutController::class, 'store'])->name('store');
            Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
        });

        // Orders
        Route::prefix('orders')->name('customer.orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
            Route::post('/{order}/review', [OrderController::class, 'review'])->name('review');
            Route::post('/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('confirm-payment');
        });

        // Bookings
        Route::prefix('bookings')->name('customer.bookings.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::get('/create', [BookingController::class, 'create'])->name('create');
            Route::post('/', [BookingController::class, 'store'])->name('store');
            Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
            Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        });

        // Profile
        Route::prefix('profile')->name('customer.profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'index'])->name('index');
            Route::patch('/', [ProfileController::class, 'update'])->name('update');
            Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('password');
        });

        // Loyalty
        Route::get('/loyalty', [LoyaltyController::class, 'index'])->name('customer.loyalty');

        // Notifications
        Route::post('/notifications/{id}/read', function (string $id) {
            $notif = auth()->user()->notifications()->findOrFail($id);
            $notif->markAsRead();
            return back();
        })->name('notifications.read');

        Route::post('/notifications/read-all', function () {
            auth()->user()->unreadNotifications->markAsRead();
            return back();
        })->name('notifications.read-all');
    });

// ── Admin Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin', \App\Http\Middleware\EnsureUserIsActive::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('menus', AdminMenuController::class);
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('promos', AdminPromoController::class);
        Route::resource('tables', AdminTableController::class);
        Route::resource('inventory', AdminInventoryController::class);
        Route::resource('users', AdminUserController::class);
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::patch('bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::resource('roles', RoleController::class);
    });

// ── Cashier Routes ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:cashier|admin', \App\Http\Middleware\EnsureUserIsActive::class])
    ->prefix('cashier')
    ->name('cashier.')
    ->group(function () {
        Route::get('/', [CashierController::class, 'index'])->name('index');
        Route::patch('/orders/{order}/status', [CashierController::class, 'updateStatus'])->name('update-status');
        Route::patch('/orders/{order}/verify', [CashierController::class, 'verifyPayment'])->name('verify');
        Route::get('/orders/{order}/receipt', [CashierController::class, 'receipt'])->name('receipt');
    });

// ── Smart Role-based Redirection for standard Dashboard ───────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasAnyRole(['admin'])) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->hasRole('cashier')) {
        return redirect()->route('cashier.index');
    }
    return redirect()->route('home');
})->middleware(['auth', \App\Http\Middleware\EnsureUserIsActive::class])->name('dashboard');

// ── Profile Route Alias ───────────────────────────────────────────────────
Route::get('/profile-redirect', function () {
    return redirect()->route('customer.profile.index');
})->middleware(['auth'])->name('profile');

require __DIR__ . '/auth.php';