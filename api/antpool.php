<?php

// load classes
error_reporting(E_ALL);

//Path to db handler Class
$db_class_path 	= '/home3/gxblocks/public_html/includes/classes/class-db-handler.php';
	
//Include the db handler
require_once( $db_class_path );	

class antpool {

	// configurations
	private $print_error_if_api_down = true;

	// private methods
	function __construct($username, $api_key, $api_secret) {
		$this->username = $username;
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;

		// todo: check if given data is correct

		if (!function_exists('curl_exec')) {
			exit("Error: Please install PHP curl extension to use this Software.\r\n $ apt-get install php5-curl\r\n");
		}
	}

	function __destruct() {
		unset($this->username, $this->api_key, $this->api_secret);
	}

	function get($type, $currency = 'BTC') {
		// generate api parameters
		$nonce = time();
		$hmac_message = $this->username.$this->api_key.$nonce;
		$hmac = strtoupper(hash_hmac('sha256', $hmac_message, $this->api_secret, false));

		// create curl request
		$post_fields = array(
			'key' => $this->api_key,
			'nonce' => $nonce,
			'signature' => $hmac,
			'coin' => $currency,
			'pageSize' => 99
		);

		$post_data = '';
		foreach($post_fields as $key => $value) {
			$post_data.= $key.'='.$value.'&';
		}
		rtrim($post_data, '&');


		$ch = curl_init();
		#curl_setopt($ch, CURLOPT_URL, 'https://maaapi.mooo.com/api/'.$type.'.htm');
		curl_setopt($ch, CURLOPT_URL, 'https://antpool.com/api/'.$type.'.htm');
		// todo: switch to public cert
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_POST, count($post_fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// set large timeout because API lak sometimes
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$result = curl_exec($ch);
		curl_close($ch);

		// check if curl was timed out
		if ($result === false) {
			if ($this->print_error_if_api_down) {
				exit('Error: No API connect');
			} else {
				exit();
			}
		}

		// validate JSON
		$result_json = json_decode($result);
		if (json_last_error() != JSON_ERROR_NONE) exit('Error: read broken JSON from API - JSON Error: '.json_last_error().' ('.$result.')');

		if ($result_json->message == 'ok') {
			
			return $result_json->data;
		} else {
			return '';
		}

	}

	function config($config, $value) {
		if (isset($this->$config)) {
			$this->$config = $value;
		}
	}
}

//Init coins
$coins = array(
	'BTC'	=> array(
		'username'		=> 'theok',
		'api_key'		=>	'34e3ef60034340cb8d5b5e401d4ebba2',
		'api_secret'	=>	'ec4f138f894e4093906fb0677957820e'
	),
	'ZEC'	=> array(
		'username'		=> 'theok',
		'api_key'		=>	'daacd23746414437b68cfcb7da9bb0f0',
		'api_secret'	=>	'fe1c2f85429e4aabb97fa55581289e1d'
	),
	'LTC'	=> array(
		'username'		=> 'theok',
		'api_key'		=>	'ad6dde8e46cf47879fd3c06c0274f380',
		'api_secret'	=>	'b4715b0264b14ad09b5dc206f666258a'
	),
	'DASH'	=> array(
		'username'		=> 'theok',
		'api_key'		=>	'e7f29e8876cd45e994f3bad88a5de5bc',
		'api_secret'	=>	'f0bcc70a80284f77a586547f0cfee696'
	),
	'ETH'	=> array(
		'username'		=> 'theok',
		'api_key'		=>	'b302cdd913344fd2bcbaff98d14a75c9',
		'api_secret'	=>	'a3e63effd07f482dbd31b7a57ca3c406'
	)
);

//foreach coing get data
$coins_data = array();
foreach($coins as $coin_name=>$coin_data){
	$ant 	= new antpool($coin_data['username'], $coin_data['api_key'], $coin_data['api_secret']);
	echo '</br>Fetching: '.$coin_name.'</br>';
	$coins_data[$coin_name]['hashrate'] = json_encode($ant->get('hashrate',$coin_name));
	$coins_data[$coin_name]['workers'] = json_encode($ant->get('workers',$coin_name));
	$coins_data[$coin_name]['paymentHistory'] = json_encode($ant->get('paymentHistory',$coin_name));
	$coins_data[$coin_name]['insert'] = $coins_data[$coin_name]['hashrate'].'+'.$coins_data[$coin_name]['workers'].'+'.$coins_data[$coin_name]['paymentHistory'];
	echo 'Completed: '.$coin_name.'</br>';
//	var_dump($coins_data[$coin_name]);
}

//Unset api
unset($ant);

$dbhander = new DB_Handler();

$dbhander->connect_to_db();

$dbhander->insert_mining_data($coins_data);

$dbhander->close_db_connection();
?>