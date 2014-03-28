<?php

    function create_group($owner, $group_name) {
        $con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();

        $stmt = mysqli_prepare($con, "INSERT INTO  Groups (groupName, owner) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $group_name, $username);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } 

        $result = mysqli_query($con, 'SELECT * FROM Groups WHERE username="' . $username . '" AND groupName="' . $group_name . '" ORDER GID BY ASC');
        if ($row = mysqli_fetch_array($result)) {
            join_group($row['GID'], $username);
        } else {
            //TODO ERROR
        }
    }

    function join_group($GID, $username) {
        $con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();

        $stmt = mysqli_prepare($con, "INSERT INTO  PartOf (GID, username) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "is", $row['GID'], $username);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }
    }

    function get_all_groups() {
        $con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $result = mysqli_query($con, 'SELECT * FROM Groups');
        $return_val = array();
        while($row = mysqli_fetch_array($result)) {
            $return_val[] = $row;
        }
        return $return_val;
    }

    function get_group_list_for_user($username) {
        $con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $result = mysqli_query($con, 'SELECT * FROM Groups NATURAL JOIN PartOf WHERE username="' . $username . '"');
        $return_val = array();
        while($row = mysqli_fetch_array($result)) {
            $return_val[] = $row;
        }
        return $return_val;
    }

?>