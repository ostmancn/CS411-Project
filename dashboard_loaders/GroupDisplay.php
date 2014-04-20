<?php

require_once("query_objects/Portfolio.php");

function show_group_user_list($group) {
  $users = $group->get_group_users();
  foreach ($users as $user) {
    $quick_view_code = "<a href=\"?page=Group&GID=" . $group->GID . "&showmore" . $user->username . "\"> Portfolio Quick View </a>";

    if (isset($_GET["showmore" . $user->username])) 
     $quick_view_code = "<a href=\"?page=Group&GID=" . $group->GID . "\"> Hide </a>";

   echo "<tr>";
   echo "  <td>" . $user->name . "</td>\n";
   echo "  <td>" . "</td>\n";
   echo "  <td>" . "</td>\n";
   echo "  <td> " . "</td>\n";
   echo "  <td> " . $quick_view_code . " </td>";
   echo "</tr>";

    if (isset($_GET["showmore" . $user->username])) {
      echo "<tr> <td colspan=\"5\" style=\"
    padding-left: 30px;
    padding-right: 30px;
    padding-bottom: 20px;
    \">";
        show_portfolio($user->get_portfolios()[$group->GID]);
      echo "</td> </tr>";
    }
  }
} 

function show_portfolio($portfolio) {

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
  $group = Group::get_group_object($_GET["GID"]);

  echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
  <h2 class="sub-header">' . $group->group_name . '</h2> <br>
  <h3 class="sub-header"> Owned by ' . $group->owner_username . '</h3>
  <div class="table-responsive">
  <table class="table table-striped">
  <thead>
  <tr>
  <th>Name</th>
  <th>Rank</th>
  <th>Number of Transactions</th>
  <th> Profit </th>
  <th></th>
  </tr>
  </thead>
  <tbody>';
  show_group_user_list($group);
  echo '    </tbody>
  </table>
  </div>
  </div>';
}

?>