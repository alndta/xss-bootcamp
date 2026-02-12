# 🚀 Panduan Implementasi Hari 4 - Blade Templating & XSS Prevention

## Prasyarat

- Sudah menyelesaikan praktik Hari 3 (CRUD Tickets)
- Laravel project sudah berjalan

## Langkah 1: Copy Migration dan Model

### 1.1 Migration Comments
Copy file `database/migrations/2024_01_02_000000_create_comments_table.php` ke folder migrations Anda.

Rename dengan tanggal yang benar:
```bash
# Contoh rename
mv 2024_01_02_000000_create_comments_table.php 2024_01_16_100000_create_comments_table.php
```

Jalankan migration:
```bash
php artisan migrate
```

### 1.2 Model Comment
Copy `app/Models/Comment.php` ke folder `app/Models/`

Tambahkan relasi di `app/Models/Ticket.php`:
```php
// Di class Ticket, tambahkan method:
public function comments()
{
    return $this->hasMany(Comment::class);
}
```

## Langkah 2: Copy Controllers

Copy kedua controller ke `app/Http/Controllers/`:
- `DemoBladeController.php`
- `XSSLabController.php`

## Langkah 3: Copy Routes

Buka `routes/web.php` dan tambahkan:

```php
use App\Http\Controllers\DemoBladeController;
use App\Http\Controllers\XSSLabController;

// Demo Blade Templating
Route::prefix('demo-blade')->name('demo-blade.')->group(function () {
    Route::get('/', [DemoBladeController::class, 'index'])->name('index');
    Route::get('/directives', [DemoBladeController::class, 'directives'])->name('directives');
    Route::get('/components', [DemoBladeController::class, 'components'])->name('components');
    Route::get('/includes', [DemoBladeController::class, 'includes'])->name('includes');
    Route::get('/stacks', [DemoBladeController::class, 'stacks'])->name('stacks');
});

// XSS Lab
Route::prefix('xss-lab')->name('xss-lab.')->group(function () {
    Route::get('/', [XSSLabController::class, 'index'])->name('index');
    Route::post('/reset-comments', [XSSLabController::class, 'resetComments'])->name('reset-comments');
    
    // Reflected XSS
    Route::get('/reflected/vulnerable', [XSSLabController::class, 'reflectedVulnerable'])->name('reflected.vulnerable');
    Route::get('/reflected/secure', [XSSLabController::class, 'reflectedSecure'])->name('reflected.secure');
    
    // Stored XSS
    Route::get('/stored/vulnerable', [XSSLabController::class, 'storedVulnerable'])->name('stored.vulnerable');
    Route::post('/stored/vulnerable', [XSSLabController::class, 'storedVulnerableStore'])->name('stored.vulnerable.store');
    Route::get('/stored/secure', [XSSLabController::class, 'storedSecure'])->name('stored.secure');
    Route::post('/stored/secure', [XSSLabController::class, 'storedSecureStore'])->name('stored.secure.store');
    
    // DOM-Based XSS
    Route::get('/dom/vulnerable', [XSSLabController::class, 'domVulnerable'])->name('dom.vulnerable');
    Route::get('/dom/secure', [XSSLabController::class, 'domSecure'])->name('dom.secure');
});
```

## Langkah 4: Copy Components

Buat folder dan copy components:
```bash
mkdir -p resources/views/components
```

Copy files:
- `resources/views/components/alert.blade.php`
- `resources/views/components/badge.blade.php`
- `resources/views/components/card.blade.php`
- `resources/views/components/ticket-card.blade.php`

## Langkah 5: Copy Partials

Copy partials tambahan:
- `resources/views/partials/ticket-row.blade.php`
- `resources/views/partials/no-tickets.blade.php`

## Langkah 6: Copy Demo Blade Views

```bash
mkdir -p resources/views/demo-blade
```

Copy files:
- `resources/views/demo-blade/index.blade.php`
- `resources/views/demo-blade/directives.blade.php`
- `resources/views/demo-blade/components.blade.php`
- `resources/views/demo-blade/includes.blade.php`
- `resources/views/demo-blade/stacks.blade.php`

## Langkah 7: Copy XSS Lab Views

```bash
mkdir -p resources/views/xss-lab/vulnerable
mkdir -p resources/views/xss-lab/secure
```

Copy files:
- `resources/views/xss-lab/index.blade.php`
- `resources/views/xss-lab/vulnerable/reflected.blade.php`
- `resources/views/xss-lab/vulnerable/stored.blade.php`
- `resources/views/xss-lab/vulnerable/dom-based.blade.php`
- `resources/views/xss-lab/secure/reflected.blade.php`
- `resources/views/xss-lab/secure/stored.blade.php`
- `resources/views/xss-lab/secure/dom-based.blade.php`

## Langkah 8: Update Layout

Pastikan layout `resources/views/layouts/app.blade.php` memiliki `@stack`:

```blade
<head>
    ...
    @stack('styles')
</head>
<body>
    ...
    @stack('scripts')
</body>
```

## Langkah 9: Jalankan Aplikasi

```bash
php artisan serve
```

## 🎯 URL yang Tersedia

### Demo Blade Templating
| URL | Deskripsi |
|-----|-----------|
| `/demo-blade` | Menu utama demo Blade |
| `/demo-blade/directives` | Demo @if, @foreach, $loop |
| `/demo-blade/components` | Demo x-alert, x-card |
| `/demo-blade/includes` | Demo @include, @each |
| `/demo-blade/stacks` | Demo @push, @stack |

### XSS Lab
| URL | Deskripsi |
|-----|-----------|
| `/xss-lab` | Menu utama XSS Lab |
| `/xss-lab/reflected/vulnerable` | Reflected XSS - Vulnerable |
| `/xss-lab/reflected/secure` | Reflected XSS - Secure |
| `/xss-lab/stored/vulnerable` | Stored XSS - Vulnerable |
| `/xss-lab/stored/secure` | Stored XSS - Secure |
| `/xss-lab/dom/vulnerable` | DOM-Based XSS - Vulnerable |
| `/xss-lab/dom/secure` | DOM-Based XSS - Secure |

## 🧪 Payload untuk Testing XSS

### Basic Payloads
```html
<script>alert('XSS')</script>
<img src=x onerror=alert('XSS')>
<svg onload=alert('XSS')>
<body onload=alert('XSS')>
<input onfocus=alert('XSS') autofocus>
```

### Cookie Stealing (untuk demo)
```html
<script>alert(document.cookie)</script>
<img src=x onerror=alert(document.cookie)>
```

## ⚠️ PERINGATAN PENTING

1. **Halaman vulnerable HANYA untuk pembelajaran**
2. **JANGAN deploy ke production**
3. **JANGAN gunakan teknik ini untuk menyerang website lain**
4. **Selalu gunakan `{{ }}` untuk output user input**

## 📝 Checklist Praktik

### Demo Blade Templating
- [ ] Akses `/demo-blade/directives` - lihat cara kerja @if, @foreach, $loop
- [ ] Akses `/demo-blade/components` - lihat cara pakai x-alert, x-card
- [ ] Akses `/demo-blade/includes` - lihat cara @include, @each
- [ ] Akses `/demo-blade/stacks` - klik button untuk lihat JavaScript berjalan

### XSS Lab
- [ ] Test Reflected XSS Vulnerable dengan payload `<script>alert('XSS')</script>`
- [ ] Test Reflected XSS Secure dengan payload yang sama (harusnya aman)
- [ ] Test Stored XSS Vulnerable dengan submit comment berbahaya
- [ ] Test Stored XSS Secure dengan payload yang sama (harusnya aman)
- [ ] Test DOM-Based XSS dengan klik link payload
- [ ] Bandingkan versi vulnerable vs secure

## 🔐 Key Takeaways

1. **Selalu gunakan `{{ }}` untuk output** - Blade auto-escape mencegah XSS
2. **Hindari `{!! !!}` untuk user input** - Ini bypass escaping
3. **Gunakan `textContent` bukan `innerHTML`** - Untuk JavaScript
4. **Validasi input di server** - Defense in depth
5. **Escape output, bukan input** - Encoding context-aware
