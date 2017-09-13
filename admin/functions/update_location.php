<?php
  include "../config/db_connect.php";

  $location_id = htmlspecialchars($_POST["location_id"]);
  $location_name = htmlspecialchars($_POST["location_name"]);
  $holiday_type_1 = htmlspecialchars($_POST["holiday_type_1"]);
  $holiday_type_2 = htmlspecialchars($_POST["holiday_type_2"]);
  $activity_type_1 = htmlspecialchars($_POST["activity_type_1"]);
  $activity_type_2 = htmlspecialchars($_POST["activity_type_2"]);

  db_update_airline($location_id, $location_name, $holiday_type_1, $holiday_type_2, $activity_type_1, $activity_type_2);


  function db_update_airline($location_id, $location_name, $holiday_type_1, $holiday_type_2, $activity_type_1, $activity_type_2) {
    global $connection;
  	$sql_query = "UPDATE locations SET holiday_type_1='$holiday_type_1', holiday_type_2='$holiday_type_2', activity_type_1='$activity_type_1', activity_type_2='$activity_type_2' WHERE location_id='$location_id'";

  	if ($connection->query($sql_query) === TRUE) {
  			// Success
        header("Location: ../locations?status=success");
  	} else {
  	    echo "Error: " . $sql_query . "<br>" . $connection->error;
        header("Location: ../locations?status=error");
  	}
  }


 ?>
