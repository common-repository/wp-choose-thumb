<?php
/**
 * Thumb loader.
 * @version 0.2
 * @author dligthart <info@daveligthart.com>
 * @package wp-choose-thumb
 */
require( dirname(__FILE__) . '/../../../wp-load.php' ); // wordpress context.


/**
 * wct_output_thumb function.
 * 
 * @access public
 * @param mixed $id
 * @param mixed $child
 * @param mixed $post_childs
 * @return void
 */
function wct_output_thumb($id, $child, $post_childs) {
	$item = $post_childs[$child];
	$thumb = trim(wp_get_attachment_thumb_url($item->ID));
	$wct_thumb = trim(get_post_meta($id, 'wct_thumb', true));
	$checked = '';
	//echo $wct_thumb . ':' . $thumb;
	//echo '<br/>';
	if($wct_thumb == $thumb) {
		$checked = ' checked="checked"';
	}
	echo '<img src="'.$thumb.'" alt="thumb" style="width:50px;display:block;clear:both;"/>';
	echo '<input type="radio" class="alignleft" style="display:inline;" name="wct_thumb" value="'.$thumb.'"'.$checked.'> '. $item->post_name . '<br/>';
	echo '<input type="hidden" name="wct_thumb_id" value="'.$item->ID.'" />';
}


/**
 * wct_output_none function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
function wct_output_none($id) {
	$checked = '';
	
	$src = trim(get_post_meta($id, 'wct_thumb',true));
	
	$hasThumb = ('' != $src && 'none' != $src);
	
	if(!$hasThumb) {
		$checked = ' checked="checked"';
	}
	
	//echo '<img src="'.$thumb.'" alt="thumb" style="width:50px;display:block;clear:both;"/>';
	echo '<input type="radio" class="alignleft" style="display:inline;" name="wct_thumb" value="none"'.$checked.'> '. __('none', 'wct') . '<br/>';
	echo '<input type="hidden" name="wct_thumb_id" value="-1" />';
}


/**
 * wct_load_child_thumbs function.
 * 
 * @access public
 * @param mixed $id
 * @return void
 */
function wct_load_child_thumbs($id) {
	if(null != $id && $id > 0){
		$post_childs = get_children('post_parent=' . $id .'&post_type=attachment&post_mime_type=image&orderby=date');
		if($post_childs){
			
			wct_output_none($id);
			
			$keys = array_keys($post_childs);
			foreach($keys as $child) {
				wct_output_thumb($id, $child, $post_childs);
			}
		}
	}
}


/**
 * wct_load_thumbs function.
 * 
 * @access public
 * @return void
 */
function wct_load_thumbs() {
	$id = $_REQUEST['id']; //post id.
	$offset = $_REQUEST['offset'];

	if($id > 0){
		wct_load_child_thumbs($id);
	} elseif($id == 0 || '' == $id){
		$posts = get_posts('numberposts=1&orderby=date&offset='.$offset . '&post_status='); // load images from the first 5 posts.
		if($posts){
			foreach($posts as $p) {
				wct_load_child_thumbs($p->ID);
			}
		}
	}

	if($offset > 0) {
		echo __('Results') . ' ' . ($offset + 1);
	}
}

wct_load_thumbs();
?>