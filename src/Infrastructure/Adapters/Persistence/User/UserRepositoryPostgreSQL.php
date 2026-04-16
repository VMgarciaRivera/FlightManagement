<?php
class UserRepositoryPostgreSQL implements UserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User($row['id'], $row['email'], $row['password']);
    }

    public function updatePassword(string $userId, string $newHash): void
    {
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newHash, $userId]);
    }

    public function updateToken(string $userId, ?string $token): void
    {
        $stmt = $this->db->prepare("UPDATE users SET token = ? WHERE id = ?");
        $stmt->execute([$token, $userId]);
    }

    public function findByToken(string $token): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE token = ?");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        return new User($row['id'], $row['email'], $row['password']);
    }

    public function deleteToken(string $userId): void
    {
        $stmt = $this->db->prepare("UPDATE users SET token = NULL WHERE id = ?");
        $stmt->execute([$userId]);
    }

    public function updateResetToken(string $userId, ?string $token): void
    {
        $stmt = $this->db->prepare("UPDATE users SET reset_token = ? WHERE id = ?");
        $stmt->execute([$token, $userId]);
    }

    public function findByResetToken(string $token): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE reset_token = ?");
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new User($row['id'], $row['email'], $row['password'], $row['reset_token']) : null;
    }
}
