<?php

namespace Database\Factories;
use App\Models\WhyChooseUs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhyChooseUs>
 */
class WhyChooseUsFactory extends Factory
{

         // Ajoute cette ligne pour lier la factory au modèle
    protected $model = WhyChooseUs::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'icon' => 'fa-solid fa-paperclip',
            'title' => fake()->sentence(),
            'short_description' => fake()->sentence(),
            'status' => fake()->boolean()
        ];
    }
}
