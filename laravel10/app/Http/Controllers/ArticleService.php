<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        $article->content = $request->content;
        $article->status = $request->status;
        $article->view_count = 0;
        $article->author_id = auth()->id() ?? 1; 
        $article->save();

        return redirect()->route('article.index')->with('success', 'Artikel baru berhasil diterbitkan.');
    }

    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Article::find($id);
        
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('articles.getEditFormB', compact('data'))->render()
        ), 200);
    }

 
    public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);
        
        $article->title = $request->title;
        $article->slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        $article->content = $request->content;
        $article->status = $request->status;
        $article->save();
        
        return response()->json(array(
            'status' => 'oke', 
            'msg' => 'Artikel berhasil diperbarui!'
        ), 200);
    }

    public function deleteData(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);
        
        if ($article) {
            $article->delete();
            return response()->json(array(
                'status' => 'oke',
                'msg' => 'Artikel berhasil dihapus!'
            ), 200);
        }

        return response()->json(array(
            'status' => 'error',
            'msg' => 'Artikel tidak ditemukan.'
        ), 404);
    }
}