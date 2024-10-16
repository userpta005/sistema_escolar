<?php

namespace App\Config;

use PDO;

class Database {
    private static $connection;
    
    public static function getConnection()
    {
		if(!self::$connection){
			$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
			$dotenv->load();
			
			$host = $_ENV['DB_HOST'];
			$dbname = $_ENV['DB_NAME'];
			$username = $_ENV['DB_USER'];
			$password = $_ENV['DB_PASS'];
			try {
                self::$connection = new PDO(
                    'mysql:host=' . $host . ';dbname=' . $dbname, 
                    $username, 
                    $password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
		}

		return self::$connection;
    
    }
}
