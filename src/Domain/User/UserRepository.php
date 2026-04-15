<?php
interface UserRepository {
    public function findByEmail(string $email): ?User;
    public function updatePassword(string $userId, string $newHash): void;
}