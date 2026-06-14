<?php
    include_once 'partials/header.php';

    $postModel = new Post();
    $allPosts = $postModel->all();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $pid = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($pid > 0) {
        $postModel->delete($pid);
    }

    header('Location: forum.php');
    exit;
}
?>

<div class="container">
<?php if (Auth::check()): ?>
                <a class="button" margin="5px" href="create-post.php">+POST</a>
<?php endif; ?>



    <div>
        <div>
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
                        <?php if ($isAdmin || $_SESSION['id'] == $p->user_id): ?>
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
    </div>
</div>

