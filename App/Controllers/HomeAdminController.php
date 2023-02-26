<?php
namespace App\Controllers;
use App\Models\HomeAdminModel;

class HomeAdminController 
{
    public $action;
    public $home_admin_model;
    public $filter, $page, $search, $filter_selected, $filter_sort;
    public $users;
    public $total_user;
    public $total_page;
    public $user_start;
    public $number_users_perPage;

    public CONST FILTER_PARAM = [
        'Id'        => ['id', 'ASC'],
        'Name'      => ['fullname', 'ASC'],
        'Pseudo'    => ['pseudo', 'ASC'],
        'Email'     => ['email', 'ASC']
    ]; 

    public function __construct() {
        $this->action = (!empty($_GET['action'])) ? $_GET['action'] : 'home_admin';
        $this->page = (empty($_GET['page']) || $_GET['page'] == 1 ) ? 1 : $_GET['page'];
        $this->home_admin_model = new HomeAdminModel();
    }

    public function index() {
        switch ($this->action) {
            case 'home_admin' :     $this->homePageAdmin(); break;
            case 'all-users' :      $this->adminAllUsers(); break;
            case 'users-stat' :     $this->adminUsersStat(); break;
            case 'all-articles' :   $this->homePageAdmin(); break;
            case 'articles-stat' :  $this->homePageAdmin(); break;
            default :               $this->error404(); break;
        };
    }

    public function homePageAdmin() {
        render('views.HomeAdmin', [
            'action'                => $this->action,
        ]);
    }

    public function error404() {
        render('views.HomeAdmin', [
            'action'                => 'error-404',
        ]);
    }

    public function adminAllUsers() {

        $this->number_users_perPage = 12;

        $this->filter = (empty($_GET['filter']) || $_GET['filter']=='Id') ? 'Id' : $_GET['filter'];

        $this->search = (!empty($_POST['search'])) ? $_POST['search'] : '';
        $this->search = $this->deleteSpecialCharacters($this->search);

        $this->filter_selected = self::FILTER_PARAM[$this->filter][0];
        $this->filter_sort = self::FILTER_PARAM[$this->filter][1];
        
        $this->restrictionHandler();

        $this->user_start = ($this->page-1) * $this->number_users_perPage;

        if (!empty($this->search)) {
            $this->users = $this->home_admin_model->getUsersWithSearch($this->search, $this->filter_selected, $this->filter_sort, $this->user_start, $this->number_users_perPage);
            $this->total_user = $this->home_admin_model->countUsersWithSearch($this->search);
            
        }else{
            $this->users = $this->home_admin_model->getUsersWithoutSearch($this->filter_selected, $this->filter_sort, $this->user_start, $this->number_users_perPage);
            $this->total_user = $this->home_admin_model->countUsersWithoutSearch();       
        }

        $this->total_page = $this->getTotalPages($this->total_user, $this->number_users_perPage);

        [$pagination, $backward, $forward,
        $aff_points_last_page, $aff_last_page,
        $aff_first_page, $aff_points_first_page] = $this->pagination($this->total_page);
        
        render('views.HomeAdmin', [
            'action'                => $this->action,
            'page'                  => $this->page,
            'search'                => $this->search,
            'filter'                => $this->filter,
            'users'                 => $this->users,
            'pagination'            => $pagination,
            'backward'              => $backward,
            'forward'               => $forward,
            'last_page'             => $this->total_page,
            'aff_points_last_page'  => $aff_points_last_page,
            'aff_last_page'         => $aff_last_page,
            'aff_first_page'        => $aff_first_page,
            'aff_points_first_page' => $aff_points_first_page
        ]);
    }

    public function restrictionHandler() {

        if (!empty($_SESSION['__ADMIN__'])) {
            if (!empty($_POST['user_block'])) {
                $this->home_admin_model->blockUser((int)$_POST['user_block']);
            }
            if (!empty($_POST['user_unblock'])) {
                $this->home_admin_model->unBlockUser((int)$_POST['user_unblock']);
            }
            if (!empty($_POST['user_limite'])) {
                $this->home_admin_model->limiteUser((int)$_POST['user_limite']);
            }
            if (!empty($_POST['user_unlimite'])) {
                $this->home_admin_model->unLimiteUser((int)$_POST['user_unlimite']);
            }
        }
    }

    public function deleteSpecialCharacters(string $search) : string {
        
        $pattern = '/\&*\"*\'*\(*\)*\=*\/*\**\+*\,*\;*\:*\!*\.*\?*\%*\[*\]*\{*\}*\#*\<*\>*/';
        $replacement = '';
        return preg_replace($pattern, $replacement, $search);
    }

    public function getTotalPages(INT $total_user, INT $number_users_perPage) : INT {

        return ceil($total_user/$number_users_perPage);
    }

    public function pagination(INT $total_page) : array {
        
        switch ($total_page) {
            case 1 : $pagination = 0; break;
            case 2 : $pagination = 2; break;
            default : $pagination = 3; break;
        };

        $aff_last_page = false;
        $aff_points_last_page = false;
        if ($total_page > 4 && $this->page < $total_page) {
            $aff_last_page = true;
            if ($this->page < ($total_page - 1)) {
                $aff_points_last_page = true;
            }
        }

        $aff_first_page = false;
        $aff_points_first_page = false;
        $backward = false;
        if ($this->page > 3) {
            $aff_first_page = true;
            $backward = true;
        }
        if ($this->page > 4) {$aff_points_first_page = true;}
             
        $forward = false;
        if ($pagination == 3) {
            if ($this->page < $total_page) {
                $forward = true;
            }
        }
        return [$pagination, $backward, $forward, 
                $aff_points_last_page, $aff_last_page, 
                $aff_first_page, $aff_points_first_page];
    }

    public function adminUsersStat() {

        render('views.HomeAdmin', [
            'action'                => $this->action,
        ]);
    }

    public function userStat() {
        $users_top_post = $this->home_admin_model->getTopPostUsers();
        foreach ($users_top_post as $item){
            $xValues[] = $item['pseudo'];
            $yValues[] = $item['number_posts'];
        }
        return json_encode([$xValues, $yValues]);
    }

    public function userAbonnementStat(INT $year) {
        if (($year >= 2020) && ($year <= 2022)) {

            $user_abonnement = $this->home_admin_model->getUserAbonnement($year);

            $months = [['January', 0], ['February', 0], ['March', 0], ['April', 0], ['May', 0],
                        ['June', 0], ['July', 0], ['August', 0], ['September', 0], 
                        ['October', 0], ['November', 0], ['December', 0]];

            foreach ($user_abonnement as $item) {
                for ($step=0; $step<=11; $step++) {
                    if ($item['month']==$months[$step][0]) {
                        $months[$step][1] = $item['number_of_users'];
                    }
                }
            }
            for ($step=0; $step<=11; $step++) {
                $xValues[] = $months[$step][0];
                $yValues[] = $months[$step][1];
            }
                   
            return json_encode([$xValues, $yValues]);
        }else{
            return json_encode('no data');
        }
    }
}
