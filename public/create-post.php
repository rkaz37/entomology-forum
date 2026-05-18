<?php
    include_once 'partials/header.php';

    $post = new Post();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 1;
    $published_at = $_POST['published_at'] ?? null;



        $post->create(
            $title,
            $content,
            $user_id
        );

        header('Location: forum.php');
        exit;
    }

?>

<main class="main-content">
    <div class="page-header">
        <h1 class="greeting">Create Blog Post</h1>
        <p class="greeting-sub">Samostatná stránka pre vytvorenie nového blog postu.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">New Post Form</h3>
                <p class="card-subtitle">Formulár pre vytvorenie blog postu</p>
            </div>
            <span class="badge badge-green">Create</span>
        </div>
//data z roznych zdrojov
        <form method="POST" enctype="multipart/form-data" style="padding:0 1.5rem 1.5rem;">

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1rem; margin-bottom:1rem;">
                <div>
                    <label>Názov</label>
                    <input
                        type="text"
                        name="title"
                        placeholder="Zadaj názov blog postu"
                        required
                        style="width:100%; padding:0.85rem 1rem;"
                    >
                </div>


            </div>


            <div style="margin-bottom:1rem;">
                <label>Obsah</label>
                <textarea
                    name="content"
                    rows="10"
                    placeholder="Sem príde obsah blog postu..."
                    required
                    style="width:100%; padding:0.85rem 1rem;"
                ></textarea>
            </div>


    <button type="submit" class="btn">Save Post</button>
</form>
</main>