<?php
    include_once 'partials/header.php';

    $post = new Post();

    $potd = $post->find_potd();
?>

<div class="container inline">
    <h1>ENTOMOLOGY FORUMS</h1>
    <h3>Post of the day:</h3>
    <a class="container post flex" href="post.php?id=<?= $potd->id ?>">
                        <img class="posts_img" src="<?= $potd->image ?>">
                        <div>
                            <h3><?= htmlspecialchars($potd->title) ?></h3>
                            by
                            <b><?= htmlspecialchars($potd->username) ?></b>
                            <?= date('d.M/Y', strtotime($potd->created_at)); ?>  
                        </div>
    </a>
</div>

<?php include_once 'partials/footer.php'; ?>
