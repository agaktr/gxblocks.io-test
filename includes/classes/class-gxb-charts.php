<?php 

//Path to db handler Class
$db_class_path 	= dirname(__FILE__).'/class-db-handler.php';
	
//Include the db handler
require_once( $db_class_path );	

class GXB_Charts {
	
	private $dates_array;
	private $mining_array;
	private $db_info;
	private $db_info_today;
	private $all_coins;
	private $db_energy_info;
	private $db_portfolio_info_raw;
	private $db_portfolio_info;
	private $rates;



	function __construct( ) {
		
		$this->dates_array = $this->mining_array = $this->db_info = $this->db_info_today = array();
		$this->all_coins = array(
			'BTC'	=> array('back_color'=>'rgb(57, 69, 229,0.5)','b_color'=>'rgb(57, 69, 229)'),
			'ZEC'	=> array('back_color'=>'rgb(132, 155, 239,0.5)','b_color'=>'rgb(132, 155, 239)'),
			'LTC'	=> array('back_color'=>'rgb(61, 98, 234,0.5)','b_color'=>'rgb(61, 98, 234)'),
			'DASH'	=> array('back_color'=>'rgb(78, 112, 236,0.5)','b_color'=>'rgb(78, 112, 236)'),
			'ETH'	=> array('back_color'=>'rgb(66, 78, 233,0.5)','b_color'=>'rgb(66, 78, 233)')
		);
		
		$cryptocompare_api_key = 'e71415aa44c1c456120d51345f86c6f3f3de2eae9651a20baff0bb177f5bb145';
		$result = file_get_contents('https://min-api.cryptocompare.com/data/pricemulti?fsyms=BTC,ETH,LTC,DASH,ZEC&tsyms=USD,EUR,BTC&api_key='.$cryptocompare_api_key);
		$this->rates = json_decode($result,true);
		
		$this->dbhander = new DB_Handler();
	}
	
	private function get_info_from_db(){
		
		$this->dbhander->connect_to_db();
		
		$this->db_info = $this->dbhander->get_info();

		$this->dbhander->close_db_connection();
	}
	
	private function get_last_info_from_db(){
		
		$this->dbhander->connect_to_db();
		
		$this->db_info = $this->dbhander->get_last_info();

		$this->dbhander->close_db_connection();
	}
	
	private function get_energy_info_from_db(){
		
		$this->dbhander->connect_to_db();
		
		$this->db_energy_info_raw = $this->dbhander->get_energy_info();

		$this->dbhander->close_db_connection();
	}
	
	private function get_portfolio_info_from_db(){
		
		$this->dbhander->connect_to_db();
		
		$this->db_portfolio_info_raw = $this->dbhander->get_portfolio_info();

		$this->dbhander->close_db_connection();
	}
	
	private function get_portfolio_last_info_from_db(){
		
		$this->dbhander->connect_to_db();
		
		$this->db_portfolio_info_raw = $this->dbhander->get_portfolio_last_info();

		$this->dbhander->close_db_connection();
	}
	
	public function init_charts_callback(){
// var_dump(4);
		$return_array = array();
		$referer = explode('/',$_SERVER["HTTP_REFERER"]);
		$referer = end($referer);

		switch ($referer){
			case 'energy.php':
			
				$return_array['gxb-average-energy-chart'] 					= self::gxb_average_energy_chart('Daily');
				$return_array['gxb-mining-electicity-coverage-chart'] 		= self::gxb_mining_electicity_coverage_chart('Daily');
				$return_array['gxb-production-consumption-chart'] 			= $this->gxb_production_consumption_chart('Daily');
				$return_array['gxb-total-production-of-green-energy-chart'] = $this->gxb_total_production_of_green_energy_chart();
				$return_array['to_change_gas'] 								= $this->gxb_update_gas();
			break;
			case 'mining.php':
			
				self::get_info_from_db();
				self::manipulate_info_from_db();
				
				$return_array['gxb-pool-power-chart'] 				= self::gxb_pool_power_chart('ALL');
				$return_array['gxb-hash-power-chart'] 				= self::gxb_hash_power_chart('BTC','Hourly');
				$return_array['gxb-coin-balance-chart'] 			= $this->gxb_coin_balance_chart('BTC');
				$return_array['to_change_forecast'] 				= $this->update_forecast('BTC');
				$return_array['gxb-pool-chart'] 					= $this->gxb_pool_chart();
				$return_array['gxb-power-costs-vs-wallet-chart'] 	= $this->gxb_power_costs_vs_wallet_chart('BTC');
				$return_array['to_change_wallet'] 					= $this->update_wallet_info();
			break;
			case 'portfolio.php':
			
				self::get_portfolio_last_info_from_db();
				self::manipulate_portfolio_info_from_db();
				
				$return_array['gxb-total-assets-chart'] 			= self::total_assets_chart();
				
				self::get_portfolio_info_from_db();
				self::manipulate_portfolio_info_from_db();
				$return_array['gxb-historical-data-chart'] 			= self::gxb_historical_data_chart();
				$return_array['gxb-historical-performance-chart'] 	= self::gxb_historical_performance_chart('USD');
			break;
		}
		
		return json_encode($return_array);
	}
	
	public function init_globals_callback(){
		$return_array = array();
		$referer = explode('/',$_SERVER["HTTP_REFERER"]);
		$referer = end($referer);

		switch ($referer){
			case 'energy.php':
			
				self::get_energy_info_from_db();
				self::manipulate_energy_info_from_db();
//				var_dump($this->db_energy_info);
				$keys = array_keys($this->db_energy_info[762232]);
				unset($keys[count($keys)-1]);
				$return_array['to_change_last_update'] = date('d/m/Y H:i:s',end($keys)).' (GMT+2)';
			break;
			case 'mining.php':
			
				self::get_last_info_from_db();
				self::manipulate_info_from_db();
				
				$return_array['to_change'] 				= self::gxb_update_workes_info();
				$return_array['to_change_last_update'] = date('d/m/Y H:i:s',array_keys($this->db_info)[0]).' (GMT+2)';
			break;
			case 'portfolio.php':
			
				self::get_portfolio_last_info_from_db();
				self::manipulate_portfolio_info_from_db();

				$return_array['to_change_portfolio'] 	= self::gxb_update_portfolio_assets();
				$return_array['to_change_last_update'] 	= date('d/m/Y H:i:s',array_keys($this->db_portfolio_info)[0]).' (GMT+2)';
			break;
		}
		
		return json_encode($return_array);
	}
	
	
	
	public function gxb_update_workes_info(){
		$return = array();
		
		$api_url = 'http://www.energyhive.com/mobile_proxy/getCurrentValuesSummary?&token=Mh7yq4UKAJoivW5Zxl_pLUxbvZfS-NgG';
		$res = json_decode(file_get_contents($api_url));
		
		
		if (isset($res->error)){
			$total_watt = 0;
		}else{
			$rdt=key($res[0]->data[0]);
			$total_watt = $res[0]->data[0]->$rdt;
		}
		
		

		$total_active_workers = 0;
		foreach($this->db_info as $time=>$coins){
			
			foreach($coins as $name=>$data){
				$hashrate = self::formatHash($data['hashrate']->last10m,2,true,false,$name);
				if ($hashrate == '0 H'){
					switch ($name){
						case 'BTC':
							$hashrate = '0 TH';
						break;
						case 'ZEC':
							$hashrate = '0 KH';
						break;
						case 'LTC':
							$hashrate = '0 MH';
						break;
						case 'DASH':
							$hashrate = '0 GH';
						break;
						case 'ETH':
							$hashrate = '0 MH';
						break;
						
					}
				}
				$total_active_workers += $data['hashrate']->activeWorkers;
				$return[$name]['hashrate'] = $hashrate.'/s';
				$return[$name]['workers'] = $data['hashrate']->activeWorkers.'/'.$data['hashrate']->totalWorkers;
				$return[$name]['poolpower'] = '###### W';
			}
		}
		
		// var_dump($total_active_workers);$total_watt
		
		foreach($return as $name=>$hash_data){
			// var_dump();

			$return[$name]['poolpower'] = number_format($total_watt*$coins[$name]['hashrate']->activeWorkers/$total_active_workers,2).' W';
		}
		
		return $return;
		
	}
	
	public function gxb_update_portfolio_assets(){
		
		
		
		$total_usd = 0;
		$total_btc = 0;
		foreach (current($this->db_portfolio_info) as $coin_name=>$coin_data){
			
			
			if ($coin_data == 'no-data'){
				
				//curent balance
				$return[$coin_name]['current_balance'] = 0;
				//btc equivalent
				$return[$coin_name]['btc_equivalent'] = 0;
				//usd equivalent
				$return[$coin_name]['usd_equivalent'] = 0;
			}else{
				
			
				//curent balance
				$return[$coin_name]['current_balance'] = floatval($coin_data["balance"]);
				//btc equivalent
				$return[$coin_name]['btc_equivalent'] = $return[$coin_name]['current_balance']*$this->rates[$coin_name]['BTC'];
				//usd equivalent
				$return[$coin_name]['usd_equivalent'] = floatval($coin_data["balance"])*$this->rates[$coin_name]['USD'];
				
				$total_usd += $return[$coin_name]['usd_equivalent'];
				$total_btc += $return[$coin_name]['btc_equivalent'];
			}
			
		}
		
		//% of portfolio
		foreach($return as $coin_name=>$return_data){
			
			$return[$coin_name]['portfolio_percentage'] = $return_data['usd_equivalent']*100/$total_usd;
		}
		
		//canonicalize
		foreach($return as $coin_name=>$return_data){
			$return[$coin_name]['portfolio_percentage'] = number_format($return[$coin_name]['portfolio_percentage'],2).' %';
			$return[$coin_name]['current_balance'] = number_format($return[$coin_name]['current_balance'],6);
			$return[$coin_name]['btc_equivalent'] = number_format($return[$coin_name]['btc_equivalent'],6);
			$return[$coin_name]['usd_equivalent'] = number_format($return[$coin_name]['usd_equivalent'],2).' $';
			
		}
		
		//totals
		$return['totals']['usd'] = number_format($total_usd,2).' $';
		$return['totals']['btc'] = number_format($total_btc,6);
		
		
		return $return;
		
	}
	
	
	
	private function manipulate_info_from_db(){
		// $counter=0;
		foreach($this->db_info as $time=>$coins){
			// var_dump(date('Y-m-d H:i:s',$time));
			foreach ($coins as $coin=>$info){
				
				$real_info = explode('+',$info);
				unset($this->db_info[$time][$coin]);

				$this->db_info[$time][$coin] = array(
					'hashrate'			=> json_decode($real_info[0]),
					'workers'			=> json_decode($real_info[1]),
					'paymentHistory'	=> json_decode($real_info[2])
				);
			
				if ($time > time() - 85000){
	
					$this->db_info_today[$time][$coin] = array(
						'hashrate'			=> json_decode($real_info[0]),
						'workers'			=> json_decode($real_info[1]),
						'paymentHistory'	=> json_decode($real_info[2])
					);
				}
				// ++$counter;
			}
		}	
		// var_dump($counter);
	}
	
	private function manipulate_energy_info_from_db(){
		
		foreach($this->db_energy_info_raw as $fetch_time=>$energy_response){

			$energy_response = json_decode($energy_response['energy_response']);
			
			// var_dump($energy_response->sid);
			
			foreach ($energy_response->data as $k=>$sensor){
				$sensor_id = ($sensor->sid);
				
				foreach($sensor->data as $key=>$reading){
					$time = key($reading);
					$this->db_energy_info[$sensor->sid][substr($time,0,-3)] = array(
						'Wm'	=> $reading->$time,
					);
				}

			}
		}
	}
	
	private function manipulate_portfolio_info_from_db(){
		
		foreach($this->db_portfolio_info_raw as $time=>$coins){
			
			foreach($coins as $name=>$data){
				
				$decoded_data = json_decode($data);
				if ($decoded_data == 'no-data'){
					$this->db_portfolio_info[$time][$name] = 'no-data';
				}else{
					$this->db_portfolio_info[$time][$name] = array(
						'earn24Hours'	=> $decoded_data->earn24Hours,
						'earnTotal'	=> $decoded_data->earnTotal,
						'paidOut'	=> $decoded_data->paidOut,
						'balance'	=> $decoded_data->balance,
					);
				}
			}
		}

	}
	
	
	
	
	
	private function generate_random_addition($amount,$percent){
		
		$add_del = mt_rand(0,1);
		$true_percent = $this->frand(0,$percent,2);
		$amount_to_push = $true_percent*$amount/100;
		// echo $amount_to_push.'</br>';
		if ($add_del == 0){
			return floatval('-'.$amount_to_push);
		}else{
			return $amount_to_push;
		}
	}
	
	private function frand($min, $max, $decimals = 0) {
		$scale = pow(10, $decimals);
		return mt_rand($min * $scale, $max * $scale) / $scale;
	}
	
	public function gxb_pool_power_chart_callback(){
		self::get_info_from_db();
		self::manipulate_info_from_db();
		$return_array['gxb-pool-power-chart'] = $this->gxb_pool_power_chart($_POST['coins']);
		return json_encode($return_array);
	}

	private function gxb_pool_power_chart($coin){
		
		
		$allcoins_tmp = array(
			'BTC'	=> array('back_color'=>'rgb(57, 69, 229,0.5)','b_color'=>'rgb(57, 69, 229)'),
			'ETH'	=> array('back_color'=>'rgb(66, 78, 233,0.5)','b_color'=>'rgb(66, 78, 233)'),
			'LTC'	=> array('back_color'=>'rgb(61, 98, 234,0.5)','b_color'=>'rgb(61, 98, 234)'),
			'DASH'	=> array('back_color'=>'rgb(78, 112, 236,0.5)','b_color'=>'rgb(78, 112, 236)'),
			'ZEC'	=> array('back_color'=>'rgb(132, 155, 239,0.5)','b_color'=>'rgb(132, 155, 239)'),
			
		);
		$allcoins = array();
		if ($coin !== 'ALL'){
			$coins_arr = explode('+',$coin);
			foreach($coins_arr as $coin_name){
				
				if (!empty($coin_name)){
					if ($coin_name == 'ZCH'){
					$coin_name = 'ZEC';
					}
					if ($coin_name == 'DSH'){
						$coin_name = 'DASH';
					}
					// var_dump($coin_name);
					$allcoins[$coin_name] = $allcoins_tmp[$coin_name];
				}
				
			}
		}else{
			$allcoins = $allcoins_tmp;
		}

		$this->dates_array = array();
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d',strtotime("-1 month"))),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		
		
		
		foreach ($period as $key => $value) {

			
			$this->dates_array[$value->format('d M')] = ''; 
		}
		
		

		foreach ($this->db_info as $time=>$coins){
			$day_time = date('d M',$time);
			foreach ($allcoins as $coin_name=>$colors){
				
				if (!empty($coins[$coin_name]["hashrate"]) && !isset($this->dates_array[$day_time][$coin_name]['workercons'])){
					$this->dates_array[$day_time][$coin_name]['workercons'] += $coins[$coin_name]["hashrate"]->activeWorkers;
					++$this->dates_array[$day_time][$coin_name]['count'];
				}
			}
		}
		
		// foreach ($this->dates_array as $time=>$info){
			// if (!empty($info)){
				
			
				// foreach($info as $coin=>$data){
					// if ($this->dates_array[$time][$coin]['count'] > 1){
						
						// $this->dates_array[$time][$coin]['workercons'] = $this->dates_array[$time][$coin]['workercons']/$this->dates_array[$time][$coin]['count'];
					// }else{
						// $this->dates_array[$time][$coin]['workercons'] = $this->dates_array[$time][$coin]['workercons'];
					// }
				// }
			// }
			
		// }

		foreach($this->dates_array as $day=>$info){
			
			foreach ($allcoins as $c_name=>$colors){
				if (empty($info[$c_name])){
					$this->dates_array[$day][$c_name]["workercons"] = 0;
				}
			}
		}
		
		$total_array = array();
		foreach($this->dates_array as $day=>$info){
			$total_array[$day] = 0;
			foreach($info as $cname=>$cons){

				$total_array[$day] += $cons["workercons"];
			}
		}
		// var_dump($total_array);
		foreach($this->dates_array as $day=>$info){
			foreach($info as $cname=>$cons){
				if ($total_array[$day] > 0){
					// var_dump($this->dates_array[$time][$cname]["workercons"]);
					$this->dates_array[$day][$cname]['workercons'] = $this->dates_array[$day][$cname]['workercons']*100/$total_array[$day];
				}
				
			}
		}
		// var_dump($total_array);
		// var_dump($this->dates_array);
		
		$datasets = array();
		foreach ($allcoins as $c_name=>$colors){
			$data_arr = array();
			foreach($this->dates_array as $day=>$info){
				$data_arr[] = number_format($info[$c_name]["workercons"],2);
			}
			$datasets[] = array(
				'label'=> "Percentage Consumption of ".$c_name,
				'yAxisID'=> 'y-axis-left','backgroundColor'=> $colors['back_color'],
				'borderColor'=> $colors['b_color'],
				'data'=>$data_arr,
				'type'=> 'line',
			);
		}
		// var_dump($datasets);
		// die();
		
		$labels = array_keys($this->dates_array);
		$return_array = array(
			'labels' => $labels,
			'datasets' => $datasets,
			'chart_type'	=> 'bar',
			'metric'	=> ' %',
			'stacked_x'	=> true,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> false,
			'max_value'	=> 100,
			'tooltip_mode'=>'nearest',
			'aspectratio'	=> 4,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	// public function gxb_pool_chart_callback(){
		// self::get_info_from_db();
		// self::manipulate_info_from_db();
		// $return_array['gxb-pool-chart'] = $this->gxb_pool_chart();
		// return json_encode($return_array);
	// }

	private function total_assets_chart(){
		
		unset($this->dates_array);
		// var_dump($coin);
		$allcoins = array(
			'BTC'	=> array('back_color'=>'rgb(57, 69, 229,1)','b_color'=>'rgb(57, 69, 229)'),
			'ETH'	=> array('back_color'=>'rgb(66, 78, 233,1)','b_color'=>'rgb(66, 78, 233)'),
			'LTC'	=> array('back_color'=>'rgb(61, 98, 234,1)','b_color'=>'rgb(61, 98, 234)'),
			'DASH'	=> array('back_color'=>'rgb(78, 112, 236,1)','b_color'=>'rgb(78, 112, 236)'),
			'ZEC'	=> array('back_color'=>'rgb(132, 155, 239,1)','b_color'=>'rgb(132, 155, 239)'),
			
		);
		
		
		
		$total_usd = 0;
		foreach (current($this->db_portfolio_info) as $coin_name=>$coin_data){
			
			
			if ($coin_data == 'no-data'){
				
				//curent balance
				$this->dates_array[$coin_name]['current_balance'] = 0;
				//usd equivalent
				$this->dates_array[$coin_name]['usd_equivalent'] = 0;
			}else{
				
				//curent balance
				$this->dates_array[$coin_name]['current_balance'] = floatval($coin_data["balance"]);
				//usd equivalent
				$this->dates_array[$coin_name]['usd_equivalent'] = floatval($coin_data["balance"])*$this->rates[$coin_name]['USD'];
				
				$total_usd += $this->dates_array[$coin_name]['usd_equivalent'];
			}
			
		}
		
		//% of portfolio canonicalized
		foreach($this->dates_array as $coin_name=>$return_data){
			
			$this->dates_array[$coin_name]['portfolio_percentage'] = number_format($return_data['usd_equivalent']*100/$total_usd,2);
		}
		
		$datasets = array();
		$dataset_array = array();
		foreach ($allcoins as $c_name=>$colors){
			$data_arr = array();
			// foreach($this->dates_array as $day=>$info){
				// $data_arr[] = number_format($info[$c_name]["workercons"],2);
				$dataset_array['coins'][] = number_format($this->dates_array[$c_name]["portfolio_percentage"],2);
				$dataset_array['back_color'][] = $colors['back_color'];
				$dataset_array['borderColor'][] = $colors['b_color'];
			// }
			
		}
		$datasets[] = array(
			'label'=> "% of Portfolio",
			'yAxisID'=> 'y-axis-left','backgroundColor'=> $dataset_array['back_color'],
			'borderColor'=> $dataset_array['borderColor'],
			'data'=>$dataset_array['coins'],
		);
		
		$labels = array_keys($allcoins);
		$return_array = array(
			'labels' => $labels,
			'datasets' => $datasets,
			'chart_type'	=> 'pie',
			'cutoutPercentage'	=> '70',
			'display_legend'	=> false,
			'display_x'	=> false,
			'display_y'	=> false,
			// 'metric'	=> ' %',
			// 'stacked_x'	=> true,
			// 'stacked_y'	=> false,
			// 'zero'	=> false,
			// 'max_value'	=> 100,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 1.2,
			// 'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			// 'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}

	private function gxb_pool_chart(){
		
		unset($this->dates_array);
		// var_dump($coin);
		$allcoins = array(
			'BTC'	=> array('back_color'=>'rgb(57, 69, 229,1)','b_color'=>'rgb(57, 69, 229)'),
			'ETH'	=> array('back_color'=>'rgb(66, 78, 233,1)','b_color'=>'rgb(66, 78, 233)'),
			'LTC'	=> array('back_color'=>'rgb(61, 98, 234,1)','b_color'=>'rgb(61, 98, 234)'),
			'DASH'	=> array('back_color'=>'rgb(78, 112, 236,1)','b_color'=>'rgb(78, 112, 236)'),
			'ZEC'	=> array('back_color'=>'rgb(132, 155, 239,1)','b_color'=>'rgb(132, 155, 239)'),
			
		);

		$currdate = date('d M');
		$this->dates_array[$currdate] = array(); 

		foreach ($this->db_info as $time=>$coins){
			$day_time = date('d M',$time);
			if (array_key_exists($day_time,$this->dates_array)){
				
			
				foreach ($allcoins as $coin_name=>$colors){
					
					if (!empty($coins[$coin_name]["hashrate"]) && !isset($this->dates_array[$day_time][$coin_name]['workercons'])){
						$this->dates_array[$day_time][$coin_name]['workercons'] += $coins[$coin_name]["hashrate"]->activeWorkers;
						++$this->dates_array[$day_time][$coin_name]['count'];
					}
				}
			}
		}
		// var_dump($this->dates_array);
		// foreach ($this->dates_array as $time=>$info){
			// if (!empty($info)){
				
			
				// foreach($info as $coin=>$data){
					// if ($this->dates_array[$time][$coin]['count'] > 1){
						
						// $this->dates_array[$time][$coin]['workercons'] = $this->dates_array[$time][$coin]['workercons']/$this->dates_array[$time][$coin]['count'];
					// }else{
						// $this->dates_array[$time][$coin]['workercons'] = $this->dates_array[$time][$coin]['workercons'];
					// }
				// }
			// }
			
		// }

		foreach($this->dates_array as $day=>$info){
			
			foreach ($allcoins as $c_name=>$colors){
				if (empty($info[$c_name])){
					$this->dates_array[$day][$c_name]["workercons"] = 0;
				}
			}
		}
		
		
		
		$total_array = array();
		foreach($this->dates_array as $day=>$info){
			$total_array[$day] = 0;
			foreach($info as $cname=>$cons){

				$total_array[$day] += $cons["workercons"];
			}
		}
		// var_dump($total_array);
		foreach($this->dates_array as $day=>$info){
			foreach($info as $cname=>$cons){
				if ($total_array[$day] > 0){
					// var_dump($this->dates_array[$time][$cname]["workercons"]);
					$this->dates_array[$day][$cname]['workercons'] = $this->dates_array[$day][$cname]['workercons']*100/$total_array[$day];
				}
				
			}
		}
		// var_dump($total_array);
		// var_dump($this->dates_array);
		
		$datasets = array();
		$dataset_array = array();
		foreach ($allcoins as $c_name=>$colors){
			$data_arr = array();
			// foreach($this->dates_array as $day=>$info){
				// $data_arr[] = number_format($info[$c_name]["workercons"],2);
				$dataset_array['coins'][] = number_format($this->dates_array[$currdate][$c_name]["workercons"],2);
				$dataset_array['back_color'][] = $colors['back_color'];
				$dataset_array['borderColor'][] = $colors['b_color'];
			// }
			
		}
		$datasets[] = array(
			'label'=> "Power Usage",
			'yAxisID'=> 'y-axis-left','backgroundColor'=> $dataset_array['back_color'],
			'borderColor'=> $dataset_array['borderColor'],
			'data'=>$dataset_array['coins'],
			// 'type'=> 'line',
		);
		// var_dump($datasets);
		// die();
		
		$labels = array_keys($allcoins);
		$return_array = array(
			'labels' => $labels,
			'datasets' => $datasets,
			'chart_type'	=> 'pie',
			'cutoutPercentage'	=> '70',
			'display_x'	=> false,
			'display_y'	=> false,
			// 'metric'	=> ' %',
			// 'stacked_x'	=> true,
			// 'stacked_y'	=> false,
			// 'zero'	=> false,
			// 'max_value'	=> 100,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 1.65,
			// 'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			// 'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	// public function gxb_coin_balance_chart_callback(){
		// self::get_info_from_db();
		// self::manipulate_info_from_db();
		// $return_array['gxb-coin-balance-chart'] = $this->gxb_coin_balance_chart($_POST['coin']);
		// return json_encode($return_array);
	// }

	private function gxb_historical_data_chart(){

        $totals = array();
		foreach ($this->db_portfolio_info as $time=>$coins){
			
			
			foreach($coins as $coin_name=>$coin_data){
		
				if ($coin_data == 'no-data'){
					
					//curent balance
					$tmp[$time][$coin_name]['current_balance'] = 0;
					//btc equivalent
					$tmp[$time][$coin_name]['btc_equivalent'] = 0;
					//usd equivalent
					$tmp[$time][$coin_name]['usd_equivalent'] = 0;
				}else{
				
					
					if ($coin_data["balance"] < 0.0000001){
						$coin_data["balance"] = 0;
					}
					//curent balance
					$tmp[$time][$coin_name]['current_balance'] = floatval($coin_data["balance"]);
					//btc equivalent
					$tmp[$time][$coin_name]['btc_equivalent'] = $tmp[$time][$coin_name]['current_balance']*$this->rates[$coin_name]['BTC'];
					//usd equivalent
					$tmp[$time][$coin_name]['usd_equivalent'] = floatval($coin_data["balance"])*$this->rates[$coin_name]['USD'];
					
					//totals
					$totals[$time]['usd_equivalent'] += $tmp[$time][$coin_name]['usd_equivalent'];
					$totals[$time]['btc_equivalent'] += $tmp[$time][$coin_name]['btc_equivalent'];
				}
			}
			
		}
		
		
		
		unset($this->dates_array);
			
		$this->dates_array = array();
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d',strtotime("-1 month"))),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		
		foreach ($period as $key => $value) {

			$this->usd_array[$value->format('d M')] = 0; 
			$this->btc_array[$value->format('d M')] = 0; 
			
			foreach ($totals as $time=>$values){
				
				

				if ($value->format('M d') == date('M d',$time) && $this->usd_array[$value->format('d M')] == 0){
					
					$this->usd_array[$value->format('d M')] = number_format($values['usd_equivalent'],2,'.','');
					$this->btc_array[$value->format('d M')] = number_format($values['btc_equivalent'],6,'.','');
				}

			}

			
		}
		
		$return_array = array(
			'labels' => array_keys($this->btc_array),
			'datasets' => 
			array(

				array(
					'label'=> "BTC Equivalent",
					'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(68, 67, 234,0)',
					'borderColor'=> 'rgb(68, 67, 234)',
					'data'=>array_values($this->btc_array),
				),
				array(
					'label'=> "USD Equivalent",
					'yAxisID'=> 'y-axis-right','backgroundColor'=> 'rgb(48, 152, 236,0)',
					'borderColor'=> 'rgb(48, 152, 236)',
					'data'=>array_values($this->usd_array),
				),
			),
			'chart_type'	=> 'line',
			'metric'	=> ' BTC',
			'stacked_x'	=> false,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'hasright'	=> true,
			'display_y_right'	=> false,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 3,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
			
		);
		
		return $return_array;
	}
	
	public function gxb_historical_performance_chart_callback(){
		self::get_portfolio_info_from_db();
		self::manipulate_portfolio_info_from_db();
		// var_dump($_POST['timeframe']);
		$return_array['gxb-historical-performance-chart'] = $this->gxb_historical_performance_chart($_POST['timeframe']);
		return json_encode($return_array);
	}
	private function gxb_historical_performance_chart($type){

		foreach ($this->db_portfolio_info as $time=>$coins){
			
			
			foreach($coins as $coin_name=>$coin_data){

				if ($coin_data == 'no-data'){
					
					//curent balance
					$tmp[$time][$coin_name]['current_balance'] = 0;
					//curent paid out
					$tmp[$time][$coin_name]['paid_out'] = 0;
					//btc equivalent
					$tmp[$time][$coin_name]['btc_equivalent'] = 0;
					//usd equivalent
					$tmp[$time][$coin_name]['usd_equivalent'] = 0;
				}else{
					
					
					if ($coin_data["balance"] < 0.0000001){
						$coin_data["balance"] = 0;
					}
					//curent balance
					$tmp[$time][$coin_name]['current_balance'] = floatval($coin_data["balance"]);
					//btc equivalent
					$tmp[$time][$coin_name]['btc_equivalent'] = $tmp[$time][$coin_name]['current_balance']*$this->rates[$coin_name]['BTC'];
					//usd equivalent
					$tmp[$time][$coin_name]['usd_equivalent'] = floatval($coin_data["balance"])*$this->rates[$coin_name]['USD'];
					
					//curent paid out
					$tmp[$time][$coin_name]['paid_out'] = floatval($coin_data["paidOut"]);
					//btc paid out equivalent
					$tmp[$time][$coin_name]['btc_paid_out_equivalent'] = $tmp[$time][$coin_name]['paid_out']*$this->rates[$coin_name]['BTC'];
					//usd paid out equivalent
					$tmp[$time][$coin_name]['usd_paid_out_equivalent'] = floatval($coin_data["paidOut"])*$this->rates[$coin_name]['USD'];
					
					
					//totals
					if ($type == 'USD' && !isset($totals[$time]['paid_out'])){
						// var_dump($tmp[$time][$coin_name]);
						$totals[$time]['paid_out'] = $tmp[$time][$coin_name]['usd_paid_out_equivalent'];
						$totals[$time]['balance'] = $tmp[$time][$coin_name]['usd_equivalent'];
						
					}else if ($type == 'BTC' && !isset($totals[$time]['paid_out'])){
						
						$totals[$time]['balance'] = $tmp[$time][$coin_name]['btc_equivalent'];
						$totals[$time]['paid_out'] = $tmp[$time][$coin_name]['btc_paid_out_equivalent'];
						
					}
					
				}
			}
			
		}

		unset($this->dates_array);
			
		$this->dates_array = array();
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d',strtotime("-1 month"))),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		
		foreach ($period as $key => $value) {

			$this->balance_array[$value->format('d M')] = 0; 
			$this->paid_out_array[$value->format('d M')] = 0; 
		
			foreach ($totals as $time=>$values){
				
				

				if ($value->format('M d') == date('M d',$time) && $this->balance_array[$value->format('d M')] == 0 ){
					
					$this->balance_array[$value->format('d M')] = number_format($values['paid_out']+$values['balance'],2,'.','');
					$this->paid_out_array[$value->format('d M')] = number_format($values['paid_out'],2,'.','');
				}

			}

			
		}
		
		// var_dump($totals);
		// var_dump($this->balance_array);
		// var_dump($this->paid_out_array);
		
		$return_array = array(
			'labels' => array_keys($this->balance_array),
			'datasets' => 
			array(

				array(
					'label'=> "Payouts",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(68, 67, 234,0.5)',
					'borderColor'=> 'rgb(68, 67, 234)',
					'data'=>array_values($this->paid_out_array),
				),
				array(
					'label'=> "Total assets plus payouts",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(48, 152, 236,0.5)',
					'borderColor'=> 'rgb(48, 152, 236)',
					'data'=>array_values($this->balance_array),
				),
			),
			'chart_type'	=> 'line',
			'metric'	=> ' '.$type,
			'stacked_x'	=> false,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'hasright'	=> false,
			'tooltip_mode'=>'nearest',
			'aspectratio'	=> 3,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
			
		);
		
		return $return_array;
	}

	private function gxb_power_costs_vs_wallet_chart($coin){
		
		self::get_energy_info_from_db();
		
		self::manipulate_energy_info_from_db();
		
		unset($this->dates_array);
			
		$this->dates_array = array();
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d',strtotime("-1 month"))),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		
		foreach ($period as $key => $value) {

			$this->dates_array[$value->format('d M')] = ''; 
			
			foreach ($this->db_energy_info as $sensor=>$readings){
				if ($sensor == 762232){
					
				}else{
					foreach($readings as $time=>$sensor_reading){
						
						if ($value->format('M d') == date('M d',$time)){
							$this->energy_dates_array[$value->format('d M')] = self::formatWm($sensor_reading['Wm'])*0.094; 
						}
					}
				}
			}
		}
		
		// var_dump($this->energy_dates_array);
		
		$echange_rates_api_key = 'e71415aa44c1c456120d51345f86c6f3f3de2eae9651a20baff0bb177f5bb145';
		$result = file_get_contents('https://min-api.cryptocompare.com/data/histohour?fsym='.$coin.'&tsym=USD&limit=1440&aggregate=1&api_key='.$echange_rates_api_key);
		$res = json_decode($result,true);
		$rates_array = array();
		foreach ($res['Data'] as $key=>$d_info){

			$rates_array[date('d M H:i',$d_info['time'])] = $d_info['close'];
			
		}
		
		foreach ($this->db_info as $time=>$coins){
			
			if (isset($coins[$coin]['paymentHistory']->rows)){
				foreach($coins[$coin]['paymentHistory']->rows as $k=>$payment){
					$day_time = date('d M',strtotime($payment->timestamp));
					
					if (!empty($payment) && array_key_exists($day_time,$this->dates_array) && !isset($this->dates_array[$day_time][$coin]['amount']) ){

						$rate = $rates_array[date('d M H:i',self::roundToNearestMinuteInterval(new DateTime($payment->timestamp),60)->getTimestamp())];
						$this->dates_array[$day_time][$coin]['amount'] += number_format(abs($payment->amount)*$rate,2);
						++$this->dates_array[$day_time][$coin]['count'];
					}
				}
			}
		}
		
	
		
		// foreach ($this->dates_array as $time=>$info){
			// if (!empty($info)){
				
			
				// foreach($info as $coin_name=>$data){
					// if ($this->dates_array[$time][$coin_name]['count'] > 1){
						
						// $this->dates_array[$time][$coin_name]['amount'] = self::formatHash($this->dates_array[$time][$coin_name]['amount']/$this->dates_array[$time][$coin_name]['count'],4,false,false,$coin_name);
					// }else{
						// $this->dates_array[$time][$coin_name]['amount'] = self::formatHash($this->dates_array[$time][$coin_name]['amount'],4,false,false,$coin_name);
					// }
				// }
			// }
			
		// }

		
		$this->total_in_usd = 0;
		$total_mining = 0;
		foreach($this->energy_dates_array as $day=>$info){
			

				if (empty($info) || $info == 0){
					$this->energy_dates_array[$day] = $total_mining;
				}else{
					$total_mining += $this->energy_dates_array[$day];
					$this->energy_dates_array[$day] = $total_mining;
				}
		}
		
		foreach($this->dates_array as $day=>$info){
			

				if (empty($info[$coin])){
					$this->dates_array[$day][$coin]["amount"] = $this->total_in_usd;
				}else{
					$this->total_in_usd += $this->dates_array[$day][$coin]["amount"];
					$this->dates_array[$day][$coin]["amount"] = $this->total_in_usd;
				}
		}
		
		
		$datasets = array();

		$data_arr = array();
		foreach($this->dates_array as $day=>$info){
			$data_arr[] = number_format($info[$coin]["amount"],2,'.','');
		}
		$data_arr_mine = array();
		foreach($this->energy_dates_array as $day=>$info){
			$data_arr_mine[] = number_format($info,2,'.','');
		}
		$datasets[] = array(
			'label'=> "Revenue of ".$coin." in $",
			'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(0,0,0,0)',
			'borderColor'=> 'rgb(48, 152, 236)',
			'data'=>$data_arr,
			'type'=> 'line',
		);
		$datasets[] = array(
			'label'=> "Cost of mining ".$coin." in $",
			'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(0,0,0,0)',
			'borderColor'=> 'rgb(233, 30, 99)',
			'data'=>$data_arr_mine,
			'type'=> 'line',
		);

// var_dump($data_arr);
// var_dump($data_arr_mine);
// var_dump($this->dates_array);
// var_dump($this->energy_dates_array);
		

		$labels = array_keys($this->dates_array);
		$return_array = array(
			'labels' => $labels,
			'datasets' => $datasets,
			'chart_type'	=> 'line',
			'metric'	=> ' $',
			'stacked_x'	=> true,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> false,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 4,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	public function update_wallet_info(){
		
		$return['usd'] = $this->total_in_usd.' USD';
		$return['mBTC'] = number_format($this->total_in_usd/$this->rates['BTC']["USD"]*1000,2).' mBTC';
		
		return $return;
	}

/**
 * @param \DateTime $dateTime
 * @param int $minuteInterval
 * @return \DateTime
 */
public function roundToNearestMinuteInterval(\DateTime $dateTime, $minuteInterval = 10)
{
    return $dateTime->setTime(
        $dateTime->format('H'),
        round($dateTime->format('i') / $minuteInterval) * $minuteInterval,
        0
    );
}
	
	private function gxb_coin_balance_chart($coin){
		
			
		$this->dates_array = array();
		$period = new DatePeriod(
			 new DateTime(date('Y-m-d',strtotime("-1 month"))),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		
		foreach ($period as $key => $value) {

			$this->dates_array[$value->format('d M')] = ''; 
		}
		
		
		foreach ($this->db_info as $time=>$coins){
			
			if (isset($coins[$coin]['paymentHistory']->rows)){
				foreach($coins[$coin]['paymentHistory']->rows as $k=>$payment){
					$day_time = date('d M',strtotime($payment->timestamp));

					if (!empty($payment) && array_key_exists($day_time,$this->dates_array) && !isset($this->dates_array[$day_time][$coin]['amount'])){
						$this->dates_array[$day_time][$coin]['amount'] += number_format(abs($payment->amount),8);
						++$this->dates_array[$day_time][$coin]['count'];
					}
				}
			}
		}
		
	
		
		// foreach ($this->dates_array as $time=>$info){
			// if (!empty($info)){
				
			
				// foreach($info as $coin_name=>$data){
					// if ($this->dates_array[$time][$coin_name]['count'] > 1){
						
						// $this->dates_array[$time][$coin_name]['amount'] = self::formatHash($this->dates_array[$time][$coin_name]['amount']/$this->dates_array[$time][$coin_name]['count'],4,false,false,$coin_name);
					// }else{
						// $this->dates_array[$time][$coin_name]['amount'] = self::formatHash($this->dates_array[$time][$coin_name]['amount'],4,false,false,$coin_name);
					// }
				// }
			// }
			
		// }
// var_dump($this->dates_array);
		

		foreach($this->dates_array as $day=>$info){
			
			// foreach ($allcoins as $c_name=>$colors){
				if (empty($info[$coin])){
					$this->dates_array[$day][$coin]["amount"] = 0;
				}
			// }
		}
		
		$datasets = array();
		// foreach ($this->all_coins as $c_name=>$colors){
			$data_arr = array();
			foreach($this->dates_array as $day=>$info){
				$data_arr[] = $info[$coin]["amount"];
			}
			$datasets[] = array(
				'label'=> "Revenue in ".$coin,
				'yAxisID'=> 'y-axis-left','backgroundColor'=> $this->all_coins[$coin]['back_color'],
				'borderColor'=> $this->all_coins[$coin]['b_color'],
				'data'=>$data_arr,
				'type'=> 'bar',
			);
		// }
		// var_dump($datasets);
		// die();
			// var_dump($datasets);
		$labels = array_keys($this->dates_array);
		$return_array = array(
			'labels' => $labels,
			'datasets' => $datasets,
			'chart_type'	=> 'bar',
			'metric'	=> ' '.$coin,
			'stacked_x'	=> true,
			'stacked_y'	=> true,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> false,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 4,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	public function gxb_update_mining_coin_callback(){
		self::get_info_from_db();
		self::manipulate_info_from_db();
		$return_array['gxb-hash-power-chart'] = $this->gxb_hash_power_chart($_POST['coin'],'Hourly');
		$return_array['gxb-coin-balance-chart'] = $this->gxb_coin_balance_chart($_POST['coin']);
		$return_array['to_change'] = $this->update_forecast($_POST['coin']);
		$return_array['gxb-pool-chart'] = $this->gxb_pool_chart();
		$return_array['gxb-power-costs-vs-wallet-chart'] 	= $this->gxb_power_costs_vs_wallet_chart($_POST['coin']);
		$return_array['to_change_wallet'] 	= $this->update_wallet_info();
		return json_encode($return_array);
	}
	public function gxb_hash_power_chart_callback(){
		self::get_info_from_db();
		self::manipulate_info_from_db();
		$return_array['gxb-hash-power-chart'] = $this->gxb_hash_power_chart($_POST['coin'],$_POST['timeframe']);
		return json_encode($return_array);
	}

	private function update_forecast($coin){
		
		$dates_to_work = $this->dates_array;
		//get_last_payment
		$last = 0;
		$counter = 0;
		$dates_to_work = array_reverse($dates_to_work,true);
		foreach($dates_to_work as $time=>$info){
			if ( $counter < 7){
				// var_dump($time);
				// var_dump($info);
				$last += $info[$coin]['amount'];
			}
			++$counter;
		}
		
		$last = $last/7;
		
		$return = '
		<tbody>
		  <tr>
			<td>'. number_format($last,5) .'<span class="gxb-currency-symbol gxb-left gxb-current-crypto-acronym"> '.$coin.'</span> = '. number_format($this->rates[$coin]['USD']*$last,2) .' <span class="gxb-currency-symbol gxb-right">USD</span></td>
			<td><div id="oned-label" class="gxb-revenue-time-label">1d</div></td>
		  </tr>
		  <tr>
			<td>'. number_format($last*7,5) .'<span class="gxb-currency-symbol gxb-left gxb-current-crypto-acronym"> '.$coin.'</span> = '. number_format($this->rates[$coin]['USD']*$last*7 ,2).' <span class="gxb-currency-symbol gxb-right">USD</span></td>
			<td><div id="onew-label" class="gxb-revenue-time-label">1w</div></td>
		  </tr>
		  <tr>
			<td>'. number_format($last*30,5) .'<span class="gxb-currency-symbol gxb-left gxb-current-crypto-acronym"> '.$coin.'</span> = '. number_format($this->rates[$coin]['USD']*$last*30 ,2).' <span class="gxb-currency-symbol gxb-right">USD</span></td>
			<td><div id="onem-label" class="gxb-revenue-time-label">1m</div></td>
		  </tr> 
		  <tr>
			<td>'. number_format($last*180,5) .'<span class="gxb-currency-symbol gxb-left gxb-current-crypto-acronym"> '.$coin.'</span> = '. number_format($this->rates[$coin]['USD']*$last*180 ,2).' <span class="gxb-currency-symbol gxb-right">USD</span></td>
			<td><div id="sixm-label" class="gxb-revenue-time-label">6m</div></td>
		  </tr>
		  <tr>
			<td>'. number_format($last*365,5) .'<span class="gxb-currency-symbol gxb-left gxb-current-crypto-acronym"> '.$coin.'</span> = '. number_format($this->rates[$coin]['USD']*$last*365 ,2).' <span class="gxb-currency-symbol gxb-right">USD</span></td>
			<td><div id="oney-label" class="gxb-revenue-time-label">1y</div></td>
		  </tr>
		</tbody>
		';
		// var_dump($return);
		/*
		
		*/
		return $return;
	}
	private function gxb_hash_power_chart($coin,$timeframe){
		
		
		
		$this->dates_array = array();
		
		if ($timeframe == 'Hourly'){
			$the_start = intval(date('H',strtotime('+8 hours')));

			for ($i = $the_start;$i>=0;--$i){

				$this->dates_array[str_pad($i, 2, '0', STR_PAD_LEFT)] = array(
					"hashrate" =>0,
					"count" =>0,
				);
			}
			for ($i = 23;$i>$the_start;--$i){
				$this->dates_array[str_pad($i, 2, '0', STR_PAD_LEFT)] = array(
					"hashrate" =>0,
					"count" =>0,
				);
			}

		}else if ($timeframe == 'Daily'){
			
			$period = new DatePeriod(
				 new DateTime(date('Y-m-d',strtotime("-1 month"))),
				 new DateInterval('P1D'),
				 new DateTime()
			);
			
			foreach ($period as $key => $value) {

				
				$this->dates_array_tmp[$value->format('Y-m-d')] = array(
					"hashrate" =>0,
					"count" =>0,
				);
			}
				
			
		}
		 $this->dates_array = array_reverse($this->dates_array,true);
		if ($timeframe == 'Hourly'){
			foreach ($this->db_info_today as $time=>$coins){

                $hour_time = date('H',$time + strtotime('+8 hours'));
				$this->dates_array[$hour_time]['hashrate'] += $coins[$coin]["hashrate"]->last10m;
				$checkhash = $coins[$coin]["hashrate"]->last10m;
				++$this->dates_array[$hour_time]['count'];
			}
		}else if ($timeframe == 'Daily'){
			
			foreach ($this->db_info as $time=>$coins){
				$day_time = date('Y-m-d',$time);
				$this->dates_array_tmp[$day_time]['hashrate'] += $coins[$coin]["hashrate"]->last10m;
				$checkhash = $coins[$coin]["hashrate"]->last10m;
				++$this->dates_array_tmp[$day_time]['count'];
			}
		}
		
//		 var_dump($this->db_info_today);
		// var_dump(count($this->db_info_today));
		if ($timeframe == 'Hourly'){
			
			foreach ($this->dates_array as $time=>$info){

				if ($this->dates_array[$time]['count'] > 1){
					if ($coin == 'ZEC'){
						$this->dates_array[$time]['hashrate'] = $this->dates_array[$time]['hashrate']*1000;
					}
					$this->dates_array[$time]['hashrate'] = self::formatHash($this->dates_array[$time]['hashrate']/$this->dates_array[$time]['count'],2,false,false,$coin);
					
				}else{
					if ($coin == 'ZEC'){
						$this->dates_array[$time]['hashrate'] = $this->dates_array[$time]['hashrate']*1000;
					}
					$this->dates_array[$time]['hashrate'] = self::formatHash($this->dates_array[$time]['hashrate'],2,false,false,$coin);
				}
			}
		}else if ($timeframe == 'Daily'){
			
			foreach ($this->dates_array_tmp as $day_time=>$info){
				$time = date('M d',strtotime($day_time));
				$this->dates_array[$time] = $info;
				
				if ($this->dates_array[$time]['count'] > 1){
					if ($coin == 'ZEC'){
						$this->dates_array[$time]['hashrate'] = $this->dates_array[$time]['hashrate']*1000;
					}
					$this->dates_array[$time]['hashrate'] = self::formatHash($this->dates_array[$time]['hashrate']/$this->dates_array[$time]['count'],2,false,false,$coin);
					
				}else{
					if ($coin == 'ZEC'){
						$this->dates_array[$time]['hashrate'] = $this->dates_array[$time]['hashrate']*1000;
					}
					$this->dates_array[$time]['hashrate'] = self::formatHash($this->dates_array[$time]['hashrate'],2,false,false,$coin);
				}
			}
		}
//		 var_dump($this->dates_array);
		// die();
		
		$labels = array_keys($this->dates_array);
		$labels_show = array();
		if ($timeframe == 'Hourly'){
			foreach ($labels as $label){
				$k = str_pad($label, 2, '0', STR_PAD_LEFT);
				$labels_show[] = $k.':00';
			}
		}else if ($timeframe == 'Daily'){
			
			$labels_show =$labels;
		}
		$return_array = array(
			'labels' => $labels_show,
			'datasets' => 
			array(
				array(
				'label'=> "Hash Power of ".$coin,
				
				'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(48, 148, 246,0.5)',
				'borderColor'=> 'rgb(48, 148, 246)',
				'data'=>array_values(array_column($this->dates_array,'hashrate')),
				'type'=> 'line',
				)
			),
			'chart_type'	=> 'bar',
			'metric'	=> ' '.self::formatHash($checkhash,2,false,true,$coin),
			'stacked_x'	=> false,
			'stacked_y'	=> false,

			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 4,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	private function formatHash($hash, $precision = 2,$output = false,$only_metric = false,$coin = 'BTC') { 
		if ($output == true || $only_metric == true){
			$hash = $hash * 1000000;
		}
		
		$units = array('H', 'KH', 'MH', 'GH', 'TH'); 
		$divide = array(1, 1000, 1000000, 1000000000, 1000000000000); 
		// $precision = 10;
		if ($coin == 'BTC'){
			$helper = 0;
		}else if ($coin == 'LTC'){
			$helper = 0;
		}else {
			$helper = 0;
		}
		if ($hash > 1){
			// $hash = intval($hash); 
		}else{
			if($only_metric == true){
				return 'H'; 
			}
			if($output == true){
				return round($hash, $precision).' H'; 
			}
			return round($hash, $precision); 
		}
		$hash = max($hash, 0); 
		$pow = floor(($hash ? log($hash) : 0) / log(1000)); 
		$pow = min($pow, count($units) - 1); 
		if($only_metric == true){
			return $units[$pow+$helper]; 
		}
		if($output == true){
			return round($hash/$divide[$pow+$helper], $precision).' '.$units[$pow+$helper]; 
		}
		// return round($hash/$divide[$pow], $precision) . ' ' . $units[$pow]; 
		return round($hash/$divide[$pow+$helper], $precision); 
	} 
	
	private function formatWm($Wm) { 
	
		$kwh = $Wm*0.017/1000; 
		// var_dump($kwh);
		return number_format($kwh,2);
	} 
	
	public function gxb_average_energy_chart_callback(){
		$return_array['gxb-average-energy-chart'] = $this->gxb_average_energy_chart($_POST['timeframe']);
		return json_encode($return_array);
	}

	private function gxb_average_energy_chart($timeframe){

		self::get_energy_info_from_db();
		
		self::manipulate_energy_info_from_db();

		$this->dates_array = array();
		
		switch ($timeframe){
			case 'Daily':
				//take data for 1 month
				$period = new DatePeriod(
					 new DateTime('-1 month'),
					 new DateInterval('P1D'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					foreach ($this->db_energy_info as $sensor=>$readings){
						if ($sensor == 762232){
							foreach($readings as $time=>$sensor_reading){
								
								if ($value->format('M d') == date('M d',$time)){
									$this->dates_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
					}
					
					
				}

			break;
			case 'Weekly':
				//take data for 3 months
				$period = new DatePeriod(
					 new DateTime('-3 months'),
					 new DateInterval('P1W'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date =  date('M d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$end_date_format =  date('Y-M-d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$this->dates_array[$value->format('M d').' - '.$end_date] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						if ($sensor == 762232){
							foreach($readings as $time=>$sensor_reading){
								
								if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-d')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								
									$this->dates_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
					}	
				}

			break;
			case 'Monthly':
				//take data for 1 year
				$period = new DatePeriod(
					 new DateTime('-11 months'),
					 new DateInterval('P1M'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date_format =  date('Y-M-t', strtotime($value->format('Y-M-d')));
					$this->dates_array[$value->format('M')] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						if ($sensor == 762232){
							foreach($readings as $time=>$sensor_reading){
								
								if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-01')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								
									$this->dates_array[$value->format('M')] += self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
					}
				}

			break;
		}

		$return_array = array(
			'labels' => array_keys($this->dates_array),
			'datasets' => 
			array(
				array(
				'label'=> "Average Energy in KWh",
				'yAxisID'=> 'y-axis-left',
				'backgroundColor'=> 'rgb(0, 0, 0,0)',
				'borderColor'=> 'rgb(68, 67, 233)',
				'data'=>array_values($this->dates_array),
				'type'=> 'line',
				),
				array(
					'label'=> "Average Energy in KWh",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(48, 152, 237)',
					'borderColor'=> 'rgb(48, 152, 237)',
					'data'=>array_values($this->dates_array),

				)
			),
			'chart_type'	=> 'bar',
			'metric'	=> ' KWh',
			'stacked_x'	=> false,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			
			'tooltip_mode'=>'nearest',
			'aspectratio'	=> 3,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,1)',
		);
		
		return $return_array;
	}


	public function gxb_mining_electicity_coverage_chart_callback(){
		self::get_energy_info_from_db();
		
		self::manipulate_energy_info_from_db();
		$return_array['gxb-mining-electicity-coverage-chart'] = $this->gxb_mining_electicity_coverage_chart($_POST['timeframe']);
		return json_encode($return_array);
	}
	private function gxb_mining_electicity_coverage_chart($timeframe){
		
		$this->dates_array = array();

		switch ($timeframe){
			case 'Daily':
			
				//take data for 1 month
				$period = new DatePeriod(
					 new DateTime('-1 month'),
					 new DateInterval('P1D'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					foreach ($this->db_energy_info as $sensor=>$readings){
					
						foreach($readings as $time=>$sensor_reading){
							
							if ($value->format('M d') == date('M d',$time)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm']); 
								}else{
									$this->mining_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
					}
				}

			break;
			case 'Weekly':
			
				//take data for 3 months
				$period = new DatePeriod(
					 new DateTime('-3 months'),
					 new DateInterval('P1W'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date =  date('M d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$end_date_format =  date('Y-M-d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$this->dates_array[$value->format('M d').' - '.$end_date] = 0; 
					$this->mining_array[$value->format('M d').' - '.$end_date] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						
						foreach($readings as $time=>$sensor_reading){
							
							if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-d')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm']); 
								}else{
									$this->mining_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
						
					}	
				}

			break;
			case 'Monthly':
			
				//take data for 1 year
				$period = new DatePeriod(
					 new DateTime('-11 months'),
					 new DateInterval('P1M'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date_format =  date('Y-M-t', strtotime($value->format('Y-M-d')));
					$this->dates_array[$value->format('M')] = 0; 
					$this->mining_array[$value->format('M')] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						
						foreach($readings as $time=>$sensor_reading){
							
							if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-01')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M')] += self::formatWm($sensor_reading['Wm']); 
								}else{
									$this->mining_array[$value->format('M')] += self::formatWm($sensor_reading['Wm']); 
								}
							}
						}
						
					}
				}

			break;
		}
		
		$real_date_array = array();
		$real_mine_array = array();
		foreach($this->mining_array as $date=>$mine_cost ){
			if ($mine_cost == 0){
				$percent_covered = 0;
			}else{
				$percent_covered = $this->dates_array[$date]*100/$mine_cost;
			}
			
			if ($percent_covered > 100){
				$percent_covered = 100;
			}
			$mine_cost = 100 - $percent_covered;

			$real_mine_array[$date] = number_format($mine_cost,2);
			$real_date_array[$date] = number_format($percent_covered,2);
		}
		
		$return_array = array(
			'labels' => array_keys($this->dates_array),
			'datasets' => 
			array(
				array(
					'label'=> "Green Coverage",
					'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(48, 152, 237,0.85)',
					'borderColor'=> 'rgb(48, 152, 237,0.85)',
					'data'=>array_values($real_date_array),
				),
				array(
					'label'=> "Mining Costs",
					'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(68, 67, 233,0.85)',
					'borderColor'=> 'rgb(68, 67, 233,0.85)',
					'data'=>array_values($real_mine_array),
				),
			),
			'chart_type'	=> 'bar',
			'metric'	=> '%',
			'stacked_x'	=> true,
			'stacked_y'	=> true,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 3,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}

	public function gxb_production_consumption_chart_callback(){
		self::get_energy_info_from_db();
		
		self::manipulate_energy_info_from_db();
		$return_array['gxb-production-consumption-chart'] = $this->gxb_production_consumption_chart($_POST['timeframe']);
		return json_encode($return_array);
	}
	private function gxb_production_consumption_chart($timeframe){

		$this->dates_array = array();
		$this->mining_array = array();

		switch ($timeframe){
			case 'Daily':
			
				//take data for 1 month
				$period = new DatePeriod(
					 new DateTime('-1 month'),
					 new DateInterval('P1D'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					foreach ($this->db_energy_info as $sensor=>$readings){
					
						foreach($readings as $time=>$sensor_reading){
							
							if ($value->format('M d') == date('M d',$time)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm'])*0.094; 
								}else{
									// $this->mining_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm'])*0.094; 
									$this->mining_array[$value->format('M d')] = self::formatWm($sensor_reading['Wm'])*0.094; 
								}
							}
						}
					}
				}

			break;
			case 'Weekly':
			
				//take data for 3 months
				$period = new DatePeriod(
					 new DateTime('-3 months'),
					 new DateInterval('P1W'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date =  date('M d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$end_date_format =  date('Y-M-d', strtotime('+6 days', strtotime($value->format('Y-M-d'))));
					$this->dates_array[$value->format('M d').' - '.$end_date] = 0; 
					$this->mining_array[$value->format('M d').' - '.$end_date] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						
						foreach($readings as $time=>$sensor_reading){
							
							if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-d')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm'])*0.094; 
								}else{
									// $this->mining_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm'])*0.094; 
									$this->mining_array[$value->format('M d').' - '.$end_date] += self::formatWm($sensor_reading['Wm'])*0.094; 
								}
							}
						}
						
					}	
				}
			
			break;
			case 'Monthly':
			
				//take data for 1 year
				$period = new DatePeriod(
					 new DateTime('-11 months'),
					 new DateInterval('P1M'),
					 new DateTime('+1 days')
				);
				foreach ($period as $key => $value) {
					
					$end_date_format =  date('Y-M-t', strtotime($value->format('Y-M-d')));
					$this->dates_array[$value->format('M')] = 0; 
					$this->mining_array[$value->format('M')] = 0; 
					foreach ($this->db_energy_info as $sensor=>$readings){
						
						foreach($readings as $time=>$sensor_reading){
							
							if (strtotime(date('Y-M-d',$time)) >= strtotime($value->format('Y-M-01')) && strtotime(date('Y-M-d',$time)) <= strtotime($end_date_format)){
								if ($sensor == 762232){
									$this->dates_array[$value->format('M')] += self::formatWm($sensor_reading['Wm'])*0.094; 
								}else{
									// $this->mining_array[$value->format('M')] += self::formatWm($sensor_reading['Wm'])*0.094; 
									$this->mining_array[$value->format('M')] += self::formatWm($sensor_reading['Wm'])*0.094; 
								}
							}
						}
						
					}
				}
			break;
		}
		

		
		$mining_final_cost = array();
		foreach($this->mining_array as $date=>$mine_cost ){
			
			$mining_final_cost[$date] = number_format($mine_cost - $this->dates_array[$date],2);
			$this->dates_array[$date] = number_format($this->dates_array[$date],2);
			$this->mining_array[$date] = number_format($this->mining_array[$date],2);
		}


		$return_array = array(
			'labels' => array_keys($this->dates_array),
			'datasets' => 
			array(

				array(
					'label'=> "Green Energy Income",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(48, 152, 236,0.4)',
					'borderColor'=> 'rgb(48, 152, 236)',
					'data'=>array_values($this->dates_array),
				),
				array(
					'label'=> "Mining Final Cost",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(62, 60, 171,0.4)',
					'borderColor'=> 'rgb(62, 60, 171)',
					'data'=>array_values($mining_final_cost),
				),
				array(
					'label'=> "Mining Energy Cost",
					'yAxisID'=> 'y-axis-left',
					'backgroundColor'=> 'rgb(69, 65, 233,0.4)',
					'borderColor'=> 'rgb(69, 65, 233)',
					'data'=>array_values($this->mining_array),
				),
			),
			'chart_type'	=> 'line',
			'metric'	=> '$',
			'stacked_x'	=> true,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'tooltip_mode'=>'nearest',
			'aspectratio'	=> 5,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
		);
		
		return $return_array;
	}
	
	private function gxb_total_production_of_green_energy_chart(){
		
		$this->dates_array = array();
		$total = 0;
        $total_sales = 0;
		//take data for 1 year
		$period = new DatePeriod(
			 new DateTime('22-12-2018'),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		foreach ($period as $key => $value) {
			$this->dates_array[$value->format('M d')] = 0;
			$this->dates_array_cost[$value->format('M d')] = 0;
			foreach ($this->db_energy_info as $sensor=>$readings){
			
				foreach($readings as $time=>$sensor_reading){
					
					if ($value->format('M d') == date('M d',$time)){
						if ($sensor == 762232){
							$addition = self::formatWm($sensor_reading['Wm']); 
							$this->dates_array[$value->format('M d')] = $addition;
							$total += $addition;
							
							$addition_sales = self::formatWm($sensor_reading['Wm'])*0.094; 
							$this->dates_array_cost[$value->format('M d')] = number_format($addition_sales,2,'.','');
							$total_sales += $addition_sales;
						}
					}
				}
			}
		}

		$return_array = array(
			'labels' => array_keys($this->dates_array),
			'datasets' => 
			array(

				array(
					'label'=> "Total Production of Green Energy",
					'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(68, 67, 234,0)',
					'borderColor'=> 'rgb(68, 67, 234)',
					'data'=>array_values($this->dates_array),
				),
				array(
					'label'=> "Total Income of Green Energy",
					'yAxisID'=> 'y-axis-right','backgroundColor'=> 'rgb(48, 152, 236,0)',
					'borderColor'=> 'rgb(48, 152, 236)',
					'data'=>array_values($this->dates_array_cost),
				),
			),
			'chart_type'	=> 'line',
			'metric'	=> ' KWh',
			'stacked_x'	=> false,
			'stacked_y'	=> false,
			'display_x'	=> true,
			'display_y'	=> true,
			'zero'	=> true,
			'hasright'	=> true,
			'display_y_right' => true,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 3,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
			'total_value'	=> array(
				array(
					'elementname' => 'gxb-kw-equivalent',
					'total' => number_format($total,2).' KWh'
				),
				array(
					'elementname' => 'gxb-usd-equivalent',
					'total' => number_format($total_sales,2).' $'
				),
			),
		);
		
		$this->total_kwh = $total;
		return $return_array;
	}

/*
	private function gxb_total_income_of_green_energy_chart(){
		
		$this->dates_array = array();
		$total = 0;

		//take data for 1 year
		$period = new DatePeriod(
			 new DateTime('22-12-2018'),
			 new DateInterval('P1D'),
			 new DateTime()
		);
		foreach ($period as $key => $value) {
			$this->dates_array[$value->format('M d')] = 0;
			foreach ($this->db_energy_info as $sensor=>$readings){
			
				foreach($readings as $time=>$sensor_reading){
					
					if ($value->format('M d') == date('M d',$time)){
						if ($sensor == 762232){
							$addition = self::formatWm($sensor_reading['Wm'])*0.094; 
							$this->dates_array[$value->format('M d')] = $addition;
							$total += $addition;
						}
					}
				}
			}
		}

		$return_array = array(
			'labels' => array_keys($this->dates_array),
			'datasets' => 
			array(

				array(
					'label'=> "Total Incode of Green Energy",
					'yAxisID'=> 'y-axis-left','backgroundColor'=> 'rgb(48, 152, 236,0)',
					'borderColor'=> 'rgb(48, 152, 236)',
					'data'=>array_values($this->dates_array),
				),
			),
			'chart_type'	=> 'line',
			'metric'	=> ' $',
			'stacked_x'	=> false,
			'stacked_y'	=> false,
			'zero'	=> true,
			'tooltip_mode'=>'index',
			'aspectratio'	=> 4,
			'gridlines_color_x'	=> 'rgb(229, 229, 229,0)',
			'gridlines_color_y'	=> 'rgb(229, 229, 229,0.7)',
			'total_value'	=> array(
				'elementname' => 'gxb-usd-equivalent',
				'total' => '$'.number_format($total,0)
			),
		);
		
		return $return_array;
	}

*/
	private function gxb_update_gas(){
		
		$return['carbon'] = 7.07*$this->total_kwh/10;
		$return['oil'] = number_format($return['carbon']/0.43/1000,2);
		$return['carbon'] = number_format($return['carbon'],2).' KG';
		
		// var_dump($return);
		return $return;
	}
 
}
?>