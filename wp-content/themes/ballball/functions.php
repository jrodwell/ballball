<?php
/*
Author: Eddie Machado (modified by J.R.)
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once('library/bones.php'); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
//require_once('library/custom-post-type.php'); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once('library/admin.php'); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
/*
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
*/

/* Custom image sizes here */

add_image_size('small', 140, 92, false);
add_image_size('stream', 220, 144, false);
add_image_size('article', 620, 413, false);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar',
		'name' => __('Sidebar', 'ballball'),
		'description' => __('The primary sidebar.', 'ballball'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __('Sidebar 2', 'bonestheme'),
		'description' => __('The second (secondary) sidebar.', 'bonestheme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<!-- end custom gravatar call -->
				<?php printf(__('<cite class="fn">%s</cite>', 'bonestheme'), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__('F jS, Y', 'bonestheme')); ?> </a></time>
				<?php edit_comment_link(__('(Edit)', 'bonestheme'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />
	<input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!


/* Include meta box class (J.R.) */

require_once("library/meta-box-class/my-meta-box-class.php");

/* Enqueue admin scripts (J.R.) */

add_action('admin_enqueue_scripts', 'ballball_queue_admin_scripts');

function ballball_queue_admin_scripts() {
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_script('jquery-ui-datetimepicker', get_stylesheet_directory_uri().'/library/js/libs/jquery-timepicker/jquery-ui-timepicker-addon.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'));     
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  wp_enqueue_style('jquery-style', get_stylesheet_directory_uri().'/library/js/libs/jquery-timepicker/jquery-ui-timepicker-addon.css');
}

/* Register menu (J.R.) */

add_action('init', 'ballball_register_menu');

function ballball_register_menu() {
  register_nav_menu('main-menu',__( 'Main Menu', 'ballball'));
}

<<<<<<< HEAD
=======
/* Custom excerpt 'read more' text */

add_filter('excerpt_more', 'ballball_excerpt_more');

function ballball_excerpt_more($more) {
	return ' <a class="read-more" href="'.get_permalink(get_the_ID()).'">'.__('Continue Reading &raquo;', 'ballball').'</a>';
}

>>>>>>> f132313597cbaca834aabab79ad0eeb45e982dbc
/* Custom post types (J.R.) */

add_action('init', 'ballball_add_post_types');

function ballball_add_post_types() {

  $labels = array(
    'name' => 'Post Sets',
    'singular_name' => 'Post Set',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Post Set',
    'edit_item' => 'Edit Post Set',
    'new_item' => 'New Post Set',
    'all_items' => 'All Post Sets',
    'view_item' => 'View Post Set',
    'search_items' => 'Search Post Sets',
    'not_found' =>  'No post sets found',
    'not_found_in_trash' => 'No post sets found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Post Sets'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array('slug' => 'post_set'),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title', 'editor', 'author', 'thumbnail'),
    'menu_position' => 5,
    'taxonomies' => array('post_tag', 'category', 'league', 'team', 'match')
  ); 

  register_post_type('post_set', $args);
  
}

/* Custom fields (J.R.) */

add_action('add_meta_boxes', 'ballball_add_custom_fields');
add_action('save_post', 'ballball_save_videoid');
add_action('save_post', 'ballball_save_hideflag');

function ballball_add_custom_fields() {
  add_meta_box(
    'ballball_videoid',
    __('Ooyala video ID', 'ballball'),
    'ballball_draw_videoid',
    'post'
  );
  add_meta_box(
    'ballball_hideflag',
    __('Hide from home page', 'ballball'),
    'ballball_draw_hideflag',
    'post'
  );
  add_meta_box(
    'ballball_hideflag',
    __('Hide from home page', 'ballball'),
    'ballball_draw_hideflag',
    'post_set'
  );   
}

function ballball_draw_videoid($post) {  
  wp_nonce_field('set_videoid', 'videoid_nonce'); // Use nonce for verification
  $value = get_post_meta($post->ID, 'ballball_videoid', true); 
  echo '<input type="text" id="ballball_videoid" name="ballball_videoid" value="'.esc_attr($value).'" />';
}

function ballball_save_videoid($post_id) {
  // Check permissions
  if (!current_user_can('edit_post', $post_id))
    return;
  // Verify action      
  if (!isset($_POST['videoid_nonce'])||!wp_verify_nonce($_POST['videoid_nonce'], 'set_videoid'))
    return;
  $mydata = sanitize_text_field($_POST['ballball_videoid']);
  add_post_meta($post_id, 'ballball_videoid', $mydata, true) or update_post_meta($post_id, 'ballball_videoid', $mydata);
}

function ballball_draw_hideflag($post) {  
  wp_nonce_field('set_hideflag', 'hideflag_nonce'); // Use nonce for verification
  $check = get_post_meta($post->ID, 'ballball_hideflag', true);
<<<<<<< HEAD
  echo '<input type="checkbox" id="ballball_hideflag" name="ballball_hideflag" value="on" ';
  if($check=='on') echo 'checked="checked"';
  echo ' />';  
=======
  echo "CHECK = $check<br /><br />"; 
  echo '<input type="checkbox" id="my_meta_box_check" name="my_meta_box_check" value="on" '.checked($check, 'on').' />';  
>>>>>>> f132313597cbaca834aabab79ad0eeb45e982dbc
}

function ballball_save_hideflag($post_id) {
  // Check permissions
  if (!current_user_can('edit_post', $post_id))
    return;
  // Verify action      
  if (!isset($_POST['hideflag_nonce'])||!wp_verify_nonce($_POST['hideflag_nonce'], 'set_hideflag'))
    return;
  $mydata = sanitize_text_field($_POST['ballball_hideflag']);
  add_post_meta($post_id, 'ballball_hideflag', $mydata, true) or update_post_meta($post_id, 'ballball_hideflag', $mydata);
}


/* Custom taxonomies (J.R.) */ 

add_action('init', 'ballball_create_taxonomies', 0);

function ballball_create_taxonomies() {
  
  $labels = array(
		'name'              => _x('Leagues', 'taxonomy general name'),
		'singular_name'     => _x('League', 'taxonomy singular name'),
		'search_items'      => __('Search Leagues'),
		'all_items'         => __('All Leagues'),
		'parent_item'       => null,
		'parent_item_colon' => null,
		'edit_item'         => __('Edit League'),
		'update_item'       => __('Update League'),
		'add_new_item'      => __('Add New League'),
		'new_item_name'     => __('New League Name'),
		'menu_name'         => __('Leagues')
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'league')
	);
	
	register_taxonomy('league', array('post', 'post_set'), $args);
	
	$labels = array(
		'name'              => _x('Teams', 'taxonomy general name'),
		'singular_name'     => _x('Team', 'taxonomy singular name'),
		'search_items'      => __('Search Teams'),
		'all_items'         => __('All Teams'),
		'parent_item'       => null,
		'parent_item_colon' => null,
		'edit_item'         => __('Edit Team'),
		'update_item'       => __('Update Team'),
		'add_new_item'      => __('Add New Team'),
		'new_item_name'     => __('New Team Name'),
		'menu_name'         => __('Teams')
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'team')
	);
	
	register_taxonomy('team', array('post', 'post_set'), $args);
  
  $labels = array(
		'name'              => _x('Matches', 'taxonomy general name'),
		'singular_name'     => _x('Match', 'taxonomy singular name'),
		'search_items'      => __('Search Matches'),
		'all_items'         => __('All Matches'),
		'parent_item'       => null,
		'parent_item_colon' => null,
		'edit_item'         => __('Edit Match'),
		'update_item'       => __('Update Match'),
		'add_new_item'      => __('Add New Match'),
		'new_item_name'     => __('New Match Name'),
		'menu_name'         => __('Matches')
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'match')
	);
	
	register_taxonomy('match', array('post', 'post_set'), $args);
  
}


/* Custom taxonomy fields (J.R.) */
 
add_action('league_edit_form_fields', 'ballball_add_league_fields', 10, 2);
add_action('edited_league', 'ballball_save_taxonomy_fields', 10, 2); 

function ballball_add_league_fields($tag) {  
  //check for existing taxonomy meta for term ID
  $t_id = $tag->term_id;
  $term_meta = get_option("taxonomy_$t_id");
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_league_optaid"><?php _e("Opta league ID", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[optaid]" id="ballball_league_optaid" style="width: 150px;" value="<?php echo $term_meta['optaid'] ? $term_meta['optaid'] : ''; ?>"><br />
    </td>
  </tr>
  <?php
}

add_action('team_edit_form_fields', 'ballball_add_team_fields', 10, 2);
add_action('edited_team', 'ballball_save_taxonomy_fields', 10, 2); 

function ballball_add_team_fields($tag) {  
  //check for existing taxonomy meta for term ID
  $t_id = $tag->term_id;
  $term_meta = get_option("taxonomy_$t_id");
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_team_optaid"><?php _e("Opta team ID", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[optaid]" id="ballball_team_optaid" style="width: 150px;" value="<?php echo $term_meta['optaid'] ? $term_meta['optaid'] : ''; ?>"><br />
    </td>
  </tr>  
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_team_league"><?php _e("League", 'ballball'); ?></label></th>
    <td>
      <?php wp_dropdown_categories('id=ballball_team_league&name=term_meta[league]&selected='.$term_meta['league'].'&show_option_none=No League&show_count=0&echo=1&hide_empty=0&taxonomy=league'); ?>
    </td>
  </tr>  
  <?php
}

add_action('match_edit_form_fields', 'ballball_add_match_fields', 10, 2);
add_action('edited_match', 'ballball_save_taxonomy_fields', 10, 2); 

function ballball_add_match_fields($tag) {  
  //check for existing taxonomy meta for term ID
  $t_id = $tag->term_id;
  $term_meta = get_option("taxonomy_$t_id");
  ?>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_league"><?php _e("League", 'ballball'); ?></label></th>
    <td>
      <?php wp_dropdown_categories('id=ballball_match_league&name=term_meta[league]&selected='.$term_meta['league'].'&show_option_none=No League&show_count=0&echo=1&hide_empty=0&taxonomy=league'); ?>
    </td>
  </tr> 
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_home_team"><?php _e("Home Team", 'ballball'); ?></label></th>
    <td>
      <?php wp_dropdown_categories('id=ballball_match_home_team&name=term_meta[home_team]&selected='.$term_meta['home_team'].'&show_option_none=No Team&show_count=0&echo=1&hide_empty=0&taxonomy=team'); ?>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_away_team"><?php _e("Away Team", 'ballball'); ?></label></th>
    <td>
      <?php wp_dropdown_categories('id=ballball_match_away_team&name=term_meta[away_team]&selected='.$term_meta['away_team'].'&show_option_none=No Team&show_count=0&echo=1&hide_empty=0&taxonomy=team'); ?>
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_kickoff_time"><?php _e("Kickoff Time", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[kickoff_time]" id="ballball_match_kickoff_time" style="width: 150px;" value="<?php echo $term_meta['kickoff_time'] ? $term_meta['kickoff_time'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_date"><?php _e("Date", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[date]" id="ballball_match_date" style="width: 150px;" value="<?php echo $term_meta['date'] ? $term_meta['date'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_venue"><?php _e("Venue", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[venue]" id="ballball_match_venue" style="width: 150px;" value="<?php echo $term_meta['venue'] ? $term_meta['venue'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_optaid"><?php _e("Opta ID", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[optaid]" id="ballball_match_optaid" style="width: 150px;" value="<?php echo $term_meta['optaid'] ? $term_meta['optaid'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_livefireid"><?php _e("LiveFyre ID", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[livefireid]" id="ballball_match_livefireid" style="width: 150px;" value="<?php echo $term_meta['livefireid'] ? $term_meta['livefireid'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_live_start_time"><?php _e("Live Start Time", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[live_start_time]" id="ballball_match_live_start_time" style="width: 150px;" value="<?php echo $term_meta['live_start_time'] ? $term_meta['live_start_time'] : ''; ?>"><br />
    </td>
  </tr>
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_live_end_time"><?php _e("Live Start Time", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[live_end_time]" id="ballball_match_live_end_time" style="width: 150px;" value="<?php echo $term_meta['live_end_time'] ? $term_meta['live_end_time'] : ''; ?>"><br />
    </td>
  </tr>
  <script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#ballball_match_kickoff_time').datetimepicker({
      dateFormat : 'dd-mm-yy',
      timeformat : 'hh:mm z'
    });
    jQuery('#ballball_match_live_start_time').datetimepicker({
      dateFormat : 'dd-mm-yy',
      timeformat : 'hh:mm z'
    });
    jQuery('#ballball_match_live_end_time').datetimepicker({
      dateFormat : 'dd-mm-yy',
      timeformat : 'hh:mm z'
    });
    jQuery('#ballball_match_date').datepicker({
      dateFormat : 'dd-mm-yy'
    });    
  });
  </script> 
  <?php 
}

function ballball_save_taxonomy_fields($term_id) {
  if(isset($_POST['term_meta'])) {
    $t_id = $term_id;
    $term_meta = get_option("taxonomy_$t_id");
    $cat_keys = array_keys($_POST['term_meta']);
    foreach($cat_keys as $key) {
      if(isset($_POST['term_meta'][$key])) {
        $term_meta[$key] = $_POST['term_meta'][$key];
      }
    }
    update_option("taxonomy_$t_id", $term_meta);
  }
}


/* Custom excerpt 'read more' text */

add_filter('the_excerpt', 'excerpt_read_more_link');

function excerpt_read_more_link($output) {
 global $post;
 return $output . '<a href="'. get_permalink($post->ID) . '"> Continue Reading...</a>';
}

?>
