<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Colaborador extends Model {
    use HasFactory, LogsActivity;

    protected $table = 'colaboradores';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'unidade_id',
    ];

    public function unidade() {
        return $this->belongsTo(Unidade::class);
    }
}
