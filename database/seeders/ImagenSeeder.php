<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Imagen;

class ImagenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define la ruta de origen donde tienes las imágenes
        $sourcePath = public_path('assets/imagen');

        // 2. Define el directorio de destino dentro del disco 'public' de Laravel (storage/app/public/imagen)
        // He corregido el destino a 'imagen' para que coincida con la ruta original, pero puedes mantener 'imagenes' si lo prefieres.
        $destinationDir = 'imagenes';

        // 3. Catálogo de nombres de archivo de las imágenes
        $imageFiles = [
            'default.jpg',
            'sliders-computadora-1.jpg',
            'sliders-computadora-2.jpg',
            'sliders-movil-1.jpg',
            'sliders-movil-2.jpg',
        ];

        // Definimos el número de veces que queremos repetir cada imagen en la base de datos
        $repetitions = 15;

        // BUCLE EXTERNO: Controla el número de repeticiones (1 a 5)
        for ($i = 1; $i <= $repetitions; $i++) {
            //$this->command->warn("--- Repetición $i de $repetitions ---");

            // BUCLE INTERNO: Itera sobre cada archivo del catálogo
            foreach ($imageFiles as $fileName) {
                $sourceFile = $sourcePath . '/' . $fileName;

                // 4. Verifica que el archivo de origen exista
                if (File::exists($sourceFile)) {
                    // Genera un nombre de archivo único A CADA ITERACIÓN
                    // Esto asegura que cada registro de DB apunte a una COPIA física diferente (aunque el contenido sea el mismo)
                    $uniqueFileName = time() . '_' . Str::slug(pathinfo($fileName, PATHINFO_FILENAME)) . '_' . $i . '.' . pathinfo($fileName, PATHINFO_EXTENSION);

                    // 5. Mueve (o copia) el archivo al disco de almacenamiento 'public'
                    $filePath = Storage::disk('public')->putFileAs(
                        $destinationDir,
                        $sourceFile,
                        $uniqueFileName
                    );

                    // 6. Crea el registro en la base de datos
                    Imagen::create([
                        'path' => $filePath,
                        'url' => Storage::disk('public')->url($filePath),
                        'titulo' => Str::title(str_replace('-', ' ', pathinfo($fileName, PATHINFO_FILENAME))) . " (Rep $i)",
                        'descripcion' => 'Imagen de catálogo cargada en la repetición ' . $i . '.',
                        'extension' => pathinfo($fileName, PATHINFO_EXTENSION),
                    ]);

                    //$this->command->info(" - Imagen '$fileName' registrada en DB (Copia $i).");
                } else {
                    $this->command->error("Archivo no encontrado: $fileName en $sourcePath");
                }
            }
        }
    }
}
