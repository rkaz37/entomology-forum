<?php
    include_once 'partials/header.php';
    if($_SERVER['REQUEST_METHOD']==='POST'){
            


            $contact = new Contact();

            if($contact->store($_POST)){
                echo 'Formulár bol odoslaný';
            }
          }
?>

<div class="container form" >
    <h1>Send message to us!</h1>
    <form class="form" method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <textarea name="message" placeholder="Message" style="height: 150px;" required></textarea>
        <button type="submit" name="submit" class="button">Submit</button>
        <br>
    </form>
</div>

<?php include_once 'partials/footer.php'; ?>