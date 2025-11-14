<?php
require_once __DIR__ . '/includes/helpers.php';

if (isset($_SESSION['admin_username'])) {
    log_admin_event('admin-access.log', 'LOGOUT | ' . $_SESSION['admin_username']);
}

session_unset();
session_destroy();

header('Location: login.php?logout=1');
exit;
