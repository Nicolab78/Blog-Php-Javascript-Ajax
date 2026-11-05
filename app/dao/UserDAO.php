<?php

require_once 'app/core/Database.php';
require_once 'app/models/User.php';

class UserDAO{
    private $pdo;


    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    private function hydrate($row){
        return new User(
            $row['id'], $row['username'], $row['email'], $row['password'], $row['role']
        );
    }

    public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }

    public function usernameExists($username){
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM user WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists($email){

    }


}