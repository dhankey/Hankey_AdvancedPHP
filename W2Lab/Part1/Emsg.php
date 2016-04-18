<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <title>Hankey Lab 2</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body>
        <?php

        require_once './autoload.php';

        $msg = new ErrorMessage();
        $msg->addMessage(0,"Hi");
        if(filter_input(INPUT_POST, 'msg') != "") $msg->addMessage(0,filter_input(INPUT_POST, 'msg'));
        $msg->removeMessage(0);

        $myMessages = $msg->getAllMessages();
        ?>

        <div class="container">
            <h3>Add a message</h3>
            <form action="#" method="post">   
               Message: <br /><input name="msg" /> <br /><br />
               <input type="submit" value="Add" class="btn btn-primary" />
            </form>

            <?php if(count($myMessages) > 0) : ?>

            <h3>My Messages</h3>
            <ul>

            <?php for($i = 0; $i < count($myMessages); $i++) : ?>

                <?php if($myMessages[$i] != "") : ?>
                <li>
                    <?php echo $myMessages[$i]; ?>
                </li>

                <?php endif ?>

            <?php endfor; ?>

            </ul>
        <?php else : ?>

            <h3>Sorry there were no messages stored.</h3>

        <?php endif; ?>


        </div>
    </body>
</html>