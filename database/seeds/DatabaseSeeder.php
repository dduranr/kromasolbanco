<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        App\User::create([
            'name' => 'Ejecutivo Gonzalo',
            'email' => 'gonzalo@gmail.com',
            'password' => Hash::make('abc123'),
            'tipo' => 1
        ]);
        App\Ejecutivo::create([
            'nombre' => 'Ejecutivo Gonzalo',
            'email' => 'gonzalo@gmail.com',
            'sucursales' => '["1","3"]',
        ]);

    }
}
