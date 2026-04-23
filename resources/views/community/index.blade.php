@extends('layouts.app')
@section('title', 'Komunitas')

@section('content')
<div class="container-fluid py-4">
    <h4 class="fw-bold mb-1">Komunitas FitLife</h4>
    <p class="text-muted small mb-4">Berbagi cerita dan motivasi bersama sesama pengguna</p>

    <div class="row g-4">
        <!-- Post Form -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-3 pb-0">
                    <h6 class="fw-semibold mb-0">Tulis Post</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('community.store') }}">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" rows="5" required maxlength="1000"
                                      class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Bagikan pengalaman, tips, atau motivasi kamu...">{{ old('content') }}</textarea>
                            @error('content')<div class="invalid-feedback small">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-sm">
                            <i class="bi bi-send"></i> Kirim Post
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Posts Feed -->
        <div class="col-lg-8">
            @forelse($posts as $post)
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:40px; height:40px; font-size:.85rem; font-weight:600;">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="fw-semibold small">{{ $post->user->name }}</span>
                                <span class="text-muted" style="font-size:.75rem;">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mb-0" style="white-space:pre-wrap; font-size:.9rem;">{{ $post->content }}</p>
                        </div>
                        @if($post->user_id === Auth::id())
                        <form method="POST" action="{{ route('community.destroy', $post->id) }}" onsubmit="return confirm('Hapus post ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger py-0 px-2"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-people d-block mb-2" style="font-size:2.5rem; opacity:.25;"></i>
                Belum ada post. Jadilah yang pertama!
            </div>
            @endforelse

            @if($posts->hasPages())
            <div class="mt-2">{{ $posts->links('pagination::bootstrap-5') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
