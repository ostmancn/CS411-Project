<?php

  include "query_functions/group_queries.php";
  include "query_functions/portfolio_queries.php";

  function show_group_list() {
        $username = $_COOKIE["wolf_of_siebel_username"];
        $groups = get_group_list_for_user($username);
        foreach ($groups as $row) {
            $quick_view_code = "<a href=\"?page=MyGroups&show" . $row['GID'] . "\"> Portfolio Quick View </a>";

            if (isset($_GET["show" . $row['GID']])) {
               $quick_view_code = "<a href=\"?page=MyGroups\"> Hide </a>";
            }

            echo "<tr>";
            echo "  <td>" . $row['groupName'] . "</td>\n";
            echo "  <td>" . $row['groupName'] . "</td>\n";
            echo "  <td>" . $row['groupName'] . "</td>\n";
            echo "  <td> " . $quick_view_code . " </td>\n";
            echo "  <td></td>";
            echo "</tr>";

            if (isset($_GET["show" . $row['GID']])) {
                echo "<tr>";
                show_portfolio($row['GID']);
                echo "</tr>";
            }
        }
    } 

    function show_portfolio($GID) {
        $username = $_COOKIE["wolf_of_siebel_username"];
        $portfolio = get_stocks_portfolio_for_group($username, $GID);

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
        foreach ($portfolio as $stock) {
          echo "<tr>";
          echo "  <td>" . $stock['ticker'] . "</td>\n";
          echo "  <td>" . $stock['fullName'] . "</td>\n";
          echo "  <td>" . $stock['Industry'] . "</td>\n";
          echo "  <td>" . $stock['Market'] . "</td>\n";
          echo "  <td>" . $stock['boughtTime'] . "</td>\n";
          echo "  <td>" . $stock['boughtPrice'] . "</td>\n";
          echo "  <td>" . $stock['numShares'] . "</td>\n";
          echo "</tr>";
        }
      
        echo '</tbody>
            </table>';
    }


    function display() {
      echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Your Groups</h2>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Group Name</th>
                      <th>Rank</th>
                      <th>Members</th>
                      <th></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>';
                    show_group_list();
        echo '    </tbody>
                </table>
              </div>
             </div>';
    }

?>