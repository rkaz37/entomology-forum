<?php
class Auth
{
    public static function login(string $username, string $password): bool
    {
        try {
            $db = (new Database())->connect();

            $stmt = $db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);

            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user->password)) {
                return false;
            }

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user->id;
            $_SESSION['role'] = $user->role;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['bio'] = $user->bio;

            return true;

        } catch (PDOException $e) {
            print_r('Auth login error: ' . $e->getMessage());
            return false;
        }
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            Redirect::redirect('login.php');
        }
    }

    public static function id(): int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return ($_SESSION['role'] ?? null) === 'admin';
    }
}