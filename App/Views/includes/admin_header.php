<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiteBlog">
    <link rel="stylesheet" type="text/css" href="./assets/css/mainAdmin.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="./assets/css/header.css">
    <title>ourBlogSpot</title>
</head>
<body>
    <header>
        
        <div class="logo">  <a href = "/"> ourBlogSpot </a>  </div>

        <div class="sign user">  
            <?= (!empty($_SESSION['__ADMIN__'])) ? '[ '.strtoupper($_SESSION['__ADMIN__']['fullname']).' ]' : ''; ?>
        </div>
        <div class="sign signin">  
            <a href = "/signout"> SignOut </a>
        </div>
        <div class="sign signup"> 
            <a href = "/signupAdmin"> 
                Create new Admin
            </a>
        </div>
        
    </header>

    <section class="admin-main">

        <div class="admin-navbar">
            <ul>
                <li class="list-item-user">
                    <span class="list-item-title">Users</span>
                    <ul class="sub-list-user"> 
                        <li><a href="/?action=all-users"> All Users </a></li>
                        <li><a href="/?action=users-stat"> Users-Statistics </a></li>
                    </ul>
                </li>
                <li class="list-item-article">
                    <span class="list-item-title">Articles</span>
                    <ul class="sub-list-article"> 
                        <li><a href="/?action=all-articles"> All Articles </a></li>
                        <li><a href="/?action=articles-stat"> Articles-Statistics </a></li>
                    </ul>
                </li>
                <li class="list-item">
                    <a href="/?action=profil" class="list-item-title"> Your Profile </a>
                </li>
            </ul>

        </div>

        <div class="admin-content">
            
        