<?php
namespace App\Controllers;
use App\Models\PostModel;
use App\Controllers\AddPostController;

class ModifyPostController
{
    public $modify_article_id;
    public $post_model;

    public function __construct() {
        $this->modify_article_id = (!empty($_GET['modifyID']))?$_GET['modifyID']:0;
        $this->post_model = new PostModel();
    }

    public function index() {

        if (!checkNumberInteger($this->modify_article_id) || intval($this->modify_article_id) <= 0 ){
            header('Location: /error');
            exit;
        }

        $is_author = $this->post_model->checkAuthorOfArticle($this->modify_article_id, $_SESSION['user']['id']);
        if (!$is_author) {
            header('Location: /error');
            exit;

        }else{
            if (!empty($_POST['title'])&&!empty($_POST['content'])){

                $title = $_POST['title'];
                $content = $_POST['content'];
                $is_public = (!empty($_POST['is_public']))? (int)$_POST['is_public'] : 0;
                $image = (!empty($_FILES['image']['name']))? AddPostController::uploadFile() : '';

                $this->post_model->updatePost($title, $content, $image, $is_public, $this->modify_article_id);
                
                $modified_article =  $this->post_model->getPostforUser($this->modify_article_id);

                render('views.ModifyPost', [
                    'modified_article'      => $modified_article,
                    'modify_article_id'     => $this->modify_article_id,
                    'modifyPost_message'    => 'Article modified successfully'
                ]);

            }else{
                $modified_article =  $this->post_model->getPostforUser($this->modify_article_id);
                render('views.ModifyPost', [
                    'modified_article'      => $modified_article,
                    'modify_article_id'     => $this->modify_article_id
                ]);
            }
        }
    }
}