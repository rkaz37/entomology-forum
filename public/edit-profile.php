<?php
    include_once 'partials/header.php';

    $user = new User();

    if ($_SESSION['id'] != $_GET['id']) {
        if(!$isAdmin){
            Redirect::redirect('home.php');
        }
    }


    $user_data = $user->find($_GET['id']);
    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $image = $_POST['image'] ?? $user_data->image;

    if(!$user->usernameValidation($username)){
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
        $user->update($_GET['id'], $username, $email, $bio, $image);
        Redirect::redirect('profile.php?id=' . $_GET['id']);
    }
    else{
        echo "username already taken";
    }

    }
?>


<form class="login-form" method="POST" enctype="multipart/form-data">
    <div>
        <label class="form-label" for="username">username</label>
                        <input type="text"
                            id="username"
                            name="username"
                            class="form-input"
                            placeholder="your cool username :3"
                            value="<?= htmlspecialchars($user_data->username) ?>"
                            required
                        >



        <label class="form-label" for="email">email</label>
                        <input type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="email"
                            value="<?= htmlspecialchars($user_data->email) ?>"
                            required
                        >                
        <label class="form-label" for="bio">bio</label>
                        <input type="text"
                            id="bio"
                            name="bio"
                            class="form-input"
                            placeholder="bio"
                            value="<?= htmlspecialchars($user_data->bio) ?>"
                        > 

                <label class="form-label" for="image">Obrázok</label>
                <input
                    id="image"
                    type="file"
                    name="image"
                    value=".jpg,.jpeg,.png,.webp"
                    style="width:100%; padding:0.85rem 1rem;"
                >



                    

                    <button type="submit">
                        SAVE
                    </button>
                </form>