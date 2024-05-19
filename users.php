<?php
$root = '.';

require_once $root . '/templates/top.php';
require_once $root . '/templates/header.php';

$users = $db->fetchAll('SELECT * FROM users');
?>

<main class="max-w-screen-lg mx-auto p-8 grid gap-4">
    <form action="." method="get" class="grid lg:flex gap-2 lg:gap-4">
        <input type="text" name="username" id="username" placeholder="Masukkan username" class="grow p-2 border rounded" autofocus required>
        <button type="submit" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium">Cari Profil</button>
        <a href="<?= $root ?>" class="w-full lg:w-auto px-3 py-2 bg-white border rounded font-medium text-center">Kembali</a>
    </form>
    <div class="flex gap-4">
        <?php foreach ($users as $user) : ?>
            <a href="<?= $root ?>/?username=<?= $user['username'] ?>">
                <div class="border rounded hover:outline hover:outline-2 cursor-pointer">
                    <div class="p-2">
                        <h1 class="font-medium">@<?= $user['username'] ?></h1>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once $root . '/templates/bottom.php'; ?>