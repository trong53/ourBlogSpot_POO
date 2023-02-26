
    <div class="guest-homepage">

        <div class="article_navbar">
            <div class="title">RECENT POSTS</div>
            <form class="search" method="GET" action="/">
                <input type="text" name="search" id="search" placeholder="Search">
                <button> <img src="./assets/img/search_icon.svg" alt=""> </button>
            </form>
            <div class="filter">
                <img src="./assets/img/filter.svg" alt="">
                <select name="select" id="select" onchange="window.location = '/?page=<?=$data['page']?>&search=<?=$data['search']?>&filter='+this.value">
                    <option value="Date" <?= ($data['filter'] == 'Date') ? 'selected' : '' ?> >Date</option>
                    <option value="View" <?= ($data['filter'] == 'View') ? 'selected' : '' ?> >View</option>
                    <option value="Title" <?= ($data['filter'] == 'Title') ? 'selected' : '' ?> >Title</option>
                </select>
            </div>
        </div>

        <?php
        if (!empty($data['articles'])) {

            if ($data['page'] == 1) { ?>
            <section class="first_article">
                
                <a href = "/post?id=<?=$data['articles'][0]['id']?>" class="first-article-image-link"> 
                    <img src = "<?=$data['articles'][0]['image']?>" alt="" class="first-article-image"> 
                </a>
                
                <div class="first_article_content">
                    <div class="first_article_info">
                        <div class="infoDate"> Updated : <?=$data['articles'][0]['updatedate']?></div>
                        <div class="infoPublier"> Published by <?=strtoupper($data['articles'][0]['fullname'])?></div>
                        <span class="view-icon"> <ion-icon name="eye-outline"></ion-icon> <?=$data['articles'][0]['viewed']?> views </span>
                    </div>

                    <span class="first_article_title"> <a href = "/post?id=<?=$data['articles'][0]['id']?>"> <?= getString(7, $data['articles'][0]['title']) ?> </a> </span>
                    
                </div>
            </section>
            <?php } ?>

            <section class="articles">
            <?php
            for ($i=(1-$data['index_start_article']); $i<=$data['articles_per_page']; $i++) { ?>
                
                <div class="article">
                    
                    <a href = "/post?id=<?=$data['articles'][$i]['id']?>" class="article-image-link"> 
                        <img src = "<?=$data['articles'][$i]['image']?>" alt="" class="article-image"> 
                    </a>
                    
                    <div class="article_info">
                        <div class="infoDate">Updated : <?=$data['articles'][$i]['updatedate']?></div>
                        <div class="infoPublier">Published by <?=strtoupper($data['articles'][$i]['fullname'])?></div>
                        <span class="view-icon"> <ion-icon name="eye-outline"></ion-icon> <?=$data['articles'][$i]['viewed']?> views </span>
                    </div>
                    
                    <div class="article_title"> 
                        <a href = "/post?id=<?=$data['articles'][$i]['id']?>"> <?= getString(6, $data['articles'][$i]['title']) ?> </a> 
                    </div>
                    
    
                </div>
            <?php } ?>
            </section>

            <ul class="pagination">
                <?php
                if ($data['backward']) { ?>
                    <a class="page-transition" href="/?page=<?= $data['page']-1 ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"> &laquo; Previous </a>
                <?php }

                if ($data['aff_first_page']) { ?>
                    <li>
                        <a href="/?page=1&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" >1</a> 
                    </li>
                <?php
                    if ($data['aff_points_first_page']) {
                        echo '<li>...</li>';
                    }
                }

                if ($data['pagination'] == 2) {
                    for ($i=1; $i<=$data['pagination']; $i++) {  ?>
                
                        <li> 
                            <a href="/?page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" 
                                <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                            </a> 
                        </li>

                <?php } }

                if ($data['pagination'] == 3) {
                    if ($data['page'] <=3) {
                        for ($i=1; $i<=$data['pagination']; $i++) {  ?>
                
                            <li> 
                                <a href="/?page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"
                                    <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                                </a> 
                            </li>

                <?php } } else {
                        for ($i=$data['page']-2; $i<=$data['page']; $i++) { ?>
                            <li> 
                                <a href="/?page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"
                                    <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                                </a> 
                            </li>
                <?php } } }
                if ($data['aff_last_page']) {
                    if ($data['aff_points_last_page']) {
                        echo '<li>...</li>';
                    } ?>
                    <li>
                        <a href="/?page=<?= $data['last_page'] ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" > 
                            <?= $data['last_page'] ?>
                        </a> 
                    </li>
                <?php
                }
                    
                if ($data['forward']) { ?>
                    <a class="page-transition" href="/?page=<?= $data['page']+1 ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"> Next &raquo; </a>
                <?php } ?>
            </ul>

        <?php }else{ 
            echo '<div class="nofound"> No article was found. </div>';
        } ?>

    </div>
