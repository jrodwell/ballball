<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

					<div id="main" class="eightcol first clearfix" role="main">

            <script src='http://player.ooyala.com/v3/524943b893fa4620be889e04ccce7b92'></script>

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix')); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header">

									<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
									
                  <p class="byline vcard"><?php
										printf(__('<time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'ballball'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')));
									?></p>

								</header> <!-- end article header -->

								<section class="entry-content clearfix" itemprop="articleBody">
									
									<div id="post_set_grid">
									
									<?php
                  
                  // Display grid elements
                  
                  $posts_group = get_post_meta($post->ID, 're_', true);
                  foreach($posts_group as $arr) {
                    echo '<div class="grid-item">';
                    $src = wp_get_attachment_image_src(get_post_thumbnail_id($arr['posts_field_id']), 'small');
                    echo '<a href="'.get_permalink($arr['posts_field_id']).'"><img class="attachment-stream wp-post-image" src="'.$src[0].'"></a>';
                    echo '</div>';
                  }
                  
                  ?>
                  
                  </div>
									
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
