<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = AboutUs::all();

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
        // dd($request->all());
        try {
            // Validação dos campos
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            // Armazenar no banco de dados (exemplo)
            $dades = AboutUs::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'about us uploaded successfully!',
                'data' => [
                    'name' => $dades->name,
                    'description' => $dades->description,
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
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        return response()->json($aboutUs, 200);
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
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        // Buscar o registro pelo ID
        $aboutUs = AboutUs::find($id);

        // Verificar se o registro foi encontrado
        if (!$aboutUs) {
            return response()->json(['message' => 'Registro não encontrado'], 404);
        }

        // Atualizar os campos com os novos dados
        $aboutUs->name = $validatedData['name'];
        $aboutUs->description = $validatedData['description'];

        // Salvar as mudanças no banco de dados
        $aboutUs->save();

        return response()->json(['message' => 'Dados atualizados com sucesso'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
