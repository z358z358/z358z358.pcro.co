<?php

/* ptt.html */
class __TwigTemplate_779c7ed0c9061fb8119b0aabc972b83ff39716331c17b6eda0acbf5b75d22b2a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout.html");

        $this->blocks = array(
            'container' => array($this, 'block_container'),
            'js' => array($this, 'block_js'),
            'ready_js' => array($this, 'block_ready_js'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_container($context, array $blocks = array())
    {
        // line 4
        echo "<div class=\"jumbotron\">
\t<h1>Ptt推文計算</h1>
\t<form role=\"form\">
\t\t<div id=\"ptt_form\" class=\"form-group\">
\t\t\t<label for=\"exampleInputEmail1\">Ptt網頁版網址</label>
\t\t\t<input id=\"ptt_url\" type=\"text\" name=\"ptt_url\" class=\"form-control\" placeholder=\"範例:http://www.ptt.cc/bbs/Gossiping/M.1408188026.A.085.html\">
\t\t</div>
\t\t<input type=\"hidden\" name=\"post_type\" value=\"ptt\">
\t\t<button id=\"ptt_go\" type=\"button\" class=\"ajax_post btn btn-default\">Go</button>
\t</form>
</div>
<div id=\"ptt_result\">
\t<h3 id=\"ptt_title\"></h3>
\t<!-- Nav tabs -->
\t<ul id=\"ptt_nav\" class=\"nav nav-tabs\" role=\"tablist\">
\t\t<li class=\"active\"><a href=\"#push_table\" role=\"tab\" data-toggle=\"tab\">內容</a></li>
\t\t<li><a href=\"#chart\" role=\"tab\" data-toggle=\"tab\">分析</a></li>
\t\t<!--<li><a href=\"#chart_table\" role=\"tab\" data-toggle=\"tab\">分析table</a></li>-->
\t</ul>

\t<!-- Tab panes -->
\t<div class=\"tab-content\">
\t\t<div class=\"tab-pane active\" id=\"push_table\">
\t\t\t<p class=\"text-right\">
\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"push_type\" id=\"inlineRadio0\" value=\"\" checked>顯示全部</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"push_type\" id=\"inlineRadio1\" value=\"推\">只顯示推文</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"push_type\" id=\"inlineRadio2\" value=\"→\">只顯示箭頭</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"radio\" name=\"push_type\" id=\"inlineRadio3\" value=\"噓\">只顯示噓文</label>
\t\t\t</p>
\t\t\t<p class=\"text-right\">
\t\t\t\t顯示
\t\t\t\t<label class=\"radio-inline\"><input type=\"checkbox\" name=\"show1\" id=\"inlineRadio00\" value=\"1\" checked>樓</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"checkbox\" name=\"show2\" id=\"inlineRadio10\" value=\"2\" checked>類型</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"checkbox\" name=\"show3\" id=\"inlineRadio20\" value=\"3\" checked>id</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"checkbox\" name=\"show4\" id=\"inlineRadio30\" value=\"4\" checked>內容</label>
\t\t\t\t<label class=\"radio-inline\"><input type=\"checkbox\" name=\"show5\" id=\"inlineRadio30\" value=\"5\" checked>日期 時間</label>
\t\t\t</p>
\t\t\t<div id=\"push_table_content\"></div>
\t\t</div>
\t\t<div class=\"tab-pane\" id=\"chart\">
\t\t\t<div class=\"google_chart\" id=\"chart1\"></div>
\t\t</div>
\t\t<!--<div class=\"tab-pane\" id=\"chart_table\">
\t\t\t<div class=\"google_chart\" id=\"chart2\"></div>
\t\t</div>-->
\t</div>
</div>

<div class=\"row featurette\">
\t<div class=\"col-md-7\">
\t\t<h2 class=\"featurette-heading\">使用說明.<span class=\"text-muted\">貼上網址，按Go.</span></h2>
\t\t<p class=\"lead\">在欄位裡輸入Ptt網頁版網址，你可以在文章列表按Q(大寫)，或該文章的推文上方有網址。<br>範例:<a href=\"javascript:void(0)\" onclick=\"check_hash('http://www.ptt.cc/bbs/Gossiping/M.1413390067.A.57A.html');\">http://www.ptt.cc/bbs/Gossiping/M.1413390067.A.57A.html</a></p>
\t</div>
\t<div class=\"col-md-5\">
\t\t<img src=\"/img/example.png\" alt=\"example\" class=\"img-rounded\" style=\"width:500px\">
\t</div>
</div>
<div class=\"row featurette\">
\t<div class=\"col-md-7\">
\t\t<h2 class=\"featurette-heading\">例外說明.<span class=\"text-muted\"></span></h2>
\t\t<p class=\"lead\">推文若被文章作者修改，該推文就無法被撈出。<br>如右圖:推文有被修改。</p>
\t</div>
\t<div class=\"col-md-5\">
\t\t<img src=\"/img/example2.png\" alt=\"example\" class=\"img-rounded\" style=\"width:500px\">
\t</div>
</div>

";
    }

    // line 73
    public function block_js($context, array $blocks = array())
    {
        // line 74
        echo "<script type=\"text/javascript\" src=\"https://www.google.com/jsapi\"></script>
<script type=\"text/javascript\">
var clog;
var tmp_data;
google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
google.load(\"visualization\", \"1\", {packages:[\"table\"]});

function ptt_table(data){

\tvar d = {};
\td['t'] = {};
\td['i'] = {};
\tvar r = '<p class=\"bg-danger\">找不到頁面或該文章無推文!</p>';
\tif(!data[\"data\"][\"push\"]){
\t\t\$(\"#ptt_result\").html(r).show();
\t\treturn;
\t}

\tvar push_type = \$(\"input[name='push_type']:checked\").val();
\tvar t = data[\"data\"][\"push\"];
\tvar i = 1;

\tr = ' ';
\tfor(var k in t){
\t\ttm = t[k];
\t\td['t'][tm['type']] = (d['t'][tm['type']]) ? (d['t'][tm['type']] + 1) :1;
\t\td['i'][tm['id']] = d['i'][tm['id']] || {};
\t\t//d['i'][tm['id']][tm['type']] = (d['i'][tm['id']][tm['type']]) ? (d['i'][t[k]['id']][tm['type']] + 1) :1;
\t\tif(push_type){
\t\t\tif(push_type != tm['type']){
\t\t\t\tcontinue;
\t\t\t}
\t\t\tk = i;
\t\t}

\t\tr = r + '<tr> <td>' + k + '</td> <td>' + tm['type'] + '</td> <td>' + tm['id'] + '</td> <td>' + tm['content'] + '</td> <td>' + tm['month'] + '/' + tm['day'] + ' ' + tm['hour'] + ':' + tm['mins'] + '</td>  </tr>';
\t\ti++;
\t}

\tvar a = [['Task', 'Hours per Day']];
\tfor(var t in d['t']){
\t\ta.push([t ,d['t'][t]]);
\t}

\tvar b = [['Task', 'Hours per Day']];
\t//for(var t in d['i']){
\t//\tb.push([t ,d['i'][t]]);
\t//}
\t//console.log(d,a,b);
\tvar ta = '';
\tta = ta + '<table class=\"table table-hover table-striped\"> <thead><tr><th>樓</th><th>類型</th><th>id</th><th>內容</th><th>日期 時間</th></tr></thead><tbody>' + r + '</tbody>';


\t\$(\"#ptt_result #push_table_content\").html(ta);
\t\$(\"#ptt_result #ptt_title\").html('<a href=\"' + data[\"data\"][\"ptt_url\"] + '\">' + data[\"data\"][\"title\"] + '</a>');
\t// 留hash
\twindow.location.hash = \$(\"#ptt_url\").val();
\t\$(\"#ptt_form\").removeClass(\"has-error has-feedback\").find(\".glyphicon-remove.form-control-feedback\").hide();

\tgoogle.setOnLoadCallback(drawChart('chart1' , '推 噓 箭頭 分佈' ,a ));
\t//google.setOnLoadCallback(drawTable('chart2' ,b ));
\t//google.setOnLoadCallback(drawChart('chart3' , '推噓箭頭分佈' ,a ));

\t\$(\"#ptt_result\").show();

\t// 隱藏沒勾的
\t\$(\"#push_table input:checkbox:not(:checked)\").each(function(){
\t\tvar c_val = \$(this).val();
\t\t\$('#push_table_content td:nth-child(' + c_val + '),#push_table_content th:nth-child(' + c_val + ')').hide();
\t});

\ttmp_data = data;

}

function drawChart(pid , ptitle , pdata){
\tvar data = google.visualization.arrayToDataTable(pdata);

\tvar options = {
\t  'title': ptitle,
\t  'width':380,
      'height':285
\t};

\tvar chart = new google.visualization.PieChart(document.getElementById(pid));

\tchart.draw(data, options);
}

function drawTable(pid , pdata) {
\tvar data = new google.visualization.DataTable();
\tdata.addColumn('string', 'id');
\tdata.addColumn('number', 'Salary');
\tdata.addColumn('boolean', 'Full Time Employee');

\tdata.addRows([
\t['Mike',  {v: 10000, f: '\$10,000'}, true],
\t['Jim',   {v:8000,   f: '\$8,000'},  false],
\t['Alice', {v: 12500, f: '\$12,500'}, true],
\t['Bob',   {v: 7000,  f: '\$7,000'},  true]
\t]);

\tvar table = new google.visualization.Table(document.getElementById(pid));

\ttable.draw(data, {showRowNumber: true});
}

function check_hash(url){
\tif(url){
\t\twindow.location.hash = url;
\t}
\tvar t_hash = window.location.hash.substring(1);
\tif(t_hash.length){
\t\t\$(\"#ptt_url\").val(t_hash);
\t\t\$(\"#ptt_go\").trigger(\"click\");
\t}
}
</script>
";
    }

    // line 194
    public function block_ready_js($context, array $blocks = array())
    {
        // line 195
        echo "\$(\"#ptt_result\").hide();
check_hash();

\$('#ptt_nav a').click(function (e) {
  e.preventDefault();
  \$(this).tab('show');
})

\$(\"#push_table input\").change(function(){
\t  ptt_table(tmp_data);
});  
";
    }

    public function getTemplateName()
    {
        return "ptt.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  232 => 195,  229 => 194,  107 => 74,  104 => 73,  33 => 4,  30 => 3,);
    }
}
