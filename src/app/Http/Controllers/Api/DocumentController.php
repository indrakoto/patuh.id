<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    // Menampilkan semua dokumen, public dan private
    public function index()
    {
        // Bisa tambahkan pagination jika perlu
        $documents = Document::select('id', 'title', 'slug', 'description', 'thumbnail_path', 'is_public', 'price')
                             ->orderBy('created_at', 'desc')
                             ->get();

        return response()->json($documents);
    }

    // Menampilkan detail dokumen, hanya untuk user terautentikasi
    public function show($id)
    {
        $document = Document::find($id);

        if (! $document) {
            return response()->json(['message' => 'Document not found'], 404);
        }

        // Cek jika dokumen public atau user sudah login
        if (! $document->is_public && auth()->guest()) {
            return response()->json(['message' => 'Unauthorized to view this document'], 401);
        }

        return response()->json([
            'id' => $document->id,
            'title' => $document->title,
            'slug' => $document->slug,
            'description' => $document->description,
            'file_path' => $document->file_path,
            'file_name' => $document->file_name,
            'file_size' => $document->file_size,
            'file_type' => $document->file_type,
            'thumbnail_path' => $document->thumbnail_path,
            'is_public' => $document->is_public,
            'price' => $document->price,
            'download_count' => $document->download_count,
            'created_by' => $document->created_by,
            'category_id' => $document->category_id,
            'created_at' => $document->created_at,
            'updated_at' => $document->updated_at,
        ]);
    }
}
