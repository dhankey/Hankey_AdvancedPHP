<?php 

/**
* 
*/
class Message implements IMessage
{
	protected $arrMsg = Array();

	function getArrMsg()
	{
		return $this->arrMsg;
	}
	
	function setArrMsg($msg)
	{
		array_push($this->arrMsg, $msg);
	}

	function __construct()
	{
		$this->setArrMsg("Constructing");
	}

	public function addMessage($key, $msg)
	{
		$this->setArrMsg($msg);
	}

	public function removeMessage($key)
	{
		$this->arrMsg[$key] = "";
	}

	public function getAllMessages()
	{
		return $this->getArrMsg();
	}

}

 ?>