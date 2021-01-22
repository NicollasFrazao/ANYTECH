$(function(){    
	var bar = $('.anytech-bar');
	$(window).scroll(function () { 
		if ($(this).scrollTop() > 70) { 
			bar.addClass("userbar-color");
		} else { 
			bar.removeClass("userbar-color");
		} 
	});  
});