<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ImagenController extends Controller
{
    public function uploadLocalImagen(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('ckeditors', 'public');

            return response()->json([
                'uploaded' => true,
                'url' => asset('storage/' . $path),
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => ['message' => 'No file uploaded.'],
        ]);
    }
}
