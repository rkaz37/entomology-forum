<?php
    include_once 'partials/header.php';

    $user = new User();
    $id = $_GET['id'];
    $user->show($id);

?>


