<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * VulnerableSearchController
 * 
 * ⚠️ DEMO ONLY - Controller untuk demonstrasi XSS vulnerability
 * JANGAN GUNAKAN POLA INI DI PRODUCTION!
 */
class VulnerableSearchController extends Controller
{
    /**
     * Halaman search VULNERABLE - menggunakan {!! !!}
     * ❌ User input langsung di-render tanpa escape
     */
    public function search(Request $request): View
    {
        $query = $request->input('q', '');

        return view('vulnerable.search', [
            'query' => $query,
        ]);
    }

    /**
     * Halaman search SECURE - menggunakan {{ }}
     * ✅ User input di-escape otomatis oleh Blade
     */
    public function secureSearch(Request $request): View
    {
        $query = $request->input('q', '');

        return view('secure.search', [
            'query' => $query,
        ]);
    }
}
