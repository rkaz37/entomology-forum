<?php
class Post
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function show(int $id)
    {
        try {
            $stmt = $this->db->query("SELECT title, content FROM posts WHERE id = " . $id);

            $post = $stmt->fetch();
            echo $post->title;
            echo $post->content;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function all(): array
    {
        try {
            $stmt = $this->db->query("SELECT posts.*, users.username as username 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            ORDER BY posts.created_at DESC");
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
            Helper::log("Post::find ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }
    //transakcie: bud sa vykona vsetko alebo nic
    public function create(string $title, string $slug, string $excerpt, string $content, string $image, string $status, int $user_id, ?string $published_at, array $categoryIds): bool 
    {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO posts (title, slug, excerpt, content, image, status, user_id, published_at) 
                    VALUES (:title, :slug, :excerpt, :content, :image, :status, :user_id, :published_at)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'title' => $title, 'slug' => $slug, 'excerpt' => $excerpt, 'content' => $content, 
                'image' => $image, 'status' => $status, 'user_id' => $user_id, 'published_at' => $published_at
            ]);

            $postId = $this->db->lastInsertId();
            $stmtCat = $this->db->prepare("INSERT INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)");
            
            foreach ($categoryIds as $categoryId) {
                $stmtCat->execute(['post_id' => $postId, 'category_id' => $categoryId]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            Helper::log("Post::create ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }

    public function update(int $id, string $title, string $slug, string $excerpt, string $content, string $image, string $status, int $user_id, ?string $published_at, array $categoryIds): bool 
    {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE posts SET title = :title, slug = :slug, excerpt = :excerpt, content = :content, 
                    image = :image, status = :status, user_id = :user_id, published_at = :published_at WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'id' => $id, 'title' => $title, 'slug' => $slug, 'excerpt' => $excerpt, 'content' => $content, 
                'image' => $image, 'status' => $status, 'user_id' => $user_id, 'published_at' => $published_at
            ]);

            $this->db->prepare("DELETE FROM post_category WHERE post_id = :id")->execute(['id' => $id]);
            
            $stmtCat = $this->db->prepare("INSERT INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)");
            foreach ($categoryIds as $categoryId) {
                $stmtCat->execute(['post_id' => $id, 'category_id' => $categoryId]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            Helper::log("Post::update ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            return $this->db->prepare("DELETE FROM posts WHERE id = :id")->execute(['id' => $id]);
        } catch (PDOException $e) {
            Helper::log("Post::delete ERROR: " . $e->getMessage(), 'ERROR');
            return false;
        }
    }

    public function getCategoryIdsByPost(int $postId): array
    {
        try {
            $stmt = $this->db->prepare("SELECT category_id FROM post_category WHERE post_id = :post_id");
            $stmt->execute(['post_id' => $postId]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            Helper::log("Post::getCategoryIdsByPost ERROR: " . $e->getMessage(), 'ERROR');
            return [];
        }
    }
}