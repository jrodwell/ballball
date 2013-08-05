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
	$hook_suffix = add_menu_page('Promoted Content', 'Promoted Content', 'manage_options', 'my-unique-identifier', 'promoted_content');
	add_action('load-'.$hook_suffix, 'promoted_content_load_function');
}

function promoted_content_load_function() {
  
  if(!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
  
  // Use POST variable to set options...

}

function promoted_content() {

	if(!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

  ?>
    
  <script type="text/javascript">
  $(document).ready(function() {
    $("#add").click(function() {
      $('#promoted_content_form select:last').clone(true).insertAfter('#promoted_content_form select:last');
      return false;
    });
  });
  </script>
  
  <h2>BallBall Promoted Content</h2>
  
  <form action="" method="post" name="promoted_content_form" id="promoted_content_form">
  
  <p><a id="add"><img src="" alt="Add Field" /></a></p>
  
  <select name="post_ids[]">
  
  <?php
  
  // New repeater fields format here... or multiple selects?
  
  ?>
  
  </select>
  
  <p><input type="submit" name="submit" id="submit" value="Submit" /></p>
  </form>

  <?php

}

?>
