<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-53250580-2', 'auto');
ga('require', 'displayfeatures');
ga('require', 'linkid', 'linkid.js');
ga('send', 'pageview');

</script>	
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdn.firebase.com/js/client/1.0.18/firebase.js"></script>
<script src="https://cdn.firebase.com/js/simple-login/1.6.1/firebase-simple-login.js"></script>
<script src="/js/jquery.blockUI.js"></script>
<script type="text/javascript">
$(document).ajaxStop($.unblockUI); 

// Firebase
var myRef = new Firebase("https://onininon.firebaseio.com");
var auth = new FirebaseSimpleLogin(myRef, function(error, user) {
	if (error) {
		// an error occurred while attempting login
		console.log(error);
	} else if (user) {
		// user authenticated with Firebase
		// console.log("User ID: " + user.uid + ", Provider: " + user.provider , user);
		$(".login_hide").hide();
		$(".logout_hide").show();
		$(".user_name a").html(user.displayName);
		$(".user_pic img").attr("src", user.thirdPartyUserData.picture.data.url);
	} else {
		// user is logged out
		$(".logout_hide").hide();
		$(".login_hide").show();
	}
});

function ajax_data(data){

	if(data["type"] == "input_error"){
		$("#" + data["tag_id"]).parents("div.form-group").addClass("has-error has-feedback").append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
	}
	else if(data["type"] == "html"){
		$("#" + data["tag_id"]).html(data["html"]);
	}
	else if(data["type"] == "ptt_table"){
		ptt_table(data);
	}
}
</script>
<script type="text/javascript">
$(document).ready(function() {
	// ajax
	$("body").on("click" , ".ajax_post" , function(){
		$.blockUI({'timeout':5000});
		var form = $(this).parents("form");
		if(form){
			$.post("<?php echo base_url();?>ajax" , form.serialize(), function(data) {
				ajax_data(data);
				//console.log(data);
			}, "json");
		}	
	});
});
</script>
<?php echo $js;?>
</body>
</html>