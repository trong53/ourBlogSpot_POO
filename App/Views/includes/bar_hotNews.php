<section class="bar_hotNews">

    <div class="hotNews-title"> MOST VIEWED </div>

    <?php
    foreach ($data['articles_mostviewed'] as $item) { ?>

    <div class="hot_article">

        <a href = "/post?id=<?=$item['id']?>" class="hotNews-image-link"> 
            <img src = "<?= $item['image'] ?>" alt="" class="hotNews-image"> 
        </a>
        
        <div class="hot_article_content"> 
            <div class="hot_article_title"> 
                <a href = "#"> <?= getString(20, $item['title']) ?> </a> 
            </div>

            <div class="hot_article_info">
                <div class="infoDate"> Updated : <?= $item['updatedate'] ?> </div>
                <div class="infoPublier"> Published by <?= strtoupper($item['fullname']) ?> </div>
                <span> <ion-icon name="eye-outline"></ion-icon> <?= $item['viewed'] ?> views </span>
            </div>
            
        </div>
    </div>
    <?php } ?>

</section>