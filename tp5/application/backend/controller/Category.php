<?php

namespace app\backend\controller;


use think\Request;

use app\backend\controller\Base;

use app\common\model\CategoryModel;

class Category extends  Base
{

	public function list(Request $request){

		$this->checkSession();

		$currentUser = $this->getCurrentUser();

		// 查询所有分类
		$categories = CategoryModel::where('user_id', $currentUser->id)
						->order('id', 'desc')
						->select();

		$this->assign('categories', $categories);

		return $this->fetch('category/list');
	}



	public function add(Request $request)
	{
		$this->checkSession();
		if ($request->isPost()) 
		{
			$title = $request->post('title', '', 'trim');
			if (!$title) {
				print_r($request->isPost());exit;
				return $this->error('添加失败,标题不能为空');
			}

			$currentUser = $this->getCurrentUser();

			$category = new CategoryModel;
			$category->name = $title;

			$category->created_time = time();

			$category->user_id = $currentUser->id;
			// print_r($currentUser->id);
			$category->save();

			return $this->success('添加成功', 'admin_category_list');
		}

		return $this->fetch('category/add');
	}

	//编辑
	public function edit(Request $request,$id)
	{
		
		$category =  CategoryModel::get($id);

		if (!$category) {
			return $this->error('编辑失败');
		}
		if ($request->isPost()) {
			$title = $request->post('title', '', 'trim');
			if (!$title) {
				return $this->error('编辑失败,标题不能为空');
			}

			$category->name = $title;
			$category->save();

			return $this->success('编辑成功', 'admin_category_list');
		}

		$this->assign('category', $category);
		return $this->fetch('category/edit');
	}

	//删除

	public function delete(Request $request,$id)
	{
		$category = CategoryModel::get($id);
		
		if (!$category) {
			return $this->error('类不存在');
		}
		$category->delete();

		return $this->success('删除成功','admin_category_list');
	}
}