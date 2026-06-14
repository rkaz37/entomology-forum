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

            if ($type === 'user') {
                $user->delete($id);
            }

        }

        Redirect::redirect('admin.php');
        exit;
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'potd'){
        $post->potd($_POST['id']);
        Redirect::redirect('admin.php');
        exit;
    }
    
    
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
            <h3>Posts:</h3>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>User ID</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $p): ?>
                        <tr>
                            <td>#<?= htmlspecialchars($p->id) ?></td>
                            <td><?= htmlspecialchars($p->title) ?></td>
                            <td><?= htmlspecialchars($p->user_id) ?></td>
                            <td><?= htmlspecialchars($p->created_at) ?></td>
                            <td>
                                <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
                                    <form method="POST"  onsubmit="return confirm('Make post of the day?')">
                                        <input type="hidden" name="action" value="potd">
                                        <input type="hidden" name="type" value="post">
                                        <input type="hidden" name="id" value="<?= $p->id ?>">
                                        <button type="submit" style="color:red; cursor:pointer;">
                                            potd
                                        </button>
                                    </form>

                                    <form method="POST"  onsubmit="return confirm('Delete?')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="type" value="post">
                                        <input type="hidden" name="id" value="<?= $p->id ?>">
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
                                    <a href="edit-profile.php?id=<?php echo $u->id; ?>" class="btn btn-ghost">
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

<?php include_once 'partials/footer.php'; ?>