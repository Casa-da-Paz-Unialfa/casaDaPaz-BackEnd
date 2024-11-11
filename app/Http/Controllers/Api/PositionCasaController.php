<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PositionCasa;
use Illuminate\Http\Request;

class PositionCasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = PositionCasa::all()->map(function ($image) {
            $image->image = url('storage/' . $image->image); // Gera o URL completo
            return $image;
        });

        return response()->json($images);
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
        // dd($request->all());
        try {
            // Validação dos campos
            $request->validate([
                'position' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:png,jpg,jpeg|max:4096'
            ]);


            // Verifica se o arquivo foi enviado
            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json(['message' => 'No valid image file provided.'], 400);
            }

            $path = $request->file('image')->store('owners', 'public');

            // Salva os dados no banco de dados
            $imageModel = PositionCasa::create([
                'position' => $request->position,
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path
            ]);

            return response()->json([
                'message' => 'Imagem enviada com sucesso!',
                'data' => [
                    'position' => $imageModel->position,
                    'name' => $imageModel->name,
                    'description' => $imageModel->description,
                    'image' => $path
                ]
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'messagem' => $e
            ], 404);
        }
    }


    // /******  96c69de0-bb60-4527-a461-e8e2ad57ec6a  *******/
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
        $request = PositionCasa::find($id);

        $path = $request->file('image')->store('gallery', 'public');

        $request->update([
            'position' => $request->position,
            'name' => $request->name,
            'image' => $path,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Image changed successfully!',
            'data' => [
                'position' => $request->position,
                'name' => $request->name,
                'image' => $path,
                'description' => $request->description
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = PositionCasa::where('id', $id)->delete();

        return response()->json($resp);
    }
}
