<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>More Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body style="padding: 25px;">
        <?php
        $details = $_REQUEST['details'];
        $folder = './uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }
        $directory = new DirectoryIterator($folder);
        $counter = 1;
        ?>


        
        <?php foreach ($directory as $file) : ?>        
            <?php if ( is_file($folder . DIRECTORY_SEPARATOR . $file) ) : ?>
                <?php $ext = (explode("_", $file)); ?>

                <?php if($details == $counter) : ?>
                
                <div style="margin-bottom: 25px; ">

                <p>
                    <span style="font-weight: bold;">File Name: </span><?php echo $file; ?> <br/>                    
                    <span style="font-weight: bold;">File Size: </span><?php echo $file->getSize(); ?><br/>
                    <span style="font-weight: bold;">File Type: </span><?php echo $ext[0]; ?><br/>
                    <span style="font-weight: bold;">Date Created: </span><?php echo date("l F j, Y, g:i a", $file->getMTime()); ?><br/>
                  
                </p>



                <?php if($ext[0] == 'img') : ?>
                <img src="./uploads/<?php echo $file; ?>" />

                <?php elseif($ext[0] == 'txt') : ?>
                <textarea readonly="true"><?php readfile("./uploads/$file"); ?></textarea>

                <?php elseif($ext[0] == 'pdf') : ?>
                <object data="./uploads/<?php echo $file; ?>" type="application/pdf" style="width: 500px; height: 700px;"></object>
                <?php endif; ?>

                <br/><br/><a href="./uploads/<?php echo $file ?>" download>Direct Download</a> | <a href="./viewAll.php?delete=<?php echo $counter ?>" style="color: #C01212;">Delete</a>

                

                </div>

            <?php endif; endif; ?>
        <?php $counter++; endforeach; ?>

    <a href="./index.php">Upload</a><br/> 
    <a href="./viewAll.php">View All Documents</a>
    </body>
</html>
