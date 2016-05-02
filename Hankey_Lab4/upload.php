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
                    'txt'  => 'text/plain',
                    'html' => 'text/html',
                    'pdf'  => 'application/pdf',
                    'doc'  => 'application/msword',
                    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'xls'  => 'application/vnd.ms-excel',
                    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
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

                if($extEnd === 'text/plain') $extEnd = 'txt';
                if($extEnd === 'document') $extEnd = 'doc';
                if($extEnd === 'text/html') $extEnd = 'html';
                if($extEnd === 'application/pdf') $extEnd = 'pdf';
                if($extEnd === 'sheet') $extEnd = 'xlsx';
                if($extEnd === 'image/jpeg' || $extEnd === 'image/png' || $extEnd === 'image/gif') $extEnd = 'img';

                $fileName = $extEnd . '_' . sha1($salt . sha1_file($_FILES[$keyName]['tmp_name']));
                $location = sprintf('./uploads/%s.%s', $fileName, $ext);

                if (!is_dir('./uploads')) {
                    mkdir('./uploads');
                }

                if (!move_uploaded_file($_FILES[$keyName]['tmp_name'], $location)) {
                    throw new RuntimeException('Failed to move uploaded file.');
                }

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
            <h2><?php echo $fileName; ?> is uploaded successfully.</h2>
        <?php else: ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>

    <a href="./index.php">Back to Upload</a><br/> 
    <a href="./viewAll.php">View All Documents</a>

    </body>
</html>