// JavaScript Document
$(document).ready(function(){
$(" #winMenu li:first").hover(function(){
		$(this).find('ul:first').show();
		},function(){
		$(this).find('ul:first').hide();;
		});	
	$("ul.dropdown li").dropdown();
	
});

$.fn.dropdown = function() {	
$('ul:first',this).css('display', 'none');
	$(this).hover(function(){		
	   $(this).addClass("hover");
		$('ul:first',this).css('display', 'block');
		$('ul li',this).css('height', '24px');
		$('ul li a',this).css('height', '24px');
	},function(){
		$(this).removeClass("hover");
		$('ul:first',this).css('display', 'none');
	});

}