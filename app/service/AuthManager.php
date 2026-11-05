<?php

class AuthManager{
    public static function isLoggedIn(){
        return isset($_SESSION['user']);
    }

    public static function hasRole($role){
        return ($_SESSION['role'] ?? null) === $role;
    }

    public static function requireRole($role){
        self::requireRole([$role]);
    }

    public static function requireRoles(array $roles){
        if (!self::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Non Connecté']);
            exit;
        }

        if (!in_array($_SESSION['role'], $roles)) {
            http_response_code(403);
            echo json_encode(['error' => 'Accès refusé']);
            exit;
        }
    }
}