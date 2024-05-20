<?php

$root = '..';

require_once '../includes/includes.php';
require_once '../includes/image.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $about = $_POST['about'];
    $birthDate = $_POST['birth_date'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];
    $errors = [];

    $checkUsername = preg_match('/^[a-zA-Z0-9_]+$/', $username);

    if (strlen($username) < 4) {
        $errors[] = 'Username minimal 4 karakter';
    } else if ($checkUsername === 0) {
        $errors[] = 'Username hanya boleh terdiri dari huruf, angka, dan underscore';
    } else {
        $user = $db->fetch('SELECT * FROM users WHERE username = ?', [$username]);

        if ($user) {
            $errors[] = 'Username sudah terdaftar';
        }
    }

    $user = $db->fetch('SELECT * FROM users WHERE email = ?', [$email]);

    if ($user) {
        $errors[] = 'Email sudah terdaftar';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter';
    }
    if ($password !== $passwordConfirmation) {
        $errors[] = 'Password tidak sama';
    }
    if (count($errors) > 0) {
        $_SESSION['old'] = ['username' => $username, 'name' => $name, 'about' => $about, 'birth_date' => $birthDate, 'email' => $email];
        $_SESSION['errors'] = $errors;
        header("Location: {$root}/register.php");
        exit;
    }

    $db->beginTransaction();

    $id = $db->execute(
        'INSERT INTO users (username, name, about, birth_date, email, password) VALUES (?, ?, ?, ?, ?, ?)',
        [$username, $name, $about, $birthDate, $email, password_hash($password, PASSWORD_DEFAULT)]
    );

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === 0) {
        $picture = $_FILES['picture'];
        $picturePath = '';

        try {
            $filename = $picture['name'];
            $tmp = $picture['tmp_name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = md5($filename . time()) . ".$ext";

            if (!file_exists($root . '/storage/users')) {
                mkdir($root . '/storage/users', 0777, true);
            }

            $picturePath = "/storage/users/$filename";

            move_uploaded_file($tmp, $root . $picturePath);

            resize_image($root . $picturePath, 720, 720, true);

            $db->execute('UPDATE users SET picture = ? WHERE id = ?', [$picturePath, $id]);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            $_SESSION['errors'] = $errors;
            header("Location: {$root}/register.php");
            exit;
        }
    }

    $db->commit();

    $user = $db->fetch('SELECT * FROM users WHERE id = ?', [$id]);

    session_start();

    $_SESSION['user'] = $user;
    $_SESSION['success'] = 'Registrasi berhasil';

    header("Location: {$root}/index.php");
}
