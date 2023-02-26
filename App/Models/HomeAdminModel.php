<?php
namespace App\Models;
use App\Database\Database;

class HomeAdminModel extends Database
{
    public function getUsersWithSearch(string $search, string $filter_selected, string $filter_sort, INT $start, INT $number_user_perPage) : array {

        $query = "SELECT id, fullname, pseudo, email, createdate, is_block, permission FROM users
                WHERE fullname LIKE '%$search%' OR pseudo LIKE '%$search%' OR email LIKE '%$search%'
                ORDER BY $filter_selected $filter_sort
                LIMIT $start, $number_user_perPage";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countUsersWithSearch(string $search) : INT {
        $query = "SELECT count(*) FROM users WHERE fullname LIKE '%$search%' OR pseudo LIKE '%$search%' OR email LIKE '%$search%'";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return (int)($statement->fetchColumn());
    }

    public function getUsersWithoutSearch(string $filter_selected, string $filter_sort, INT $start, INT $number_user_perPage) : array {
        $query = "SELECT id, fullname, pseudo, email, createdate, is_block, permission FROM users
                ORDER BY $filter_selected $filter_sort
                LIMIT $start, $number_user_perPage";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countUsersWithoutSearch() : INT {
        $query = "SELECT count(*) FROM users";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return (int)($statement->fetchColumn());
    }

    public function blockUser(INT $user_id) : void {
        $query = "UPDATE users SET is_block = 1 where id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $user_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function unBlockUser(INT $user_id) : void {
        $query = "UPDATE users SET is_block = 0 where id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $user_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function limiteUser(INT $user_id) : void {
        $query = "UPDATE users SET permission = 0 where id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $user_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function unLimiteUser(INT $user_id) : void {
        $query = "UPDATE users SET permission = 1 where id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $user_id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getTopPostUsers() : array {
        $query = "SELECT pseudo, number_posts FROM users ORDER BY number_posts DESC LIMIT 10";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserAbonnement(INT $year) {
        $query = "SELECT DISTINCT (MONTHNAME(createdate)) AS month, COUNT(*) AS number_of_users
                FROM users WHERE YEAR(createdate) = :year GROUP BY month";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':year', $year, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}