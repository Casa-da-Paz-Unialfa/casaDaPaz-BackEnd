<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::all()->map(function ($image) {
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
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('gallery', 'public');
                    $imagePaths[] = $path; // Salva o caminho da imagem
                }
            }

            // Armazena os caminhos como JSON no campo `image`
            $imageModel = Image::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => json_encode($imagePaths),
            ]);

            return response()->json([
                'message' => 'Imagens enviadas com sucesso!',
                'data' => [
                    'name' => $imageModel->name,
                    'description' => $imageModel->description,
                    'images' => $imagePaths,
                ]
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Erro ao enviar as imagens',
                'error' => $e->getMessage(),
            ], 400);
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
        $request = Image::find($id);

        $path = $request->file('image')->store('gallery', 'public');

        $request->update([
            'name' => $request->name,
            'image' => $path,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Image changed successfully!',
            'data' => [
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
        $resp = Image::where('id', $id)->delete();

        return response()->json($resp);
    }
}
