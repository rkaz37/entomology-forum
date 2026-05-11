<?php
    include_once 'partials/header.php';
    if($_SERVER['REQUEST_METHOD']==='POST'){
            


            $contact = new Contact();

            if($contact->store($_POST)){
                echo 'Formulár bol odoslaný';
            }
          }
?>

<div class="container" >
    <h3>Send message to us!</h3>
    <form class="container" name="contact-form" action="contact.php" method="POST">
        <input type="text" minlength="2" name="name" placeholder="Name" class="form-control" required>
        <br>
        <input type="email" name="email" placeholder="E-mail" class="form-control" required>
        <br>
        <textarea class="" name="message" placeholder="Message" style="height: 150px;" required></textarea>
        <br>
        <button type="submit" name="submit">Submit</button>
        <br>
    </form>
</div>