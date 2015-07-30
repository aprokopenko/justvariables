<?php
	
	/**
	 *	init admin for just variables page
	 */
	function jv_admin_menu(){
		add_options_page(__('Just Variables', JV_TEXTDOMAIN), __('Just Variables', JV_TEXTDOMAIN), 'manage_options', 'just_variables', 'jv_admin_settings_page');
	}
	
	/**
	* Properly enqueue styles and scripts for our theme options page.
	*/
	add_action( 'admin_print_styles', 'jv_admin_styles' );
	function jv_admin_styles( $hook_suffix ) {
		wp_enqueue_style( 'just_variables', plugins_url( 'assets/styles.css' , __FILE__ ) );
	}

	add_action( 'admin_print_scripts', 'jv_admin_scripts' );
	function jv_admin_scripts( $hook_suffix ) {
		wp_enqueue_script( 'just_variables',
				plugins_url( 'assets/settings_page.js' , __FILE__ ),
				array( 'jquery', 'jquery-ui-sortable' ) );
		
		// add text domain
		wp_localize_script( 'just_variables', 'text_just_variables', jv_get_language_strings() );
	}
	
	/**
	 *	translation strings for javascript
	 */
	function jv_get_language_strings(){
		$strings = array(
			'confirm_delete' => __('Are you sure you want to delete selected field?', JV_TEXTDOMAIN),
		);
		return $strings;
	}
	
	/**
	 *	show variables settings page
	 */
	function jv_admin_settings_page(){
		//$post_types = jv_get_post_types( 'object' );
		$jv_read_settings = jv_get_read_settings();
		$jv_multisite_settings = jv_get_multisite_settings();
		$jv_tabs = !isset($_GET['tab']) ? 'fields' : $_GET['tab'];
		// Form submit processing
		if( !empty($_POST['submitted']) && !empty($_POST['jv_settings']) ){
			
			$post = $_POST['jv_settings'];
			// update database with new values
			$variables = array();
			if( !empty($post['slug']) ){
				foreach($post['slug'] as $key => $slug){
					if( $key == 0 ) continue; // 0 index is empty row for copy
					
					$variables[ $slug ] = array(
						'type' => $post['type'][$key],
						'slug' => $post['slug'][$key],
						'name' => $post['title'][$key],
						'default' => $post['default'][$key],
					);
					
				}
				//pa($variables,1);
				
				// update DB
				jv_update_options('jv_variables', $variables);
				
				// check if we have variables - if no - delete all values
				if( empty($variables) ){
					update_option('jv_values', array());
				}
			}
		}
		if( !empty($_POST['jv_update_settings']) ) {
			if( MULTISITE ){
				$jv_multisite_settings = jv_save_multisite_settings( $_POST['jv_multisite_setting'] );
			}
			$jv_read_settings = jv_update_read_settings();
		}
		$variables = jv_get_options('jv_variables', array());
		
		// load template
		include( JV_ROOT . '/templates/settings_page.tpl.php' );
	}

/**
 *	Save miltisite settings from the form
 *	@param string $settings Multisite settings in present time
 *	@return string New multisite settings
 */
function jv_save_multisite_settings( $new_value ){
	$current_value = jv_get_multisite_settings();
	$new_value = trim($new_value);
	if( $current_value ){
		$saved = update_site_option( 'jv_multisite_setting', $new_value );
	}
	else{
		$saved = add_site_option( 'jv_multisite_setting', $new_value );
	}

	if( $saved ){
		jv_add_admin_notice('notice', __('<strong>MultiSite settings</strong> has been updated.', JV_TEXTDOMAIN));
	}

	return $new_value;
}

/**
 *	Get multisite settings
 *	@return string Return multisite settings
 */
function jv_get_multisite_settings(){
	if( MULTISITE && $multisite_setting = get_site_option('jv_multisite_setting') )
	{
		return $multisite_setting;
	}
	return JV_CONF_MS_SITE;
}

/**
 *	Get options with wp-options
 *	@param string $key Option name
 *	@return array Options with $key
 */
function jv_get_options($key){
	$jv_multisite_settings = jv_get_multisite_settings();
	return $jv_multisite_settings == 'network' ? get_site_option($key, array()) : get_option($key, array());
}

/**
 *	Update options with wp-options
 *	@param string $key Option name
 *	@param array $value Values with option name
 *	@return bollean
 */
function jv_update_options($key, $value){
	$jv_multisite_settings = jv_get_multisite_settings();
	$jv_multisite_settings == 'network' ? update_site_option($key, $value) : update_option($key, $value);
	return true;
}
?>