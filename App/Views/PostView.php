<?php

if ($data['read_permission']) {
    include 'App/Views/includes/header.php';

    include 'App/Views/includes/main_post.php';

    include 'App/Views/includes/footer.php'; 

}else{
    include 'App/Views/Error404View.php';
}

?>