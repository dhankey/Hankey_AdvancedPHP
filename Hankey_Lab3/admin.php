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

        if(!isset($_SESSION['user_id'])) header('Location: ./login.php');

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];

        require_once './autoload.php';

        $util = new Util();

        if($util->isPostRequest()) 
        {    
            session_destroy();
            $username = "";
            header('Location: ./login.php');
        }

     ?>
        <div style="width: 500px; float:left; margin: 30px;">
            <h3>Welcome to the admin vip page...Go Crazy</h3>
            <form action="#" method="post">   
              <input type="submit" value="Log Out" class="btn btn-primary" />
            </form><br />

            <a href="./index.php">Back to home</a>
        </div>
        <div style="width: 500px; float:right; margin: 30px;">
            <p><?php if(!empty($username)) { echo "Signed in as: " . $username; } else { echo "Not Signed in"; } ?></p>
        </div>
    </body>
</html>