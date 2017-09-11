<?php
	//echo "hello";
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Load configuration as an array. Use the actual location of your configuration file
	$config = parse_ini_file('config.ini');

	// Try and connect to the database
	$connection = mysqli_connect('localhost', $config['username'], $config['password'], $config['dbname']);

	// If connection was not successful, handle the error
	if($connection === false) {
	    echo "Cannot connect to the database.";
	}




function get_airline_data() {
	global $connection;
	$sql_query = "SELECT * FROM airlines";
	$result = $connection->query($sql_query);

	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

				echo '<tr class="even pointer">
					<td class="">' .$row["carrier_id"]. '</td>
					<td class=""><h4>' .$row["carrier_name"]. '</h4></td>
					<td class="">
						<select class="form-control" name="carrier_category">
							<option value="">- Please Select -</option>
							<option value="1">Top Rated</option>
							<option value="2">Traditional</option>
							<option value="3">Low Cost</option>
						</select>
					</td>
					<td class="last">
						<button type="submit" class="btn btn-primary">Update</button>
					</td>
				</tr>';

    }
	} else {
	    echo "0 results";
	}
}

//get_data('airlines');




function db_add_airline($carrier_id, $carrier_name) {
	global $connection;
	$sql_query = "INSERT IGNORE INTO airlines (carrier_id, carrier_name)
	VALUES ('$carrier_id', '$carrier_name')";

	if ($connection->query($sql_query) === TRUE) {
	    echo "New Airline Added";
	} else {
	    echo "Error: " . $sql_query . "<br>" . $connection->error;
	}
}




?>
