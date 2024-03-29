<?php
try
{

	
	// define the site path __SITE_PATH : c:\xampp\htdocs\adv_mvc
	define ('__SITE_PATH', realpath(dirname(dirname(__FILE__))));
	
	// __SITE_URL : /adv_mvc/
 	define ('__SITE_URL', str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']));
	
	// __BASE_URL : /adv_mvc/
 	define ('__BASE_URL', __SITE_URL);
 	
 	define ('__ASSET_URL', __SITE_URL.'assets/');
 	
 	define ('__IMAGE_URL', __ASSET_URL.'images/');
 	define ('__CSS_URL', __ASSET_URL.'css/');
 	define ('__JS_URL', __ASSET_URL.'js/');
 	
	// the application directory path 
	define ('__APP_PATH', __SITE_PATH.'/application');
	define ('__VIEW_PATH', __APP_PATH.'/views');	
	define ('__LAYOUT_PATH', __SITE_PATH.'/layouts');
	define ('__HELPER_PATH', __APP_PATH.'/helpers');
	define ('__CONFIG_PATH', __APP_PATH.'/config');
	
	define ('__UPLOAD_DATA_PATH', realpath(dirname(__FILE__)) . '/data/upload/');
	
// 	$str = str_replace($_SERVER['DOCUMENT_ROOT'],"",__UPLOAD_DATA_PATH);
	
// 	echo "<pre>";
// 	print_r($str);
// 	echo "</pre>";
	
// 	echo "<pre>";
// 	print_r('/mvc-cms/public_html/data/upload/');
// 	echo "</pre>";
		
// 	die();
	
// 	echo "<pre>";
// 	print_r($_SERVER['DOCUMENT_ROOT']);
// 	echo "</pre>";
	
// 	echo "<pre>";
// 	print_r(__UPLOAD_DATA_PATH);
// 	echo "</pre>";
		
// 	die();	
	
	
	/*** include the helper ***/
 	$_autoload_helpers = array();
 	$config = NULL;
	
	require __SITE_PATH . '/startup.php';
	
 	/*** a new registry object ***/
 	$registry = new Registry();
 	
 	// Session
 	$oSession = new Session();
 	$registry->oSession = $oSession;
 	
	// Response
	$response = new Response();
	$response->addHeader('Content-Type: text/html; charset=utf-8');
	$registry->oResponse = $response; 

	// Config
	$registry->oConfig = $config; 
	
	// Parameter	
	$parameter = new Parameter();
	$registry->oParams = $parameter;
	
	// Initialize the FrontController
	$front = FrontController::getInstance();
	$front->setRegistry($registry);
	
	/*
		// Cau hinh cho cac action nay chay dau tien 
	$front->addPreRequest(new Request('run/first/action')); 
	$front->addPreRequest(new Request('run/second/action'));
	*/
	
	$front->dispatch();
	
	// Output
	$response->output();	
}
catch(MvcException $e)
{
	if($config->config_values['application']['display_errors'])
		show_error($e->getMessage());
	else 				
		//show a 404 page here
		show_404();
}
catch(Exception $e)
{
	die('FATAL : '.$e->getMessage().' : '.$e->getLine());
}
