<?php 

/**
* 
*/
class CRUD extends DB implements IDAO 
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
        $stmt = $db->prepare("SELECT * FROM users");

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
        $stmt = $db->prepare("INSERT INTO users SET email = :email, password = :password, created = :created");
        
        $binds = array(
        ":email" => $values['email'],
        ":password" => $values['password'],
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
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");

        $binds = array(
        ":id" => $id
        );

        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $results;
    }

    function readLogin($values) 
    { 
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * from users WHERE email = :email");

        $binds = array(
        ":email" => $values['email']
        );

        $results = array();
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $results;
    }

    function registeredEmail($email){
        
        $db = $this->getDb();
        $stmt = $db->prepare("SELECT * FROM users where email = :email");
        $binds = array(
            ":email" => $email          
        );
        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    function update($values) { }
    
    function delete($id) { }
}




 ?>