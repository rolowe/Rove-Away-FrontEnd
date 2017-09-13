<?php
	//echo "hello";
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	// Load configuration as an array. Use the actual location of your configuration file
	$config = parse_ini_file('config.ini');

	// Try and connect to the database
	$connection = mysqli_connect($config['host'], $config['username'], $config['password'], $config['dbname']);

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
			?>

				<form action="functions/update_airline.php" method="POST">
					<tr class="even pointer">
						<td class="">
							<?php echo $row["carrier_id"]; ?>
							<input type="hidden" name="carrier_id" value="<?php echo $row["carrier_id"]; ?>" />
						</td>
						<td class="">
							<h4><?php echo $row["carrier_name"]; ?></h4>
							<input type="hidden" name="carrier_name" value="<?php echo $row["carrier_name"]; ?>" />
						</td>
						<td class="">
							<select class="form-control" name="carrier_category">
								<option value="0">- Please Select -</option>
								<option value="1" <?php if($row["carrier_category"] === '1') { echo "selected"; } ?> >Top Rated</option>
								<option value="2" <?php if($row["carrier_category"] === '2') { echo "selected"; } ?> >Traditional</option>
								<option value="3" <?php if($row["carrier_category"] === '3') { echo "selected"; } ?> >Low Cost</option>
							</select>
						</td>
						<td class="last">
							<button type="submit" class="btn btn-primary">Update</button>
						</td>
					</tr>
				</form>
				<?php
    }
	} else {
	    echo "0 results";
	}
}


function get_location_data() {
	global $connection;
	$sql_query = "SELECT * FROM locations";
	$result = $connection->query($sql_query);

	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
			?>

				<form action="functions/update_location.php" method="POST">
					<tr class="even pointer">
						<td class="">
							<?php echo $row["location_id"]; ?>
							<input type="hidden" name="location_id" value="<?php echo $row["location_id"]; ?>" />
						</td>
						<td class="">
							<h4><?php echo $row["location_name"]; ?></h4>
							<input type="hidden" name="location_name" value="<?php echo $row["location_name"]; ?>" />
						</td>
						<td class="">
							<select class="form-control" name="holiday_type_1">
								<option value="0">--</option>
								<option value="1" <?php if($row["holiday_type_1"] === '1') { echo "selected"; } ?> >City</option>
								<option value="2" <?php if($row["holiday_type_1"] === '2') { echo "selected"; } ?> >Beach</option>
								<option value="3" <?php if($row["holiday_type_1"] === '3') { echo "selected"; } ?> >Ski</option>
							</select>
						</td>
						<td class="">
							<select class="form-control" name="holiday_type_2">
								<option value="0">--</option>
								<option value="1" <?php if($row["holiday_type_2"] === '1') { echo "selected"; } ?> >City</option>
								<option value="2" <?php if($row["holiday_type_2"] === '2') { echo "selected"; } ?> >Beach</option>
								<option value="3" <?php if($row["holiday_type_2"] === '3') { echo "selected"; } ?> >Ski</option>
							</select>
						</td>
						<td class="">
							<select class="form-control" name="activity_type_1">
								<option value="0">--</option>
								<option value="1" <?php if($row["activity_type_1"] === '1') { echo "selected"; } ?> >Culture</option>
								<option value="2" <?php if($row["activity_type_1"] === '2') { echo "selected"; } ?> >Party</option>
								<option value="3" <?php if($row["activity_type_1"] === '3') { echo "selected"; } ?> >Relax</option>
							</select>
						</td>
						<td class="">
							<select class="form-control" name="activity_type_2">
								<option value="0">--</option>
								<option value="1" <?php if($row["activity_type_2"] === '1') { echo "selected"; } ?> >Culture</option>
								<option value="2" <?php if($row["activity_type_2"] === '2') { echo "selected"; } ?> >Party</option>
								<option value="3" <?php if($row["activity_type_2"] === '3') { echo "selected"; } ?> >Relax</option>
							</select>
						</td>
						<td class="last">
							<button type="submit" class="btn btn-primary">Update</button>
						</td>
					</tr>
				</form>
				<?php
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
			// Success
			//echo "New Airline Added";
	} else {
	    echo "Error: " . $sql_query . "<br>" . $connection->error;
	}
}


function db_add_location($location_id, $location_name) {
	global $connection;
	$sql_query = "INSERT IGNORE INTO locations (location_id, location_name)
	VALUES ('$location_id', '$location_name')";

	if ($connection->query($sql_query) === TRUE) {
			// Success
			//echo "New Airline Added";
	} else {
	    echo "Error: " . $sql_query . "<br>" . $connection->error;
	}
}




?>
