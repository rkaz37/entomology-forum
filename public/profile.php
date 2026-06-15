<?php
    include_once 'partials/header.php';

    $user = new User();
    $id =(int) $_GET['id'];
    $user = $user->find($id);
    $postModel = new Post();
    $allPosts = $postModel->showProfile($id);

?>

<div class="container profile-all">
    <div class="profile">
        <img src="<?= $user->image ?>">
        <h2 class="username"> <?= $user->username ?> </h2>
        <p class="bio"> <?= $user->bio ?> </p>
    </div>
    <div class="profile-posts scroll">
        <?php if (!empty($allPosts)): ?>
                <?php foreach ($allPosts as $p): ?>
                    <a class="container post flex" href="post.php?id=<?= $p->id ?>">
                        <img class="posts_img" src="<?= $p->image ?>">
                        <div>
                            <h3><?= htmlspecialchars($p->title) ?></h3>
                            by
                            <b><?= htmlspecialchars($p->username) ?></b>
                            <?= date('d.M/Y', strtotime($p->created_at)); ?>
                                
                            
                        </div>
                        <?php if ($isAdmin || (Auth::check() && ($_SESSION['id'] == $p->user_id))): ?>
                                <form method="POST"  onsubmit="return confirm('delete?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="type" value="post">
                                    <input type="hidden" name="id" value="<?= $p->id ?>">
                                    <button type="submit" style="color:red; cursor:pointer;">
                                            Delete
                                    </button>
                                </form>
                        <?php endif; ?>  
                    </a>
                    

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



<?php include_once 'partials/footer.php'; ?>