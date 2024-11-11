<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bazzar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class BazzarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = Bazzar::all()->map(function ($bazzar) {
            // Gera a URL completa para cada imagem
            $bazzar->image = asset('storage/' . $bazzar->image);
            return $bazzar;
        });

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica os dados recebidos
        try {
            // Validação dos campos
            $request->validate([
                'image' => 'required|image|mimes:png,jpg,jpeg|max:4096'
            ]);

            $path = $request->file('image')->store('bazzar', 'public');

            // Armazenar no banco de dados (exemplo)
            Bazzar::create([
                'image' => $path
            ]);

            return response()->json([
                'message' => 'bazzar uploaded successfully!',
                'data' => [
                    'image' => $path
                ]
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'messagem' => 'erro erro a enviar'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = Bazzar::where('id', $id)->delete();

        return response()->json($resp);
    }
}
