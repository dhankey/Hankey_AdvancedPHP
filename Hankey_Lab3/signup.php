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
            elseif($userCRUD->registeredEmail($values['email']))
            {
                array_push($message,'Sorry email is already registered');
            }

            if($validator->valueIsEmpty($values['password'])) 
            {
                array_push($message,'Sorry password is empty');
            } 
            elseif(!$validator->valueIsValid($values['password']))
            {
                array_push($message,'Sorry password is not valid');
            }
            elseif($values['password'] !== $values['confpassword'])
			{
				array_push($message,'Sorry password did not match the confirmation password');
			}
            else
            {
            	$values['password'] = password_hash($values['password'], PASSWORD_DEFAULT);
            }

            // Add user
            if(count($message) === 0)
            {
                if($userCRUD->create($values))
                {
                    array_push($message,'Succesfully Added');
                }
            }

            include './views/errors.php';
        }

     ?>
        <div style="width: 500px; float:left; margin: 30px;">
            <h3>Create an account</h3>
            <form action="#" method="post">   
              Email: <br /><input name="email" value="<?php echo $values['email'] ?>" /> <br /><br />
              Password: <br /><input name="password" type="password" /> <br /><br />
              Confirm Password: <br /><input name="confpassword" type="password" /> <br /><br />

               <input type="submit" value="Submit" class="btn btn-primary" />
            </form><br />

            <a href="./index.php">Back to home</a>
        </div>
        <div style="width: 500px; float:right; margin: 30px;">
            <p><?php if(!empty($username)) { echo "Signed in as: " . $username; } else { echo "Not Signed in"; } ?></p>
        </div>
    </body>
</html>