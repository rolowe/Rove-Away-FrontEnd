<?php
  session_start();
  include "config/config.php";
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Rove Away - Prototype</title>
  </head>

  <body>



        <div class="container">

          <h1>Rove Away</h1>

          <button class="ui button right">
            <a href="index.php">Start again</a>
          </button>


    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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



    <table class="ui celled striped table">
      <!-- <thead>
        <tr>
          <th>Departing</th>
          <th>Arriving</th>
          <th>Flight time</th>
          <th>Stops</th>
          <th>Flying with</th>
          <th>Pricing options</th>
        </tr>
      </thead> -->
      <tbody>

    <?php foreach ($oResult->Itineraries as $Itinerary): ?>

      <tr>
        <td>

        <table>
          <tr>
            <td>
                <?php
                  $ItineryId = $Itinerary->OutboundLegId;
                  $departingFrom = $aoLegs[$ItineryId]->OriginStation;
                  $arrivingTo = $aoLegs[$ItineryId]->DestinationStation;
                  $carrierId = $aoLegs[$ItineryId]->Carriers[0];
                ?>
                <?= $aoPlace[$departingFrom]->Name; ?><br>
                <?php echo date('D j F, Y, g:i a',strtotime( $aoLegs[$ItineryId]->Departure )); ?>
            </td>
            <td>
                <?= $aoPlace[$arrivingTo]->Name; ?><br>
                <?php echo date('D j F, Y, g:i a',strtotime( $aoLegs[$ItineryId]->Arrival )); ?>
            </td>
            <td>
                <?= $aoLegs[$ItineryId]->Duration; ?> mins
            </td>
            <td>
                <?php
                  $stopNo = count($aoLegs[$ItineryId]->Stops);
                  if ($stopNo > 0) {
                    echo $stopNo . " stop<br />";
                    foreach ( $aoLegs[$ItineryId]->Stops as $Stop ) {
                      echo $aoPlace[$Stop]->Name;
                    }
                  } else {
                    echo "Direct";
                  }
                ?>
            </td>
            <td>
                <img src="<?= $aoCarrier[$carrierId]->ImageUrl ?>" title="<?= $aoCarrier[$carrierId]->ImageUrl ?>" width="80" />
            </td>
          </tr>
        </table>

      </td>
      </tr>

      <tr>
        <td>

          <table>
            <tr>

            <?php foreach ($Itinerary->PricingOptions as $PricingOption) : ?>
              <td>

                <table>
                  <tr>
                    <td>
                      <h4>£<?= $PricingOption->Price; ?></h4>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <?php $AgentId = $PricingOption->Agents[0]; ?>
                      <img src="<?=$aoAgents[$AgentId]->ImageUrl; ?>" title="" width="80" />
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <a href="<?= $PricingOption->DeeplinkUrl; ?>">Book now</a><br>
                      <small>via <?=$aoAgents[$AgentId]->Name; ?></small>
                    </td>
                  </tr>
                </table>

              </td>
            <?php endforeach; ?>

            </tr>
          </table>

        </td>
      </tr>

    <?php endforeach; ?>

      </tbody>
    </table>



    </div>


</body>

</html>
