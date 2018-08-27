<?php
namespace app\common\model;

use think\Model;
use think\Db;
use app\common\model\CategoryModel;
use app\common\model\TagModel;
use app\common\model\ArticleTagMapModel;
use app\common\model\UserModel;

class ArticleModel extends Model
{
	protected $pk   = 'id';
	protected $name = 'articles';

	//一对一关联
	public function category(){
		return $this->hasOne('CategoryModel','id','category_id');
	}
	public function user(){
		return $this->hasOne('UserModel','id','user_id');
	}

	public function getCurrentUser()
	{
		$userId = session('user')['id'];
		return UserModel::get($userId);
	}

	public function addArticle($postData)
	{
		$currentUser = $this->getCurrentUser();

		Db::startTrans();
		try {
			$article = new self;
			$article->title = $postData['title'];
			$article->sub_title = $postData['subtitle'];
			$article->body = $postData['content'];
			$article->category_id = $postData['category'];
			$article->created_time = time();
			$article->updated_time = time();
			$article->user_id = $currentUser->id;

			$article->save();

			if (isset($postData['tag']) && !empty($postData['tag'])) {
				$articleTag = new ArticleTagMapModel;
				$tags = [];
				foreach ($postData['tag'] as $tagId) {
					$tags[] = ['article_id'=>$article->id, 'tag_id'=>$tagId];
				}

				$articleTag->saveAll($tags);
			}
			$this->updateCategoryArticleNum();

			// 提交事务
			Db::commit();

			return $article;
		} catch (\Exception $e) {
		    // 回滚事务
		    Db::rollback();
			return false;
		}
	}

	//编辑文章

	public function editArticle($id ,$postData)
	{
		$currentUser = $this->getCurrentUser();

		//开启事务
		Db::startTrans();

		try{	
			$article = self::get($id);

			$article->title = $postData['title'];
			$article->sub_title = $postData['subtitle'];
			$article->body = $postData['content'];
			$article->category_id = $postData['category'];
			$article->updated_time = time();

			$article->save();

			if (isset($postData['tag']) && !empty($postData['tag'])) {
				$articleTag = new ArticleTagMapModel;
				$tags = [];
				foreach ($postData['tag'] as $tagId) {
					$tags[] = ['article_id'=>$article->id, 'tag_id'=>$tagId];
				}
				$articleTag->saveAll($tags);
				
			
			}


			// 更新分类下文章数量
			$this->updateCategoryArticleNum();

			//提交事务

			Db::commit();

			return $article;  


		}catch(\Exception $e){

			//回滚事务、

			Db::rollback();

			return false;
		}
	}
	public function updateCategoryArticleNum()
	{
		$currentUser = $this->getCurrentUser();
		$categories = CategoryModel::where('user_id', $currentUser->id)->select();
		if (!$categories) {
			return true;
		}

		foreach ($categories as $key => $category) {
			$category->article_num = self::where('category_id', $category->id)->count();
			$category->save();
		}
	}
}
