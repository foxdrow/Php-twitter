<?php
namespace App\Models;

use App\Core\Db;
use PDOException;

class Model extends Db{

    protected $table;
    private $db;
    
    public function queryToDB(string $sql, array $attributs = null){
        
        $this->db = Db::getInstance();
        
        if($attributs !== null){
            
            $query = $this->db->prepare($sql, array(Db::ATTR_CURSOR => Db::CURSOR_FWDONLY));
            $query->execute($attributs);

            return $query;
        }else{
            return $this->db->query($sql);
        }
    }

    public function registrationDB($sql, $attributs){
        
        $this->db = Db::getInstance();

        try
        {
            $query = $this->db->prepare($sql, array(Db::ATTR_CURSOR => Db::CURSOR_FWDONLY));

            $query->execute($attributs);
        
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
            if ($e->errorInfo[1] == 1062)
                return 1;
        }
        return 0;
    }

}