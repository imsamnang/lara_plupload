$(document).ready(function function_name() {
	if($('#totop').length != 0) {
	    $('#totop').click(function(e){
			e.preventDefault();
			$("html, body").animate({ scrollTop: 0 }, "slow");
		});
		$(window).scroll(function(){
			var y = window.pageYOffset;
			var h = $(window).height();
			if(y>=h) {
				$('#totop').show();
			} else {
				$('#totop').hide();
			}
		});
		// function detectScrollTop() {
		// 	$('#totop').css('left',$('header .header-content').width()+$('header .header-content').offset().left+25);
		// 	$('#totop').css('right','auto');
		// }
		// detectScrollTop();
		// $( window ).resize(function() {
		//   detectScrollTop();
		// });
	}
});