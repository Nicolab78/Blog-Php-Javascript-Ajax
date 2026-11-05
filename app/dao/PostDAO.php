<?php

require_once 'app/core/Database.php';
require_once 'app/models/Post.php';

class PostDAO{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    private function hydrate($row){
        return new Post($row['id'], $row['user_id'], $row['title'], $row['content'], $row['created_at'], $row['username']);
    }

    public function findAll(){
        $sql = 'SELECT p.*, u.username FROM posts p
                JOIN users u ON u.id = p.user_id
                ORDER BY p.created_at DESC';
        $rows = $this->pdo->query($sql)->fetchAll();
        return array_map([$this, 'hydrate'], $rows);
    }

    public function findById($id){
        $stmt = $this->pdo->prepare(
            'SELECT p.*, u.username FROM posts p
                   JOIN users u ON u.id = p.user_id
                   WHERE p.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }

    public function create(Post $post){
        $stmt = $this->pdo->prepare(
            'INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)'
        );
        $stmt->execute([$post->getUserId(), $post->getTitle(), $post->getContent()]);
        return $this->pdo->lastInsertId();
    }

    public function update(Post $post){
        $stmt = $this->pdo->prepare(
            'UPDATE posts SET title = ?, username = ? WHERE id = ?'
        );
        return $stmt->execute([$post->getTitle(), $post->getContent(), $post->getId()]);
    }

    public function delete($id){
        $stmt = $this->pdo->prepare('DELETE FROM posts WHERE id = ?');
        return $stmt->execute([$id]);
    }
}