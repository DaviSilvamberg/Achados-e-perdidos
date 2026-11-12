<?php

namespace App\Models;

use Database\Factories\ObjetoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['titulo', 'categoria', 'local', 'turno', 'descricao', 'foto', 'status'])]
class Objeto extends Model
{
    /** @use HasFactory<ObjetoFactory> */
    use HasFactory;
}
