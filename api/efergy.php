<?php

// load classes
error_reporting(E_ALL);

//Path to db handler Class
$db_class_path 	= '/home3/gxblocks/public_html/includes/classes/class-db-handler.php';


//Include the db handler
require_once( $db_class_path );

class efergy {

	// configurations
	private $print_error_if_api_down = true;

	// private methods
	function __construct($api_key) {

		$this->api_key = $api_key;

		// todo: check if given data is correct

		if (!function_exists('curl_exec')) {
			exit("Error: Please install PHP curl extension to use this Software.\r\n $ apt-get install php5-curl\r\n");
		}
	}

	function __destruct() {
		unset($this->api_key);
	}

	function get($type, $options) {


		$ch = curl_init();

		$options_args = '';
		foreach ($options as $k=>$v){
			$options_args .= '&'.$k.'='.$v;
		}
		$api_url = 'http://www.energyhive.com/mobile_proxy/'.$type.'?'.$options_args.'&token='.$this->api_key;

		var_dump($api_url);
		curl_setopt($ch, CURLOPT_URL, $api_url);
		// curl_setopt($ch, CURLOPT_URL, 'http://www.energyhive.com/mobile_proxy/getTimeSeries?&fromTime='.strtotime('-5 days').'&toTime='.strtotime('-1 days').'&aggPeriod=day&aggFunc=sum&offset=0&token=1RA2g4QiGn-0t89yqlLFOd8e0OaffTsD');
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

		return $result_json;

	}

	function config($config, $value) {
		if (isset($this->$config)) {
			$this->$config = $value;
		}
	}
}

$energyhive = new efergy('Mh7yq4UKAJoivW5Zxl_pLUxbvZfS-NgG');

$fromtime = strtotime('-28 days') + 28800;
$totime = strtotime('now') + 28800;
$options = array(
	'fromTime'	=>	$fromtime,
	'toTime'	=>	$totime,
	'period'	=>	'custom',
	'aggPeriod'	=>	'day',
	'aggFunc'	=>	'sum',
	'type'		=>	'PWER',
	'offset'	=>	0
);

$results[] = $energyhive->get('getHV',$options);

$encoded_result = json_encode($results[0]);

echo 'Results of call:</br>';

var_dump($results);
echo '</br>';

$dbhander = new DB_Handler();

$dbhander->connect_to_db();

$dbhander->insert_energy_data($encoded_result);

$dbhander->close_db_connection();
?>