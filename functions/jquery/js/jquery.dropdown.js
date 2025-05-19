$(document).ready(function(){
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