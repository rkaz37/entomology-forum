<?php
    include_once 'partials/header.php';
    $post = new Post();
    $comment = new Comment();

    $id = $_GET['id'];
    $comments = $comment->all($id);

    //echo count($comments);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'comment') {
    $content = $_POST['content'] ?? '';
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;


        $comment->create($content, $user_id, $id);

        header('Location: post.php?id=' . $id);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $cid = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($cid > 0) {
        $comment->delete($cid);
    }

    Redirect::redirect('post.php?id=' . $id);
    exit;
}
?>

<?php
    $p = $post->find($id);
    
?>
<div class="container" id="post">
    <h3> <?= $p->title ?></h3> 
    by 
    <b><a href="profile.php?id=<?= $p->user_id ?>"><?= $p->username ?></a></b>
    <br>
    <div class="flex">
        <img src="<?= $p->image ?>">
        <div>
            <p class="content"><?= htmlspecialchars($p->content) ?></p>
        </div>
    </div>
</div>

<div class="container" id="comments">

        <div>
                    <?php foreach ($comments as $c): ?>
                        <div class="comment">
                            <a href="profile.php?id= <?= $c->user_id ?>">
                            <img class="minipfp" src="<?= $c->image ?>">
                            <h3>  <?= htmlspecialchars($c->username) ?>: </a> </h3>
                            <p class="content"><?= htmlspecialchars($c->content) ?></p>
                            <?php if ($isAdmin): ?>
                                <form method="POST"  onsubmit="return confirm('Naozaj vymazať?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="type" value="post">
                                    <input type="hidden" name="id" value="<?php echo $c->id; ?>">
                                    <button type="submit" style="color:red; cursor:pointer;">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                            <?php echo '<br>' ?>

                            


                    <?php endforeach; ?>

                    <?php if (empty($comments)): ?>
                            <p> no comments!</p>
                    <?php endif; ?>

                    <?php if (Auth::check()): ?>
                        <button type="button" onclick="document.getElementById('commentForm').style.display='Block'">Comment</button>

                            <form method="POST" id="commentForm" enctype="multipart/form-data" style="display:none;">
                                <textarea name="content" rows="10" placeholder="add comment..." required></textarea>
                                <input type="hidden" name="action" value="comment">
                                <button type="submit" class="btn">send</button>
                            </form>

                    <?php endif; ?>
\
        </div>


<?php include_once 'partials/footer.php'; ?>