<?php

function get_header(){
	require '../includes/elements/header.php';
}//end get_header

function get_footer(){
	require '../includes/elements/footer.php';
}//end get_footer

function gxb_menu($path){

	$menu_items = array(
	
		'Energy Dashboard'		=> array( 
			'icon' => '<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 391.399 391.399" style="enable-background:new 0 0 391.399 391.399;" xml:space="preserve"><path style="fill:#94C83D;" d="M144.299,377.699l50.4-143.6l-132.4-0.4c-5.6,0-10-4.4-10-10c0-2.4,0.8-4.4,2.4-6.4l0,0c38.8-47.6,77.6-95.2,116.4-142.8c19.2-23.2,38.4-46.8,58-70.8c3.6-4.4,9.6-4.8,14-1.6c3.2,2.8,4.4,7.2,3.2,11.2l-50.8,144l132.4,0.4c5.6,0,10,4.4,10,10c0,2.4-0.8,4.4-2,6l0,0c-37.2,48-76.4,95.2-115.6,142.8c-19.2,23.2-38.4,46.4-58.8,71.2c-3.6,4.4-9.6,4.8-14,1.6C143.899,386.099,142.699,381.699,144.299,377.699"/><g><path style="fill:#5E9641;" d="M119.499,332.899c4.8,2.8,6.8,8.8,4,13.6c-2.8,4.8-8.8,6.8-13.6,4c-28.8-15.6-52.4-38.4-68.8-66c-16-27.2-25.2-58.4-25.2-91.6c0-41.6,14.4-80.4,38.8-111.2s59.2-53.6,99.6-63.2c5.2-1.2,10.8,2,12,7.6c1.2,5.2-2,10.8-7.6,12c-36,8.4-66.8,28.8-88.4,56s-34.4,62-34.4,98.8c0,29.2,8,57.2,22.4,81.6C73.099,298.899,93.899,319.299,119.499,332.899"/><path style="fill:#5E9641;" d="M273.099,53.699c-4.8-2.8-6.8-8.8-4-13.6c2.8-4.8,8.8-6.8,13.6-4c28.8,15.6,52,38.8,68,65.6c16,27.2,24.8,58.4,24.8,91.2c0,42-14.8,81.2-39.6,112c-24.8,30.8-60,53.6-100.8,62.8c-5.2,1.2-10.8-2.4-12-7.6s2.4-10.8,7.6-12c36.4-8,67.6-28.4,89.6-55.6c22-27.6,35.2-62.4,35.2-99.6c0-29.2-8-56.8-22-80.8C319.099,88.099,298.699,67.699,273.099,53.699"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>', 
			
			'path' => '/dashboards/energy.php'
		),
		
		'Mining Dashboard'	=> array( 
			'icon' => '<svg height="40px" viewBox="0 0 512 512" width="40px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="0" y2="512"><stop offset="0" stop-color="#2af598"/><stop offset="1" stop-color="#009efd"/></linearGradient><path d="m240.785156 208.949219 141.335938 140.886719-28.238282 28.328124-141.636718-141.183593c-35.886719 43.785156-38.964844 89.195312-41.246094 100.023437h-37v-36c-.15625-29.929687 9.710938-78.84375 30.910156-110.804687l-25.800781-25.804688 28.28125-28.285156 26.308594 26.308594c32.566406-19.894531 82.367187-28.417969 113.542969-28.417969.253906 0 .507812 0 .757812.003906h37.996094v36c-9 1.558594-57.5625 1.265625-105.210938 38.945313zm219.214844-52.949219v40h52v40h-52v40h52v40h-52v40h52v40h-52v4c0 33.085938-26.914062 60-60 60h-4v52h-40v-52h-40v52h-40v-52h-40v52h-40v-52h-40v52h-40v-52h-4c-33.085938 0-60-26.914062-60-60v-4h-52v-40h52v-40h-52v-40h52v-40h-52v-40h52v-40h-52v-40h52v-4c0-33.085938 26.914062-60 60-60h4v-52h40v52h40v-52h40v52h40v-52h40v52h40v-52h40v52h4c33.085938 0 60 26.914062 60 60v4h52v40zm-40-44c0-11.027344-8.972656-20-20-20h-288c-11.027344 0-20 8.972656-20 20v288c0 11.027344 8.972656 20 20 20h288c11.027344 0 20-8.972656 20-20zm0 0" fill="url(#a)"/></svg>', 
			
			'path' => '/dashboards/mining.php'
		),
		
		'Portfolio Dashboard'	=> array( 
			'icon' => '<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 496 496" style="enable-background:new 0 0 496 496;" xml:space="preserve" width="40px" height="40px"><g><g><path d="M496,248C496,111.256,384.744,0,248,0c-42.872,0-84.64,11.104-121.672,32H96V0H48v101.496C16.64,144.216,0,194.776,0,248 c0,136.752,111.256,248,248,248c30.472,0,60.216-5.48,88.416-16.248C352.512,489.984,371.552,496,392,496 c24.944,0,49.072-8.968,67.936-25.248L449.48,458.64C433.52,472.416,413.112,480,392,480c-48.52,0-88-39.48-88-88 c0-48.52,39.48-88,88-88c48.52,0,88,39.48,88,88c0,20.28-6.704,39.344-19.4,55.128l12.472,10.032 C487.856,438.768,496,415.632,496,392c0-20.464-6.024-39.504-16.264-55.608C490.496,308.184,496,278.472,496,248z M128,80h16v16 v96h-16V80z M96,48h16v16v128H96V48z M64,16h16v16v160H64V16z M240,479.8C118.432,475.648,20.352,377.568,16.2,256H240V479.8z M240,240H16.32c1.304-38.944,12.12-76.16,31.68-109.336V208h32h16h16h16h16h16h16h16h32v-80h-32V96h-32V64h-32V49.536 c33.848-20.512,72.312-31.896,112-33.256V240z M160,192v-80h16v16v64H160z M192,192v-48h16v48H192z M479.8,240h-68.488 l58.832-58.832C475.792,199.896,479.104,219.616,479.8,240z M439.488,117.2l-89.352,89.352l11.312,11.312l86.8-86.8 c6.208,10.592,11.592,21.712,16.088,33.288L388.688,240h-49.376l10.344-10.344l-11.312-11.312L316.688,240h-49.376L417.496,89.816 C425.48,98.376,432.848,107.512,439.488,117.2z M256,16.2c20.384,0.696,40.104,4.008,58.832,9.656L256,84.688V16.2z M256,179.312 l97.224-97.224l-11.312-11.312L256,156.688v-49.376l75.648-75.648c11.576,4.488,22.696,9.872,33.288,16.088L352.048,60.64 l11.312,11.312l15.44-15.44c9.688,6.64,18.824,14,27.384,21.992L256,228.688V179.312z M392,288c-57.344,0-104,46.656-104,104 c0,30.088,12.92,57.144,33.408,76.152c-21.08,7.032-43.008,10.912-65.408,11.664V256h223.816 c-0.752,22.392-4.664,44.304-11.688,65.384C449.12,300.904,422.072,288,392,288z" /></g></g><g><g><rect x="84.155" y="336" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -198.7141 208.2625)" width="135.767" height="16" /></g></g><g><g><path d="M184,352c-13.232,0-24,10.768-24,24s10.768,24,24,24s24-10.768,24-24S197.232,352,184,352z M184,384c-4.408,0-8-3.584-8-8 c0-4.416,3.592-8,8-8s8,3.584,8,8C192,380.416,188.408,384,184,384z" /></g></g><g><g><path d="M120,288c-13.232,0-24,10.768-24,24s10.768,24,24,24s24-10.768,24-24S133.232,288,120,288z M120,320c-4.408,0-8-3.584-8-8 c0-4.416,3.592-8,8-8s8,3.584,8,8C128,316.416,124.408,320,120,320z"/></g></g><g><g><path d="M392,384c-8.824,0-16-7.176-16-16c0-8.824,7.176-16,16-16c8.824,0,16,7.176,16,16h16c0-14.872-10.24-27.288-24-30.864V320 h-16v17.136c-13.76,3.576-24,15.992-24,30.864c0,17.648,14.352,32,32,32c8.824,0,16,7.176,16,16c0,8.824-7.176,16-16,16 c-8.824,0-16-7.176-16-16h-16c0,14.872,10.24,27.288,24,30.864V464h16v-17.136c13.76-3.576,24-15.992,24-30.864 C424,398.352,409.648,384,392,384z" fill="#FFFFFF"/></g></g><g><g><rect x="448" y="384" width="16" height="16" /></g></g><g><g><rect x="320" y="384" width="16" height="16" /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>', 
			
			'path' => '/dashboards/portfolio.php'
		)
	);
?>
	<header class="hide-on-small-only">
		<nav>
			<div class="gxb-logo-wrapper">
				<img src="../images/gxblocks-logo.png"></img>
			</div>
			<div class="gxb-horizontal-seperator"></div>
			<div class="gxb-menu-wrapper">
				
				<?php foreach($menu_items as $name => $menu_item){ 
					if ($menu_item['path'] == $path){ 
						$active_menu_item = 'active-menu-item';
					}else{
						$active_menu_item = '';
					}
				?>
				<div class="gxb-menu-item <?php echo $active_menu_item; ?>">
					<a href="<?php echo $menu_item['path']; ?>">
						<div class="gxb-menu-item-image-wrapper">
							<?php echo $menu_item['icon']; ?>
						</div>
						<div class="gxb-menu-item-text-wrapper">
							<p><?php echo $name; ?></p>
						</div>
					</a>
				</div>	
				<?php } ?>
			</div>
		</nav>
	</header>
	
	<div class="mobile-window hide-on-med-and-up">
	  <div class="gxb-mobile-header">
		<div class="burger-container">
		  <div id="burger">
			<div class="bar topBar"></div>
			<div class="bar btmBar"></div>
		  </div>
		</div>
		<div class="icon"><img src="../images/gxblocks-logo.png"></div>
		
		<div class="gxb-swith-theme-wrapper gxb-mobile-switch-theme">
			<div class="switch">
				<label>
				  <input id="switch-theme" type="checkbox">
				  <span class="lever"></span>
				</label>
			  </div>
		</div>
		
		<ul class="menu">
		
			<?php foreach($menu_items as $name => $menu_item){ 
					if ($menu_item['path'] == $path){ 
						$active_menu_item = 'active-menu-item';
					}else{
						$active_menu_item = '';
					}
				?>
				<li class="menu-item <?php echo $active_menu_item; ?>">
					<a href="<?php echo $menu_item['path']; ?>">
						<div class="gxb-menu-item-image-wrapper">
							<?php echo $menu_item['icon']; ?>
						</div>
						<div class="gxb-menu-item-text-wrapper">
							<p><?php echo $name; ?></p>
						</div>
					</a>
				</li>	
				<?php } ?>
	
		  
			<li class="menu-item">
				<a href="#">
					<div class="gxb-menu-item-image-wrapper">
						<div class="gxb-notification-wrapper">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 459.334 459.334" style="enable-background:new 0 0 459.334 459.334;" xml:space="preserve" width="512px" height="512px"><g><g><g><path d="M175.216,404.514c-0.001,0.12-0.009,0.239-0.009,0.359c0,30.078,24.383,54.461,54.461,54.461 s54.461-24.383,54.461-54.461c0-0.12-0.008-0.239-0.009-0.359H175.216z" fill="#FFFFFF"/><path d="M403.549,336.438l-49.015-72.002c0-22.041,0-75.898,0-89.83c0-60.581-43.144-111.079-100.381-122.459V24.485 C254.152,10.963,243.19,0,229.667,0s-24.485,10.963-24.485,24.485v27.663c-57.237,11.381-100.381,61.879-100.381,122.459 c0,23.716,0,76.084,0,89.83l-49.015,72.002c-5.163,7.584-5.709,17.401-1.419,25.511c4.29,8.11,12.712,13.182,21.887,13.182 H383.08c9.175,0,17.597-5.073,21.887-13.182C409.258,353.839,408.711,344.022,403.549,336.438z" fill="#FFFFFF"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
						</div>
					</div>
					
					<div class="gxb-menu-item-text-wrapper">
						<p>Notifications</p>
					</div>
				</a>
			</li>
			<li class="menu-item">
				<a href="#">
					<div class="gxb-menu-item-image-wrapper">
						<div class="gbx-user-icon">T</div>
					</div>
					
					<div class="gxb-menu-item-text-wrapper">
						<p>Thodoris K.</p>
					</div>
				</a>
			</li>
		</ul>
		
	  </div>
	  
	</div>
  
	
<?php
}//end gxb_menu

function gxb_top_menu($path){

	$menu_items = array(
	
		'Energy Dashboard'		=> array( 
			'icon' => '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 391.399 391.399" style="enable-background:new 0 0 391.399 391.399;" xml:space="preserve" width="40px" height="40px"><path style="fill:#94C83D;" d="M144.299,377.699l50.4-143.6l-132.4-0.4c-5.6,0-10-4.4-10-10c0-2.4,0.8-4.4,2.4-6.4l0,0c38.8-47.6,77.6-95.2,116.4-142.8c19.2-23.2,38.4-46.8,58-70.8c3.6-4.4,9.6-4.8,14-1.6c3.2,2.8,4.4,7.2,3.2,11.2l-50.8,144l132.4,0.4c5.6,0,10,4.4,10,10c0,2.4-0.8,4.4-2,6l0,0c-37.2,48-76.4,95.2-115.6,142.8c-19.2,23.2-38.4,46.4-58.8,71.2c-3.6,4.4-9.6,4.8-14,1.6C143.899,386.099,142.699,381.699,144.299,377.699"/><g><path style="fill:#5E9641;" d="M119.499,332.899c4.8,2.8,6.8,8.8,4,13.6c-2.8,4.8-8.8,6.8-13.6,4c-28.8-15.6-52.4-38.4-68.8-66c-16-27.2-25.2-58.4-25.2-91.6c0-41.6,14.4-80.4,38.8-111.2s59.2-53.6,99.6-63.2c5.2-1.2,10.8,2,12,7.6c1.2,5.2-2,10.8-7.6,12c-36,8.4-66.8,28.8-88.4,56s-34.4,62-34.4,98.8c0,29.2,8,57.2,22.4,81.6C73.099,298.899,93.899,319.299,119.499,332.899"/><path style="fill:#5E9641;" d="M273.099,53.699c-4.8-2.8-6.8-8.8-4-13.6c2.8-4.8,8.8-6.8,13.6-4c28.8,15.6,52,38.8,68,65.6c16,27.2,24.8,58.4,24.8,91.2c0,42-14.8,81.2-39.6,112c-24.8,30.8-60,53.6-100.8,62.8c-5.2,1.2-10.8-2.4-12-7.6s2.4-10.8,7.6-12c36.4-8,67.6-28.4,89.6-55.6c22-27.6,35.2-62.4,35.2-99.6c0-29.2-8-56.8-22-80.8C319.099,88.099,298.699,67.699,273.099,53.699"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>', 
			
			'path' => '/dashboards/energy.php'
		),
		
		'Mining Dashboard'	=> array( 
			'icon' => '<svg height="40px" viewBox="0 0 512 512" width="40px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="256" x2="256" y1="0" y2="512"><stop offset="0" stop-color="#2af598"/><stop offset="1" stop-color="#009efd"/></linearGradient><path d="m240.785156 208.949219 141.335938 140.886719-28.238282 28.328124-141.636718-141.183593c-35.886719 43.785156-38.964844 89.195312-41.246094 100.023437h-37v-36c-.15625-29.929687 9.710938-78.84375 30.910156-110.804687l-25.800781-25.804688 28.28125-28.285156 26.308594 26.308594c32.566406-19.894531 82.367187-28.417969 113.542969-28.417969.253906 0 .507812 0 .757812.003906h37.996094v36c-9 1.558594-57.5625 1.265625-105.210938 38.945313zm219.214844-52.949219v40h52v40h-52v40h52v40h-52v40h52v40h-52v4c0 33.085938-26.914062 60-60 60h-4v52h-40v-52h-40v52h-40v-52h-40v52h-40v-52h-40v52h-40v-52h-4c-33.085938 0-60-26.914062-60-60v-4h-52v-40h52v-40h-52v-40h52v-40h-52v-40h52v-40h-52v-40h52v-4c0-33.085938 26.914062-60 60-60h4v-52h40v52h40v-52h40v52h40v-52h40v52h40v-52h40v52h4c33.085938 0 60 26.914062 60 60v4h52v40zm-40-44c0-11.027344-8.972656-20-20-20h-288c-11.027344 0-20 8.972656-20 20v288c0 11.027344 8.972656 20 20 20h288c11.027344 0 20-8.972656 20-20zm0 0" fill="url(#a)"/></svg>', 
			
			'path' => '/dashboards/mining.php'
		),
		
		'Portfolio Dashboard'	=> array( 
			'icon' => '<?xml version="1.0" encoding="iso-8859-1"?><!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0) --><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 496 496" style="enable-background:new 0 0 496 496;" xml:space="preserve" width="40px" height="40px"><g><g><path d="M496,248C496,111.256,384.744,0,248,0c-42.872,0-84.64,11.104-121.672,32H96V0H48v101.496C16.64,144.216,0,194.776,0,248 c0,136.752,111.256,248,248,248c30.472,0,60.216-5.48,88.416-16.248C352.512,489.984,371.552,496,392,496 c24.944,0,49.072-8.968,67.936-25.248L449.48,458.64C433.52,472.416,413.112,480,392,480c-48.52,0-88-39.48-88-88 c0-48.52,39.48-88,88-88c48.52,0,88,39.48,88,88c0,20.28-6.704,39.344-19.4,55.128l12.472,10.032 C487.856,438.768,496,415.632,496,392c0-20.464-6.024-39.504-16.264-55.608C490.496,308.184,496,278.472,496,248z M128,80h16v16 v96h-16V80z M96,48h16v16v128H96V48z M64,16h16v16v160H64V16z M240,479.8C118.432,475.648,20.352,377.568,16.2,256H240V479.8z M240,240H16.32c1.304-38.944,12.12-76.16,31.68-109.336V208h32h16h16h16h16h16h16h16h32v-80h-32V96h-32V64h-32V49.536 c33.848-20.512,72.312-31.896,112-33.256V240z M160,192v-80h16v16v64H160z M192,192v-48h16v48H192z M479.8,240h-68.488 l58.832-58.832C475.792,199.896,479.104,219.616,479.8,240z M439.488,117.2l-89.352,89.352l11.312,11.312l86.8-86.8 c6.208,10.592,11.592,21.712,16.088,33.288L388.688,240h-49.376l10.344-10.344l-11.312-11.312L316.688,240h-49.376L417.496,89.816 C425.48,98.376,432.848,107.512,439.488,117.2z M256,16.2c20.384,0.696,40.104,4.008,58.832,9.656L256,84.688V16.2z M256,179.312 l97.224-97.224l-11.312-11.312L256,156.688v-49.376l75.648-75.648c11.576,4.488,22.696,9.872,33.288,16.088L352.048,60.64 l11.312,11.312l15.44-15.44c9.688,6.64,18.824,14,27.384,21.992L256,228.688V179.312z M392,288c-57.344,0-104,46.656-104,104 c0,30.088,12.92,57.144,33.408,76.152c-21.08,7.032-43.008,10.912-65.408,11.664V256h223.816 c-0.752,22.392-4.664,44.304-11.688,65.384C449.12,300.904,422.072,288,392,288z" /></g></g><g><g><rect x="84.155" y="336" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -198.7141 208.2625)" width="135.767" height="16" /></g></g><g><g><path d="M184,352c-13.232,0-24,10.768-24,24s10.768,24,24,24s24-10.768,24-24S197.232,352,184,352z M184,384c-4.408,0-8-3.584-8-8 c0-4.416,3.592-8,8-8s8,3.584,8,8C192,380.416,188.408,384,184,384z" /></g></g><g><g><path d="M120,288c-13.232,0-24,10.768-24,24s10.768,24,24,24s24-10.768,24-24S133.232,288,120,288z M120,320c-4.408,0-8-3.584-8-8 c0-4.416,3.592-8,8-8s8,3.584,8,8C128,316.416,124.408,320,120,320z"/></g></g><g><g><path d="M392,384c-8.824,0-16-7.176-16-16c0-8.824,7.176-16,16-16c8.824,0,16,7.176,16,16h16c0-14.872-10.24-27.288-24-30.864V320 h-16v17.136c-13.76,3.576-24,15.992-24,30.864c0,17.648,14.352,32,32,32c8.824,0,16,7.176,16,16c0,8.824-7.176,16-16,16 c-8.824,0-16-7.176-16-16h-16c0,14.872,10.24,27.288,24,30.864V464h16v-17.136c13.76-3.576,24-15.992,24-30.864 C424,398.352,409.648,384,392,384z" fill="#FFFFFF"/></g></g><g><g><rect x="448" y="384" width="16" height="16" /></g></g><g><g><rect x="320" y="384" width="16" height="16" /></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>', 
			
			'path' => '/dashboards/portfolio.php'
		)
	);
	
	
	foreach($menu_items as $name => $menu_item){ 
		if ($menu_item['path'] == $path){ 
			$page_name = $name;
			$page_name_icon = $menu_item['icon'];
		}else{
			continue;
		}
	} 
 ?>

<div class="gxb-top-header-wrapper row">
	<div class="gxb-page-name-wrapper">
		<div class="card">
			<div class="gxb-page-name-icon"><?php echo $page_name_icon; ?></div>
			<div class="gxb-page-name"><?php echo $page_name; ?></div>
		</div>
	</div>
	<div class="gxb-page-name-wrapper gxb-notification-and-user">
		<p class="gxb-last-update-info">Last Update: <span class="gxb-last-update-info-span"></span></p>
		<div class="gxb-swith-theme-wrapper hide-on-med-and-down" data-tooltip="Click to switch themes">

			 <div class="switch">
				<label>
				  <input id="switch-theme" type="checkbox">
				  <span class="lever"></span>
				</label>
			  </div>
		
		</div>
		
		<div class="gxb-notification-wrapper hide-on-med-and-down">
			
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 459.334 459.334" style="enable-background:new 0 0 459.334 459.334;" xml:space="preserve" width="512px" height="512px"><g><g><g><path d="M175.216,404.514c-0.001,0.12-0.009,0.239-0.009,0.359c0,30.078,24.383,54.461,54.461,54.461 s54.461-24.383,54.461-54.461c0-0.12-0.008-0.239-0.009-0.359H175.216z" fill="#FFFFFF"/><path d="M403.549,336.438l-49.015-72.002c0-22.041,0-75.898,0-89.83c0-60.581-43.144-111.079-100.381-122.459V24.485 C254.152,10.963,243.19,0,229.667,0s-24.485,10.963-24.485,24.485v27.663c-57.237,11.381-100.381,61.879-100.381,122.459 c0,23.716,0,76.084,0,89.83l-49.015,72.002c-5.163,7.584-5.709,17.401-1.419,25.511c4.29,8.11,12.712,13.182,21.887,13.182 H383.08c9.175,0,17.597-5.073,21.887-13.182C409.258,353.839,408.711,344.022,403.549,336.438z" fill="#FFFFFF"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
			
			<div class="gxb-notifications-overview">
			
				<div class="gxb-notification-item gxb-unread">
				
					<p class="gxb-notification-text">Total Assets of GX Blocks in Crypto Coins and Others. Data is fetched from cryptowat.ch</p>
					
					<div class="gxb-notification-time">
						
						<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47.001px" height="47.001px" viewBox="0 0 47.001 47.001" style="enable-background:new 0 0 47.001 47.001;" xml:space="preserve"><g><g id="Layer_1_65_"><g><path d="M46.907,20.12c-0.163-0.347-0.511-0.569-0.896-0.569h-2.927C41.223,9.452,32.355,1.775,21.726,1.775C9.747,1.775,0,11.522,0,23.501C0,35.48,9.746,45.226,21.726,45.226c7.731,0,14.941-4.161,18.816-10.857c0.546-0.945,0.224-2.152-0.722-2.699c-0.944-0.547-2.152-0.225-2.697,0.72c-3.172,5.481-9.072,8.887-15.397,8.887c-9.801,0-17.776-7.974-17.776-17.774c0-9.802,7.975-17.776,17.776-17.776c8.442,0,15.515,5.921,17.317,13.825h-2.904c-0.385,0-0.732,0.222-0.896,0.569c-0.163,0.347-0.11,0.756,0.136,1.051l4.938,5.925c0.188,0.225,0.465,0.355,0.759,0.355c0.293,0,0.571-0.131,0.758-0.355l4.938-5.925C47.018,20.876,47.07,20.467,46.907,20.12z"/><path d="M21.726,6.713c-1.091,0-1.975,0.884-1.975,1.975v11.984c-0.893,0.626-1.481,1.658-1.481,2.83c0,1.906,1.551,3.457,3.457,3.457c0.522,0,1.014-0.125,1.458-0.334l6.87,3.965c0.312,0.181,0.65,0.266,0.986,0.266c0.682,0,1.346-0.354,1.712-0.988c0.545-0.943,0.222-2.152-0.724-2.697l-6.877-3.971c-0.092-1.044-0.635-1.956-1.449-2.526V8.688C23.701,7.598,22.816,6.713,21.726,6.713z M21.726,24.982c-0.817,0-1.481-0.665-1.481-1.48c0-0.816,0.665-1.481,1.481-1.481s1.481,0.665,1.481,1.481C23.207,24.317,22.542,24.982,21.726,24.982z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
						
						<span class="gxb-time-value">1 min</span> ago
					
					</div>
					
					
				</div>
				
				<div class="gxb-notification-item gxb-unread">
				
					<p class="gxb-notification-text">Total Assets of GX Blocks in Crypto Coins</p>
					
					<div class="gxb-notification-time">
						
						<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47.001px" height="47.001px" viewBox="0 0 47.001 47.001" style="enable-background:new 0 0 47.001 47.001;" xml:space="preserve"><g><g id="Layer_1_65_"><g><path d="M46.907,20.12c-0.163-0.347-0.511-0.569-0.896-0.569h-2.927C41.223,9.452,32.355,1.775,21.726,1.775C9.747,1.775,0,11.522,0,23.501C0,35.48,9.746,45.226,21.726,45.226c7.731,0,14.941-4.161,18.816-10.857c0.546-0.945,0.224-2.152-0.722-2.699c-0.944-0.547-2.152-0.225-2.697,0.72c-3.172,5.481-9.072,8.887-15.397,8.887c-9.801,0-17.776-7.974-17.776-17.774c0-9.802,7.975-17.776,17.776-17.776c8.442,0,15.515,5.921,17.317,13.825h-2.904c-0.385,0-0.732,0.222-0.896,0.569c-0.163,0.347-0.11,0.756,0.136,1.051l4.938,5.925c0.188,0.225,0.465,0.355,0.759,0.355c0.293,0,0.571-0.131,0.758-0.355l4.938-5.925C47.018,20.876,47.07,20.467,46.907,20.12z"/><path d="M21.726,6.713c-1.091,0-1.975,0.884-1.975,1.975v11.984c-0.893,0.626-1.481,1.658-1.481,2.83c0,1.906,1.551,3.457,3.457,3.457c0.522,0,1.014-0.125,1.458-0.334l6.87,3.965c0.312,0.181,0.65,0.266,0.986,0.266c0.682,0,1.346-0.354,1.712-0.988c0.545-0.943,0.222-2.152-0.724-2.697l-6.877-3.971c-0.092-1.044-0.635-1.956-1.449-2.526V8.688C23.701,7.598,22.816,6.713,21.726,6.713z M21.726,24.982c-0.817,0-1.481-0.665-1.481-1.48c0-0.816,0.665-1.481,1.481-1.481s1.481,0.665,1.481,1.481C23.207,24.317,22.542,24.982,21.726,24.982z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
						
						<span class="gxb-time-value">12 hours</span> ago
					
					</div>
					
				</div>
				
				<div class="gxb-notification-item">
				
					<p class="gxb-notification-text">Total Assets of GX Blocks in Crypto Coins</p>
					
					<div class="gxb-notification-time">
						
						<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="47.001px" height="47.001px" viewBox="0 0 47.001 47.001" style="enable-background:new 0 0 47.001 47.001;" xml:space="preserve"><g><g id="Layer_1_65_"><g><path d="M46.907,20.12c-0.163-0.347-0.511-0.569-0.896-0.569h-2.927C41.223,9.452,32.355,1.775,21.726,1.775C9.747,1.775,0,11.522,0,23.501C0,35.48,9.746,45.226,21.726,45.226c7.731,0,14.941-4.161,18.816-10.857c0.546-0.945,0.224-2.152-0.722-2.699c-0.944-0.547-2.152-0.225-2.697,0.72c-3.172,5.481-9.072,8.887-15.397,8.887c-9.801,0-17.776-7.974-17.776-17.774c0-9.802,7.975-17.776,17.776-17.776c8.442,0,15.515,5.921,17.317,13.825h-2.904c-0.385,0-0.732,0.222-0.896,0.569c-0.163,0.347-0.11,0.756,0.136,1.051l4.938,5.925c0.188,0.225,0.465,0.355,0.759,0.355c0.293,0,0.571-0.131,0.758-0.355l4.938-5.925C47.018,20.876,47.07,20.467,46.907,20.12z"/><path d="M21.726,6.713c-1.091,0-1.975,0.884-1.975,1.975v11.984c-0.893,0.626-1.481,1.658-1.481,2.83c0,1.906,1.551,3.457,3.457,3.457c0.522,0,1.014-0.125,1.458-0.334l6.87,3.965c0.312,0.181,0.65,0.266,0.986,0.266c0.682,0,1.346-0.354,1.712-0.988c0.545-0.943,0.222-2.152-0.724-2.697l-6.877-3.971c-0.092-1.044-0.635-1.956-1.449-2.526V8.688C23.701,7.598,22.816,6.713,21.726,6.713z M21.726,24.982c-0.817,0-1.481-0.665-1.481-1.48c0-0.816,0.665-1.481,1.481-1.481s1.481,0.665,1.481,1.481C23.207,24.317,22.542,24.982,21.726,24.982z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
						
						<span class="gxb-time-value">4 days</span> ago
					
					</div>
					
					
				</div>
				
				<div class="gxb-notification-item gxb-view-all">
					
					<p class="gxb-notification-text">View all notifications</p>
					
				</div>
				
			</div>
			
			<div id="gxb-notifcations-overlay" class="gxb-overlay"></div>
			
		</div>
		
		<div class="gxb-user-wrapper hide-on-med-and-down">
			<div class="gbx-user-name">Thodoris K.</div>
			<div class="gbx-user-icon">T</div>
			
			
			<div class="gxb-account-panel">
			
				<div class="gxb-account-item">
					My Profile
				</div>
			
				<div class="gxb-account-item">
					My Wallet
				</div>
			
				<div class="gxb-account-item">
					Settings
				</div>
			
				<div class="gxb-account-item">
					Log Out
				</div>
			
			</div>
			
			<div id="gxb-account-overlay" class="gxb-overlay"></div>
			
		</div>
		
	</div>
</div>

<?php
}//end gxb_menu


?>