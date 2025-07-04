<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        // Ambil 9 artikel terbaru
        $newsList = News::with(['category'])
            ->where([
                    ['is_published', '=', 1]
                ])
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->paginate(9); // Mengambil 10 artikel per halaman
        
        return view('news.index', [
            'newsList' => $newsList
        ]);
    }

    // Menampilkan satu artikel berdasarkan slug
    public function showArticle($news_slug, $id)
    {
        
        $news = News::with(['category'])
            ->where([
                    ['is_published', '=', 1],
                ])
            ->findOrFail($id);
        
        // Ambil 10 artikel terkait (kecuali artikel saat ini)
        $relatedNews = News::with(['category'])
            ->where('category_id', $news->category_id) // Cari artikel dengan kategori yang sama
            ->where('id', '!=', $id) // Mengecualikan artikel yang sedang dilihat
            ->where('is_published', 1)
            ->latest() // Mengurutkan berdasarkan tanggal terbaru
            ->take(6) // Ambil 10 artikel terkait
            ->get();
            
        return view('news.show', [
            'news' => $news,
            'relatedNews' => $relatedNews,
        ]);

    }
}
