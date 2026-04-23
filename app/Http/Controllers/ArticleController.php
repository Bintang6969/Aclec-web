<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $category = request('category');
        $query = Article::with('author:id,name')
            ->whereNotNull('published_at')
            ->orderByDesc('published_at');

        if ($category && array_key_exists($category, Article::categories())) {
            $query->where('category', $category);
        }

        $articles   = $query->paginate(9)->withQueryString();
        $categories = Article::categories();

        return view('articles.index', compact('articles', 'categories', 'category'));
    }

    public function show(Article $article)
    {
        abort_if(!$article->published_at, 404);
        return view('articles.show', compact('article'));
    }
}
