<ul class="pagination">
    <?php
    if ($data['backward']) { ?>
        <a class="page-transition" href="/?action=all-users&page=<?= $data['page']-1 ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"> &laquo; Previous </a>
    <?php }

    if ($data['aff_first_page']) { ?>
        <li>
            <a href="/?action=all-users&page=1&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" >1</a> 
        </li>
    <?php
        if ($data['aff_points_first_page']) {
            echo '<li>...</li>';
        }
    }

    if ($data['pagination'] == 2) {
        for ($i=1; $i<=$data['pagination']; $i++) {  ?>
    
            <li> 
                <a href="/?action=all-users&page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" 
                    <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                </a> 
            </li>

    <?php } }

    if ($data['pagination'] == 3) {
        if ($data['page'] <=3) {
            for ($i=1; $i<=$data['pagination']; $i++) {  ?>
    
                <li> 
                    <a href="/?action=all-users&page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"
                        <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                    </a> 
                </li>

    <?php } } else {
            for ($i=$data['page']-2; $i<=$data['page']; $i++) { ?>
                <li> 
                    <a href="/?action=all-users&page=<?= $i ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"
                        <?php if ($i == $data['page']) {echo 'class ="selected-page"';} ?> > <?= $i ?> 
                    </a> 
                </li>
    <?php } } }
    if ($data['aff_last_page']) {
        if ($data['aff_points_last_page']) {
            echo '<li>...</li>';
        } ?>
        <li>
            <a href="/?action=all-users&page=<?= $data['last_page'] ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>" > 
                <?= $data['last_page'] ?>
            </a> 
        </li>
    <?php
    }
        
    if ($data['forward']) { ?>
        <a class="page-transition" href="/?action=all-users&page=<?= $data['page']+1 ?>&search=<?=$data['search']?>&filter=<?= $data['filter'] ?>"> Next &raquo; </a>
    <?php } ?>
</ul>