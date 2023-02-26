<?php
namespace App\Controllers;

class SignoutController
{
    public function signout() {
        unset($_SESSION['user']);  // session_destroy() is OK with header.
        unset($_SESSION['__ADMIN__']);
        unset($_SESSION['user-notification']);
        unset($_SESSION['user-notification-show']);
        header('Location: /');
    }
}
