<?php

  require_once("query_objects/Group.php");
  require_once("query_objects/User.php"); 

    function show_portfolio($PID) {
        $portfolio = Portfolio::get_portfolio_object($PID, null, null);

        echo '<table class="table table-striped">
               <thead>
                <tr>
                  <th>Ticker</th>
                  <th>Full Name</th>
                  <th>Industry</th>
                  <th>Market</th>
                  <th>Bought Time</th>
                  <th>Bought Price</th>
                  <th># Shares</th>
                </tr>
              </thead>
              <tbody>';
        $stocks = $portfolio->get_bought_stocks()
        foreach ($stocks as $stock) {
          echo "<tr>";
          echo "  <td>" . $stock->ticker . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->fullname . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->sector . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->exchange . "</td>\n";
          echo "  <td>" . $stock->bought_time . "</td>\n";
          echo "  <td>" . $stock->bought_price . "</td>\n";
          echo "  <td>" . $stock->number_of_shares . "</td>\n";
          echo "</tr>";
        }
      
        echo '</tbody>
            </table>';
    }


    function display() {
      $PID = $_GET["PID"];
      echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Your Groups</h2>
              <div class="table-responsive">';
                show_portfolio($PID);
        echo '</div>
             </div>';
    }

?>