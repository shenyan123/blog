<?php

namespace app\backend\controller;

use think\Request;
use app\backend\controller\Base;

class Person extends Base
{
	public function initialize()
	{
		$this->checkSession();
		$this->assign('nav', 'person');
	}

	public function list(Request $request)
	{
		$currentUser = $this->getCurrentUser();
			
			print_r($request->post());
		if ($request->isPost()) {
			$nickname = $request->post('nickname', '', 'trim');
			if (!$nickname) {
				return $this->error('保存失败,昵称不能为空');
			}
			$currentUser->nickname = $nickname;
			$currentUser->intro = $request->post('intro');

			$currentUser->save();

			$this->success('保存成功', 'admin_person_list');
		}

		$this->assign('user', $currentUser);
		return $this->fetch('person/list');
	}

	public function avatarChange(Request $request)
	{
		$file = request()->file('file');

		$uploadDir = './uploads';
		$size = 2 * 1024 * 1024; // 2M
		$info = $file->validate(['size'=>$size,'ext'=>'jpg,jpeg,png,gif'])->move($uploadDir);
		if($info){
			// ./uploads/20180822\37b40676cd3fb6962bd56c18495a556c.jpg
			$filePath = $uploadDir.'/'.$info->getSaveName();
	    	$image = \think\Image::open($filePath);

			// ./uploads/20180822\37b40676cd3fb6962bd56c18495a556c_thumb.jpg
			$pathinfo = pathinfo($info->getSaveName());
	    	$thumbSavePath = $pathinfo['dirname'].'/'.$pathinfo['filename'].'_thumb.'.$pathinfo['extension'];
	    	$thumbPath = $uploadDir.'/'.$thumbSavePath;
	    	$image->thumb(200, 200, \think\Image::THUMB_CENTER)->save($thumbPath);

			$currentUser = $this->getCurrentUser();
			$currentUser->avatar = $thumbSavePath;
			$currentUser->save();

			// $currentUser = $this->getCurrentUser();

			// $filePath = str_replace('\\', '/', $info->getSaveName());
			// $currentUser->avatar = $filePath;
			// $currentUser->save();

			$this->success('上传成功', 'admin_person_list');
	    }else{
	        // 上传失败获取错误信息
			return $this->error($file->getError());
	    }
	}

}
