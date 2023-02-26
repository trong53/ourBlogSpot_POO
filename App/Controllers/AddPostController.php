<?php
namespace App\Controllers;
use App\Models\AddPostModel;

class AddPostController
{
    public $title, $content, $is_public, $image;
    public $add_post;

    public function __construct(){

        $this->title = (!empty($_POST['add-post-submit']))? $_POST['title'] : '';
        $this->content = (!empty($_POST['add-post-submit']))? $_POST['content'] : '';
        $this->is_public = (!empty($_POST['is_public']))? $_POST['is_public'] : 0;
        $this->image = (!empty($_FILES['image']['name']))? self::uploadFile() : './assets/img/blog.jpg';
        
        $this->add_post = new AddPostModel();
    }

    public function index() {
        
        $user_id = $_SESSION['user']['id'];
        $viewed = 0;
        $create_date = $update_date = date('Y-m-d');        

        if  (!empty($this->title) && !empty($this->content) && empty($_SESSION['user-notification'])) {
            
            $create_post = $this->add_post->createPost($this->title, $this->content, $this->image, $user_id, $this->is_public, $viewed, $create_date, $update_date);
            
            if ($create_post) {
                $message = 'Article saved successfully';
            }else{
                $message = 'Article was not saved !';
            }
        }
        
        render('views.AddPost', [
            'addPost_message'   => $message??''
        ]);
    }

    static public function uploadFile() {
        if (!empty($_FILES['image']['name'])){

            $directory_name = "img";
            $filename = $_FILES['image']['name'];
            $randomString = createRandomString(10);
        
            $source_file = $_FILES['image']['tmp_name'];
            $destination = $_SERVER['DOCUMENT_ROOT'];

            $destination .=  '\assets'. DIRECTORY_SEPARATOR. $directory_name. DIRECTORY_SEPARATOR. $randomString . '-' . $filename;
            move_uploaded_file($source_file, $destination);

            return '\assets'. DIRECTORY_SEPARATOR. $directory_name. DIRECTORY_SEPARATOR. $randomString . '-' . $filename;
        }
    }

}