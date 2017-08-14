<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Rove Away | Travel planning on your terms</title>
  <link rel="icon" href="img/favicon.ico">

  <link rel="stylesheet" href="assets/css/lib/flexboxgrid/flexboxgrid.min.css" type="text/css">

	<link rel="stylesheet" type="text/css" href="assets/css/lib/datepicker/default.css">
	<link rel="stylesheet" type="text/css" href="assets/css/lib/datepicker/default.date.css">

	<link rel="stylesheet" href="assets/css/style.css" type="text/css">
</head>

<body>

  <div class="flexbox-container">
    <section>

      <div class="container">

      <img src="assets/img/rove-away.png" alt="Rove Away. Travel Planning on your terms." class="logo">

      <form action="results.php" method="POST" id="cache_flights">

        <div class="row">

          <div class="col-xs">
            <!-- <select id="iata" name="iata" class="ui search dropdown">
              <option value="">Select Airport</option>
							<option value="LOND">All London</option>
              <option value="LHR">London Heathrow</option>
              <option value="LGW">London Gatwick</option>
              <option value="BRS">Bristol</option>
            </select> -->

						<input type="text" id="airport-search" name="iata" list="json-datalist" placeholder="Leaving from...">
			      <datalist id="json-datalist">
							<select></select>
						</datalist>
          </div>

          <div class="col-xs">
            <input type="date" id="dep_date" name="dep_date" class="datepicker fieldset__input  picker__input" placeholder="Leaving?">
            <span>(or leave blank for any date)</span>
          </div>

          <div class="col-xs">
            <input type="date" id="ret_date" name="ret_date" class="datepicker fieldset__input  picker__input" placeholder="Coming home?">
            <span>(or leave blank to not specify)</span>
          </div>

          <div class="col-xs">
            <select id="ppl" name="ppl" class="ui search dropdown">
              <option value="">How many?</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>

        </div>

        <button type="submit" class="btn">Rove</button>
      </form>

      </div>

    </section>
  </div>

	<footer>
		<ul>
			<li><a href="http://www.facebook.com" target="_blank" class="social facebook">Facebook</a></li>
			<li><a href="http://www.instagram.com" target="_blank" class="social instagram">Instagram</a></li>
			<li><a href="http://www.twitter.com" target="_blank" class="social twitter">Twitter</a></li>
			<li><a href="#">Terms</a></li>
			<li><a href="#">Privacy</a></li>
		</ul>
	</footer>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

	<script src="assets/js/lib/picker.js"></script>
	<script src="assets/js/lib/picker.date.js"></script>

	<script src="assets/js/form_elements.js"></script>
	<script src="assets/js/search_airports.js"></script>
	<script src="assets/js/lib/datalist.polyfill.min.js"></script>

	<!-- <script src="js/main.js"></script> -->
</body>

</html>
