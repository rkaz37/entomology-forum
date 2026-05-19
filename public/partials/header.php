<?php
    require_once '../app/core/App.php';
    App::init();

    //Auth::requireLogin();
    $isAdmin = Auth::isAdmin();
    if(Auth::check()){
        $user = $_SESSION['user_id'];
    }

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
    <div class="navbar container">
        <a href="home.php">Home</a>
        <a href="forum.php">Forum</a>
        <a href="contact.php">Contact us</a>

        <?php if ($isAdmin): ?>
                <a href="admin.php">MOD MENU</a>
        <?php endif; ?>
        <?php if (Auth::check()): ?>
                <a href="profile.php?id=<?php echo $user; ?>"><?php echo $_SESSION['username']; ?></a>
        <?php endif; ?>
        <?php if (Auth::check()): ?>
                <a class="button" id="log" href="logout.php">logout</a>
        <?php else: ?>
                <a class="button" id="log" href="login.php">login</a>
                <a class="button" id="log" href="sign-up.php">sign up</a>
        <?php endif; ?>
    </div>