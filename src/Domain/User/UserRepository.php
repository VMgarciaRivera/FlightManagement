<?php
interface UserRepository {
    public function findByEmail(string $email): ?User;
    public function updatePassword(string $userId, string $newHash): void;
    public function updateToken(string $userId, ?string $token): void;
    public function findByToken(string $token): ?User;
    public function deleteToken(string $userId): void;
    public function updateResetToken(string $userId, ?string $token): void;
    public function findByResetToken(string $token): ?User;
}