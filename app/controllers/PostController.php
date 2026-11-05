<?php

require_once 'app/models/Post.php';
require_once 'app/dao/PostDAO.php';
require_once 'app/service/AuthManager.php';

class PostController{
    private $postDAO;

    public function __construct(){
        $this->postDAO = new PostDAO();
    }

    private function json($data, $code = 200){
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function requireOwnerOrAdmin(Post $post){
        AuthManager::requireRole(['user', 'admin']);
        if ($post->getUserId() !== $_SESSION['user_id'] && !AuthManager::hasRole('admin')) {
            $this->json(['error' => 'Accès refusé'], 403);
        }
    }

    public function index(){
        try{
            $posts = $this->postDAO->findAll();
            $this->json(array_map(fn($p) => $p->toArray(), $posts));
        } catch (Exception $e){
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id){
        try{
            $posts = $this->postDAO->findById($id);
            if (!$posts) {
                $this->json(['error' => 'Post non trouvé'], 404);
            }
            $this->json($posts->toArray());
        } catch (Exception $e){
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(){
        AuthManager::requireRole(['user','admin']);
        try {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');

            if ($title == '' || $content == '') {
                $this->json(['error' => 'Tout les champs sont requis'], 400);
            }

            $post = new Post($title, $content, $_SESSION['user_id']);
            $id = $this->postDAO->create($post);
            $this->json(['sucess' => true, 'id' => $id], 201);
        } catch (Exception $e){
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id){
        try{
            $post = $this->postDAO->findById($id);
            if (!$post) {
                $this->json(['error' => 'Post non trouvé'], 404);
            }

            $this->requireOwnerOrAdmin($post);

            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            if ($title == '' || $content == '') {
                $this->json(['error' => 'Tout les champs sont requis'], 400);
            }

            $post->setTitle($title);
            $post->setContent($content);
            $this->postDAO->update($post);
            $this->json(['sucess' => true]);
        } catch (Exception $e){
            $this->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id){
        try {
            $post = $this->postDAO->findById($id);
            if (!$post) {
                $this->json(['error' => 'Post non trouvé'], 404);
            }

            $this->requireOwnerOrAdmin($post);

            $this->postDAO->delete($post);
            $this->json(['sucess' => true]);
        } catch (Exception $e){
            $this->json(['error' => $e->getMessage()], 500);
        }
    }


}