<?php 

/**
* 
*/
class SuccessMessage extends Message
{	
	function setArrMsg($msg)
	{
		array_push($this->arrMsg, "*Succes* ".$msg);
	}
}

 ?>