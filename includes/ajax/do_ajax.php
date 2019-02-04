<?php


if ($_POST['action'] == 'charts'){
	ini_set('memory_limit',-1);
	require '../classes/class-gxb-charts.php';
	$gxb_charts = new GXB_Charts();
	$f_name = str_replace('-','_',$_POST['function_name']).'_callback';
	die($gxb_charts->$f_name());
}

?>