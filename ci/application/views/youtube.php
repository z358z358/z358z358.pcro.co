<div class="container" id="youController" ng-controller="youController">	
	<div class="jumbotron">
		<h1>youtube 播放器</h1>
		<form name="you_form" method="get" ng-submit="submit()" role="form" action="" novalidate>
			<div id="you_form" class="form-group">
				<label for="exampleInputEmail1">網址</label>
				<input ng-model="youtube_url" id="youtube_url" type="url" name="youtube_url" class="form-control" placeholder="" required>
			</div>
			<input id="youtube_go" type="submit" class="btn btn-default" value="Go" ng-disabled="!you_form.$valid"><a href="#" onclick="$('#div_result').show();">或直接輸入含有youtube網址的文字</a>
		</form>
		<div id="div_result" class="hid">
			<textarea ng-model="html_youtube"  id="result" class="form-control" rows="3"></textarea>
			<a href="#" ng-click="get_video_id()" class="btn btn-default">Go</a>
		</div>
	</div>
	<div  ng-show="video_id.length" class="youtube_jum jumbotron">
		<div class="youtube resizable">
			<div id="player_youtube">

			</div>
		</div>
	</div>
	<div ng-show="video_id.length" id="list">
		<h4></h4>
		<table class="table table-hover table-striped">
		<tr ng-class="{'success': $index==count,'warning':key==last_id && $index!=count}" ng-repeat="key in video_id">
			<td>{{$index + 1}}</td>
			<td><a class="youtube_link" id="{{key}}" href="http://youtu.be/{{key}}" target="_blank"><span class="video_name">{{video_name[key]}}</span> http://youtu.be/{{key}}</a></td>
			<td class="jump"><a href="#" ng-click="jump_to($index)">播這首</a></td>
		</tr>
		</table>

	</div>

	<div class="row featurette">
		<div class="col-md-10">
			<h2 class="featurette-heading">使用說明.<span class="text-muted">貼上網址，按Go.</span></h2>
			<p class="lead">在欄位裡輸入網址，抓取該網頁的內容，然後列出youtube。<br>範例:<a href="?youtube_url=http%3A%2F%2Fwww.ptt.cc%2Fbbs%2FELSWORD%2FM.1409792311.A.883.html#">http://www.ptt.cc/bbs/ELSWORD/M.1409792311.A.883.html</a></p>
		</div>
	</div>
</div>	