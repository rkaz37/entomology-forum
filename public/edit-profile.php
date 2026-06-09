<?php
    include_once 'partials/header.php';

    $user = new User();

    if (!Auth::check() || $_SESSION['id'] != $_GET['id']) {
    Redirect::redirect('home.php');
    }

    $user_data = $user->find($_GET['id']);
    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    $user->update($_GET['id'], $username, $email, $bio);
    Redirect::redirect('profile.php?id=' . $_GET['id']);

    }
?>


<form class="login-form" method="POST">
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


                    

                    <button type="submit">
                        SAVE
                    </button>
                </form>