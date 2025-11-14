<?php
require_once __DIR__ . '/includes/helpers.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = null;
$timeout = isset($_GET['timeout']);
$logout = isset($_GET['logout']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = read_json_file('data/users.json', []);
    $user = null;

    foreach ($users as $candidate) {
        if (($candidate['username'] ?? '') === $username) {
            $user = $candidate;
            break;
        }
    }

    if (!$user || !password_verify($password, $user['password'] ?? '')) {
        $error = 'Kullanıcı adı veya şifre hatalı';
        log_admin_event('admin-failed-logins.log', "FAILED | {$username} | IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
    } else {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_role'] = $user['role'] ?? 'admin';
        $_SESSION['last_activity'] = time();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        log_admin_event('admin-access.log', 'LOGIN | ' . $user['username']);

        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white/95 rounded-2xl shadow-2xl w-full max-w-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2 text-center">Admin Panel</h1>
        <p class="text-gray-500 text-center mb-6">Catering Antipasti</p>

        <?php if ($timeout): ?>
            <div class="bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-lg p-3 mb-4">
                Oturumunuz güvenlik nedeniyle sonlandırıldı.
            </div>
        <?php endif; ?>

        <?php if ($logout): ?>
            <div class="bg-green-50 text-green-800 border border-green-200 rounded-lg p-3 mb-4">
                Başarıyla çıkış yapıldı.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-700 border border-red-200 rounded-lg p-3 mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Kullanıcı Adı</label>
                <input type="text" name="username" required autofocus class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-gray-500">
            </div>
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Şifre</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-gray-500">
            </div>
            <button type="submit" class="w-full bg-gray-900 text-white font-semibold rounded-lg py-3 hover:bg-black transition">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
