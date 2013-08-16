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

add_image_size('small', 140, 92, true);
add_image_size('stream', 220, 144, true);
add_image_size('promoted', 460, 302, true);
add_image_size('article', 620, 413, true);

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
		'name' => __('Primary Sidebar', 'ballball'),
		'description' => __('The primary sidebar.', 'ballball'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
	
	/* Added by J.R. */
	
	register_sidebar(array(
		'id' => 'top',
		'name' => __('Top Widgets', 'ballball'),
		'description' => __('Widgets to appear in the header.', 'ballball'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

  /* End. */

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

/* i18n (J.R.) */

add_action('after_setup_theme', 'language_setup');
function language_setup(){
  load_theme_textdomain('ballball', get_template_directory().'/library/languages');
}

/* Thumbnail support */

add_theme_support('post-thumbnails', array('post', 'post_set'));

/* Include meta box class (J.R.) */

require_once("library/meta-box-class/my-meta-box-class.php");

/* Enqueue scripts (J.R.) */

add_action('admin_enqueue_scripts', 'ballball_queue_admin_scripts');

function ballball_queue_admin_scripts() {
  wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_script('jquery-ui-datetimepicker', get_stylesheet_directory_uri().'/library/js/libs/jquery-timepicker/jquery-ui-timepicker-addon.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'));     
  wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  wp_enqueue_style('jquery-style', get_stylesheet_directory_uri().'/library/js/libs/jquery-timepicker/jquery-ui-timepicker-addon.css');
}

/* Register menus (J.R.) */

add_action('init', 'ballball_register_menus');

function ballball_register_menus() {
  register_nav_menus(array(
    'main-nav' => __('The Main Menu', 'ballball' ),
    'live' => __('Live Match Menu', 'ballball'),
    'all-competitions' => __('All Competitons Menu', 'ballball'),
    'footer-nav' => __('Extra Footer Links', 'ballball')
  ));
}

/* Custom excerpt length */

function custom_excerpt_length($length) {
	return 20;
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

/* Custom styles on TinyMCE */

add_filter('mce_buttons_2', 'add_mce_dropdown');

function add_mce_dropdown($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}

add_filter('tiny_mce_before_init', 'add_mce_styles');

function add_mce_styles($settings) {

  $style_formats = array(
    array(
    	'title' => 'Highlight',
    	'block' => 'p',
    	'classes' => 'highlight',
    ),
    array(
    	'title' => 'Quote',
    	'block' => 'p',
    	'classes' => 'quote',
    ),
    array(
    	'title' => 'Small',
    	'block' => 'p',
    	'classes' => 'small',
    ),
  );

  $settings['style_formats'] = json_encode($style_formats);
  return $settings;

}

add_action('admin_init', 'add_editor_stylesheet');

function add_editor_stylesheet() {
	add_editor_style();
}

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
    'supports' => array('title', 'editor', 'author', 'excerpt', 'thumbnail'),
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
  echo '<input type="checkbox" id="ballball_hideflag" name="ballball_hideflag" value="on" ';
  if($check=='on') echo 'checked="checked"';
  echo ' />';    
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

/* Repeater field for multiple post select on post set */

$config = array(
  'id' => 'post_set_meta_box',
  'title' => 'Articles in Set',      
  'pages' => array('post_set'),
  'context' => 'normal',
  'priority' => 'high',
  'fields' => array(),
  'local_images' => true,
  'use_with_theme' => true            
);

$post_set_meta = new AT_Meta_Box($config);

$repeater_fields[] = $post_set_meta->addPosts($prefix.'posts_field_id', array('post_type' => 'post'), array('name' => ''), true);
$post_set_meta->addRepeaterBlock($prefix.'re_', array('inline' => true, 'name' => 'Add Articles', 'fields' => $repeater_fields));

$post_set_meta->Finish();

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
		'rewrite'           => array('slug' => 'league'),
		'show_in_nav_menus' => true
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
		'rewrite'           => array('slug' => 'team'),
		'show_in_nav_menus' => true
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
		'rewrite'           => array('slug' => 'match'),
		'show_in_nav_menus' => true
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
    <th scope="row" valign="top"><label for="ballball_match_live_end_time"><?php _e("Live End Time", 'ballball'); ?></label></th>
    <td>
      <input type="text" name="term_meta[live_end_time]" id="ballball_match_live_end_time" style="width: 150px;" value="<?php echo $term_meta['live_end_time'] ? $term_meta['live_end_time'] : ''; ?>"><br />
    </td>
  </tr>  
  <tr class="form-field">
    <th scope="row" valign="top"><label for="ballball_match_live_hideflag"><?php _e("Do Not Show Live", 'ballball'); ?></label></th>
    <td>
      <input type="checkbox" name="term_meta[live_hideflag]" id="ballball_match_live_hideflag" style="width: 15px" 
      <?php
      $check = $term_meta['live_hideflag'];
      echo '<input type="checkbox" id="ballball_match_live_hideflag" name="term_meta[live_hideflag]" style="width: 15px" value="on" ';
      if($check=='on') echo 'checked="checked"';
      echo ' />';
      ?>
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
    
    jQuery('#ballball_match_kickoff_time').change(function(){
      
      var stamp = jQuery('#ballball_match_kickoff_time').datetimepicker("getDate").getTime()/1000;
      
      var livestamp = stamp-3600;
      var livedate = new Date(livestamp*1000);
      var day = ('0'+livedate.getDate()).slice(-2);
      var month = livedate.getMonth()+1;
      month = ('0'+month).slice(-2);
      var year = livedate.getFullYear();
      var hours = ('0'+livedate.getHours()).slice(-2);
      var minutes = ('0'+livedate.getMinutes()).slice(-2);
      
      //if(jQuery('#ballball_match_live_start_time').val()=="") {
        jQuery('#ballball_match_live_start_time').val(day+'-'+month+'-'+year+' '+hours+':'+minutes);
      //}
      
      var liveendstamp = stamp+10800;
      var liveenddate = new Date(liveendstamp*1000);
      var day = ('0'+liveenddate.getDate()).slice(-2);
      var month = liveenddate.getMonth()+1;
      month = ('0'+month).slice(-2);
      var year = liveenddate.getFullYear();
      var hours = ('0'+liveenddate.getHours()).slice(-2);
      var minutes = ('0'+liveenddate.getMinutes()).slice(-2);
      
      //if(jQuery('#ballball_match_live_end_time').val()=="") {
        jQuery('#ballball_match_live_end_time').val(day+'-'+month+'-'+year+' '+hours+':'+minutes);
      //}
      
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
 return $output . '<a class="readmore" href="'. get_permalink($post->ID) . '"> '.__('View More', 'ballball').'</a>';
}

add_filter('excerpt_more', 'ballball_remove_readmore');    

function ballball_remove_readmore($more) {
	return '';
}

/* Language code to locale */

function lang_to_locale($lang) {
  if($lang=='ja') return 'ja_JP';
  else if($lang=='id') return 'id_ID';
  else if($lang=='vi') return 'vi_VN';
  else return 'en_GB';
}

/* Custom time ago */

function custom_time_ago($date) {
 
	// Array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'y', 'ballball' ), __( 'y', 'ballball' ) ),
		array( 60 * 60 * 24 * 30 , __( 'M', 'ballball' ), __( 'M', 'ballball' ) ),
		array( 60 * 60 * 24 * 7, __( 'w', 'ballball' ), __( 'w', 'ballball' ) ),
		array( 60 * 60 * 24 , __( 'd', 'ballball' ), __( 'd', 'ballball' ) ),
		array( 60 * 60 , __( 'h', 'ballball' ), __( 'h', 'ballball' ) ),
		array( 60 , __( 'm', 'ballball' ), __( 'm', 'ballball' ) ),
		array( 1, __( 's', 'ballball' ), __( 's', 'ballball' ) )
	);
 
	if ( !is_numeric( $date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $date ) );
		$date = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}
 
	$current_time = current_time( 'mysql', $gmt = 0 );
	$newer_date = strtotime( $current_time );
 
	// Difference in seconds
	$since = $newer_date - $date;
 
	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since )
		return __( 'sometime', 'ballball' );
 
	/**
	 * We only want to output one chunks of time here, eg:
	 * x years
	 * xx months
	 * so there's only one bit of calculation below:
	 */
 
	//Step one: the first chunk
	for ( $i = 0, $j = count($chunks); $i < $j; $i++) {
		$seconds = $chunks[$i][0];
 
		// Finding the biggest chunk (if the chunk fits, break)
		if ( ( $count = floor($since / $seconds) ) != 0 )
			break;
	}
 
	// Set output var
	$output = ( 1 == $count ) ? '1'. $chunks[$i][1] : $count . $chunks[$i][2];
 
 
	if ( !(int)trim($output) ){
		$output = '0 ' . __( 's', 'ballball' );
	}
 
	$output .= __(' ago', 'ballball');
 
	return $output;
	
}

/* Custom menu walker */

class jr_walker extends Walker_Nav_Menu {
  
  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
    
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    // Build URL for language (J.R.)
    
    if($item->object=='league') {
      $term = get_term_by('id', $item->object_id, 'league');
      $slug = $term->slug; 
      //$lang_str = (ICL_LANGUAGE_CODE=='en') ? '' : ICL_LANGUAGE_CODE.'/';
      //$custom_url = get_bloginfo('url').'/'.$lang_str.'league/'.$slug;
      $custom_url = get_bloginfo('url').'/league/'.$slug;
    } else if($item->object=='team') {
      $term = get_term_by('id', $item->object_id, 'team');
      $slug = $term->slug; 
      $custom_url = get_bloginfo('url').'/team/'.$slug;
    } else {
      $custom_url = $item->url;
    } 

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		//$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ! empty( $custom_url )        ? ' href="'   . esc_attr( $custom_url        ) .'"' : '';
    
		$item_output = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
  
}

function menu_set_is_parent($sorted_menu_items, $args) {
  $last_top = 0;
  foreach($sorted_menu_items as $key => $obj) {
    // it is a top level item?
    if(0 == $obj->menu_item_parent) {
      $last_top = $key;
    } else {
      $sorted_menu_items[$last_top]->classes['is-parent'] = 'is-parent';
    }
  }
  return $sorted_menu_items;
}
add_filter('wp_nav_menu_objects', 'menu_set_is_parent', 10, 2);

/* Custom get image caption (J.R. credit Luke Mlsna) */
              
function wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

function wp_get_caption($attachment_id) {
  $img_meta = wp_get_attachment($attachment_id);
  return $img_meta['caption']; 
}              

// The languages switcher function
function language_switcher() {
	$languages = icl_get_languages('skip_missing=1');

	// error_log(print_r($languages, true));
	echo "<ul>";
	echo "<li class=\"language-trigger " . ICL_LANGUAGE_CODE . "\"><span>" . ICL_LANGUAGE_NAME . "<sup>&#x25BE;</sup></span>";

	echo '<ul>';
	foreach($languages as $i) {
		if($i['active'] == 1) {
			echo "<li class=\"active {$i['language_code']}\"><span class=\"no-link\">{$i['translated_name']}&nbsp;&ndash;&nbsp;{$i['native_name']}</span></li>";
		}
	}

	foreach($languages as $i) {
		if($i['active'] === 0) {
			echo "<li class=\"{$i['language_code']}\"><a href=\"{$i['url']}\">{$i['translated_name']}&nbsp;&ndash;&nbsp;{$i['native_name']}</a></li>";
		}
	}

	echo '</ul></li></ul>';
}

// Disable Admin Bar for specific user - Ivan
if (!function_exists('df_disable_admin_bar')) {

	function df_disable_admin_bar() {
		
		// we're getting current user ID
		$user = get_current_user_id();
		
		// and removeing admin bar for user with ID 17
		if ($user == 17) {
		
			// for the admin page
			remove_action('admin_footer', 'wp_admin_bar_render', 1000);
			// for the front-end
			remove_action('wp_footer', 'wp_admin_bar_render', 1000);
			
			// css override for the admin page
			function remove_admin_bar_style_backend() {
				echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
			}	  
			add_filter('admin_head','remove_admin_bar_style_backend');
			
			// css override for the frontend
			function remove_admin_bar_style_frontend() {
				echo '<style type="text/css" media="screen">
				html { margin-top: 0px !important; }
				* html body { margin-top: 0px !important; }
				</style>';
			}
			add_filter('wp_head','remove_admin_bar_style_frontend', 99);
			
		}
  	}
}
add_action('init','df_disable_admin_bar');

/* Detect modile/tablet for Tealium (J.R.) */

function detect_device() {
  if(function_exists('wpmd_is_tablet') && wpmd_is_tablet()) return 'tablet';
  else if(function_exists('wpmd_is_device') && wpmd_is_device()) return 'mobile';
  else return 'desktop';
}

class wctest {
    public function __construct() {
        if ( is_admin() ){
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }
    }
	
    public function add_plugin_page(){
        // This page will be under "Settings"
        add_options_page( 'Settings Admin', 'Settings', 'manage_options', 'test-setting-admin', array( $this, 'create_admin_page' ) );
    }

    public function create_admin_page() {
        ?>
	<div class="wrap">
	    <?php screen_icon(); ?>
	    <h2>Settings</h2>			
	    <form method="post" action="options.php">
	        <?php
                    // This prints out all hidden setting fields
		    settings_fields( 'test_option_group' );	
		    do_settings_sections( 'test-setting-admin' );
		?>
	        <?php submit_button(); ?>
	    </form>
	</div>
	<?php
    }
	
    public function page_init() {		
        register_setting( 'test_option_group', 'array_key', array( $this, 'check_ID' ) );
            
            add_settings_section(
            'setting_section_id',
            'Setting',
            array( $this, 'print_section_info' ),
            'test-setting-admin'
        );	
            
        add_settings_field(
            'some_id', 
            'Some ID(Title)', 
            array( $this, 'create_an_id_field' ), 
            'test-setting-admin',
            'setting_section_id'			
        );		
    }
	
    public function check_ID( $input ) {
        if ( is_numeric( $input['some_id'] ) ) {
            $mid = $input['some_id'];			
            if ( get_option( 'app_link' ) === FALSE ) {
                add_option( 'app_link', $mid );
            } else {
                update_option( 'app_link', $mid );
            }
        } else {
            $mid = '';
        }
        return $mid;
    }
	
    public function print_section_info(){
        print 'Enter your setting below:';
    }
	
    public function create_an_id_field(){
        ?><input type="text" id="input_whatever_unique_id_I_want" name="array_key[some_id]" value="<?php echo get_option( 'app_link' ); ?>" /><?php
    }
}

$wctest = new wctest();

?>
