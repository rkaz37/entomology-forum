<?php
    include_once 'partials/header.php';

    $post = new Post();
    $user = new User();

    $posts = $post->all();
    $users = $user->all();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $type = $_POST['type'] ?? '';

    if ($id > 0) {

        if ($type === 'post') {
            $post->delete($id);
        }

        if ($type === 'category') {
            $category->delete($id);
        }

        if ($type === 'user') {
            $user->delete($id);
        }

    }

    header('Location: admin.php');
    exit;
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'logout')
        {
            $validate = new Validate();

            $validate->logout();
        }

    include_once 'partials/header-admin.php';
    
?>


<div class="container">
        <div>
            <p># of posts: <?php echo count($posts); ?></p>
        </div>
        <div>
            <p># of users: <?php echo count($users); ?></p>
        </div>

</div>

<div class="container" id="posts">
        <div>
            <div>
                <h3>Posts</h3>
                <p class="card-subtitle">CRUD for posts</p>
            </div>
            <a href="blog-post-create.php" class="btn btn-ghost">+ New Post</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>User ID</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $p): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($p->id); ?></td>
                            <td>
                                <div>
                                    <?php echo htmlspecialchars($p->title); ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($p->user_id); ?></td>
                            <td><?php echo htmlspecialchars($p->created_at); ?></td>
                            <td>
                                <?php if ($p->status === 'published'): ?>
                                    <span>Published</span>
                                <?php else: ?>
                                    <span>Draft</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                                    <a href="blog-post-edit.php?id=<?php echo $p->id; ?>" class="btn btn-ghost">
                                        Edit
                                    </a>

                                    <form method="POST"  onsubmit="return confirm('Naozaj vymazať?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="type" value="post">
                                        <input type="hidden" name="id" value="<?php echo $p->id; ?>">
                                        <button type="submit" style="color:red; cursor:pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($posts)): ?>
                        <tr>
                            <td colspan="7" style="text-align:center;">Žiadne blog posty neboli nájdené.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container" id="users">
        <div>
            <div>
                <h3>Users</h3>
                <p>CRUD for users</p>
            </div>
            <a href="user-create.php" class="btn btn-ghost">+ New User</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>username</th>
                        <th>Email</th>
                        <th>Rola</th>
                        <th>Počet postov</th>
                        <th>Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($u->id); ?></td>
                            <td><?php echo htmlspecialchars($u->username); ?></td>
                            <td><?php echo htmlspecialchars($u->email); ?></td>
                            <td><?php echo htmlspecialchars($u->role); ?></td>
                            <td><?php echo htmlspecialchars($u->posts_count ?? 0); ?></td>
                            <td>
                                <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                                    <a href="user-edit.php?id=<?php echo $u->id; ?>" class="btn btn-ghost">
                                        Edit
                                    </a>

                                    <form method="POST" style="display:inline;" onsubmit="return confirm('Naozaj vymazať?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="type" value="user">
                                        <input type="hidden" name="id" value="<?php echo $u->id; ?>">
                                        <button type="submit" class="btn btn-ghost" style="color:red; cursor:pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Žiadni používatelia neboli nájdení.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

