<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hankey Lab 1</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <?php

        require_once './autoload.php';

        $addCRUD = new CRUD();

        $addresses = $addCRUD->readAll();

        include './views/view-address.php';

        ?>

        <a href="./views/add-address.php">Add an address</a>
    </body>
</html>
