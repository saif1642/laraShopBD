/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

//Select Product Size

$(document).ready(function(){
    //Get Product price with size
	$('#selSize').change(function(){
		let idSize= $(this).val();
		$.ajax({
			type:'get',
			url:'/get-product-price',
			data:{idSize:idSize},
			success:function(resp){
				 //alert(resp);
				 let arr = resp.split('#');
				 $('#getPrice').html("US $"+arr[0]);
				 $('#price').val(arr[0]);
				 if(arr[1]==0){
					 $('#cartbtn').hide();
					 $('#availability').text('Out of Stock');
				 }else{
					$('#cartbtn').show();
					$('#availability').text('In Stock');
				 }
			},error:function(){
				alert("Error");
			}
		})		
		
	});
    //replace main image with alternate Image 
});

$(document).ready(function(){
    //replace main image with alternate Image 
	$('.changeImage').click(function(){
		 let image= $(this).attr('src');
		 $('.mainImage').attr('src',image);
		
	});
    
});

// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();

// Setup thumbnails example
var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

$('.thumbnails').on('click', 'a', function(e) {
	var $this = $(this);

	e.preventDefault();

	// Use EasyZoom's `swap` method
	api1.swap($this.data('standard'), $this.attr('href'));
});

// Setup toggles example
var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

$('.toggle').on('click', function() {
	var $this = $(this);

	if ($this.data("active") === true) {
		$this.text("Switch on").data("active", false);
		api2.teardown();
	} else {
		$this.text("Switch off").data("active", true);
		api2._init();
	}
});
//Existing user message
$().ready(function(){
	//validate on keyup and submit
	$('#registerForm').validate({
		rules:{
			name:{
				required:true,
				minLength:2,
				lettersonly:true
			},
			password:{
				required:true,
				minLength:6,

			},
			email:{
				required:true,
				email:true,
				remote:"/check-email"
			}
		},
		messages:{
			name:"Please Enter Your name",
			password:{
				minLength:"Password must be 6 Characters long"
			},
			email:{
				required:"please enter an email",
				email:"Please enter a valid email",
				remote:"Email already exists!"
			}
		}

	});
	$('#loginForm').validate({
		rules:{
			
			password:{
				required:true,

			},
			email:{
				required:true,
				email:true,
			}
		},
		messages:{
			password:"Please enter your password",
			email:{
				required:"please enter an email",
				email:"Please enter a valid email",
			}
		}

	});

	$('#password').passtrength({
		tooltip: true,
		textWeak: "Weak",
		textMedium: "Medium",
		textStrong: "Strong",
		textVeryStrong: "Very Strong",
		eyeImg : "images/frontend_images/eye.svg"
	});
});
