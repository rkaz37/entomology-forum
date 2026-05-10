<?php
    require_once '../app/core/App.php';
    App::init();

    session_start();
    //Auth::requireLogin();
    $isAdmin = Auth::isAdmin();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title><?php echo Title::getPageTitle(); ?></title>
    
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="forum.php">Forum</a>
        <a href="contact.php">Contact us</a>
        <a href="login.php">LOGIN</a>

        <?php if ($isAdmin): ?>
                <a href="admin.php">MOD MENU</a>
        <?php endif; ?>
    </div>