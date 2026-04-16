<?php
interface UserRepository {
    public function findByEmail(string $email): ?User;
    public function updatePassword(string $userId, string $newHash): void;
    public function updateToken(string $userId, string $token): void;
    public function findByToken(string $token): ?User;
}