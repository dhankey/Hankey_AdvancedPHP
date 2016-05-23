<?php 

/**
* 
*/
class PhotoCRUD extends DB implements IDAO 
{
    function __construct() 
    { 
        $this->setDns('mysql:host=localhost;port=3306;dbname=PHPAdvClassSpring2016');
        $this->setPassword('');
        $this->setUser('root');
        
    }
    
    function readAll() 
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM photos");

        $results = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $results;
    }
    
    function create($values)
    {   
        $date = date("Y-m-d H:i:s");
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO photos SET user_id = :user_id, filename = :filename, title = :title, created = :created");
        
        $binds = array(
        ":user_id" => $values['user_id'],
        ":filename" => $values['filename'],
        ":title" => $values['title'],
        ":created" => $date
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    function read($id) 
    {
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * from photos WHERE user_id = :user_id");

        $binds = array(
        ":user_id" => $id
        );

        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $results; 
    }
    
    function delete($id) 
    {
        $db = $this->getDb();
        $stmt = $db->prepare("DELETE FROM photos WHERE photo_id = :photo_id");
        
        $binds = array(
        ":photo_id" => $id
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    function update($values) 
    { 
        $db = $this->getDb();
        $stmt = $db->prepare("UPDATE photos SET views = :views WHERE photo_id = :photo_id");
        
        $binds = array(
        ":views" => $values['views'],
        ":photo_id" => $values['photo_id']
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
}

 ?>