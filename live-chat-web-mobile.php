<?php
	/*
	Plugin Name: Live chat web mobile
	Description: Plugin for live chat web mobile iframe.
	Version: 1.1
	Author: EMT.
	Author URI: http://www.8mobile8.com
	*/

	define('IFRAME_PLUGIN_VERSION', '1.1');

	add_action('wp_footer', 'lcwm_add_chat_function_name');
	function lcwm_add_chat_function_name()
	{
	?>
	<div class="lcmw-widget" id="lcmw-widget" data-state="closed" style="opacity: 1;visibility: visible;z-index: 2147483639;position: fixed;bottom: 0px;right: 0px;width: 320px;height: 50%;max-width: 100%;max-height: 500px;background-color: transparent;border: 0px none;overflow: hidden;">
		<div class="lcmw-container" style="position: absolute;top: 0px;right: 0px;bottom: 0px;left: 0px;width: 100%;height: 100%;margin: 0px;padding: 0px;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;border: 0px none;float: none;">
			<iframe id="rocketchat-iframe" src="http://8mobile8.com/Livechat/?depId=<?php
		echo get_option('dep_id');
	?>" style="width:100%;height:100%;border:none;background-color:transparent" allowtransparency="true"></iframe>
		</div>
		<div class="lcmw-overlay"></div>
	</div>
	 <script>
		window.addEventListener('message', function(event) {
		  document.getElementById('lcmw-widget').style.height=event.data;
		});
	  </script>
	<?php
	}


	add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'lcwm_add_action_links');

	function lcwm_add_action_links($links)
	{
		$mylinks = array(
			'<a href="' . admin_url('options-general.php?page=live-chat-web-mobile/live-chat-web-mobile.php') . '">Settings</a>'
		);
		return array_merge($links, $mylinks);
	}


	// create custom plugin settings menu
	add_action('admin_menu', 'lcwm_plugin_create_menu');

	function lcwm_plugin_create_menu()
	{
		
		//create new top-level menu
		add_menu_page('Live chat web mobile', 'Chat Settings', 'administrator', __FILE__, 'lcwm_plugin_settings_page', 'dashicons-format-chat');
		
		//call register settings function
		add_action('admin_init', 'register_lcwm_plugin_settings');
	}


	function register_lcwm_plugin_settings()
	{
		//register our settings
		register_setting('lcwm-plugin-settings', 'dep_id');
	}

	function lcwm_plugin_settings_page()
	{
	?>
	<div class="wrap">
	<h1>Live chat web mobile</h1>

	<form method="post" action="options.php">
		<?php
		settings_fields('lcwm-plugin-settings');
	?>
	  <?php
		do_settings_sections('lcwm-plugin-settings');
	?>
	  <table class="form-table">
			<tr valign="top">
			<th scope="row">Department Id</th>
			<td><input type="text" name="dep_id" value="<?php
		echo esc_attr(get_option('dep_id'));
	?>" /></td>
			</tr>
			 
			
		</table>
		
		<?php
		submit_button();
	?>

	</form>
	</div>
	<?php
	}
?>