<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiteBlog">
    <link rel="stylesheet" type="text/css" href="./assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/main_user.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/footer.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/signUpIn.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/posts.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/addPost.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="./assets/tools/ckeditor/ckeditor.js"></script>
    <title>ourBlogSpot</title>
</head>
<body>
    <header>
	
        <div class="logo">  <a href = "/"> ourBlogSpot </a>  </div>

        <div class="sign user">  
            <?= (!empty($_SESSION['user'])) ? '[ '.strtoupper($_SESSION['user']['fullname']).' ]' : ''; ?>
        </div>

        <div class="sign signin">  
            <?php

                if (empty($_SESSION['user'])) { ?>
                    <a href = "/signin"> SignIn </a>
                <?php } else { ?>
                    <a href = "/signout"> SignOut </a>
                <?php } ?>
         </div>
        
         <div class="sign signup"> 
            <a href = "/signup"> 
                <?= (empty($_SESSION['user'])) ? 'SignUp' : ''; ?>
            </a>
        </div>
		
    </header>