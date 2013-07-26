<?php
/*
This is the custom post type taxonomy template.
If you edit the custom taxonomy name, you've got
to change the name of this template to
reflect that name change.

i.e. if your custom taxonomy is called
register_taxonomy( 'shoes',
then your single template should be
taxonomy-shoes.php

*/
?>

<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">

							<h1 class="archive-title h2"><?php single_cat_title(); ?></h1>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							
							<?php
              
              // Check article type...
              
              $type = "text-article";
              if($video_id = get_post_meta(get_the_ID(), 'ballball_videoid', true)) {
                $type = "video-article";
              } else if(has_post_thumbnail(get_the_ID())) {
                $type = "image-article";
              }
              
              ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix', $type)); ?> role="article">

								<header class="article-header">

									<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

								</header> <!-- end article header -->

								<section class="entry-content clearfix">
								  
								  <div class="featured-image">
								  <?php if($type == "video-article") { ?>
                  <script src='http://player.ooyala.com/v3/386858aec41745dab060a13fedec14c9'></script><div id='ooyalaplayer' style='width:640px;height:360px'></div><script>OO.ready(function() { OO.Player.create('ooyalaplayer', '<?php echo $video_id; ?>'); });</script><noscript><div>Please enable Javascript to watch this video</div></noscript>
								  <?php } else if($type == "image-article") { ?>
								  <?php the_post_thumbnail('stream'); ?>
								  <?php } ?>
								  </div>
								  
									<div class="article-excerpt"><?php the_excerpt('<span class="read-more">' . __('Contine Reading &raquo;', 'ballball') . '</span>'); ?></div>
									
								</section> <!-- end article section -->

								<footer class="article-footer clearfix">
									
                  <p class="byline vcard"><?php echo '<time class="updated" datetime="'.get_the_time('Y-m-j').'" pubdate>'.human_time_diff(get_the_time('U'), current_time('timestamp')).__(' ago', 'ballball').'</time>'; ?></p>
                  
                  <p class="tags"><?php the_terms(get_the_ID(), 'league', '<span class="tags-title">', ' ', '</span>'); ?></p>
                  
                  <p class="share">[SHARE]</p>
                  
								</footer> <!-- end article footer -->

								<?php // comments_template(); // uncomment if you want to use them ?>

							</article> <!-- end article -->

							<?php endwhile; ?>

							<nav class="wp-prev-next">
									<ul class="clearfix">
										<li class="prev-link"><?php next_posts_link(__('&laquo; Older Articles', "ballball")) ?></li>
										<li class="next-link"><?php previous_posts_link(__('Newer Articles &raquo;', "ballball")) ?></li>
									</ul>
							</nav>

							<?php else : ?>

									<article id="post-not-found" class="hentry clearfix">
											<header class="article-header">
												<h1><?php _e("Nothing found.", "ballball"); ?></h1>
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
