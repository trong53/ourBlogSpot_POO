<?php  

include 'App/Views/includes/admin_header.php'; 	

switch ($data['action']) {
    case 'home_admin' :
        include 'App/Views/includes/admin_homepage.php';
        break;
    case 'all-users' :
        include 'App/Views/includes/admin_all_users.php';
        break;
    case 'users-stat' :
        include 'App/Views/includes/admin_users_stat.php';
        break;
    case 'all-articles' :
        include 'App/Views/includes/admin_all_articles.php';
        break;
    case 'articles-stat' :
        include 'App/Views/includes/admin_articles_stat.php';
        break;
    default : 
        include 'App/Views/includes/admin_error404.php';
        break;
};

include 'App/Views/includes/admin_footer.php';

?>