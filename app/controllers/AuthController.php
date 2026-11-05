<?php

class AuthController{

    private $userDAO;

    public function __construct(){
        $this->userDAO = new UserDAO();
    }

    private function json($data, $code = 200){
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function me(){
        if (!AuthManager::isLoggedIn()){
            $this->json(['logged_in' => false]);
        }

        $this->json([
            'logged_in' => true,
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role']
        ]);
    }

    public function authenticate(){
        try{
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $user = $this->userDAO->findByEmail($email);
            if (!$user || !password_verify($password, $user->getPasswordHash)) {
                $this->json(['error' => 'Identifiants incorrects'], 401);
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['role'] = $user->getRole();


        }
    }
}