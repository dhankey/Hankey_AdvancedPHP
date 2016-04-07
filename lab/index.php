<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hankey Lab 1</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <?php

        require_once './functions/dbcon.php';
        require_once './functions/util.php';

        $addresses = getAllAddresses();

        include './views/view-address.php';

        ?>

        <a href="./views/add-address.php">Add an address</a>
    </body>
</html>
