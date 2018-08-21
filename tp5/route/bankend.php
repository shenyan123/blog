<?php

Route::rule('/login','backend/Login/login')->name('login');
Route::rule('/logout','backend/Login/logout')->name('logout');

Route::rule('/reg','backend/Reg/reg')->name('reg');

Route::post('/reg/submit','backend/Reg/regSubmit')->name('reg_submit');

Route::get('/user/exist', 'backend/Reg/userExist')->name('user_exist');



//分类管理

Route::get('/admin/category$', 'backend/Category/list')->name('admin_category_list');


Route::rule('/admin/category/add$', 'backend/Category/add')->name('admin_category_add');

Route::rule('/admin/category/:id/edit$', 'backend/Category/edit')
		->pattern(['id'=>'\d+'])
		->name('admin_category_edit');//编辑分类

Route::get('/admin/category/:id/delete$', 'backend/Category/delete')
		->pattern(['id'=>'\d+'])
		->name('admin_category_delete');//删除分类



//标签管理
Route::get('/admin/tag$','backend/Tag/list')->name('admin_tag_list');


Route::rule('/admin/tag/add$', 'backend/Tag/add')->name('admin_tag_add');//添加标签

Route::rule('/admin/tag/:id/edit$', 'backend/Tag/edit')
		->pattern(['id'=>'\d+'])
		->name('admin_tag_edit');//编辑分类

Route::get('/admin/tag/:id/delete$', 'backend/Tag/delete')
		->pattern(['id'=>'\d+'])
		->name('admin_tag_delete');//删除分类


//文章管理
Route::get('/admin/text','backend/Text/list')->name('admin_text_list');

Route::rule('/admin/text/add$','backend/Text/add')->name('admin_person_add');//添加文章

//个人信息
Route::get('/admin/person','backend/Person/list')->name('admin_person_list');
