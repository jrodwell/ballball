<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

            <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>

            <?php
            
            $counter = 0;
            
            ?>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix', $two, $four)); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php echo $title = get_the_title(); ?></h1>
									
                  <p class="byline vcard"><?php
										printf(__('<time class="updated" datetime="%1$s" pubdate>%2$s</time> (GMT +00:00)', 'ballball'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')));
									?></p>

								</header> <!-- end article header -->

                <section class="entry-gridcontent clearfix">

                  <div id="post_set_grid" class="clearfix">
									
									<?php
                  
                  // Display grid elements
                  
                  $posts_group = get_post_meta($post->ID, 're_', true);     
                  foreach($posts_group as $arr) {
                    if(get_post_status($arr['posts_field_id'])=='publish') {
                      $counter++; 
                      if($counter%4==0) echo '<div class="grid-item two four clearfix">'; 
                      else if($counter%2==0) echo '<div class="grid-item two clearfix">'; 
                      else echo '<div class="grid-item">';
                      if(has_post_thumbnail($arr['posts_field_id'])) {
                        $src = wp_get_attachment_image_src(get_post_thumbnail_id($arr['posts_field_id']), 'small');
                      } else {
                        $src[0] = get_stylesheet_directory_uri().'/library/images/ballball-fallback.jpg';
                      }
                      echo '<a href="'.get_permalink($arr['posts_field_id']).'"><img class="attachment-stream wp-post-image" src="'.$src[0].'"></a>';
                      echo '<p><a href="'.get_permalink($arr['posts_field_id']).'">'.get_the_title($arr['posts_field_id']).'</a></p>';
                      $posts_group = get_post_meta($arr['posts_field_id'], 're_', true);
                      $set_count = count($posts_group);
                      if($type == "set-article") {
                        echo '<span class="set-count">'.$set_count.'</span>';
                      }
                      echo '</div>';
                    }
                  }
                  
                  ?>
                  
                  </div>

                </section> <!-- end article section -->

								<section class="entry-content clearfix" itemprop="articleBody">
									
									<div class="share-panel"> 
  								  
  								  <div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-width="50" data-layout="box_count" data-show-faces="true" data-send="false"></div>
                    
                    <a href="<?php echo get_permalink(); ?>" class="twitter-share-button" data-url="<?php echo get_bloginfo('url'); ?>" data-lang="<?php echo ICL_LANGUAGE_CODE; ?>" data-count="vertical">Tweet</a>
                    
                    <div class="g-plusone" href="<?php echo get_permalink(); ?>" data-size="tall"></div>
  								  
								  </div>
									
                  <?php the_content(); ?>
                  
								</section> <!-- end article section -->

								<footer class="article-footer">

                  <?php if(get_the_terms(get_the_ID(), 'league')) { ?><p>Posted Under</p><p class="tags"><?php the_terms(get_the_ID(), 'league', '<span class="tags-title">', ' ', '</span>'); ?></p><?php } ?>
                  
								</footer> <!-- end article footer -->

							</article> <!-- end article -->

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry clearfix">
								<header class="article-header">
									<p><?php _e("No article found.", "ballball"); ?></p>
								</header>
									<section class="entry-content">
								</section>
								<footer class="article-footer">
								</footer>
							</article>

						<?php endif; ?>

					</div> <!-- end #main -->

					<?php get_sidebar(); ?>

				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

      <script type="text/javascript">
      var utag_data = {
        content_type : "article",
        article_type : "article_set",
        article_title : "<?php echo $title; ?>",
        display_device_format : "<?php echo detect_device(); ?>"
      }
      </script>

<?php get_footer(); ?>
