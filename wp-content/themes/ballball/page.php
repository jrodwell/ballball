<?php get_header(); ?>

			<div id="content">

				<div id="inner-content" class="wrap clearfix">

						<div id="main" class="eightcol first clearfix" role="main">
              
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" role="article">

								<header class="article-header">

									<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

								</header> <!-- end article header -->

								<section class="entry-content clearfix">
								
									<div class="article-excerpt"><?php the_content(); ?></div>
									
								</section> <!-- end article section -->

								<footer class="article-footer clearfix">
									
                  <p class="byline vcard"><?php echo '<time class="updated" datetime="'.get_the_time('Y-m-j').'" pubdate>'.custom_time_ago(get_the_time('U')).'</time>'; ?></p>                                                                   

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

<?php get_footer(); ?>
