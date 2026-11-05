<?php

class Comment{
    private $id;
    private $postId;
    private $userId;
    private $content;
    private $createdAt;
    private $author;

    public function __construct($id, $postId, $userId, $content, $createdAt, $author){
        $this->id = $id;
        $this->postId = $postId;
        $this->userId = $userId;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'postId' => $this->postId,
            'userId' => $this->userId,
            'content' => $this->content,
            'author' => $this->author,
            'createdAt' => $this->createdAt,
        ];
    }
}