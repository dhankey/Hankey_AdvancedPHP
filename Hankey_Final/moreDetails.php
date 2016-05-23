<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>More Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Social Media Stuff -->
    <script type="text/javascript">var switchTo5x=true;</script>
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "92a6608d-7abd-4469-85f8-ba0fc029edbc", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>

    </head>
    <body>
     <?php
        session_start();

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];
        if(isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];

    ?>

        <div id="wrapper">
        <div id="login">
            <?php if(!empty($username)) : ?>
            <p>Signed in as: <?php echo $username; ?></p>
            <a href="./userPage.php">Your Account</a><br/>
            <a href="./logout.php">Log Out</a><br/>

            <?php else : ?>
            <p>Not Signed in</p>

            <a href="./login.php">Log in</a><br/>
            <a href="./signup.php">Create an account</a><br/>
            <?php endif; ?>
        </div>

        <div id="header">
            <h2>More Details!</h2>
            <hr />
        </div>

        <?php

        if(isset($_REQUEST['details'])) $details = $_REQUEST['details'];
        if(isset($_REQUEST['delete'])) $delete = $_REQUEST['delete'];
        
        $folder = './uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }

        $directory = new DirectoryIterator($folder);    

        require_once './autoload.php';
       
        $photoCrud = new PhotoCRUD();

        $photos = $photoCrud->readAll();

        foreach($photos as $photo) :  

        if(!empty($delete) && $delete == $photo['photo_id'] && $user_id == $photo['user_id']) 
        {
            unlink($folder . DIRECTORY_SEPARATOR . $photo['filename']);
            $photoCrud->delete($photo['photo_id']);
            header('Location: ./userPage.php');
        }

        ?>
               
            <?php if ( is_file($folder . DIRECTORY_SEPARATOR . $photo['filename']) ) : ?>

                <?php if($details == $photo['photo_id']) : 
                            $views = $photo['views']; 
                            $views++; ?>
                
                <div style="margin-bottom: 25px; ">

                <p>
                    <span style="font-weight: bold;">Meme Title: </span><?php echo $photo['title']; ?> <br/>                    
                    <span style="font-weight: bold;">Views: </span><?php echo $photo['views']; ?><br/>
                    <?php foreach ($directory as $file) : ?>
                        <?php if($file == $photo['filename']) : ?>
                    <span style="font-weight: bold;">File Size: </span><?php echo $file->getSize(); ?><br/>
                    <?php endif; endforeach; ?>
                    <span style="font-weight: bold;">Date Created: </span><?php echo $photo['created']; ?><br/>
                </p>

                <img src="./uploads/<?php echo $photo['filename']; ?>" />

                <br/><br/>Share on your Social Media!<br/><br/>
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_email_large' displayText='Email'></span><br/><br/>
                <a href="./uploads/<?php echo $photo['filename'] ?>" download>Direct Download</a>
                <?php if(!empty($user_id) && $user_id == $photo['user_id']) : ?> | <a href="./moreDetails.php?delete=<?php echo $photo['photo_id'] ?>" style="color: #C01212;">Delete</a> <?php endif; ?>

                <?php 

                    $photo['views'] = $views;
                    $photoCrud->update($photo);
                 ?>
                
                </div>

            <?php endif; endif; ?>
        <?php endforeach; ?>

    <a href="./index.php">Home</a><br/> 
    </div>
    </body>
</html>
