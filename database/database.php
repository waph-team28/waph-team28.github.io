<? php
        $mysqli = new mysqli('localhost', 'team28', 'RiddleStars', 'waph_team');
		if($mysqli->connect_errno) {
	 		printf("Database connection failed: %s\n", $mysqli->connect_error);
	 		exit();
		}

        function createPost($postOwner, $postContent){
        	global $mysqli;
			$prepared_sql = "INSERT INTO posts(postOwner, postContent) VALUES(?, ?);";
			$stmt = $mysqli->prepare($prepared_sql);
			$stmt->bind_param("ss", $postOwner, $postContent);
			$stmt->execute();
			$result = $stmt->get_result();
			
	    }
?>