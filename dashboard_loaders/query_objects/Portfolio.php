<?php

require_once("User.php");
require_once("Group.php");
require_once("BoughtStock.php");

class Portfolio {

	private static $loaded_portfolios;

	private $owner_user_object;
	private $username;

	private $portfolio_name;

	private $GID;
	private $group_object;

	private $money_left;

	private $PID;

	private $bought_stocks_objects;

	public static function get_portfolio_object($PID, $GID, $username) {
		if (is_null(Portfolio::$loaded_portfolios))
			Portfolio::$loaded_portfolios = array();

		if (isset(Portfolio::$loaded_portfolios[$PID]))
			return Portfolio::$loaded_portfolios[$PID];

		$new_port = new Portfolio(null, null, null, null);
		$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();
        
        $result = null;
        if (is_null($PID)) 
        	$result = mysqli_query($con, 'SELECT * FROM Portfolio WHERE GID="' . $GID . '" AND username="' . $username . '"');
        else 
        	$result = mysqli_query($con, 'SELECT * FROM Portfolio WHERE PID="' . $PID . '"');
        
        if (!$row = mysqli_fetch_array($result)) 
            return null;
        
        $new_port->username = $row['username'];
        $new_port->GID = $row['GID'];
        $new_port->money_left = $row['moneyLeft'];
        $new_port->PID = $row['PID'];

        Portfolio::$loaded_portfolios[$PID] = $new_port;

        return $new_port;
	}

	public function __construct($username, $portfolio_name, $GID, $money_left) {
		if (is_null($username) || is_null($username) || is_null($GID) || is_null($money_left))
			return;

		$this->username = $username;
		$this->portfolio_name = $portfolio_name;
		$this->GID = $GID;
		$this->money_left = $money_left;

		$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
        if (mysqli_connect_errno($con))
            echo "Failed to connect to MySQL: " , mysqli_connect_error();

        $stmt = mysqli_prepare($con, "INSERT INTO  Portfolio (GID, moneyLeft, pName, username) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iiss", $GID, $money_left, $portfolio_name, $username);
        if (!mysqli_stmt_execute($stmt)) {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        	return;
        }

        $this->PID = mysqli_insert_id($con);
        Portfolio::$loaded_portfolios[$this->PID] = $this;
	}

	public function get_owner_user_object() {
		if (is_null($this->owner_user_object)) {
			$this->owner_user_object = User::get_user_object($this->username);
		}
		return $this->owner_user_object;
	}

	public function get_group_object() { 
		if (is_null($this->group_object)) {
			$this->group_object = Group::get_group_object($this->GID);
		}
		return $this->group_object;
	}

	public function get_bought_stocks() {
		if (is_null($this->bought_stocks_objects)) {
			$con = mysqli_connect("engr-cpanel-mysql.engr.illinois.edu", "wolfofsiebel_usr", "qwertyuiop1", "wolfofsiebel_db");
	        if (mysqli_connect_errno($con))
	            echo "Failed to connect to MySQL: " , mysqli_connect_error();
	        
	        $result = mysqli_query($con, 'SELECT * FROM BoughtStock WHERE PID="' . $this->PID . '"');
	        $this->bought_stocks_objects = array();
	        while ($row = mysqli_fetch_array($result))
	            $this->bought_stocks_objects[$row['ticker']] = BoughtStock::get_bought_stock_object($row['ticker'], $row['PID']);
		}
		return $this->bought_stocks_objects;
	}

}

?>