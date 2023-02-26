<?php
namespace App\Models;
use App\Database\Database;

class HomeModel extends Database
{
    public function getPostsFirstPageWithSearch(string $search, string $filter_selected, string $filter_sort, INT $number_articles_perPage) : array {
        $number_articles_perPage++;
        $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                FROM posts AS p, users AS u
                WHERE u.id = p.user_id AND p.is_public = 1 AND (p.title LIKE '%$search%' OR p.content LIKE '%$search%')
                ORDER BY $filter_selected $filter_sort
                LIMIT $number_articles_perPage";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostsNextPagesWithSearch(string $search, string $filter_selected, string $filter_sort, INT $start, INT $user_id, INT $number_articles_perPage=12) : array {
        if ($user_id==0) {
            $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.is_public = 1 AND (p.title LIKE '%$search%' OR p.content LIKE '%$search%')
                    ORDER BY $filter_selected $filter_sort
                    LIMIT $start, $number_articles_perPage";
            $statement = $this->connection->prepare($query);
        }else{
            $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.user_id = :user_id AND (p.title LIKE '%$search%' OR p.content LIKE '%$search%')
                    ORDER BY $filter_selected $filter_sort
                    LIMIT $start, $number_articles_perPage";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countArticlesWithSearch(string $search, INT $user_id) : INT {
        if ($user_id==0) {
            $query = "SELECT count(*) FROM posts WHERE is_public = 1 AND (title LIKE '%$search%' OR content LIKE '%$search%')";
            $statement = $this->connection->prepare($query);
        }else{
            $query = "SELECT count(*) FROM posts WHERE user_id = :user_id AND (title LIKE '%$search%' OR content LIKE '%$search%')";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        }
        $statement->execute();
        return (int)($statement->fetchColumn());
    }

    public function getPostsFirstPageWithoutSearch(string $filter_selected, string $filter_sort, INT $number_articles_perPage) : array {
        $number_articles_perPage++;
        $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.is_public = 1
                    ORDER BY $filter_selected $filter_sort
                    LIMIT $number_articles_perPage";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostsNextPagesWithoutSearch(string $filter_selected, string $filter_sort, INT $start, INT $user_id, INT $number_articles_perPage) : array {
        if ($user_id==0) {
            $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.is_public = 1
                    ORDER BY $filter_selected $filter_sort
                    LIMIT $start, $number_articles_perPage";
            $statement = $this->connection->prepare($query);
        }else{
            $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.user_id = :user_id
                    ORDER BY $filter_selected $filter_sort
                    LIMIT $start, $number_articles_perPage";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        }
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countArticlesWithoutSearch(INT $user_id) : INT {
        if ($user_id==0) {
            $query = "SELECT count(*) FROM posts WHERE is_public = 1";
            $statement = $this->connection->prepare($query);
        }else{
            $query = "SELECT count(*) FROM posts WHERE user_id = :user_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        }
        $statement->execute();
        return (int)($statement->fetchColumn());
    }

    public function getPostsMostViewed() {
        $query = "SELECT p.id, p.title, p.image, p.updatedate, p.viewed, u.fullname 
                    FROM posts AS p, users AS u 
                    WHERE u.id = p.user_id AND p.is_public = 1
                    ORDER BY p.viewed DESC
                    LIMIT 10";

        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}