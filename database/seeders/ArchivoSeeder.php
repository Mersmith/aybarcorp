<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Archivo;

class ArchivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivos = [
            [
                'titulo' => 'Manual de Usuario',
                'descripcion' => 'Documento de ayuda para el usuario final.',
                'path' => 'archivos/manual_usuario.docx',
                'url' => 'http://localhost/storage/archivos/manual_usuario.docx',
                'extension' => 'docx',
            ],
            [
                'titulo' => 'Reporte Financiero 2025',
                'descripcion' => 'Resumen de estados financieros del año 2025.',
                'path' => 'archivos/reporte_financiero.xlsx',
                'url' => 'http://localhost/storage/archivos/reporte_financiero.xlsx',
                'extension' => 'xlsx',
            ],
            [
                'titulo' => 'Presentación Comercial',
                'descripcion' => 'Diapositivas para presentación a clientes.',
                'path' => 'archivos/presentacion_comercial.pptx',
                'url' => 'http://localhost/storage/archivos/presentacion_comercial.pptx',
                'extension' => 'pptx',
            ],
            [
                'titulo' => 'Catálogo de Productos',
                'descripcion' => 'Versión PDF del catálogo de productos 2025.',
                'path' => 'archivos/catalogo_productos.pdf',
                'url' => 'http://localhost/storage/archivos/catalogo_productos.pdf',
                'extension' => 'pdf',
            ],
        ];

        foreach ($archivos as $archivo) {
            Archivo::create($archivo);
        }
    }
}
