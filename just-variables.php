<?php
/*
Plugin Name: Just Variables for Wordpress
Plugin URI: http://justcoded.com/just-labs/just-wordpress-theme-variables-plugin/
Description: This plugin add custom page with theme text variables to use inside the templates.
Tags: theme, variables, template, text data
Author: Alexander Prokopenko
Author URI: http://justcoded.com/
Version: 1.1
Donate link: http://justcoded.com/just-labs/just-wordpress-theme-variables-plugin/#donate
*/

define('JV_ROOT', dirname(__FILE__));
define('JV_TEXTDOMAIN', 'just-wp-variables');
define('JV_CONF_MS_SITE', 'site');
define('JV_CONF_MS_NETWORK', 'network');

if(!function_exists('pa')){
function pa($mixed, $stop = false) {
	$ar = debug_backtrace(); $key = pathinfo($ar[0]['file']); $key = $key['basename'].':'.$ar[0]['line'];
	$print = array($key => $mixed); echo( '<pre>'.htmlentities(print_r($print,1)).'</pre>' );
	if($stop == 1) exit();
}
}

require_once( JV_ROOT . '/just-variables.admin.php' );
require_once( JV_ROOT . '/just-variables.theme.php' );

/**
 *	plugin init
 */
add_action('plugins_loaded', 'jv_init');
function jv_init(){
	if( !is_admin() ) return;
	
	/**
	 *	load translations
	 */
	load_plugin_textdomain( JV_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	
	// add admin page
	add_action( 'admin_menu', 'jv_admin_menu' );
}

/*
 	functions for templates to print variables
 */

/**
 *	get actual value for variable
 *	@param string $var variable name
 *	@return string  return variable value or NULL
 */
function jv_get_variable_value( $var ){
	$values = get_option('jv_values');
	if( !empty($values[$var]) ){
		return $values[$var];
	}
	
	return NULL;
}


/**
 *	get actual value for variable
 *	@param string $var   variable name
 *	@param bool   $echo  print variable by default.
 *	@return string  return variable value or NULL
 */
function just_variable( $var, $echo = true ){
	$value = jv_get_variable_value( $var );
	if( !is_null($value) && $echo ){
		echo $value;
	}
	else{
		return $value;
	}
}

/**
 *	register custom shortcode to print variables in the content
 *	@param array $atts attributes array submitted to shortcode
 *	@return string  return parsed shortcode
 */
function just_variable_shortcode( $atts ){
	if( empty($atts['code']) ){
		return '';
	}
	else{
		return just_variable( $atts['code'], false );
	}
}
add_shortcode('justvar', 'just_variable_shortcode');

/**
 * add message to be printed with admin notice
 * @param string $type    notice|error
 * @param string $message  message to be printed
 */
function jv_add_admin_notice( $type, $message ){
	global $jv_notices;
	if( !$jv_notices )
		$jv_notices = array();
	
	$jv_notices[] = array($type, $message);
}

/**
 *	Function for update saving method
 *	@return string Return read method from file or database
 */
function jv_update_read_settings(){
	$current_value = jv_get_read_settings();
	$new_value = $_POST['jv_read_settings'];

	if( MULTISITE && ($_POST['jv_multisite_setting'] != JV_CONF_MS_NETWORK && $new_value == JV_CONF_SOURCE_FS_GLOBAL) ){
		jv_add_admin_notice('error', __('<strong>Settings storage update FAILED!</strong>. Your MultiSite Settings do not allow to set global storage in FileSystem', JCF_TEXTDOMAIN));
		return $current_value;
	}
}

/**
 *	Get read sttings
 *	@return string Return read method from file or database
 */
function jv_get_read_settings(){
	return get_site_option('jv_read_settings');
}
?>