(function( $ ) {

	

	
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	/**
	 * 
	 * Initialize global vars
	 * Applied for all Dashboards
	 * 
	 */
	var ajax_object	= {ajaxurl:'../includes/ajax/do_ajax.php'};
	var charts_array = {};
	/**
	 * 
	 * Change Color Themes - Change Event
	 * Applied for all Dashboards
	 * 
	 */ 
	 var color_theme = '';
		
		if( $('body').hasClass('light-theme') ){
			
			color_theme = 'lightTheme';
		}
		else {
			color_theme = 'darkTheme';
		}
	$(".switch input").on('change',function() {
		
		
		
		if( $('body').hasClass('light-theme') ){
			
			$('body').removeClass('light-theme').addClass('dark-theme');
			color_theme = 'darkTheme';
		}
		else {
			$('body').removeClass('dark-theme').addClass('light-theme');
			color_theme = 'lightTheme';
		}

		localStorage['color_theme'] = color_theme;




		//Update Chart Colors
		$('canvas').each(function( index ) {
				
			var chart_id = $(this).attr('id');
			if( charts_array[chart_id] ){
				
				updatechartColors( chart_id, color_theme );
			}
			
		});
		
	});

		if (localStorage['color_theme'] == 'darkTheme'){

			var switch_lever_desktop = $('.gxb-top-header-wrapper #switch-theme');
			var switch_lever_mobile = $('.gxb-mobile-header #switch-theme');
			switch_lever_desktop.prop('checked',true);
			switch_lever_mobile.prop('checked',true);
			switch_lever_mobile.trigger('change');

		}else{

		}

	
	/**
	 *
	 * Check if mobile
	 *
	 *
	 *
	 */
	var is_mobile = false;
	if( $('.gxb-swith-theme-wrapper.hide-on-med-and-down').css('display')=='none') {
		is_mobile = true;
	}
	
	/**
	 * 
	 * Notifications Open - Click Event
	 * Applied for all Dashboards
	 * 
	 */
	$('.gxb-notification-wrapper svg').on('click', function(){
		
		$('.gxb-notifications-overview').addClass('gxb-opened');
		$('#gxb-notifcations-overlay').addClass('active');
	});
	 
	 
	$('#gxb-notifcations-overlay').on('click', function(){
		
		$('.gxb-notifications-overview').removeClass('gxb-opened');
		$(this).removeClass('active');
		
	});
	 
	
	
	/**
	 * 
	 * Account Open - Click Event
	 * Applied for all Dashboards
	 * 
	 */
	// $('.gxb-user-wrapper').on('click', function(){
		
		// $('.gxb-account-panel').addClass('gxb-opened');
		// $('#gxb-account-overlay').addClass('active');
	// });
	 
	 
	// $('#gxb-account-overlay').on('click', function(){
		

		// $('.gxb-account-panel').removeClass('gxb-opened');
		// $('#gxb-account-overlay').removeClass('active');
		
	// });
	
	
	/**
	 * 
	 * Notification Item Click Event
	 * Applied for all Dashboards
	 * 
	 */
	$('.gxb-notification-item:not(.gxb-view-all)').on('click', function(){
		
		$(this).toggleClass('gxb-unread');
	});
	 
	 
	 
	/**
	 * 
	 * Expand Window to Full Screen - Click Event
	 * Applied for all Dashboards
	 * 
	 */
	$('.gxb-expand-icon').on('click', function(){
		
		var metric_id = $(this).closest('.gxb-metric-wrapper').attr('id');
		var exact_card_to_expand = $('#'+metric_id+':not(.clone)');
		var card_clone = $('#'+metric_id+'.clone');
		var overlay = $('.gxb-fullscreen-overlay');
		/*Fullscreen*/

		//Clone the card
		// console.log($('#'+metric_id+'.clone'));
		if (card_clone.length == 1){
			var exact_card_to_expand = $('#'+metric_id+':not(.clone)')
			$('#'+metric_id+':not(.clone)').toggleClass('fullscreen');
			//Animate to top in 1s
			$('html, body').animate( {scrollTop: card_clone.css('top')}, 500 );
			overlay.removeClass('opened');
			
			setTimeout(function(){
				exact_card_to_expand.css('position','inherit');
				exact_card_to_expand.attr('style','');
				card_clone.remove();
			},550);
			
			
		}else{
			
			var card_position = exact_card_to_expand.position();
			card_clone = exact_card_to_expand.clone();
			card_clone.addClass('clone').css('opacity',0).css('top',card_position.top+'px').css('left',card_position.left+'px').css('width',exact_card_to_expand.css('width')).css('height',exact_card_to_expand.css('height'));
			exact_card_to_expand.css('top',card_position.top+'px').css('left',card_position.left+'px').css('width',exact_card_to_expand.css('width')).css('height',exact_card_to_expand.css('height')).css('position','absolute');
			exact_card_to_expand.after(card_clone);	
			exact_card_to_expand.toggleClass('fullscreen');		
			//Animate to top in 1s
			$('html, body').animate( {scrollTop: 125}, 500 );
			// $(window).scrollTop(300);
			overlay.addClass('opened');
		}

		setTimeout(function(){
			exact_card_to_expand.toggleClass('z-index-overlay');
		},500);
		
			
	});
	  
	 
	/**
	 * 
	 * Chart Filter - Click Event
	 * Applied for all Dashboards
	 * 
	 */
	$('.gxb-filter-item').on('click', function(){
		
		$(this).closest('.gxb-chart-filter').find('.gxb-filter-item.gxb-active-filter').removeClass('gxb-active-filter');
		$(this).addClass('gxb-active-filter');
		
		//Get the timeframe	
		var timeframe = $(this).text();

		//Get the chart id to apply filter change
		var chart_id = $(this).closest('.gxb-card-content').find('canvas').attr('id');
		
		//Get the coin
		var coin_acronym 		= $('#gxb-coins-cards .active-coin').attr('data-coin');
		
		$.ajax({
			url: ajax_object.ajaxurl,
			type : 'post',
			data : {
				action : 'charts',
				function_name : chart_id,
				coin: coin_acronym,
				timeframe : timeframe
			},
			beforeSend : function () { 
				$('#'+chart_id).after('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
				
			},
			success : function( response ) {			
// console.log(response);

				var resp = $.parseJSON(response);

				updatechartData(charts_array[chart_id],resp[chart_id],chart_id);
				updatechartColors( chart_id, color_theme );
				$('.lds-ring').remove();
			},
			error : function (response) {
				// $content.empty().append('Something went wrong.');
			}
		
		});	
		
		// alert('Code to change chart: '+chart_id);
	});
	 
	 
	/**
	 * 
	 * Mobile Header Open Menu - Click Event
	 * Applied for all Dashboards on Mobile
	 * 
	 */
	(function(){
		var burger = document.querySelector('.burger-container'),
			header = document.querySelector('.gxb-mobile-header');
		
		burger.onclick = function() {
			header.classList.toggle('menu-opened');
		}
	}());
	 
	 
	
	/**
	 * 
	 * Select Item from Table - Click Event
	 * Mining and Portfolio Dashboard
	 * 
	 */
	$('.gxb-selectable-table tr').on('click', function(){
		
		$(this).toggleClass('active-row');
		
		var $active_rows = $(this).closest('tbody').find('.active-row');
		var $not_active_rows = $(this).closest('tbody').find('tr:not(.active-row)');	
		
		
		
		var action_data = '';
		$active_rows.each(function(key,row) {
			action_data += $(this).find('td').eq(1).text()+'+';
		});
		
		$(".gxb-dataset-legend-item.hide").removeClass('hide');
		$not_active_rows.each(function(key,row) {

			$(".gxb-dataset-legend-item[data-coin='" + $(this).find('td').eq(1).text() + "']").addClass('hide');
		});	
			
			
			$.ajax({
			url: ajax_object.ajaxurl,
			type : 'post',
			data : {
				action : 'charts',
				function_name : 'gxb_pool_power_chart',
				coins : action_data
			},
			beforeSend : function () { 
				$('#gxb-pool-power-chart').after('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');

			},
			success : function( response ) {			

				var resp = $.parseJSON(response);

				updatechartData(charts_array['gxb-pool-power-chart'],resp['gxb-pool-power-chart'],'gxb-pool-power-chart');
				updatechartColors( 'gxb-pool-power-chart', color_theme );
				$('.lds-ring').remove();

			},
			error : function (response) {
				// $content.empty().append('Something went wrong.');
			}
		
			});	
		
		
	});
	 
	
	
	 
	/**
	 * 
	 * Select Coin - Click Event - Fixed Header
	 * Mining Dashboard Only
	 * 
	 */ 
	 
	if( $('body').hasClass('mining-dashboard') ){  
	 
		$('.gxb-fixed-header-wrapper').on('click', '.col', function(){ 
			var coin_acronym 		= $(this).attr('data-coin');
			
			$('.gxb-fixed-header-wrapper .col').removeClass('active-coin');
			$(this).addClass('active-coin');
			$("#gxb-coins-cards").find(".card[data-coin='" + coin_acronym + "']").trigger('click'); 
			$("tbody tr").removeClass('hoverable');
			$("tbody tr[data-coin-id='" + coin_acronym + "']").addClass('hoverable');

		});
		 
	}
	 
	 
	/**
	 * 
	 * Select Coin - Click Event - Cards
	 * Mining Dashboard Only
	 * 
	 */
	 
	if( $('body').hasClass('mining-dashboard') ){ 
	
		$('#gxb-coins-cards').on('click', '.card', function(){
			
			//get coin acronym
			var coin_acronym 		= $(this).attr('data-coin');
			var coin_name 			= $(this).find('.gxb-coin-title').text();
			var coin_algo 			= $(this).find('.gxb-coin-algorithm').text();
			var coin_hash_value 	= $(this).find('.gxb-hash-value').text();
			var coin_hash_metric 	= $(this).find('.gxb-hash-metric').text();
			
			//Remove previous active coin
			$('#gxb-coins-cards .card.active-coin').removeClass('active-coin');
			$('.gxb-fixed-header-wrapper .col').removeClass('active-coin');
			
			//Add the active class to the selected coin
			$(this).addClass('active-coin');
			$(".gxb-fixed-header-wrapper").find(".col[data-coin='" + coin_acronym + "']").addClass('active-coin');
			
			//Change Dashboard texts
			$('.gxb-current-crypto-name').text(coin_name);
			$('.gxb-current-crypto-algo').text(coin_algo);
			$('.gxb-selected-coin-hashrate').text( coin_hash_value + ' '+ coin_hash_metric );
			$('#hashrate-metric .gxb-low-opacity-text').text( coin_acronym );
			$('.gxb-current-crypto-acronym').text( coin_acronym );
			
			//Highlight the coin
			$("tbody tr").removeClass('hoverable');
			$("tbody tr[data-coin-id='" + coin_acronym + "']").addClass('hoverable');
			
			$.ajax({
			url: ajax_object.ajaxurl,
			type : 'post',
			data : {
				action : 'charts',
				function_name : 'gxb_update_mining_coin',
				coin : coin_acronym
			},
			beforeSend : function () { 
				$('canvas:not(#gxb-pool-power-chart)').after('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
				
				$('#hash-power-metric .gxb-filter-item').removeClass('gxb-active-filter');
				$('#hash-power-metric .gxb-filter-item.hourly-item').addClass('gxb-active-filter');
			},
			success : function( response ) {			
// console.log(response);
				var resp = $.parseJSON(response);
				// console.log(resp);
				$.each(resp, function(chart_id,chartdata) {
					// console.log(chart_id);
					// console.log(chartdata);
					// console.log(chartdata);
					if (chart_id == 'to_change'){
						// console.log(chartdata);
						$('.gxb-forecast-table tbody').remove();
						$('.gxb-forecast-table').append(chartdata);
					}else if (chart_id == 'to_change_wallet'){
						// console.log(chartdata);
						$('.gxb-equivalent-value.gxb-usd-value').text(chartdata.usd);
						$('.gxb-equivalent-value.gxb-mbtc-value').text(chartdata.mBTC);
					}else{
						updatechartData(charts_array[chart_id],chartdata,chart_id);
						updatechartColors( chart_id, color_theme );
					}
					
				});
				

				var $selected_hasrate = $('.gxb-selected-coin-hashrate');
				$selected_hasrate.text($('[data-coin='+coin_acronym+'] .gxb-hash-value').text()+' '+$('[data-coin='+coin_acronym+'] .gxb-hash-metric').text());
				$('.lds-ring').remove();
			},
			error : function (response) {
				// $content.empty().append('Something went wrong.');
			}
		
		});	
			
		});
		
	}
	
		 
	/**
	 * 
	 * Display Fixed Header for Coin Select - Scroll Event
	 * Mining Dashboard Only
	 * 
	 */
	 if( $('body').hasClass('mining-dashboard') ){
	
		$(window).scroll(function() {
		   var hT = $('#gxb-coins-cards').offset().top,
			   hH = $('#gxb-coins-cards').outerHeight(),
			   wH = $(window).height(),
			   wS = $(this).scrollTop();
		   if (wS > (hT+hH)){
			   $('.gxb-fixed-header').addClass('active');
			   $('.gxb-mobile-header').addClass('no-shadow');
		   }
		   else {
				$('.gxb-fixed-header').removeClass('active');
				$('.gxb-mobile-header').removeClass('no-shadow');
		   }
		});
		
	}
	
	/**
	 * 
	 * The onload functions
	 * Applied for all Dashboards
	 * 
	 */	 
	$(window).on('load', function() {
		
		//Initialize charts on first page load
		initCharts();
		initGlobal();
		
	});
	
	
	var customTooltips = function(tooltip) {
		// Tooltip Element
		var tooltipEl = document.getElementById('chartjs-tooltip');
		if (!tooltipEl) {
			tooltipEl = document.createElement('div');
			tooltipEl.id = 'chartjs-tooltip';
			tooltipEl.innerHTML = "<table></table>"
			document.body.appendChild(tooltipEl);
		}
		// Hide if no tooltip
		if (tooltip.opacity === 0) {
			tooltipEl.style.opacity = 0;
			return;
		}
		// Set caret Position
		tooltipEl.classList.remove('above', 'below', 'no-transform');
		if (tooltip.yAlign) {
			tooltipEl.classList.add(tooltip.yAlign);
		} else {
			tooltipEl.classList.add('no-transform');
		}
		function getBody(bodyItem) {
			return bodyItem.lines;
		}
		// Set Text
		if (tooltip.body) {
			var titleLines = tooltip.title || [];
			var bodyLines = tooltip.body.map(getBody);
			//PUT CUSTOM HTML TOOLTIP CONTENT HERE (innerHTML)
			var innerHtml = '<thead>';
			titleLines.forEach(function(title) {
				innerHtml += '<tr><th>' + title + '</th></tr>';
			});
			innerHtml += '</thead><tbody>';
			bodyLines.forEach(function(body, i) {

				var colors = tooltip.labelColors[i];
				// console.log(colors);
				var style = 'background:' + colors.backgroundColor.replace(",0", ",1");
				style += '; border-color:#000' + colors.borderColor.replace(",0", ",1");
				style += '; border-width: 1px'; 
				var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
				innerHtml += '<tr><td>' + span + body + '</td></tr>';
			});
			innerHtml += '</tbody>';
			var tableRoot = tooltipEl.querySelector('table');
			tableRoot.innerHTML = innerHtml;
		}
		var position = this._chart.canvas.getBoundingClientRect();
		// Display, position, and set styles for font
		tooltipEl.style.opacity = 1;
		tooltipEl.style.left = position.left + tooltip.caretX + 'px';
		tooltipEl.style.top = position.top + tooltip.caretY + 'px';
		tooltipEl.style.fontFamily = tooltip._fontFamily;
		tooltipEl.style.fontSize = tooltip.fontSize;
		tooltipEl.style.fontStyle = tooltip._fontStyle;
		tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
	};
	
	
	/**
	 * 
	 * The chart initialization function on first page load
	 * Applied for all Dashboards
	 * 
	 */
	function initCharts(){
		
		$.ajax({
			url: ajax_object.ajaxurl,
			type : 'post',
			data : {
				action : 'charts',
				function_name : 'init_charts',
				
			},
			beforeSend : function () { 

				$('canvas').after('<div class="lds-ring"><div></div><div></div><div></div><div></div></div>');
			},
			success : function( response ) {
console.log(response);

				var resp = $.parseJSON(response);
				
				var ctx;
				$.each(resp, function(chart_id,chartdata) {
					
					if (chart_id == 'to_change_forecast'){
						$('.gxb-forecast-table tbody').remove();
						$('.gxb-forecast-table').append(chartdata);
					}else if (chart_id == 'to_change_gas'){
						// console.log(chartdata);
						$('.gxb-carbon-equivalent').text(chartdata.carbon);
						$('.gxb-oil-equivalent').text(chartdata.oil);
					}else if (chart_id == 'to_change_wallet'){
						// console.log(chartdata);
						$('.gxb-equivalent-value.gxb-usd-value').text(chartdata.usd);
						$('.gxb-equivalent-value.gxb-mbtc-value').text(chartdata.mBTC);
					}else{

						updatechartData(charts_array[chart_id],chartdata,chart_id);
					updatechartColors( chart_id, color_theme );
						if (chartdata.total_value){
							$.each(chartdata.total_value, function(k,v) {
								$('.'+v.elementname).text(v.total);
							});
							
						}
						
						if (chart_id == 'gxb-pool-chart'){

							$.each(chartdata.labels, function($k,$name) {
								$('.legend-percent.'+$name).text(chartdata.datasets[0].data[$k]+'%');
							});
						}
					}
				});

				$('.lds-ring').remove();
				
				// initFullscrren();
			},
			error : function (response) {
				// $content.empty().append('Something went wrong.');
			}
		
		});	
	}
	
	/**
	 * 
	 * The chart initialization fullscreen function on first page load
	 * Applied for all Dashboards
	 * 
	 */
	function initFullscrren(){
		
		$.each($('.gxb-metric-wrapper'),function($k,$el){
			// console.log();
			var exact_card_to_expand = $('#'+$('.gxb-metric-wrapper').eq($k).attr('id')+':not(.clone)');
			var card_position = exact_card_to_expand.position();
			exact_card_to_expand.css('top',card_position.top+'px').css('left',card_position.left+'px').css('width',exact_card_to_expand.css('width')).css('height',exact_card_to_expand.css('height'));

			// console.log($el);
		});
		
	}
	
	/**
	 * 
	 * The chart initialization function on first page load
	 * Applied for all Dashboards
	 * 
	 */
	function initGlobal(){
		
		$.ajax({
			url: ajax_object.ajaxurl,
			type : 'post',
			data : {
				action : 'charts',
				function_name : 'init_globals',
				
			},
			beforeSend : function () { 

			},
			success : function( response ) {
console.log(response);
				var resp = $.parseJSON(response);

				$.each(resp, function(key,data) {
					
					if (key == 'to_change_portfolio'){
						
						$.each(data, function(coin_name,coin_data) {
							// console.log(data.portfolio_percentage);
							$('.active-row[data-coin="'+coin_name+'"] td').eq(2).text(coin_data.portfolio_percentage);
							$('.active-row[data-coin="'+coin_name+'"] td').eq(3).text(coin_data.current_balance);
							$('.active-row[data-coin="'+coin_name+'"] td').eq(4).text(coin_data.btc_equivalent);
							$('.active-row[data-coin="'+coin_name+'"] td').eq(5).text(coin_data.usd_equivalent);
						});
						$('#total-assets-metric .gxb-btc-equivalent').text(data.totals.btc);
						$('#total-assets-metric .gxb-usd-equivalent').text(data.totals.usd);
						
					}else if (key == 'to_change_last_update'){
						// console.log(chartdata);
						$('.gxb-last-update-info-span').text(data);
					}else{
						$.each(data, function(coin_name,coin_data) {
						
							var $the_coin_el = $('[data-coin-id='+coin_name+'] td');
							var $the_coin_card_el_hash_value = $('[data-coin='+coin_name+'] .gxb-hash-value');
							var $the_coin_card_el_hash_metric = $('[data-coin='+coin_name+'] .gxb-hash-metric');
							
							$the_coin_el.eq(2).text(coin_data.poolpower);
							$the_coin_el.eq(3).text(coin_data.workers);
							$the_coin_card_el_hash_value.text(coin_data.hashrate.split(' ')[0]);
							$the_coin_card_el_hash_metric.text(coin_data.hashrate.split(' ')[1]);
							if (coin_name == 'BTC'){
								var $selected_hasrate = $('.gxb-selected-coin-hashrate');
								$selected_hasrate.text(coin_data.hashrate);
							}

						
						});
					}
					
				});


			},
			error : function (response) {
				// $content.empty().append('Something went wrong.');
			}
		
		});	
	}


	/**
	 * 
	 * The update charts function responsible for updating charts
	 * Applied for all Dashboards
	 * 
	 */
	function updatechartData(chart,resp,chart_id) {
		
		// console.log(chart.data);
		if (chart){
			chart.destroy();
		}
		
		$('#'+chart_id).css('width','100%');

		
		
		
		
		var chartdata = resp;

		var $diagram_ratio = chartdata.aspectratio;
		var $tick_size = 12;
		if (is_mobile){
			$diagram_ratio = 1.5;
			$tick_size = 8;
		}

		ctx = document.getElementById(chart_id).getContext('2d');
					
					//TODO Based on chart?
					// var chartmax = Math.round((Math.max.apply(Math,chartdata.datasets[0].data)+1000)/1000)*1000;
					
					//Create the new chart
					charts_array[chart_id] = new Chart(ctx, {
						// The type of chart we want to create
						type: chartdata.chart_type,

						// The data for our dataset
						data: chartdata,

						// Configuration options go here
						options: {
							aspectRatio:$diagram_ratio,
							cutoutPercentage:chartdata.cutoutPercentage,
							maintainAspectRatio:true,
// elements: {
            // line: {
                // tension: 0, // disables bezier curves
            // }
        // },
							legend: {
								display: chartdata.display_legend,

							},
							scales: {
								yAxes: [
								{
									id: 'y-axis-left',
									gridLines: {
										display: chartdata.display_y,
										drawBorder: false,
										color: chartdata.gridlines_color_y,
									},
									
									ticks: {
										fontSize: $tick_size,
										beginAtZero: chartdata.zero,
										// max:chartdata.max_value,
										callback: function(value, index, values) {
											if (chartdata.metric){

												return value + chartdata.metric  ;
											}else{

												return '';
											}
											
										},
										autoSkip:true,
										maxTicksLimit:5
									},
									
									stacked: chartdata.stacked_y,

								},{
									id: 'y-axis-right',
									position: 'right',
									gridLines: {
										display: chartdata.display_y_right,
										drawBorder: false,
										color: chartdata.gridlines_color_y,
									},
									
									ticks: {
										fontSize: $tick_size,
										beginAtZero: chartdata.zero,
										// max:chartdata.max_value,
										callback: function(value, index, values) {
											if (chartdata.metric){
												if(chartdata.hasright){
													return value + '$'  ;
												}
												
											}else{
												if(chartdata.hasright){
													return '';
												}
											}
											
										},
										autoSkip:true,
										maxTicksLimit:5
									},
									
									stacked: chartdata.stacked_y,

								}],
								xAxes: [{

									display: chartdata.display_x,
									stacked: chartdata.stacked_x,
									ticks: {
										fontSize: $tick_size,
									},
									gridLines: {
													color: chartdata.gridlines_color_x,
													drawBorder: false,
												}
								}],
							},
							tooltips: {
								mode: chartdata.tooltip_mode,
								intersect: false,
								titleFontFamily: "'Lato', sans-serif",
								backgroundColor: 'rgba(255,255,255,0.9)',
								titleFontColor: '#010101',
								bodyFontColor: '#666',
								bodyFontFamily: "'Lato', sans-serif",
								multiKeyBackground: 'transparent',
								titleMarginBottom: 12,
								bodySpacing: 12,
								xPadding: 15,
								yPadding: 15,
								// custom: customTooltips,
								
							}
						}
					});
					
					if (chart_id == 'gxb-pool-chart'){
						
						$.each(chartdata.labels, function($k,$name) {
							$('.legend-percent.'+$name).text(chartdata.datasets[0].data[$k]+'%');
						});
					}
		
		
					
		
		
		
		
		
		
		
		
		
		
		
		
		
		// chart.data = resp;
		// chart.update();
		// console.log(chart.data);
	}
	
	
	
	
	/**
	 * 
	 * Updates the colors of the charts when switch themes
	 * Applied for all Dashboards
	 * 
	 */
	function updatechartColors( $chart_id, $color_theme ) {
		
		//Get the current chart by chart_id
		var $chart = charts_array[$chart_id];
		
		//Create the chart color key
		var $color_chart_key = $chart_id.replace(/\-/g, "_");
		
		//Console log the chart infor
		// console.log(color_chart_key);
		
		
		var $all_charts_colors = { 
			
			globalColors: {
				
				lightTheme: {
					
					ticksColor: '#666',
					gridLinesColorX: 'rgba(217, 220, 224,0)',
					gridLinesColorY: 'rgba(217, 220, 224,1)',
					tooltips: {
						backgroundColor: 'rgba(255,255,255,0.9)',
						titleFontColor: '#010101',
						bodyFontColor: '#666',
					}
				}, 
				
				darkTheme: {
					
					ticksColor: '#fff',
					gridLinesColorX: 'rgba(31, 72, 112,0)',
					gridLinesColorY: 'rgba(31, 72, 112,1)',
					tooltips: {
						backgroundColor: 'rgba(16, 37, 70,0.9)',
						titleFontColor: '#fff',
						bodyFontColor: '#fff',
					}
					
				},
			},
			chartsColors: {

				gxb_average_energy_chart: {
				
					lightTheme: {
						backgroundColor: 	['transparent', '#3098ec'],
						borderColor: 		['#4443ea', '#3098ec'],
					},
					
					darkTheme: {
						backgroundColor: 	['transparent', '#009687'],
						borderColor: 		['#fdd848', '#009687'],
					},
					
				},
				
				gxb_mining_electicity_coverage_chart: {
				
					lightTheme: {
						backgroundColor: 	[ '#3098ec', '#4443ea' ],
						borderColor: 		[ 'transparent', 'transparent' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ '#009687', '#4443ea' ],
						borderColor: 		[ 'transparent', 'transparent' ],
					},
					
				},
				
				gxb_production_consumption_chart: {

					lightTheme: {
						backgroundColor: 	['rgba(48, 152, 237,0.4)', 'rgba(69, 65, 233, 0.4)', 'rgba(69, 65, 233, 0.4)'],
						borderColor: 		['rgba(48, 152, 237,0.4)', 'rgba(69, 65, 233, 0.4)', 'rgba(69, 65, 233, 0.4)'],
					},
					
					darkTheme: {
						backgroundColor: 	['rgba(0, 150, 135, 0.4)', 'rgba(253, 216, 72, 0.4)', 'rgba(69, 65, 233, 0.4)'],
						borderColor: 		['rgba(0, 150, 135, 0.4)', 'rgba(253, 216, 72, 0.4)', 'rgba(69, 65, 233, 0.4)'],
					},
					
				},
				
				gxb_total_production_of_green_energy_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'transparent','transparent' ],
						borderColor:		[ '#4443ea','transparent' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'transparent','transparent' ],
						borderColor: 		[ '#3098ec','transparent' ],
					},
					
				},
				
				
				gxb_pool_power_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'rgba(0, 18, 255,0.5)', 'rgba(49, 92, 255,0.5)', 'rgba(106, 137, 255,0.5)', 'rgba(120, 149, 255,0.5)', 'rgba(201, 213, 255,0.5)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgba(0, 18, 255,0.5)', 'rgba(49, 92, 255,0.5)', 'rgba(106, 137, 255,0.5)', 'rgba(120, 149, 255,0.5)', 'rgba(201, 213, 255,0.5)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
				},
				
				gxb_hash_power_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'rgba(48, 148, 246, 0.56)' ],
						borderColor: 		[ 'rgb(48, 148, 246)' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgba(253, 216, 72, 0.36)' ],
						borderColor: 		[ 'rgb(253, 216, 72)' ],
					},
					
				},
				
				gxb_coin_balance_chart: {
				
					lightTheme: {
						backgroundColor: 	[ '#9ec9ea' ],
						borderColor: 		[ 'transparent' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgba(253, 216, 72, 0.5)' ],
						borderColor: 		[ 'transparent' ],
					},
					
				},
				
				gxb_pool_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
				},
				
				gxb_power_costs_vs_wallet_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'transparent', 'transparent' ],
						borderColor: 		[ 'rgba(48, 152, 237,0.85)', '#b33a6d' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'transparent', 'transparent' ],
						borderColor: 		[ 'rgb(253, 216, 72)', '#b33a6d' ],
					},
					
				},
				
				gxb_total_wallet_balance_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'transparent' ],
						borderColor: 		[ '#3194ec' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'transparent' ],
						borderColor: 		[ '#3194ec' ],
					},
					
				},
				
				gxb_total_assets_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
						borderColor: 		[ 'rgb(0, 18, 255)', 'rgb(49, 92, 255)', 'rgb(106, 137, 255)', 'rgb(120, 149, 255)', 'rgb(201, 213, 255)' ],
					},
					
					
				},
				
				
				gxb_historical_data_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'transparent', 'transparent' ],
						borderColor: 		[ '#e91e63', '#3194ec' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'transparent', 'transparent' ],
						borderColor: 		[ 'rgb(253, 216, 72)', 'rgb(0, 255, 55)' ],
					},
					
				},
				
				
				gxb_historical_performance_chart: {
				
					lightTheme: {
						backgroundColor: 	[ 'rgba(48, 152, 236,0.5)','rgba(68, 67, 234,0.5)' ],
						borderColor: 		[ 'rgb(48, 152, 236)','rgb(68, 67, 234)' ],
					},
					
					darkTheme: {
						backgroundColor: 	[ 'rgba(48, 152, 236,0.5)', 'rgba(68, 67, 234,0.5)' ],
						borderColor: 		[ 'rgb(48, 152, 236)', 'rgb(68, 67, 234)' ],
					},
					
				},
				
				
			},
		};
		
		
		//Set the new Global Colors
		$chart.options.scales.xAxes[0].ticks.minor.fontColor  	= $all_charts_colors.globalColors[$color_theme].ticksColor;
		$chart.options.scales.yAxes[0].ticks.minor.fontColor  	= $all_charts_colors.globalColors[$color_theme].ticksColor;
		$chart.options.scales.yAxes[1].ticks.minor.fontColor  	= $all_charts_colors.globalColors[$color_theme].ticksColor;
		$chart.options.scales.xAxes[0].gridLines.color 		 	= $all_charts_colors.globalColors[$color_theme].gridLinesColorX;
		$chart.options.scales.yAxes[0].gridLines.color 		 	= $all_charts_colors.globalColors[$color_theme].gridLinesColorY;
		$chart.options.scales.yAxes[1].gridLines.color 		 	= $all_charts_colors.globalColors[$color_theme].gridLinesColorY;
		// console.log($chart.options.scales.yAxes);
		$chart.options.tooltips.backgroundColor 			 	= $all_charts_colors.globalColors[$color_theme].tooltips.backgroundColor;
		$chart.options.tooltips.titleFontColor 			 		= $all_charts_colors.globalColors[$color_theme].tooltips.titleFontColor;
		$chart.options.tooltips.bodyFontColor 			 		= $all_charts_colors.globalColors[$color_theme].tooltips.bodyFontColor;
		
		
		
		//If isset the chart in the colors array
		if( typeof( $all_charts_colors.chartsColors[$color_chart_key] ) != "undefined" && $all_charts_colors.chartsColors[$color_chart_key] !== null ){
		
			//Loop through the datasets of the current chart
			$($chart.data.datasets).each( function( index ) {
			
				$chart.data.datasets[index].backgroundColor 	= $all_charts_colors.chartsColors[$color_chart_key][$color_theme].backgroundColor[index];
				$chart.data.datasets[index].borderColor 		= $all_charts_colors.chartsColors[$color_chart_key][$color_theme].borderColor[index];
				
			});
			
			
		}
		
		if ($chart_id == 'gxb-pool-chart' || $chart_id == 'gxb-total-assets-chart'){

			$chart.data.datasets[0].backgroundColor 	= $all_charts_colors.chartsColors[$color_chart_key][$color_theme].backgroundColor;
			$chart.data.datasets[0].borderColor 		= $all_charts_colors.chartsColors[$color_chart_key][$color_theme].borderColor;
		}
		
		//Update the chart
		$chart.update();
	}
	
	 
	//Define your target Element here 
	var $back_to_top = $('#dl-back-to-top');
	 
	//If Element exists 
	if( $back_to_top.length ){

		//Scroll Event to show or hide the back to top btn
		$( window ).on( 'scroll', function() {

			if ( $(this).scrollTop() > 400 ) {
				
				//Show the btn
				$back_to_top.fadeIn();
				
			} 
			else {
				
				//Hide the btn
				$back_to_top.fadeOut();
				
			}
			
		});

		//When Click the back to top button
		$back_to_top.on( 'click', function() {
			
			//Animate to top in 1s
			$('html, body').animate( {scrollTop: 0}, 1000 );
			
		});
		
	 
	}//End if element exists
	
 })( jQuery );