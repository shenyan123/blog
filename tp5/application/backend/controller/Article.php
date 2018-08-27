<?php

namespace app\backend\controller;

use think\Request;
use app\backend\controller\Base;
use app\common\model\CategoryModel;

use app\common\model\TagModel;
use app\common\model\ArticleTagMapModel;

use app\common\model\ArticleModel;

class Article extends Base
{
	public function initialize()
	{
		$this->checkSession();
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
						->paginate(2);
						$page = $articles->render();
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
			foreach ($articles as $key => $article) {
				$category = CategoryModel::get($article->category_id);
				$article->category = $category;
			}
			// print_r($category);

		$this->assign('articles', $articles);
		$this->assign('page',$page);

		// var_dump($this->assign('articles', $articles));
		return $this->fetch('article/list');
	}

	public function add(Request $request)
	{
		$currentUser = $this->getCurrentUser();

		if ($request->isPost()) {
			$postData = $request->post();
			// print_r($postData);
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


	public function edit(Request $request,$id)
	{
		$currentUser = $this->getCurrentUser();

		$article =  ArticleModel::get($id);
		if (!$article) {
			return $this->error('编辑失败，文章不存在');
		}

		if ($request->isPost()) {
				$postData = $request->post();
				if (!$postData['title']) {
					return $this->error('编辑失败，标题不存在');
				}
				if(!$postData['content']) {
					return $this->error('编辑失败，文章不存在');
				}
					$articleModel = new ArticleModel;
				$article = $articleModel->editArticle($id, $postData);

				if (!$article) {
					return $this->error('编辑失败');
				}
				return $this->success('编辑成功','admin_article_list');
		}

		$article->tagIds = ArticleTagMapModel::where('article_id',$id)->column('tag_id');

		

		$categories = CategoryModel::where('user_id',$currentUser->id)
						->order('id','desc')
						->select();

		$tags = TagModel::where('user_id',$currentUser->id)
						->order('id','desc')
						->select();

		$this->assign('categories',$categories);
		$this->assign('tags',$tags);

		$this->assign('article',$article);


			return $this->fetch('article/edit');
		
	}



	public function delete(Request $request,$id)
	{
		// print_r('expression');exit;
		$article =  ArticleModel::get($id);

		// print_r($id);exit;
		if (!$article) {
			return $this->error('删除失败,文章不存在');
			}	
			//删除标签

		ArticleTagMapModel::where('article_id', $id)->delete();

		$article->delete();
		
			return $this->success('删除成功','admin_article_list');
	}

}
