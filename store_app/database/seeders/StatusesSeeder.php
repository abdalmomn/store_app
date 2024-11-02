<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::query()->create([
            'status' => 'pending'
        ]);
        Status::query()->create([
            'status' => 'shipping'
        ]);
        Status::query()->create([
            'status' => 'delivered'
        ]);
        Status::query()->create([
            'status' => 'accepted'
        ]);
        Status::query()->create([
            'status' => 'rejected'
        ]);
        Status::query()->create([
            'status' => 'preparing'
        ]);
        Status::query()->create([
            'status' => 'canceled'
        ]);
    }
}
