<?php
    session_start();
    require_once '../../info.php';

	$dbh = new PDO("mysql:host=$hostname; dbname=$db; charset=utf8", $user, $pass, 	array(PDO::ATTR_EMULATE_PREPARES => false,
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
	try {
        $filters = [
            "value IS NOT NULL",
        ];

        if (isset($_SESSION['year'])) {
            if($_SESSION['year'] == "0") {
                unset($_SESSION['year']);
            } else {
                $filters[] = "year = {$_SESSION['year']}";
            }
        }

        if (isset($_SESSION['start'],$_SESSION['end'])) {
            $filters[] = "month BETWEEN {$_SESSION['start']} AND {$_SESSION['end']}";
        }

        $sql = "
            SELECT value, COUNT(*) AS count
            FROM data
            LEFT OUTER JOIN age
            ON data.age_id = age.id
            WHERE " . implode(' AND ', $filters) . "
            GROUP BY age_id;";

        $result = $dbh->prepare($sql);//prepares query
        $result->execute();
		
		$result->setFetchMode(PDO::FETCH_ASSOC); //fetching results as associative array

	 	$emparray[] = array();

		while ($row = $result->fetch()):
			$emparray[] = $row;
		endwhile;

		unset($emparray[0]);
		$emparray = array_values($emparray);
		echo json_encode($emparray);

		$dbh = null; //closes database connection
	}

	catch(PDOException $e) {
		echo $e -> getMessage();
	}
?>
