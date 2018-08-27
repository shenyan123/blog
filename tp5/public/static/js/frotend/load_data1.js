$(function(){

	if ($('.tag-list').length) {
		$.get($('.tag-list').data('url'),function(html){
			$('.tag-list').html(html)
		})
	}

	
})