<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>File Uploads</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<?php 
        session_start();

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];
        else header('Location: ./login.php');
        
        if(isset($_SESSION['user_id'])) $user_id = $_SESSION['user_id'];

        require_once './autoload.php';

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
			<h2>Welcome to your account page</h2>
			<a href="./index.php">Home</a>
			<hr />
		</div>

		<div id="content">

			<div class="miniTitle">Upload a new meme!</div>
			<div id="uploadForm" style="margin-bottom: 25px; float:left;">
				<form enctype="multipart/form-data" action="upload.php" method="POST">
		            Choose a File to Upload <input name="upfile" type="file" value="./images/templateMemes/template_one.jpg" /><br/>
		            *Valid file types include jpg, png, gif<br/><br/>
		           
		            Meme Top Text: <br /><input name="memetop" placeholder="Type Here" required="required" /> <br /><br />
            		Meme Bottom Text: <br /><input name="memebottom" placeholder="Type Here" required="required" /> <br /><br />
            		Meme Title: <br /><input name="memetitle" placeholder="Type Here" required="required" /> <br /><br />
		            <input type="submit" value="Upload" class="btn btn-primary"/>
		        </form>
			</div>

			<div id="gallery">
				<div class="miniTitle">Edit your current memes</div>
				<?php 

					$photoCrud = new PhotoCRUD();

					$photos = $photoCrud->read($user_id);

					foreach($photos as $photo) :
				?>
				<div class="thumbnail">
				<a href="./moreDetails.php?details=<?php echo $photo['photo_id'] ?>"><img src="./uploads/<?php echo $photo['filename']; ?>"  /></a>
				<p style="text-align: center; margin-top: 5px"><?php echo $photo['title']; ?></p>
			</div>
			<?php endforeach; ?>
			</div>
		</div>

	</div>
	<div id="footer">
	&copy; Dan Hankey | 2016 | Advanced PHP
	</div>
       
</body>
</html>