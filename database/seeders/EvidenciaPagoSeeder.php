<?php

namespace Database\Seeders;

use App\Models\EvidenciaPago;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EvidenciaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakePath = public_path('assets/imagen/default.jpg');

        if (!file_exists($fakePath)) {
            dump("⚠️ La imagen no existe: $fakePath");
            return;
        }

        // Asegurar que la carpeta exista
        Storage::disk('public')->makeDirectory('evidencias');

        // Subir la imagen al storage
        $filename = 'fake_' . Str::random(10) . '.jpg';
        $storagePath = 'evidencias/' . $filename;

        Storage::disk('public')->put(
            $storagePath,
            file_get_contents($fakePath)
        );

        // URL accesible
        $url = Storage::url($storagePath);

        // Obtener un cliente cualquiera o null si no existe
        $clienteId = Cliente::inRandomOrder()->value('id') ?? null;

        $estados = [1, 2, 3, 4];

        // Insertar registros de prueba
        foreach (range(1, 30) as $i) {
            EvidenciaPago::create([
                'cronograma_id' => null,
                'unidad_negocio_id' => rand(1, 3),
                'proyecto_id' => rand(1, 10),
                'path' => $storagePath,
                'url' => $url,
                'extension' => 'jpg',

                'numero_operacion' => rand(10000000, 99999999),
                'banco' => 'BCP',
                'monto' => fake()->randomFloat(2, 50, 2000),
                'fecha' => fake()->date(),

                'estado_evidencia_pago_id' => $estados[array_rand($estados)],
                'cliente_id' => $clienteId,
                'usuario_valida_id' => null,
            ]);
        }

        dump("🌱 Seeder EvidenciaPagoSeeder ejecutado correctamente ✔️");

    }
}
