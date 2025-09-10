<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Kabupaten::factory()
            ->count(12)
            ->has(
                \App\Models\Kecamatan::factory()
                    ->count(15)
                    ->has(\App\Models\MonthlyProgress::factory()->count(12)),
            )
            ->create();
    }
}
