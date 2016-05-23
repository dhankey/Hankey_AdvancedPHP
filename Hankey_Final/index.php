<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Meme World</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body >
	
	<?php 
        session_start();

        if(isset($_SESSION['username'])) $username = $_SESSION['username'];
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
			<h2>Welcome to Meme World!</h2>
			<hr />
		</div>

		<div id="gallery">
			<div class="miniTitle">Meme Gallery</div>

			<div id="memeMonth">
				<h4 style='margin-bottom: 15px;'>Meme of the Moment</h4>

			</div>

			<div >

			<?php 

				$photoCrud = new PhotoCRUD();

				$photos = $photoCrud->readAll();

				$rand = rand(1, count($photos));
				$counter = 1;

				foreach($photos as $photo) :

					if($rand == $counter) :
			?>
						<script type="text/javascript">
							var meme = document.getElementById('memeMonth');
							meme.innerHTML 
							+= "<a href=\"./moreDetails.php?details=<?php echo $photo['photo_id'] ?>\">"
							+  "<img src=\"./uploads/<?php echo $photo['filename']; ?>\"  />"
							+  "</a>"
							+  "<p style=\"text-align: center; margin-top: 5px\">"
							+  "<?php echo $photo['title']; ?>"
							+  "</p>";
							</script>
							
					<?php else : ?>
						<div class="thumbnail">
							<a href="./moreDetails.php?details=<?php echo $photo['photo_id'] ?>"><img src="./uploads/<?php echo $photo['filename']; ?>"  /></a>
							<p style="text-align: center; margin-top: 5px"><?php echo $photo['title']; ?></p>
						</div>
					<?php endif; ?>
			<?php $counter++; endforeach; ?>
		</div></div>

	</div>
	<div id="footer">
	&copy; Dan Hankey | 2016 | Advanced PHP
	</div>

</body>
</html>