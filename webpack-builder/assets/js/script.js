
jQuery(window).ready(function($) {

	console.log('js loaded');
    
    // Cookie Notice
	var cookieNotice = new CookieAccept();



	


	$('.mobile-toggle-menu').click (function(e){
		$('.mobile-toggle-menu').css('opacity',0);
		$('.mobile-toggle-menu-close').fadeIn();
		$('#main-menu').toggleClass('page-header__main-menu--open');
		document.body.style.overflow = 'hidden';
		e.preventDefault();
	});

	$('.mobile-toggle-menu-close').click (function(e){
		$('#main-menu').toggleClass('page-header__main-menu--open');
		$('.mobile-toggle-menu-close').hide();
		$('.mobile-toggle-menu').css('opacity',1);
		document.body.style.overflow = 'auto';
		e.preventDefault();
	});



	// Tabs
	var transition_time = 300;
	$('#ingredients .ingredients__tabs__tab').off().on('click', function(e) {
		e.preventDefault();
		var $this = $(this);
		var target = $this.attr('href');

		// Hide existing tabs then reveal selected tab.
		var $selected_tab = $('#ingredients .ingredients__tabs__tab--selected');
		if ($selected_tab.length) {
			$selected_tab.removeClass('ingredients__tabs__tab--selected');
		}
		$this.addClass('ingredients__tabs__tab--selected');

		
		var $selected_tab_media = $('#ingredients .ingredients__media__tab--show');
		
		//console.log($selected_tab_media);

		if ($selected_tab_media.length) {
			$selected_tab_media.hide();
			$(target).show().addClass('ingredients__media__tab--show');
		} else {
			$(target).show().addClass('ingredients__media__tab--show');
		}


	});

	// Set first tab selected on load.
	$('#ingredients .ingredients__tabs__tab').first().addClass('ingredients__tabs__tab--selected');
	$('#ingredients .ingredients__media__tab').first().fadeIn(transition_time).addClass('ingredients__media__tab--show');




	// Animation
	$('.animate').viewportChecker({
		classToAdd: 'fade-up'
	});

	$('.animate-fade').viewportChecker({
		classToAdd: 'fade-in'
	});

	$('.animate-fade-slow').viewportChecker({
		classToAdd: 'fade-in-slow'
	});

	$('.animate-pulse').viewportChecker({
		classToAdd: 'pulse-in'
	});


  	$(document).bind("gform_confirmation_loaded", function (e, form_id) {
	
  		$('#page-heading').text('Thankyou');
  		$('#page-intro').html('We have your order and will call you soon to confirm your choices and arrange payment.<br/>We have included a summary of your order below.');

  		$('#order-by-phone').hide();
  		$('#how-it-works').hide();
 
  		$('.content__panel--white').removeClass('content__panel--white');
  		$('#page-subheading').addClass('no-margin');
  		$('#page-subheading').css('color','white');
  		$('#page-subheading').css('font-size','18px');
  		$('#page-subheading').css('text-align','center');
  		$('#print-order-button').show();

  		
  		
    

    	
  		

	});



});

