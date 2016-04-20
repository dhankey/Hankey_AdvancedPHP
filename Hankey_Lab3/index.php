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

     ?>
        <div style="width: 500px; float:left; margin: 30px;">
            <h3>Welcome</h3>

            <a href="./signup.php">Create an account</a><br/>
            <a href="./login.php">Log in</a><br/>
            <a href="./admin.php">Admin Page</a><br/>
        </div>
        <div style="width: 500px; float:right; margin: 30px;">
            <p><?php if(!empty($username)) { echo "Signed in as: " . $username; } else { echo "Not Signed in"; } ?></p>
        </div>
    </body>
</html>
