<?php
    require_once '../app/core/App.php';
    App::init();
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
    </div>