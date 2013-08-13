			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap clearfix">

          <p>LOGO HERE</p>

          <p class="source-org copyright">&copy; 2013 NWS Digital Asia Pte. Limited</p>

					<nav role="navigation">
					  <?php wp_nav_menu(array('menu' => 'Footer Links', 'menu_class' => 'footer-menu')); ?>
            <?php wp_nav_menu(array('menu' => 'Main Menu', 'menu_class' => 'footer-menu', 'container_id' => 'footer-nav', 'walker' => new jr_walker())); ?>
					</nav>
					
					<p>Match Statistics supplied by Opta Sports Data Limited. Reproduced under licence from Football DataCo Limited. All rights reserved</p>
					
				</div> <!-- end #inner-footer -->

			</footer> <!-- end footer -->

		</div> <!-- end #container -->

		<!-- all js scripts are loaded in library/bones.php -->
		<?php wp_footer(); ?>

	</body>

</html> <!-- end page. what a ride! -->
