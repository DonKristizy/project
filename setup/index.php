<!DOCTYPE html>
<html lang="en">
<head>
	<title>Rukky's Project Setup</title>
	<meta charset="utf-8">
	<meta content="initial-scale=1.0, width=device-width" name="viewport">
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<div class="container">
		<header>
			<h1>ENTER YOUR DATABASE INFO HERE</h1>
		</header>
		<div class="main">
			<div class="setup-wrap">
				<form method="post" id="setup" action="">
					<div class="element">
						<input type="text" name="dbhost" placeholder="DATABASE Host (e.g 127.0.0.1 or localhost)" required>
					</div>
					<div class="element">
						<input type="text" name="dbuser" placeholder="DATABASE Username (e.g root)" required>
					</div>
					<div class="element">
						<input type="password" name="dbpass" placeholder="DATABASE Password">
					</div>
					<div class="element">
						<input type="text" name="dbname" placeholder="DATABASE Name" required>
					</div>
					<div class="element btn">
						<button type="submit" class="submit-btn" name="save">SAVE</button>
					</div>
					<!-- <p class="err">Error Message goes here</p> -->
				</form>
			</div>
		</div>
		<!-- <footer class="copyright">
			<p>Tizycorp Markup &copy; 2016</p>
		</footer> -->
	</div>
</body>
</html>
<?php
	// Let's do some php :D
	if (isset($_POST['dbhost']) && !empty($_POST['dbhost']) && isset($_POST['dbname']) && !empty($_POST['dbname']) && isset($_POST['dbuser']) && !empty($_POST['dbuser'])) {
		dbconx();
		include_once('../inc/db_conx.php');
		$query = mysqli_query($db_conx,"CREATE TABLE IF NOT EXISTS `subs` (`id` int(11) NOT NULL AUTO_INCREMENT, `emails` varchar(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
		if ($query) {
			echo "Setup was succesful... Redirecting and Deleting in 5secs..";
			$path = '../setup';
			cleanIT($path);
			header("refresh:5;url=../index.html");
		} else {
			echo "Sorry! There's a problem connecting to the database. Please check your database settings...";
			exit();
		}
	}

	function dbconx(){
		$dbhost = $dbuser = $dbpass = $dbname = $content = '';
		$dbhost = $_POST['dbhost'];
		$dbuser = $_POST['dbuser'];
		$dbpass = $_POST['dbpass'];
		$dbname = $_POST['dbname'];

		// Now let's play with files
		$myfile = fopen('../inc/db_conx.php', 'w') or die('Unable to open file!');
		$content .= '<?php
	$mysqli_host = "'.$dbhost.'";
	$mysqli_user = "'.$dbuser.'";
	$mysqli_pass = "'.$dbpass.'";
	$mysqli_db_name = "'.$dbname.'";

	$db_conx = @mysqli_connect($mysqli_host,$mysqli_user,$mysqli_pass,$mysqli_db_name);
	// evaluate the connection
	if (mysqli_connect_errno()) {
		echo mysqli_connect_error();
		exit();
	}
?>';
		fwrite($myfile, $content);
		fclose($myfile);
		return;
	}

	function cleanIT($path) {
		$files = glob($path.'/*');
		foreach ($files as $file) {
			is_dir($file) ? cleanIT($file) : unlink($file);
		}
		rmdir($path);
		return;
	}
?>

