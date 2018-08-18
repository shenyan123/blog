// $(function(){

// 	function append_error(from_group,error_msg){
// 		from_group.addClass('has_error');
// 		from_group.find('.error_msg').remove();
// 		form_group.append('<span class="help-block error-msg">'+error_msg+'</span>');
// 	}

// 	function remove_error(form_group) {
// 		form_group.removeClass('has-error');
// 		form_group.find('.error-msg').remove();
// 	}

// 	//验证用户名

// 	function check_username(){
// 		var pattern = /^\w{4,12}$/;
// 		var input = $('[name = username]');
// 		var from_group = input.parent();//返回当前窗口的父窗口，

// 		var username = $.trim(input.val); //$.trim()是jQuery提供的函数,用于去掉字符串首尾的空白字符

// 		//判断用户名是否合法
// 		if (!pattern.test(username)) { //est() 方法用于检测一个字符串是否匹配某个模式. 如果字符串中有匹配的值返回 true ,否则返回 false
// 			// 处理错误输出
// 			append_error(form_group, '用户名不合法');
// 			} else {
// 			remove_error(form_group);
// 			is_user_exist();
// 		}
// 	}


// 	// 判断用户名是否存在
// 		function is_user_exist(){
// 			var input =$('[name = username]')；
// 			var username = input.val();
// 			var from_group = input.parent();

// 			var url = input.data('url') +'?username='+username;

// 			$.get(url,function(res){
// 				if (res.data.exist) {
// 					append_error(from_group,'用户名已经存在');
// 				}else{
// 					remove_error(from_group);
// 				}
// 			})
// 		}


// 	//验证密码是否是重复的
// 		function check_password()
// 		{
// 			var input = $('[name=password]');
// 			var form_group = input.parent();
// 			var reinput = $('[name=repassword]');
// 			var reform_group = reinput.parent();

// 			var password = input.val();
// 			var repassword = reinput.val();

// 			if (password!=repassword) {
// 				append_error(form_group, '两次密码不一致');
// 				append_error(reform_group, '两次密码不一致');
// 			}else{
// 				remove_error(form_group);
// 				remove_error(reform_group);
// 			}
// 		}

// 		$('[name=username]').on('blur', function() {
// 		check_username();
// 	})

// 	$('.password').on('blur', function() {
// 		check_password();
// 	})

// 	$('.btn-submit').on('click', function() {
// 		var form = $('.login-form');
// 		check_username();
// 		check_password();

// 		if (!$('.has-error').length) {
// 			form.submit();
// 		}
// 	})
	
// })


//错误输出

	// function rend_error(){
	// 	from_group.removeClass('has_error');

	// }

	// //验证用户名
	// function check_username(){
	// 	var pattern = /\w{4,12}/;
	// 	var username = $('[nmme=username]').val(); //在reg修改东西 38行附近

	// 	var  username = input.val();
	// 	var from_group = input/parent();
	// 	if (！pattern.test(username)) {
	// 		//处理错误输出
	// 		from_group.addClass('has_error');
	// 		from_group.append('<span class="help-block error-msg">用户输入不合法</sapn>')
	// 	}else{
	// 		from_group.removeClass('has_error');
	// 	}

		
	// }
$(function(){

	function append_error(form_group, error_msg) {
		form_group.addClass('has-error');
		form_group.find('.error-msg').remove();
		form_group.append('<span class="help-block error-msg">'+error_msg+'</span>');
	}

	function remove_error(form_group) {
		form_group.removeClass('has-error');
		form_group.find('.error-msg').remove();
	}

	

	// 验证用户名
	function check_username() {
		var pattern = /^\w{4,12}$/;
		var input = $('[name=username]');
		var form_group = input.parent();

		var username = $.trim(input.val());
		if (!pattern.test(username)) {
			// 处理错误输出
			append_error(form_group, '用户名不合法');
		} else {
			remove_error(form_group);
			is_user_exist();
		}
	}

	function is_user_exist() {
		var input = $('[name=username]');
		var username = input.val();
		var form_group = input.parent();

		var url = input.data('url') + '?username='+username;
		$.get(url, function(res) {
			if (res.data.exist) {
				append_error(form_group, '用户名已存在');
			} else {
				remove_error(form_group);
			}
		})
	}

	function check_password() {
		var input = $('[name=password]');
		var form_group = input.parent();
		var reinput = $('[name=repassword]');
		var reform_group = reinput.parent();

		var password = input.val();
		var repassword = reinput.val();
		// if (!password) {
		// 	append_error(from_group,'两次密码不一致')
		// }
		if (password!=repassword) {
			append_error(form_group, '两次密码不一致');
			append_error(reform_group, '两次密码不一致');
		} else {
			remove_error(form_group);
			remove_error(reform_group);
		}
	}

	$('[name=username]').on('blur', function() {
		check_username();
	})

	$('.password').on('blur', function() {
		check_password();
	})

	$('.btn-submit').on('click', function() {
		var form = $('.login-form');
		check_username();
		check_password();

		if (!$('.has-error').length) {
			form.submit();
		}
	})
});
