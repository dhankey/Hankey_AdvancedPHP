<?php 

/**
* 
*/
class Validation
{
    public function emailIsValid($tmp)
    {
    	return(preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/', $tmp));
    }

    public function valueIsValid($tmp)
    {
    	return(preg_match('/^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$/', $tmp));
    }

    public function valueIsEmpty($tmp)
    {
    	return(empty($tmp));
    }
}

 ?>