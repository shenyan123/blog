$(function(){

	if ($('.category-list').length) {
		$.get($('.category-list').data('url'),function(html){
			$('.category-list').html(html)
		})
	}

	if ($('.hotArticle-list').length) {
		$.get($('.hotArticle-list').data('url'),function(html){
			$('.hotArticle-list').html(html)
		})
	}

	if ($('.relate-list').length) {
		$.get($('.relate-list').data('url'),function(html){
			$('.relate-list').html(html)
		})
	}
})