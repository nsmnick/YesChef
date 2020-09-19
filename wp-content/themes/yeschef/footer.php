	<footer class="panel page-footer">
		

		<div class="container">



			<div class="footer-container">

				<div class="footer-container__col1">

					<div class="logo-container">
						<div class="logo-container__image">
							<div class="footer-logo"></div>
						</div>

						<div class="logo-container__content">
							<p><?php echo get_option('top_text', true); ?></p>

							<p class="by"><?php echo get_option('bottom_text', true); ?></p>
						</div>
					</div>


				</div>

				<div class="footer-container__col2">

					<div class="address-container">
						
						<div class="address-container__address">
							<p>
								<?php echo get_option('company_address', true); ?>
							</p>
						</div>

						<div class="address-container__contact">
							<a href="tel:<?php echo get_option('company_phone_link', true); ?>"><?php echo get_option('company_phone', true); ?></a><br/>
							<a href="mailto:<?php echo get_option('company_email', true); ?>"><?php echo get_option('company_email', true); ?></a>
						</div>

						<div class="address-container__social">

							<div class="social-container">
								
								<div class="social-container__icon social-container__icon__facebook">
									<a href="<?php echo get_option('facebook_link', true); ?>">&nbsp;</a>
								</div>

								<div class="social-container__icon social-container__icon__instagram">
									<a href="<?php echo get_option('instagram_link', true); ?>">&nbsp;</a>
								</div>

								<!-- <div class="social-container__icon social-container__icon__twitter">
									<a href="#">&nbsp;</a>
								</div> -->

							</div>



						</div>

					
					</div>


					<nav id="footer-menu">

					<ul class="footer-menu">

						<?php
							wp_nav_menu([
								'theme_location' => 'footer-menu'
								, 'container' => ''
								, 'items_wrap' => '%3$s'
							]);
						?>

					</ul>

				</nav>

				
				</div>



			</div>

		</div>

		
		


		<div class="footer-bottom">

			<div class="container">





				<div class="footer-bottom__container">
					<div class="footer-bottom__container__copyright">
					</div>

					<div class="footer-bottom__container__by">
						Website by
					</div>
					<a href="https://nsmdigital.com" target="_blank" rel="noreferrer noopener"><div class="footer-bottom__container__by__logo">&nbsp;</div></a>
				</div>

			</div>
			
		</div>



	</footer>







<?php wp_footer(); ?>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177763557-1"></script>
<script type="text/plain" cookie-accept>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo GA_CODE;?>');


  jQuery(document).ready(function() {
    
    jQuery(document).bind("gform_confirmation_loaded", function(event, formID) {
    	console.log('form submitted');
		
		if (typeof gtag != "undefined") 
		{
			gtag('event', 'Submission', {'event_category': 'Form','event_label': 'Order Form'});
			console.log('ga event submitted');
		}

		if (typeof fbq != "undefined") 
		{
			fbq('track', 'Purchase', {value: 0.00, currency: 'GBP'});
			console.log('fb event submitted');
		}

		
    });
    
  });


</script>





</body>
</html>
