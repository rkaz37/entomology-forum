<?php
require_once 'Model.php';
class User extends Model
{

    // READ - všetci používatelia + ich posty
    public function all(): array
    {
        try {
            $sql = "SELECT u.*, COUNT(p.id) as posts_count FROM users u LEFT JOIN posts p ON p.user_id = u.id GROUP BY u.id ORDER BY u.id DESC";

            return $this->db->query($sql)->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    public function show(int $id)
    {
        try {
            $stmt = $this->db->query("SELECT * FROM users WHERE id = " . $id);

            $user = $stmt->fetch();
        
            echo '<img src="' . $user->image . '">';
            echo $user->username;
            echo '<br>';
            echo $user->bio;

        } catch (PDOException $e) {
            return false;
        }
    }

    // READ - jeden používateľ
    public function find(int $id): object|false
    {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            return false;
        }
    }

    // CREATE
    public function create(string $username, string $email, string $password): bool
    {
        try {
            $this->db->beginTransaction();
            $sql = "INSERT INTO users (username, email, password, role, image) VALUES (:username, :email, :password, :role, :image)";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => 'user',
                'image' => '../vault/default.png']);

            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            return false;
        }
    }

    // UPDATE
    public function update(int $id, string $username, string $email, string $bio): bool
    {
        try {
                $sql = "UPDATE users SET username = :username, email = :email, bio = :bio WHERE id = :id";

                $params = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'bio' => $bio
                ];
            

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (Exception $e) {
            return false;
        }
    }

    // DELETE
    public function delete(int $id): bool
    {
        try {
            $sql = "DELETE FROM users WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);

        } catch (Exception $e) {
            Helper::log('User::delete - ' . $e->getMessage());
            return false;
        }
    }
}