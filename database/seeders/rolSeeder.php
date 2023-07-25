<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
            'id' => 1,
            'nombre' => 'SOCIO COMISIONISTA',
            'estado' => 1,
            ],
            [
            'id' => 2,
            'nombre' => 'CONTROLADOR',
            'estado' => 1,
            ],
            [
            'id' => 3,
            'nombre' => 'ADMINISTRADOR',
            'estado' => 1,
            ],
            
            
        ]);
    }
}
