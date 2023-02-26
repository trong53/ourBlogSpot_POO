<?php
namespace App\Controllers;
use App\Models\PostModel;

class PostController
{
    public $article_id;
    public $post_model;

    public function __construct() {
        $this->article_id = (!empty($_GET['id'])) ? $_GET['id'] : 0;
        $this->post_model = new PostModel();
    }

    public function index() {
        
        if (!checkNumberInteger($this->article_id)){
            render ('views.post', [
                'read_permission'    => false,
            ]);
            exit;
        }

        $recent_articles_allUsers = $this->post_model->getRecentPostsforUser();
        [$read_permission, $is_author] = $this->checkPermissionOfArticle();

        if ($read_permission) {
            $this->post_model->updateView($this->article_id);
        }

        $selected_article = $this->post_model->getPostforUser($this->article_id);
       
        render ('views.post', [
            'read_permission'           => $read_permission,
            'is_author'                 => $is_author,
            'id'                        => $this->article_id,
            'selected_article'          => $selected_article,
            'recent_articles_allUsers'  => $recent_articles_allUsers
        ]);
    }

    public function checkPermissionOfArticle() : array {
        $read_permission = false;
        $is_author = false;
        if ((int)($this->article_id) > 0) {

            if ($this->post_model->checkArticleIsPublic($this->article_id)){
                $read_permission = true;
            }else{
                $read_permission = $this->post_model->checkAuthorOfArticle($this->article_id, $_SESSION['user']['id']);
            }

            if (!empty($_SESSION['user'])) {
                $is_author = $this->post_model->checkAuthorOfArticle($this->article_id, $_SESSION['user']['id']);
            }
        }
        return [$read_permission, $is_author];
    }
}
