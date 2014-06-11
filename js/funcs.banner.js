//banner slider-homepage
$(function(){
	$('#slides').slides({
		preload:true,
		preloadImage:'img/banners/loading.gif',
		play:5000,
		pause:2500,
		effect:'fade',
		crossfade:true
	});
});