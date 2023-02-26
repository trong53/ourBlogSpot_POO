<?php
namespace App\Models;
use App\Database\Database;

class AddPostModel extends Database
{
    public function createPost(string $title, string $content, string $image, 
                                INT $user_id, INT $is_public, INT $viewed, 
                                string $createdate, string $updatedate) : bool
    {
        try {
            $query ="INSERT INTO posts 
            (title, content, image, user_id, is_public, viewed, createdate, updatedate ) 
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";

            $statement = $this->connection->prepare($query);
            $statement->bindParam(1, $title, \PDO::PARAM_STR);
            $statement->bindParam(2, $content, \PDO::PARAM_STR);
            $statement->bindParam(3, $image, \PDO::PARAM_STR);
            $statement->bindParam(4, $user_id, \PDO::PARAM_INT);
            $statement->bindParam(5, $is_public, \PDO::PARAM_INT);
            $statement->bindParam(6, $viewed, \PDO::PARAM_INT);
            $statement->bindParam(7, $createdate, \PDO::PARAM_STR);
            $statement->bindParam(8, $updatedate, \PDO::PARAM_STR);

            $statement->execute();
            return true;
        } catch(\PDOException $e) {
            return false;
        }
    }
}