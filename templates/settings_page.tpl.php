<?php
	$assets_path = WP_PLUGIN_URL.'/just-wp-variables/assets';
?>
<div class="wrap">
	<div class="icon32 icon32-posts-page" id="icon-edit"><br></div>
	<h2><?php _e('Just Variables', JV_TEXTDOMAIN); ?></h2>
	<p><?php _e('Create at least one variable to unblock "Theme Variables" page.', JV_TEXTDOMAIN); ?></p>
	
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ($jv_tabs == 'fields' ? 'nav-tab-active' : '');?>" href="?page=just_variables&amp;tab=fields"><?php _e('Fields', JV_TEXTDOMAIN); ?></a>
		<a class="nav-tab <?php echo ($jv_tabs == 'settings' ? 'nav-tab-active' : '');?>" href="?page=just_variables&amp;tab=settings"><?php _e('Settings', JV_TEXTDOMAIN); ?></a>
	</h2>
	
	<?php // Fields list ?>
	<?php if( $jv_tabs == 'fields' ): ?>
	<form action="?page=just_variables" method="post">
	<fieldset>
		<table id="jv_settings" class="wp-list-table widefat fixed">
			<thead>
				<tr>
					<th class="minwidth">&nbsp;</th>
					<th class="td_type"><?php _e('Type', JV_TEXTDOMAIN); ?></th>
					<th class="td_input"><?php _e('Variable', JV_TEXTDOMAIN); ?></th>
					<th class="td_input"><?php _e('Title', JV_TEXTDOMAIN); ?></th>
					<th class="td_input"><?php _e('Default Value', JV_TEXTDOMAIN); ?></th>
					<th class="minwidth">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr class="new_row">
					<td class="minwidth"><span class="drag-handle">move</span></td>
					<td class="td_type">
						<select name="jv_settings[type][]">
							<option value="text" selected="selected"><?php _e('Text Input', JV_TEXTDOMAIN); ?></option>
							<option value="textarea"><?php _e('Textarea', JV_TEXTDOMAIN); ?></option>
						</select>
					</td>
					<td class="td_input"><input type="text" name="jv_settings[slug][]" value="" class="regular-text" /></td>
					<td class="td_input"><input type="text" name="jv_settings[title][]" value="" class="regular-text" /></td>
					<td class="td_input"><input type="text" name="jv_settings[default][]" value="" placeholder="<?php _e('Default Value', JV_TEXTDOMAIN); ?>" class="regular-text" /></td>
					<td class="minwidth"><a href="#" class="delete_variable" title="<?php _e('Delete', JV_TEXTDOMAIN); ?>"><img src="<?php echo $assets_path; ?>/icon-delete.png" title="Delete" alt="Delete" /></a></td>
				</tr>
				<?php foreach($variables as $slug => $var) :?>
				<tr>
					<td class="minwidth"><span class="drag-handle">move</span></td>
					<td class="td_type">
						<select name="jv_settings[type][]">
							<option value="text" <?php echo selected($var['type'], 'text'); ?>><?php _e('Text Input', JV_TEXTDOMAIN); ?></option>
							<option value="textarea" <?php echo selected($var['type'], 'textarea'); ?>><?php _e('Textarea', JV_TEXTDOMAIN); ?></option>
						</select>
					</td>
					<td class="td_input"><input type="text" name="jv_settings[slug][]" value="<?php echo esc_attr($slug); ?>" class="regular-text" /></td>
					<td class="td_input"><input type="text" name="jv_settings[title][]" value="<?php echo esc_attr($var['name']); ?>" class="regular-text" /></td>
					<td class="td_input"><input type="text" name="jv_settings[default][]" value="<?php echo esc_attr($var['default']); ?>" placeholder="<?php _e('Default Value', JV_TEXTDOMAIN); ?>" class="regular-text" /></td>
					<td class="minwidth"><a href="#" class="delete_variable" title="<?php _e('Delete', JV_TEXTDOMAIN); ?>"><img src="<?php echo $assets_path; ?>/icon-delete.png" title="Delete" alt="Delete" /></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr><td colspan="6">
					<input id="jv_var_more" type="button" class="button-secondary" value="<?php _e('Add one more', JV_TEXTDOMAIN); ?>" />
				</td></tr>
			</tfoot>
		</table>
		
		<p class="submit">
			<input id="submit" class="button-primary" type="submit" value="<?php _e('Save Changes', JV_TEXTDOMAIN); ?>" name="submit">
		</p>
		
		<input type="hidden" name="submitted" value="1" />
	</fieldset>
	</form>
	
	<?php // Settings boxes ?>
	<?php elseif( $jv_tabs == 'settings' ): ?>
	<div class="jv_tab-content">
		<div class="jv_inner-tab-content" >
			<form action="<?php get_permalink(); ?>" id="jvform_settings" method="post" class="jv_form_horiz" onsubmit="return initSettings();">
				
				<?php if( MULTISITE ): ?>
					<div class="card pressthis">
						<h3 class="header"><?php _e('MultiSite settings:', JV_TEXTDOMAIN); ?></h3>
						<fieldset>
							<input type="radio" name="jv_multisite_setting" id="jv_setting_global" 
								   value="<?php echo JV_CONF_MS_NETWORK; ?>" <?php checked($jv_multisite_settings, JV_CONF_MS_NETWORK); ?> />
							<label for="jv_setting_global"><?php _e('Make fields settings global for all network', JV_TEXTDOMAIN); ?> </label><br />
							
							<input type="radio" name="jv_multisite_setting" id="jv_setting_each" 
								   value="<?php echo JV_CONF_MS_SITE; ?>" <?php checked($jv_multisite_settings, JV_CONF_MS_SITE); ?> />
							<label for="jv_setting_each"><?php _e('Fields settings are unique for each site', JV_TEXTDOMAIN); ?> </label><br /><br />
						</fieldset>
					</div>
				<?php endif; ?>
				
				<br /><br />
				<?php wp_nonce_field("just-nonce"); ?>
				<input type="submit" class="button-primary jv_update_settings" name="jv_update_settings" value="<?php _e('Save all settings', JV_TEXTDOMAIN); ?>" />
			</form>
		</div>
	</div>
	<?php endif; ?>	
</div>
