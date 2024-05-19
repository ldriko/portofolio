<?php
$root = '.';

require_once $root . '/templates/top.php';
?>

<main class="h-dvh p-8 flex items-center justify-center">
    <form action="<?= $root ?>/handlers/login.php" method="post" class="max-w-sm w-full border rounded">
        <div class="p-4 border-b">
            <h1 class="text-lg font-bold">Portofolio</h1>
            <div>Masuk dengan akun anda untuk mulai!</div>
        </div>
        <div class="grid gap-4 p-4">
            <?php require_once $root . '/templates/errors.php'; ?>
            <div class="grid gap-2">
                <div class="grid gap-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="p-2 border rounded" value="<?= old('email') ?>" autofocus required>
                </div>
                <div class="grid gap-1">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="p-2 border rounded" required>
                </div>
            </div>
        </div>
        <div class="px-4 pb-4 flex flex-row-reverse items-center justify-between">
            <button type="submit" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium">Masuk</button>
            <a href="<?= $root ?>/register.php" class="text-gray-500">
                Belum punya akun? Daftar disini
            </a>
        </div>
    </form>
</main>

<?php require_once $root . '/templates/bottom.php'; ?>