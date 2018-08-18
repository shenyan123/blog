<?php

namespace app\backend\controller;

use think\Request;

use app\backend\controller\Base;;

class Tag extends Base
{
	public function list(Request $request)
	{
		
		$this->checkSession();

		return $this->fetch('tag/list');
	}
}