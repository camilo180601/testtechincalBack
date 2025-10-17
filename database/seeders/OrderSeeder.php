<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) return;

        $today = Carbon::today();

        $orders = [
            ['client_name' => 'ACME', 'description' => 'Tarjetas promocionales', 'status' => 'pending', 'delivery_date' => $today->copy()->addDays(3)],
            ['client_name' => 'Globex', 'description' => 'Calendarios 2026', 'status' => 'in_progress', 'delivery_date' => $today->copy()->addDays(7)],
            ['client_name' => 'Initech', 'description' => 'Folletos corporativos', 'status' => 'pending', 'delivery_date' => $today->copy()->addDays(5)],
            ['client_name' => 'Stark', 'description' => 'Posters A1', 'status' => 'completed', 'delivery_date' => $today->copy()->addDays(-2)], // past to test
            ['client_name' => 'Wayne', 'description' => 'Tarjetas VIP', 'status' => 'pending', 'delivery_date' => $today->copy()->addDays(10)],
        ];

        foreach ($orders as $o) {
            Order::create(array_merge($o, ['user_id' => $admin->id, 'delivery_date' => $o['delivery_date']->format('Y-m-d')]));
        }
    }
}
