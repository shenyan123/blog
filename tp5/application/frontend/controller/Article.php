<?php
  
  namespace app\frontend\controller;

  use think\Request;
  use think\Controller;
  use app\common\model\UserModel;
  use \app\common\model\CategoryModel;
  use app\backend\controller\Base;
  use \app\common\model\TagModel;
  use \app\common\model\ArticleModel;
  use \app\common\model\ArticleTagMapModel;

  class  Article extends Controller
  {
  	public function initialize()
	{
		// $this->checkSession();
		$this->assign('nav', 'article');
	}

  	public function list(Request $request)
  	{
  		$where = [];
 			
  		$categoryId = $request->get('category',0);//把id初始化为0;
  		$category = CategoryModel::get($categoryId);
  		if ($category) {
  			$where['category_id'] = $category->id;
  		}




  		$articles =  ArticleModel::where($where)->order('id','desc')->paginate(4);
  		$page = $articles->render();

    	// $tags = TagModel::order('id','desc')->select();

    	$categorys = CategoryModel::where('article_num','>',0)->order('id','desc')->select();

     
    	$this->assign('articles',$articles);
    	$this->assign('page',$page);
    	// $this->assign('tags',$tags);
    	$this->assign('currcategory',$category);
    	$this->assign('categorys',$categorys);

  		return $this->fetch('article/list');
  	}




    public function detail(Request $request,$id)
    {
      
      $article = ArticleModel::get($id);

      if (!$article) {
      $this->error('文章不存在', 'homepage');
      }
      $article->views +=1;
      $article->save();

      $article->user = UserModel::get($article->user_id);
      $article->category = CategoryModel::get($article->category_id);

      $tagIds = ArticleTagMapModel::where('article_id', $id)->column('tag_id');
      $article->tags = TagModel::whereIn('id', $tagIds)->select();
      $this->assign('article', $article);

      return $this->fetch('article/detail');
    }



    public function  tagArticle(Request $request,$id)
    {
      $tagid = TagModel::get($id);
     
      if (!$tagid) {
      $this->error('文章不存在', 'homepage');
      }
      $tagid->user = UserModel::get($tagid->user_id);

      
      
      $articleId = ArticleTagMapModel::where('tag_id', $id)->column('article_id');

     

      $articles = ArticleModel::whereIn('id',$articleId)->paginate(2);
      $page = $articles->render();

      $this->assign('page', $page);
      $this->assign('articles', $articles);
      $this->assign('tagid', $tagid);

      return $this->fetch('article/tag_detail');
    }



    public function userInfo(Request $request,$id)
    {
      $user = UserModel::get($id);
      if (!$user) {
        $this->error('用户不存在','homepage');
      }
      $articles = ArticleModel::where('user_id',$user->id)->order('id','desc')->paginate(8);
      $page = $articles->render();

      $this->assign('user',$user);
      $this->assign('articles',$articles);
      $this->assign('page',$page);
      
      return $this->fetch('article/user_info');
    }



 


  	public function category_list(Request $request)
    {
      $categorys = CategoryModel::where('article_num','>',0)->order('id','desc')->select();
      $this->assign('categorys',$categorys);
      return $this->fetch('article/ajex/category_list');
    }
    public function tag_list(Request $request)
  	{
  		$tags = TagModel::order('id','desc')->select();
  		$this->assign('tags',$tags);
  		return $this->fetch('article/ajex/tag_list');
  	}



    public function hotArticle(Request $request)
    {
       //人们文章

      $hotArticle = ArticleModel::order('views','desc')->limit(5)->select();

      $this->assign('hotArticle',$hotArticle);

      return $this->fetch('article/ajex/hot_Article');
    }

    public function relateArticle(Request $request,$id)
    {
      //先获得文章->标签->id->article
      //先获得文章的tags
      $articleId = ArticleModel::get($id);

      $tagId = ArticleTagMapModel::where('article_id',$id)->column('tag_id');

      $atricleID = ArticleTagMapModel::whereIn('tag_id',$tagId)->column('article_id');

      $articles = ArticleModel::whereIn('id',$atricleID)->limit(2)->select();


       $this->assign('articles',$articles);

       return $this->fetch('article/ajex/relate-article');
    }
  }

