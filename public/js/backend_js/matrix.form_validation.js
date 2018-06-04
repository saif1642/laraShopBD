
$(document).ready(function(){
	
	$("#current_pwd").keyup(function(){
	  //alert('dddd');
	  let current_pwd = $('#current_pwd').val();
	  $.ajax({
		  type:'get',
		  url:'/admin/check-pwd',
		  data:{current_pwd:current_pwd},
		  success:function(resp){
              if(resp == "false"){
				  $('#chkPwd').html("<font color='red'>Current Password is incorrect!</font>");
			  }else if(resp == "True"){
				  $('#chkPwd').html("<font color='green'>Current Password is correct</font>");
			  }
		  },
		  error:function(){
			  alert("Error");
		  }
	  });
	});
	
	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();
	
	$('select').select2();
	
	// Form Validation
    $("#basic_validate").validate({
		rules:{
			required:{
				required:true
			},
			email:{
				required:true,
				email: true
			},
			date:{
				required:true,
				date: true
			},
			url:{
				required:true,
				url: true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#number_validate").validate({
		rules:{
			min:{
				required: true,
				min:10
			},
			max:{
				required:true,
				max:24
			},
			number:{
				required:true,
				number:true
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
	
	$("#password_validate").validate({
		rules:{
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			current_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#add_category").validate({
		rules:{
			cat_name:{
				required: true,
				minlength:3,
				maxlength:20
			},
			cat_description:{
				required:true,
				minlength:3,
				maxlength:200,
				
			},
			cat_url:{
				required:true,
				minlength:3,
				maxlength:50,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	$("#edit_category").validate({
		rules:{
			cat_name:{
				required: true,
				minlength:3,
				maxlength:20
			},
			cat_description:{
				required:true,
				minlength:3,
				maxlength:200,
				
			},
			cat_url:{
				required:true,
				minlength:3,
				maxlength:50,
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});
});
