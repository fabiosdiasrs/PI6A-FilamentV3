<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DadosAdicionais>
 */
class DadosAdicionaisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'escola'=> 'Ginásio do Areal',
            'pessoa_id'=> fake()->numberBetween(1,27),
            'aluno_id' => fake()->numberBetween(1,27),
            'direito_imagem' => fake()->boolean(),
        ];
    }
}
