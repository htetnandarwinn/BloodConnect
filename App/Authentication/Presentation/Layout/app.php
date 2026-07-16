<?php
/** @var string $content */

require __DIR__ . '/../../../Shared/Presentation/Layout/header.php';
?>

<main class="min-h-screen bg-gray-50">
    <?= $content ?>
</main>

<?php require __DIR__ . '/../../../Shared/Presentation/Layout/footer.php'; ?>
