<?php
/*
 Plugin Name: WP-Choose-Thumb
 Plugin URI: http://daveligthart.com
 Description: A simple way to add a default thumbnail to your post.
 Version: 1.3.6
 Author: Dave Ligthart
 Author URI: http://daveligthart.com
 */

$wct_plugin_url = trailingslashit(get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );

if(is_admin()) {
	wp_enqueue_script('jquery');
}

add_action('plugins_loaded', create_function('', 'wct_load_textdomain();') );


if(is_admin()) { // admin actions
	add_action('admin_menu', 'wct_create_menu');
	add_action('admin_init', 'wct_register_options');
}

/**
 * wpcp_create_menu function.
 * 
 * @access public
 * @return void
 */
function wct_create_menu() {
	add_options_page('WP-Choose-Thumb', 'WP-Choose-Thumb', 'manage_options', 'wct_options', 'wct_render_settings_page');
}

/**
 * wpcp_register_options function.
 * 
 * @access public
 * @return void
 */
function wct_register_options() { 
	register_setting('wct-group', 'wct_styling');
	register_setting('wct-group', 'wct_nothumb');
}

/**
 * wpcp_render_settings_page function.
 * 
 * @access public
 * @return void
 */
function wct_render_settings_page() {
	require('settings.php');	
}


/**
 * wct_load_textdomain function.
 * 
 * @access public
 * @return void
 */
function wct_load_textdomain() {
	$locale = get_locale();
	if ( empty($locale) ){
		$locale = 'en_US';
	}
	$mofile = dirname (__FILE__)."/resources/locale/$locale.mo";
	load_textdomain ('wct', $mofile);
}

/**
 * wct_thumb function.
 * 
 * @access public
 * @param string $postId (default: '')
 * @return void
 */
function wct_thumb($postId = '') {
	
	wct_display_thumb('', $postId);
}


/** 
 * wct_display_thumb function. Display thumb. For use in theme.
 * 
 * @access public
 * @param string $style (default: '')
 * @param string $pid (default: '')
 * @param string $alt (default: 'thumbnail')
 * @param string $class (default: 'alignleft')
 * @return void
 */
function wct_display_thumb($style = '', $pid = '', $alt = 'thumbnail', $class = 'alignleft') {
	global $post;
	
	if('' == $pid){
		
		if(null != $post) {
			
			$pid = $post->ID;
		} 
		else {
		
			return;
		}
	}
	
	$temp = trim(stripslashes(get_option('wct_styling')));
	
	if($temp) {
		
		$style = ' style="'. $temp . '"';
	}

	$src = trim(get_post_meta($pid, 'wct_thumb',true));

	$hasThumb = ('' != $src && 'none' != $src);

	if($hasThumb) {
	
		echo '<img alt="'.$alt.'" src="'. $src .'" class="'.$class.'" '.$style.'/>';
	} 
	else {
		
		echo trim(stripslashes(get_option('wct_nothumb'))); 
	}

	return $hasThumb;
}

/**
 * wct_admin_head function.
 * 
 * @access public
 * @return void
 */
function wct_admin_head() {
	global $post;
	global $wct_plugin_url;
	?>

<script type="text/javascript" language="javascript">
/* <![CDATA[ */
/* WP-Choose-Thumb Javascript. http://daveligthart.com */

var wct_cur_offset = 0;

var wct_offset = 1;

/**
 * wct_load_thumb_next function.
 * 
 * @access public
 * @return void
 */
function wct_load_thumb_next(){
	wct_loading();
	wct_cur_offset = wct_cur_offset + wct_offset;
	wct_load();
}

/**
 * wct_load_thumb_prev function.
 * 
 * @access public
 * @return void
 */
function wct_load_thumb_prev() {
	if(wct_cur_offset >= wct_offset) {
		wct_loading();
		wct_cur_offset = wct_cur_offset - wct_offset;
		wct_load();
	}
}

/**
 * wct_load function.
 * 
 * @access public
 * @return void
 */
function wct_load() {
	wct_load_thumbs(<?php global $post; echo $post->ID; ?>);
}

/**
 * wct_loading function.
 * 
 * @access public
 * @return void
 */
function wct_loading() {
	jQuery('#wct_loading').show();
}

/**
 * wct_loaded function.
 * 
 * @access public
 * @return void
 */
function wct_loaded() {
	jQuery('#wct_loading').hide();

	if(wct_cur_offset > 0) {
		jQuery('#wct_prev').hide(); //;"show()";
	} else {
		jQuery('#wct_prev').hide();
	}
}

/**
 * wct_load_thumbs function.
 * 
 * @access public
 * @param mixed offset
 * @return void
 */
function wct_load_thumbs(offset) {
	if(offset > 0) {
		jQuery("#wct_thumbs").load("<?php echo $wct_plugin_url . '/wct-thumb-loader.php?id='; ?>" + offset,"",
			function (responseText, textStatus, XMLHttpRequest) {
				wct_loaded();
			}
		);
	}
}

/**
 * wct_init function.
 * 
 * @access public
 * @return void
 */
function wct_init() {
	wct_load_thumbs(<?php global $post; echo $post->ID; ?>);
	if(wct_cur_offset == 0) {
		jQuery('#wct_prev').hide();
	}
}
jQuery(document).ready(function(){
  wct_init();
});
/* ]]> */
</script>
<?php
}

/**
 * wct_init function.
 * 
 * @access public
 * @return void
 */
function wct_init() {
	if(function_exists('add_meta_box')){
		add_meta_box('wct_div', __('WP-Choose-Thumb'), 'wct_metabox', 'post', 'side');
	}
}


/**
 * wct_edit_post function.
 * 
 * @access public
 * @param string $pid (default: '')
 * @return void
 */
function wct_edit_post($pid = '') {
	$c = (trim($_POST['wct_thumb']));
	if('' != $pid && '' != $_POST['wct_thumb']) {
		$temp = (trim(get_post_meta($pid, 'wct_thumb', true)));
		if($c != $temp) { // should not be the same otherwise update is useless and a performance hog.
			delete_post_meta($pid, 'wct_thumb'); // Delete first then re-add to circumvent WP's built in post meta handling.
			update_post_meta($pid, 'wct_thumb', $c, true);
		}
	}
}


/**
 * wct_metabox function.
 * 
 * @access public
 * @return void
 */
function wct_metabox() {
	global $post;
	global $wct_plugin_url;
?>
<p class="sub"><?php _e('Choose thumbnail for post','wct'); ?>.
	<div class="navigation" style="padding-bottom: 10px; padding-left: 5px;">
	<a id="wct_prev" href=""
		onclick="javascript:wct_load_thumb_prev(); return false;"
		title="previous thumbs" class="alignleft"
		style="margin-right: 5px; display: none;"><?php _e('previous', 'wct'); ?></a>
	<a id="wct_next" href=""
		onclick="javascript:wct_load_thumb_next(); return false;"
		title="next thumbs" class="alignright" style="display: none;"><?php _e('next','wct'); ?></a>
	<a id="wct_refresh" href=""
		onclick="javascript:wct_load(); return false;" title="refresh thumbs"><?php _e('refresh', 'wct'); ?></a>
	</div>
</p>
<p id="wct_thumbs"><?php _e('Waiting for publish', 'wct'); ?>
	<div align="center" id="wct_loading"><img
		src="<?php echo $wct_plugin_url . '/resources/images/ajax-loader.gif'; ?>"
		alt="loading" /></div>
</p>
<?php
}
add_action('admin_head', 'wct_admin_head');
add_action('admin_menu', 'wct_init');
add_action('publish_post', 'wct_edit_post');
add_filter('edit_post', 'wct_edit_post');
?>