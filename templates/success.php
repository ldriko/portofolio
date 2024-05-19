<?php if (isset($_SESSION['success'])) : ?>
    <div class="p-2 bg-green-50 border border-green-500 rounded text-green-900">
        <?= $_SESSION['success'] ?>
    </div>
<?php endif; ?>