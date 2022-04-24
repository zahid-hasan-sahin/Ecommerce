<?php
require_once("../../include/initialize.php");
  	
if (!isset($_SESSION['CUSID'])) {
	redirect(web_root . "customer/indexe.php");
}


$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
$header=$view;
$title="Settings";
switch ($view) {
	case 'list' :
		$content    = 'list.php';		
		break;

	case 'add' :
		$content    = 'setDeliveryFee.php';		
		break;

	case 'edit' :
		$content    = 'setDeliveryFee.php';		
		break;
    case 'view' :
		$content    = 'view.php';		
		break;

	default :
		$content    = 'setting.php';		
}
require_once ("../theme/templates.php");
