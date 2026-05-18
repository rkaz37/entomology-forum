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

<?php if (Auth::check()): ?>
                <a href="create-post.php">+POST</a>
<?php endif; ?>


<section>
    <div>
        <div>
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
                        <figure>
                            <a href="post.php?id=<?php echo $p->id; ?>">
                                
                            </a>
                        </figure>
                        <div>
                            
                            <h3>
                                <a href="post.php?id=<?php echo $p->id; ?>">
                                    <?php echo htmlspecialchars($p->title); ?>
                                </a>
                            </h3>               
                            
                            <div>
                                <span class="author">
                                    <span class="sp">by</span>
                                    <span class="author-name">
                                        <?php echo htmlspecialchars($p->username ?? '???ERROR???'); ?>
                                    </span>
                                </span>
                                <span class="meta-date">
                                    <span class="sp">-</span>
                                    <time class="published">
                                        <?php echo date('M d, Y', strtotime($p->created_at)); ?>
                                    </time>
                                </span>
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
    </div>
</section>

