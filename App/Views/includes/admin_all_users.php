<div class="article_navbar">
    <form class="search" method="POST" action="/?action=all-users">
        <input type="text" name="search" id="search" placeholder="Search">
        <button> <img src="./assets/img/search_icon.svg" alt=""> </button>
    </form>
    <div class="filter">
        <img src="./assets/img/filter.svg" alt="">
        <select class="admin-filter" name="select" id="select" onchange="window.location = '/?action=all-users&page=<?=$data['page']?>&search=<?=$data['search']?>&filter='+this.value">
            <option value="Id" <?= ($data['filter'] == 'Id') ? 'selected' : '' ?> >No filter</option>    
            <option value="Name" <?= ($data['filter'] == 'Name') ? 'selected' : '' ?> >Name</option>
            <option value="Pseudo" <?= ($data['filter'] == 'Pseudo') ? 'selected' : '' ?> >Pseudo</option>
            <option value="Email" <?= ($data['filter'] == 'Email') ? 'selected' : '' ?> >Email</option>
        </select>
    </div>
</div>

<table class="all-users">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fullname</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Date of creation</th>
            <th>Is_Blocked</th>
            <th>Permission</th>
        </tr>    
    </thead>

    <tbody>
        <?php 
            foreach ($data['users'] as $user) { ?>
            
        <tr>
            <td> <?=$user['id']?>           </td>
            <td> <?=$user['fullname']?>     </td>
            <td> <?=$user['pseudo']?>       </td>
            <td> <?=$user['email']?>        </td>
            <td> <?=$user['createdate']?>   </td>
            <td> 
                <div class="user-status">
                    <span class="<?=($user['is_block']==0)?'user-unrestriction-font':'user-restriction-font'?>"> 
                        <?=($user['is_block']==0)?'No blocked':'Blocked'?> </span>
                    <span>
                        <form action="/?action=all-users&page=<?=$data['page']?>&search=<?=$data['search']?>&filter=<?=$data['search']?>" method="POST">
                            <button class = "user-restriction" type = "submit" name = "user_block" value="<?=$user['id']?>" > Block </button>
                            <button class = "user-unrestriction" ype = "submit" name = "user_unblock" value="<?=$user['id']?>" > Unblock </button>  
                        </form>
                    </span> 
                </div>
                
            </td>
            <td> 
                <div class="user-status">
                    <span class="<?=($user['permission']==1)?'user-unrestriction-font':'user-restriction-font'?>"> 
                        <?=($user['permission']==1)?'No limited':'Limited'?> </span>
                    <span>
                        <form action="/?action=all-users&page=<?=$data['page']?>&search=<?=$data['search']?>&filter=<?=$data['search']?>" method="POST">
                            <button class = "user-restriction" type = "submit" name = "user_limite" value="<?=$user['id']?>"> Limite </button>
                            <button class = "user-unrestriction" type = "submit" name = "user_unlimite" value="<?=$user['id']?>"> Unlimite </button>  
                        </form>
                    </span> 
                </div>
                   
            </td>
        </tr>

        <?php } ?>
    </tbody>

    <tfoot>
        <tr>
            <th>Id</th>
            <th>Fullname</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Date of creation</th>
            <th>Is_Blocked</th>
            <th>Permission</th>
        </tr>    
    </tfoot>
</table>

<?php
    include 'App/Views/includes/admin_pagination.php';
?>