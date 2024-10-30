<?php
/*
Plugin Name: Cook'd
Plugin URI: http://cookd.it/
Description: Add Cook'd social button and allow readers to publish their photos to your recipe post.
Version: 0.7.0
Author: Cooklet
Author URI: http://www.cooklet.com/
License: GPL2
*/

/*  Copyright 2014  Cooklet  (email : cookd@cooklet.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*I18N*/

function cookd_init() {
 load_plugin_textdomain( 'cookd', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action('plugins_loaded', 'cookd_init');


function load_custom_wp_admin_js() {
	wp_register_style( 'cookd_style', plugins_url( 'style.css' , __FILE__ ) );
	wp_enqueue_style( 'cookd_style' );
	wp_register_script( 'custom_wp_admin_js', plugins_url( '/js/admin.js' , __FILE__ ) );
	wp_enqueue_script( 'custom_wp_admin_js' );
	wp_register_script( 'custom_wp_popup_js', plugins_url( '/js/popup.js' , __FILE__ ) );
	wp_enqueue_script( 'custom_wp_popup_js' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_js' );


/*admin panel in menu*/
function cookd_menu() {
	//add_options_page( 'Cook\'d Options', 'Cook\'d', 'manage_options', 'cookd', 'cookd_options' );
	$icon_url = plugins_url( 'images/icon.png' , __FILE__ );
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	add_menu_page( 'Cook\'d Options', 'Cook\'d', 'manage_options', 'cookd', 'cookd_options', $icon_url);

}
add_action( 'admin_menu', 'cookd_menu' );


function cookd_options() {

/*save changes*/

   $changes='';
   $args = array(
	'posts_per_page'   => 30,
	'offset'           => 0,
	'category'         => '',
	'orderby'          => 'post_date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
    
   $posts_array = get_posts( $args );

if ($_REQUEST['save']=='1') {

  if ( ! update_option('singleonly', $_REQUEST['singleonly']))  add_option('singleonly', $_REQUEST['singleonly']); 
  if ( ! update_option('wherecookd', $_REQUEST['wherecookd']))  add_option('wherecookd', $_REQUEST['wherecookd']); 
  if ( ! update_option('email', str_replace("\'","'",$_REQUEST['email'])))  add_option('email', $_REQUEST['email']); 
  if ( ! update_option('befirst', str_replace("\'","'",$_REQUEST['befirst'])))  add_option('befirst', $_REQUEST['befirst']); 
  if ( ! update_option('blogtag', str_replace("\'","'",$_REQUEST['blogtag'])))  add_option('blogtag', $_REQUEST['blogtag']); 
  if ( ! update_option('fbid', $_REQUEST['fbid']))  add_option('fbid', $_REQUEST['fbid']); 
  if ( ! update_option('fbpage', $_REQUEST['fbpage']))  add_option('fbpage', $_REQUEST['fbpage']); 
  if ( ! update_option('fbtag', str_replace("\'","'",$_REQUEST['fbtag'])))  add_option('fbtag', $_REQUEST['fbtag']); 
 
   $blog = md5(get_bloginfo('wpurl'));
  $changes = "<div id='setting-error-settings_updated' class='changes updated settings-error' blog='$blog'><strong>".__( "Changes saved", "cookd" )."</strong></div>";
}





	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}


   
   $hidden='';
   
   
    echo "<div class='cookdwrap'>";
      echo $changes;
?>
      <p class="description"><?php _e( "Let's see what you can change here", "cookd" ) ?></p>
      <form method="post">
      <table class="form-table">

        <tr valign="top">
        <th scope="row"><label for="email"><?php _e("email", "cookd" ) ?></label></th>
        <td><input type='text' name='email' id='email'  class="regular-text"  value="<?php echo get_option('email'); ?>"/></td>
        </tr>
        <tr valign="top">
        <th scope="row"><label for="blogtag"><?php _e("Maybe new welcome message?", "cookd" ) ?></label></th>
        <td><textarea name="blogtag" id="blogtag" class="regular-text" ><?php echo get_option('blogtag'); ?></textarea>
        <p class="description"></p></td>
        </tr>
        <tr valign="top">
        <th scope="row"><label for="befirst"><?php _e("be first message?", "cookd" ) ?></label></th>
        <td><textarea name="befirst" id="befirst" class="regular-text" ><?php echo get_option('befirst'); ?></textarea></td>
        </tr>
        <tr valign="top">
        <th scope="row"><label for="fbpage"><?php _e("We need your facebook page ID for tagging", "cookd" ) ?></label></th>
        <td><input type='text' name='fbpage' id='fbpage'  class="regular-text"  value="<?php echo get_option('fbpage'); ?>"/></td>
        </tr>
        <tr valign="top">
        <th scope="row"><label for="fbid"><?php _e("facebookID", "cookd" ) ?></label></th>
        <td><input type='text' name='fbid' id='fbid'  class="regular-text"  value="<?php echo get_option('fbid'); ?>"/></td>
        </tr>
        <tr valign="top">
        <th scope="row"><label for="fbtag"><?php _e("Maybe new facebook share message?", "cookd" ) ?></label></th>
        <td><textarea name="fbtag" id="fbtag" class="regular-text" ><?php echo get_option('fbtag'); ?></textarea>
        </tr>

        <tr valign="top">
        <th scope="row"><label for="wherecookd"><?php _e("If you'll not add shortcode [cookd] to the post, the button will automatically show at the:", "cookd" ) ?></label></th>
        <td class='wherecookd' last='<?php echo get_option('wherecookd')?>'>
         <input type='radio' name='wherecookd' value='top'/> <?php _e("beginning", "cookd" ) ?><br/>
         <input type='radio' name='wherecookd' value='bottom'/> <?php _e("end", "cookd" ) ?>        
        </tr>

        <tr valign="top">
        <th scope="row"><label for="singleonly"><?php _e("singleonly", "cookd" ) ?></label></th>
        <td class='singleonly' last='<?php echo get_option('singleonly')?>'>
         <input type='radio' name='singleonly' value='false'/> <?php _e("no", "cookd" ) ?> <br/>
         <input type='radio' name='singleonly' value='true'/> <?php _e("yes", "cookd" ) ?>
        </tr>

      </table>      

        <input type='hidden' name='save' value='1'/>
        <input type='hidden' name='page' value='cookd'/>

        <input type='hidden' name='lang' id='lang' value='<?php echo str_replace("-","_",get_bloginfo('language')); ?>'/>
        <input type='hidden' name='blogname' id='blogname' value='<?php echo get_bloginfo('name'); ?>'/>
        <input type='hidden' name='url' id='url' value='<?php echo get_bloginfo('wpurl'); ?>'/>
        
        <?php submit_button(); ?>  
      </form>
      
  <form enctype="multipart/form-data" id="upload-form" class="wp-upload-form" method="post" action="">
	<p>
		<label for="upload"><?php _e("Change profile picture", "cookd" ) ?></label><br>
		<input type="file" id="upload" name="import">
		<input type="hidden" name="action" value="save">
		<input type="submit" name="submit" id="submit" class="button" value="<?php _e("Upload image", "cookd" ) ?>">
	</p>
	
	</form>
      
        
<?php

    if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
    $uploadedfile = $_FILES['import'];
    $upload_overrides = array( 'test_form' => false );
    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
    $new='';
    if ( $movefile['url'] ) {
        if ( ! update_option('foto', $movefile['url']))  add_option('foto', $movefile['url']); 
        $blog = md5(get_bloginfo('wpurl'));
        $new='blog="'.$blog.'"';
    } 
    if (get_option('foto')) echo '<img id="cookdprofpic" '.$new.' src="'.get_option('foto').'" alt=""/>';
      
    echo "</div>";

}




/*shortcode*/

function cookd_add_button() {

/*$ajaxJS = "
    <script type='text/javascript'>

    function load(url, callback) {
        var xhr;
        
        if(typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest();
        else {
          var versions = ['MSXML2.XmlHttp.5.0', 
                  'MSXML2.XmlHttp.4.0',
                    'MSXML2.XmlHttp.3.0', 
                    'MSXML2.XmlHttp.2.0',
                  'Microsoft.XmlHttp'];

           for(var i = 0, len = versions.length; i < len; i++) {
            try {
              xhr = new ActiveXObject(versions[i]);
              break;
            }
            catch(e){}
           } // end for
        }
        
        xhr.onreadystatechange = ensureReadiness;
        
        function ensureReadiness() {
          if(xhr.readyState < 4) {
            return;
          }
          
          if(xhr.status !== 200) {
            return;
          }

           all is well	
          if(xhr.readyState === 4) {
            callback(xhr);
          }			
        }
        
        xhr.open('GET', url, true);
        xhr.send('');
      }      
      
    </script>
";
*/

$ajaxJS = " <script type='text/javascript'> function load(url, callback) { var xhr; if(typeof XMLHttpRequest !== 'undefined') xhr = new XMLHttpRequest(); else { var versions = ['MSXML2.XmlHttp.5.0', 'MSXML2.XmlHttp.4.0', 'MSXML2.XmlHttp.3.0', 'MSXML2.XmlHttp.2.0', 'Microsoft.XmlHttp']; for(var i = 0, len = versions.length; i < len; i++) { try { xhr = new ActiveXObject(versions[i]); break; } catch(e){} } } xhr.onreadystatechange = ensureReadiness; function ensureReadiness() { if(xhr.readyState < 4) { return; } if(xhr.status !== 200) { return; } if(xhr.readyState === 4) { callback(xhr); } } xhr.open('GET', url, true); xhr.send(''); } </script> ";



  $snippet = "";
  
 if ((get_post_meta(get_the_ID(),'cookdopt',true)!='out') && ((is_single()) || (get_option('singleonly')!='true'))) {
  $recipe = get_permalink();
  $blog = get_bloginfo('wpurl');
  
/*   $snippet = "
    <script type='text/javascript' src='http://cookd.it/embed/cookd.js'></script> 
    $ajaxJS
    <script type='text/javascript'>
    var url='http://cookd.it/embed/ajax.php?action=check&recipe=$recipe&blog=$blog';
    url=url.replace(/#038;/g,'');
    load(url, function(xhr) {

         if (xhr.responseText!='Unknown blog') {         
            insertCookd(xhr.responseText);
          } else {
            document.getElementById('".md5($recipe)."').innerHTML ='Cook\'d: ".__( 'Unknown blog', 'cookd' )."';
          }

    });        
    </script> 
    <div id='".md5($recipe)."' lang='".get_locale()."' class='cookd-bar'></div>
	"; */

$snippet = " <script type='text/javascript' src='http://cookd.it/embed/cookd.js'></script> $ajaxJS <script type='text/javascript'> var url='http://cookd.it/embed/ajax.php?action=check&recipe=$recipe&blog=$blog'; url=url.replace(/#038;/g,''); load(url, function(xhr) { if (xhr.responseText!='Unknown blog') { insertCookd(xhr.responseText); } else { document.getElementById('".md5($recipe)."').innerHTML ='Cook\'d: ".__( 'Unknown blog', 'cookd' )."'; } }); </script> <div id='".md5($recipe)."' lang='".get_locale()."' class='cookd-bar'></div> "; 	 
	   
  }  
  return $snippet;
}

add_shortcode('cookd', 'cookd_add_button');




/*content filter*/


function cookd_content_filter( $content ) {

  if ( !$content ) {
    $content = get_the_content();
  }

    if ( (get_post_meta(get_the_ID(),'cookdopt',true)!='out') && (!strstr($content,"[cookd]")) && (in_the_loop()) ) {

      if (get_option('wherecookd')=='top') {
        $content = "[cookd] ".$content ;
      } else {
        $content .= " [cookd]" ;
      }
    }


  return $content;
}


add_filter( 'the_content', 'cookd_content_filter' );


/* editor button*/


function cookd_addbuttons() {
   // Only do this stuff when the current user has permissions and we are in Rich Editor mode
   if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
     add_filter("mce_external_plugins", "add_cookd_tinymce_plugin");
     add_filter('mce_buttons', 'register_cookd_button');
   }
}
 
function register_cookd_button($buttons) {
   array_push($buttons, "separator", "cookd_button");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_cookd_tinymce_plugin($plugin_array) {
   $plugin_array['cookd_button'] = plugins_url( '/js/editor_plugin.js' , __FILE__ );
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'cookd_addbuttons');




// add column to wp-admin/edit.php

// ADD NEW COLUMN
function cookd_columns_head($defaults) {
	$defaults['cookd'] = '[cookd]';
	return $defaults;
}

// SHOW THE FEATURED IMAGE
function cookd_columns_content($column_name, $post_ID) {
	if ($column_name == 'cookd') {
		echo "<a href='#' postid='$post_ID' class='postcookd' cookdopt='".get_post_meta($post_ID,'cookdopt',true)."'></a><a href='.cookd-popup' recipe='".md5(get_permalink( $post_ID ))."' class='cookd_button' name='modal'>".__( 'Uploads', 'cookd' )."</a>";
	}
}


add_filter('manage_posts_columns', 'cookd_columns_head');  
add_action('manage_posts_custom_column', 'cookd_columns_content', 10, 2);  
// ...and for pages
add_filter('manage_pages_columns', 'cookd_columns_head');  
add_action('manage_pages_custom_column', 'cookd_columns_content', 10, 2);  


?>
