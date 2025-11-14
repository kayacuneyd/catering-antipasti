<?php
require_once __DIR__ . '/includes/helpers.php';

$usersPath = admin_path('data/users.json');
ensure_directory(dirname($usersPath));

$existing = read_json_file('data/users.json', []);
if (!empty($existing)) {
    die('Kurulum tamamlanmış görünüyor. Lütfen bu dosyayı silin.');
}

$success = false;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';

    if (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalı';
    } elseif (strlen($password) < 8) {
        $error = 'Şifre en az 8 karakter olmalı';
    } elseif ($password !== $confirm) {
        $error = 'Şifreler eşleşmiyor';
    } else {
        $payload = [[
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ]];

        write_json_file('data/users.json', $payload);
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Kurulumu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
        <?php if ($success): ?>
            <div class="text-center space-y-4">
                <p class="text-5xl">✅</p>
                <h1 class="text-3xl font-bold">Kurulum Tamamlandı</h1>
                <p class="text-gray-600">Artık <code>login.php</code> sayfasından giriş yapabilirsiniz. Güvenlik için <code>setup.php</code> dosyasını silmeyi unutmayın.</p>
                <a href="login.php" class="inline-flex items-center justify-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold">Admin Paneline Git</a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">İlk Admin Kullanıcısı</h1>
                    <p class="text-gray-500">Paneli kullanmaya başlamadan önce bir kullanıcı oluşturun.</p>
                </div>
                <?php if ($error): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-red-700">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Kullanıcı Adı</label>
                        <input type="text" name="username" required minlength="3" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Şifre</label>
                        <input type="password" name="password" required minlength="8" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Şifre (Tekrar)</label>
                        <input type="password" name="password_confirm" required minlength="8" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                    <button type="submit" class="w-full bg-gray-900 text-white rounded-lg py-3 font-semibold">Kullanıcı Oluştur</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
