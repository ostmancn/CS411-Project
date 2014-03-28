<?php

    function get_stock_price_info($tickers) {
        $file = "http://download.finance.yahoo.com/d/quotes.csv?s=";
        for ($i = 0;$i < 50;$i ++ ) {
            $file = $file . $tickers[$i] . "+";
        }

        $file = $file . "&f=l1&e=.csv";
        $file_handle = fopen($file, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }  
        fclose($file_handle);
        
        return $line_of_text;
    }

	function get_all_stocks($partname, $industry, $market, $sector, $price_min, $price_max) {
		$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $stmt = mysqli_prepare($con, 'SELECT * FROM Stock WHERE ticker LIKE ? OR fullName LIKE ?');
        $partname = $partname . "%";
        mysqli_stmt_bind_param($stmt, "ss", $partname, $partname);
        $stmt->execute();
        $result = $stmt->get_result();
        $retval = array();
        while ($row = mysqli_fetch_array($result)) {
            $retval[] = $row;
        }
        return $retval;
	}

?>