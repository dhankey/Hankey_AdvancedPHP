<?php

class CorpResoruce extends DB implements IRestModel {
    
    function __construct() {
        
        $util = new Util();
        $this->setDbConfig($util->getDBConfig());              
    }

    public function getAll() {
        $stmt = $this->getDb()->prepare("SELECT * FROM corps");
        $results = array();      
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $results;
    }
    
    public function get($id) {
       
        $stmt = $this->getDb()->prepare("SELECT * FROM corps where id = :id");
        $binds = array(":id" => $id);

        $results = array(); 
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        return $results;
                
    }
    
    public function post($serverData) {
        /* note you should validate before adding to the data base */
        $stmt = $this->getDb()->prepare("INSERT INTO corps SET corp = :corp, incorp_dt = :incorp_dt, email = :email, owner = :owner, phone = :phone, location = :location");
        $binds = array(
            ":corp" => $serverData['corp'],
            ":incorp_dt" => $serverData['incorp_dt'],
            ":email" => $serverData['email'],
            ":owner" => $serverData['owner'],
            ":phone" => $serverData['phone'],
            ":location" => $serverData['location']
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        } 
        return false;
    }

    function put($serverData)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("UPDATE corps SET corp = :corp, incorp_dt = :incorp_dt, email = :email, owner = :owner, phone = :phone, location = :location WHERE id = :id");
        
        $binds = array(
        ":id" => $serverData['id'],
        ":corp" => $serverData['corp'],
        ":incorp_dt" => $serverData['incorp_dt'],
        ":email" => $serverData['email'],
        ":owner" => $serverData['owner'],
        ":phone" => $serverData['phone'],
        ":location" => $serverData['location']
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    function delete($id)
    {
        $db = $this->getDb();
        $stmt = $db->prepare("DELETE FROM corps WHERE id = :id");
        
        $binds = array(
        ":id" => $id
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
}