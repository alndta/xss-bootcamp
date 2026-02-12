{{-- ============================================ --}}
{{-- VULNERABLE SEARCH PAGE --}}
{{-- ⚠️ JANGAN GUNAKAN DI PRODUCTION! --}}
{{-- ============================================ --}}

@extends('layouts.app')

@section('title', 'Vulnerable Search')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('xss-lab.index') }}">XSS Lab</a></li>
            <li class="breadcrumb-item active">Vulnerable Search</li>
        </ol>
    </nav>

    <div class="alert alert-danger">
        <h5><i class="bi bi-exclamation-triangle"></i> ⚠️ HALAMAN VULNERABLE</h5>
        <p class="mb-0">
            Halaman ini <strong>SENGAJA</strong> dibuat vulnerable untuk demonstrasi XSS.
            Query pencarian ditampilkan menggunakan <code>&#123;!! !!&#125;</code> tanpa escaping!
        </p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-search"></i> Pencarian (VULNERABLE)
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Form Pencarian --}}
                    <form action="{{ route('vulnerable.search') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari sesuatu..."
                                   value="{{ $query }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-search"></i> Cari
                            </button>
                        </div>
                    </form>

                    {{-- ❌ VULNERABLE CODE! User input di-render tanpa escape --}}
                    @if($query)
                        <div class="alert alert-secondary">
                            <strong>Hasil pencarian untuk:</strong>
                            {!! $query !!}
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

            {{-- Penjelasan Kode Vulnerable --}}
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0"><i class="bi bi-code-slash"></i> Kode Vulnerable</h6>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code>&lt;!-- ❌ VULNERABLE CODE --&gt;
&lt;div class="alert"&gt;
    Hasil pencarian untuk: &#123;!! $query !!&#125;
&lt;/div&gt;

&lt;!-- $query langsung dari user tanpa escaping! --&gt;
&lt;!-- Jika user memasukkan: &lt;script&gt;alert('XSS')&lt;/script&gt; --&gt;
&lt;!-- Script akan DIEKSEKUSI oleh browser! --&gt;</code></pre>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Cara Testing --}}
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-lightbulb"></i> Cara Testing XSS</h6>
                </div>
                <div class="card-body">
                    <p>Coba masukkan payload berikut di form pencarian:</p>
                    
                    <div class="mb-2">
                        <small class="text-muted">Basic Script:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Image onerror:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;img src=x onerror=alert('XSS')&gt;</code>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">SVG onload:</small>
                        <code class="d-block bg-light p-2 rounded">&lt;svg onload=alert('XSS')&gt;</code>
                    </div>
                    
                    <hr>
                    <p class="small text-danger mb-0">
                        <i class="bi bi-exclamation-circle"></i>
                        Jika muncul alert popup, berarti XSS <strong>berhasil dieksekusi</strong>!
                    </p>
                </div>
            </div>

            {{-- Link ke versi secure --}}
            <div class="card mt-3 border-success">
                <div class="card-body text-center">
                    <p class="mb-2">Lihat versi yang sudah diperbaiki:</p>
                    <a href="{{ route('secure.search') }}" class="btn btn-success">
                        <i class="bi bi-shield-check"></i> Versi Secure
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
