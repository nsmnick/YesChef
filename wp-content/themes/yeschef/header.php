<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title><?php wp_title(' - ', TRUE, 'right'); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" type="image/png" href="<?php echo IMAGES; ?>/favicon.png">

	<link rel="canonical" href="<?php echo site_url(); ?>/">

	<script>(function(){document.documentElement.className='js'})();</script>

	<!--[if (lt IE 9)]><script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.helper.ie8.js"></script><![endif]-->

	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div id="cookie-accept" class="cookie-accept">
		<div class="cookie-accept__container">
			<div class="cookie-accept__content">
				This website uses cookies to allow us to see how the site is used. The cookies do not identify you. If you continue to use this site we will assume that you are happy with this.  If you want to use this website without cookies or would like to know more, you can do that here.
			</div>
			<div class="cookie-accept__controls">
				<button id="cookie-accept__deny" class="cookie-accept__deny">Deny</button>
				<button id="cookie-accept__allow" class="cookie-accept__allow">Allow Cookies</button>
			</div>
		</div>
	</div>
	
	<header>
	
		<?php
		//if(is_page_template( 'single-nsm_meals.php' ) ){

		$bg_class='';
		if(is_single()) {
			$bg_class = ' bottom-green';
		}

		if(is_front_page() )
		{
			echo '<div class="home-bg-image"></div>';
		}
		?>

		

		<div class="page-header<?php echo $bg_class;?>">
			
			<div class="container">


				<div class="header-container">

					<div class="header-container__left">					
						<a href="<?php echo site_url(); ?>/" >
							<div class="site-header-logo"></div>
						</a>
					</div>



					<div class="header-container__center">					

						
						<nav id="main-menu" class="page-header__main-menu">

							<ul class="main-menu">

								<li class="menu-item mobile"><a href="<?php echo site_url(); ?>/">Home</a></li>
								<?php
									wp_nav_menu([
										'theme_location' => 'main-menu'
										, 'container' => ''
										, 'items_wrap' => '%3$s'
									]);
								?>

							</ul>

						</nav>

						


					</div>

					<div class="header-container__right">					
						
						<a class="button" href="/place-your-order">Order your box</a>

						<div class="page-header__menu-button-container">

							<div class="hamburger-toggle" data-menu="1">
								<div class="hamburger-toggle__left"></div>
								<div class="hamburger-toggle__right"></div>
							</div>
							
						</div>


					</div>


				</div>


			</div>
		</div>
	</header>





    