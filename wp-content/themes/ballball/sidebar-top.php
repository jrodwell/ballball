				<div id="sidebar" class="sidebar fourcol last clearfix" role="complementary">

					<?php if(is_active_sidebar('top')) : ?>

						<?php dynamic_sidebar('top'); ?>

					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the backend. -->

						<div class="alert alert-help">
							<p><?php _e("Please activate some Widgets.", "ballball");  ?></p>
						</div>

					<?php endif; ?>

				</div>