<?php
session_start();
require 'vendor/autoload.php';

use App\Database\Database;
use App\Controllers\HomeController;
use App\Controllers\SignupController;
use App\Controllers\SigninController;
use App\Controllers\SignoutController;
use App\Controllers\PostController;
use App\Controllers\AddPostController;
use App\Controllers\ModifyPostController;
use App\Controllers\DeletePostController;
use App\Controllers\HomeAdminController;

if (empty($_SESSION['database'])) {
    $db = new Database();
    $db->createTableAdmin();
    $db->createTableUsers();
    $db->createTablePosts();
    $_SESSION['database'] = 'true';
}

switch (getUri()) {
    case '/':
        if (!empty($_SESSION['__ADMIN__'])){
            $home_admin = new HomeAdminController();
            $home_admin->index();
            die;
        }
        if (empty($_SESSION['user'])){
            $home = new HomeController();
            $home->showHomePageGuest();

        }else{
            $home = new HomeController();
            $home->showHomePageUser();
        }
        break;
    
    case '/notshow-notif':
        $_SESSION['user-notification-show']='not-show';
        break;

    case '/post':
        $post = new PostController();
        $post->index();
        break;
    
    case '/active-users' :
        $user_stat = new HomeAdminController();
        echo $user_stat->userStat();
        break;
    
    case '/user-abonnement' :
        $abonnement_year = json_decode(file_get_contents('php://input', true));
        if (!empty($abonnement_year) && checkNumberInteger($abonnement_year) && intval($abonnement_year) > 0 ) {
            $user_stat_abonnement = new HomeAdminController();
            echo $user_stat_abonnement->userAbonnementStat((int)$abonnement_year);
        }else{
            echo json_encode('no data');
        }
        break;
    
    case '/addPost':
        if (!empty($_SESSION['user']) && empty($_SESSION['user-notification'])) {
            $add_post = new AddPostController();
            $add_post->index();
        }else{
            header('Location: /error');
        }
        break;
    
    case '/modifyPost':
        if (!empty($_SESSION['user'])) {
            $modify_post = new ModifyPostController();
            $modify_post->index();
        }else{
            header('Location: /error');
        }
        break;

    case '/deletePost':
        if (!empty($_SESSION['user'])) {
            $delete_post = new DeletePostController();
            $delete_post->index();
        }else{
            header('Location: /error');
        }
        break;
    
    case '/signup':
        if (empty($_POST['submit-signup'])){
            render('views.signup');
            die;
        }
        $sign_up = new SignupController();        
        $sign_up->index();
        break;
    
    case '/signup-check-field' :
        $field_tochecked = json_decode(file_get_contents('php://input', true));
        if (!empty($field_tochecked)) {
            $sign_up = new SignupController();        
            echo json_encode(($sign_up->checkNotExist($field_tochecked)));
        }
        break;
        
    case '/signin':
        if (!empty($_SESSION['user'])){
            header('Location : /');
            die;
        }
        if (empty($_POST['submit-signin'])){
            render('views.signin');
            die;
        }
        $sign_in = new SigninController();
        $sign_in->index();
        break;

    case '/signout':
        $sign_out = new SignoutController();
        $sign_out->signout();
        break;

    case '/error':
        render('views.error404');
        die;
        break;

    default :
        render('views.error404');
        die;
        break;
};
