<style>
.wind{
	width:100px;
	height:100px;
	font-size: 60px;
}
.red{
	color:red;
}
</style>
<script type="text/javascript" src="/js/moment.js" charset="utf-8"></script>
<script type="text/javascript" src="/js/jquery_cookie.js" charset="utf-8"></script>
<script type="text/javascript">
var onbeforeunload_tag = false;
window.onbeforeunload = function confirmExit(){
	if (onbeforeunload_tag) return '離開此頁紀錄將會清空，確定離開本頁面？';
}


(function(){
	var app = angular.module('my' , []).filter('to_trusted', ['$sce', function($sce){
        return function(text) {
            if(text) return $sce.trustAsHtml(text);
        };
    }]);

	app.filter('fromNow', function() {
	  return function(date) {
		return moment(date).fromNow();
	  }
	});

	app.filter('num', function() {
		return function(input) {
		  return parseInt(input, 10);
		}
	});

	app.controller('mjController' ,['$scope' , function($scope){
		var tmp_cookie = ($.cookie('mj_user'))?$.cookie('mj_user').split(","):false;
		$scope.users = (tmp_cookie)? tmp_cookie : ['玩家1' , '玩家2' , '玩家3' , '玩家4'];
		$scope.users_money = [0 , 0 , 0 , 0];
		$scope.user_form = false;
		$scope.user_wind_form = false;
		$scope.user_wind_form_count = 0;
		$scope.final = [0 , 0 , 0 , 0];
		$scope.user_wind = [0 , 1 , 2 , 3];
		$scope.winds = ['東' , '南' , '西' , '北'];
		$scope.basic = 2; // 底幾台
		$scope.point = 10; // 一台多少錢
		$scope.money = 1000; // 初始金額
		$scope.winner = '';
		$scope.str_go = 'Go';
		$scope.check = false;
		$scope.del_check = false;

		$scope.wind_count = 0; // 哪個風
		$scope.wind_no = 0; // 在哪個風 東風東=0 東風南=1 北風北=15
		$scope.banker = 0; // 誰是莊
		$scope.banker_count = 0; // 連莊數

		$scope.next_banker_count = 0; // 下一輪 莊連
		$scope.same_banker = 0; // 下一輪莊是否同一個
		// 紀錄 時間  玩家1 玩家2 玩家3 玩家4 哪個風
		$scope.logs = []; 

		$scope.tmp_users = $scope.users.slice(0);

		// 初始化
		$scope.init = function(){
			//$scope.winner = $scope.users[0];
			//$scope.loser = $scope.users[1];
			$scope.del_check = false;
			$scope.final = [0 , 0 , 0 , 0];
			$scope.next_banker_count = 0;
			$scope.refresh_money();
			$scope.same_banker = 0;

		}

		// 統計
		$scope.refresh_money = function(){
			var tmp = $scope.wind_no % 4;// 哪個風當莊
			$scope.wind_count = parseInt($scope.wind_no / 4);
			$scope.banker = (arraySearch($scope.user_wind,tmp));
			$scope.users_money = [0 , 0 , 0 , 0];

			for(var log1 in $scope.logs){
				for(var count in $scope.users_money){
					count = parseInt(count, 10);
					$scope.users_money[count] += $scope.logs[log1][count]; 
					//console.log($scope.users_money , $scope.logs[log1] , count);
				}
			}
		}

		$scope.save_user = function(){
			$scope.users = $scope.tmp_users.slice(0);
			$scope.user_form = false;
			$.cookie('mj_user', $scope.users.slice(0), { expires: 365 });
		}

		$scope.set_wind = function(type){
			// 開始
			if(type == -1){
				$scope.user_wind_form = true;
				$scope.user_wind_form_count = 0;
				$scope.user_wind = [-1 , -1 , -1 , -1];
			}
			else{
				$scope.user_wind[$scope.user_wind_form_count] = type;
				
				$scope.user_wind_form_count++;
				// 選完了
				if($scope.user_wind_form_count == 4){
					$scope.init();
					$scope.user_wind_form = false;
					$scope.user_wind_form_count = 0;

				}
			}	
			console.log(type , $scope.user_wind_form_count);
		}

		$scope.check_is_set = function(num){
			return ($scope.user_wind.indexOf(num) === -1)? true : false;
		}

		// 新增資料
		$scope.add_log = function(){
			// 還沒算
			if($scope.check == false){
				$scope.same_banker = 0;
				$scope.final = [0 , 0 , 0 , 0];
				$scope.next_banker_count = 0;

				var tmp_point = $scope.win_point;
				var banker_point = ($scope.banker_count * 2) + 1; // 連莊台數

				// 莊家胡了
				if($scope.winner == $scope.banker){
					$scope.next_banker_count = $scope.banker_count + 1;
					tmp_point += banker_point;
					$scope.same_banker = 1;
				}
				// 莊家被胡
				else if($scope.loser == $scope.banker){
					tmp_point += banker_point;

				}
				
				if($scope.win_type == '自摸'){
					tmp_point *= -1;
					// 莊家自摸
					if($scope.winner == $scope.banker){
						$scope.final = [tmp_point , tmp_point , tmp_point , tmp_point];
						$scope.final[$scope.winner] = tmp_point * -3;
						$scope.same_banker = 1;
					}
					else {
						var banker = tmp_point - banker_point;
						$scope.final = [tmp_point , tmp_point , tmp_point , tmp_point];
						$scope.final[$scope.banker] = banker;
						$scope.final[$scope.winner] = (banker + tmp_point*2) * -1;
					}
				}
				else if($scope.win_type == '臭莊'){
					$scope.next_banker_count = $scope.banker_count + 1;
					$scope.same_banker = 1;
				}
				else if($scope.win_type == '胡了'){
					$scope.final[$scope.winner] = tmp_point;
					$scope.final[$scope.loser] = -1 * tmp_point;

				}
				$scope.check = true;
				
			}
			// 塞紀錄
			else{
				var tmp = $scope.final;
				tmp.push(new Date().valueOf());
				tmp.push($scope.wind_no);
				
				$scope.logs.unshift(tmp);
				console.log($scope.logs , tmp);

				$scope.banker_count = $scope.next_banker_count;
				if($scope.same_banker == 0){
					$scope.wind_no++;
				}
				$scope.wind_no = ($scope.wind_no > 15) ? 0 : $scope.wind_no;
				$scope.check = false;

				$scope.init();

                // 離開頁面的詢問
                onbeforeunload_tag = true;
			}			
		}

		// 刪紀錄
		$scope.del_log = function(){
			// 有連莊
			if($scope.banker_count > 0){
				$scope.banker_count--;
			}
			else if($scope.wind_no > 0){
				$scope.wind_no--;
			}

			$scope.logs.shift();
			$scope.init();
		}

		$scope.init();

	}]);

})();

function arraySearch(arr,val) {
for (var i=0; i<arr.length; i++)
	if (arr[i] === val)                    
		return i;
return false;
}
</script>