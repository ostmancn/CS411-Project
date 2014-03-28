<?php

	include "query_functions/group_queries.php";

	function show_all_groups() {
		$groups = get_all_groups($username);
    foreach ($groups as $row) {
      echo "<tr>";
      echo "  <td>" . $row['groupName'] . "</td>\n";
      echo "  <td>" . $row['groupName'] . "</td>\n";
      echo "  <td>" . $row['groupName'] . "</td>\n";
      echo '  <td> <a data-toggle="modal" href="#JoinGroup" link-number="' . $row['GID'] . '"> Join </a> </td>';
      echo "</tr>";
    }
	}

  function modaljs() {
    echo "<script type=\"text/javascript\">
     $(function(){
      $('a[link-number]').live('click', function() {
        alert('Below');
        var index = $(this).attr('link-number') * 1 - 1;
        $('#coverTextH3').text(data[index].H3)
        $('#coverTextP').text(data[index].P)
      });
    });
    </script>";
  }

  function modaldisplay() {
    echo '<div class="modal fade" id="JoinGroup" tabindex="-1" role="dialog" aria-labelledby="purchaseLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="SignUpForm" action="/form_submisions/create_user_form.php" method="post">
              <div class="modal-content">
                <div class="modal-header">
                  <h3>Enter Information</h3>
                </div>
                <div class="modal-body" style= "padding-top: 0px;" >
                  <div class="divDialogElements">
                    <h4>Username</h4>
                    <input class="xlarge" id="xlInput" name="username" value="" type="text">
                    
                    <h4>Pasword</h4>
                    <input class="xlarge" id="xlInput" name="password" value="" type="text">
                    
                    <h4>Retype Pasword</h4>
                    <input class="xlarge" id="xlInput" name="repassword" value="" type="text">
                    
                    <hr style="height:1px;border:none;color:#333;background-color:#333;">
                    <h4>Name</h4>
                    <input class="xlarge" id="xlInput" name="name" value="" type="text">
                    <h4>Email</h4>
                    <input class="xlarge" id="xlInput" name="email" value="" type="text">
                  </div>
                </div>
                <div class="modal-footer">
                  <a href="#" class="btn btn-primary" data-dismiss="modal">Cancel</a>
                  <input type="submit" id="submit" class="btn btn-primary" value="Submit"><br>
                </div>
              </div>
          </form>
        </div>
      </div>';
  }


	function display() {
    modaljs();
    modaldisplay();

		echo '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h2 class="sub-header">Group Finder</h2>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Group Name</th>
                      <th>Members</th>
                      <th>Spots Left</th>
                      <th></th>
                      <th>Join!</th>
                    </tr>
                  </thead>
                  <tbody>';
                    show_all_groups();
    echo '        </tbody>
                </table>
              </div>
             </div>';
	}

?>