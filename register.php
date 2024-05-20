<?php
$root = '.';

require_once $root . '/templates/top.php';
?>

<main class="min-h-dvh p-8 flex items-center justify-center">
    <form action="<?= $root ?>/handlers/register.php" method="post" enctype="multipart/form-data" class="max-w-sm w-full border rounded">
        <div class="p-4 border-b">
            <h1 class="text-lg font-bold">Pendaftaran</h1>
            <div>Buat akun terlebih dahulu untuk mulai!</div>
        </div>
        <div class="p-4 border-b">
            <div class="flex justify-center">
                <div class="grid gap-2">
                    <div class="w-32 h-32 border rounded-full overflow-hidden">
                        <img id="preview" class="w-full h-full border object-cover hidden">
                    </div>
                    <button type="button" class="px-3 py-2 bg-white border rounded font-medium" onclick="openPicturePicker()">Pilih Foto</button>
                    <input type="file" name="picture" id="picture" accept="image/png,image/jpeg,image/jpg" class="absolute -top-80">
                </div>
            </div>
        </div>
        <?php if (count($_SESSION['errors']) > 0) : ?>
            <div class="p-4 border-b">
                <?php require_once $root . '/templates/errors.php'; ?>
            </div>
        <?php endif; ?>
        <div class="p-4 grid gap-4 border-b">
            <div class="grid gap-1">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="p-2 border rounded" value="<?= old('username') ?>" autofocus required>
            </div>
            <div class="grid gap-1">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="p-2 border rounded" value="<?= old('name') ?>" required>
            </div>
            <div class="grid gap-1">
                <label for="about">Tentang Saya</label>
                <textarea name="about" id="about" class="p-2 border rounded" required><?= old('about') ?></textarea>
            </div>
            <div class="grid gap-1">
                <label for="birth_date">Tanggal Lahir</label>
                <input type="date" name="birth_date" id="birth_date" class="p-2 border rounded" value="<?= old('birth_date') ?>" required>
                <small class="text-gray-500">Opsional</small>
            </div>
        </div>
        <div class=" grid gap-4 p-4">
            <div class="grid gap-1">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="p-2 border rounded" value="<?= old('email') ?>" required>
            </div>
            <div class="grid gap-1">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="p-2 border rounded" required>
            </div>
            <div class="grid gap-1">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 border rounded" required>
            </div>
        </div>
        <div class="px-4 pb-4 flex flex-row-reverse items-center justify-between">
            <button type="submit" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium">Daftar</button>
            <a href="<?= $root ?>/login.php" class="text-gray-500">
                Sudah punya akun? Masuk disini
            </a>
        </div>
    </form>
</main>

<script>
    document.querySelector('#picture').addEventListener('change', (event) => {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('preview').classList.remove('hidden');
        }

        reader.readAsDataURL(file);
    });

    const openPicturePicker = () => {
        document.getElementById('picture').click();
    }
</script>

<?php require_once $root . '/templates/bottom.php'; ?>