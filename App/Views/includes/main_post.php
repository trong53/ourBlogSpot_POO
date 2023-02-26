<main class="post_container">
    <?php
    if (empty($data['selected_article'])) {
        echo '<img class="post-BG-image" src= "./assets/img/blog.jpg" alt="">';
    }else{
        echo '<img class="post-BG-image" src= "'.$data['selected_article']['image'].'" alt="">';
    }
    ?>

    <div class="article_main">
        
        <section class="post_article">
            <div class="post-article-navbar">
                <?php
                if ($data['is_author']) { ?>
                
                <div class="article-functions">
                    <img src="./assets/img/modify_icon.svg" alt="">
                    <a href = "/modifyPost?modifyID=<?=$data['selected_article']['id']?>"> Modify article </a>
                </div>

                <div class="article-functions">
                    <img src="./assets/img/delete_icon.svg" alt="">
                    <a href = "/deletePost?deleteID=<?=$data['selected_article']['id']?>"> Delete article </a>
                </div>
                <?php } ?>
                
                <div class="article_info post_article_info">
                    <div class="infoDate">Updated : <?= $data['selected_article']['updatedate'] ?></div>
                    <div class="infoPublier">Published by <?= strtoupper($data['selected_article']['fullname']) ?></div>
                    <span class="view-icon"> <ion-icon name="eye-outline"></ion-icon> <?= $data['selected_article']['viewed'] ?> viewed </span>
                </div>
            </div>

            <div class="post_article_title"> <?= $data['selected_article']['title'] ?> </div>
            
            <div class="post_article_description"> <?= $data['selected_article']['content'] ?> </div>    
        </section>

        <section class="recent_articles">
            <div class="recent_article_title">RECENT ARTICLES</div>
            
            <?php
            foreach ($data['recent_articles_allUsers'] as $recent_article) { ?>

            <div class="recent_article">
            
                <a href = "/post?id=<?= $recent_article['id'] ?>"> <img src = " <?= $recent_article['image'] ?> "> </a>
        
                <div class="hot_article_content post_recent_article_content">
                    <div class="hot_article_title">
                        <a href = "/post?id=<?= $recent_article['id'] ?>"> <?= getString(8, $recent_article['title']) ?>  </a>
                    </div>

                    <div class="hot_article_info">
                        <div class="infoDate"> Updated : <?= $recent_article['updatedate'] ?> </div>
                        <div class="infoPublier"> Published by <?= strtoupper($recent_article['fullname']) ?>  </div>
                        <span> <ion-icon name="eye-outline"></ion-icon> <?= $recent_article['viewed'] ?> views </span>
                    </div>
                </div>
            </div>

            <?php } ?>

        </section>
    </div>

</main>
