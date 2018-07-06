$(document).ready(function() {
	$(".username").blur(function() {
		$(".user-icon").css("left","-50px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","calc(50% - 38px)");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","-50px");
	});
	
	$(".email").focus(function() {
		$(".email-icon").css("left","calc(50% - 302px)");
	});
	$(".email").blur(function() {
		$(".email-icon").css("left","-50px");
	});
	
	$(".qiwi").focus(function() {
		$(".qiwi-icon").css("left","calc(50% - 38px)");
	});
	$(".qiwi").blur(function() {
		$(".qiwi-icon").css("left","-50px");
	});

	$(".username").focus(function() {
		$(".user-icon").css("left","calc(50% - 302px)");
	});
});