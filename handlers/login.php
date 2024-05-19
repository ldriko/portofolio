<?php

$root = '..';

require_once $root . '/includes/includes.php';

if (isset($_SESSION['user'])) {
    header("Location: {$root}/index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user'] = $user;

        header("Location: {$root}/index.php");
    } else {
        $_SESSION['old'] = ['email' => $email];
        $_SESSION['errors'] = ['Email atau password salah'];
        header("Location: {$root}/login.php");
    }
}
