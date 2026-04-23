@extends('layouts.app')
@section('title', 'Artikel Kesehatan')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-1">Artikel & Berita Kesehatan</h4>
    <p class="text-muted small mb-4">Informasi terpercaya seputar kesehatan dan kebugaran</p>

    <!-- Category Filter -->
    <div class="mb-4 d-flex flex-wrap gap-2">
        <a href="{{ route('articles.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-secondary' }}">Semua</a>
        @foreach(\App\Models\Article::categories() as $val => $label)
        <a href="{{ route('articles.index', ['category' => $val]) }}" class="btn btn-sm {{ request('category')==$val ? 'btn-success' : 'btn-outline-secondary' }}">{{ $label }}</a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    <div class="row g-4">
        @forelse($articles as $article)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                @if($article->image)
                <img src="{{ $article->image }}" class="card-img-top" style="height:180px; object-fit:cover;" alt="{{ $article->title }}">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                    <i class="bi bi-newspaper text-muted" style="font-size:2.5rem; opacity:.3;"></i>
                </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="badge bg-success bg-opacity-10 text-success small">
                            {{ \App\Models\Article::categories()[$article->category] ?? ucfirst($article->category) }}
                        </span>
                    </div>
                    <h6 class="fw-semibold mb-2">{{ $article->title }}</h6>
                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($article->excerpt, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted" style="font-size:.75rem;">
                            {{ $article->published_at?->format('d M Y') }}
                        </span>
                        <a href="{{ route('articles.show', $article->slug) }}" class="btn btn-sm btn-outline-success">Baca</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5 text-muted">
                <i class="bi bi-newspaper d-block mb-2" style="font-size:2.5rem; opacity:.25;"></i>
                Belum ada artikel
            </div>
        </div>
        @endforelse
    </div>

    @if($articles->hasPages())
    <div class="mt-4 d-flex justify-content-center">{{ $articles->links('pagination::bootstrap-5') }}</div>
    @endif
</div>
@endsection
