<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transparency;
use Illuminate\Http\Request;

class TransparencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = Transparency::all()->map(function ($transparency) {
            // Gera a URL completa para cada imagem
            $transparency->file = asset('storage/' . $transparency->file);
            return $transparency;
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
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'file' => 'required|mimes:pdf,doc,docx|max:4096'
            ]);



            // Verifica se o arquivo foi enviado
            if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
                return response()->json(['message' => 'No valid image file provided.'], 400);
            }

            $path = $request->file('file')->store('files', 'public');

            // dd($request->all());
            // Armazenar no banco de dados (exemplo)
            $dados = Transparency::create([
                'name' => $request->name,
                'description' => $request->description,
                'file' => $path
            ]);

            return response()->json([
                'message' => 'file uploaded successfully!',
                'data' => [
                    'name' => $dados->name,
                    'description' => $dados->description,
                    'file' => $path
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
        $request = Transparency::find($id);

        $path = $request->file('files')->store('files', 'public');

        $request->update([
            'name' => $request->name,
            'description' => $request->description,
            'file' => $path
        ]);

        return response()->json([
            'message' => 'Image changed successfully!',
            'data' => [
                'name' => $request->name,
                'description' => $request->description,
                'file' => $path
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $resp = Transparency::where('id', $id)->delete();

        return response()->json($resp);
    }
}
