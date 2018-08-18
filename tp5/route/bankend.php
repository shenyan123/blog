<?php

Route::rule('/login','backend/Login/login')->name('login');
Route::rule('/logout','backend/Login/logout')->name('logout');

Route::rule('/reg','backend/Reg/reg')->name('reg');

Route::post('/reg/submit','backend/Reg/regSubmit')->name('reg_submit');

Route::get('/user/exist', 'backend/Reg/userExist')->name('user_exist');



//分类管理

Route::get('/admin/category','backend/Category/list')->name('admin_category_list');

//标签管理
Route::get('/admin/tag','backend/Tag/list')->name('admin_tag_list');

//文章管理
Route::get('/admin/text','backend/Text/list')->name('admin_text_list');