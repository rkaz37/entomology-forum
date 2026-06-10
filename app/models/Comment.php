<?php
require_once 'Model.php';
class Comment extends Model
{

    public function show(int $id)
    {
        try {
            $stmt = $this->db->query("SELECT comments.*, users.username as username 
            FROM comments 
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = " . $id);

            $post = $stmt->fetch();
            echo $post->title;
            echo $post->content;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function all(int $id): array
    {
        try {
            $stmt = $this->db->query("SELECT comments.*, users.username as username 
            FROM comments 
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = " . $id);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            
            return [];
        }
    }

    public function find(int $id): object|false
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            //Helper::log("Post::find ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }

    //transakcie: bud sa vykona vsetko alebo nic
    public function create(string $content, int $user_id, int $id): bool 
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO comments (post_id, content, user_id) 
                    VALUES (:id, :content, :user_id)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id, 'content' => $content, 'user_id' => $user_id
            ]);

            $postId = $this->db->lastInsertId();
            

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            //Helper::log("Post::create ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->db->prepare("DELETE FROM comments WHERE id = :id")->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    
}