<?php
namespace App\Database;

class Database {

    public $connection;

    public function __construct() {
        try {
            $this->CreateDatabaseIfnotExist('siteblog');

            $this->connection = new \PDO(
                'mysql:host=' . CONFIG_DB['database']['host'] . ';dbname=' . CONFIG_DB['database']['dbname'] . ';charset=utf8',
                CONFIG_DB['database']['user'],
                CONFIG_DB['database']['password']
            );
            $this->connection -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
            die('Error in database, please return later');                                                   //die('Erreur : ' . $e->getMessage());
        }
    }

    public function CreateDatabaseIfnotExist($database_name) {

        $PDOconnection = new \PDO(
            'mysql:host=' . CONFIG_DB['database']['host'],
            CONFIG_DB['database']['user'],
            CONFIG_DB['database']['password']
        );

        $sql = "CREATE DATABASE IF NOT EXISTS $database_name CHARACTER SET utf8 COLLATE utf8_general_ci";
        $statement = $PDOconnection->prepare($sql);
        $statement -> execute();
}

    public function createTableAdmin() : void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS admin
            (
                id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(300) NOT NULL,
                createdate DATETIME NOT NULL,
                is_block TINYINT(2) NOT NULL DEFAULT '0',
                permission TINYINT(2) NOT NULL DEFAULT '1'
            )";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

        } catch(\PDOException $e) {
            die('Error in database, please return later');
        }
    }

    public function createTableUsers() : void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS users
            (
                id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                fullname VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                pseudo VARCHAR(255) NOT NULL UNIQUE,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(300) NOT NULL,
                createdate DATETIME NOT NULL,
                is_block TINYINT(2) NOT NULL DEFAULT '0',
                permission TINYINT(2) NOT NULL DEFAULT '1',
                number_posts INT(10) NOT NULL DEFAULT '0',
                number_evals INT(10) NOT NULL DEFAULT '0'
            )";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

        } catch(\PDOException $e) {
            die('Error in database, please return later');
        }
    }

    public function createTablePosts() : void {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS posts
            (
                id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(500) NOT NULL COLLATE 'utf8_general_ci',
                content TEXT COLLATE 'utf8_general_ci',
                image VARCHAR(500) COLLATE 'utf8_general_ci',
                user_id INT(6) NOT NULL,
                is_public TINYINT(2) NOT NULL DEFAULT '0',
                is_block TINYINT(2) NOT NULL DEFAULT '0',
                viewed INT(40),
                createdate DATETIME NOT NULL,
                updatedate DATETIME NOT NULL
            )";
            $statement = $this->connection->prepare($sql);
            $statement->execute();

        } catch(\PDOException $e) {
            die('Error in database, please return later');
        }
    }
}