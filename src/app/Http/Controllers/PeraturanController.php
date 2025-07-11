<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class PeraturanController extends Controller
{
    /**
     * Menampilkan daftar peraturan
     */
    public function index()
    {
        // Ambil peraturan dengan id=1 atau parent=11
        $peraturan = Document::orderBy('created_at', 'desc')
                          ->paginate(6); // 6 item per halaman

        return view('peraturan.index', compact('peraturan'));
    }

    public function byKategori($slug, $id_kategori)
    {
        $kategori = Document::findOrFail($id_kategori);
        $peraturan = $kategori->peraturan()->paginate(10);
        
        return view('peraturan.kategori', compact('kategori', 'peraturan'));
    }

    public function show($slug, $id_peraturan)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with([
                'warning' => 'Silakan login untuk membaca peraturan: "Judul Peraturan"',
                'redirectAfterLogin' => url()->current()
            ]);
        }
    
        $peraturan = Document::findOrFail($id_peraturan);
        
        // Validasi slug
        if ($peraturan->slug !== $slug) {
            return redirect()->route('peraturan.show', [
                'slug' => $peraturan->slug, 
                'id_peraturan' => $id_peraturan
            ], 301);
        }
        
        return view('peraturan.show', compact('peraturan'));
    }

        /**
     * Handle search request
     */
    public function search(Request $request)
    {
        $query = Document::query();

        // Filter by keyword
        if ($request->has('q')) {
            $searchTerm = $request->input('q');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by tahun (contoh tambahan)
        //if ($request->has('tahun')) {
        //    $query->whereYear('tanggal_dokumen', $request->input('tahun'));
        //}

        $results = $query->paginate(6)
                       ->appends($request->query());

        return view('peraturan.search', [
            'results' => $results,
            'searchQuery' => $request->input('q', ''),
            //'tahun' => $request->input('tahun', '')
        ]);
    }

}
