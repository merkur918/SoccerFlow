<?php

class SessionManager
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setUser($userData): void
    {
        $_SESSION['user'] = $userData;
        $_SESSION['logged_in'] = true;
    }

    public function getUser()
    {
        return $_SESSION['user'] ?? null;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        session_start();
    }

    public function hasLevel($requiredLevel): bool
    {
        $user = $this->getUser();
        if (!$user) return false;
        
        return ($user['nivel'] ?? 0) >= $requiredLevel;
    }
}