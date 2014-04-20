<?php

  require_once("query_objects/Portfolio.php");

  function show_group_list() {
        $username = $_COOKIE["wolf_of_siebel_username"];
        $user_object = User::get_user_object($username);
        $groups = $user_object->get_groups();
        foreach ($groups as $group) {
            $quick_view_code = "<a href=\"?page=MyGroups&showmore" . $group->GID . "\"> Portfolio Quick View </a>";

            if (isset($_GET["show" . $group->GID])) {
               $quick_view_code = "<a href=\"?page=MyGroups\"> Hide </a>";
            }

            echo "<tr>";
            echo "  <td> <a href=\"?page=Group&GID=" . $group->GID . "\">" . $group->group_name . " </a> </td>\n";
            echo "  <td>" . $group->group_name . "</td>\n";
            echo "  <td>" . $group->group_name . "</td>\n";
            echo "  <td> </td>\n";
            echo "  <td> " . $quick_view_code .  " </td>";
            echo "</tr>";

            if (isset($_GET["showmore" . $group->GID])) {
                echo "<tr> <td>";
                //show_portfolio($group);
                echo "</td> </tr>";
            }
        }
    } 

    function show_portfolio($group_object) {
        $username = $_COOKIE["wolf_of_siebel_username"];
        $portfolio = Portfolio::get_portfolio_object(null, $group_object->GID, $username);

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

        $stocks_in_port = $portfolio->get_bought_stocks();
        foreach ($stocks_in_port as $stock) {
          echo "<tr>";
          echo "  <td>" . $stock->ticker . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->full_name . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->sector . "</td>\n";
          echo "  <td>" . $stock->get_stock_object()->exchange . "</td>\n";
          echo "  <td>" . $stock->bought_time . "</td>\n";
          echo "  <td>" . $stock->bought_price . "</td>\n";
          echo "  <td>" . $stock->number_of_shares. "</td>\n";
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