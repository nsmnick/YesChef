
jQuery(window).ready(function($) {

	console.log('js loaded');
    
    // Cookie Notice
//	var cookieNotice = new CookieAccept();


	// Header scroll shrink
	// $(document).on("scroll", function(){

	// 	if($(document).scrollTop() > 75){
	// 	  	$(".page-header").addClass("scrolled");
	// 	}
	// 	else
	// 	{
	// 		$(".page-header").removeClass("scrolled");
	// 	}
	// });




	$('.hamburger-toggle').click (function(){
		$('.hamburger-toggle').toggleClass('js-mobile-menu-open');
		$('#main-menu').toggleClass('page-header__main-menu--open');
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
		
		console.log($selected_tab_media);

		if ($selected_tab_media.length) {
			$selected_tab_media.hide();
			$(target).show().addClass('ingredients__media__tab--show');
		} else {
			$(target).show().addClass('ingredients__media__tab--show');
		}


		// var $selected_tab_media = $('#ingredients .ingredients__media__tab--show');
		// if ($selected_tab_media.length) {
		// 	$selected_tab_media.hide();
		// 	$(target).show().addClass('ingredients__media__tab--show');
		// } else {
		// 	$(target).show().addClass('ingredients__media__tab--show');
		// }
	});

	// Set first tab selected on load.
	$('#ingredients .ingredients__tabs__tab').first().addClass('ingredients__tabs__tab--selected');
	$('#ingredients .ingredients__media__tab').first().fadeIn(transition_time).addClass('ingredients__media__tab--show');




	// $('.menu-item.menu-item-has-children a').on('touchstart click', function(e) {
	// 	var navitem = $(this);


	// 	if ($(window).width() <= 1024) {
	 	
	// 		// Check if item has a sub menu but isn't selected don't do anything but open the menu
	// 		if (!navitem.hasClass('selected') && navitem.next().length) {
	// 			// Don't navigate
	// 			e.preventDefault();

	// 			// Close other menus
	// 			$('.menu-item.menu-item-has-children a.selected').removeClass('selected').next().slideUp();

	// 			// open submenu
	// 			navitem.addClass('selected').next().slideDown();
	// 		}
	// 	}
	// });
	


	// // Animation
	// $('.animate').viewportChecker({
	// 	classToAdd: 'fade-up'
	// });

	// $('.animate-fade').viewportChecker({
	// 	classToAdd: 'fade-in'
	// });

	// $('.animate-fade-slow').viewportChecker({
	// 	classToAdd: 'fade-in-slow'
	// });

	// $('.animate-pulse').viewportChecker({
	// 	classToAdd: 'pulse-in'
	// });





	// Smooth scrolling.
	// var scrollingoffset = 75;
	// if (window.location.hash.length) {

	// 	console.log('smooth');

	// 	var target = $(window.location.hash);

	// 	if (target.length) {
	// 		$("html, body").animate({scrollTop: target.offset().top - scrollingoffset}, 1000);
	// 	}
	// }



// 	$('a[href^="#"]:not([href="#"])').click(function() {

// 		// console.log('here1:' + location.pathname.replace(/^\//,''));
// 		// console.log('here2:' + this.pathname.replace(/^\//,''));
// 		// console.log('here3:' + location.hostname);

// 		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
// 			var target = $(this.hash);

// //			console.log('here');

// 			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
// 			if (target.length) {
// 				$('html,body').animate({
// 					scrollTop: target.offset().top - scrollingoffset
// 				}, 1000);
// 				return false;
// 			}
// 		}
// 	});







	/* Accordion */

	// var acc = document.getElementsByClassName("accordion");
	// var i;

	// for (i = 0; i < acc.length; i++) {
	//     acc[i].addEventListener("click", function() {

	//     	// $('.accordion').removeClass("active");
	//     	// $('.accordion-panel').css({"max-height": ''});

	//         this.classList.toggle("active");
	//         var panel = this.nextElementSibling;

	//         if (panel.style.maxHeight) {
	//             panel.style.maxHeight = null;
	// 			panel.classList.remove("active");
	//         } else {
	//             panel.style.maxHeight = panel.scrollHeight + "px";
	//             panel.classList.add("active");
	//         }
	//     });
	// }
	

	// if($('#search-form')) 
	// {
	// 	// Set class for dirty input field.
	// 	$('#s').on('change', function() {
	// 		var $this = $(this);

	// 		if ($(this).val()) {
	// 			$this.addClass('search-dialog__group__input--dirty');
	// 		} else {
	// 			$this.removeClass('search-dialog__group__input--dirty');
	// 		}
	// 	});


	// }


	
  	




});