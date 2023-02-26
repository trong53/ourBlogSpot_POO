
<?php  include 'App/Views/includes/header.php'; ?>	

<main>
    
    <?php 
    
    if (!empty($_SESSION['user'])) {
        include 'App/Views/includes/main_user.php';

    }else{
        include 'App/Views/includes/main.php';

        include 'App/Views/includes/bar_hotNews.php';
    }
    ?>

</main>

<?php include 'App/Views/includes/footer.php'; ?>