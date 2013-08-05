<?php get_header(); ?>

      <script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>

      <div id="hero">
      
        <div id="inner-hero">
        
        <?php
        
        $view_matches = array();
        $view_leagues = array();
        
        //$live_leagues = array();
        
        // Get current live matches
        
        $menu_items = wp_get_nav_menu_items('live-match-menu');
        
        //var_dump($menu_items);
        
        foreach($menu_items as $menu_item) {
          $term_meta = get_option("taxonomy_$menu_item->object_id");
          $view_leagues[$menu_item->object_id] = $term_meta['optaid'];
        }
        
        //var_dump($view_leagues);
        
        $all_matches = get_terms('match', array('hide_empty' => false));
        
        //var_dump($matches);
        
        foreach($all_matches as $match) {
          
          $time_now = time();
          
          //var_dump($match);
          
          $match_name = $match->name;
          $term_meta = get_option("taxonomy_$match->term_id");
          
          //var_dump($term_meta);
          
          $league_tax_id = $term_meta['league'];
          $league = $view_leagues[$league_tax_id];
          $live_start = strtotime($term_meta['live_start_time']);
          $live_end = strtotime($term_meta['live_end_time']);
          $opta_id = $term_meta['optaid'];
          $hideflag = $term_meta['live_hideflag'];
          
          //echo "$league, $live_start, $live_end, $opta_id, $hideflag<br /><br />";
          
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
          }
          
        }
        
        //$all_leagues = get_terms('league', array('hide_empty' => false));
        //var_dump($all_leagues);
        
        
        ?>
    
        <div id="leagueMenu">
          <ul>
          <?php
          foreach($view_matches as $league=>$matches) {
            
            ?>
            <li onclick="gotoleague($league);">League name here...</li>
            <?php
          }
          ?>
          </ul>
        </div>
    
        <div id="widgetOutput">
    
        <?php
        foreach($view_matches as $league=>$matches) {
        ?>
          <?php echo count($matches); ?> Live Matches <br /><br />
          <div id="live-league-<?php echo $league; ?>" class="live-league">
            <opta widget="fixtures" sport="football" competition="<?php echo $league; ?>" season="2013" match="<?php $count=0; foreach($matches as $match) { $count++; echo $match; if($count!=count($matches)) echo ', '; } ?>" live="true" order_by="date_asc" group_by_date="false" group_by_competition="false" show_competition_name="false" show_group="false" show_venue="false" show_attendance="false" show_referee="false" show_time="true" show_crest="false" show_scorers="false" show_cards="false" show_subs="false" sound="false" extra_match_link="true" player_popup="false" player_names="full" opta_logo="false" start_expanded="false" team_name="short" narrow_limit="400"></opta>
          </div>
          <?php
        }        
        ?>
        
        </div>
        
        </div>
           
      </div>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
              
              <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>
              
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
                  <div id="ooyalaplayer-<?php echo $thisid=uniqid(); ?>" class="videoplayer"></div>
                  <script>OO.ready(function() { OO.Player.create(
                    'ooyalaplayer-<?php echo $thisid; ?>',
                    '<?php echo $video_id; ?>',
                    {
                    css : 'http://ballball.wpengine.com/wp-content/themes/ballball/library/css/video.css'
                    }
                  ); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>
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

									<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

								</header> <!-- end article header -->

								<section class="entry-content clearfix">
								
									<div class="article-excerpt"><?php the_excerpt(); ?></div>
									
								</section> <!-- end article section -->

								<footer class="article-footer clearfix">
									
                  <p class="byline vcard"><?php echo '<time class="updated" datetime="'.get_the_time('Y-m-j').'" pubdate>'.custom_time_ago(get_the_time('U')).'</time>'; ?></p>
                  
                  <p class="tags"><?php the_terms(get_the_ID(), 'league', '<span class="tags-title">', ' ', '</span>'); ?></p>
                  
                  <p class="share">[SHARE]</p>                                                                       

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
												<h1><?php _e("No articles found.", "ballball"); ?></h1>
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

<?php get_footer(); ?>
