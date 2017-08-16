<?php
  session_start();
  include "config/config.php";

  $page_title = "Live Prices | Rove Away";
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
      $session_key = preg_replace('/\s+/', '', $_SESSION['livesession']);
      $livepriceURL = "http://partners.api.skyscanner.net/apiservices/pricing/uk1/v1.0/" . $session_key;


      // 1. Query
      $session_url = $livepriceURL . "?apiKey=de995438234178656329029769192274";
      //echo $session_url;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $session_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
      $json = curl_exec($ch);
      curl_close($ch);

      // 2. Attempt to parse
      if (($oResult = json_decode($json)) === null)
      {
          trigger_error("Something went wrong. Sorry.");
          exit(500);
      }

      // 3. Match Itinery to Legs
      $aoLegs = [];
      foreach ($oResult->Legs AS $oLegs)
      {
          $aoLegs[$oLegs->Id] = $oLegs;
      }

      // 4. Cache Agents
      $aoAgents = [];
      foreach ($oResult->Agents AS $oAgents)
      {
          $aoAgents[$oAgents->Id] = $oAgents;
      }

      // 5. Cache Carriers
      $aoCarrier = [];
      foreach ($oResult->Carriers AS $oCarrier)
      {
          $aoCarrier[$oCarrier->Id] = $oCarrier;
      }

      // 6. Cache Places
      $aoPlace = [];
      foreach ($oResult->Places AS $oPlace)
      {
          $aoPlace[$oPlace->Id] = $oPlace;
      }

  ?>


    <?php foreach ($oResult->Itineraries as $Itinerary): ?>

        <div class="results-item col-1">

                <?php
                  $ItineryId = $Itinerary->OutboundLegId;
                  $departingFrom = $aoLegs[$ItineryId]->OriginStation;
                  $arrivingTo = $aoLegs[$ItineryId]->DestinationStation;
                  $carrierId = $aoLegs[$ItineryId]->Carriers[0];
                ?>

                <div class="col-6">
                  <h3><?= $aoPlace[$departingFrom]->Name; ?></h3>
                    <?php echo date('D j F, Y, g:i a',strtotime( $aoLegs[$ItineryId]->Departure )); ?>
                </div>

                <div class="col-6">
                  <h3><?= $aoPlace[$arrivingTo]->Name; ?></h3>
                    <?php echo date('D j F, Y',strtotime( $aoLegs[$ItineryId]->Arrival )); ?><br>
                    <?php echo date('g:i a',strtotime( $aoLegs[$ItineryId]->Arrival )); ?>
                </div>

                <div class="col-6">
                  <br>
                  <?php echo convertToHoursMins($aoLegs[$ItineryId]->Duration, '%02d hours %02d mins'); ?>
                  <br>
                  <?php
                    $stopNo = count($aoLegs[$ItineryId]->Stops);
                    if ($stopNo > 0) {
                      echo $stopNo . " stop<br />";
                      foreach ( $aoLegs[$ItineryId]->Stops as $Stop ) {
                        echo "<small>" . $aoPlace[$Stop]->Name . "</small><br>";
                      }
                    } else {
                      echo "Direct";
                    }
                  ?>
                </div>

                <div class="col-6">
                  <small>Flying with</small><br>
                  <img src="<?= $aoCarrier[$carrierId]->ImageUrl ?>" title="<?= $aoCarrier[$carrierId]->ImageUrl ?>" width="80" />
                </div>



                  <?php
                    $count = 0;
                    foreach ($Itinerary->PricingOptions as $PricingOption) :
                      $count++;

                    ?>

                      <div class="col-6">
                        <?php if($count == 1) { ?>
                        <br>
                        <h4>£<?= $PricingOption->Price; ?></h4>
                      </div>

                      <?php $AgentId = $PricingOption->Agents[0]; ?>

                      <div class="col-6">


                          <?php if($count != 1) { ?>
                            <img src="<?= $aoAgents[$AgentId]->ImageUrl; ?>" title="" width="80" />
                          <?php } ?>

                          <a href="<?= $PricingOption->DeeplinkUrl; ?>" class="btn">Book now</a><br>
                          <small>via <?=$aoAgents[$AgentId]->Name; ?></small>

                        <?php } ?>
                      </div>
                  <?php endforeach; ?>



          </div>

    <?php endforeach; ?>



    <?php
      function convertToHoursMins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
      }
    ?>


    <?php include "templates/footer.php"; ?>

    <?php include "templates/_footer.php"; ?>
