<?php
require_once '../app/core/App.php';
App::init();

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

    $error = 'Nesprávny email alebo heslo.';
}
?>

<form class="login-form" method="POST">
    <div>
        <label class="form-label" for="username">username</label>
                        <input type="text"
                            id="username"
                            name="username"
                            class="form-input"
                            placeholder="username"
                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                            required
                        >



                        
        <label class="form-label" for="password" style="margin-bottom: 0;">Password</label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter your password"
                            value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"
                            required
                        >


                    <?php if ($error): ?>
                        <p style="color: #dc2626; font-size: 0.875rem; margin-bottom: 1rem;">
                            <?= htmlspecialchars($error) ?>
                        </p>
                    <?php endif; ?>

                    <button type="submit">
                        Sign In
                    </button>
                </form>