<?php
    include_once 'partials/header.php';

    $post = new Post();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $user_id = $_SESSION['id'];
        $published_at = $_POST['published_at'] ?? null;
        $image = $_POST['image'] ?? '../vault/default.png';


        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0){
            $originalName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($extension, $allowedExtensions)) {
                $image = '../vault/' . time() . '-' . basename($originalName);

                move_uploaded_file($tmpName, $image);
            }
        }
        $post->create($title, $content, $user_id, $image);

        Rdirect::redirect('forum.php');
        exit;
    }

?>

<div class="container">
        <h1>Create Blog Post!</h1>
        <form method="POST" enctype="multipart/form-data" style="padding:0 1.5rem 1.5rem;">

            <div class="container">
                <div class="flex">
                    <label>Title:</label>
                    <input type="text" name="title" placeholder="Add title..." required>
                </div>

                <div class="flex">
                    <label>Content:</label>
                    <textarea name="content" rows="10" placeholder="Add content..." required></textarea>
                </div>

                <div class="flex">
                    <label>Image:</label>
                    <input id="image" type="file" name="image" value=".jpg,.jpeg,.png,.webp">
                </div>

                <button type="submit" class="button">Save Post</button>
        </form>
</div>

<?php include_once 'partials/footer.php'; ?>