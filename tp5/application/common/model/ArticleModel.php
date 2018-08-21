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

			// 提交事务
			Db::commit();

			return $article;
		} catch (\Exception $e) {
		    // 回滚事务
		    Db::rollback();
			return false;
		}
	}

}
