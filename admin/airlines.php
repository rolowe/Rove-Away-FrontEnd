<?php
	$body_class = "nav-md";
	include "templates/_head.php";
?>

<?php include "templates/left_col.php"; ?>

<?php include "templates/top_bar.php"; ?>


<!-- page content -->
    <div class="right_col" role="main">

        <div class="page-title">
          <div class="title_left">
            <h3>Airlines</h3>
          </div>
        </div>

        <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Recorded Carriers</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li>
                      	<a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li>
                      	<a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Carrier ID </th>
                            <th class="column-title">Carrier Nme </th>
                            <th class="column-title">Category </th>
                            <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php get_airline_data(); ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
        <!-- /page content -->




<?php include "templates/footer.php"; ?>

<?php include "templates/_footer.php"; ?>
