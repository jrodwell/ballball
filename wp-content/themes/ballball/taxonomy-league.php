<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
              
              <script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
              
              <?php print apply_filters('taxonomy-images-queried-term-image', ''); ?>
              
              <h1 class="archive-title h2"><?php single_cat_title(); ?></h1>
              
              <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>
              
              <div id="tab-controls" class="clearfix">
                <div id="latest-tab" class="tab"><?php echo __('Latest', 'ballball'); ?></div>
                <div id="fixtures-tab" class="tab"><?php echo __('Fixtures', 'ballball'); ?></div>
                <div id="results-tab" class="tab"><?php echo __('Results', 'ballball'); ?></div>
              </div>
              
              <div id="tab-viewports">
                <div id="latest-viewport" class="viewport">
                
                  <?php
                  
                  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $args = array(
                    'post_type' => array('post', 'post_set'),
                    'paged' => $paged,
                    'tax_query' => array(
                  		array(
                  			'taxonomy' => 'league',
                  			'field' => 'slug',
                  			'terms' => get_query_var('term')
                  		)
                  	)
                  );
                  $custom_query = new WP_Query($args); 
                  
                  $n = $custom_query->found_posts;
                  $counter = 0;
                  
                  $league_slug = get_query_var('term');
                  $league = get_term_by('slug', $league_slug, 'league');
                  $league_name = $league->name;
                  $term_meta = get_option("taxonomy_$league->term_id");
                  $league_optaid = $term_meta['optaid'];
                  
                  $queried_object = get_queried_object();
                  $current_term_id = $queried_object->term_id;
                  $all_matches = get_terms('match', array('hide_empty' => false));
                  $array_matches = array();
                  foreach($all_matches as $match) {
                    $term_meta = get_option("taxonomy_$match->term_id");
                    $league_tax_id = $term_meta['league'];                
                    if($league_tax_id==$current_term_id) {
                      $opta_id = $term_meta['optaid'];
                      $array_matches[$opta_id] = $match->slug;
                    }                
                  }
                  
                  ?>
                  
                  <script type='text/javascript'>
                  <?php
                  echo "var array_matches = [";
                  foreach($array_matches as $key=>$value) {
                  ?>
                  { "o":"<?php echo $key; ?>" , "m":"<?php echo $value; ?>" },
                  <?php
                  }      
                  echo "];\n";
                  ?>
                  </script>
                  
    							<?php if ($custom_query->have_posts()) : while ($custom_query->have_posts()) : $custom_query->the_post(); $counter++; ?>
    
                  <?php
                  
                  // Check article type...
                  
                  if(get_post_type()=='post_set') {
                    $type = "set-article";
                  } else {
                    $type = "text-article";
                    if(get_post_meta(get_the_ID(), 'ballball_videoid', true)) {
                      $video_id = get_post_meta(get_the_ID(), 'ballball_videoid', true);
                      $type = "video-article";
                    } else if(has_post_thumbnail(get_the_ID())) {
                      $type = "image-article";
                    }
                  }
                  
                  ?>
    
    							<article id="post-<?php the_ID(); ?>" <?php if($counter==$n) post_class(array('clearfix', $type, 'last')); else post_class(array('clearfix', $type)); ?> role="article">
    
    								<header class="article-header">
    
                      <div class="featured-image"> 
    								  <?php if($type == "video-article") { ?>
                      <div id="ooyalaplayer-<?php echo $thisid=uniqid(); ?>" class="videoplayer">
                      <?php if(function_exists('wpmd_is_ios') && function_exists('wpmd_is_android') && function_exists('wpmd_is_tablet') && !wpmd_is_ios()&&wpmd_is_android()&&wpmd_is_tablet()) { ?>
                      <a href="<?php echo get_option('app_link'); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/tablet_app-download.jpg'; ?>" /></a>
                      <?php } else if(function_exists('wpmd_is_ios') && function_exists('wpmd_is_android') && !wpmd_is_ios()&&wpmd_is_android()) { ?>
                      <a href="<?php echo get_option('app_link'); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/mobile_app-download.jpg'; ?>" /></a>
                      <?php } ?>
                      </div>
                      <?php if(function_exists('wpmd_is_android') && !wpmd_is_android()) { ?>
                      <script>OO.ready(function() { OO.Player.create(
                        'ooyalaplayer-<?php echo $thisid; ?>',
                        '<?php echo $video_id; ?>',
                        {
                        css : 'http://ballball.wpengine.com/wp-content/themes/ballball/library/css/video.css'
                        }
                      ); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>
                      <?php } ?>
    								  <?php } else if($type == "image-article" || $type == "set-article") { ?>
    								  <?php
                      $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'stream');
                      echo '<a href="'.get_permalink().'"><img width="100%" height="100%" class="attachment-stream wp-post-image" src="'.$src[0].'"></a>';
                      $posts_group = get_post_meta($post->ID, 're_', true);
                      $set_count = count($posts_group);
                      if($type == "set-article") {
                        echo '<span class="set-count">'.$set_count.'</span>';
                      }
                      ?>
    								  <?php } ?>
    								  </div>
    
    									<h1 class="h2"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
    
    								</header> <!-- end article header -->
    
    								<section class="entry-content clearfix">								  
    								  
    									<div class="article-excerpt"><?php the_excerpt(); ?></div>
    									
    								</section> <!-- end article section -->
    
    								<footer class="article-footer clearfix">
    									
                      <p class="byline vcard"><?php echo '<time class="updated" datetime="'.get_the_time('Y-m-j').'" pubdate>'.custom_time_ago(get_the_time('U')).'</time>'; ?></p>
                      
                      <p class="tags"><?php the_terms(get_the_ID(), 'league', '<span class="tags-title">', ' ', '</span>'); ?></p>
                      
                      <p class="share">
                      
                      <!--
                      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="50" data-layout="button_count" data-show-faces="false" data-send="false"></div>
                      <a href="<?php the_permalink(); ?>" class="twitter-share-button" data-via="twitterapi" data-lang="<?php echo ICL_LANGUAGE_CODE; ?>">Tweet</a>
                      <div href="<?php the_permalink(); ?>" class="g-plusone" data-size="medium"></div>
                      -->
                      
                      <span class='st_facebook' st_url='<?php the_permalink(); ?>' displayText='Facebook'></span>
                      <span class='st_twitter' st_url='<?php the_permalink(); ?>' displayText='Tweet'></span>
                      <span class='st_googleplus' st_url='<?php the_permalink(); ?>' displayText='Google +'></span>
                      
                      </p>                                                                      
    
    								</footer> <!-- end article footer -->
    
    								<?php // comments_template(); // uncomment if you want to use them ?>
    
    							</article> <!-- end article -->
    
    							<?php endwhile; ?>
    							
    							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
										<header class="article-header">
											<p><?php _e("There are no articles for this match.", "ballball"); ?></p>
										</header>
											<section class="entry-content">
										</section>
										<footer class="article-footer">
										</footer>
									</article>
    
    							<?php endif; wp_reset_query(); ?>
                  
                  <nav class="wp-prev-next">
  									<ul class="clearfix">
  										<li class="prev-link"><?php next_posts_link(__('Older <span class="article-word">Articles</span>', "ballball")) ?></li>
  										<li class="next-link"><?php previous_posts_link(__('Newer <span class="article-word">Articles</span>', "ballball")) ?></li>
  									</ul>
    							</nav>
                    
                </div>
                
                <div id="fixtures-viewport" class="viewport">
                  <?php 
                  $league_slug = get_query_var('term');
                  $league = get_term_by('slug', $league_slug, 'league');
                  $term_meta = get_option("taxonomy_$league->term_id");
                  $league_optaid = $term_meta['optaid'];
                  ?>
                  <opta widget="fixtures" sport="football" competition="<?php echo $league_optaid; ?>" season="2013" status="prematch" days_ahead="30" live="false" order_by="date_asc" group_by_date="false" group_by_competition="false" show_competition_name="false" show_group="false" show_venue="false" show_attendance="false" show_referee="false" show_time="true" show_crest="false" show_scorers="false" show_cards="false" show_subs="false" sound="false" match_link="ballball.com" pre_match="true" player_popup="false" player_names="full" opta_logo="false" start_expanded="false" team_name="short" narrow_limit="400"></opta>
                </div>
                
                <div id="results-viewport" class="viewport">
                  <opta widget="fixtures" sport="football" competition="<?php echo $league_optaid; ?>" season="2013" status="fulltime" live="false" order_by="date_desc" group_by_date="false" group_by_competition="false" show_competition_name="false" show_group="false" show_venue="false" show_attendance="false" show_referee="false" show_time="true" show_crest="false" show_scorers="false" show_cards="false" show_subs="false" sound="false" match_link="ballball.com" player_popup="false" player_names="full" opta_logo="false" start_expanded="false" team_name="short" narrow_limit="400"></opta>
                </div>
                
              </div>
							
						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

      <script type="text/javascript">
      var utag_data = {
        content_type : "stream",
        stream_type : "league",
        league : "<?php echo $league_name; ?>",
        league_id : "<?php echo $league_optaid; ?>",
        display_device_format : "<?php echo detect_device(); ?>"
      }
      </script>

<?php get_footer(); ?>
