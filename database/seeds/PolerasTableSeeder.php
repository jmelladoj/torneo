<?php

use App\Polera;
use Illuminate\Database\Seeder;

class PolerasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Polera::create(['talla' => 'S']);
        Polera::create(['talla' => 'M']);
        Polera::create(['talla' => 'L']);
        Polera::create(['talla' => 'XL']);
    }
}
