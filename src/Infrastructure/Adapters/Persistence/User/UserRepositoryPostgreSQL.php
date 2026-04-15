<?php
class UserRepositoryPostgreSQL implements UserRepository {
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function findByEmail(string $email): ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User($row['id'], $row['email'], $row['password']);
    }

    public function updatePassword(string $userId, string $newHash): void {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newHash, $userId]);
    }
}