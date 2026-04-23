@extends('layouts.app')
@section('title', $article->title)

@section('content')
<div class="container py-4" style="max-width:780px;">
    <a href="{{ route('articles.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    @if($article->image)
    <img src="{{ $article->image }}" class="img-fluid rounded-4 mb-4 w-100" style="max-height:360px; object-fit:cover;" alt="{{ $article->title }}">
    @endif

    <span class="badge bg-success bg-opacity-10 text-success mb-2">
        {{ \App\Models\Article::categories()[$article->category] ?? ucfirst($article->category) }}
    </span>
    <h1 class="fw-bold mb-2">{{ $article->title }}</h1>
    <p class="text-muted small mb-4">
        <i class="bi bi-calendar3"></i> {{ $article->published_at?->format('d F Y') }}
        @if($article->author)
            &nbsp;&bull;&nbsp; <i class="bi bi-person"></i> {{ $article->author->name }}
        @endif
    </p>

    <div class="lead text-muted mb-4">{{ $article->excerpt }}</div>

    <hr class="mb-4">

    <div class="article-content" style="line-height:1.9; font-size:1rem;">
        {!! nl2br(e($article->content)) !!}
    </div>

    <hr class="mt-5 mb-3">
    <a href="{{ route('articles.index') }}" class="btn btn-outline-success">
        <i class="bi bi-grid-3x3-gap"></i> Lihat Artikel Lainnya
    </a>
</div>
@endsection
