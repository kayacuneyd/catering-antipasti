<?php
/**
 * Shared helper utilities for the admin panel.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!defined('ADMIN_PROJECT_ROOT')) {
    $root = realpath(__DIR__ . '/../../') ?: (__DIR__ . '/../../');
    $root = rtrim(str_replace('\\', '/', $root), '/') . '/';
    define('ADMIN_PROJECT_ROOT', $root);
}
if (!defined('ADMIN_DATA_DIR')) {
    define('ADMIN_DATA_DIR', ADMIN_PROJECT_ROOT . 'data');
}
if (!defined('ADMIN_LOG_DIR')) {
    define('ADMIN_LOG_DIR', ADMIN_PROJECT_ROOT . 'logs');
}
if (!defined('ADMIN_UPLOAD_DIR')) {
    define('ADMIN_UPLOAD_DIR', ADMIN_PROJECT_ROOT . 'assets/uploads');
}

/**
 * Resolve a path relative to the project root when a non-absolute path
 * is provided.
 */
function admin_path(string $path): string
{
    if ($path === '') {
        return ADMIN_PROJECT_ROOT;
    }

    if ($path[0] === DIRECTORY_SEPARATOR || preg_match('/^[A-Za-z]:\\\\/', $path)) {
        return $path;
    }

    return ADMIN_PROJECT_ROOT . ltrim($path, '/');
}

function ensure_directory(string $path): void
{
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
    }
}

function read_json_file(string $path, array $default = []): array
{
    $fullPath = admin_path($path);
    if (!file_exists($fullPath)) {
        return $default;
    }

    $contents = file_get_contents($fullPath);
    if ($contents === false) {
        return $default;
    }

    $data = json_decode($contents, true);
    return is_array($data) ? $data : $default;
}

function write_json_file(string $path, array $data): bool
{
    $fullPath = admin_path($path);
    ensure_directory(dirname($fullPath));

    $result = file_put_contents(
        $fullPath,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );

    return $result !== false;
}

function slugify(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/i', '-', $value);
    return trim($value, '-') ?: 'entry-' . substr(sha1((string) microtime(true)), 0, 6);
}

function redirect_with_message(string $target, string $message, string $type = 'success'): void
{
    $_SESSION['flash'][$type] = $message;
    header('Location: ' . $target);
    exit;
}

function show_success_message(): ?string
{
    if (!empty($_SESSION['flash']['success'])) {
        $message = $_SESSION['flash']['success'];
        unset($_SESSION['flash']['success']);
        return $message;
    }

    return null;
}

function show_error_message(): ?string
{
    if (!empty($_SESSION['flash']['error'])) {
        $message = $_SESSION['flash']['error'];
        unset($_SESSION['flash']['error']);
        return $message;
    }

    return null;
}

function verify_csrf_token(?string $token): bool
{
    return isset($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

function require_valid_csrf(): void
{
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        redirect_with_message('index.php', 'Geçersiz CSRF anahtarı. Lütfen tekrar deneyin.', 'error');
    }
}

function normalize_multiline(string $value): array
{
    $lines = preg_split('/\r?\n/', trim($value));
    $lines = array_filter(array_map('trim', $lines), static fn($line) => $line !== '');
    return array_values($lines);
}

function log_admin_event(string $filename, string $message): void
{
    ensure_directory(ADMIN_LOG_DIR);
    $path = ADMIN_LOG_DIR . '/' . $filename;
    $prefix = date('Y-m-d H:i:s') . ' | ';
    file_put_contents($path, $prefix . $message . "\n", FILE_APPEND);
}

function log_activity(string $action, string $details = ''): void
{
    $username = $_SESSION['admin_username'] ?? 'unknown';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $message = sprintf('%s | %s | %s', $username, $action, $details ?: 'N/A');
    $message .= ' | IP: ' . $ip;
    log_admin_event('admin-changes.log', $message);
}

function update_custom_css_colors(array $colors): void
{
    $cssPath = admin_path('assets/css/custom.css');
    if (!file_exists($cssPath)) {
        return;
    }

    $map = [];
    foreach ($colors as $name => $hex) {
        $hex = ltrim($hex, '#');
        if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            continue;
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        $map[$name] = sprintf('    --color-%s: %d %d %d;', $name, $r, $g, $b);
    }

    if (empty($map)) {
        return;
    }

    $newBlock = ":root {\n" . implode("\n", $map) . "\n}";
    $css = file_get_contents($cssPath);

    if (preg_match('/:root\s*\{[^}]*\}/', $css)) {
        $css = preg_replace('/:root\s*\{[^}]*\}/', $newBlock, $css, 1);
    } else {
        $css = $newBlock . "\n\n" . $css;
    }

    file_put_contents($cssPath, $css);
}

function get_settings(): array
{
    return read_json_file('data/settings.json', [
        'site_title' => 'Catering Antipasti',
        'site_description' => '',
        'contact_email' => '',
        'phone' => '',
        'whatsapp' => '',
        'address' => '',
        'social_facebook' => '',
        'social_instagram' => '',
        'analytics_id' => '',
        'maintenance_mode' => false,
        'logo_path' => '',
        'active_palette' => 'classic'
    ]);
}

function save_settings(array $settings): bool
{
    return write_json_file('data/settings.json', $settings);
}

function get_palettes(): array
{
    $defaults = [
        'active' => 'classic',
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

    $palettes = read_json_file('data/palettes.json', $defaults);
    return array_merge($defaults, $palettes);
}

function save_palettes(array $palettes): bool
{
    return write_json_file('data/palettes.json', $palettes);
}

function admin_upload_path(string $subdir = ''): string
{
    $path = rtrim(ADMIN_UPLOAD_DIR . '/' . ltrim($subdir, '/'), '/');
    ensure_directory($path);
    return $path;
}

function handle_upload(string $field, array $allowedExtensions, int $maxSizeMb = 5): array
{
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Dosya yüklenemedi.'];
    }

    $file = $_FILES[$field];
    if ($file['size'] > $maxSizeMb * 1024 * 1024) {
        return ['success' => false, 'error' => 'Dosya boyutu çok büyük.'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) {
        return ['success' => false, 'error' => 'Desteklenmeyen dosya türü.'];
    }

    $safeName = slugify(pathinfo($file['name'], PATHINFO_FILENAME));
    $targetName = $safeName . '-' . time() . '.' . $ext;

    return ['success' => true, 'tmp_path' => $file['tmp_name'], 'target_name' => $targetName];
}
