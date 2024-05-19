<?php if (count($_SESSION['errors']) > 0) : ?>
    <div class="p-2 bg-red-50 border border-red-500 rounded text-red-900">
        <ul class="list-disc list-outside ms-6">
            <?php foreach ($_SESSION['errors'] as $value) : ?>
                <li><?= $value ?></li>
                <li>Masukkan ulang foto</li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>