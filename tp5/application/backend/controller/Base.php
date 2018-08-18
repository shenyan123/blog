<?php

namespace app\backend\controller;

use think\Controller;

class Base extends Controller
{
	public function checkSession(){
		if(!session('user')){
			$this->redirect('login');
		}
	}
}