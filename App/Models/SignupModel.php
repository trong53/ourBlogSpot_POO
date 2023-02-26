<?php
namespace App\Models;
use App\Database\Database;

class SignupModel extends Database
{
	public CONST VALIDATION_PATTERN = array(
		'password'      =>  [   
								'pattern'   => '/^(?=.*\d)(?=.*\W)(?=.*[A-Z]).{8,32}$/'
							],
		'name'          =>  [
								'pattern'   => '/^[A-z]{1,}\s?([A-z]{1,}\'?\-?[A-z]{1,}\s?)+([A-z]{1,})?$/'
							],
		'email'         =>  [
								'pattern'   => '/^[A-z][A-z0-9_\.\-]{2,32}@([A-z0-9\.\-]{3,15})(\.[A-z]{2,8}){1,2}$/'
							],
		'pseudo'        =>  [
								'pattern'   => '/^[A-z0-9_\-\.]{2,32}$/'
							]                
	);

	public function checkField(string $name, string $field) : bool {
		$pattern = self::VALIDATION_PATTERN[$field]['pattern'];

		if (preg_match($pattern, trim($name))) {
			return true;
		}else{
			return false;
		}
	}

	public function insertUser(string $name, string $pseudo, string $email, string $password) : void {
		try {
			date_default_timezone_set('Europe/Paris');
            $date = date('Y-m-d H:i:s');
			$query = "INSERT INTO users (fullname, pseudo, email, password, createdate) VALUES (?, ?, ?, ?, ?)";
			
			$statement = $this->connection->prepare($query);
			$statement->bindParam(1, $name, \PDO::PARAM_STR);
			$statement->bindParam(2, $pseudo, \PDO::PARAM_STR);
			$statement->bindParam(3, $email, \PDO::PARAM_STR);
			$statement->bindParam(4, $password, \PDO::PARAM_STR);
			$statement->bindParam(5, $date, \PDO::PARAM_STR);
			$statement -> execute();

		} catch(\Exception $e) {
			die('Error in database, please return later');
		}

	}

	public function checkNotExist(string $field, string $field_name) : bool {
		$query = "SELECT id FROM users WHERE $field_name = ?";

		$statement = $this->connection->prepare($query);
		$statement->bindParam(1, $field, \PDO::PARAM_STR);
		$statement -> execute();
		$statement = $statement->fetchColumn();

		if (empty($statement)) {return true;}
		else {return false;}
	}
}





