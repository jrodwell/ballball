<?php
/*
Plugin Name: BallBall Promoted Content
Plugin URI: http://www.ostmodern.co.uk
Description: Allows the selection of promoted content on ballball.com homepage
Version: 0.1
Author: John Rodwell
Author URI: http://www.bashthekeyboard.co.uk
License: GPL2
*/

add_action('admin_menu', 'ballball_promoted_content_plugin_menu');

function ballball_promoted_content_plugin_menu() {
	$hook_suffix = add_menu_page('Promoted Content', 'Promoted Content', 'manage_options', 'promoted-content', 'promoted_content');
	add_action('load-'.$hook_suffix, 'promoted_content_load_function');
}

function promoted_content_load_function() {
  
  if(!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
  
  if($_POST['submit']) {
    if(isset($_GET['tab'])) $lang = $_GET['tab']; else $lang = 'en';
    $add_postids = array();
    foreach($_POST['post_ids'] as $post_id) {
      if($post_id!=0) $add_postids[] = $post_id;
    }
    update_option('promoted_postids_'.$lang, $add_postids);
  }
  
}

function promoted_content() {

	if(!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

  ?>
    
  <script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#add").click(function() {
      jQuery('.post_select:last').clone(true).insertAfter('.post_select:last');
      return false;
    });
    jQuery(".remove").click(function() {
      jQuery(this).parent().remove();
      return false;
    });
  });
  </script>
  
  <?php
  
  if(isset($_GET['tab'])) admin_tabs($_GET['tab']); else admin_tabs('en');
  
  ?>
  
  <h2>BallBall Promoted Content</h2>
  
  <?php
  
  if(isset($_GET['tab'])) $tab = $_GET['tab']; else $tab = 'en';

  ?>
  
  <form action="" method="post" name="promoted_content_form" id="promoted_content_form">
  
  <p><a href="#" id="add"><img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/add.png" alt="Add Field" /></a></p>
  
  <?php
  
  $post_ids = get_option('promoted_postids_'.$tab, false);
  foreach($post_ids as $post_id) {
  
  ?>
  
  <p class="post_select"><select name="post_ids[]">
  
  <option value="">Please choose content to promote...</option>
  
  <?php
  
  $args = array(
    'post_type' => array('post', 'post_set'),
    'posts_per_page' => -1
  );
  $custom_query = new WP_Query($args); 
   
  ?>
  
  <?php if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

  <option value="<?php echo get_the_ID(); ?>"<?php if(get_the_ID()==$post_id) echo ' selected="selected"'; ?>><?php echo get_the_title(); ?></option>

  <?php endwhile; endif; ?>
  
  </select><a href="#" class="remove"><img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/remove.png" alt="Remove Field" style="margin-bottom: -9px;" /></a></p>
  
  <?php } ?>
  
  <p class="post_select"><select name="post_ids[]">
  
  <option value="">Please choose content to promote...</option>
  
  <?php
  
  $args = array(
    'post_type' => array('post', 'post_set'),
    'posts_per_page' => -1
  );
  $custom_query = new WP_Query($args); 
   
  ?>
  
  <?php if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

  <option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>

  <?php endwhile; endif; ?>
  
  </select><a href="#" class="remove"><img src="<?php echo get_stylesheet_directory_uri(); ?>/library/images/remove.png" alt="Remove Field" style="margin-bottom: -9px;" /></a></p>
  
  <p><input type="submit" name="submit" id="submit" value="Submit" /></p>
  
  </form>
  
  <?php

}

function admin_tabs($current='en') {
  $tabs = array('en' => 'English', 'ja' => 'Japanese', 'id' => 'Indonesian', 'vi' => 'Vietnamese');
  echo '<div id="icon-themes" class="icon32"><br></div>';
  echo '<h2 class="nav-tab-wrapper">';
  foreach($tabs as $tab => $name) {
    $class = ( $tab == $current ) ? ' nav-tab-active' : '';
    echo "<a class='nav-tab$class' href='?page=promoted-content&tab=$tab'>$name</a>";
  }
  echo '</h2>';
}

?>
