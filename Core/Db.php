<?php
/**
 * CLASS en pattern SINGLETON, elle ne peut avoir 2 instances en même temps
 * (https://apprendre-php.com/tutoriels/tutoriel-45-singleton-instance-unique-d-une-classe.html)
 */

namespace App\Core;

//J'importe class natives PDO, PDOException("https://www.php.net/manual/fr/class.pdoexception.php" )
use PDO;
use PDOException;

class Db extends PDO{

    private static $_instance;

    private const DBHOST = 'localhost';
    private const DBUSER = 'root';
    private const DBPASS = '';
    private const DBNAME = 'twitter';

    private function __construct(){

        $_dsn = 'mysql:host=' . self::DBHOST . ';dbname=' . self::DBNAME;

        try{
            parent::__construct($_dsn, self::DBUSER, self::DBPASS);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch(PDOException $Exception){
            die($Exception->getMessage());
        }
    }

    public static function getInstance():self{

        if(self::$_instance === null){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
}
