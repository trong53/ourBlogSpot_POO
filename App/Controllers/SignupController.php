<?php
namespace App\Controllers;
use App\Models\SignupModel;

class SignupController 
{
    public $name, $password, $email, $pseudo;
    public $signup_model;

    public function __construct() {
        $this->name = (!empty($_POST['submit-signup']))? $_POST['name'] : '';
        $this->password = (!empty($_POST['submit-signup']))? $_POST['password'] : '';
        $this->pseudo = (!empty($_POST['submit-signup']))? $_POST['pseuso'] : '';
        $this->email = (!empty($_POST['submit-signup']))? $_POST['email'] : '';
        $this->signup_model = new SignupModel();
    }
    public function index() : void {

        $validate_fields = $this->checkAllFields([
            [$this->name, 'name'],
            [$this->password, 'password'],
            [$this->email, 'email'],
            [$this->pseudo, 'pseudo'],
        ]);

        $check_not_exist = $this->checkNotExist([
            [$this->email, 'email'],
            [$this->pseudo, 'pseudo']
        ]);
        
        $validation = $validate_fields * $check_not_exist;

        if ($validation) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->signup_model->insertUser($this->name, $this->pseudo, $this->email, $this->password);
            $notification = "Account created successfully.";
        }else{
            $notification = "Field(s) not correct ! Please try again.";
        }
        
        render('views.signup', [
            'notification'      => $notification ??''
        ]);
    
    }

    public function checkAllFields(array $fields=[]) : bool {
        $validation = true;
        foreach ($fields as $field) {
            $check = $this->signup_model->checkField($field[0], $field[1]);
            $validation*=$check;
        }
        return $validation;
    }

    public function checkNotExist(array $fields=[]) : bool {
        $validation = true;
        foreach ($fields as $field) {
            if ($this->checkAllFields([$field])){
                $check = $this->signup_model->checkNotExist($field[0], $field[1]);
                $validation*=$check;
            }
        }
        return $validation;
    }
}