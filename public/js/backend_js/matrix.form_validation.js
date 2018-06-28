
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
	$("#add_product").validate({
		rules:{
			category_id:{
                required: true
			},
			product_name:{
				required: true,
				minlength:3,
				maxlength:20
			},
			product_code:{
				required:true,
				minlength:3,
				maxlength:50,
			},
			product_color:{
				required:true,
				minlength:3,
				maxlength:50,
			},
			price:{
				required:true,
				number:true
			},
			image:{
				required:true
			
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

	$("#edit_product").validate({
		rules:{
			category_id:{
                required: true
			},
			product_name:{
				required: true,
				minlength:3,
				maxlength:20
			},
			product_code:{
				required:true,
				minlength:3,
				maxlength:50,
			},
			product_color:{
				required:true,
				minlength:3,
				maxlength:50,
			},
			price:{
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
	 $('.deleteRecord').click(function(e){
		 let id = $(this).attr('rel');
		 let deleteFunction = $(this).attr('rel1');
		 swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
			cancelButtonClass: 'btn btn-default',
			confirmButtonClass: 'btn btn-danger',
		  },function(){
             window.location.href = "/admin/"+deleteFunction+"/"+id;
		  })
		 
	 });

	 $(document).ready(function(){
		let maxField = 10; //Input fields increment limitation
		let addButton = $('.add_button'); //Add button selector
		let wrapper = $('.field_wrapper'); //Input field wrapper
		//New HTML Element
		let fieldHTML = '<div class="field_wrapper" style="margin-left:180px; margin-top:5px"><div><input type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px;" />';
		fieldHTML += '<input type="text" name="size[]" id="size" placeholder="Size" style="width:120px;" />';
		fieldHTML += '<input type="text" name="price[]" id="price" placeholder="Price" style="width:120px;" />';
		fieldHTML += '<input type="text" name="stock[]" id="stock" placeholder="Stock" style="width:120px;" />';
		fieldHTML += '<a href="javascript:void(0);" class="remove_button btn btn-danger">Remove</a></div></div>';
		let x = 1; //Initial field counter is 1
		
		//Once add button is clicked
		$(addButton).click(function(){
			//Check maximum number of input fields
			if(x < maxField){ 
				x++; //Increment field counter
				$(wrapper).append(fieldHTML); //Add field html
			}
		});
		
		//Once remove button is clicked
		$(wrapper).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).parent('div').remove(); //Remove field html
			x--; //Decrement field counter
		});
	});


});
