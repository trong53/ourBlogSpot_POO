<?php
namespace App\Controllers;
use App\Models\SigninModel;

class SigninController 
{
    public $email, $password;
    public $signin_model;

    public function __construct() {
        $this->password = (!empty($_POST['submit-signin']))? $_POST['password'] : '';
        $this->email = (!empty($_POST['submit-signin']))? $_POST['email'] : '';
        $this->signin_model = new SigninModel();
    }

    public function index() {
        if ($this->checkAdmin()){
            $this->loadPageAdmin();
            exit;
        }
        $this->loadPageUser();
    }

    private function loadPageUser(){

        $user_info = $this->signin_model->getUserInfo($this->email);
        $password = $user_info['password']??'no_data';

        if (!empty($password) && password_verify($this->password, $password)) {
            
            if ($user_info['is_block'] == 1) {
                render('views.signin', [
                    'warning'      => 'warning'
                ]);
                die;
            }
            if ($user_info['permission'] == 0) {
                $_SESSION['user-notification'] = "user-notification";
                $_SESSION['user-notification-show'] = "show";
            }

            $_SESSION['user'] = $this->signin_model->getUserData($this->email);
            header('Location: /');
            
        }else{
            $notification = 'Incorrect email or password';
            render('views.signin', [
                'notification'      => $notification ??''
            ]);
        }
    }

    private function checkAdmin() {
        if ($this->email === CONFIG_DB['admin']) {
            return true;
        }
    }

    private function loadPageAdmin(){

        $password = $this->signin_model->getPassAdmin($this->email);

        if (password_verify($this->password,  $password)) {
            $_SESSION['__ADMIN__'] = $this->signin_model->getAdminData($this->email);
            header('Location: /');
        }else{
            $notification = 'Incorrect email or password';
            render('views.signin', [
                'notification'      => $notification ??''
            ]);
        }
    }
}

