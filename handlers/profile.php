<?php

$root = '..';

require_once '../includes/includes.php';
require_once '../includes/image.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_SESSION['user'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $about = $_POST['about'];
    $birthDate = $_POST['birth_date'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $errors = [];

    $checkUsername = preg_match('/^[a-zA-Z0-9_]+$/', $username);

    if (strlen($username) < 4) {
        $errors[] = 'Username minimal 4 karakter';
    } else if ($checkUsername === 0) {
        $errors[] = 'Username hanya boleh terdiri dari huruf, angka, dan underscore';
    } else {
        $usernameExists = $db->fetch('SELECT * FROM users WHERE username = ? AND id != ?', [$username, $user['id']]);

        if ($usernameExists) {
            $errors[] = 'Username sudah terdaftar';
        }
    }

    $emailExists = $db->fetch('SELECT * FROM users WHERE email = ? AND id != ?', [$email, $user['id']]);

    if ($emailExists) {
        $errors[] = 'Email sudah terdaftar';
    }
    if (strlen($password) > 0 && strlen($password) < 8) {
        $errors[] = 'Password minimal 8 karakter';

        if ($password !== $_POST['password_confirmation']) {
            $errors[] = 'Password tidak sama';
        }
    }
    if (count($errors) > 0) {
        $_SESSION['old'] = ['username' => $username, 'name' => $name, 'about' => $about, 'birth_date' => $birthDate, 'email' => $email];
        $_SESSION['errors'] = $errors;
        header("Location: {$root}/profile.php");
        exit;
    }

    $db->beginTransaction();

    $db->execute(
        'UPDATE users SET username = ?, name = ?, about = ?, birth_date = ?, email = ? WHERE id = ?',
        [$username, $name, $about, $birthDate, $email, $user['id']]
    );

    if (strlen($password) > 0) {
        $db->execute(
            'UPDATE users SET password = ? WHERE id = ?',
            [password_hash($password, PASSWORD_DEFAULT), $user['id']]
        );
    }

    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === 0) {
        $picture = $_FILES['picture'];
        $picturePath = '';

        try {
            $filename = $picture['name'];
            $tmp = $picture['tmp_name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = md5($filename . time()) . ".$ext";
            $picturePath = "/storage/users/$filename";

            move_uploaded_file($tmp, $root . $picturePath);

            resize_image($root . $picturePath, 720, 720, true);

            $db->execute('UPDATE users SET picture = ? WHERE id = ?', [$picturePath, $user['id']]);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            $_SESSION['errors'] = $errors;
            header("Location: {$root}/profile.php");
            exit;
        }
    }

    $db->commit();

    $_SESSION['user'] = $db->fetch('SELECT * FROM users WHERE id = ?', [$user['id']]);
    $_SESSION['success'] = 'Profil berhasil diperbarui';

    header("Location: {$root}/profile.php");
}
