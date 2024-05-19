<?php

$root = '.';

require_once $root . '/includes/includes.php';

$user = $_SESSION['user'];

if (!isset($user)) {
    header("Location: {$root}/login.php");
}
?>

<?php require_once $root . '/templates/top.php'; ?>
<?php require_once $root . '/templates/header.php'; ?>

<main class="p-8 flex items-center justify-center">
    <form action="<?= $root ?>/handlers/profile.php" method="post" enctype="multipart/form-data" class="max-w-sm w-full border rounded">
        <div class="p-4 border-b">
            <h1 class="text-lg font-bold">Profil</h1>
            <div>Ubah informasi profil anda disini</div>
        </div>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="p-4 border-b">
                <?php require_once $root . '/templates/success.php'; ?>
            </div>
        <?php endif; ?>
        <div class="p-4 border-b">
            <div class="flex justify-center">
                <div class="grid gap-2">
                    <div class="flex justify-center">
                        <div class="w-32 h-32 border rounded-full overflow-hidden">
                            <img id="preview" class="w-full h-full object-cover" src="<?= $root . $user['picture'] ?>">
                        </div>
                    </div>
                    <button type="button" class="px-3 py-2 bg-white border rounded font-medium" onclick="openPicturePicker()">Ubah Foto</button>
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
                <input type="text" name="username" id="username" class="p-2 border rounded" value="<?= old('username', $user['username']) ?>" autofocus required>
            </div>
            <div class="grid gap-1">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="p-2 border rounded" value="<?= old('name', $user['name']) ?>" autofocus required>
            </div>
            <div class="grid gap-1">
                <label for="about">Tentang Saya</label>
                <textarea name="about" id="about" class="p-2 border rounded" required><?= old('about', $user['about']) ?></textarea>
            </div>
            <div class="grid gap-1">
                <label for="birth_date">Tanggal Lahir</label>
                <input type="date" name="birth_date" id="birth_date" class="p-2 border rounded" value="<?= old('birth_date', $user['birth_date']) ?>" required>
                <small class="text-gray-500">Opsional</small>
            </div>
        </div>
        <div class="grid gap-4 p-4">
            <div class="grid gap-2">
                <div class="grid gap-1">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="p-2 border rounded" value="<?= old('email', $user['email']) ?>" required>
                </div>
                <div class="grid gap-1">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="p-2 border rounded">
                    <small class="text-gray-500">Kosongi bila tidak ingin merubah</small>
                </div>
                <div class="grid gap-1 hidden">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="p-2 border rounded">
                </div>
            </div>
        </div>
        <div class="px-4 pb-4 flex flex-row-reverse items-center justify-between">
            <button type="submit" class="px-3 py-2 bg-zinc-900 text-white rounded font-medium">Simpan</button>
            <a href="<?= $root ?>/index.php" class="px-3 py-2 bg-white border rounded font-medium">
                Kembali ke beranda
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

    document.querySelector('#password').addEventListener('input', (event) => {
        const password = event.target.value;
        const passwordConfirmation = document.getElementById('password_confirmation');

        if (password.length > 0) {
            passwordConfirmation.parentElement.classList.remove('hidden');
            passwordConfirmation.required = true;
        } else {
            passwordConfirmation.parentElement.classList.add('hidden');
            passwordConfirmation.required = false;
        }
    });
</script>

<?php require_once $root . '/templates/bottom.php'; ?>