<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentDownloadLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

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
        //if (!auth()->check()) {
        //    return redirect()->route('login')->with([
        //        'warning' => 'Silakan login untuk membaca peraturan',
        //        'redirectAfterLogin' => url()->current(),
        //    ]);
        //}

        $peraturan = Document::where('id', $id_peraturan)
            ->where('slug', $slug)
            ->firstOrFail();

        $userHasAccess = false;

        if (auth()->check()) {
            $user = auth()->user();

            $userHasAccess = $peraturan->is_public
                || $peraturan->created_by === $user->id
                || $user->hasActiveMembership(); // dari model User
        }
        
        return view('peraturan.show', [
            'peraturan' => $peraturan,
            'userHasAccess' => $userHasAccess,
        ]);
    }

    public function showX($slug, $id_peraturan)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with([
                'warning' => 'Silakan login untuk membaca peraturan',
                'redirectAfterLogin' => url()->current(),
            ]);
        }

        $peraturan = Document::findOrFail($id_peraturan);

        $userHasAccess = $peraturan->is_public
            || $peraturan->created_by == auth()->id()
            || $peraturan->accesses()->where('user_id', auth()->id())->exists();

        if (!$userHasAccess) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        return view('peraturan.show', [
            'peraturan' => $peraturan,
            'userHasAccess' => $userHasAccess,
        ]);
    }

    public function showByToken($token)
    {
        try {
            $data = Crypt::decrypt($token); // ['id' => ..., 'slug' => ...]
            return $this->show($data['slug'], $data['id']);
        } catch (\Exception $e) {
            abort(403, 'Invalid or expired token.');
        }
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

    public function download($slug, $id)
    {
        $document = Document::where('id', $id)
            ->where('slug', $slug)
            ->firstOrFail();

        // Hanya user login yang bisa download
        if (!auth()->check()) {
            abort(403, 'Unauthorized access');
        }

        $user = auth()->user();

        // Jika dokumen private → validasi membership
        if (!$document->is_public) {
            $membership = $user->activeMembership;

            if (!$membership) {
                return back()->with('error', 'Anda tidak memiliki langganan aktif.');
            }

            $plan = $membership->plan; // Relasi ke MembershipPlan
            $maxDownloads = match ($plan->id) {
                2 => 5,   // Silver
                3 => 10,  // Gold
                default => 0
            };

            $downloadCount = DocumentDownloadLog::where('user_id', $user->id)
                ->whereBetween('downloaded_at', [$membership->start_date, $membership->end_date])
                ->count();

            if ($downloadCount >= $maxDownloads) {
                return back()->with('error', 'Batas download Anda telah tercapai.');
            }
        }

        // Validasi file ada
        $filePath = $document->file_path;

        if (!Storage::disk('private_uploads')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        // ✅ Catat log download
        DocumentDownloadLog::create([
            'user_id'       => $user->id,
            'document_id'   => $document->id,
            'downloaded_at' => now(),
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
        ]);

        // Tambah total download
        $document->increment('download_count');

        // Ambil path & nama file
        $fullPath = Storage::disk('private_uploads')->path($filePath);
        $downloadFileName = $document->getDownloadFilename();

        return response()->download($fullPath, $downloadFileName);
    }

    public function downloadByToken($token)
    {
        try {
            $data = Crypt::decrypt($token); // hasil: ['id' => ..., 'slug' => ...]

            return $this->download($data['slug'], $data['id']);
        } catch (\Exception $e) {
            abort(403, 'Invalid download token.');
        }
    }

}
