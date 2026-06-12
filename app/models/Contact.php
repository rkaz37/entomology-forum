<?php
require_once 'Model.php';
class Contact extends Model
{

    public function store(array $data): bool
    {

        $sql = "INSERT INTO contacts (username, email, message) VALUES (:username, :email, :message)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['username' => $data['name'], 'email' => $data['email'],'message' => $data['message']]);
    }
}