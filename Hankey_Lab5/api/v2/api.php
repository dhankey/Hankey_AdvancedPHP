<?php

include_once './bootstrap.php';

/*
 * The Rest server is sort of like the page is hosting the API
 * When a user calls the page (By url(HTTP), CURL, JavaScript etc.), the server(this Page) will handle the request.
 */
$restServer = new RestServer();

try {
    
    $restServer->setStatus(200);
    
    $resource = $restServer->getResource();
    $verb = $restServer->getVerb();
    $id = $restServer->getId();
    $serverData = $restServer->getServerData();
    
       
    /* 
     * You can add resoruces that will be handled by the server 
     * 
     * There are clever ways to use advanced variables to sort of
     * generalize the code below. That would also require that all
     * resoruces follow the same standard. Interfaces can ensure that.
     * 
     * But in this example we will just code it out.
     * 
     */
    if ( 'corps' === $resource ) {
        
        $resourceData = new CorpResoruce();
        var_dump($serverData['id']);
        
        if ( 'GET' === $verb ) 
        {
            
            if ( NULL === $serverData['id'] ) {
                
                $restServer->setData($resourceData->getAll());                           
                
            } else {
                
                $restServer->setData($resourceData->get($serverData['id']));
                
            }            
            
        }
                
        if ( 'POST' === $verb ) {
            

            if ($resourceData->post($serverData)) {
                $restServer->setMessage('Corporation Added');
                $restServer->setStatus(201);
            } else {
                throw new Exception('Corporation could not be added');
            }
        
        }
        
        
        if ( 'PUT' === $verb ) {
            
            if ( NULL === $serverData['id'] ) {
                throw new InvalidArgumentException('Corporation ID ' . $serverData['id'] . ' was not found');
            }
            else
            {
                if($resourceData->put($serverData))
                {
                    $restServer->setMessage('Corporation Updated');
                    $restServer->setStatus(201);
                }
            }
            
        }

        if ( 'DELETE' === $verb ) {
            
            if ( NULL === $serverData['id'] ) {
                throw new InvalidArgumentException('Corporation ID ' . $serverData['id'] . ' was not found');
            }
            else
            {
                if($resourceData->delete($serverData['id']))
                {
                    $restServer->setMessage('Corporation Deleted');
                    $restServer->setStatus(201);
                }
            }
            
        }
        
    } else {
        throw new InvalidArgumentException($resource . ' Resource Not Found');
        
    }
   
    
    /* 400 exeception means user sent something wrong */
} catch (InvalidArgumentException $e) {
    $restServer->setStatus(400);
    $restServer->setErrors($e->getMessage());
    /* 500 exeception means something is wrong in the program */
} catch (Exception $ex) {    
    $restServer->setStatus(500);
    $restServer->setErrors($ex->getMessage());   
}


echo $restServer->getReponse();
die();