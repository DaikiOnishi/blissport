// JavaScript Document
jQuery(function($){
	$('.tabbar').each(function() {
		var self = $(this);
		$('<em />').appendTo(self).css('--offset', self.find('.active').position().left + self.find('.active').width() / 2);
	});
	
	$('.tabbar ul li a').on('click touch', function(e) {
		
		e.preventDefault();
		
		var self = $(this);
		
		if(!self.parent().hasClass('active')) {
			self.parent().parent().children('li').removeClass('active');
			self.parent().addClass('active');
			self.parent().parent().parent().children('em').css('--offset', self.parent().position().left + self.parent().width() / 2);
		}
		
	});
});