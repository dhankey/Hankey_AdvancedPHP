<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>File Uploads</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
		<div style="width: 500px; float:left; margin: 30px;">
			<h3>Welcome to your online storage!</h3> <br/>
			<form enctype="multipart/form-data" action="upload.php" method="POST">
            Choose a File to Upload <input name="upfile" type="file" /><br/>
            *Valid file types include jpg, png, gif, txt, html, docx, xlsx<br/><br/>
            <input type="submit" value="Upload" class="btn btn-primary"/>
        </form>

        <br/> <a href="./viewAll.php">View All Documents</a>
		</div>
       
</body>
</html>