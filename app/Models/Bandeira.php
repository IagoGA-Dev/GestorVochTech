<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandeira extends Model {
    use HasFactory;

    protected $table = 'bandeiras';

    protected $fillable = [
        'nome',
        'grupo_economico_id',
    ];

    public function grupoEconomico() {
        return $this->belongsTo(GrupoEconomico::class);
    }

    public function unidades() {
        return $this->hasMany(Unidade::class);
    }
}

