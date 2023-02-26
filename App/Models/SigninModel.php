<?php
namespace App\Models;
use App\Database\Database;

class SigninModel extends Database
{
    public function getUserInfo(string $email) : array|string {
        
        $query = "SELECT password, is_block, permission FROM users WHERE email = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $email, \PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();

        if (!empty($statement)) {
            return $statement;
        }else{
            return 'no data';
        }
    }

    public function getUserData(string $email) : array|string {

        $query = "SELECT id, fullname, pseudo, email, is_block, permission FROM users WHERE email = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $email, \PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch(\PDO::FETCH_ASSOC);
        
        if (!empty($statement)) {
            return $statement;
        }else{
            return '';
        }

    }

    public function getPassAdmin(string $email) : string {

        $query = "SELECT password FROM admin WHERE email = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $email, \PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch();

        if (!empty($statement)) {
            return $statement['password'];
        }else{
            return 'no data';
        }
    }

    public function getAdminData(string $email) : array|string {

        $query = "SELECT id, fullname, email, is_block, permission FROM admin WHERE email = ?";
        
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $email, \PDO::PARAM_STR);
        $statement->execute();
        $statement = $statement->fetch(\PDO::FETCH_ASSOC);

        if (!empty($statement)) {
            return $statement;
        }else{
            return '';
        }
    }
}

   