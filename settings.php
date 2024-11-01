<?php
/**
 * Settings.
 *
 * @author Dave Ligthart <info@daveligthart.com>
 * @package wct
 * @subpackage view
 * @version 0.1
 */
?>
    <div class="wrap">
        <h2><?php _e('WP-Choose-Thumb', 'wct'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'wct-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Add thumbnail CSS', 'wct'); ?></th>                  
                    <td><textarea name="wct_styling" rows="5" cols="40"><?php echo get_option('wct_styling'); ?></textarea>
                    <p><?php _e('Add extra CSS styling for thumbnail. e.g. padding:10px; border:1px solid red; ', 'wct'); ?></p></td>                  
                </tr>
                 <tr valign="top">
                    <th scope="row"><?php _e('Add no thumbnail HTML', 'wct'); ?></th>                  
                    <td><textarea name="wct_nothumb" rows="5" cols="40"><?php echo get_option('wct_nothumb'); ?></textarea>
                    <p><?php _e('When no thumbnail is selected, display HTML.', 'wct'); ?></p></td>                  
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    
   <a style="float:left; margin-right:10px;" href="http://daveligthart.com" target="_blank" title="<?php _e('Like'); ?>"><img src="<?php echo plugin_dir_url(__FILE__); ?>/resources/images/thumbsup.png" width="32" height="32" alt="<?php _e('I Like', 'wct'); ?>" /></a>
 
   <div style="margin:15px 0px;"> 
   		<span><?php _e('By', 'wct'); ?></span>  <a href="http://daveligthart.com" target="_blank" title="<?php _e('Created by DaveLigthart.com', 'wct'); ?>"><span>Dave</span> <span>Ligthart</span></a>
    
    	<cite><?php _e('Happy to be of service.', 'wct'); ?></cite> 
   </div>
