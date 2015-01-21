<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});

(function(){
	var app = angular.module('my' , []).filter('to_trusted', ['$sce', function($sce){
        return function(text) {
            if(text) return $sce.trustAsHtml(text);
        };
    }]);

	app.controller('pttController' ,['$scope' , '$http' , function($scope , $http){
		// angular要設定headers
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		$scope.return_data = {};
		$scope.post_data = {
			'post_type' : 'ptt',
		};
		$scope.setting = {
			'push_type' : '',
			'show1' : true,
			'show2' : true,
			'show3' : true,
			'show4' : true,
			'show5' : true,
		};

		$scope.ajax = function(){
			$http.post('<?php echo base_url();?>ajax' , $.param($scope.post_data)).success(function(data, status, headers, config) {
				$scope.return_data = data.data;
				if($scope.return_data){
					window.location.hash = $scope.post_data.ptt_url;
					// google chart
					var a = [['Task', 'Hours per Day']];
					for(var t in $scope.return_data.google_chart){
						a.push([t ,$scope.return_data.google_chart[t]]);
					}
					google.setOnLoadCallback(drawChart('chart1' , '推 噓 箭頭 分佈' , a));
				}
			});
		};

		$scope.set_hash = function(tmp_hash){
			window.location.hash = tmp_hash;
			$scope.init();
		};

		$scope.init = function(){
			var t_hash = window.location.hash.substring(1);
			if(t_hash.length){
				$scope.post_data.ptt_url = t_hash;
				$scope.ajax();
				//angular.element('#ptt_go').triggerHandler('click');
			}
		}

		$scope.init();
	}]);

})();

function drawChart(pid , ptitle , pdata){
	var data = google.visualization.arrayToDataTable(pdata);

	var options = {
	  'title': ptitle,
	  'width':380,
      'height':285
	};

	var chart = new google.visualization.PieChart(document.getElementById(pid));

	chart.draw(data, options);
}
</script>

<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
var clog;
var tmp_data;
google.load("visualization", "1", {packages:["corechart"]});
google.load("visualization", "1", {packages:["table"]});

function ptt_table(data){

	var d = {};
	d['t'] = {};
	d['i'] = {};
	var r = '<p class="bg-danger">找不到頁面或該文章無推文!</p>';
	if(!data["data"]["push"]){
		$("#ptt_result").html(r).show();
		return;
	}

	var push_type = $("input[name='push_type']:checked").val();
	var t = data["data"]["push"];
	var i = 1;

	r = ' ';
	for(var k in t){
		tm = t[k];
		d['t'][tm['type']] = (d['t'][tm['type']]) ? (d['t'][tm['type']] + 1) :1;
		d['i'][tm['id']] = d['i'][tm['id']] || {};
		//d['i'][tm['id']][tm['type']] = (d['i'][tm['id']][tm['type']]) ? (d['i'][t[k]['id']][tm['type']] + 1) :1;
		if(push_type){
			if(push_type != tm['type']){
				continue;
			}
			k = i;
		}

		r = r + '<tr> <td>' + k + '</td> <td>' + tm['type'] + '</td> <td>' + tm['id'] + '</td> <td>' + tm['content'] + '</td> <td>' + tm['month'] + '/' + tm['day'] + ' ' + tm['hour'] + ':' + tm['mins'] + '</td>  </tr>';
		i++;
	}

	var a = [['Task', 'Hours per Day']];
	for(var t in d['t']){
		a.push([t ,d['t'][t]]);
	}

	var b = [['Task', 'Hours per Day']];
	//for(var t in d['i']){
	//	b.push([t ,d['i'][t]]);
	//}
	//console.log(d,a,b);
	var ta = '';
	ta = ta + '<table class="table table-hover table-striped"> <thead><tr><th>樓</th><th>類型</th><th>id</th><th>內容</th><th>日期 時間</th></tr></thead><tbody>' + r + '</tbody>';


	$("#ptt_result #push_table_content").html(ta);
	$("#ptt_result #ptt_title").html('<a href="' + data["data"]["ptt_url"] + '">' + data["data"]["title"] + '</a>');
	// 留hash
	window.location.hash = $("#ptt_url").val();
	$("#ptt_form").removeClass("has-error has-feedback").find(".glyphicon-remove.form-control-feedback").hide();

	google.setOnLoadCallback(drawChart('chart1' , '推 噓 箭頭 分佈' ,a ));
	//google.setOnLoadCallback(drawTable('chart2' ,b ));
	//google.setOnLoadCallback(drawChart('chart3' , '推噓箭頭分佈' ,a ));

	$("#ptt_result").show();

	// 隱藏沒勾的
	$("#push_table input:checkbox:not(:checked)").each(function(){
		var c_val = $(this).val();
		$('#push_table_content td:nth-child(' + c_val + '),#push_table_content th:nth-child(' + c_val + ')').hide();
	});

	tmp_data = data;

}

function drawChart(pid , ptitle , pdata){
	var data = google.visualization.arrayToDataTable(pdata);

	var options = {
	  'title': ptitle,
	  'width':380,
      'height':285
	};

	var chart = new google.visualization.PieChart(document.getElementById(pid));

	chart.draw(data, options);
}

function drawTable(pid , pdata) {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'id');
	data.addColumn('number', 'Salary');
	data.addColumn('boolean', 'Full Time Employee');

	data.addRows([
	['Mike',  {v: 10000, f: '$10,000'}, true],
	['Jim',   {v:8000,   f: '$8,000'},  false],
	['Alice', {v: 12500, f: '$12,500'}, true],
	['Bob',   {v: 7000,  f: '$7,000'},  true]
	]);

	var table = new google.visualization.Table(document.getElementById(pid));

	table.draw(data, {showRowNumber: true});
}

function check_hash(url){
	if(url){
		window.location.hash = url;
	}
	var t_hash = window.location.hash.substring(1);
	if(t_hash.length){
		$("#ptt_url").val(t_hash);
		$("#ptt_go").trigger("click");
	}
}
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#ptt_result").hide();
	check_hash();

	$('#ptt_nav a').click(function (e) {
	  e.preventDefault();
	  $(this).tab('show');
	})

	$("#push_table input").change(function(){
		  ptt_table(tmp_data);
	});  
});
</script>-->