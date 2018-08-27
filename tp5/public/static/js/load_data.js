$(function(){

	if ($('.category-list').length) {
		$.get($('.category-list').data('url'),function(html){
			$('.category-list').html(html)
		})
	}
})