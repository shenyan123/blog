<?php

Route::get('/', 'frontend/Index/index')->name('homepage');


Route::get('/list$','frontend/Article/list')->name('Article_list');

Route::get('/list/:id/show$','frontend/Article/detail')
			->pattern(['id'=>'\d+'])
			->name('admin_list_detail');

Route::get('/list/:id/tag_show$','frontend/Article/tagArticle')
			->pattern(['id'=>'\d+'])
			->name('tag_list_detail');
			

Route::get('/list/:id/user-info$','frontend/Article/userInfo')
			->pattern(['id'=>'\d+'])
			->name('user_info');


Route::rule('/list/category_list$','frontend/Article/category_list')->name('ajex_category_list');

Route::rule('/list/tag_list$','frontend/Article/tag_list')->name('ajex_tag_list');

Route::get('/list/hot-Article$','frontend/Article/hotArticle')->name('ajex_hot_Article');


Route::rule('/list/:id/relate-Article$','frontend/Article/relateArticle')
				->pattern(['id'=>'\d+'])
				->name('ajex_relate_Article');

