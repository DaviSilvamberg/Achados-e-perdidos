<?php

namespace Tests\Feature;

use App\Models\Objeto;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_homepage_shows_object_statistics(): void
    {
        Objeto::factory()->create(['status' => 'disponível']);
        Objeto::factory()->create(['status' => 'devolvido']);

        $this->get('/')
            ->assertOk()
            ->assertSee('Objetos cadastrados')
            ->assertSee('2', false)
            ->assertSee('Objetos devolvidos')
            ->assertSee('Objetos disponíveis');
    }
}
