//wowjs init
new WOW({
	boxClass:'wow',
	animateClass:'animated',
	offset:100,
	mobile:false,
	live:true
}).init();

//jquery
$(document).ready(function() {
	//rel links
	$('.main-content a[rel=external]').filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	}).addClass('ext');

	// svr replace w/mondenizr
	if(!Modernizr.svg) {
		$('img[src*="svg"]').attr('src'), function () {
			return $(this).attr('src').replace('.svg', '.png');
		}
	}

	//SF menu
	if ($(window).width() < 960) {
		//nothing
	}
	else {
		var exampleOptions = {
			speed: 'fast',
			popUpSelector: 'ul'
		}
		var example = $('#sf-menu').superfish(exampleOptions);
	}

	//responsive nav
	$('#pull').click( function () {
		$('.sf-menu').toggleClass("xactive");
		$(this).toggleClass("clozed");
	});
	$('.mobnav-subarrow').click( function () {
		$(this).parent().toggleClass("xpopdrop");
		$(this).toggleClass("clozed");
	});

	$(function() {
		var pull = $('#pull');
			menu = $('#nav ul');
			menuHeight = menu.height();
		$(pull).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});
		$(window).resize(function(){
			var w = $(window).width();
			if(w > 640 && menu.is(':hidden')) {
				menu.removeAttr('style');
			}
		});
	});

	//scroll-to-top plugin
	jQuery.fn.topLink = function(settings) {
		settings = jQuery.extend({
		  min: 1,
		  fadeSpeed: 200,
		  ieOffset: 50
		}, settings);
		return this.each(function() {
		  //listen for scroll
		  var el = $(this);
		  el.css('display','none'); //in case the user forgot
		  $(window).scroll(function() {
			//stupid IE hack
			if(!jQuery.support.hrefNormalized) {
			  el.css({
				'position': 'absolute',
				'top': $(window).scrollTop() + $(window).height() - settings.ieOffset
			  });
			}
			if($(window).scrollTop() >= settings.min)
			{
			  el.fadeIn(settings.fadeSpeed);
			}
			else
			{
			  el.fadeOut(settings.fadeSpeed);
			}
		  });
		});
	  };
	//set the link
	$('#top-link a').topLink({
		min: 400,
		fadeSpeed: 500
	});
	//smoothscroll
	$('#top-link a').click(function(e) {
		e.preventDefault();
	});

	// sticky nav
	/*$(function() {
		var sticky_navigation_offset_top = $('#header').offset().top;
		var sticky_navigation = function(){
			var scroll_top = $(window).scrollTop();
			if (scroll_top > sticky_navigation_offset_top) {
				$('#header img').css({'width':'88px'});
				$('#nav').css({'margin-top':'0px'});
				$('.quick-links').css({'margin-top':'0px'});
			} else {
				$('#header img').css({'width':'184px'});
				$('#nav').css({'margin-top':'20px'});
				$('.quick-links').css({'margin-top':'20px'});
			}
		};

		sticky_navigation();

		$(window).scroll(function() {
			 sticky_navigation();
		});
	});*/

	//responsive tables
	$("table").wrap("<div class='table-scroll'></div>");

	//keyboard prevent enter submit
	$('#contact-form').keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});

	//slider nav
	var toggle = 0;
	$('#navslide').on('click', function () {
		if(toggle == 0){
			$('.nav').animate({
				'left': '0'
			});
			$('#navslide').animate({
				'left': '273'
			});
			toggle = 1;
			return false;
		} else {
			$('.nav').animate({
				'left': '-273'
			});
			$('#navslide').animate({
				'left': '0'
			});
			toggle = 0;
			return false;
		}
	});



});
