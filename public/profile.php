<?php
    include_once 'partials/header.php';

    $user = new User();
    $id =(int) $_GET['id'];
    $user = $user->find($id);
    $postModel = new Post();
    $allPosts = $postModel->showProfile($id);

    //$user2 = new User();
    //$user2 = $user2->find($_GET['id']);
    //echo $user2->id;

?>

<div class="container profile-all">
    <div class="profile">
        <img src="<?= $user->image ?>">
        <h2 class="username"> <?= $user->username ?> </h2>
        <p class="bio"> <?= $user->bio ?> </p>
    </div>
    <div class="profile-posts">
        <?php if (!empty($allPosts)): ?>
                <?php foreach ($allPosts as $p): ?>
                    <?php
                    /*
                        // Logika pre obrázok (rovnaká ako na home.php)
                        $imagePath = '../assets/images/item1.jpg'; // default
                        if (!empty($p->image)) {
                            if (file_exists(__DIR__ . '/../uploads/' . $p->image)) {
                                $imagePath = '../uploads/' . $p->image;
                            } else {
                                $imagePath = '../assets/images/' . $p->image;
                            }
                        }
                            */
                    ?>

                    <div class='container post'>
                        <div>  
                            <h3>
                                <a href="post.php?id=<?= $p->id ?>"> <?php echo htmlspecialchars($p->title); ?> </a>
                            </h3>               
                            
                            <div class="author">
                                <p> by 
                                    <a href="profile.php?id=<?= $p->user_id ?>"> <?= htmlspecialchars($p->username) ?> </a>
                                    -
                                    <time class="published">
                                        <?= date('d. M/Y', strtotime($p->created_at)); ?>
                                    </time>
                            </div>
                        </div>
                    </div>
                    <?php if ($isAdmin): ?>
                                <form method="POST"  onsubmit="return confirm('Naozaj vymazať?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="type" value="post">
                                    <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                                    <button type="submit" style="color:red; cursor:pointer;">
                                            Delete
                                    </button>
                                </form>
                    <?php endif; ?>

                <?php endforeach; ?>
            <?php else: ?>
                <div>
                    <p>No posts!</p>
                </div>
            <?php endif; ?>
    </div>
    <?php if(isset($_SESSION['id'])): ?>
        <?php if($_SESSION['id'] === (int) $_GET['id'] || $isAdmin): ?>
            <a href="edit-profile.php?id=<?php echo $id;?>">EDIT</a>
        <?php endif; ?>
    <?php endif; ?>
</div>



