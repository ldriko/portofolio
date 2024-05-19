<?php
$user = $_SESSION['user'] ?? null;
?>

<header class="h-20 flex items-center bg-white border-b">
    <div class="max-w-screen-lg w-full mx-auto px-8 flex items-center justify-between p-4">
        <a href="<?= $root ?>" class="text-lg font-bold">Portofolio</a>
        <?php if ($user !== null) : ?>
            <div class="flex items-center gap-4">
                <form action="<?= $root ?>/handlers/logout.php" method="post">
                    <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded font-medium">Logout</button>
                </form>
            </div>
        <?php else : ?>
            <div class="flex gap-4">
                <a href="<?= $root ?>/register.php" class="px-3 py-2 bg-white border rounded font-medium text-center">
                    Daftar
                </a>
                <a href="<?= $root ?>/login.php" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium text-center">
                    Login
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>