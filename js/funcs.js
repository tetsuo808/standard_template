$(document).ready(function() {
	//rel links
	$('.main-content a[rel=external]').filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	}).addClass('ext');
	
	//responsive stuff
	//nav highlighting for mobile
	/*$("#nav ul li").each(function(i) {
		$(this).addClass("rainbow0" + (i+1));
	});*/
	
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