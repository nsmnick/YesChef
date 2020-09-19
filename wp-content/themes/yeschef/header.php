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

	<!-- Facebook Pixel Code -->
		<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window,document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		 fbq('init', '611798939510965'); 
		fbq('track', 'PageView');
		</script>
		<noscript>
		 <img height="1" width="1" 
		src="https://www.facebook.com/tr?id=611798939510965&ev=PageView
		&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
		
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
			echo '<div class="home-bg-image animate-fade"></div>';
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

								<li class="menu-item mobile"><a href="<?php echo site_url(); ?>/place-your-order">Order your box</a></li>

							</ul>

						</nav>

						


					</div>

					<div class="header-container__right">					
						
						<a class="button place-order-button" href="/place-your-order">Order your box</a>


						<a class="button mobile-toggle-menu" href="#">Menu</a>
						<div class="mobile-toggle-menu-close"></div>
					


					</div>


				</div>


			</div>
		</div>

		

	</header>





    