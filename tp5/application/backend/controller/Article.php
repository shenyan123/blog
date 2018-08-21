<?php

namespace app\backend\controller;

use think\Request;
use app\backend\controller\Base;
use app\common\model\CategoryModel;

use app\common\model\TagModel;

use app\common\model\ArticleModel;

class Article extends Base
{
	public function initialize()
	{
		$this->checkSession();

		print_r($this->checkSession());
		$this->assign('nav', 'article');
	}

	public function list(Request $request)
	{
		$currentUser = $this->getCurrentUser();

		/*
				print_r($currentUser);
					app\common\model\UserModel Object
					(
					    [data] => Array
					        (
					            [id] => 6
					            [username] => admin
					            [password] => 202cb962ac59075b964b07152d234b70
					            [nickname] => admin
					            [intro] => 
					            [avatar] => 
					        )

					    [relation] => Array
					        (
					        )

					)
		*/

		$articles = ArticleModel::where('user_id', $currentUser->id)
						->order('id', 'desc')
						->select();

		/*				print_r($articles);

					think\model\Collection Object
			(
			    [items:protected] => Array
			        (
			            [0] => app\common\model\ArticleModel Object
			                (
			                    [data] => Array
			                        (
			                            [id] => 1
			                            [title] => 等我打完这把
			                            [body] => wwdwdwd
			                            [created_time] => 1534823980
			                            [uodated_time] => 0
			                            [category_id] => 1
			                            [user_id] => 6
			                        )

			                    [relation] => Array
			                        (
			                        )
			                )
			        )
			)
					*/
		$this->assign('articles', $articles);
		return $this->fetch('article/list');
	}

	public function add(Request $request)
	{
		$currentUser = $this->getCurrentUser();

		if ($request->isPost()) {
			$postData = $request->post();
			if (!$postData['title']) {
				return $this->error('添加失败,标题不能为空');
			}
			if (!$postData['content']) {
				return $this->error('添加失败,内容不能为空');
			}

			$articleModel = new ArticleModel;
			$article = $articleModel->addArticle($postData);
			if (!$article) {
				return $this->error('添加失败');
			}

			return $this->success('添加成功', 'admin_article_list');
		}

		// 查出所有的category和tag
		$categories = CategoryModel::where('user_id', $currentUser->id)
						->order('id', 'desc')
						->select();

		$tags = TagModel::where('user_id', $currentUser->id)
						->order('id', 'desc')
						->select();

		$this->assign('categories', $categories);
		$this->assign('tags', $tags);
		return $this->fetch('article/add');
	}

}
