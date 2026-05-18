<?php
require_once 'Model.php';
class Contact extends Model
{

    public function store(array $data): bool
    {
        // validácia
        /*
        if ($this->name === '' || $this->email === '' || $this->message === '') {
            echo "Vyplň všetky polia!";
            return false;
        }*/

        /*if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            echo "Email nemá správny formát!";
            return false;
        }*/

        $sql = "INSERT INTO contacts (username, email, message)
                VALUES (:username, :email, :message)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'username' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message']
        ]);
    }
}