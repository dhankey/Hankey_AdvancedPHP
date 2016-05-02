<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>View All</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body style="padding: 25px;">
        <?php
        $delete = -1;
        if(isset($_REQUEST['delete'])) { $delete = $_REQUEST['delete']; }
        $folder = './uploads';
        if ( !is_dir($folder) ) {
            die('Folder <strong>' . $folder . '</strong> does not exist' );
        }
        $directory = new DirectoryIterator($folder);
        $counter = 1;
        ?>

        <?php foreach ($directory as $file) : ?>        
            <?php if ( is_file($folder . DIRECTORY_SEPARATOR . $file) ) : ?>

                <?php if($delete == $counter) : ?>
                    <?php unlink($folder . DIRECTORY_SEPARATOR . $file) ?>
                <?php else: ?>

                <?php $ext = (explode("_", $file)); ?>

                <div style="margin-bottom: 25px; ">

                <p>
                    <?php echo ($counter-2) ?>. 
                    <span style="font-weight: bold;">File Name: </span><?php echo $file; ?> <br/>

                    <a href="./moreDetails.php?details=<?php echo $counter ?>">More Details</a> | <a href="./viewAll.php?delete=<?php echo $counter ?>" style="color: #C01212;">Delete</a>
                </p>

                </div>

            <?php endif; endif; ?>
        <?php $counter++; endforeach; ?>

    <a href="./index.php">Upload</a>
    </body>
</html>
