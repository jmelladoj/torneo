<?php

use App\Categoria;
use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Categoria::create([
            'nombre' => 'RX HOMBRES',
            'valor' => 35000,
            'cupos' => 24,
            'categoria' => 1
        ]);

        Categoria::create([
            'nombre' => 'SCALED HOMBRES',
            'valor' => 35000,
            'cupos' => 36,
            'categoria' => 1
        ]);

        Categoria::create([
            'nombre' => 'DUPLAS BÁSICO HOMBRES',
            'valor' => 70000,
            'cupos' => 24,
            'categoria' => 2
        ]);

        Categoria::create([
            'nombre' => '35+ HOMBRES',
            'valor' => 35000,
            'cupos' => 24,
            'categoria' => 1,
            'limitancia_edad' => 1,
            'edad_minima' => 35
        ]);

        Categoria::create([
            'nombre' => '40+ HOMBRES',
            'valor' => 35000,
            'cupos' => 12,
            'categoria' => 1,
            'limitancia_edad' => 1,
            'edad_minima' => 40
        ]);

        Categoria::create([
            'nombre' => 'RX MUJERES',
            'valor' => 35000,
            'cupos' => 12,
            'categoria' => 1
        ]);

        Categoria::create([
            'nombre' => 'SCALED MUJERES',
            'valor' => 35000,
            'cupos' => 12,
            'categoria' => 1
        ]);

        Categoria::create([
            'nombre' => 'DUPLAS BÁSICO MUJERES',
            'valor' => 70000,
            'cupos' => 24,
            'categoria' => 2
        ]);

        Categoria::create([
            'nombre' => '35+ MUJERES',
            'valor' => 35000,
            'cupos' => 12,
            'categoria' => 1,
            'limitancia_edad' => 1,
            'edad_minima' => 30
        ]);

        Categoria::create([
            'nombre' => 'SCALED TRÍOS',
            'valor' => 105000,
            'cupos' => 12,
            'categoria' => 3
        ]);
    }
}
