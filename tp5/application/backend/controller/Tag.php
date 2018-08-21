<?php

namespace app\backend\controller;

use think\Request;

use app\backend\controller\Base;

use app\common\model\TagModel;

class Tag extends Base
{
	public function list(Request $request)
	{
		
		$this->checkSession();
		$currentUser = $this->getCurrentUser();

		// 查询所有分类
		$tags = TagModel::where('user_id', $currentUser->id)
						->order('id', 'desc')
						->select();

		$this->assign('tags', $tags);
		return $this->fetch('tag/list');
	}

	public function add(Request $request)
	{
		$this->checkSession();

		if ($request->isPost()) 
		{
			print_r($request->isPost());
			$title = $request->post('title', '', 'trim');
			if (!$title) {
				print_r($request->isPost());exit;
				return $this->error('添加失败,标签不能为空');
			}

			$currentUser = $this->getCurrentUser();

			$tag = new TagModel;
			$tag->name = $title;

			$tag->created_time = time();

			$tag->user_id = $currentUser->id;
			// print_r($currentUser->id);
			$tag->save();

			return $this->success('添加成功', 'admin_tag_list');
		}

		return $this->fetch('tag/add');
	}

	
		//编辑
		public function edit(Request $request,$id)
		{
			
			$tag =  TagModel::get($id);

			if (!$tag) {
				return $this->error('编辑失败');
			}
			if ($request->isPost()) {
				$title = $request->post('title', '', 'trim');
				if (!$title) {
					return $this->error('编辑失败,标题不能为空');
				}

				$tag->name = $title;
				$tag->save();

				return $this->success('编辑成功', 'admin_tag_list');
			}

			$this->assign('tag', $tag);
			return $this->fetch('tag/edit');
		}

		//删除

		public function delete(Request $request,$id)
		{
			$tag = TagModel::get($id);
			
			if (!$tag) {
				return $this->error('类不存在');
			}
			$tag->delete();

			return $this->success('删除成功','admin_tag_list');
		}
}