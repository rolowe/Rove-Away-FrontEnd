<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB Connect
include "admin/config/db_connect.php";


// SkyScanner API KEY
$sk_api_key = "ro272479499858557678555613499413";

// Browse Cached Flights
$sk_browser_url = "http://partners.api.skyscanner.net/apiservices/browsequotes/v1.0/GB/GBP/en-GB/";

// Live Flight Price
$sk_live_price_url = "http://partners.api.skyscanner.net/apiservices/pricing/v1.0/GB/GBP/en-GB/";

?>
