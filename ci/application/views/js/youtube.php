<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script type="text/javascript" id="youtube_api" src=""></script>
<script type="text/javascript" src="/js/jquery_cookie.js" charset="utf-8"></script>
<script type="text/javascript">
(function(){
	var app = angular.module('my' , []).filter('to_trusted', ['$sce', function($sce){
        return function(text) {
            if(text) return $sce.trustAsHtml(text);
        };
    }]);

	app.controller('youController' ,['$scope' , '$window' , function($scope , $window){
		$scope.youtube_url = '<?php echo $youtube_url;?>';
		$scope.html_youtube = '<?php echo $html_youtube;?>';
		$scope.video_id = [];
		$scope.video_name = {};
		$scope.last_id = $.cookie('last_id');
		$scope.count = 0;

		$scope.play_video = function(){
			if($scope.video_id == []) return;

			$("#player_youtube").replaceWith($('<div id="player_youtube"></div>'));
				player2 = new YT.Player('player_youtube', {
				videoId: $scope.video_id[$scope.count],
				events: {
					'onReady': onPlayerReady,
					'onStateChange': onPlayerStateChange,
					'onError': onPlayerError
				}
			});
			
			if(!$scope.video_name[$scope.video_id[$scope.count]]){
				var url = "http://gdata.youtube.com/feeds/api/videos/" + $scope.video_id[$scope.count] + "?v=2&alt=jsonc&&callback=showMyVideos";
				// 创建script标签，设置其属性
				var script = document.createElement('script');
				script.setAttribute('src', url);
				// 把script标签加入head，此时调用开始
				document.getElementsByTagName('head')[0].appendChild(script); 
			}

		};
	
		// 抓影片
		$scope.get_video_id = function(){
			var tmp2 = unique_video = [];
			var tmp;
			$scope.video_id = [];

			tmp = $scope.html_youtube.match(/watch\?v\=(\S{11})/g).toString().replaceArray("watch?v=" , "");
			if(tmp){
				tmp2 = tmp.toString().replaceArray("watch?v=" , "");
			}
			
			tmp = $scope.html_youtube.match(/youtu.be\/(\S{11})/g);
			if(tmp){
				tmp2 = tmp.toString().replaceArray("youtu.be/" , "").concat(tmp2);
			}

			// 過濾重複
			$.each(tmp2, function(i, el){
				if($.inArray(el, unique_video) === -1) unique_video.push(el);
			});
			

			$scope.video_id = unique_video;
			if($scope.video_id){
				$scope.play_video();
			}
			return;
		};

		$scope.jump_to = function(no){
			if($scope.video_id[no]) {
				$scope.count = no;
				$scope.play_video();
			}
		}

		// 抓影片名稱
		$window.showMyVideos = function(data){
			var scope = angular.element($("#youController")).scope();
			scope.$apply(function(){
				//console.log(data.data.id , data);
				scope.video_name[data.data.id] = data.data.title;
			});
		}

		// autoplay video
		$window.onPlayerReady = function(event){
			event.target.playVideo();
			//console.log('onPlayerReady');
		};

		$window.onPlayerStateChange = function(event){
			// 結束時放下一首
			if(event.data === 0) {     
				var scope = angular.element($("#youController")).scope();
			
				$.cookie('last_id', $scope.video_id[$scope.count], { expires: 365 });
				// 因為是從外面呼叫  所以變數需要透過$apply來改
				scope.$apply(function(){
					scope.last_id = $scope.video_id[$scope.count];
					scope.count++;
				});
				

				//console.log($scope);
				if(!($scope.count >= $scope.video_id.length)){
					$scope.play_video();
				}
				else{
					$scope.count = 0;
					$scope.play_video();
				}
			}
			//console.log('onPlayerStateChange');
		};

        // 有錯誤就撥下一首
        $window.onPlayerError = function(event){
            var scope = angular.element($("#youController")).scope();
            scope.$apply(function(){
                scope.last_id = $scope.video_id[$scope.count];
                scope.count++;
            });
            
            if(!($scope.count >= $scope.video_id.length)){
                $scope.play_video();
            }
            else{
                $scope.count = 0;
                $scope.play_video();
            }
        };

		if($scope.html_youtube != ''){
			$scope.get_video_id();
		}

	}]);

})();

String.prototype.replaceArray = function(find, replace) {
	  var replaceString = this;
	  for (var i = 0; i < replaceString.length; i++) {
		replaceString = replaceString.replace(find, replace);
	  }
	  return replaceString.split(",");
	};
</script>
<!--
<script type="text/javascript">
	String.prototype.replaceArray = function(find, replace) {
	  var replaceString = this;
	  for (var i = 0; i < replaceString.length; i++) {
		replaceString = replaceString.replace(find, replace);
	  }
	  return replaceString.split(",");
	};

	Array.prototype.my_unique = function() {
		var a = this.concat();//使用concat()再複製一份陣列，避免影響原陣列
		for(var i=0; i<a.length; ++i) {
			for(var j=i+1; j<a.length; ++j) {
				if(a[i] === a[j])
					a.splice(j, 1);
			}
		}
	 
		return a;
	};

    var video_id , video_id2;
	var played = [];
    // create youtube player
    var player2;
	var count = 0;

	function play_video() {
		$("#player_youtube").replaceWith($('<div id="player_youtube"></div>'));
        player2 = new YT.Player('player_youtube', {
          videoId: video_id[count],
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
			'onError': onPlayerStateChange
          }
        });
		
		if($("#" + video_id[count] + " .video_name").html() == ""){
			var url = "http://gdata.youtube.com/feeds/api/videos/" + video_id[count] + "?v=2&alt=jsonc&&callback=showMyVideos";
			// 创建script标签，设置其属性
			var script = document.createElement('script');
			script.setAttribute('src', url);
			// 把script标签加入head，此时调用开始
			document.getElementsByTagName('head')[0].appendChild(script); 
		}
    };

	function get_video_id(){
		video_id = [];
		var tmp = $("#result").val().match(/watch\?v\=(...........)/g);
		if(tmp){
			video_id = $("#result").val().match(/watch\?v\=(...........)/g).toString().replaceArray("watch?v=" , "");
		}
		tmp = $("#result").val().match(/youtu.be\/(...........)/g);
		if(tmp){
			video_id2 = $("#result").val().match(/youtu.be\/(...........)/g).toString().replaceArray("youtu.be/" , "");
			video_id = video_id.concat(video_id2).my_unique();
		}
		var unique_video = [];
		$.each(video_id, function(i, el){
			if($.inArray(el, unique_video) === -1) unique_video.push(el);
		});
		video_id = unique_video;
		var textt = "";
		for (var i = 0; i < video_id.length; i++) {
			textt += '<tr><td>' + (i+1) + '<td><td><a class="youtube_link" id="'+video_id[i]+'" href="http://youtu.be/'+video_id[i]+'" target="_blank"><span class="video_name"></span>http://youtu.be/'+video_id[i]+'</a></td><td class="jump" data-vid="'+video_id[i]+'" data-count="'+i+'"><a href="#">播這首</a></td></tr>';
		}
		$("#list").html('<h4>找到' + video_id.length + '首</h4><table class="table table-hover table-striped"><thead><tr><th></th><th></th><th></th></tr></thead><tbody>' +  textt + '</tbody></table>' );
		count = 0;
		play_video();
		$(".youtube_jum").show();
		$.cookie('youtube_url', $("#youtube_url").val(), { expires: 365 });
	};

    // autoplay video
    function onPlayerReady(event) {
		var last_id = $.cookie('last_id');
		$(".youtube_link").parents("tr").removeClass("warning success");
		if(last_id){
			$("#" + last_id + ".youtube_link").parents("tr").addClass("warning");
		}
		$("#" + video_id[count] + ".youtube_link").parents("tr").addClass("success");


		
        event.target.playVideo();
    };

    // when video ends
    function onPlayerStateChange(event) {        
        if(event.data === 0) {         
			$.cookie('last_id', video_id[count], { expires: 365 });
            count++;
			if(!(count >= video_id.length)){
				play_video();
			}
			else{
				count = 0;
				play_video();
			}
        }
		//console.log(event);
    }; 

	function showMyVideos(data){
		$("#" + video_id[count] + " .video_name").html(data['data']['title']);
	}
</script>
<script type="text/javascript">
$(document).ready(function() {
	$( ".resizable" ).resizable();

	if($("#result").val()){
		get_video_id();
	}

	$("#list").on("click" , ".jump" , function(){
		var this_count = parseInt($(this).data("count"));
		if(this_count >= 0){
			count = this_count;
			play_video();
		}
	});

	var cookie_url = $.cookie('youtube_url'); 
	if(cookie_url && $("#youtube_url").val() == ""){
		$("#youtube_url").val(cookie_url);
	}
});
</script>-->