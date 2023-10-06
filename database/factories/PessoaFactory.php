<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pessoa>
 */
class PessoaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'=> fake()->name(),
            'dt_nascimento'=> fake()->date(),
            'estado_civil'=> 'solteiro',
            'cpf'=> fake()->numerify('###.###.###-##'),
            'rg'=> fake()->numerify('##########'),
            'nis'=> fake()->numerify('###.#####.##-#'),
            'email'=> fake()->email(),
            'telefone'=> fake()->phoneNumber(),
            'sexo'=> 'f',
            'rua'=> fake('pt_BR')->streetName(),
            'cep'=> fake()->numerify('#####-###'),
            'Bairro' => 'Areal',
            'numero'=> fake()->randomNumber(1,9),
            'pais_id'=>1,
            'estado_id'=>fake()->numberBetween(1,27),
            'cidade_id'=>fake()->numberBetween(1,30),
        ];
    }
}
