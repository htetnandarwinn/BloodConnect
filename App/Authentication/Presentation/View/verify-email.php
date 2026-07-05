<?php $errors = $_SESSION['errors'] ?? []; ?>
<?php $success = $_SESSION['success'] ?? ''; ?>
<?php $old = $_SESSION['old'] ?? []; ?>

<main style="max-width:400px;margin:auto;padding:20px;">
    <h2>Verify Your Email</h2>

    <?php if (!empty($errors['form'])): ?>
        <p style="color:red;">
            <?= $errors['form'] ?>
        </p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green;">
            <?= $success ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="/BloodConnect/public/verify-email">
        <label>Enter OTP Code</label>
        <input type="text" name="code" required>

        <button type="submit">Verify</button>
    </form>

    <form method="POST" action="/BloodConnect/public/resend-code">
        <button type="submit">Resend Code</button>
    </form>
</main>