<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class GrupoEconomico extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'Grupo_Economicos';

    protected $fillable = [
        'nome',
    ];

    public function bandeiras() {
        return $this->hasMany(Bandeira::class);
    }
}
