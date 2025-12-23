<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GrupoProyecto;

class GrupoProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            [
                'nombre' => 'Proyectos en Lima Metropolitana',
                'slug' => 'proyectos-en-lima-metropolitana',
                'titulo' => 'LIMA',
                'subtitulo' => 'METROPOLITANA',
                'imagen' => asset('assets/imagenes/proyectos/proyecto-1.jpg'),
            ],
            [
                'nombre' => 'Proyectos en Huacho',
                'slug' => 'proyectos-en-huacho',
                'titulo' => 'HUACHO',
                'subtitulo' => 'HUAURA',
                'imagen' => asset('assets/imagenes/proyectos/proyecto-1.jpg'),
            ],
            [
                'nombre' => 'Proyectos en Lima Huaral',
                'slug' => 'proyectos-en-lima-huaral',
                'titulo' => 'HUARAL',
                'subtitulo' => 'LIMA',
                'imagen' => asset('assets/imagenes/proyectos/proyecto-1.jpg'),
            ],
            [
                'nombre' => 'Proyectos en Ica',
                'slug' => 'proyectos-en-ica',
                'titulo' => 'ICA',
                'subtitulo' => 'ICA',
                'imagen' => asset('assets/imagenes/proyectos/proyecto-1.jpg'),
            ],
        ];

        GrupoProyecto::insert($grupos);
    }
}
