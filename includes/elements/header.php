<!DOCTYPE html>
<html>
	<head>
		<title>GXBlocks Demo Charts</title>
		
		<!--Import main css file-->
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"> 
		<link type="text/css" rel="stylesheet" href="<?php echo $_SERVER['"DOCUMENT_ROOT"']; ?>/assets/css/style.css"  media="screen,projection"/>

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<?php

$request_page = explode('.',explode('/',$_SERVER["REQUEST_URI"])[2])[0];
?>
<body class="<?php echo $request_page; ?>-dashboard light-theme">
<div class="gxb-fullscreen-overlay"></div>
<!-- Left Menu Header -->
<?php gxb_menu($_SERVER["REQUEST_URI"]); ?>

<div class="gxb-main-content">
	
	<!-- Top Page Menu Header -->
	<?php gxb_top_menu($_SERVER["REQUEST_URI"]); ?>
	
	<div class="gxb-dashboard-metrics row">
