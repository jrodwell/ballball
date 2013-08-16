<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
              
              <h1 class="archive-title h2"><?php single_cat_title(); ?></h1>
              
              <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>
              
              <script src="http://widget.cloud.opta.net/2.0/js/widgets.opta.js"></script>
              
              <?php
              
              $leagues = array();
              
              $match_slug = get_query_var('term');
              $match = get_term_by('slug', $match_slug, 'match');
              $match_name = $match->name;
              $term_meta = get_option("taxonomy_$match->term_id");      
              
              $kickoff = date('Ymd', strtotime($term_meta['kickoff_time']));        
              $home_team_id = $term_meta['home_team'];
              $away_team_id = $term_meta['away_team'];
              $all_teams = get_terms('team', array('hide_empty' => false));
              foreach($all_teams as $team) {
                if($team->term_id==$home_team_id) {
                  $home_team_name = $team->name;
                  $term_meta = get_option("taxonomy_$team->term_id");
                  $home_team_optaid = $term_meta['optaid'];
                } else if($team->term_id==$away_team_id) {
                  $away_team_name = $team->name;
                  $term_meta = get_option("taxonomy_$team->term_id");
                  $away_team_optaid = $term_meta['optaid'];
                }
              }                                        
              
              $term_meta = get_option("taxonomy_$match->term_id");               
              $league_tax_id = $term_meta['league'];
              $match_optaid = $term_meta['optaid'];
              $all_leagues = get_terms('league', array('hide_empty' => false));
              foreach($all_leagues as $league) {
                if($league->term_id==$league_tax_id) {
                  $term_meta = get_option("taxonomy_$league->term_id");
                  $league_optaid = $term_meta['optaid'];
                }
              }
              
              ?>
              
              <opta widget="fixtures" sport="football" competition="<?php echo $league_optaid; ?>" match="<?php echo $match_optaid; ?>" season="2013" live="true" order_by="date_asc" group_by_date="false" group_by_competition="false" show_competition_name="false" show_group="false" show_venue="true" show_attendance="true" show_referee="true" show_time="true" show_crest="true" show_scorers="true" show_cards="true" show_subs="false" sound="false" player_popup="false" player_names="initial" opta_logo="false" start_expanded="true" image_size="large" narrow_limit="300" pre_match="true"></opta>
              
              <?php
              
              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
              $args = array(
                'post_type' => array('post', 'post_set'),
                'paged' => $paged,
                'tax_query' => array(
              		array(
              			'taxonomy' => 'match',
              			'field' => 'slug',
              			'terms' => get_query_var('term')
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

									<h1 class="h2"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php echo $title=get_the_title(); ?></a></h1>

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
										<p><?php _e("There are no articles for this match.", "ballball"); ?></p>
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
        content_type : "stream",
        stream_type : "match",
        match : "<?php echo $match_name; ?>",
        match_date : "<?php echo $kickoff; ?>",
        match_id : "<?php echo $match_optaid; ?>",
        home_team : "<?php echo $home_team_name; ?>",
        home_team_id : "<?php echo $away_team_optaid; ?>",
        away_team : "<?php echo $home_team_name; ?>",
        away_team_id : "<?php echo $away_team_optaid; ?>",
        display_device_format : "<?php echo detect_device(); ?>"
      }
      </script>

<?php get_footer(); ?>
