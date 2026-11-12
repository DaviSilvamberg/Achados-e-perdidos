<?php

namespace App\Http\Controllers;

use App\Models\Objeto;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use RuntimeException;

class ObjetoController extends Controller
{
    private const CATEGORIAS = [
        'Material escolar',
        'Eletrônicos',
        'Roupas e acessórios',
        'Garrafas e lancheiras',
        'Documentos',
        'Outros',
    ];

    private const TURNOS = ['Matutino', 'Vespertino', 'Noturno'];

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'busca' => ['nullable', 'string', 'max:100'],
            'categoria' => ['nullable', Rule::in(self::CATEGORIAS)],
            'turno' => ['nullable', Rule::in(self::TURNOS)],
        ]);

        $objetos = Objeto::query()
            ->when($filters['busca'] ?? null, function (Builder $query, string $busca): void {
                $query->where('titulo', 'like', '%'.$busca.'%');
            })
            ->when($filters['categoria'] ?? null, function (Builder $query, string $categoria): void {
                $query->where('categoria', $categoria);
            })
            ->when($filters['turno'] ?? null, function (Builder $query, string $turno): void {
                $query->where('turno', $turno);
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('objetos.index', compact('objetos'));
    }

    public function create(): View
    {
        return view('objetos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        if (isset($data['foto'])) {
            $data['foto'] = $this->storeFoto($data['foto']);
        }

        Objeto::create($data);

        return redirect()->route('objetos.index')->with('success', 'Objeto cadastrado com sucesso.');
    }

    public function edit(Objeto $objeto): View
    {
        return view('objetos.edit', compact('objeto'));
    }

    public function update(Request $request, Objeto $objeto): RedirectResponse
    {
        $data = $request->validate($this->rules(true));
        $fotoAntiga = $objeto->foto;

        if (isset($data['foto'])) {
            $data['foto'] = $this->storeFoto($data['foto']);
        }

        $objeto->update($data);

        $fotoRemovida = $fotoAntiga === null || $fotoAntiga === $objeto->foto
            || $this->deleteFoto($fotoAntiga);

        $response = redirect()->route('objetos.index')
            ->with('success', 'Objeto atualizado com sucesso.');

        if (! $fotoRemovida) {
            $response->with('warning', 'O objeto foi atualizado, mas não foi possível remover a foto antiga.');
        }

        return $response;
    }

    public function destroy(Objeto $objeto): RedirectResponse
    {
        $foto = $objeto->foto;
        $objeto->delete();

        if ($foto !== null && ! $this->deleteFoto($foto)) {
            return redirect()->route('objetos.index')
                ->with('warning', 'O objeto foi excluído, mas não foi possível remover sua foto.');
        }

        return redirect()->route('objetos.index')->with('success', 'Objeto excluído com sucesso.');
    }

    /**
     * @return array<string, array<int, string|In>>
     */
    private function rules(bool $updating = false): array
    {
        return [
            'titulo' => ['required', 'string', 'max:120'],
            'categoria' => ['required', Rule::in(self::CATEGORIAS)],
            'local' => ['required', 'string', 'max:150'],
            'turno' => ['required', Rule::in(self::TURNOS)],
            'descricao' => ['required', 'string', 'max:2000'],
            'status' => [$updating ? 'required' : 'sometimes', Rule::in(['disponível', 'devolvido'])],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ];
    }

    private function storeFoto(UploadedFile $foto): string
    {
        $path = $foto->store('objetos', 'public');

        if ($path === false) {
            throw new RuntimeException('Não foi possível armazenar a foto do objeto.');
        }

        return $path;
    }

    private function deleteFoto(string $path): bool
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($path)) {
            return true;
        }

        if ($disk->delete($path)) {
            return true;
        }

        Log::warning('Não foi possível remover uma foto de objeto.', ['path' => $path]);

        return false;
    }
}
