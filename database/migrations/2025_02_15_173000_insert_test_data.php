<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        if (!env('SEED_TEST_DATA', false)) {
            return;
        }

        $now = now();

        // Insert Grupos Econômicos
        $gruposIds = [];
        for ($i = 1; $i <= 15; $i++) {
            $gruposIds[] = DB::table('Grupo_Economicos')->insertGetId([
                'nome' => "Grupo Teste {$i}",
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // Insert Bandeiras
        $bandeirasIds = [];
        foreach ($gruposIds as $grupoId) {
            $bandeirasIds[] = DB::table('bandeiras')->insertGetId([
                'nome' => "Bandeira Teste {$grupoId}",
                'grupo_economico_id' => $grupoId,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // Insert Unidades
        $unidadesIds = [];
        foreach ($bandeirasIds as $bandeiraId) {
            $unidadesIds[] = DB::table('unidades')->insertGetId([
                'nome_fantasia' => "Unidade Teste {$bandeiraId}",
                'razao_social' => "Unidade Teste {$bandeiraId} LTDA",
                'cnpj' => str_pad($bandeiraId, 14, '0', STR_PAD_LEFT),
                'bandeira_id' => $bandeiraId,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        // Insert Colaboradores
        foreach ($unidadesIds as $unidadeId) {
            DB::table('colaboradores')->insert([
                'nome' => "Colaborador Teste {$unidadeId}",
                'email' => "colaborador{$unidadeId}@teste.com",
                'cpf' => str_pad($unidadeId, 11, '0', STR_PAD_LEFT),
                'unidade_id' => $unidadeId,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }

    public function down()
    {
        if (!env('SEED_TEST_DATA', false)) {
            return;
        }

        // Delete in reverse order to maintain referential integrity
        DB::table('colaboradores')->whereRaw("nome LIKE 'Colaborador Teste %'")->delete();
        DB::table('unidades')->whereRaw("nome_fantasia LIKE 'Unidade Teste %'")->delete();
        DB::table('bandeiras')->whereRaw("nome LIKE 'Bandeira Teste %'")->delete();
        DB::table('Grupo_Economicos')->whereRaw("nome LIKE 'Grupo Teste %'")->delete();
    }
};
