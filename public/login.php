<?php
    include_once 'partials/header.php';

$error = null;

if (Auth::check()) {
    Redirect::redirect('home.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (Auth::login($username, $password)) {
        Redirect::redirect('home.php');
    }

    $error = 'Wrong Username or Password!';
}
?>

<form class="container form" method="POST">
    <h2>login:</h2>
    <div>
        <label for="username">Username: </label>
        <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
    </div>
    <div>
        <label for="password" style="margin-bottom: 0;">Password: </label>
        <input type="password" id="password" name="password" placeholder="Enter your password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" required>
    </div>


    <?php if ($error): ?>
       <p style="color: #dc2626; font-size: 0.875rem; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <button type="submit" class="button">Sign In</button>
</form>

<?php include_once 'partials/footer.php'; ?>