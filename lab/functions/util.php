<?php 

/**
 * A method to check if a Post request has been made.
 *    
 * @return boolean
 */
function isPostRequest() 
{
    return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
}

function getAllAddresses() 
{    
    $db = dbconnect();
    $exec = $db->prepare("SELECT * FROM address");
    
    $results = array();

    if ($exec->execute() && $exec->rowCount() > 0) 
    {
       $results = $exec->fetchAll(PDO::FETCH_ASSOC);
    }
    
    return $results;
}

function addAddress($fullname, $email, $addressline1, $city, $state, $zip, $birthday) 
{    
    $db = dbconnect();
    $exec = $db->prepare("INSERT INTO address SET fullname = :fullname,	email = :email,
    											  addressline1 = :addressline1, city = :city,
    											  state = :state, zip = :zip, 
    											  birthday = :birthday");
    $binds = array(
        ":fullname" => $fullname,
        ":email" => $email,
        ":addressline1" => $addressline1,
        ":city" => $city,
        ":state" => $state,
        ":zip" => $zip,
        ":birthday" => $birthday
    );

    if ($exec->execute($binds) && $exec->rowCount() > 0) {
        return true;
    }
    
    return false;
}

 ?>