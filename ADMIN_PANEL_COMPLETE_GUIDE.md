# Admin Panel Implementation Guide - Complete
## Catering Antipasti Web Sitesi İçin Hafif Admin Panel Sistemi

**Versiyon:** 2.0  
**Tarih:** 14 Kasım 2024  
**Geliştirici:** Cüneyt Kaya

---

## 📋 İçindekiler

1. [Genel Bakış](#1-genel-bakış)
2. [Dosya Yapısı](#2-dosya-yapısı)
3. [Güvenlik Sistemi](#3-güvenlik-sistemi)
4. [Renk Paleti Yönetimi](#4-renk-paleti-yönetimi)
5. [Menü Yönetimi](#5-menü-yönetimi)
6. [Blog Yönetimi](#6-blog-yönetimi)
7. [Logo Yönetimi](#7-logo-yönetimi)
8. [Genel Ayarlar](#8-genel-ayarlar)
9. [Helper Fonksiyonlar](#9-helper-fonksiyonlar)
10. [Kurulum Adımları](#10-kurulum-adımları)
11. [Güvenlik Best Practices](#11-güvenlik-best-practices)
12. [Testing & Troubleshooting](#12-testing--troubleshooting)

---

## 1. Genel Bakış

Bu dokümanda, Catering Antipasti web sitesi için hafif (lightweight) bir admin panel sistemi kurulumu anlatılmaktadır. 

### 1.1 Özellikler

- ✅ Güvenli login sistemi (session-based)
- ✅ Renk paleti yönetimi (real-time preview)
- ✅ Menü yönetimi (preset + custom)
- ✅ Blog yönetimi (WYSIWYG editor)
- ✅ Logo upload sistemi
- ✅ Dosya tabanlı (JSON) - Database gereksiz
- ✅ CSRF koruması
- ✅ Activity logging
- ✅ Session timeout (30 dakika)
- ✅ Automatic backup system

### 1.2 Teknik Stack

- **Backend:** PHP 7.4+
- **Frontend:** Tailwind CSS 3.x
- **Editor:** TinyMCE (WYSIWYG)
- **Data Storage:** JSON files
- **Security:** Session-based auth, CSRF tokens

### 1.3 Sistem Gereksinimleri

- PHP 7.4 veya üzeri
- Apache/Nginx web server
- `mod_rewrite` aktif (Apache için)
- `file_put_contents` ve `file_get_contents` izinleri
- En az 50MB disk alanı

---

## 2. Dosya Yapısı

### 2.1 Tam Dizin Yapısı

```
proje-root/
│
├── admin/                              ← YENİ KLASÖR
│   ├── index.php                       ← Dashboard
│   ├── login.php                       ← Login sayfası
│   ├── logout.php                      ← Logout
│   ├── setup.php                       ← İlk kurulum (tek kullanımlık)
│   │
│   ├── colors.php                      ← Renk yönetimi
│   ├── colors-save.php                 ← Renk kaydetme
│   │
│   ├── menus.php                       ← Menü listesi
│   ├── menu-edit.php                   ← Menü düzenleme
│   ├── menu-new.php                    ← Yeni menü
│   ├── menu-save.php                   ← Menü kaydetme
│   ├── menu-delete.php                 ← Menü silme
│   │
│   ├── blog.php                        ← Blog listesi
│   ├── blog-new.php                    ← Yeni blog yazısı
│   ├── blog-edit.php                   ← Blog düzenleme
│   ├── blog-save.php                   ← Blog kaydetme
│   ├── blog-delete.php                 ← Blog silme
│   │
│   ├── logo.php                        ← Logo yönetimi
│   ├── logo-upload.php                 ← Logo upload
│   │
│   ├── images.php                      ← Görsel galerisi
│   ├── images-upload.php               ← Görsel upload
│   │
│   ├── settings.php                    ← Genel ayarlar
│   ├── settings-save.php               ← Ayarları kaydet
│   │
│   ├── /includes/
│   │   ├── auth.php                    ← Auth middleware
│   │   ├── helpers.php                 ← Helper fonksiyonlar
│   │   ├── header.php                  ← Admin header
│   │   └── footer.php                  ← Admin footer
│   │
│   ├── /assets/
│   │   ├── admin.css                   ← Admin panel CSS
│   │   └── admin.js                    ← Admin panel JS
│   │
│   └── .htaccess                       ← Admin güvenlik
│
├── data/                               ← GÜNCELLENMİŞ
│   ├── menus.json                      (mevcut)
│   ├── blog-posts.json                 (mevcut)
│   ├── references.json                 (mevcut)
│   ├── palettes.json                   ← YENİ
│   ├── settings.json                   ← YENİ
│   └── users.json                      ← YENİ (admin kullanıcıları)
│
├── logs/                               ← YENİ KLASÖR
│   ├── admin-access.log                ← Login logları
│   ├── admin-failed-logins.log         ← Başarısız denemeler
│   ├── admin-changes.log               ← Yapılan değişiklikler
│   └── .htaccess                       ← Log dosyalarını koru
│
└── assets/
    └── css/
        └── custom.css                  ← Dinamik renkler (auto-generated)
```

### 2.2 Dosya İzinleri

```bash
# Klasör izinleri
chmod 755 admin/
chmod 755 admin/includes/
chmod 755 admin/assets/
chmod 755 data/
chmod 755 logs/

# Dosya izinleri
chmod 644 admin/*.php
chmod 644 admin/includes/*.php
chmod 644 data/*.json
chmod 644 logs/*.log

# Yazılabilir klasörler
chmod 755 data/
chmod 755 logs/
chmod 755 assets/uploads/
```

---

## 3. Güvenlik Sistemi

### 3.1 İlk Kurulum: Admin Kullanıcısı Oluşturma

**admin/setup.php** - Sadece ilk kurulumda çalışır:

```php
<?php
/**
 * SETUP SCRIPT - Sadece bir kez çalıştırın!
 * İlk admin kullanıcısını oluşturur
 * Kurulum sonrası bu dosyayı silin veya yeniden adlandırın
 */

// Eğer zaten kullanıcı varsa setup'ı engelle
$users_file = '../data/users.json';
if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true);
    if (!empty($users)) {
        die('⚠️ Setup zaten tamamlanmış. Bu dosyayı silin.');
    }
}

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // Validasyon
    if (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalı';
    } elseif (strlen($password) < 8) {
        $error = 'Şifre en az 8 karakter olmalı';
    } elseif ($password !== $password_confirm) {
        $error = 'Şifreler eşleşmiyor';
    } else {
        // Kullanıcıyı oluştur
        $user = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
            'last_login' => null
        ];
        
        // Kaydet
        $users = [$user];
        
        // Dizin yoksa oluştur
        if (!is_dir('../data')) {
            mkdir('../data', 0755, true);
        }
        
        file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
        
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Setup</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        
        <?php if ($success): ?>
            <!-- Başarı Mesajı -->
            <div class="text-center">
                <div class="text-6xl mb-4">✅</div>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">Kurulum Tamamlandı!</h1>
                <p class="text-gray-600 mb-6">Admin kullanıcınız başarıyla oluşturuldu.</p>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 text-left">
                    <p class="text-sm text-yellow-800 font-bold mb-2">⚠️ ÖNEMLİ GÜVENLİK UYARISI:</p>
                    <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                        <li>Bu <code class="bg-yellow-100 px-1 rounded">setup.php</code> dosyasını SİLİN</li>
                        <li>Veya dosyayı <code class="bg-yellow-100 px-1 rounded">setup.php.disabled</code> olarak yeniden adlandırın</li>
                    </ol>
                </div>
                
                <a href="login.php" 
                   class="block bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">
                    Admin Paneline Git →
                </a>
            </div>
        
        <?php else: ?>
            <!-- Setup Formu -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Panel Kurulumu</h1>
                <p class="text-gray-600">İlk admin kullanıcısını oluşturun</p>
            </div>
            
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Kullanıcı Adı
                    </label>
                    <input type="text" 
                           name="username" 
                           required 
                           minlength="3"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="hasan">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Şifre
                    </label>
                    <input type="password" 
                           name="password" 
                           required 
                           minlength="8"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="En az 8 karakter">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Şifre (Tekrar)
                    </label>
                    <input type="password" 
                           name="password_confirm" 
                           required 
                           minlength="8"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                           placeholder="Şifreyi tekrar girin">
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold text-lg">
                    Kurulumu Tamamla
                </button>
            </form>
        <?php endif; ?>
        
    </div>
</body>
</html>
```

### 3.2 Login Sistemi

**admin/login.php:**

```php
<?php
session_start();

// Zaten giriş yapmışsa dashboard'a yönlendir
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = null;

// Logout mesajı
if (isset($_GET['logout'])) {
    $success = 'Başarıyla çıkış yaptınız.';
}

// Timeout mesajı
if (isset($_GET['timeout'])) {
    $error = 'Oturumunuz zaman aşımına uğradı. Lütfen tekrar giriş yapın.';
}

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Kullanıcıları yükle
    $users_file = '../data/users.json';
    if (!file_exists($users_file)) {
        $error = 'Sistem henüz kurulmamış. Lütfen setup.php dosyasını çalıştırın.';
    } else {
        $users = json_decode(file_get_contents($users_file), true);
        
        // Kullanıcıyı bul
        $user = null;
        foreach ($users as $key => $u) {
            if ($u['username'] === $username) {
                $user = $u;
                $user_index = $key;
                break;
            }
        }
        
        // Şifre kontrolü
        if ($user && password_verify($password, $user['password'])) {
            // Başarılı giriş
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_role'] = $user['role'];
            $_SESSION['login_time'] = time();
            
            // CSRF token oluştur
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            
            // Son giriş zamanını güncelle
            $users[$user_index]['last_login'] = date('Y-m-d H:i:s');
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
            
            // Log
            $log_dir = '../logs';
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0755, true);
            }
            file_put_contents(
                $log_dir . '/admin-access.log',
                date('Y-m-d H:i:s') . " | LOGIN: {$username} | IP: {$_SERVER['REMOTE_ADDR']}\n",
                FILE_APPEND
            );
            
            // Yönlendir
            header('Location: index.php');
            exit;
            
        } else {
            // Başarısız giriş
            $error = 'Kullanıcı adı veya şifre hatalı!';
            
            // Failed login log
            file_put_contents(
                '../logs/admin-failed-logins.log',
                date('Y-m-d H:i:s') . " | FAILED: {$username} | IP: {$_SERVER['REMOTE_ADDR']}\n",
                FILE_APPEND
            );
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Catering Antipasti</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="text-5xl mb-4">🍽️</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Catering Antipasti</h1>
            <p class="text-gray-600">Admin Panel</p>
        </div>
        
        <!-- Success mesajı -->
        <?php if (isset($success)): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-4 mb-6">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <!-- Error mesajı -->
        <?php if ($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <!-- Login formu -->
        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Kullanıcı Adı
                </label>
                <input type="text" 
                       name="username" 
                       required 
                       autofocus
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                       placeholder="Kullanıcı adınızı girin">
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Şifre
                </label>
                <input type="password" 
                       name="password" 
                       required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition-colors"
                       placeholder="Şifrenizi girin">
            </div>
            
            <button type="submit" 
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 font-bold text-lg transition-all transform hover:scale-105">
                Giriş Yap
            </button>
        </form>
        
        <!-- Footer -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>&copy; <?= date('Y') ?> Catering Antipasti</p>
        </div>
        
    </div>
</body>
</html>
```

### 3.3 Auth Middleware

**admin/includes/auth.php:**

```php
<?php
/**
 * Auth Middleware
 * Her admin sayfasının başında include edilmeli
 */

// Session başlat
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Logout değilse orijinal URL'i kaydet
    if (basename($_SERVER['PHP_SELF']) !== 'logout.php') {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    }
    header('Location: login.php');
    exit;
}

// Session timeout kontrolü (30 dakika)
$timeout = 1800; // 30 dakika
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
    // Session'ı temizle
    session_unset();
    session_destroy();
    
    // Yeni session başlat ve timeout mesajı için
    session_start();
    header('Location: login.php?timeout=1');
    exit;
}

// Session'ı yenile
$_SESSION['login_time'] = time();

// CSRF token oluştur (yoksa)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * CSRF Token Doğrulama Fonksiyonu
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Activity Log Fonksiyonu
 */
function log_activity($action, $details = '') {
    $log_dir = __DIR__ . '/../../logs';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_entry = sprintf(
        "%s | %s | %s | %s | IP: %s\n",
        date('Y-m-d H:i:s'),
        $_SESSION['admin_username'] ?? 'unknown',
        $action,
        $details,
        $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    );
    
    file_put_contents($log_dir . '/admin-changes.log', $log_entry, FILE_APPEND);
}

/**
 * Admin sayfası için ortak değişkenler
 */
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$admin_username = $_SESSION['admin_username'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'user';
```

### 3.4 Logout

**admin/logout.php:**

```php
<?php
session_start();

// Log
if (isset($_SESSION['admin_username'])) {
    $log_dir = '../logs';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    file_put_contents(
        $log_dir . '/admin-access.log',
        date('Y-m-d H:i:s') . " | LOGOUT: {$_SESSION['admin_username']} | IP: {$_SERVER['REMOTE_ADDR']}\n",
        FILE_APPEND
    );
}

// Session'ı temizle
session_unset();
session_destroy();

// Login sayfasına yönlendir
header('Location: login.php?logout=1');
exit;
```

### 3.5 Admin .htaccess Güvenliği

**admin/.htaccess:**

```apache
# Admin Panel Güvenlik Ayarları

# Dizin listesini engelle
Options -Indexes

# PHP hatalarını gizle
php_flag display_errors Off

# Session güvenliği
php_value session.cookie_httponly 1
php_value session.cookie_secure 1
php_value session.use_strict_mode 1

# File upload limiti
php_value upload_max_filesize 5M
php_value post_max_size 8M

# IP Whitelist (opsiyonel - uncomment ve IP'ni ekle)
# Order Deny,Allow
# Deny from all
# Allow from 123.456.789.0

# Belirli dosyalara erişimi engelle
<Files "*.json">
    Order Allow,Deny
    Deny from all
</Files>

<Files "*.log">
    Order Allow,Deny
    Deny from all
</Files>
```

### 3.6 Logs .htaccess

**logs/.htaccess:**

```apache
Order deny,allow
Deny from all
```

---

## 4. Renk Paleti Yönetimi

### 4.1 İlk Kurulum: Palettes JSON

**data/palettes.json:**

```json
{
  "classic": {
    "olive": "#5C4A3C",
    "sangiovese": "#D4704A",
    "verona": "#F5E6D3",
    "terracotta": "#E8B944",
    "seagray": "#7A8C8E",
    "vineyard": "#3A5A40",
    "cream": "#F5E6D3"
  },
  "tuscan": {
    "olive": "#4A3B2B",
    "sangiovese": "#B8402A",
    "verona": "#F7E3C8",
    "terracotta": "#D79B49",
    "seagray": "#8A9A9C",
    "vineyard": "#2F5233",
    "cream": "#FCF1E1"
  },
  "coastal": {
    "olive": "#2E4A62",
    "sangiovese": "#D94F70",
    "verona": "#EFF6F9",
    "terracotta": "#F2AF29",
    "seagray": "#4D7D8C",
    "vineyard": "#1E3F2F",
    "cream": "#F9FBF2"
  }
}
```

### 4.2 Renk Yönetim Sayfası

**admin/colors.php:**

```php
<?php
require_once 'includes/auth.php';

// Paletleri yükle
$palettes_file = '../data/palettes.json';
if (!file_exists($palettes_file)) {
    // İlk kurulum için default paletleri oluştur
    $default_palettes = [
        'classic' => [
            'olive' => '#5C4A3C',
            'sangiovese' => '#D4704A',
            'verona' => '#F5E6D3',
            'terracotta' => '#E8B944',
            'seagray' => '#7A8C8E',
            'vineyard' => '#3A5A40',
            'cream' => '#F5E6D3'
        ],
        'tuscan' => [
            'olive' => '#4A3B2B',
            'sangiovese' => '#B8402A',
            'verona' => '#F7E3C8',
            'terracotta' => '#D79B49',
            'seagray' => '#8A9A9C',
            'vineyard' => '#2F5233',
            'cream' => '#FCF1E1'
        ],
        'coastal' => [
            'olive' => '#2E4A62',
            'sangiovese' => '#D94F70',
            'verona' => '#EFF6F9',
            'terracotta' => '#F2AF29',
            'seagray' => '#4D7D8C',
            'vineyard' => '#1E3F2F',
            'cream' => '#F9FBF2'
        ]
    ];
    
    if (!is_dir('../data')) {
        mkdir('../data', 0755, true);
    }
    file_put_contents($palettes_file, json_encode($default_palettes, JSON_PRETTY_PRINT));
    $palettes = $default_palettes;
} else {
    $palettes = json_decode(file_get_contents($palettes_file), true);
}

// Aktif paleti belirle
$active_palette = $_GET['palette'] ?? 'classic';
$current_colors = $palettes[$active_palette] ?? $palettes['classic'];

// Success mesajı
$success = isset($_GET['success']) ? 'Renkler başarıyla kaydedildi ve siteye uygulandı!' : null;

// Renk açıklamaları
$color_descriptions = [
    'olive' => 'Başlıklar ve ana metin rengi',
    'sangiovese' => 'CTA butonları ve vurgular',
    'verona' => 'Arka plan ve bölüm rengi',
    'terracotta' => 'İkincil vurgular ve border\'lar',
    'seagray' => 'Alt metinler ve açıklamalar',
    'vineyard' => 'Footer ve koyu bölümler',
    'cream' => 'Açık arka planlar'
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renk Yönetimi - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .color-picker-wrapper {
            display: flex;
            gap: 1rem;
            align-items: center;
            padding: 1.5rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: all 0.3s;
        }
        
        .color-picker-wrapper:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        
        .color-preview {
            width: 80px;
            height: 80px;
            border-radius: 0.5rem;
            border: 3px solid #e5e7eb;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .color-preview:hover {
            transform: scale(1.05);
            border-color: #3b82f6;
        }
        
        input[type="color"] {
            width: 0;
            height: 0;
            opacity: 0;
            position: absolute;
        }
        
        .palette-card {
            transition: all 0.3s;
        }
        
        .palette-card:hover {
            transform: translateY(-2px);
        }
        
        .palette-card.active {
            border-color: #3b82f6;
            background: #eff6ff;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'includes/header.php'; ?>
    
    <div class="container mx-auto py-8 px-4">
        <div class="max-w-5xl mx-auto">
            
            <!-- Başlık -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">🎨 Renk Paleti Yönetimi</h1>
                        <p class="text-gray-600">Site renklerini buradan değiştirebilirsiniz. Değişiklikler anında uygulanır.</p>
                    </div>
                    <a href="index.php" class="text-gray-600 hover:text-gray-800">
                        ← Dashboard'a Dön
                    </a>
                </div>
            </div>
            
            <!-- Success mesajı -->
            <?php if ($success): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 flex items-center gap-3 animate-fade-in">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Hazır Paletler -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Hazır Renk Paletleri</h2>
                <p class="text-gray-600 mb-6 text-sm">Hazır paletlerden birini seçin veya özel renkleri aşağıda düzenleyin.</p>
                
                <div class="grid md:grid-cols-3 gap-4">
                    <?php 
                    $palette_names = [
                        'classic' => 'Toskana Classic',
                        'tuscan' => 'Tuscan Sunset',
                        'coastal' => 'Coastal Blue'
                    ];
                    
                    foreach ($palettes as $name => $colors): 
                    ?>
                        <a href="?palette=<?= urlencode($name) ?>" 
                           class="palette-card block p-5 border-2 rounded-xl hover:shadow-md <?= $name === $active_palette ? 'active' : 'border-gray-200' ?>">
                            <h3 class="font-bold mb-3 text-gray-800">
                                <?= htmlspecialchars($palette_names[$name] ?? ucfirst($name)) ?>
                            </h3>
                            <div class="flex gap-2 flex-wrap">
                                <?php foreach ($colors as $color_name => $hex): ?>
                                    <div style="background: <?= htmlspecialchars($hex) ?>;" 
                                         class="w-12 h-12 rounded-lg shadow-sm"
                                         title="<?= htmlspecialchars($color_name) ?>"></div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($name === $active_palette): ?>
                                <div class="mt-3 text-sm text-blue-600 font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Aktif Palet
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Renk Düzenleyici -->
            <form method="POST" action="colors-save.php" id="color-form">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="palette_name" value="<?= htmlspecialchars($active_palette) ?>">
                
                <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Renkleri Özelleştir</h2>
                    
                    <div class="space-y-4">
                        <?php foreach ($current_colors as $name => $hex): ?>
                        <div class="color-picker-wrapper">
                            <!-- Renk önizleme -->
                            <label for="color-<?= $name ?>" class="cursor-pointer">
                                <div class="color-preview" 
                                     style="background-color: <?= htmlspecialchars($hex) ?>;" 
                                     id="preview-<?= $name ?>"></div>
                            </label>
                            
                            <!-- Gizli color input -->
                            <input type="color" 
                                   id="color-<?= $name ?>" 
                                   name="<?= $name ?>" 
                                   value="<?= htmlspecialchars($hex) ?>"
                                   onchange="updatePreview('<?= $name ?>', this.value)">
                            
                            <!-- Bilgiler -->
                            <div class="flex-1">
                                <h3 class="font-bold text-lg text-gray-800 capitalize mb-1">
                                    <?= htmlspecialchars($name) ?>
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">
                                    <?= htmlspecialchars($color_descriptions[$name] ?? 'Özel renk') ?>
                                </p>
                                <input type="text" 
                                       class="px-3 py-2 border border-gray-300 rounded-lg font-mono text-sm w-32 focus:outline-none focus:border-blue-500"
                                       value="<?= htmlspecialchars($hex) ?>"
                                       id="hex-<?= $name ?>"
                                       pattern="^#[a-fA-F0-9]{6}$"
                                       onchange="updateFromHex('<?= $name ?>', this.value)">
                            </div>
                            
                            <!-- Reset butonu -->
                            <button type="button" 
                                    class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors"
                                    onclick="resetColor('<?= $name ?>', '<?= $palettes['classic'][$name] ?? $hex ?>')"
                                    title="Classic palete sıfırla">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Canlı Önizleme -->
                <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Canlı Önizleme</h2>
                    
                    <div class="space-y-6" id="live-preview">
                        <!-- Buton örnekleri -->
                        <div>
                            <p class="text-sm text-gray-600 mb-3">CTA Butonları:</p>
                            <div class="flex gap-3 flex-wrap">
                                <button type="button" 
                                        class="preview-btn-primary px-6 py-3 rounded-lg font-semibold transition-transform hover:scale-105"
                                        style="background-color: <?= $current_colors['sangiovese'] ?>; 
                                               color: <?= $current_colors['cream'] ?>;">
                                    Primary Button
                                </button>
                                <button type="button" 
                                        class="preview-btn-secondary px-6 py-3 rounded-lg font-semibold border-2 transition-all"
                                        style="border-color: <?= $current_colors['terracotta'] ?>; 
                                               color: <?= $current_colors['olive'] ?>;">
                                    Secondary Button
                                </button>
                            </div>
                        </div>
                        
                        <!-- Başlık örnekleri -->
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Başlık ve Metin:</p>
                            <h2 class="preview-heading text-4xl font-bold mb-3"
                                style="color: <?= $current_colors['olive'] ?>;">
                                Beispiel Überschrift
                            </h2>
                            <p class="preview-text text-lg"
                               style="color: <?= $current_colors['seagray'] ?>;">
                                Dies ist ein Beispieltext. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        
                        <!-- Card örneği -->
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Kart Bileşeni:</p>
                            <div class="preview-card p-6 rounded-xl shadow-lg max-w-md" 
                                 style="background-color: <?= $current_colors['verona'] ?>; 
                                        border-left: 4px solid <?= $current_colors['terracotta'] ?>;">
                                <h3 class="text-xl font-bold mb-2" 
                                    style="color: <?= $current_colors['olive'] ?>;">
                                    Service Card
                                </h3>
                                <p class="text-sm mb-4" 
                                   style="color: <?= $current_colors['seagray'] ?>;">
                                    Dies ist eine Beispiel-Service-Karte mit allen Farbstilen.
                                </p>
                                <button type="button" 
                                        class="text-sm font-semibold"
                                        style="color: <?= $current_colors['sangiovese'] ?>;">
                                    Mehr erfahren →
                                </button>
                            </div>
                        </div>
                        
                        <!-- Footer örneği -->
                        <div>
                            <p class="text-sm text-gray-600 mb-3">Footer:</p>
                            <div class="preview-footer p-6 rounded-xl" 
                                 style="background-color: <?= $current_colors['vineyard'] ?>; 
                                        color: <?= $current_colors['cream'] ?>;">
                                <h4 class="font-bold mb-2">Footer Bereich</h4>
                                <p class="text-sm opacity-90">© 2024 Catering Antipasti. Alle Rechte vorbehalten.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Kaydet Butonu -->
                <div class="flex gap-4 sticky bottom-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                        💾 Kaydet ve Uygula
                    </button>
                    <a href="index.php" 
                       class="px-8 py-4 border-2 border-gray-300 rounded-xl hover:bg-gray-50 font-semibold text-gray-700 flex items-center justify-center transition-colors">
                        İptal
                    </a>
                </div>
            </form>
            
        </div>
    </div>
    
    <script>
        // Renk değiştiğinde önizlemeyi güncelle
        function updatePreview(name, color) {
            const preview = document.getElementById('preview-' + name);
            const hex = document.getElementById('hex-' + name);
            
            if (preview) preview.style.backgroundColor = color;
            if (hex) hex.value = color;
            
            updateLivePreview();
        }
        
        // Hex input'tan güncelle
        function updateFromHex(name, hex) {
            // Hex validasyonu
            if (!/^#[a-fA-F0-9]{6}$/i.test(hex)) {
                alert('Geçersiz hex renk formatı! Örnek: #FF5733');
                return;
            }
            
            const colorInput = document.getElementById('color-' + name);
            if (colorInput) colorInput.value = hex;
            
            updatePreview(name, hex);
        }
        
        // Rengi sıfırla
        function resetColor(name, defaultColor) {
            if (!confirm(`${name} rengini classic palete sıfırlamak istediğinizden emin misiniz?`)) {
                return;
            }
            
            document.getElementById('color-' + name).value = defaultColor;
            updatePreview(name, defaultColor);
        }
        
        // Canlı önizlemeyi güncelle
        function updateLivePreview() {
            const colors = {
                sangiovese: document.getElementById('color-sangiovese').value,
                cream: document.getElementById('color-cream').value,
                olive: document.getElementById('color-olive').value,
                seagray: document.getElementById('color-seagray').value,
                verona: document.getElementById('color-verona').value,
                terracotta: document.getElementById('color-terracotta').value,
                vineyard: document.getElementById('color-vineyard').value
            };
            
            // Butonlar
            const btnPrimary = document.querySelector('.preview-btn-primary');
            if (btnPrimary) {
                btnPrimary.style.backgroundColor = colors.sangiovese;
                btnPrimary.style.color = colors.cream;
            }
            
            const btnSecondary = document.querySelector('.preview-btn-secondary');
            if (btnSecondary) {
                btnSecondary.style.borderColor = colors.terracotta;
                btnSecondary.style.color = colors.olive;
            }
            
            // Başlık
            const heading = document.querySelector('.preview-heading');
            if (heading) heading.style.color = colors.olive;
            
            // Text
            const text = document.querySelector('.preview-text');
            if (text) text.style.color = colors.seagray;
            
            // Card
            const card = document.querySelector('.preview-card');
            if (card) {
                card.style.backgroundColor = colors.verona;
                card.style.borderLeftColor = colors.terracotta;
            }
            
            const cardHeading = document.querySelector('.preview-card h3');
            if (cardHeading) cardHeading.style.color = colors.olive;
            
            const cardText = document.querySelector('.preview-card p');
            if (cardText) cardText.style.color = colors.seagray;
            
            const cardLink = document.querySelector('.preview-card button');
            if (cardLink) cardLink.style.color = colors.sangiovese;
            
            // Footer
            const footer = document.querySelector('.preview-footer');
            if (footer) {
                footer.style.backgroundColor = colors.vineyard;
                footer.style.color = colors.cream;
            }
        }
        
        // Form submit öncesi onay
        document.getElementById('color-form').addEventListener('submit', function(e) {
            if (!confirm('Renk değişikliklerini kaydetmek ve siteye uygulamak istediğinizden emin misiniz?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
```

### 4.3 Renk Kaydetme Backend

**admin/colors-save.php:** - [UPDATEV2.md içindeki kodla aynı - ~200 satır]

---

## 5. Menü Yönetimi

### 5.1 Menü Listesi

**admin/menus.php:** - [Önceki mesajdaki kod - ~220 satır]

### 5.2 Yeni Menü Oluşturma

**admin/menu-new.php:** - [Önceki mesajdaki kod - ~200 satır]

### 5.3 Menü Kaydetme Backend

**admin/menu-save.php:** - [Önceki mesajdaki kod - ~120 satır]

### 5.4 Menü Düzenleme

**admin/menu-edit.php:** - [Önceki mesajdaki kod - ~180 satır]

### 5.5 Menü Silme

**admin/menu-delete.php:** - [Önceki mesajdaki kod - ~40 satır]

---

## 6. Blog Yönetimi

### 6.1 Blog Listesi

**admin/blog.php:**

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/helpers.php';

// Blog yazılarını yükle
$blog_file = '../data/blog-posts.json';
$blog_posts = read_json_file($blog_file, ['de' => [], 'en' => []]);

// Aktif dil
$lang = $_GET['lang'] ?? 'de';

// Success/Error mesajları
$success = show_success_message();
$error = show_error_message();

$page_title = 'Blog Yönetimi';
?>
<?php include 'includes/header.php'; ?>

<div class="container mx-auto py-8 px-4">
    <div class="max-w-7xl mx-auto">
        
        <!-- Başlık ve Filtreler -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">📝 Blog Yönetimi</h1>
                    <p class="text-gray-600">Blog yazılarınızı yönetin</p>
                </div>
                
                <a href="blog-new.php?lang=<?= $lang ?>" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-purple-700 font-semibold flex items-center gap-2 transition-all transform hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Yeni Yazı Ekle
                </a>
            </div>
            
            <!-- Dil Seçimi -->
            <div class="flex gap-2 bg-gray-100 p-1 rounded-lg w-fit">
                <a href="?lang=de" 
                   class="px-4 py-2 rounded-md font-semibold transition-colors <?= $lang === 'de' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600 hover:text-gray-800' ?>">
                    🇩🇪 Deutsch
                </a>
                <a href="?lang=en" 
                   class="px-4 py-2 rounded-md font-semibold transition-colors <?= $lang === 'en' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-600 hover:text-gray-800' ?>">
                    🇬🇧 English
                </a>
            </div>
        </div>
        
        <!-- Messages -->
        <?php if ($success): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Blog Listesi -->
        <?php
        $posts = $blog_posts[$lang] ?? [];
        
        if (empty($posts)):
        ?>
            <div class="bg-white p-12 rounded-xl shadow-sm text-center">
                <div class="text-6xl mb-4">✍️</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Henüz blog yazısı yok</h3>
                <p class="text-gray-600 mb-6">İlk blog yazınızı oluşturmak için yukarıdaki butona tıklayın.</p>
                <a href="blog-new.php?lang=<?= $lang ?>" 
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Yeni Yazı Ekle
                </a>
            </div>
        <?php else: ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($posts as $index => $post): ?>
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        
                        <!-- Görsel varsa göster -->
                        <?php if (!empty($post['image'])): ?>
                            <div class="h-48 bg-cover bg-center" 
                                 style="background-image: url('<?= htmlspecialchars($post['image']) ?>');"></div>
                        <?php else: ?>
                            <div class="h-48 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                <span class="text-6xl">📝</span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- İçerik -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2">
                                <?= htmlspecialchars($post['title']) ?>
                            </h3>
                            
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                <?= htmlspecialchars($post['excerpt'] ?? strip_tags($post['content'])) ?>
                            </p>
                            
                            <!-- Meta -->
                            <div class="flex items-center gap-3 mb-4 text-xs text-gray-500">
                                <span>📅 <?= format_date($post['date'], $lang) ?></span>
                                <span>•</span>
                                <span>👤 <?= htmlspecialchars($post['author'] ?? 'Admin') ?></span>
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-4">
                                <?php if ($post['published'] ?? true): ?>
                                    <span class="inline-flex items-center gap-1 text-xs bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                        Yayında
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full">
                                        <span class="w-2 h-2 bg-gray-500 rounded-full"></span>
                                        Taslak
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="blog-edit.php?lang=<?= $lang ?>&index=<?= $index ?>" 
                                   class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                                    ✏️ Düzenle
                                </a>
                                <button onclick="deletePost('<?= $lang ?>', <?= $index ?>)" 
                                        class="px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    🗑️
                                </button>
                            </div>
                        </div>
                        
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<script>
function deletePost(lang, index) {
    if (!confirm('Bu blog yazısını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'blog-delete.php';
    
    const inputs = {
        'csrf_token': '<?= $_SESSION['csrf_token'] ?>',
        'lang': lang,
        'index': index
    };
    
    for (const [name, value] of Object.entries(inputs)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}
</script>

<?php include 'includes/footer.php'; ?>
```

### 6.2 Yeni Blog Yazısı

**admin/blog-new.php:**

```php
<?php
require_once 'includes/auth.php';
$lang = $_GET['lang'] ?? 'de';
$page_title = 'Yeni Blog Yazısı';
?>
<?php include 'includes/header.php'; ?>

<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Başlık -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">✍️ Yeni Blog Yazısı</h1>
                    <p class="text-gray-600">
                        <?= $lang === 'de' ? '🇩🇪 Deutsch' : '🇬🇧 English' ?>
                    </p>
                </div>
                <a href="blog.php?lang=<?= $lang ?>" 
                   class="text-gray-600 hover:text-gray-800">
                    ← Geri Dön
                </a>
            </div>
        </div>
        
        <!-- Form -->
        <form method="POST" action="blog-save.php" enctype="multipart/form-data" id="blog-form">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="lang" value="<?= htmlspecialchars($lang) ?>">
            <input type="hidden" name="action" value="create">
            
            <!-- Temel Bilgiler -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Temel Bilgiler</h2>
                
                <div class="space-y-4">
                    <!-- Başlık -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Başlık *</label>
                        <input type="text" 
                               name="title" 
                               required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                               placeholder="z.B. Die besten Antipasti für Ihre Veranstaltung">
                    </div>
                    
                    <!-- Slug (auto-generate edilecek) -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">URL Slug *</label>
                        <input type="text" 
                               name="slug" 
                               required 
                               pattern="[a-z0-9-]+"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 font-mono"
                               placeholder="die-besten-antipasti">
                        <p class="text-xs text-gray-500 mt-1">Sadece küçük harf, rakam ve tire (-) kullanın</p>
                    </div>
                    
                    <!-- Excerpt -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Özet</label>
                        <textarea name="excerpt" 
                                  rows="3"
                                  maxlength="200"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                  placeholder="Kısa özet (max 200 karakter)"></textarea>
                    </div>
                    
                    <!-- Kapak Görseli -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kapak Görseli</label>
                        <input type="file" 
                               name="image" 
                               accept="image/*"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Max 5MB - JPG, PNG, WebP</p>
                    </div>
                    
                    <!-- Yazar -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Yazar</label>
                        <input type="text" 
                               name="author" 
                               value="<?= htmlspecialchars($admin_username) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <!-- Tarih -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Yayın Tarihi *</label>
                        <input type="date" 
                               name="date" 
                               required 
                               value="<?= date('Y-m-d') ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <!-- Durum -->
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="published" 
                                   value="1"
                                   checked
                                   class="w-5 h-5 text-blue-600 rounded">
                            <span class="text-gray-700 font-semibold">Hemen yayınla</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- İçerik -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">İçerik</h2>
                
                <textarea name="content" 
                          id="blog-content" 
                          rows="20"
                          class="w-full"></textarea>
            </div>
            
            <!-- Kaydet Butonu -->
            <div class="flex gap-4 sticky bottom-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-[1.02]">
                    💾 Yazıyı Kaydet
                </button>
                <a href="blog.php?lang=<?= $lang ?>" 
                   class="px-8 py-4 border-2 border-gray-300 rounded-xl hover:bg-gray-50 font-semibold text-gray-700 flex items-center justify-center transition-colors">
                    İptal
                </a>
            </div>
        </form>
        
    </div>
</div>

<!-- TinyMCE WYSIWYG Editor -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#blog-content',
    height: 500,
    menubar: false,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
    content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 16px; }'
});

// Başlıktan otomatik slug oluştur
document.querySelector('input[name="title"]').addEventListener('input', function(e) {
    const title = e.target.value;
    const slugInput = document.querySelector('input[name="slug"]');
    
    // Eğer slug manuel değiştirilmemişse otomatik oluştur
    if (!slugInput.dataset.manuallyEdited) {
        let slug = title.toLowerCase();
        
        // Almanca karakterleri değiştir
        const replacements = {
            'ä': 'ae', 'ö': 'oe', 'ü': 'ue', 'ß': 'ss',
            'Ä': 'ae', 'Ö': 'oe', 'Ü': 'ue'
        };
        
        for (const [from, to] of Object.entries(replacements)) {
            slug = slug.replace(new RegExp(from, 'g'), to);
        }
        
        // Özel karakterleri temizle
        slug = slug.replace(/[^a-z0-9\s-]/g, '');
        slug = slug.replace(/[\s-]+/g, '-');
        slug = slug.replace(/^-+|-+$/g, '');
        
        slugInput.value = slug;
    }
});

// Slug manuel düzenlendiğinde işaretle
document.querySelector('input[name="slug"]').addEventListener('input', function() {
    this.dataset.manuallyEdited = 'true';
});
</script>

<?php include 'includes/footer.php'; ?>
```

### 6.3 Blog Kaydetme

**admin/blog-save.php:**

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/helpers.php';

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
    set_error_message('Güvenlik hatası!');
    header('Location: blog.php');
    exit;
}

$lang = $_POST['lang'] ?? 'de';
$action = $_POST['action'] ?? 'create';
$index = $_POST['index'] ?? null;

// Validasyon
$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$excerpt = trim($_POST['excerpt'] ?? '');
$content = $_POST['content'] ?? '';
$author = trim($_POST['author'] ?? 'Admin');
$date = $_POST['date'] ?? date('Y-m-d');
$published = isset($_POST['published']);

if (empty($title)) {
    set_error_message('Başlık boş olamaz!');
    header("Location: blog.php?lang={$lang}");
    exit;
}

if (empty($slug)) {
    set_error_message('URL slug boş olamaz!');
    header("Location: blog.php?lang={$lang}");
    exit;
}

// Görsel upload
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload_result = handle_file_upload(
        $_FILES['image'],
        '../assets/uploads/blog',
        ['jpg', 'jpeg', 'png', 'webp']
    );
    
    if ($upload_result['success']) {
        $image_path = '/assets/uploads/blog/' . $upload_result['filename'];
        
        // Görseli optimize et
        optimize_image('../assets/uploads/blog/' . $upload_result['filename'], 1200, 85);
    }
}

// Eğer excerpt yoksa content'ten oluştur
if (empty($excerpt)) {
    $excerpt = substr(strip_tags($content), 0, 200);
}

// Post objesi
$post = [
    'title' => $title,
    'slug' => $slug,
    'excerpt' => $excerpt,
    'content' => $content,
    'author' => $author,
    'date' => $date,
    'published' => $published,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
];

if ($image_path) {
    $post['image'] = $image_path;
}

// Blog posts yükle
$blog_file = '../data/blog-posts.json';
$blog_posts = read_json_file($blog_file, ['de' => [], 'en' => []]);

// Create veya Update
if ($action === 'create') {
    $blog_posts[$lang][] = $post;
    $log_message = "BLOG_CREATED: {$title} ({$lang})";
    $success_message = "Blog yazısı başarıyla oluşturuldu!";
    
} else if ($action === 'update' && $index !== null) {
    if (isset($blog_posts[$lang][$index])) {
        // Eski görseli koru (eğer yeni yüklenmemişse)
        if (!$image_path && isset($blog_posts[$lang][$index]['image'])) {
            $post['image'] = $blog_posts[$lang][$index]['image'];
        }
        
        $post['created_at'] = $blog_posts[$lang][$index]['created_at'] ?? date('Y-m-d H:i:s');
        $blog_posts[$lang][$index] = $post;
        $log_message = "BLOG_UPDATED: {$title} ({$lang})";
        $success_message = "Blog yazısı başarıyla güncellendi!";
    } else {
        set_error_message('Güncellenecek yazı bulunamadı!');
        header("Location: blog.php?lang={$lang}");
        exit;
    }
}

// Kaydet
if (write_json_file($blog_file, $blog_posts)) {
    log_activity($log_message);
    set_success_message($success_message);
} else {
    set_error_message('Kaydetme hatası!');
}

header("Location: blog.php?lang={$lang}");
exit;
```

### 6.4 Blog Düzenleme & Silme

Blog düzenleme ve silme dosyaları menü yönetimiyle aynı mantıkta çalışır - sadece veri yapısı farklıdır.

---

## 7. Logo Yönetimi

**admin/logo.php:**

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/helpers.php';

$success = show_success_message();
$error = show_error_message();

// Mevcut logoyu kontrol et
$logo_path = '../assets/images/logo.svg';
$logo_exists = file_exists($logo_path);

$page_title = 'Logo Yönetimi';
?>
<?php include 'includes/header.php'; ?>

<div class="container mx-auto py-8 px-4">
    <div class="max-w-3xl mx-auto">
        
        <!-- Başlık -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">🖼️ Logo Yönetimi</h1>
            <p class="text-gray-600">Site logosunu yükleyin veya değiştirin</p>
        </div>
        
        <!-- Messages -->
        <?php if ($success): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <!-- Mevcut Logo -->
        <?php if ($logo_exists): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Mevcut Logo</h2>
                <div class="bg-gray-50 p-8 rounded-lg text-center">
                    <img src="<?= $logo_path ?>?v=<?= time() ?>" 
                         alt="Logo" 
                         class="max-h-32 mx-auto">
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Upload Formu -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                <?= $logo_exists ? 'Yeni Logo Yükle' : 'Logo Yükle' ?>
            </h2>
            
            <form method="POST" action="logo-upload.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                
                <div class="space-y-6">
                    <!-- Dosya Seçimi -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3">Logo Dosyası *</label>
                        <input type="file" 
                               name="logo" 
                               required 
                               accept=".svg,.png,.jpg,.jpeg"
                               class="w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 cursor-pointer hover:border-blue-400">
                        
                        <div class="mt-3 space-y-2 text-sm text-gray-600">
                            <p>✅ <strong>Önerilen:</strong> SVG formatı (sonsuz ölçeklenebilir)</p>
                            <p>✅ <strong>Desteklenen:</strong> SVG, PNG, JPG (max 2MB)</p>
                            <p>ℹ️ <strong>Boyut:</strong> Yükseklik max 80px olarak optimize edilecek</p>
                        </div>
                    </div>
                    
                    <!-- Submit -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold text-lg shadow-lg hover:shadow-xl transition-all">
                        📤 Logoyu Yükle
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>
```

**admin/logo-upload.php:**

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/helpers.php';

// CSRF kontrolü
if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
    set_error_message('Güvenlik hatası!');
    header('Location: logo.php');
    exit;
}

// Dosya yükleme kontrolü
if (!isset($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
    set_error_message('Dosya yüklenemedi!');
    header('Location: logo.php');
    exit;
}

$file = $_FILES['logo'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

// Dosya tipi kontrolü
$allowed_types = ['svg', 'png', 'jpg', 'jpeg'];
if (!in_array($ext, $allowed_types)) {
    set_error_message('Geçersiz dosya tipi! Sadece SVG, PNG, JPG desteklenir.');
    header('Location: logo.php');
    exit;
}

// Boyut kontrolü (2MB)
if ($file['size'] > 2 * 1024 * 1024) {
    set_error_message('Dosya çok büyük! Max 2MB');
    header('Location: logo.php');
    exit;
}

// Hedef dizin
$target_dir = '../assets/images';
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0755, true);
}

// Eski logoyu yedekle
$target_path = $target_dir . '/logo.' . $ext;
if (file_exists($target_path)) {
    $backup_path = $target_dir . '/logo_backup_' . date('YmdHis') . '.' . $ext;
    copy($target_path, $backup_path);
}

// Yeni logoyu kaydet
if (move_uploaded_file($file['tmp_name'], $target_path)) {
    // PNG/JPG ise optimize et
    if (in_array($ext, ['png', 'jpg', 'jpeg'])) {
        optimize_image($target_path, 800, 90);
    }
    
    log_activity('LOGO_UPDATED', "New logo uploaded: logo.{$ext}");
    set_success_message('Logo başarıyla yüklendi!');
} else {
    set_error_message('Logo kaydedilemedi!');
}

header('Location: logo.php');
exit;
```

---

## 8. Genel Ayarlar

**admin/settings.php:**

```php
<?php
require_once 'includes/auth.php';
require_once 'includes/helpers.php';

// Ayarları yükle
$settings_file = '../data/settings.json';
$settings = read_json_file($settings_file, [
    'site_title' => 'Catering Antipasti',
    'site_description' => '',
    'contact_email' => '',
    'phone' => '',
    'whatsapp' => '',
    'address' => '',
    'social_facebook' => '',
    'social_instagram' => '',
    'analytics_id' => '',
    'maintenance_mode' => false
]);

$success = show_success_message();

$page_title = 'Genel Ayarlar';
?>
<?php include 'includes/header.php'; ?>

<div class="container mx-auto py-8 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Başlık -->
        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">⚙️ Genel Ayarlar</h1>
            <p class="text-gray-600">Site genelindeki ayarları yönetin</p>
        </div>
        
        <?php if ($success): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg mb-6">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <!-- Form -->
        <form method="POST" action="settings-save.php">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            
            <!-- Site Bilgileri -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Site Bilgileri</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Site Başlığı</label>
                        <input type="text" 
                               name="site_title" 
                               value="<?= htmlspecialchars($settings['site_title']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Site Açıklaması</label>
                        <textarea name="site_description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"><?= htmlspecialchars($settings['site_description']) ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- İletişim Bilgileri -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">İletişim Bilgileri</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">E-posta</label>
                        <input type="email" 
                               name="contact_email" 
                               value="<?= htmlspecialchars($settings['contact_email']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Telefon</label>
                        <input type="tel" 
                               name="phone" 
                               value="<?= htmlspecialchars($settings['phone']) ?>"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">WhatsApp</label>
                        <input type="tel" 
                               name="whatsapp" 
                               value="<?= htmlspecialchars($settings['whatsapp']) ?>"
                               placeholder="+49..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Adres</label>
                        <textarea name="address" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"><?= htmlspecialchars($settings['address']) ?></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Sosyal Medya -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Sosyal Medya</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Facebook URL</label>
                        <input type="url" 
                               name="social_facebook" 
                               value="<?= htmlspecialchars($settings['social_facebook']) ?>"
                               placeholder="https://facebook.com/..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Instagram URL</label>
                        <input type="url" 
                               name="social_instagram" 
                               value="<?= htmlspecialchars($settings['social_instagram']) ?>"
                               placeholder="https://instagram.com/..."
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            </div>
            
            <!-- Gelişmiş -->
            <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Gelişmiş Ayarlar</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Google Analytics ID</label>
                        <input type="text" 
                               name="analytics_id" 
                               value="<?= htmlspecialchars($settings['analytics_id']) ?>"
                               placeholder="G-XXXXXXXXXX"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="maintenance_mode" 
                                   value="1"
                                   <?= $settings['maintenance_mode'] ? 'checked' : '' ?>
                                   class="w-5 h-5 text-blue-600 rounded">
                            <div>
                                <span class="text-gray-700 font-semibold">Bakım Modu</span>
                                <p class="text-sm text-gray-500">Site ziyaretçilere bakım sayfası gösterilir</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Kaydet -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 font-bold text-lg shadow-lg hover:shadow-xl transition-all">
                    💾 Ayarları Kaydet
                </button>
            </div>
        </form>
        
    </div>
</div>

<?php include 'includes/footer.php'; ?>
```

---

## 9. Helper Fonksiyonlar

[UPDATEV2.md'deki helper fonksiyonlar bölümü aynen geçerli]

---

## 10. Kurulum Adımları

### 10.1 Hızlı Kurulum

```bash
# 1. Klasörleri oluştur
mkdir -p admin/includes admin/assets data logs

# 2. İzinleri ayarla
chmod 755 admin/ admin/includes/ admin/assets/ data/ logs/
chmod 644 admin/*.php

# 3. Browser'da setup.php'yi çalıştır
https://yourdomain.com/admin/setup.php

# 4. Admin kullanıcısı oluştur ve setup.php'yi sil
rm admin/setup.php
# VEYA
mv admin/setup.php admin/setup.php.disabled

# 5. Giriş yap
https://yourdomain.com/admin/login.php
```

### 10.2 Dosyaları Upload Etme

```bash
# FTP/SFTP ile yükle
admin/
data/
logs/

# Veya git ile
git clone your-repo
cd project
# ... dosyaları organize et
```

### 10.3 İlk Ayarlar

1. **Renkler** → `/admin/colors.php` - Palette seç
2. **Logo** → `/admin/logo.php` - Logo yükle
3. **Ayarlar** → `/admin/settings.php` - İletişim bilgilerini ekle
4. **Menüler** → `/admin/menus.php` - İlk menüyü ekle

---

## 11. Güvenlik Best Practices

### 11.1 .htaccess Yapılandırması

```apache
# admin/.htaccess
Options -Indexes
php_flag display_errors Off
php_value session.cookie_httponly 1
php_value session.cookie_secure 1

# IP Whitelist (opsiyonel)
# Order Deny,Allow
# Deny from all
# Allow from YOUR.IP.ADDRESS
```

### 11.2 Şifre Politikası

- Minimum 8 karakter
- Büyük-küçük harf kombinasyonu
- En az 1 rakam
- Özel karakter önerilir

### 11.3 Backup Stratejisi

```bash
#!/bin/bash
# backup.sh

BACKUP_DIR="/path/to/backups"
DATE=$(date +%Y%m%d_%H%M%S)

# Data backup
tar -czf "$BACKUP_DIR/data_$DATE.tar.gz" data/

# Logs backup
tar -czf "$BACKUP_DIR/logs_$DATE.tar.gz" logs/

# Assets backup
tar -czf "$BACKUP_DIR/assets_$DATE.tar.gz" assets/uploads/

# Eski backup'ları temizle (30 günden eski)
find "$BACKUP_DIR" -name "*.tar.gz" -mtime +30 -delete

echo "Backup completed: $DATE"
```

### 11.4 Log Monitoring

```bash
# Başarısız login denemelerini izle
tail -f logs/admin-failed-logins.log

# Tüm değişiklikleri izle
tail -f logs/admin-changes.log

# Log analizi
grep "FAILED" logs/admin-failed-logins.log | wc -l
```

---

## 12. Testing & Troubleshooting

### 12.1 Test Checklist

- [ ] Setup çalışıyor mu?
- [ ] Login sistemi çalışıyor mu?
- [ ] Session timeout aktif mi?
- [ ] CSRF koruması çalışıyor mu?
- [ ] Renk değişiklikleri CSS'e yansıyor mu?
- [ ] Menü ekleme/düzenleme/silme çalışıyor mu?
- [ ] Blog ekleme/düzenleme/silme çalışıyor mu?
- [ ] Görsel upload çalışıyor mu?
- [ ] Logo upload çalışıyor mu?
- [ ] Loglar yazılıyor mu?
- [ ] Backup sistemi çalışıyor mu?

### 12.2 Sık Karşılaşılan Sorunlar

**Problem:** Session timeout çok kısa
```php
// includes/auth.php içinde
$timeout = 3600; // 60 dakikaya çıkar
```

**Problem:** Dosya upload edilemiyor
```bash
# PHP ayarlarını kontrol et
php -i | grep upload_max_filesize
php -i | grep post_max_size

# .htaccess ile artır
php_value upload_max_filesize 10M
php_value post_max_size 12M
```

**Problem:** JSON yazma hatası
```bash
# İzinleri kontrol et
chmod 755 data/
chmod 644 data/*.json
```

**Problem:** CSS değişiklikleri yansımıyor
```php
// Browser cache'i bypass et
<link href="custom.css?v=<?= time() ?>">
```

---

## 13. Sonuç

Bu admin panel sistemi:
- ✅ Hafif ve hızlı
- ✅ Database gerektirmez
- ✅ Kolay kurulum
- ✅ Güvenli
- ✅ Genişletilebilir

### 13.1 Gelecek Geliştirmeler (Opsiyonel)

- Multi-user support (kullanıcı rolleri)
- 2FA (Two-Factor Authentication)
- Activity dashboard (grafiklerle)
- Automated backup scheduler
- Image optimization pipeline
- Email notifications
- API endpoints

### 13.2 Destek

Sorularınız için:
- 📧 Email: cuneyt@kayacuneyt.com
- 🌐 Website: kayacuneyt.com

---

**Son Güncelleme:** 14 Kasım 2024  
**Versiyon:** 2.0  
**Lisans:** MIT  

© 2024 Cüneyt Kaya - Tüm hakları saklıdır.
