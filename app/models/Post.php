<?php

class Post{
    private $id;
    private $user_Id;
    private $title;
    private $content;
    private $createdAt;
    private $author;

    public function __construct($id, $user_Id, $title, $content, $createdAt, $author){
        $this->id = $id;
        $this->user_Id = $user_Id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->author = $author;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->user_Id;
    }

    public function setUserId($user_Id): void
    {
        $this->user_Id = $user_Id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'author' => $this->author,
            'createdAt' => $this->createdAt,
        ];
    }



}