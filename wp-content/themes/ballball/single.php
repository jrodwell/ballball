<?php get_header(); ?>

			<div id="content">
        
				<div id="inner-content" class="wrap clearfix"> 

					<div id="main" class="eightcol first clearfix" role="main">

            <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <?php
              
              // Check article type...
              
              $type = "single-text-article";
              if(get_post_meta(get_the_ID(), 'ballball_videoid', true)) {
                $video_id = get_post_meta(get_the_ID(), 'ballball_videoid', true);
                $type = "single-video-article";
              } else if(has_post_thumbnail(get_the_ID())) {
                $type = "single-image-article";
              }
              
              ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix', $type)); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
							  
								<header class="article-header">

                  <div class="single-featured-image"> 
								  <?php if($type == "single-video-article") { ?>
                  <div id="ooyalaplayer-<?php echo $thisid=uniqid(); ?>" class="videoplayer-big"></div>
                  <script>OO.ready(function() { OO.Player.create(
                    'ooyalaplayer-<?php echo $thisid; ?>',
                    '<?php echo $video_id; ?>',
                    {
                    css : 'http://ballball.wpengine.com/wp-content/themes/ballball/library/css/video.css'
                    }
                  ); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>
								  <?php } else if($type == "single-image-article") { ?>
								  <?php
								  $src = wp_get_attachment_image_src(get_post_thumbnail_id(), 'article');
								  $caption = wp_get_caption(get_post_thumbnail_id());
                  echo '<a href="'.get_permalink().'"><img width="100%" height="100%" class="attachment-article wp-post-image" src="'.$src[0].'"></a>';                  
								  ?>
								  <?php } ?>
								  </div>
								  
								  <?php if($caption) echo '<p class="caption">'.$caption.'</p>'; ?>

									<h1 class="entry-title single-title" itemprop="headline"><?php echo $title = get_the_title(); ?></h1>
									
                  <p class="byline vcard"><?php
										printf(__('<time class="updated" datetime="%1$s" pubdate>%2$s</time> (GMT +00:00)', 'ballball'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')));
									?></p>

								</header> <!-- end article header -->

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
        article_type : "<?php if($type=='single-video-article') echo 'article_with_video'; else if($type=='single-image-article') echo 'article_with_image'; else echo 'article'; ?>",
        article_title : "<?php echo $title; ?>",
        display_device_format : "<?php echo detect_device(); ?>"
      }
      </script>

<?php get_footer(); ?>
