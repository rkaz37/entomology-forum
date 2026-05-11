<?php

class User
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // READ - všetci používatelia + ich posty
    public function all(): array
    {
        try {
            $sql = "
                SELECT u.*, COUNT(p.id) as posts_count
                FROM users u
                LEFT JOIN posts p ON p.user_id = u.id
                GROUP BY u.id
                ORDER BY u.id DESC
            ";

            return $this->db->query($sql)->fetchAll();
        } catch (Exception $e) {
            Helper::log('User::all - ' . $e->getMessage());
            return [];
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
            Helper::log('User::find - ' . $e->getMessage());
            return false;
        }
    }

    // CREATE
    public function create(
        string $name,
        string $email,
        string $password,
        string $role,
        ?string $bio = null
    ): bool
    {
        try {
            $sql = "
                INSERT INTO users (name, email, password, role, bio)
                VALUES (:name, :email, :password, :role, :bio)
            ";

            $stmt = $this->db->prepare($sql);

            return $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
                'bio' => $bio
            ]);
        } catch (Exception $e) {
            Helper::log('User::create - ' . $e->getMessage());
            return false;
        }
    }

    // UPDATE
    public function update(
        int $id,
        string $name,
        string $email,
        string $password,
        string $role,
        ?string $bio = null
    ): bool
    {
        try {
            if (!empty($password)) {
                $sql = "
                    UPDATE users
                    SET name = :name,
                        email = :email,
                        password = :password,
                        role = :role,
                        bio = :bio
                    WHERE id = :id
                ";

                $params = [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => $role,
                    'bio' => $bio
                ];
            } else {
                $sql = "
                    UPDATE users
                    SET name = :name,
                        email = :email,
                        role = :role,
                        bio = :bio
                    WHERE id = :id
                ";

                $params = [
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'role' => $role,
                    'bio' => $bio
                ];
            }

            $stmt = $this->db->prepare($sql);
            return $stmt->execute($params);

        } catch (Exception $e) {
            Helper::log('User::update - ' . $e->getMessage());
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