<?php

namespace Database\Factories;

use App\Models\Barcode;
use App\Models\Trashtype;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barcode>
 */
class BarcodeFactory extends Factory
{

    protected $model = Barcode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(100, 1000000), // Falls Auto-Increment deaktiviert ist
            'title' => $this->faker->text(50),
            'notes' => $this->faker->paragraph(),
        ];
    }
}
