<?php
    include_once 'partials/header.php';
    $post = new Post();
    $comment = new Comment();

    $id = $_GET['id'];
    $comments = $comment->all($id);

    //echo count($comments);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'comment') {
    $content = $_POST['content'] ?? '';
    $user_id = (int)$_SESSION['id'];


        $comment->create($content, $user_id, $id);

        Redirect::redirect('post.php?id=' . $id);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'commentdel') {
    $cid = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($cid > 0) {
        $comment->delete($cid);
    }

    Redirect::redirect('post.php?id=' . $id);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $pid = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($pid > 0) {
        $post->delete($pid);
    }

    Redirect::redirect('forum.php');
    exit;
}
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
    <?php if ($isAdmin || (Auth::check() && $_SESSION['id'] == $p->user_id)): ?>
                                <form method="POST"  onsubmit="return confirm('Delete?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="type" value="post">
                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                                    <button type="submit" style="color:red; cursor:pointer;">Delete</button>
                                </form>
<?php endif; ?>
</div>


<div class="container" id="comments">

        <div>
                    <?php foreach ($comments as $c): ?>
                        <div class="comment">
                            <a href="profile.php?id= <?= $c->user_id ?>">
                            <img class="minipfp" src="<?= $c->image ?>">
                            <h3>  <?= htmlspecialchars($c->username) ?>: </a> </h3>
                            <p class="content"><?= htmlspecialchars($c->content) ?></p>
                            <?php if ($isAdmin || (Auth::check() && $_SESSION['id'] == $c->user_id)): ?>
                                <form method="POST"  onsubmit="return confirm('Delete?')">
                                    <input type="hidden" name="action" value="commentdel">
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

        </div>


<?php include_once 'partials/footer.php'; ?>