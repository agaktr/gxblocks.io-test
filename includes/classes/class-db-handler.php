<?php

class DB_Handler{

	/**
	 * DB properties.
	 */
	private $conn;
	private $servername;
	private $db_username;
	private $db_password;
	private $db_name;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    array    $q       		The actual file to be converted.
	 * @param    string   $conversion_type  The type of conversion that will be applied.
	 */
	public function __construct() {
		
		$this->sql_configuration();
		
	}

	
	/**
	* Function sql_configuration()
	* Configures the sql connection information
	* Change the config file named 'sql_config.txt' in the folder
	* 
	* Example:
	* $this->sql_configuration();
	*
	* @since    1.0
	*/
	private function sql_configuration(){
		
		if (file_exists('../sql_config.txt')){
			$sql_config = file_get_contents('../sql_config.txt');
		}else{
			
			$sql_config = file_get_contents('/home3/gxblocks/public_html/sql_config.txt');
		}
		
		
		$sql_info	= explode(',', $sql_config );
		
		$this->servername 	= $sql_info[0];
		$this->db_username 	= $sql_info[1];
		$this->db_password 	= $sql_info[2];
		$this->db_name 		= $sql_info[3];
		
	}

	/**
	* Function connect_to_db()
	* Open a connection to the db
	* Set the cmysqli object to the conn property of the class
	* 
	* Example:
	* $this->close_db_connection();
	*
	* @since    1.0
	*/
	public function connect_to_db(){
		
		// Create connection
		$this->conn = new mysqli($this->servername, $this->db_username, $this->db_password, $this->db_name );
	
		// Check connection
		if ($this->conn->connect_error) {
			
			die("Connection failed: " . $this->conn->connect_error);
			
		} 
		
	}
	
	
	
	/**
	* Function close_db_connection()
	* Closes the connection to the db
	* 
	* Example:
	* $this->close_db_connection();
	*
	* @since    1.0
	*/
	public function close_db_connection(){
		
		$this->conn->close();
		
	}
	
	
	
	/**
	* Function insert_mining_data($coins_data)
	* Closes the connection to the db
	* 
	* Example:
	* $this->insert_mining_data($coins_data);
	*
	* @since    1.0
	*/
	public function insert_mining_data($coins_data){
		
		//Insert to db
		$the_insert = '';
		foreach($coins_data as $coin_name=>$coin_data){
			$the_insert .= ',';
			$the_insert .= "'".$coin_data['insert']."'";
		}
        $time = time()+28800;
		$sql = "INSERT INTO raw_data (time, BTC,ZEC,LTC,DASH,ETH) VALUES (".$time.$the_insert.")";

		echo '</br>Importing</br>';
		if ($this->conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
		
	}
	
	
	
	/**
	* Function insert_energy_data($energy_data)
	* Closes the connection to the db
	* 
	* Example:
	* $this->insert_energy_data($energy_data);
	*
	* @since    1.0
	*/
	public function insert_energy_data($energy_data){

        $time = time()+28800;
		$sql = "INSERT INTO energy_data (time, energy_response) VALUES (".$time.",'".$energy_data."')";

		echo '</br>Importing</br>';
		if ($this->conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}
	
	
	
	/**
	* Function insert_portfolio_data($coins_data)
	* Closes the connection to the db
	* 
	* Example:
	* $this->insert_portfolio_data($coins_data);
	*
	* @since    1.0
	*/
	public function insert_portfolio_data($coins_data){
		
		//Insert to db
		$the_insert = '';
		foreach($coins_data as $coin_name=>$coin_data){
			
			if (empty($coin_data['insert'])){
				$insert_text = 'no-data';
			}else{
				$insert_text = $coin_data['insert'];
			}
			$the_insert .= ',';
			$the_insert .= "'".json_encode($insert_text)."'";
		}

        $time = time()+28800;
		$sql = "INSERT INTO portfolio_data (time, BTC,ZEC,LTC,DASH,ETH) VALUES (".$time.$the_insert.")";

		echo '</br>Importing</br>';
		if ($this->conn->query($sql) === TRUE) {
			echo "New record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}
	
	
	
	/**
	* Function get_info()
	* Closes the connection to the db
	* 
	* Example:
	* $this->get_info();
	*
	* @since    1.0
	*/
	public function get_info(){
		
		$sql = "SELECT * FROM raw_data";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

				$db_info[$row['time']]['BTC'] = $row['BTC'];
				$db_info[$row['time']]['ZEC'] = $row['ZEC'];
				$db_info[$row['time']]['LTC'] = $row['LTC'];
				$db_info[$row['time']]['DASH'] = $row['DASH'];
				$db_info[$row['time']]['ETH'] = $row['ETH'];
			}
		} else {
			echo "0 results";
		}
		
		return $db_info;
	}
	
	
	
	/**
	* Function get_last_info()
	* Closes the connection to the db
	* 
	* Example:
	* $this->get_last_info();
	*
	* @since    1.0
	*/
	public function get_last_info(){
		
		$sql = "SELECT * FROM raw_data ORDER BY time DESC LIMIT 1";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

				$db_info[$row['time']]['BTC'] = $row['BTC'];
				$db_info[$row['time']]['ZEC'] = $row['ZEC'];
				$db_info[$row['time']]['LTC'] = $row['LTC'];
				$db_info[$row['time']]['DASH'] = $row['DASH'];
				$db_info[$row['time']]['ETH'] = $row['ETH'];
			}
		} else {
			echo "0 results";
		}
		
		return $db_info;
	}
	
	
	
	/**
	* Function get_energy_info()
	* Closes the connection to the db
	* 
	* Example:
	* $this->get_energy_info();
	*
	* @since    1.0
	*/
	public function get_energy_info(){
		
		$sql = "SELECT * FROM energy_data ORDER BY id DESC LIMIT 1";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

				$db_energy_info_raw[$row['time']]['energy_response'] = $row['energy_response'];
			}
		} else {
			echo "0 results";
		}

		return $db_energy_info_raw;
	}
	
	
	
	/**
	* Function get_portfolio_info()
	* Closes the connection to the db
	* 
	* Example:
	* $this->get_portfolio_info();
	*
	* @since    1.0
	*/
	public function get_portfolio_info(){
		
		$sql = "SELECT * FROM portfolio_data";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

				$db_portfolio_info_raw[$row['time']]['BTC'] = $row['BTC'];
				$db_portfolio_info_raw[$row['time']]['ZEC'] = $row['ZEC'];
				$db_portfolio_info_raw[$row['time']]['LTC'] = $row['LTC'];
				$db_portfolio_info_raw[$row['time']]['DASH'] = $row['DASH'];
				$db_portfolio_info_raw[$row['time']]['ETH'] = $row['ETH'];
			}
		} else {
			echo "0 results";
		}
		
		return $db_portfolio_info_raw;
	}
	
	
	
	/**
	* Function get_portfolio_last_info()
	* Closes the connection to the db
	* 
	* Example:
	* $this->get_portfolio_last_info();
	*
	* @since    1.0
	*/
	public function get_portfolio_last_info(){
		
		$sql = "SELECT * FROM portfolio_data ORDER BY time DESC LIMIT 1";
		$result = $this->conn->query($sql);
		if ($result->num_rows > 0) {
			// output data of each row
			while($row = $result->fetch_assoc()) {

				$db_portfolio_info_raw[$row['time']]['BTC'] = $row['BTC'];
				$db_portfolio_info_raw[$row['time']]['ZEC'] = $row['ZEC'];
				$db_portfolio_info_raw[$row['time']]['LTC'] = $row['LTC'];
				$db_portfolio_info_raw[$row['time']]['DASH'] = $row['DASH'];
				$db_portfolio_info_raw[$row['time']]['ETH'] = $row['ETH'];
			}
		} else {
			echo "0 results";
		}
		
		return $db_portfolio_info_raw;
	}
	
	
	
	
	
	


}


?>