<?php
namespace App\Controllers;
use App\Models\PostModel;

class DeletePostController
{
    public $delete_article_id;

    public function __construct() {
        $this->delete_article_id = (!empty($_GET['deleteID']))?$_GET['deleteID']:0;
        $this->post_model = new PostModel();
    }

    public function index() {
        
        if (!checkNumberInteger($this->delete_article_id) || intval($this->delete_article_id) <= 0 ){
            render ('views.post', [
                'read_permission'    => false,
            ]);
            exit;
        }

        $is_author = $this->post_model->checkAuthorOfArticle($this->delete_article_id, $_SESSION['user']['id']);

        if ($is_author) {
            $this->post_model->deleteArticle($this->delete_article_id);
        }

        header('Location: /');
    }
}