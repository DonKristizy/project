<?php
	/**
     * serv.php
     *
     * Contains php functions required for database interactions.
     *
     * @author DonKristizy
     */
	if (is_ajax()) {
	  	if (isset($_POST["action"]) && !empty($_POST["action"])) { //Checks if action value exists
	    	$action = $_POST["action"];
	    	switch($action) { //Switch case for value of action
	      		case "nletter": nletter_func(); break;
	    	}
	  	}
	}

	//Function to check if the request is an AJAX request
	function is_ajax() {
	  	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	function nletter_func(){
		include_once('db_conx.php');
		if(isset($_POST['email']) && !empty($_POST['email'])) {	
			$message = array();
			$email = "";
			$email = $_POST['email'];
			$email = strtolower($email);

			if($email == "" ){
				$message[] = "You have to enter an email address";
			}
			
			// let's query the db
			$sql = "SELECT id FROM subs WHERE emails = '$email' LIMIT 1";
			$query = mysqli_query($db_conx,$sql);
			if(mysqli_num_rows($query) > 0 ){
				$message[] = "You are already subscribed to our Newsletter";
			}

			// Now lets check to see if there is any error
			$counterror = count($message);
			if($counterror > 0 ){
				for ($i = 0 ; $i < $counterror; $ii){
					echo $message[$i];
					exit();
				}
			}

			$query = mysqli_query($db_conx,"INSERT INTO subs (emails) VALUES('$email')");
			if ($query) {
				// Our new email has been inserted successfully
				echo "plus";
				exit();
			} else {
				echo "Sorry! There's a problem with our server...";
				exit();
			}
		} else {
			echo "You have to enter an email address";
		}
	}

?>