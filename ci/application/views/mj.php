<div class="container container-fluid" id="mjController" ng-controller="mjController">	
	<div class="container-fluid">
		<div class="row">
			<h1 class="page-header">麻將紀錄</h1>
			<div ng-show="user_form">
				<form class="form-horizontal" role="form" novalidate>
					<div class="form-group" ng-repeat="user in users">
						<label class="col-sm-2 control-label">玩家{{$index+1}}</label>
						<div class="col-sm-10">
							<input ng-model="tmp_users[$index]" type="text" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button ng-click="save_user()" type="button" class="btn btn-default">確定</button>
						</div>
					</div>
				</form>
			</div>

			<div ng-show="user_wind_form">
				<form class="form-horizontal" role="form" novalidate>
					<div class="form-group">
						<div class="col-sm-2">
								{{users[user_wind_form_count]}}是
						</div>
						<div class="col-sm-10">							
							<button class="btn btn-default btn-lg" ng-repeat="(key , wind) in winds" ng-click="set_wind(key)" ng-if="check_is_set(key)">{{wind}}</button>
						</div>
					</div>
				</form>
			</div>

			<button ng-hide="user_form" ng-click="user_form=true">點此修改玩家名稱</button>
			<button ng-hide="user_wind_form" ng-click="set_wind(-1)">點此修改玩家風位</button>
			<p>現在是 {{winds[wind_count]}}風{{winds[wind_no%4]}}， {{users[banker]}}當莊 ，連莊數:{{banker_count}}</p>
			<div class="placeholders">
				<div ng-class="{'bg-danger':banker==$index}" class="col-sm-3 placeholder" ng-repeat="user in users">
					<!--<div class="wind">{{winds[$index]}}</div>-->
					<h4 >{{user}}</h4>
					<span class="text-muted">{{winds[user_wind[$index]]}}</span>
					<span class="text-muted">{{users_money[$index]}}</span>
				</div>
			</div>

			<h2 class="sub-header">寫記錄</h2>
			<div class="">
				<form class="form-horizontal" role="form" novalidate>
					<div ng-hide="check">
						<div class="form-group">
							<div class="col-sm-2">
								1.選誰胡了
							</div>
							<div class="col-sm-10">
								<label class="radio-inline" ng-repeat="user in users">
									<input ng-model="$parent.winner" type="radio" name="winner" value="{{$index}}"> {{user}}
								</label>
							</div>
						</div>

						<!--<select class="form-control" ng-model="winner" ng-options="name for name in users"></select>-->
						<div class="form-group">
							<div class="col-sm-2">
								2.類型
							</div>
							<div class="col-sm-10">
								<label class="radio-inline">
									<input ng-model="win_type" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="胡了" /> 胡了
								</label>
								<label class="radio-inline">
									<input ng-model="win_type" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="自摸" /> 自摸
								</label>
								<label class="radio-inline">
									<input ng-model="win_type" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="臭莊" /> 臭莊、流局
								</label>
							</div>
						</div>

						<div class="form-group" ng-show="win_type==='胡了'">
							<div class="col-sm-2">
								3.誰被胡
							</div>
							<div class="col-sm-10">
								<label class="radio-inline" ng-repeat="user in users" ng-hide="$index==winner">
									<input ng-model="$parent.loser" type="radio" name="loser" value="{{$index}}"> {{user}}
								</label>
							</div>
						</div>

						<div ng-hide="win_type==='臭莊'" class="form-group">
							<label class="col-sm-3 control-label">台(包含底；不含莊家、莊連拉的台數)</label>
							<div class="col-sm-9">
								<input ng-model="win_point" name="win_point" class="form-control" type="number" require />
							</div>					
						</div>
					</div>

					<div class="final" ng-show="check">
						<h2 class="sub-header">異動明細</h2>
						<div class="form-group">
							<div class="col-sm-3" ng-repeat="user in users">
								{{user}}<input ng-model="final[$index]" type="number" class="form-control" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-2">
							{{users[banker]}}繼續當莊?
							</div>
							<div class="col-sm-10">
								<label class="radio-inline">
									<input ng-model="same_banker" type="radio" value="1"> 是
								</label><label class="radio-inline">
									<input ng-model="same_banker" type="radio" value="0"> 否
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-1 control-label">連莊數:</label>
							<div class="col-sm-11">
								<input ng-model="next_banker_count" name="next_banker_count" class="form-control" type="number" />
							</div>				
						</div>
					</div>

					<div class="">
						<button type="button" ng-click="add_log()" class="btn btn-primary">{{str_go}}</button>
						<button type="button" ng-show="check" ng-click="check=false" class="btn btn-default">上一步</button>
					</div>
				</form>  
			</div>

			<h2 class="sub-header">記錄區</h2>
			<button type="button" ng-show="logs.length && !del_check" ng-click="del_check=true" class="btn btn-danger">刪除最新一筆紀錄</button>
			<button type="button" ng-show="del_check" ng-click="del_log()" class="btn btn-danger">刪除無法復原 確定要刪?</button>
			<button type="button" ng-show="del_check" ng-click="del_check=false" class="btn btn-default">不要</button>

			<div class="table-responsive">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>時間</th>
							<th ng-repeat="user in users">{{user}}</th> 
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="log in logs" ng-init="tmp_wind_count = (log[5]/4 | num)">
						<!--<td>{{log[5]/4}} {{wind_count}}</td>-->
							<td>{{log[4] | date:'shortTime'}} {{winds[tmp_wind_count]}}風{{winds[log[5]%4]}}</td>
							<td ng-class="{red:log[0]<0}">{{log[0]}}</td>
							<td ng-class="{red:log[1]<0}">{{log[1]}}</td>
							<td ng-class="{red:log[2]<0}">{{log[2]}}</td>
							<td ng-class="{red:log[3]<0}">{{log[3]}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>	