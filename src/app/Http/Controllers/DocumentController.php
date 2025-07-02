<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class DocumentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($fileName)
    {
        // Pastikan user login & punya akses ke dokumen
        if (!Auth::check()) {
            abort(403, 'Akses ditolak.');
        }

        $filePath = "documents/" . $fileName;

        if (!Storage::disk('private_uploads')->exists($fileName)) {
            abort(404, 'File tidak ditemukan.');
        }

        $file = Storage::disk('private_uploads')->get($fileName);
        $mimeType = Storage::disk('private_uploads')->mimeType($fileName);

        return response($file, 200)->header('Content-Type', $mimeType);
    }
}
