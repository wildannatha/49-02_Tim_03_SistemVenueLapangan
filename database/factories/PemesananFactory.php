<?php

namespace Database\Factories;

use App\Models\Pemesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pemesanan>
 */
class PemesananFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'tanggal' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'jam' => fake()->time('H:i'),
            'raket' => fake()->numberBetween(0, 3),
            'sepatu' => fake()->numberBetween(0, 3),
            'bola' => fake()->numberBetween(0, 3),
        ];
    }
}
