<?php

namespace Tests\Feature;

use App\Models\Objeto;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ObjetoAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_can_view_objects_but_cannot_open_admin_forms(): void
    {
        $objeto = Objeto::factory()->create(['titulo' => 'Mochila azul']);

        $this->get(route('objetos.index'))
            ->assertOk()
            ->assertSee('Mochila azul')
            ->assertDontSee('Novo cadastro')
            ->assertDontSee('Editar');

        $this->get(route('objetos.create'))
            ->assertRedirect(route('login'));

        $this->assertModelExists($objeto);
    }

    public function test_authenticated_non_admin_cannot_create_update_or_delete_objects(): void
    {
        $user = User::factory()->create();
        $objeto = Objeto::factory()->create();

        $this->actingAs($user)
            ->post(route('objetos.store'), $this->validObjectData())
            ->assertForbidden();

        $this->put(route('objetos.update', $objeto), $this->validObjectData())
            ->assertForbidden();

        $this->delete(route('objetos.destroy', $objeto))
            ->assertForbidden();

        $this->assertModelExists($objeto);
    }

    public function test_admin_can_create_an_object_with_a_photo(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->get(route('objetos.create'))
            ->assertOk()
            ->assertSee('Cadastrar objeto encontrado');

        $this->post(route('objetos.store'), [
            ...$this->validObjectData(),
            'foto' => $this->fakeImage('mochila.png'),
        ])
            ->assertRedirect(route('objetos.index'))
            ->assertSessionHas('success');

        $objeto = Objeto::where('titulo', 'Mochila encontrada')->firstOrFail();

        $this->assertSame('disponível', $objeto->status);
        $this->assertNotNull($objeto->foto);
        Storage::disk('public')->assertExists($objeto->foto);
    }

    public function test_admin_can_update_and_delete_an_object_and_its_photo(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();
        $fotoAntiga = $this->fakeImage('foto-antiga.png')->store('objetos', 'public');
        $objeto = Objeto::factory()->create(['foto' => $fotoAntiga]);

        $this->actingAs($admin)
            ->get(route('objetos.edit', $objeto))
            ->assertOk()
            ->assertSee('Editar objeto');

        $this->put(route('objetos.update', $objeto), [
            ...$this->validObjectData(),
            'titulo' => 'Guarda-chuva devolvido',
            'status' => 'devolvido',
            'foto' => $this->fakeImage('foto-nova.png'),
        ])
            ->assertRedirect(route('objetos.index'));

        $objeto->refresh();
        $fotoNova = $objeto->foto;

        $this->assertSame('Guarda-chuva devolvido', $objeto->titulo);
        $this->assertSame('devolvido', $objeto->status);
        Storage::disk('public')->assertMissing($fotoAntiga);
        Storage::disk('public')->assertExists($fotoNova);

        $this->delete(route('objetos.destroy', $objeto))
            ->assertRedirect(route('objetos.index'));

        $this->assertDatabaseMissing('objetos', ['id' => $objeto->id]);
        Storage::disk('public')->assertMissing($fotoNova);
    }

    public function test_admin_can_sign_in_but_non_admin_accounts_cannot(): void
    {
        $admin = $this->createAdmin();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Entrar na administração');

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);

        auth()->logout();

        $user = User::factory()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_seeder_creates_the_account_from_configuration(): void
    {
        config([
            'admin.email' => 'admin@example.test',
            'admin.password' => 'local-test-password',
        ]);

        $this->seed(AdminUserSeeder::class);

        $admin = User::where('email', 'admin@example.test')->firstOrFail();

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue(password_verify('local-test-password', $admin->password));
    }

    public function test_admin_photo_upload_rejects_non_image_files(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin)
            ->post(route('objetos.store'), [
                ...$this->validObjectData(),
                'foto' => UploadedFile::fake()->create('arquivo.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('foto');

        $this->assertDatabaseCount('objetos', 0);
    }

    private function createAdmin(): User
    {
        $admin = User::factory()->create();
        $admin->is_admin = true;
        $admin->save();

        return $admin;
    }

    private function fakeImage(string $filename): UploadedFile
    {
        $content = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/l3sAAAAASUVORK5CYII=',
            true,
        );

        if ($content === false) {
            throw new \LogicException('A imagem de teste não pôde ser decodificada.');
        }

        return UploadedFile::fake()->createWithContent($filename, $content);
    }

    /**
     * @return array<string, string>
     */
    private function validObjectData(): array
    {
        return [
            'titulo' => 'Mochila encontrada',
            'categoria' => 'Material escolar',
            'local' => 'Biblioteca',
            'turno' => 'Matutino',
            'descricao' => 'Mochila azul encontrada na biblioteca.',
        ];
    }
}
