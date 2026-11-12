<?php

namespace Database\Factories;

use App\Models\Objeto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Objeto>
 */
class ObjetoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => fake()->words(2, true),
            'categoria' => fake()->randomElement([
                'Material escolar',
                'Eletrônicos',
                'Roupas e acessórios',
                'Garrafas e lancheiras',
                'Documentos',
                'Outros',
            ]),
            'local' => fake()->streetName(),
            'turno' => fake()->randomElement(['Matutino', 'Vespertino', 'Noturno']),
            'descricao' => fake()->sentence(),
            'foto' => null,
            'status' => 'disponível',
        ];
    }
}
