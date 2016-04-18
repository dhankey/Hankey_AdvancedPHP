<?php 

/**
* 
*/
class ErrorMessage extends Message
{	
	function setArrMsg($msg)
	{
		array_push($this->arrMsg, "*ERROR* ".$msg);
	}
}

 ?>