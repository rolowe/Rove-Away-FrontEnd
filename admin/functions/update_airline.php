<?php
  include "../config/db_connect.php";

  $carrier_id = htmlspecialchars($_POST["carrier_id"]);
  $carrier_category = htmlspecialchars($_POST["carrier_category"]);


  db_update_airline($carrier_id, $carrier_category);


  function db_update_airline($carrier_id, $carrier_category) {
    global $connection;
  	$sql_query = "UPDATE airlines SET carrier_category='$carrier_category' WHERE carrier_id='$carrier_id'";

  	if ($connection->query($sql_query) === TRUE) {
  			// Success
        header("Location: ../airlines?status=success");
  	} else {
  	    echo "Error: " . $sql_query . "<br>" . $connection->error;
        header("Location: ../airlines?status=error");
  	}
  }


 ?>
