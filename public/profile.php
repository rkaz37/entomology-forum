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