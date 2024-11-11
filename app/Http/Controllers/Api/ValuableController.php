<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Valuable;
use Dotenv\Parser\Value;
use Illuminate\Http\Request;

class ValuableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = Valuable::all()->toArray();;
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
        //dd($request->all());
        try {
            // Validação dos campos
            $request->validate([
                'position' => 'required|string|max:255',
                'vacancies' => 'required|integer|min:1|max:255',
            ]);

            $vacancies = intval($request->input('vacancies'));
            // Armazenar no banco de dados (exemplo)
            $dades = Valuable::create([
                'position' => $request->position,
                'vacancies' => $vacancies,
            ]);

            return response()->json([
                'message' => 'about us uploaded successfully!',
                'data' => [
                    'position' => $dades->position,
                    'vacancies' => $dades->vacancies,
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
        $resp = Valuable::where('id', $id)->delete();

        return response()->json($resp);
    }
}
