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
								  <?php the_post_thumbnail('article'); ?>
								  <?php } ?>
								  </div>

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									
                  <p class="byline vcard"><?php
										printf(__('<time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'ballball'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')));
									?></p>

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
								
									<?php the_content(); ?>
									
								</section> <!-- end article section -->

								<footer class="article-footer">

                  <p class="tags"><?php the_terms(get_the_ID(), 'league', '<span class="tags-title">', ' ', '</span>'); ?></p>
                  
                  <p class="share">[SHARE]</p>   

								</footer> <!-- end article footer -->

							</article> <!-- end article -->

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry clearfix">
								<header class="article-header">
									<h1><?php _e("No article found.", "ballball"); ?></h1>
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

<?php get_footer(); ?>
