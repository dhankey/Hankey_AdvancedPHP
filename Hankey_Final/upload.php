<!DOCTYPE html>
<html>
    <head>
        <title>Upload</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">      
    </head>
    <body style="padding: 25px;">
        <?php
        session_start();

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];
        else header('Location: ./login.php');
        
        if(isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];

        require_once './autoload.php';

        /*
         * make sure php_fileinfo.dll extension is enable in php.ini
         */

        class Filehandler 
        {

            function upLoad($keyName) 
            {
                $ext = $this->errorCheck($keyName);
                return $this->renameFile($keyName, $ext);
            }

            function errorCheck($keyName)
            {
                 // Undefined | Multiple Files | $_FILES Corruption Attack
                // If this request falls under any of them, treat it invalid.
                if (!isset($_FILES[$keyName]['error']) || is_array($_FILES[$keyName]['error'])) {
                    throw new RuntimeException('Invalid parameters.');
                }

                // Check $_FILES['upfile']['error'] value.
                switch ($_FILES[$keyName]['error']) {
                    case UPLOAD_ERR_OK:
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('No file sent.');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('Exceeded filesize limit.');
                    default:
                        throw new RuntimeException('Unknown errors.');
                }

                // You should also check filesize here. 
                if ($_FILES[$keyName]['size'] > 1000000) {
                    throw new RuntimeException('Exceeded filesize limit.');
                }

                // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
                // Check MIME Type by yourself.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $validExts = array(
                    'jpg'  => 'image/jpeg',
                    'png'  => 'image/png',
                    'gif'  => 'image/gif'
                );
                $ext = array_search($finfo->file($_FILES[$keyName]['tmp_name']), $validExts, true);


                if (false === $ext) {
                    throw new RuntimeException('Invalid file format.');
                }

                return $ext;
            }

            function renameFile($keyName, $ext)
            {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $extEnd = strtolower(end((explode(".", $finfo->file($_FILES[$keyName]['tmp_name'])))));

                // You should name it uniquely.
                // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
                // On this example, obtain safe unique name from its binary data.

                $salt = uniqid(mt_rand(), true);

                $fileName = 'img_' . sha1($salt . sha1_file($_FILES[$keyName]['tmp_name']));
                $location = sprintf('./uploads/%s.%s', $fileName, $ext);

                if (!is_dir('./uploads')) {
                    mkdir('./uploads');
                }

                if (!move_uploaded_file($_FILES[$keyName]['tmp_name'], $location)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }

                switch ($ext) 
                {
                    case "jpg" :
                    case "jpeg" :
                        $rImg = imagecreatefromjpeg("./uploads/" . $fileName . '.' . $ext);
                        break;
                    case "gif" :
                        $rImg = imagecreatefromgif("./uploads/" . $fileName . '.' . $ext);
                        break;
                    case "png" :
                        $rImg = imagecreatefrompng("./uploads/" . $fileName . '.' . $ext);
                        break;
                    default :
                        throw new RuntimeException("Error Bad Extention");
                        break;
                }

                $image_info = getimagesize("./uploads/" . $fileName . '.' . $ext);

                if (false === $image_info) 
                {
                    throw new RuntimeException('Invalid file format.');
                }

                $image_width = $image_info[0];
                $image_height = $image_info[1];

                // Set a maximum height and width
                $max_width = 300;
                $max_height = 300;
                $ratio_orig = $image_width / $image_height;

                if ($max_width / $max_height > $ratio_orig) 
                {
                    $max_width = $max_height * $ratio_orig;
                } 
                else 
                {
                    $max_height = $max_width / $ratio_orig;
                }

                $image_p = imagecreatetruecolor($max_width, $max_height);
                imagecopyresampled($image_p, $rImg, 0, 0, 0, 0, $max_width, $max_height, $image_width, $image_height);
                $memetop = filter_input(INPUT_POST, 'memetop');
                $memebottom = filter_input(INPUT_POST, 'memebottom');

                //Font Color (white in this case)
                $textcolor = imagecolorallocate($image_p, 255, 255, 255);
                $bgcolor = imagecolorallocate($image_p, 0, 0, 0);

                //y-coordinate of the upper left corner. 
                $yPos = intval($max_height - 20);
                if (null !== $memetop && strlen($memetop) > 0) 
                {
                    //x-coordinate of center. 
                    $xPosTop = intval(($max_width - 8.5 * strlen($memetop)) / 2);
                    // Set the background
                    imagefilledrectangle($image_p, 0, 0, $max_width, 20, $bgcolor); // top
                    //Writting the picture
                    imagestring($image_p, 5, $xPosTop, 0, $memetop, $textcolor);
                }

                if (null !== $memebottom && strlen($memebottom) > 0) 
                {
                    //x-coordinate of center. 
                    $xPosBottom = intval(($max_width - 8.5 * strlen($memebottom)) / 2);
                    // Set the background 
                    imagefilledrectangle($image_p, 0, $yPos, $max_width, $max_height, $bgcolor); //bottom
                    //Writting the picture
                    imagestring($image_p, 5, $xPosBottom, $yPos, $memebottom, $textcolor);
                }

                switch ($ext) 
                {
                    case "jpg" :
                    case "jpeg" :
                        if (!imagejpeg($image_p, $location)) 
                        {
                            throw new RuntimeException('Failed to move uploaded file.');
                        }
                        break;
                    case "gif" :
                        if (!imagegif($image_p, $location)) 
                        {
                            throw new RuntimeException('Failed to move uploaded file.');
                        }
                        break;
                    case "png" :
                        if (!imagepng($image_p, $location)) 
                        {
                            throw new RuntimeException('Failed to move uploaded file.');
                        }
                        break;
                    default :
                        throw new RuntimeException("Error Bad Extention");
                        break;
                }

                imagedestroy($rImg);
                imagedestroy($image_p);

                return $fileName . '.' . $ext;
            }

        }

        $filehandler = new Filehandler();

        try {

            $fileName = $filehandler->upLoad('upfile');
        } catch (RuntimeException $e) {
            $error = $e->getMessage();
        }
        ?>

        <?php if ( isset($fileName) ) : ?>
            <?php 

                $photoCrud = new PhotoCRUD();

                $values = array(
                "user_id" => $user_id,
                "filename" => $fileName,
                "title" => filter_input(INPUT_POST, 'memetitle')
                );

                if($photoCrud->create($values)) header('Location: ./userPage.php');
                else
                {
                    echo "There was an issue with uploading your file: " . $fileName; 
                } 

             ?>

        <?php else: ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

    <a href="./index.php">Back to home</a><br/> 
    <a href="./userPage.php">Back to your account</a>

    </body>
</html>