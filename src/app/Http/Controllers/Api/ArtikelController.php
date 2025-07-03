<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar data artikel',
            'data' => $artikels
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $artikel = Artikel::find($id);

        if ($artikel) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data artikel',
                'data' => $artikel
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}