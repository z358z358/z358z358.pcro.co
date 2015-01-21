<?php

/* youtube.html */
class __TwigTemplate_b895a2523c9a3f2c0ca173b2ea63b63b0eb2bfefbeccd734e44519ee16981f4e extends Twig_Template
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
\t<h1>youtube 播放器</h1>
\t<form role=\"form\">
\t\t<div id=\"ptt_form\" class=\"form-group\">
\t\t\t<label for=\"exampleInputEmail1\">網址</label>
\t\t\t<input id=\"youtube_url\" value=\"";
        // line 9
        if (isset($context["youtube_url"])) { $_youtube_url_ = $context["youtube_url"]; } else { $_youtube_url_ = null; }
        echo twig_escape_filter($this->env, $_youtube_url_, "html", null, true);
        echo "\" type=\"text\" name=\"youtube_url\" class=\"form-control\" placeholder=\"\">
\t\t</div>
\t\t<input id=\"youtube_go\" type=\"submit\" class=\"btn btn-default\" value=\"Go\"><a href=\"#\" onclick=\"\$('#div_result').show();\">或直接輸入含有youtube網址的文字</a>
\t</form>
\t<div id=\"div_result\" class=\"hid\">
\t\t<textarea id=\"result\" class=\"form-control\" rows=\"3\">";
        // line 14
        if (isset($context["html_youtube"])) { $_html_youtube_ = $context["html_youtube"]; } else { $_html_youtube_ = null; }
        echo twig_escape_filter($this->env, $_html_youtube_, "html", null, true);
        echo "</textarea>
\t\t<a href=\"#\" onclick=\"get_video_id()\" class=\"btn btn-default\">Go</a>
\t</div>
</div>
<div class=\"youtube_jum jumbotron hid\">
\t<div class=\"youtube resizable\">
\t\t<div id=\"player_youtube\">

\t\t</div>
\t</div>
</div>
<div id=\"list\">

</div>

<div class=\"row featurette\">
\t<div class=\"col-md-10\">
\t\t<h2 class=\"featurette-heading\">使用說明.<span class=\"text-muted\">貼上網址，按Go.</span></h2>
\t\t<p class=\"lead\">在欄位裡輸入網址，抓取該網頁的內容，然後列出youtube。<br>範例:<a href=\"/youtube/?youtube_url=http%3A%2F%2Fwww.ptt.cc%2Fbbs%2FELSWORD%2FM.1409792311.A.883.html#\">http://www.ptt.cc/bbs/ELSWORD/M.1409792311.A.883.html</a></p>
\t</div>
</div>

";
    }

    // line 38
    public function block_js($context, array $blocks = array())
    {
        // line 39
        echo "<link rel=\"stylesheet\" href=\"//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css\" />
<script src=\"//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js\"></script>
<script type=\"text/javascript\" id=\"youtube_api\" src=\"\"></script>
<script type=\"text/javascript\" src=\"/js/jquery_cookie.js\" charset=\"utf-8\"></script>
<script type=\"text/javascript\">
\tString.prototype.replaceArray = function(find, replace) {
\t  var replaceString = this;
\t  for (var i = 0; i < replaceString.length; i++) {
\t\treplaceString = replaceString.replace(find, replace);
\t  }
\t  return replaceString.split(\",\");
\t};

\tArray.prototype.my_unique = function() {
\t\tvar a = this.concat();//使用concat()再複製一份陣列，避免影響原陣列
\t\tfor(var i=0; i<a.length; ++i) {
\t\t\tfor(var j=i+1; j<a.length; ++j) {
\t\t\t\tif(a[i] === a[j])
\t\t\t\t\ta.splice(j, 1);
\t\t\t}
\t\t}
\t 
\t\treturn a;
\t};

    var video_id , video_id2;
\tvar played = [];
    // create youtube player
    var player2;
\tvar count = 0;

\tfunction play_video() {
\t\t\$(\"#player_youtube\").replaceWith(\$('<div id=\"player_youtube\"></div>'));
        player2 = new YT.Player('player_youtube', {
          videoId: video_id[count],
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange,
\t\t\t'onError': onPlayerError
          }
        });
\t\t
\t\tif(\$(\"#\" + video_id[count] + \" .video_name\").html() == \"\"){
\t\t\tvar url = \"http://gdata.youtube.com/feeds/api/videos/\" + video_id[count] + \"?v=2&alt=jsonc&&callback=showMyVideos\";
\t\t\t// 创建script标签，设置其属性
\t\t\tvar script = document.createElement('script');
\t\t\tscript.setAttribute('src', url);
\t\t\t// 把script标签加入head，此时调用开始
\t\t\tdocument.getElementsByTagName('head')[0].appendChild(script); 
\t\t}
    };

\tfunction get_video_id(){
\t\tvideo_id = [];
\t\tvar tmp = \$(\"#result\").val().match(/watch\\?v\\=(...........)/g);
\t\tif(tmp){
\t\t\tvideo_id = \$(\"#result\").val().match(/watch\\?v\\=(...........)/g).toString().replaceArray(\"watch?v=\" , \"\");
\t\t}
\t\ttmp = \$(\"#result\").val().match(/youtu.be\\/(...........)/g);
\t\tif(tmp){
\t\t\tvideo_id2 = \$(\"#result\").val().match(/youtu.be\\/(...........)/g).toString().replaceArray(\"youtu.be/\" , \"\");
\t\t\tvideo_id = video_id.concat(video_id2).my_unique();
\t\t}
\t\tvar unique_video = [];
\t\t\$.each(video_id, function(i, el){
\t\t\tif(\$.inArray(el, unique_video) === -1) unique_video.push(el);
\t\t});
\t\tvideo_id = unique_video;
\t\tvar textt = \"\";
\t\tfor (var i = 0; i < video_id.length; i++) {
\t\t\ttextt += '<tr><td>' + (i+1) + '<td><td><a class=\"youtube_link\" id=\"'+video_id[i]+'\" href=\"http://youtu.be/'+video_id[i]+'\" target=\"_blank\"><span class=\"video_name\"></span> http://youtu.be/'+video_id[i]+'</a></td><td class=\"jump\" data-vid=\"'+video_id[i]+'\" data-count=\"'+i+'\"><a href=\"#\">播這首</a></td></tr>';
\t\t}
\t\t\$(\"#list\").html('<h4>找到' + video_id.length + '首</h4><table class=\"table table-hover table-striped\"><thead><tr><th></th><th></th><th></th></tr></thead><tbody>' +  textt + '</tbody></table>' );
\t\tcount = 0;
\t\tplay_video();
\t\t\$(\".youtube_jum\").show();
\t\t\$.cookie('youtube_url', \$(\"#youtube_url\").val(), { expires: 365 });
\t};

    // autoplay video
    function onPlayerReady(event) {
\t\tvar last_id = \$.cookie('last_id');
\t\t\$(\".youtube_link\").parents(\"tr\").removeClass(\"warning success\");
\t\tif(last_id){
\t\t\t\$(\"#\" + last_id + \".youtube_link\").parents(\"tr\").addClass(\"warning\");
\t\t}
\t\t\$(\"#\" + video_id[count] + \".youtube_link\").parents(\"tr\").addClass(\"success\");


\t\t
        event.target.playVideo();
    };

    // when video ends
    function onPlayerStateChange(event) {        
        if(event.data === 0) {         
\t\t\t\$.cookie('last_id', video_id[count], { expires: 365 });
            count++;
\t\t\tif(!(count >= video_id.length)){
\t\t\t\tplay_video();
\t\t\t}
\t\t\telse{
\t\t\t\tcount = 0;
\t\t\t\tplay_video();
\t\t\t}
        }
\t\t//console.log(event);
    }; 

    // 有錯誤就撥下一首
    function onPlayerError(){
        count++;
        if(!(count >= video_id.length)){
            play_video();
        }
        else{
            count = 0;
            play_video();
        }
    }

\tfunction showMyVideos(data){
\t\t\$(\"#\" + video_id[count] + \" .video_name\").html(data['data']['title']);
\t}
</script>
";
    }

    // line 166
    public function block_ready_js($context, array $blocks = array())
    {
        // line 167
        echo "\$( \".resizable\" ).resizable();

if(\$(\"#result\").val()){
\tget_video_id();
}

\$(\"#list\").on(\"click\" , \".jump\" , function(){
\tvar this_count = parseInt(\$(this).data(\"count\"));
\tif(this_count >= 0){
\t\tcount = this_count;
\t\tplay_video();
\t}
});

var cookie_url = \$.cookie('youtube_url'); 
if(cookie_url && \$(\"#youtube_url\").val() == \"\"){
\t\$(\"#youtube_url\").val(cookie_url);
}
";
    }

    public function getTemplateName()
    {
        return "youtube.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  212 => 167,  209 => 166,  80 => 39,  77 => 38,  49 => 14,  40 => 9,  33 => 4,  30 => 3,);
    }
}
