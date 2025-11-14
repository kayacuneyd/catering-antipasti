<?php
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Ungültiger Token']);
    exit;
}

$name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
$event_type = trim(filter_input(INPUT_POST, 'event_type', FILTER_SANITIZE_STRING));
$event_date = trim(filter_input(INPUT_POST, 'event_date', FILTER_SANITIZE_STRING));
$guest_count = trim(filter_input(INPUT_POST, 'guest_count', FILTER_SANITIZE_NUMBER_INT));
$message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));
$selected_menu = trim(filter_input(INPUT_POST, 'selected_menu', FILTER_SANITIZE_STRING));
$custom_menu = trim(filter_input(INPUT_POST, 'custom_menu_items', FILTER_SANITIZE_STRING));
$privacy = isset($_POST['privacy']);

if (!$name || !$email || !$event_type || !$message || !$privacy) {
    echo json_encode(['success' => false, 'message' => 'Bitte füllen Sie alle Pflichtfelder aus']);
    exit;
}

$to = ADMIN_EMAIL;
$subject = "Neue Anfrage von $name - " . SITE_NAME;

$lines = [
    "NEUE WEBSITE-ANFRAGE",
    "========================",
    "",
    "Name: $name",
    "E-Mail: $email",
    'Telefon: ' . ($phone ?: 'Nicht angegeben'),
    'Event-Typ: ' . ($event_type ?: 'Nicht angegeben'),
    'Datum: ' . ($event_date ?: 'Nicht angegeben'),
    'Gästeanzahl: ' . ($guest_count ?: 'Nicht angegeben'),
    '',
    "Nachricht:",
    $message,
    '',
];

if ($selected_menu) {
    $lines[] = 'Ausgewähltes Menü: ' . $selected_menu;
    $lines[] = '';
}

if ($custom_menu) {
    $lines[] = "Individuelles Menü:";
    $lines[] = $custom_menu;
    $lines[] = '';
}

$lines[] = "========================";
$lines[] = 'Gesendet: ' . date('d.m.Y H:i:s');

$email_body = implode("\n", $lines);

$headers = sprintf("From: %s\r\nReply-To: %s\r\nX-Mailer: PHP/%s", $email, $email, phpversion());

if (mail($to, $subject, $email_body, $headers)) {
    $log_dir = __DIR__ . '/../logs';
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0755, true);
    }
    $log_entry = sprintf("%s | %s | %s | %s\n", date('Y-m-d H:i:s'), $name, $email, $event_type);
    @file_put_contents($log_dir . '/inquiries.log', $log_entry, FILE_APPEND);

    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $is_english = strpos($referer, '/en/') !== false;
    $success_message = $is_english
        ? 'Thank you for your request! We will be in touch within 48 hours.'
        : 'Vielen Dank für Ihre Anfrage! Wir melden uns innerhalb von 48 Stunden bei Ihnen.';

    echo json_encode([
        'success' => true,
        'message' => $success_message,
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Leider ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut oder kontaktieren Sie uns direkt per E-Mail.',
    ]);
}

