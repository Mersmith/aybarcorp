<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 2; $i++) {
            $user_super_admin = User::create([
                'name' => "Super Admin $i",
                'email' => "super_admin$i@aybarplat.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]);

            $user_super_admin->assignRole('super-admin');
        }

        for ($i = 1; $i <= 2; $i++) {
            $supervisor_gestor = User::create([
                'name' => "Supervisor Gestor $i",
                'email' => "supervisor_gestor$i@aybarplat.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]);

            $supervisor_gestor->syncRoles(['supervisor atc', 'supervisor atc']);
        }

        for ($i = 1; $i <= 8; $i++) {
            $gestor = User::create([
                'name' => "Gestor $i",
                'email' => "gestor$i@aybarplat.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]);

            $gestor->assignRole('gestor');
        }

        for ($i = 1; $i <= 2; $i++) {
            $supervisor_atc = User::create([
                'name' => "Supervisor Atc $i",
                'email' => "supervisor_atc$i@aybarplat.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]);

            $supervisor_atc->syncRoles(['supervisor atc', 'supervisor gestor']);
        }

        for ($i = 1; $i <= 8; $i++) {
            $atc = User::create([
                'name' => "Atc $i",
                'email' => "atc$i@aybarplat.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
            ]);

            $atc->assignRole('atc');
        }

        for ($i = 1; $i <= 2; $i++) {
            $cliente = User::create([
                'name' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'password' => Hash::make('123456'),
                'rol' => 'cliente',
            ]);

            //$cliente->assignRole('cliente');

            Cliente::factory()->create([
                'user_id' => $cliente->id,
                'email' => $cliente->email,
                'nombre' => $cliente->name,
                'nombre_completo' => $cliente->name,
            ]);
        }
    }
}
