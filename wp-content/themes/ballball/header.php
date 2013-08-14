<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
	
		<meta charset="utf-8">

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<!-- mobile meta (hooray!) -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<!-- icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) -->
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<!-- or, set /favicon.ico for IE10 win -->
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- drop Google Analytics Here -->
		<!-- end analytics -->		
    		
    <script type="text/javascript">
    var utag_data = {
    }
    </script>
    
    <!-- Loading script asynchronously -->
    <script type="text/javascript">
        (function(a,b,c,d){
        a='//tags.tiqcdn.com/utag/newscorp/ballball-web/dev/utag.js';
        b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
        a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
        })();
    </script>
		
    <div id="fb-root"></div>
    
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/<?php echo lang_to_locale(ICL_LANGUAGE_CODE); ?>/all.js#xfbml=1&appId=1374694749425097";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">
      {lang: '<?php echo ICL_LANGUAGE_CODE; ?>'} 
    </script type="text/javascript">
    
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    
    <script type="text/javascript">stLight.options({publisher: "d76d4b36-432a-4cf5-ad8d-e69b24c5c3a4", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    
    <script type="text/javascript">
    var wordpress_offset = <?php echo get_option('gmt_offset'); ?>;
    var language_code = '<?php echo ICL_LANGUAGE_CODE; ?>';
    </script>  
    
	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap clearfix">

					<div id="mobile-header">
						<a href="<?php echo home_url(); ?>" rel="nofollow" id="logo"><img src="<?php echo get_stylesheet_directory_uri().'/library/images/logo.png'; ?>" /></a>
						<!-- widgetised area for language switcher (J.R.) -->
						<div id="language-switcher"><?php language_switcher(); ?></div>
					</div>

					<nav role="navigation">
						<!-- <div class="test-menu-container"><ul class="nav-menu"><li class="menu-item"><?php icl_link_to_element(269, 'match'); ?></li></ul></div> -->

						<?php
							$menu_locations = get_nav_menu_locations();
							$main_nav_object = wp_get_nav_menu_object($menu_locations['main-nav']);
							$main_nav_items = wp_get_nav_menu_items($main_nav_object->term_id);
						?>

						<?php wp_nav_menu(array('menu' => 'Main Menu', 'menu_class' => 'nav-menu', 'container_id' => 'header-nav', 'walker' => new jr_walker())); ?>
					  
					</nav>

				</div> <!-- end #inner-header -->

			</header> <!-- end header -->
