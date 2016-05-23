<?php 

interface IDAO 
{
    function create($values);
    function read($id);
    function update($values);
    function delete($id);
    function readAll();  
}

 ?>