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

	

	function check_username() {
		var input = $('[name=username]');
		var form_group = input.parent();
		var username = $.trim(input.val());

		if (!username) {
			append_error(form_group, '用户名不能为空');
		} else {
			remove_error(form_group);
		}
	}

	function check_password() {
		var input = $('[name=password]');
		var form_group = input.parent();
		var password = $.trim(input.val());

		if (!password) {
			append_error(form_group, '密码不能为空');
		} else {
			remove_error(form_group);
		}
	}

	$('[name=username]').on('blur', function() {
		check_username();
	})

	$('[name=password]').on('blur', function() {
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