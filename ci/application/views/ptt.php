<div class="container" ng-controller="pttController">	
	<div class="jumbotron">
		<h1>Ptt推文計算</h1>
		<form name="ptt_form" role="form" novalidate>
			<div id="ptt_form" class="form-group">
				<label for="ptt_url">Ptt網頁版網址</label>
				<input ng-model="post_data.ptt_url" id="ptt_url" type="url" name="ptt_url" class="form-control" placeholder="範例:http://www.ptt.cc/bbs/Gossiping/M.1408188026.A.085.html" required>
			</div>
			<button id="ptt_go" type="button" class="btn btn-default" ng-click="ajax()" ng-disabled="!ptt_form.$valid">Go</button>
		</form>
	</div>
	<div id="ptt_result" ng-show="return_data.title">
		<h3 id="ptt_title">{{return_data.title}}</h3>
		<!-- Nav tabs -->
		<ul id="ptt_nav" class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#push_table" role="tab" data-toggle="tab">內容</a></li>
			<li><a href="#chart" role="tab" data-toggle="tab">分析</a></li>
			<!--<li><a href="#chart_table" role="tab" data-toggle="tab">分析table</a></li>-->
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane active" id="push_table">
				<p class="text-right">
					<label class="radio-inline"><input ng-model="setting.push_type" type="radio" name="push_type" id="inlineRadio0" value="">顯示全部</label>
					<label class="radio-inline"><input ng-model="setting.push_type" type="radio" name="push_type" id="inlineRadio1" value="推">只顯示推文</label>
					<label class="radio-inline"><input ng-model="setting.push_type" type="radio" name="push_type" id="inlineRadio2" value="→">只顯示箭頭</label>
					<label class="radio-inline"><input ng-model="setting.push_type" type="radio" name="push_type" id="inlineRadio3" value="噓">只顯示噓文</label>
				</p>
				<p class="text-right">
					顯示
					<label class="radio-inline"><input ng-model="setting.show1" type="checkbox" name="show1" id="inlineRadio00" value="1">樓</label>
					<label class="radio-inline"><input ng-model="setting.show2" type="checkbox" name="show2" id="inlineRadio10" value="1">類型</label>
					<label class="radio-inline"><input ng-model="setting.show3" type="checkbox" name="show3" id="inlineRadio20" value="1">id</label>
					<label class="radio-inline"><input ng-model="setting.show4" type="checkbox" name="show4" id="inlineRadio30" value="1">內容</label>
					<label class="radio-inline"><input ng-model="setting.show5" type="checkbox" name="show5" id="inlineRadio30" value="1">日期 時間</label>
				</p>
				<div id="push_table_content">
					<table ng-show="return_data.push" class="table table-hover table-striped"> 
						<thead>
							<tr>
								<!--<th ng-show="setting.push_type != ''">順序</th>-->
								<th ng-show="setting.show1">樓</th>
								<th ng-show="setting.show2">類型</th>
								<th ng-show="setting.show3">id</th>
								<th ng-show="setting.show4">內容</th>
								<th ng-show="setting.show5">日期 時間</th>
							</tr>
						</thead>
						<tbody> 
						<tr ng-repeat="val in return_data.push" ng-if="setting.push_type == '' || val.type == setting.push_type"> 
							<!--<td ng-show="setting.push_type != ''">{{$index++}}</td> -->
							<td ng-show="setting.show1">{{val.floor}}</td> 
							<td ng-show="setting.show2">{{val.type}}</td> 
							<td ng-show="setting.show3">{{val.id}}</td> 
							<td ng-show="setting.show4" ng-bind-html="val.content | to_trusted"></td>
							<td ng-show="setting.show5">{{val.month}}/{{val.month}} {{val.hour}}:{{val.mins}}</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="chart">
				<div class="google_chart" id="chart1"></div>
			</div>
			<!--<div class="tab-pane" id="chart_table">
				<div class="google_chart" id="chart2"></div>
			</div>-->
		</div>
	</div>

	<div class="row featurette">
		<div class="col-md-7">
			<h2 class="featurette-heading">使用說明.<span class="text-muted">貼上網址，按Go.</span></h2>
			<p class="lead">在欄位裡輸入Ptt網頁版網址，你可以在文章列表按Q(大寫)，或該文章的推文上方有網址。<br>範例:<a href="javascript:void(0)" ng-click="set_hash('http://www.ptt.cc/bbs/Gossiping/M.1413390067.A.57A.html')" >http://www.ptt.cc/bbs/Gossiping/M.1413390067.A.57A.html</a></p>
		</div>
		<div class="col-md-5">
			<img src="/img/example.png" alt="example" class="img-rounded" style="width:500px">
		</div>
	</div>
	<div class="row featurette">
		<div class="col-md-7">
			<h2 class="featurette-heading">例外說明.<span class="text-muted"></span></h2>
			<p class="lead">推文若被文章作者修改，該推文就無法被撈出。<br>如右圖:推文有被修改。</p>
		</div>
		<div class="col-md-5">
			<img src="/img/example2.png" alt="example" class="img-rounded" style="width:500px">
		</div>
	</div>
</div>