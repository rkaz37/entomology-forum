<?php
    include_once 'partials/header.php';
    $post = new Post();
    $id = $_GET['id'];
?>

<?php
    $post->show($id);
    
?>