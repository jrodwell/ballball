<?php
/*
Plugin Name: Follow BallBall
Plugin URI: http://www.ostmodern.co.uk
Description: Multilingual follow plugin for ballball.com
Version: 0.1
Author: John Rodwell
Author URI: http://www.bashthekeyboard.co.uk
License: GPL2
*/

class BallBall_Follow extends WP_Widget {
	
  // Constructor
  function BallBall_Follow() {
		parent::WP_Widget(false, $name = 'Follow BallBall');
	}
	
	function widget($args, $instance) {
    extract($args);
    $title = apply_filters('widget_title', $instance['title']);
    $id = $args['widget_id'];
    echo $before_widget; ?>
    
    <h4 class="widgettitle">
      Follow BallBall
    </h4>
    
    <div id="follow-container">
      
      <p><a href="https://twitter.com/ballball" class="twitter-follow-button" data-show-count="false" data-size="large" data-lang="<?php echo ICL_LANGUAGE_CODE; ?>">Follow @ballball</a></p>
      
      <p><div class="fb-like" data-href="<?php echo get_bloginfo('url'); ?>" data-width="120" data-show-faces="false" data-send="false"></div></p>
      
      <p><div href="<?php echo get_bloginfo('url'); ?>" class="g-plusone" data-annotation="inline" data-width="300"></div></p>
          
    </div>
    
    <?php
    echo $after_widget;
  }
  
  function update($new_instance, $old_instance) {
  	$instance = $old_instance;
  	$instance['title'] = strip_tags($new_instance['title']);
  	$instance['tagname'] = strip_tags($new_instance['tagname']);
    return $instance;
  }
  
  // Admin form
	function form($instance) {
    $title = esc_attr($instance['title']);
    ?>
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
    </p>
    <?php
  }
	
}

function load_ballball_follow_widget() {
	register_widget('BallBall_Follow');
}

add_action('widgets_init', 'load_ballball_follow_widget');
 
?>
