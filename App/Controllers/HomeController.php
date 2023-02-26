<?php
namespace App\Controllers;
use App\Models\HomeModel;

class HomeController 
{
    public $filter, $page, $search, $filter_selected, $filter_sort;
    public $home_model;
    public $articles;
    public $total_article;
    public $total_page;
    public $article_start;
    public $number_articles_perPage;
    public $user_id;

    public CONST FILTER_PARAM = [
        'Date'      => ['p.updatedate', 'DESC'],
        'Title'     => ['p.title', 'ASC'],
        'View'      => ['p.viewed', 'DESC']
    ]; 

    public function __construct() {

        $this->number_articles_perPage = 12;

        $this->filter = (empty($_GET['filter']) || $_GET['filter'] == 'Date' ) ? 'Date' : $_GET['filter'];
        $this->page = (empty($_GET['page']) || $_GET['page'] == 1 ) ? 1 : $_GET['page'];

        $this->search = (!empty($_GET['search'])) ? $_GET['search'] : '';
        $this->search = $this->deleteAllSpecialCharacters($this->search);

        $this->filter_selected = self::FILTER_PARAM[$this->filter][0];
        $this->filter_sort = self::FILTER_PARAM[$this->filter][1];
        $this->user_id = (!empty($_SESSION['user'])) ? $_SESSION['user']['id'] : 0;
        $this->home_model = new HomeModel();
    }
    
    public function showHomePageGuest() : void {
        
        if (!empty($this->search)) {
    
            if ($this->page == 1) {
                $this->articles = $this->home_model->getPostsFirstPageWithSearch($this->search, $this->filter_selected, $this->filter_sort, $this->number_articles_perPage);
                                                
            }else{
                $this->article_start = ($this->page - 1) * $this->number_articles_perPage + 1;
                $this->articles = $this->home_model->getPostsNextPagesWithSearch($this->search, $this->filter_selected, $this->filter_sort, $this->article_start, $this->user_id, $this->number_articles_perPage);
                                        
            }
            $this->total_article = $this->home_model->countArticlesWithSearch($this->search, $this->user_id);

        }else{
            if ($this->page == 1) {
                $this->articles = $this->home_model->getPostsFirstPageWithoutSearch($this->filter_selected, $this->filter_sort, $this->number_articles_perPage);

            }else{
                $this->article_start = ($this->page - 1) * $this->number_articles_perPage + 1;
                $this->articles = $this->home_model->getPostsNextPagesWithoutSearch($this->filter_selected, $this->filter_sort, $this->article_start, $this->user_id, $this->number_articles_perPage);
            }
            $this->total_article = $this->home_model->countArticlesWithoutSearch($this->user_id);
        }

        [$pagination, $backward, $forward,
        $aff_points_last_page, $aff_last_page,
        $aff_first_page, $aff_points_first_page] = $this->Pagination();

        [$index_start_article, $articles_per_page] = $this->countArticlesPerPageforGuest();
        
        render('views.home', [
            'page'                  => $this->page,
            'search'                => $this->search,
            'filter'                => $this->filter,
            'articles'              => $this->articles,
            'index_start_article'   => $index_start_article,
            'articles_per_page'     => $articles_per_page,
            'pagination'            => $pagination,
            'backward'              => $backward,
            'forward'               => $forward,
            'last_page'             => $this->total_page,
            'aff_points_last_page'  => $aff_points_last_page,
            'aff_last_page'         => $aff_last_page,
            'aff_first_page'        => $aff_first_page,
            'aff_points_first_page' => $aff_points_first_page,
            'articles_mostviewed'   => $this->getArticlesMostViewed()
        ]);
    }

    public function getArticlesMostViewed() : array {
        return $this->home_model->getPostsMostViewed();
    }

    public function deleteAllSpecialCharacters(string $search) : string {
        
        $pattern = '/\&*\"*\'*\(*\-*\_*\)*\=*\/*\**\+*\,*\;*\:*\!*\.*\?*\%*\[*\]*\{*\}*\#*\<*\>*/';
        $replacement = '';
        return preg_replace($pattern, $replacement, $search);
    }
    
    public function getTotalPages(INT $total_article, INT $number_articles_perPage) : INT {
        if ($this->user_id == 0) {
            return (ceil(($total_article-$number_articles_perPage-1)/$number_articles_perPage) + 1);
        }else{
            return ceil($total_article/$number_articles_perPage);
        }
    }

    public function Pagination() : array {
        $this->total_page = $this->getTotalPages($this->total_article, $this->number_articles_perPage);
        
        switch ($this->total_page) {
            case 1 : $pagination = 0; break;
            case 2 : $pagination = 2; break;
            default : $pagination = 3; break;
        };

        $aff_last_page = false;
        $aff_points_last_page = false;
        if ($this->total_page > 4 && $this->page < $this->total_page) {
            $aff_last_page = true;
            if ($this->page < ($this->total_page - 1)) {
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
            if ($this->page < $this->total_page) {
                $forward = true;
            }
        }
        return [$pagination, $backward, $forward, 
                $aff_points_last_page, $aff_last_page, 
                $aff_first_page, $aff_points_first_page];
    }
        
    public function countArticlesPerPageforGuest() : array {
        if ($this->page == 1) {
            $index_start_article = 0;
            if ($this->total_page > 1) {
                $articles_per_page = 12;
            }else{
                $articles_per_page = $this->total_article - 1;
            }
        }else{
            $index_start_article  = 1;
            if ($this->page < $this->total_page) {
                $articles_per_page = 12 - $index_start_article;
            }elseif($this->page == $this->total_page) {
                $articles_per_page = $this->total_article - $this->article_start - 1;
            }
        }
        return [$index_start_article, $articles_per_page];
    }

    public function showHomePageUser() : void {
        $this->article_start = ($this->page-1) * $this->number_articles_perPage;

        if (!empty($this->search)) {
            $this->articles = $this->home_model->getPostsNextPagesWithSearch($this->search, $this->filter_selected, $this->filter_sort, $this->article_start, $this->user_id, $this->number_articles_perPage);
            $this->total_article = $this->home_model->countArticlesWithSearch($this->search, $this->user_id);
            
        }else{
            $this->articles = $this->home_model->getPostsNextPagesWithoutSearch($this->filter_selected, $this->filter_sort, $this->article_start, $this->user_id, $this->number_articles_perPage);
            $this->total_article = $this->home_model->countArticlesWithoutSearch($this->user_id);       
        }

        [$pagination, $backward, $forward,
        $aff_points_last_page, $aff_last_page,
        $aff_first_page, $aff_points_first_page] = $this->Pagination();

        [$index_start_article, $articles_per_page] = $this->countArticlesPerPageforUser();
        
        render('views.home', [
            'page'                  => $this->page,
            'search'                => $this->search,
            'filter'                => $this->filter,
            'articles'              => $this->articles,
            'index_start_article'   => $index_start_article,
            'articles_per_page'     => $articles_per_page,
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

    public function countArticlesPerPageforUser() : array {
        $index_start_article  = 1;
        $articles_per_page = 11;
        if ($this->page < $this->total_page) {
            $articles_per_page = 12 - $index_start_article;
        }elseif($this->page == $this->total_page) {
            $articles_per_page = $this->total_article - $this->article_start - 1;
        }
        return [$index_start_article, $articles_per_page];
    }
}