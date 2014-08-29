$(document).ready(function() {
	//rel links
	$('.main-content a[rel=external]').filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	}).addClass('ext');
	
	//SF menu
	if ($(window).width() < 1280) {
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
	});
	$('.mobnav-subarrow').click( function () {
		$(this).parent().toggleClass("xpopdrop");
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
			if(w > 620 && menu.is(':hidden')) {
				menu.removeAttr('style');
			}
		});
	});
	
});