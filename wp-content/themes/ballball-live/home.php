<?php get_header(); ?>

      <script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
        
        <?php
        
        $view_matches = array();
        $view_leagues = array();
        $league_names = array();
        
        // Get current live matches
        
        $menu_items = wp_get_nav_menu_items('live-match-menu');
        
        foreach($menu_items as $menu_item) {
          $term_meta = get_option("taxonomy_$menu_item->object_id");
          if($term_meta['optaid']) {
            $opta_id = $term_meta['optaid'];
            $view_leagues[$menu_item->object_id] = $opta_id;
            $league_names[$opta_id] = $menu_item->title;
          }
        }
        
        $all_matches = get_terms('match', array('hide_empty' => false));
        $array_matches = array();
        
        if(count($view_leagues)>0) {
          foreach($all_matches as $match) {
            
            //$time_now = time();
            $time_now = current_time('timestamp');
            $match_name = $match->name;
            $term_meta = get_option("taxonomy_$match->term_id");
            $league_tax_id = $term_meta['league'];
            $league = $view_leagues[$league_tax_id];
            $live_start = strtotime($term_meta['live_start_time']);
            $live_end = strtotime($term_meta['live_end_time']);
            $opta_id = $term_meta['optaid'];
            $hideflag = $term_meta['live_hideflag'];                  
            
            // Filter
            
            if(
              in_array($league, $view_leagues)
              &&$hideflag!='on'
              &&$opta_id!=null
              &&$live_start!=null
              &&$live_end!=null
              &&$time_now>$live_start
              &&$time_now<$live_end
            ) {
              if(!array_key_exists($league, $view_matches)) $view_matches[$league] = array();
              $view_matches[$league][] = $opta_id;
              $array_matches[$opta_id] = $match->slug; 
            }
            
          }
        }
        
        /*
        $all_leagues = get_terms('league', array('hide_empty' => false));
        foreach($all_leagues as $league) {
          $term_meta = get_option("taxonomy_$league->term_id");
          $league_optaid = $term_meta['optaid'];
          $league_names[$league_optaid] = $league->name;
        }
        */
        
        $n_matches=0;
        foreach($view_matches as $league) {
          $n_matches += count($league);
        }
        
        ?>
        
        <?php if(count($view_matches)>0) { ?> 
        
        <div id="hero" class="clearfix">
      
          <div id="inner-hero" class="clearfix">
        
            <h2 class="total-match-count"><?php echo $n_matches; ?> Live Matches</h2>
            
            <p class="auto-update">Automatic updates</p>
              
            <div id="widgetOutput" class="clearfix">
            
            <ul id="live-league-menu">
        
            <?php
            $counter=0;
            foreach($view_matches as $league=>$matches) {
            ?>
              <li id="menu-league-<?php echo $counter; ?>" class="league-menu-item clearfix" ><?php echo $league_names[$league]; ?> <span class="num-matches">(<?php echo count($matches); ?>)</span></li>  
            <?php
            $counter++; }        
            ?>
            
            </ul>
        
            <?php
            $counter=0;
            foreach($view_matches as $league=>$matches) {
            ?>
              <h3 class="league-menu-item clearfix" ><?php echo $league_names[$league]; ?> <span class="num-matches">(<?php echo count($matches); ?>)</span></h3>  
              <div id="live-league-<?php echo $counter; ?>" class="live-league clearfix">
                <opta widget="fixtures" sport="football" competition="<?php echo $league; ?>" season="2013" match="<?php $count=0; foreach($matches as $match) { $count++; echo $match; if($count!=count($matches)) echo ', '; } ?>" live="true" order_by="date_asc" group_by_date="false" group_by_competition="false" show_competition_name="false" show_group="false" show_venue="false" show_attendance="false" show_referee="false" show_time="true" show_crest="false" show_scorers="false" show_cards="false" show_subs="false" sound="false" match_link="ballball.com" pre_match="true" player_popup="false" player_names="full" opta_logo="false" start_expanded="false" team_name="short" narrow_limit="400"></opta>             
              </div>
            <?php    
            $counter++; }        
            ?>
        
          </div>
        
        </div>
           
      </div>
      
      <?php } ?>
      
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

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
              
              <div id="promoted" class="clearfix">
              
              <?php
              
              // Get promoted post IDs...
              
              $promoted_postids = get_option('promoted_postids_'.ICL_LANGUAGE_CODE, false);
              $args_one = array(
                'post_type' => array('post', 'post_set'),
                'post__in' => $promoted_postids,
                'posts_per_page' => 3
              );
              $posts_one = get_posts($args_one);
              $n = count($posts_one);
              $posts_one_ids = array();
              foreach($posts_one as $post_one) {
                $posts_one_ids[] = $post_one->ID;
              }
              if($n<3) {
                $x = 3-$n;
                $args_two = array(
                  'post_type' => array('post', 'post_set'),
                  'posts_per_page' => $x,
                  'post__not_in' => $posts_one_ids
                );
                $posts_two = get_posts($args_two);
                $promoted_posts = array_merge($posts_one, $posts_two);
              } else {
                $promoted_posts = $posts_one;
              }
              

              // IA: Wrapping promo items in 2 columns ?>


              <div class="column left">

                <?php $counter=0; foreach($promoted_posts as $promoted_post) { $counter++;
                
                // Check article type...
                
                if(get_post_type($promoted_post->ID)=='post_set') {
                  $type = "set-article";
                } else {
                  $type = "text-article";
                  if(get_post_meta($promoted_post->ID, 'ballball_videoid', true)) {
                    $video_id = get_post_meta($promoted_post->ID, 'ballball_videoid', true);
                    $type = "video-article";
                  } else if(has_post_thumbnail($promoted_post->ID)) {
                    $type = "image-article";
                  }
                }
                
                ?>
                
                <div id="promoted-item-large-<?php echo $counter; ?>" class="promoted-item-large">
                  
                  <div class="promoted-featured-image-large"> 
                  <?php
  							  if(has_post_thumbnail($promoted_post->ID)) {
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($promoted_post->ID), 'promoted');
                  } else {
                    $src[0] = get_stylesheet_directory_uri().'/library/images/ballball-fallback-large.png';
                  }
                  echo '<a href="'.get_permalink($promoted_post->ID).'"><img class="attachment-stream wp-post-image" src="'.$src[0].'"></a>';
                  ?>
                  </div>
                  <?php
                  echo '<h2><a href="'.get_permalink($promoted_post->ID).'">'.get_the_title($promoted_post->ID).'</a></h2>';
                  echo '<p>'.pippin_excerpt_by_id($promoted_post->ID).'</p>';
                  ?>						  
  							  
                </div>
                
                <?php } ?>

              </div><!-- column left -->

              <div class="column right">
              

                <?php $counter=0; foreach($promoted_posts as $promoted_post) { $counter++;
                
                // Check article type...
                
                if(get_post_type($promoted_post->ID)=='post_set') {
                  $type = "set-article";
                } else {
                  $type = "text-article";
                  if(get_post_meta($promoted_post->ID, 'ballball_videoid', true)) {
                    $video_id = get_post_meta($promoted_post->ID, 'ballball_videoid', true);
                    $type = "video-article";
                  } else if(has_post_thumbnail($promoted_post->ID)) {
                    $type = "image-article";
                  }
                }
                
                ?>
                
                <div id="promoted-item-small-<?php echo $counter; ?>" class="promoted-item-small">
                
                  <div class="promoted-featured-image"> 
                  <?php
  							  if(has_post_thumbnail($promoted_post->ID)) {
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($promoted_post->ID), 'small');
                  } else {
                    $src[0] = get_stylesheet_directory_uri().'/library/images/ballball-fallback.jpg';
                  }
                  echo '<img class="attachment-stream wp-post-image" src="'.$src[0].'">';
                  ?>
                  </div>
                  <?php
                  echo '<p>'.get_the_title($promoted_post->ID).'</p>';
                  ?>
                  
                </div>
                
                <?php } ?>

              </div><!-- column right -->
              
              </div>
              
              <script src='http://player.ooyala.com/v3/a7474f8cef8e4baea1cb4f5e9a45e1cd'></script>
              
              <?php
              
              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $args = array(
                'post_type' => array('post', 'post_set'),
                'paged' => $paged,
                'meta_query' => array(
                  array(
                    'key' => 'ballball_hideflag',
                    'value' => 'on',
                    'compare' => 'NOT IN',
                  )
                )
              );
              $custom_query = new WP_Query($args); 
              
              $n = $custom_query->found_posts;
              $counter = 0;
              
              ?>
              
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
                  <?php if(!wpmd_is_ios()&&wpmd_is_android()&&wpmd_is_tablet()) { ?>
                  <a href="<?php echo get_option('app_link'); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/tablet_app-download.jpg'; ?>" /></a>
                  <?php } else if(!wpmd_is_ios()&&wpmd_is_android()) { ?>
                  <a href="<?php echo get_option('app_link'); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/mobile_app-download.jpg'; ?>" /></a>
                  <?php } ?>
                  </div>
                  <?php if(!wpmd_is_android()) { ?>
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

							<nav class="wp-prev-next">
									<ul class="clearfix">
										<li class="prev-link"><?php next_posts_link(__('Older <span class="article-word">Articles</span>', "ballball")) ?></li>
										<li class="next-link"><?php previous_posts_link(__('Newer <span class="article-word">Articles</span>', "ballball")) ?></li>
									</ul>
							</nav>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
											<header class="article-header">
												<p><?php _e("There are no articles.", "ballball"); ?></p>
										</header>
											<section class="entry-content">
										</section>
										<footer class="article-footer">
										</footer>
									</article>

							<?php endif; wp_reset_query(); ?>

						</div> <!-- end #main -->

						<?php get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->
      
      <script type="text/javascript">
      var utag_data = {
        content_type : "home",
        stream_type : "home",
        display_device_format : "<?php echo detect_device(); ?>"
      }
      </script>

<?php get_footer(); ?>
