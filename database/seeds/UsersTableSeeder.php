<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@torneoarena.cl',
            'password' => bcrypt('arena.2020*')
        ]);
    }
}
