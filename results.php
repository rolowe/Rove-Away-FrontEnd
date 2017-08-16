<?php
  include "config/config.php";

	$page_title = "Results travelling " .$_POST['dep_date']. " | Rove Away";
	include "templates/_head.php";
?>

<body>

  <?php include "templates/header.php"; ?>

  <section class="results-search">
    <div class="container">
      <img src="assets/img/rove-away.png" alt="Rove Away. Travel Planning on your terms." class="logo">
      <?php include "templates/forms/search.php"; ?>
    </div>
  </section>

    <div class="container">

    <?php
        // 1. GET Form Values
        // 1.1 IATA - AIRPORT CODE
        $iata = (isset($_POST['iata']) && preg_match('/^[A-Z]{3}$/', $_POST['iata'])) ? $_POST['iata'].'-iata' : 'anywhere';

        // 1.2 DEPARTURE DATE
        if ( isset($_POST['dep_date']) ) {
          $dep_date = str_replace("/", "-", $_POST['dep_date']);
        } else {
          $dep_date = 'anytime';
        }

        // 1.3 RETURNING DATE
        if ( isset($_POST['ret_date']) ) {
          $ret_date = str_replace("/", "-", $_POST['ret_date']);
        } else {
          $ret_date = "";
        }

        // 1.4 NO OF PEOPLE
        if ( isset($_POST['ppl']) ) {
          $ppl = str_replace("/", "-", $_POST['ppl']);
        } else {
          $ppl = "1";
        }

        // 2. URL
        $sUri = "{$sk_browser_url}{$iata}/anywhere/{$dep_date}/{$ret_date}?apikey={$sk_api_key}";

        // 3. Query
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $sUri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        $json = curl_exec($ch);
        curl_close($ch);

        // 4. attempt to parse
        if (($oResult = json_decode($json)) === null)
        {
            trigger_error("Something went wrong. Sorry.");
            exit(500);
        }

        // 5. Cache Carriers
        $aoCarrier = [];
        foreach ($oResult->Carriers AS $oCarrier)
        {
            $aoCarrier[$oCarrier->CarrierId] = $oCarrier;
        }

        // 6. Cache Places
        $aoPlace = [];
        foreach ($oResult->Places AS $oPlace)
        {
            $aoPlace[$oPlace->PlaceId] = $oPlace;
        }

        // 7. Results
        $sDest = str_replace('-iata', '', $iata);
        if (count($oResult->Quotes) > 0)
        {
            $sDest = $aoPlace[$oResult->Quotes[0]->OutboundLeg->OriginId]->Name;
        }

        // 8. sort on ascending price
        usort($oResult->Quotes, function($oA, $oB)
        {
            return ($oB->MinPrice === $oA->MinPrice) ? 0 : ($oB->MinPrice < $oA->MinPrice ? 1 : -1);
        });

    ?>



        <?php foreach ($oResult->Quotes AS $oQuote): ?>

          <div class="results-item col-3">

            <span class="fly-from"><?=$sDest; ?></span>
            <small>to</small>
            <h3><?=$aoPlace[$oQuote->OutboundLeg->DestinationId]->Name; ?></h3>

            <div class="dates">
              <span class="date">
                <?=date('M jS, Y', strtotime($oQuote->OutboundLeg->DepartureDate)); ?>
              </span>
              <?php if ($ret_date != "") { ?>
                  <span class="date">
                    <?=date('M jS, Y', strtotime($oQuote->InboundLeg->DepartureDate)); ?>
                  </span>
              <?php } ?>
            </div>

            <div class="price">
              <small>From </small>
              <h4>£<?=$oQuote->MinPrice;?><small>pp</small></h4>
            </div>


            <div class="flying-with">
              <small>Flying with</small><br>
              <?php foreach ($oQuote->OutboundLeg->CarrierIds AS $iCarrier): ?>
                  <?php
                  if($aoCarrier[$iCarrier]->Name != "") {
                    echo $aoCarrier[$iCarrier]->Name;
                  } else {
                    echo "Multiple Airlines";
                  }
                  ?>
              <?php endforeach; ?>
            </div>

            <a href="functions/start-live-session.php?originplace=<?= $iata; ?>&destinationplace=<?= $aoPlace[$oQuote->OutboundLeg->DestinationId]->IataCode; ?>&outbounddate=<?= $dep_date; ?>" class="btn">More info</a>

          </div>

        <?php endforeach; ?>

  </div>

  <?php include "templates/footer.php"; ?>

  <?php include "templates/_footer.php"; ?>
