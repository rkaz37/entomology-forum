<?php
    include_once 'partials/header.php';

$error = null;
$user = new User();

if (Auth::check()) {
    Redirect::redirect('home.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    if(!$user->usernameValidation($username) && !$user->emailValidation($email)){
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0){
            $originalName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extension, $allowedExtensions)) {
                $image = '../vault/' . time() . '-' . basename($originalName);

                move_uploaded_file($tmpName, $image);
            }
        }
    
        $user->create($username, $email, $password, $image);

        if (Auth::login($username, $password)) {
            Redirect::redirect('home.php');
        }
    }
    $error = 'Error!';
}
?>

<form class="container form" method="POST" enctype="multipart/form-data">
    <h2>Sign up!</h2>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
    <div>

    <div>
        <label for="email">email</label>
        <input type="email" id="email" name="email" placeholder="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>   
    </div>      
    
    <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password..." value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" required>
    </div>
    <div>
        <label for="image">Obrázok</label>
        <input id="image" type="file" name="image" value=".jpg,.jpeg,.png,.webp">
    </div>


    <?php if ($error): ?>
        <p style="color: #dc2626; font-size: 0.875rem; margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <button type="submit" class="button">Sign In!</button>
</form>


<?php include_once 'partials/footer.php'; ?>