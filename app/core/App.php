<?php

class App
{
    public static function init(): void
    {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        // Core
        require_once __DIR__ . '/Redirect.php';
        require_once __DIR__ . '/Database.php';
        require_once __DIR__ . '/Title.php';
        require_once __DIR__ . '/Auth.php';

        // Models
        //require_once __DIR__ . '/../models/Category.php';
        require_once __DIR__ . '/../models/Contact.php';
        require_once __DIR__ . '/../models/Post.php';
        //require_once __DIR__ . '/../models/User.php';
    }
}
?>