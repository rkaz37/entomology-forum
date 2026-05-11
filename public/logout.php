<?php
require_once '../app/core/App.php';
App::init();

// reálne odhlásenie
Auth::logout();

// presmerovanie (najčistejšie riešenie)
Redirect::redirect('home.php');
exit;
?>