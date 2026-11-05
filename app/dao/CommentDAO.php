<?php

require_once 'app/core/Database.php';
require_once 'app/models/Comment.php';

class CommentDAO{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    private function hydrate($row){
        return new Comment(
            $row['id'], $row['postId'], $row['userId'], $row['content'], $row['created_at'], $row['username']
        );
    }

    public function findByPostId($postId){
        $stmt = $this->pdo->prepare(
            'SELECT c.*, u.username FROM comments c
                   JOIN users u ON u.id = c.user_id
                   WHERE c.post_id = ?
                   ORDER BY c.created_at DESC'
        );
        $stmt->execute([$postId]);
        return array_map([$this, 'hydrate'], $stmt->fetchAll());

    }

    public function findById($id){
        $stmt = $this->pdo->prepare(
            'SELECT c.*, u.username FROM comments c
                   JOIN users u ON u.id = c.user_id
                   WHERE c.id = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? $this->hydrate($row) : null;
    }

    public function create(Comment $comment){
        $stmt = $this->pdo->prepare(
            'INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)'
        );
        $stmt->execute([$comment->getPostId(), $comment->getUserId(), $comment->getContent()]);
        return $this->pdo->lastInsertId();
    }

    public function delete($id){
        $stmt = $this->pdo->prepare('DELETE FROM comments WHERE id = ?');
        return $stmt->execute([$id]);
    }
}