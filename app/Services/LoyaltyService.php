<?php

namespace App\Services;

use App\Models\LoyaltyTransaction;
use App\Models\MembershipTier;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LoyaltyService
{
    /**
     * Award points to a user after a completed order.
     */
    public function awardPoints(User $user, int $points, Order $order, string $description): void
    {
        DB::transaction(function () use ($user, $points, $order, $description) {
            $newBalance = $user->loyalty_points + $points;

            $user->increment('loyalty_points', $points);

            LoyaltyTransaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'type' => 'earned',
                'points' => $points,
                'balance_after' => $newBalance,
                'description' => $description,
            ]);

            // Auto-upgrade membership tier
            $this->checkAndUpgradeTier($user->fresh());
        });
    }

    /**
     * Redeem loyalty points during checkout (100 pts = Rp 10.000).
     */
    public function redeemPoints(User $user, int $points): float
    {
        abort_if($user->loyalty_points < $points, 422, 'Poin tidak mencukupi.');
        abort_if($points <= 0, 422, 'Jumlah poin tidak valid.');
        abort_if($points % 100 !== 0, 422, 'Poin harus kelipatan 100.');

        $discountValue = ($points / 100) * 10000; // 100 pts = Rp 10.000
        $newBalance = $user->loyalty_points - $points;

        $user->decrement('loyalty_points', $points);

        LoyaltyTransaction::create([
            'user_id' => $user->id,
            'type' => 'redeemed',
            'points' => -$points,
            'balance_after' => $newBalance,
            'description' => "Penukaran {$points} poin",
        ]);

        return $discountValue;
    }

    /**
     * Evaluate and upgrade user membership tier based on accumulated points.
     */
    public function checkAndUpgradeTier(User $user): void
    {
        $newTier = MembershipTier::where('is_active', true)
            ->where('min_points', '<=', $user->loyalty_points)
            ->orderByDesc('min_points')
            ->first();

        if ($newTier && $user->membership_tier_id !== $newTier->id) {
            $user->update(['membership_tier_id' => $newTier->id]);
        }
    }

    /**
     * Get user loyalty summary.
     */
    public function getSummary(User $user): array
    {
        $tier = $user->membershipTier;
        $nextTier = MembershipTier::where('is_active', true)
            ->where('min_points', '>', $user->loyalty_points)
            ->orderBy('min_points')
            ->first();

        return [
            'points' => $user->loyalty_points,
            'tier' => $tier,
            'next_tier' => $nextTier,
            'points_to_next' => $nextTier ? $nextTier->min_points - $user->loyalty_points : 0,
            'redeem_value' => floor($user->loyalty_points / 100) * 10000,
            'history' => $user->loyaltyTransactions()->latest()->take(10)->get(),
        ];
    }
}
