<?php
    include_once 'partials/header.php';
    $post = new Post();
    $comment = new Comment();

    $id = $_GET['id'];
    $comments = $comment->all($id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;


        $comment->create(
            $content,
            $user_id,
            $id
        );

        header('Location: post.php?id=' . $id);
        exit;
    }
?>

<?php
    $post->show($id);
    
?>

<div class="container" id="comments">

        <div>
                    <?php foreach ($comments as $c): ?>
                            <?php echo htmlspecialchars($c->username); ?>
                            <?php echo htmlspecialchars($c->content); ?>
                            <?php echo '<br>' ?>
                            


                    <?php endforeach; ?>

                    <?php if (empty($comments)): ?>
                            <p> no comments</p>
                    <?php endif; ?>

                    <?php if (Auth::check()): ?>
                    <form method="POST" enctype="multipart/form-data" style="padding:0 1.5rem 1.5rem;">

            <div style="margin-bottom:1rem;">
                <textarea
                    name="content"
                    rows="10"
                    placeholder="add cooment"
                    required
                    style="width:100%; padding:0.85rem 1rem;"
                ></textarea>
            </div>


    <button type="submit" class="btn">send</button>
</form>
                    <?php endif; ?>
        </div>
    </div>