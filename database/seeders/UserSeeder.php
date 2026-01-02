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
                'email' => "super_admin$i@aybarsac.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user_super_admin->assignRole('super-admin');
        }

        for ($i = 1; $i <= 2; $i++) {
            $user_admin = User::create([
                'name' => "Admin $i",
                'email' => "admin$i@aybarsac.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user_admin->assignRole('admin');
        }

        //ATC
        for ($i = 1; $i <= 2; $i++) {
            $supervisor_atc = User::create([
                'name' => "Supervisor Atc $i",
                'email' => "supervisor_atc$i@aybarsac.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $supervisor_atc->syncRoles(['supervisor atc', 'supervisor archivo']);
        }

        $atc = [
            ['name' => 'Chunga Palomino Ximena', 'email' => 'x.chunga@aybarsac.com'],
            ['name' => 'Galvez Vela Luis Armando', 'email' => 'l.galvez@aybarsac.com'],
            ['name' => 'Molero Labarca Jeffersom Gabriel', 'email' => 'j.molero@aybarsac.com'],
            ['name' => 'Muñoz Zevallos Anthony Gabriel', 'email' => 'g.muñoz@aybarsac.com'],
            ['name' => 'Palacios Romero Kimberly Cielo', 'email' => 'c.palacios@aybarsac.com'],
            ['name' => 'Vargas Angel Kleivis Rosmary', 'email' => 'k.vargas@aybarsac.com'],
            ['name' => 'Perez Espiritu Gilaam Yajaira', 'email' => 'g.perez@aybarsac.com'],
            ['name' => 'Estrada Rivas Evelin Yusaira', 'email' => 'e.estrada@aybarsac.com'],
            ['name' => 'Triveño Rado Astrid Marcela', 'email' => 'a.triveño@aybarsac.com'],
            ['name' => 'Rodriguez Valencia Paolo Matias', 'email' => 'r.valencia@aybarsac.com'],
            ['name' => 'Fretel Cruz Sadith del Rosario', 'email' => 'f.cruz@aybarsac.com'],
            ['name' => 'Herrera de la Cruz Miguel Angel', 'email' => 'h.de@aybarsac.com'],
            ['name' => 'Espinoza Obispo Xiomara Nayeli', 'email' => 'e.obispo@aybarsac.com'],
        ];

        foreach ($atc as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user->assignRole('atc');
        }

        //BACKOFFICE
        $backoffice = [
            ['name' => 'RAMON ALBERTO MARTINEZ CONTRERA', 'email' => 'RAMONMARTINEZ@aybarsac.com'],
            ['name' => 'ALEXANDRA GRETTEL REYES CUSTODIO', 'email' => 'acgestor02@aybarsac.com'],
            ['name' => 'ALESSANDRA MARIEL MENACHO MARTICEZ', 'email' => 'acgestor06@aybarsac.com'],
            ['name' => 'MARCO ANTONIO UMERES CONDORI', 'email' => 'acgestor04@aybarsac.com'],
            ['name' => 'ALONSO JAVIER REYES VALENCIA', 'email' => 'acgestor05@aybarsac.com'],
            ['name' => 'SHERYL SIDNEY PORTILLA TATAJE', 'email' => 'acgestor09@aybarsac.com'],
            ['name' => 'JUAN PABLO VELASQUEZ MAMANI', 'email' => 'acgestor10@aybarsac.com'],
            ['name' => 'HENRY POOL TORRES VILLEGAS', 'email' => 'acgestor01@aybarsac.com'],
            ['name' => 'LIZZETT EVELYN MAMANI MONTALVO', 'email' => 'LIZZETTMAMANI@aybarsac.com'],
            ['name' => 'JHON ANTONY SOLIS ROJAS', 'email' => 'validadorcobranza1@aybarsac.com'],
            ['name' => 'LIZBETH FIORELA QUISPE VELARDE', 'email' => 'LIZBETHQUISPE@aybarsac.com'],
            ['name' => 'ALEXANDRA CONY CABRERA VELASQUEZ', 'email' => 'estadocuenta04@aybarsac.com'],
            ['name' => 'ANDREA ISABEL ROJAS DOMINGUEZ', 'email' => 'estadocuenta02@aybarsac.com'],
            ['name' => 'RODRIGO ARTEMIO PAJARES PIZARRO', 'email' => 'estadocuenta05@aybarsac.com'],
            ['name' => 'JORGE ALEXANDER GASTELÚ VASQUEZ', 'email' => 'estadocuenta03@aybarsac.com'],
            ['name' => 'MANUEL REYES REYES', 'email' => 'm.reyes@aybarsac.com'],
            ['name' => 'CHISTINA CORNEJO HILARES', 'email' => 'c.cornejo@aybarsac.com'],
        ];

        foreach ($backoffice as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user->syncRoles(['atc', 'backoffice']);
        }

        //LEGAL
        $legal = [
            ['name' => 'GEMA CACERES VARGAS', 'email' => 'GEMACACERESVARGAS@aybarsac.com'],
            ['name' => 'FLOR ALLCCA', 'email' => 'FLORALLCCA@aybarsac.com'],
            ['name' => 'JACKELYNE RAMOS', 'email' => 'JACKELYNERAMOS@aybarsac.com'],
            ['name' => 'RICARDO ORTIZ', 'email' => 'RICARDOORTIZ@aybarsac.com'],
            ['name' => 'MILAGROS YAÑEZ', 'email' => 'MILAGROSYANEZ@aybarsac.com'],
            ['name' => 'JOSE MUÑOZ', 'email' => 'JOSEMUNOZ@aybarsac.com'],
            ['name' => 'Marco Antonio Santa Maria', 'email' => 'analistalegal01@aybarsac.com'],
            ['name' => 'Grecia Falconi', 'email' => 'especialistacontratos@aybarsac.com'],
            ['name' => 'Stefani', 'email' => 'viviendaparatodos@aybarsac.com'],
            ['name' => 'Sheyla Abad', 'email' => 'analistacontratos@aybarsac.com'],
            ['name' => 'Victor Sánchez', 'email' => 'analistacontratos2@aybarsac.com'],
        ];

        foreach ($legal as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user->syncRoles(['atc', 'legal']);
        }

        //ARCHIVO
        for ($i = 1; $i <= 2; $i++) {
            $supervisor_gestor = User::create([
                'name' => "Supervisor Archivo $i",
                'email' => "supervisor_archivo$i@aybarsac.com",
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $supervisor_gestor->assignRole(['supervisor archivo']);
        }

        $arhivo = [
            ['name' => 'archivo', 'email' => 'ARCHIVO365@AYBARSAC.COM'],
            ['name' => 'GWENDOLYNE ACCOTUPA CHAVEZ', 'email' => 'AUXILIARARCHIVO@AYBARSAC.COM'],
            ['name' => 'IRWIN CHIRINOS CABREJOS', 'email' => 'GWENDOLYNEACCOSTUPA@AYBARSAC.COM'],
        ];

        foreach ($arhivo as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('123456'),
                'rol' => 'admin',
                'activo' => true,
            ]);

            $user->assignRole('archivo');
        }

        //CLIENTE
        for ($i = 1; $i <= 2; $i++) {
            $cliente = User::create([
                'name' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'password' => Hash::make('123456'),
                'rol' => 'cliente',
                'activo' => true,
            ]);

            //$cliente->assignRole('cliente');

            Cliente::factory()->create([
                'user_id' => $cliente->id,
                'email' => $cliente->email,
                'nombre' => $cliente->name,
            ]);
        }
    }
}
