<?php
require_once 'Model.php';
class Post extends Model
{

    public function showProfile(int $id): array
    {
        try {
            $stmt = $this->db->prepare("SELECT posts.*, users.username as username FROM posts JOIN users ON posts.user_id = users.id WHERE users.id = :id 
            ORDER BY posts.created_at DESC");
            $stmt->execute(['id' => $id]);

            return $stmt->fetchAll();
        } catch(PDOException $e) {
            return [];
        }
    }

    public function all(): array
    {
        try {
            $stmt = $this->db->query("SELECT posts.*, users.username as username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");

            return $stmt->fetchAll();
        } catch(PDOException $e) {            
            return [];
        }
    }

    public function find(int $id): object|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
            //$stmt = $this->db->prepare("SELECT * , users.username as username FROM posts JOIN users ON posts.user_id = users.id WHERE id = :id");
            $stmt->execute(['id' => $id]);

            return $stmt->fetch();
        } catch(PDOException $e){
            return false;
        }
    }
    //transakcie: bud sa vykona vsetko alebo nic
    public function create(string $title, string $content, int $user_id, $image): bool 
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO posts (title, content, user_id, image) VALUES (:title, :content, :user_id, :image)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['title' => $title, 'content' => $content, 'user_id' => $user_id, 'image' => $image]);

            $postId = $this->db->lastInsertId();

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            //Helper::log("Post::create ERROR: " . $e->getMessage(), 'ERROR');
            echo "aaaa";
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->db->prepare("DELETE FROM posts WHERE id = :id")->execute(['id' => $id]);
        } catch (PDOException $e) {
            //Helper::log("Post::delete ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }
}