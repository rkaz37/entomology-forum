<?php
    include_once 'partials/header.php';

    $user = new User();
    $id =(int) $_GET['id'];
    $user->show($id);

    //$user2 = new User();
    //$user2 = $user2->find($_GET['id']);
    //echo $user2->id;

    //echo $id;
    //echo $_SESSION['user_id'];


?>

<?php if($_SESSION['user_id'] === $id): ?>
                <a href="edit-profile.php?id=<?php echo $id;?>">EDIT</a>
<?php endif; ?>


