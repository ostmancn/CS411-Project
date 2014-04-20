<?php

	require_once("query_objects/Stock.php");

	function show_all_stocks($start, $interval) {
		  $stocks = Stock::get_all_stocks("b", "", "", "", "", "", "");

	    for ($i = $start; $i < count($stocks) && $i < $start + $interval; $i ++) {
	      echo "<tr>";
	      echo "  <td>" . $stocks[$i]->ticker . "</td>\n";
	      echo "  <td>" . $stocks[$i]->full_name . "</td>\n";
	      echo "  <td>" . $stocks[$i]->sector . "</td>\n";
	      echo "  <td>" . $stocks[$i]->exchange . "</td>\n";
        echo "  <td>" . $stocks[$i]->get_price() . "</td>\n";
        echo "  <td>" . "" . "</td>\n";
	      echo "</tr>";
	    }
	}

	
	function display() {
    $start = 0;

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
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>';
                    show_all_stocks($start, 30);
        echo '    </tbody>
                </table>
              </div>
             </div>';
	}

?>