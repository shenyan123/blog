<?php

namespace app\backend\controller;

use think\Request;

use app\backend\controller\Base;;

use app\common\model\TextModel;

class Text extends Base
{
	public function list(Request $request)
	{
		
		$this->checkSession();

		return $this->fetch('text/list');
	}


	public function add(Request $request)
	{
		$this->checkSession();

		if ($request->isPost()) {
			print_r($request->isPost());
		}
	}
}