<?php
$root = '.';

require_once $root . '/templates/top.php';
require_once $root . '/templates/header.php';

$notFound = false;

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $user = $db->fetch('SELECT * FROM users WHERE username = ?', [$username]);

    if (!$user) $notFound = true;
} else {
    $user = $_SESSION['user'] ?? null;
}
?>

<main class="max-w-screen-lg mx-auto p-8 grid gap-4">
    <form action="." method="get" class="grid lg:flex gap-2 lg:gap-4">
        <input type="text" name="username" id="username" placeholder="Masukkan username" class="grow p-2 border rounded" autofocus required>
        <button type="submit" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium">Cari Profil</button>
        <a href="<?= $root ?>/users.php" class="w-full lg:w-auto px-3 py-2 bg-white border rounded font-medium text-center">Semua Profil</a>
    </form>
    <div class="flex justify-center">
        <?php if ($notFound) : ?>
            <div>Profil yang anda cari tidak ditemukan</div>
        <?php elseif ($user !== null) : ?>
            <form action="<?= $root ?>/handlers/profile.php" method="post" enctype="multipart/form-data" class="max-w-sm w-full border rounded">
                <div class="p-4 border-b">
                    <h1 class="text-lg font-bold">@<?= $user['username'] ?></h1>
                </div>
                <div class="p-4 border-b">
                    <div class="flex justify-center">
                        <div class="grid gap-2">
                            <div class="flex justify-center">
                                <div class="w-32 h-32 border rounded-full overflow-hidden">
                                    <img id="preview" class="w-full h-full object-cover" src="<?= $root . $user['picture'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid gap-4 p-4 border-b">
                    <?php require_once $root . '/templates/errors.php'; ?>
                    <div class="grid gap-4">
                        <div class="grid gap-1">
                            <div>Nama Lengkap</div>
                            <div class="p-2 border rounded"><?= $user['name'] ?></div>
                        </div>
                        <div class="grid gap-1">
                            <div>Tentang Saya</div>
                            <div class="p-2 border rounded whitespace-pre-line"><?= $user['about'] ?></div>
                        </div>
                        <?php if ($user['birth_date']) : ?>
                            <div class="grid gap-1">
                                <div>Tanggal Lahir</div>
                                <div class="p-2 border rounded"><?= date('d M Y', strtotime($user['birth_date'])) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($user['id'] === $_SESSION['user']['id']) : ?>
                    <div class="p-4">
                        <a href="<?= $root ?>/profile.php" class="block px-3 py-2 bg-zinc-900 text-white rounded font-medium text-center">
                            Edit Profil
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </div>
</main>

<?php require_once $root . '/templates/bottom.php'; ?>