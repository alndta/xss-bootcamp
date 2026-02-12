{{-- ============================================ --}}
{{-- SECURE SEARCH PAGE --}}
{{-- ✅ Versi yang sudah diamankan --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Secure Search')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Secure Search</li>
        </ol>
    </nav>

    <div class="alert alert-success">
        <h5><i class="bi bi-shield-check"></i> ✅ HALAMAN SECURE</h5>
        <p class="mb-0">
            Halaman ini menggunakan <code>&#123;&#123; &#125;&#125;</code> (Blade auto-escape) untuk menampilkan input user.
            Script berbahaya akan ditampilkan sebagai <strong>teks biasa</strong>.
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-search"></i> Pencarian (SECURE)
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('secure.search') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari sesuatu..."
                                   value="{{ $query }}">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- ✅ SECURE CODE! Menggunakan auto-escape --}}
                    @if($query)
                        <div class="alert alert-secondary">
                            <strong>Hasil pencarian untuk:</strong>
                            {{ $query }}
                        </div>

                        <p class="text-muted">
                            <i class="bi bi-info-circle"></i> 
                            Tidak ada hasil ditemukan — ini hanya demo pencarian.
                        </p>
                    @else
                        <p class="text-muted text-center">
                            <i class="bi bi-search"></i> Masukkan kata pencarian di atas.
                        </p>
                    @endif
                </div>
            </div>

            {{-- Penjelasan Kode Secure --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Secure</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>&lt;!-- ✅ SECURE CODE --&gt;
&lt;div class="alert"&gt;
    Hasil pencarian untuk: &#123;&#123; $query &#125;&#125;
&lt;/div&gt;

&lt;!-- Blade otomatis memanggil htmlspecialchars() --&gt;
&lt;!-- Jika user memasukkan: &lt;script&gt;alert('XSS')&lt;/script&gt; --&gt;
&lt;!-- Output: &amp;lt;script&amp;gt;alert('XSS')&amp;lt;/script&amp;gt; --&gt;
&lt;!-- Browser menampilkan sebagai TEKS, tidak dieksekusi! --&gt;</code></pre>
                </div>
            </div>

            {{-- Perbandingan --}}
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="bi bi-arrow-left-right"></i> Perbandingan Vulnerable vs Secure</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-danger">❌ Vulnerable:</h6>
                            <pre class="bg-light p-2 rounded"><code>&#123;!! $query !!&#125;</code></pre>
                            <p class="small text-muted">
                                User input langsung di-render sebagai HTML tanpa escape
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">✅ Secure:</h6>
                            <pre class="bg-light p-2 rounded"><code>&#123;&#123; $query &#125;&#125;</code></pre>
                            <p class="small text-muted">
                                Blade auto-escape mencegah eksekusi script berbahaya
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Cara Testing --}}
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Cara Testing</h6>
                </div>
                <div class="card-body">
                    <p>Coba masukkan payload yang sama:</p>
                    
                    <div class="mb-2">
                        <code class="d-block bg-light p-2 rounded">&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                    </div>
                    
                    <hr>
                    
                    <p class="small text-success mb-0">
                        <i class="bi bi-check-circle"></i>
                        Script akan ditampilkan sebagai <strong>TEKS</strong>, 
                        bukan dieksekusi!
                    </p>
                </div>
            </div>

            {{-- Link ke versi vulnerable --}}
            <div class="card mt-3 border-danger">
                <div class="card-body text-center">
                    <p class="mb-2">Bandingkan dengan versi vulnerable:</p>
                    <a href="{{ route('vulnerable.search') }}" class="btn btn-outline-danger">
                        <i class="bi bi-unlock"></i> Versi Vulnerable
                    </a>
                </div>
            </div>

            {{-- Best Practices --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-bookmark"></i> Best Practices</h6>
                </div>
                <div class="card-body small">
                    <ul class="mb-0">
                        <li>Selalu gunakan <code>&#123;&#123; &#125;&#125;</code> untuk menampilkan data user</li>
                        <li>Hindari <code>&#123;!! !!&#125;</code> untuk user input</li>
                        <li>Validasi input di server-side</li>
                        <li>Sanitasi dengan <code>strip_tags()</code> atau <code>e()</code></li>
                        <li>Gunakan Content Security Policy (CSP)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
