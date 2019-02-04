<?php
//Require the init file responsible for loading all the required files.
require '../includes/config/init.php';

get_header();
?>

	<div id="total-assets-metric" class="col l12 gxb-metric-wrapper">

		<div class="card">
		
			<div class="gxb-card-heading">
			
				<h3 class="truncate">Total Assets</h3>
				
				<div class="gxb-icons-wrapper">
					
					<div data-tooltip="This table represents our total current assets and their USD/BTC equivalent.">
					
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve"><g><g><rect x="192" y="298.667" width="42.667" height="42.667"/></g></g><g><g><path d="M213.333,0C95.513,0,0,95.513,0,213.333s95.513,213.333,213.333,213.333s213.333-95.513,213.333-213.333 S331.154,0,213.333,0z M213.333,388.053c-96.495,0-174.72-78.225-174.72-174.72s78.225-174.72,174.72-174.72 c96.446,0.117,174.602,78.273,174.72,174.72C388.053,309.829,309.829,388.053,213.333,388.053z"/></g></g><g><g><path d="M296.32,150.4c-10.974-45.833-57.025-74.091-102.858-63.117c-38.533,9.226-65.646,43.762-65.462,83.384h42.667 c2.003-23.564,22.729-41.043,46.293-39.04s41.043,22.729,39.04,46.293c-4.358,21.204-23.38,36.169-45.013,35.413 c-10.486,0-18.987,8.501-18.987,18.987v0v45.013h42.667v-24.32C279.787,241.378,307.232,195.701,296.32,150.4z"/>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					
					</div>
				
				
					<div data-tooltip="Click to view in Full Screen">
					
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="gxb-expand-icon hide-on-med-and-down"  x="0px" y="0px" width="20px" height="20px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve"><g><g id="fullscreen"><path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51    H306v76.5h51V0H229.5z" /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

					</div>
					
				</div>
				
			</div>
			
			<div class="gxb-card-content">
				
				<div id="total-assets-chart" class="col l3 s12">
				
					
					<canvas id="gxb-total-assets-chart"></canvas>
				
				</div>
				
				<div class="col l6 s12">
				
					 <table>
						<thead>
						  <tr>
							  <th></th>
							  <th>Asset</th>
							  <th>% of Portfolio</th>
							  <th>Current Balance</th>
							  <th>BTC Equivalent</th>
							  <th>USD Equivalent</th>
						  </tr>
						</thead>

						<tbody>
						  <tr class="active-row" data-coin="BTC">
							<td><div id="btc-circle" class="gxb-circle-layer"></div></td>
							<td>BTC</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						  </tr>
						  <tr class="active-row" data-coin="ETH">
							<td><div id="eth-circle" class="gxb-circle-layer"></div></td>
							<td>ETH</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						  </tr>
						  <tr class="active-row" data-coin="LTC">
							<td><div id="ltc-circle" class="gxb-circle-layer"></div></td>
							<td>LTC</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						  </tr> 
						  <tr class="active-row" data-coin="DASH">
							<td><div id="dsh-circle" class="gxb-circle-layer"></div></td>
							<td>DASH</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						  </tr>
						  <tr class="active-row" data-coin="ZEC">
							<td><div id="zch-circle" class="gxb-circle-layer"></div></td>
							<td>ZEC</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						  </tr>
						</tbody>
					  </table>
				
				</div>
				
				<div class="col l3 s12">
				
					<h4 class="gxb-total-title">Total</h4>
				
					<div class="gxb-inner-card gxb-total-card z-depth-1">
						<div class="gxb-low-opacity-text">BTC</div>
						<div class="gxb-equivalent-value gxb-btc-equivalent"></div>
						<div class="gxb-equivalent-label">Total BTC Equivalent</div>
						
					</div>
				
					<div class="gxb-inner-card gxb-total-card z-depth-1">
						<div class="gxb-low-opacity-text">USD</div>
						<div class="gxb-equivalent-value gxb-usd-equivalent"></div>
						<div class="gxb-equivalent-label">Total USD Equivalent</div>
					</div>
				
				</div>
				
				<div class="clearfix"></div>
				
			</div>
			
		</div>
		
	</div>
	
	<div id="historical-data-metric" class="col l6 s12 gxb-metric-wrapper">

		<div class="card">
		
			<div class="gxb-card-heading">
				
				<h3 class="truncate">Historical Data</h3>
				
				<div class="gxb-icons-wrapper">
					
					<div data-tooltip="This chart represents the historical data of assets balance.">
					
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve"><g><g><rect x="192" y="298.667" width="42.667" height="42.667"/></g></g><g><g><path d="M213.333,0C95.513,0,0,95.513,0,213.333s95.513,213.333,213.333,213.333s213.333-95.513,213.333-213.333 S331.154,0,213.333,0z M213.333,388.053c-96.495,0-174.72-78.225-174.72-174.72s78.225-174.72,174.72-174.72 c96.446,0.117,174.602,78.273,174.72,174.72C388.053,309.829,309.829,388.053,213.333,388.053z"/></g></g><g><g><path d="M296.32,150.4c-10.974-45.833-57.025-74.091-102.858-63.117c-38.533,9.226-65.646,43.762-65.462,83.384h42.667 c2.003-23.564,22.729-41.043,46.293-39.04s41.043,22.729,39.04,46.293c-4.358,21.204-23.38,36.169-45.013,35.413 c-10.486,0-18.987,8.501-18.987,18.987v0v45.013h42.667v-24.32C279.787,241.378,307.232,195.701,296.32,150.4z"/>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					
					</div>
				
				
					<div class="hide-on-med-and-down"  data-tooltip="Click to view in Full Screen">
					
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="gxb-expand-icon hide-on-med-and-down"  x="0px" y="0px" width="20px" height="20px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve"><g><g id="fullscreen"><path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51    H306v76.5h51V0H229.5z" /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

					</div>
					
				</div>
				
			</div>
			
			<div class="gxb-card-content">
				
				<div class="gxb-chart-heading col s12">
				
					<div class="gxb-dataset-legend-wrapper">
					
						<div class="gxb-dataset-legend-item">
						
							<div class="gxb-label-box"></div>
							
							<div class="gxb-label-text">
								BTC Equivalent
							</div>
						
						</div>
					
						<div class="gxb-dataset-legend-item">
						
							<div class="gxb-label-box"></div>
							
							<div class="gxb-label-text">
								USD Equivalent
							</div>
						
						</div>
					
					</div>
				
				</div>
			
				
				<div class="col s12">
				
					
					<canvas id="gxb-historical-data-chart"></canvas>
				
				</div>
				
				<div class="clearfix"></div>
				
			</div>
			
		</div>
		
	</div>
	
	
	<div id="historical-performance-metric" class="col l6 s12 gxb-metric-wrapper">

		<div class="card">
		
			<div class="gxb-card-heading">
			
				<h3 class="truncate">Historical Performance</h3>
				
				<div class="gxb-icons-wrapper">
					
					<div data-tooltip="This chart represents the historical performance of our assets including the payouts.">
					
						<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve"><g><g><rect x="192" y="298.667" width="42.667" height="42.667"/></g></g><g><g><path d="M213.333,0C95.513,0,0,95.513,0,213.333s95.513,213.333,213.333,213.333s213.333-95.513,213.333-213.333 S331.154,0,213.333,0z M213.333,388.053c-96.495,0-174.72-78.225-174.72-174.72s78.225-174.72,174.72-174.72 c96.446,0.117,174.602,78.273,174.72,174.72C388.053,309.829,309.829,388.053,213.333,388.053z"/></g></g><g><g><path d="M296.32,150.4c-10.974-45.833-57.025-74.091-102.858-63.117c-38.533,9.226-65.646,43.762-65.462,83.384h42.667 c2.003-23.564,22.729-41.043,46.293-39.04s41.043,22.729,39.04,46.293c-4.358,21.204-23.38,36.169-45.013,35.413 c-10.486,0-18.987,8.501-18.987,18.987v0v45.013h42.667v-24.32C279.787,241.378,307.232,195.701,296.32,150.4z"/>	</g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
					
					</div>
				
				
					<div class="hide-on-med-and-down"  data-tooltip="Click to view in Full Screen">
					
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="gxb-expand-icon hide-on-med-and-down"  x="0px" y="0px" width="20px" height="20px" viewBox="0 0 357 357" style="enable-background:new 0 0 357 357;" xml:space="preserve"><g><g id="fullscreen"><path d="M51,229.5H0V357h127.5v-51H51V229.5z M0,127.5h51V51h76.5V0H0V127.5z M306,306h-76.5v51H357V229.5h-51V306z M229.5,0v51    H306v76.5h51V0H229.5z" /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

					</div>
					
				</div>
				
			</div>
			
			<div class="gxb-card-content">
			
					
				<div class="gxb-chart-heading col s12">
				
					<div class="gxb-dataset-legend-wrapper">
					
						<div class="gxb-dataset-legend-item">
						
							<div class="gxb-label-box"></div>
							
							<div class="gxb-label-text">
								Total assets plus payouts USD
							</div>
						
						</div>
					
						<div class="gxb-dataset-legend-item">
						
							<div class="gxb-label-box"></div>
							
							<div class="gxb-label-text">
								Payouts USD
							</div>
						</div>
						
						
					
					</div>
					
					
					<div class="gxb-chart-filter">
					
						<div class="gxb-filter-item">BTC</div>
						<div class="gxb-filter-item gxb-active-filter">USD</div>
					
					</div>
				
				</div>

			
				<div class="col s12">
				
					
					<canvas id="gxb-historical-performance-chart"></canvas>
			
				</div>
				
				<div class="clearfix"></div>
				
			</div>
			
		</div>
		
	</div>
	
	
	
<?php get_footer(); ?>