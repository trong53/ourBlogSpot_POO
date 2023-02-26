<?php
namespace App\Models;
use App\Database\Database;

class PostModel extends Database
{

    public function getPostforUser(INT $id) : array|bool {
        $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                FROM posts AS p, users AS u 
                WHERE u.id = p.user_id AND p.id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function getRecentPostsforUser() : array {
        $query = "SELECT p.id, p.title, p.content, p.image, p.updatedate, p.viewed, u.fullname 
                FROM posts AS p, users AS u 
                WHERE u.id = p.user_id AND p.is_public = 1
                ORDER BY p.updatedate DESC
                LIMIT 5";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function checkArticleIsPublic(INT $article_id) : bool {
        $query = "SELECT is_public from posts where id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $article_id, \PDO::PARAM_INT);
        $statement->execute();
        $statement = $statement->fetch();
        if (!empty($statement) && $statement['is_public']==1) {
            return true;
        }else{
            return false;
        }
    }

    public function checkAuthorOfArticle (INT $article_id, INT $user_id) {
        $query = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $article_id, \PDO::PARAM_INT);
        $statement->bindParam(2, $user_id, \PDO::PARAM_INT);
        $statement->execute();
        $statement = $statement->fetchColumn();
        if ($statement) {
            return true;
        }else{
            return false;
        }
    }

    public function updateView($article_id) {
        $query = "UPDATE posts SET viewed = viewed + 1 where id = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $article_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function deleteArticle(INT $article_id) : void {
        $query = "DELETE FROM posts where id = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $article_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function updatePost(string $title, string $content, string $image, INT $is_public, INT $article_id) : void {

        $update_date = date('Y-m-d');
        if (empty($image)) {
            $query = "UPDATE posts SET title = :title, content=:content, is_public=:is_public,updatedate=:updatedate where id = :article_id";
            $statement = $this->connection->prepare($query);

        }else{
            $query = "UPDATE posts SET title = :title, content=:content, image=:image, is_public=:is_public,updatedate=:updatedate where id = :article_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':image', $image, \PDO::PARAM_STR);
        }
        $statement->bindParam(':title', $title, \PDO::PARAM_STR);
        $statement->bindParam(':content', $content, \PDO::PARAM_STR);
        $statement->bindParam(':is_public', $is_public, \PDO::PARAM_INT);
        $statement->bindParam(':updatedate', $update_date, \PDO::PARAM_STR);
        $statement->bindParam(':article_id', $article_id, \PDO::PARAM_INT);

        $statement->execute();
    }

}

