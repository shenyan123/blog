<?php

function check_username($username)
{
	$pattern = '/^\w{4,12}$/';
	return preg_match($pattern, $username);
}

function  encrypt($str){  //encryt加密
	return md5($str);
}