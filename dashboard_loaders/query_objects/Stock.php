<?php

class Stock {

	private static $loaded_stocks;

	public $ticker;
	public $sector;
	public $exchange;
	public $full_name;

	public static function get_stock_object($ticker) {
		if (is_null(Stock::$loaded_stocks))
			Stock::$loaded_stocks = array();

		if (isset(Stock::$loaded_stocks[$ticker]))
			return Stock::$loaded_stocks[$ticker];

		$new_stock = new Stock;
		$new_stock->ticker = $ticker;
		$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $result = mysqli_query($con, 'SELECT * FROM Stock WHERE ticker="' . $ticker . '"');
        if (!$row = mysqli_fetch_array($result)) 
            return null;
        
        $new_stock->sector = $row['sector'];
        $new_stock->exchange = $row['exchange'];
        $new_stock->full_name = $row['fullName'];

        Stock::$loaded_stocks[$ticker] = $new_stock;

        return $new_stock;
	}

	public static function get_all_stocks($partticker, $partname, $industry, $market, $sector, $price_min, $price_max) {
		if (is_null(Stock::$loaded_stocks))
			Stock::$loaded_stocks = array();

		$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        if (strcmp($partname, "") == 0)
            $partname = "-----";
        else if (strcmp($partticker, "") == 0)
            $partticker = "-----";

        $stmt = mysqli_prepare($con, 'SELECT * FROM Stock WHERE ticker LIKE ? OR fullName LIKE ? ORDER BY ticker ASC');
        $partname = $partname . "%";
        $partticker = $partticker . "%";
        mysqli_stmt_bind_param($stmt, "ss", $partticker, $partname);
        $stmt->execute();
        $result = $stmt->get_result();
        $retval = array();

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
        	if (isset(Stock::$loaded_stocks[$row['ticker']])) {
        		$ret_value[$i] = Stock::$loaded_stocks[$row['ticker']];
        	} else {
        		$new_stock = new Stock;
	        	$new_stock->ticker = $row['ticker'];
	        	$new_stock->sector = $row['sector'];
	       		$new_stock->exchange = $row['exchange'];
	       		$new_stock->full_name = $row['full_name'];
	       		Stock::$loaded_stocks[$row['ticker']] = $new_stock;
	       		$ret_value[$i] = $new_stock;
       		}
       		$i ++;
        }
        return $ret_value;
	}

    public function get_price() {
        $con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $result = mysqli_query($con, 'SELECT * FROM Stock WHERE ticker="' . $this->ticker . '"');
        if (!$row = mysqli_fetch_array($result)) 
            return null;

        return $row['price'];
    }

/*
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
*/

	public function __construct() {
	}

}

?>