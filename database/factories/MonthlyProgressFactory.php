<?php

namespace Database\Factories;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MonthlyProgress>
 */
class MonthlyProgressFactory extends Factory
{
    protected $model = \App\Models\MonthlyProgress::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "kecamatan_id" => Kecamatan::factory(),
            "month" => $this->faker->monthName(),
            "year" => $this->faker->year(),

            "target_kbpp" => $this->faker->numberBetween(50, 600),
            "capaian_kbpp" => $this->faker->numberBetween(0, 500),
            "capaian_kbpp_percent" => $this->faker->randomFloat(2, 0, 100),

            "target_mkjp" => $this->faker->numberBetween(10, 200),
            "capaian_mkjp" => $this->faker->numberBetween(0, 200),
            "capaian_mkjp_percent" => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
