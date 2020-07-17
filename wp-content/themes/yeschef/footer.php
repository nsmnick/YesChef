	<footer class="panel page-footer">
		

		<div class="container">



			<div class="footer-container">

				<div class="footer-container__col1">

					<div class="logo-container">
						<div class="logo-container__image">
							<div class="footer-logo"></div>
						</div>

						<div class="logo-container__content">
							<p>Fresh, local and delicious home cooking ingredients boxes delivered to your door weekly for you to prepare wholesome, balanced and fresh food for all the family.</p>

							<p class="by">Brought to you buy The Chequers Aylesford.</p>
						</div>
					</div>


				</div>

				<div class="footer-container__col2">

					<div class="address-container">
						
						<div class="address-container__address">
							<p>
								Chequers Inn,<br/>
								63 High St, Aylesford,<br/>
								ME20 7AY
							</p>
						</div>

						<div class="address-container__contact">
							<a href="tel+441622717286">01622 717 286</a><br/>
							<a href="mailto:info@thechequersaylesford.co.uk">info@thechequersaylesford.co.uk</a>
						</div>

						<div class="address-container__social">

							<div class="social-container">
								
								<div class="social-container__icon social-container__icon__facebook">
									<a href="#">&nbsp;</a>
								</div>

								<div class="social-container__icon social-container__icon__instagram">
									<a href="#">&nbsp;</a>
								</div>

								<div class="social-container__icon social-container__icon__twitter">
									<a href="#">&nbsp;</a>
								</div>

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
						<?php echo get_global_replace_date_field('copyright_message'); ;?>
					</div>

					<div class="footer-bottom__container__by">
						Website by
					</div>
					<div class="footer-bottom__container__by__logo">&nbsp;</div>
				</div>

			</div>
			
		</div>



	</footer>







<?php wp_footer(); ?>


<!-- Global site tag (gtag.js) - Google Analytics -->



</body>
</html>
