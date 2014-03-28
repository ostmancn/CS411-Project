<?php

	include "dashboard_loaders/query_functions/stock_queries.php";

	function show_all_stocks() {
		  $stocks = get_all_stocks("ap", "", "", "", "", "");
      $tickers = array();
      foreach ($stocks as $row) {
        $tickers[] = $row['ticker'];
      }
      $prices = get_stock_price_info($tickers);

	    for ($i = 0; $i < count($stocks); ++$i) {
	      echo "<tr>";
	      echo "  <td>" . $stocks[$i]['ticker'] . "</td>\n";
	      echo "  <td>" . $stocks[$i]['fullName'] . "</td>\n";
	      echo "  <td>" . $stocks[$i]['industry'] . "</td>\n";
	      echo "  <td>" . $stocks[$i]['market'] . "</td>\n";
        echo "  <td>" . $prices[$i][0] . "</td>\n";
	      echo "</tr>";
	    }
	}

	
	function display() {
		echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">All Stocks</h2>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Ticker</th>
                      <th>Full Name</th>
                      <th>Industry</th>
                      <th>Market</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>';
                    show_all_stocks();
        echo '    </tbody>
                </table>
              </div>
             </div>';
	}

?>