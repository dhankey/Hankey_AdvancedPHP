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
        $stmt = $db->prepare("SELECT * FROM address");

        $results = array();
        if ($stmt->execute() && $stmt->rowCount() > 0) {
           $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $results;
    }
    
    function create($values)
    {   
        $db = $this->getDb();
        $stmt = $db->prepare("INSERT INTO address SET fullname = :fullname, email = :email,
                                                  addressline1 = :addressline1, city = :city,
                                                  state = :state, zip = :zip, 
                                                  birthday = :birthday");
        $binds = array(
        ":fullname" => $values['name'],
        ":email" => $values['email'],
        ":addressline1" => $values['address'],
        ":city" => $values['city'],
        ":state" => $values['state'],
        ":zip" => $values['zip'],
        ":birthday" => $values['dob']
        );

        if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }
    
    function read($id) { }
    
    function update($values) { }
    
    function delete($id) { }
}




 ?>