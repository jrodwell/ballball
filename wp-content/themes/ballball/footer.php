
			<footer class="footer" role="contentinfo">

				<div class="footer-top">
					<div class="inner">
						<div class="logo-copyright">
							<div class="logo"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/logoFooter.png'; ?>"></div>
							<p class="source-org copyright">&copy; 2013 NWS Digital Asia Pte. Limited</p>
						</div>

						<div class="ad-container">
							<div class="ad footer-ad"></div>
						</div>
					</div>
				</div>

				<div id="inner-footer" class="wrap clearfix">

					<nav role="navigation">
						<?php wp_nav_menu(array('menu' => 'Main Menu', 'menu_class' => 'footer-menu', 'container_id' => 'footer-nav-desktop', 'walker' => new jr_walker())); ?>
					</nav>

					<hr>

					<nav role="navigation">
						<?php wp_nav_menu(array('menu' => 'Footer Links', 'menu_class' => 'footer-menu')); ?>
					</nav>

					<p class="credit">Match Statistics supplied by <a href="http://www.optasports.com/">Opta Sports Data Limited</a>. Reproduced under licence from Football DataCo Limited. All rights reserved</p>
				
				</div> <!-- end #inner-footer -->

				<nav role="navigation">
					<?php wp_nav_menu(array('menu' => 'Main Menu', 'menu_class' => 'footer-menu', 'container_id' => 'footer-nav-mobile', 'walker' => new jr_walker())); ?>
				</nav>

			</footer> <!-- end footer -->

		</div> <!-- end #container -->

		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
