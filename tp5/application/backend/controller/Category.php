<?php

namespace app\backend\controller;


use think\Request;

use app\backend\controller\Base;

class Category extends  Base
{

	public function list(Request $request){

		$this->checkSession();

		return $this->fetch('category/list');
	}
}