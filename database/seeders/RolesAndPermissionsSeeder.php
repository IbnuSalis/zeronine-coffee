<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── Permissions ────────────────────────────────────────────────────
        $permissions = [
            // Menu
            'menu.view', 'menu.create', 'menu.update', 'menu.delete',
            // Category
            'category.view', 'category.create', 'category.update', 'category.delete',
            // Order
            'order.view', 'order.update-status', 'order.cancel', 'order.view-all',
            // Payment
            'payment.verify', 'payment.refund',
            // Booking
            'booking.view', 'booking.manage',
            // Review
            'review.approve', 'review.delete',
            // User
            'user.view', 'user.create', 'user.update', 'user.delete',
            // Role & Permission
            'role.manage',
            // Promo
            'promo.view', 'promo.create', 'promo.update', 'promo.delete',
            // Table
            'table.view', 'table.create', 'table.update', 'table.delete',
            // Inventory
            'inventory.view', 'inventory.create', 'inventory.update', 'inventory.delete',
            // Analytics
            'analytics.view', 'analytics.export',
            // Kitchen
            'kitchen.view', 'kitchen.update-status',
            // Cashier
            'cashier.verify', 'cashier.print-receipt',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ─── Roles ──────────────────────────────────────────────────────────

        // Admin
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions([
            'menu.view', 'menu.create', 'menu.update', 'menu.delete',
            'category.view', 'category.create', 'category.update', 'category.delete',
            'order.view', 'order.update-status', 'order.cancel', 'order.view-all',
            'payment.verify',
            'booking.view', 'booking.manage',
            'review.approve', 'review.delete',
            'user.view', 'user.create', 'user.update', 'user.delete',
            'role.manage',
            'promo.view', 'promo.create', 'promo.update', 'promo.delete',
            'table.view', 'table.create', 'table.update', 'table.delete',
            'inventory.view', 'inventory.create', 'inventory.update', 'inventory.delete',
            'analytics.view', 'analytics.export',
        ]);

        // Cashier
        $cashier = Role::firstOrCreate(['name' => 'cashier', 'guard_name' => 'web']);
        $cashier->syncPermissions([
            'order.view', 'order.view-all', 'order.update-status',
            'payment.verify',
            'cashier.verify', 'cashier.print-receipt',
        ]);

        // Customer (default role for all registered users)
        $customer = Role::firstOrCreate(['name' => 'customer', 'guard_name' => 'web']);
        $customer->syncPermissions([
            'order.view',
            'booking.view',
        ]);

        $this->command->info('✅ Roles and permissions seeded successfully.');
    }
}
