<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Events::all()->map(function ($image) {
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
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'image' => 'required|image|mimes:png,jpg,jpeg|max:4096'
            ]);


            // Verifica se o arquivo foi enviado
            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json(['message' => 'No valid image file provided.'], 400);
            }

            $path = $request->file('image')->store('events', 'public');

            // Armazenar no banco de dados (exemplo)
            $imageModel = Events::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $path
            ]);

            return response()->json([
                'message' => 'Image uploaded successfully!',
                'data' => [
                    'name' => $imageModel->name,
                    'description' => $imageModel->description,
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
        $request = Events::find($id);

        $path = $request->file('image')->store('events', 'public');

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
        $resp = Events::where('id', $id)->delete();

        return response()->json($resp);
    }
}
