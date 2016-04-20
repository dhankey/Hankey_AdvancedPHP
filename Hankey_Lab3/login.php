<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hankey Lab 1</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
    <?php 
        session_start();

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];

    	require_once './autoload.php';

    	$userCRUD = new CRUD();
    	$validator = new Validation();
    	$util = new Util();

    	$values = filter_input_array(INPUT_POST);

    	if($util->isPostRequest()) 
        {    
            $message = array();

            // Checking if empty and valid  
			if ($validator->valueIsEmpty($values['email']))
            {
                array_push($message,'Sorry email is empty');
            }
            elseif(!$validator->emailIsValid($values['email']))
            {
                array_push($message,'Sorry email is not valid');
            }
            elseif(!$userCRUD->registeredEmail($values['email']))
            {
                array_push($message,'Sorry email is not registered');
            }

            if($validator->valueIsEmpty($values['password'])) 
            {
                array_push($message,'Sorry password is empty');
            } 
            elseif(!$validator->valueIsValid($values['password']))
            {
                array_push($message,'Sorry password is not valid');
            }

            // Add user
            if(count($message) === 0)
            {
                $results = $userCRUD->readLogin($values);

                if(count($results) > 0)
                {   
                    $passwordCheck = password_verify($values['password'], $results[0]['password']);
        
                    if($passwordCheck == true)
                    {
                        array_push($message,'Succesfully logged in');
                        $_SESSION['username'] = $results[0]['email'];
                        $_SESSION['user_id'] = $results[0]['user_id'];
                        $username = $_SESSION['username'];
                    }
                    else 
                    {
                        array_push($message,'Email or password were incorrect');
                    }
                }
            }

            include './views/errors.php';
        }

     ?>
        <div style="width: 500px; float:left; margin: 30px;">
            <h3>Log in</h3>
            <form action="#" method="post">   
              Email: <br /><input name="email"/> <br /><br />
              Password: <br /><input name="password" type="password" /> <br /><br />

               <input type="submit" value="Submit" class="btn btn-primary" />
            </form><br />

            <a href="./index.php">Back to home</a>
        </div>
        <div style="width: 500px; float:right; margin: 30px;">
            <p><?php if(!empty($username)) { echo "Signed in as: " . $username; } else { echo "Not Signed in"; } ?></p>
        </div>
    </body>
</html>