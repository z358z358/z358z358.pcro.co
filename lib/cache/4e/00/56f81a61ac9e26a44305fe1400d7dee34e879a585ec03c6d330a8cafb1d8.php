<?php

/* layout.html */
class __TwigTemplate_4e0056f81a61ac9e26a44305fe1400d7dee34e879a585ec03c6d330a8cafb1d8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'container' => array($this, 'block_container'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!doctype html>
<!--[if lt IE 7]>      <html class=\"no-js lt-ie9 lt-ie8 lt-ie7\"> <![endif]-->
<!--[if IE 7]>         <html class=\"no-js lt-ie9 lt-ie8\"> <![endif]-->
<!--[if IE 8]>         <html class=\"no-js lt-ie9\"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class=\"no-js\">
<head>
<meta charset=\"utf-8\">
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />
<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\" />
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0\" />
<meta content=\"yes\" name=\"apple-mobile-web-app-capable\" />
<meta name=\"Robots\" content=\"all\" />
<title>";
        // line 14
        echo twig_escape_filter($this->env, twig_title_string_filter($this->env, strip_tags((isset($context["title"]) ? $context["title"] : null))), "html", null, true);
        echo "</title>
<link rel=\"stylesheet\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css\">
<!-- Optional theme -->
<link rel=\"stylesheet\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css\">
";
        // line 18
        echo (isset($context["css_lib"]) ? $context["css_lib"] : null);
        echo "
<!--[if lt IE 9]><script src=\"//html5shiv.googlecode.com/svn/trunk/html5.js\"></script><![endif]-->
</head>
<body>
\t<!-- 上方選單 -->
\t<nav class=\"navbar navbar-default\" role=\"navigation\">
\t\t<div class=\"container-fluid\">
\t\t\t<!-- Brand and toggle get grouped for better mobile display -->
\t\t\t<div class=\"navbar-header\">
\t\t\t\t<button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-1\">
\t\t\t\t<span class=\"sr-only\">Toggle navigation</span>
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t<span class=\"icon-bar\"></span>
\t\t\t\t</button>
\t\t\t\t<a class=\"navbar-brand\" href=\"/\">首頁</a>
\t\t\t</div>

\t\t\t<!-- Collect the nav links, forms, and other content for toggling -->
\t\t\t<div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-1\">
\t\t\t\t<ul class=\"nav navbar-nav\">
\t\t\t\t\t";
        // line 39
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["nav"]) ? $context["nav"] : null));
        foreach ($context['_seq'] as $context["key"] => $context["_nav"]) {
            if ($this->getAttribute((isset($context["_nav"]) ? $context["_nav"] : null), "nav")) {
                // line 40
                echo "\t\t\t\t\t\t";
                if (((isset($context["key"]) ? $context["key"] : null) == (isset($context["_current"]) ? $context["_current"] : null))) {
                    // line 41
                    echo "\t\t\t\t\t\t\t<li class=\"active\"><a href=\"/";
                    echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["_nav"]) ? $context["_nav"] : null), "name"), "html", null, true);
                    echo "</a></li>
\t\t\t\t\t\t";
                } else {
                    // line 43
                    echo "\t\t\t\t\t\t\t<li><a href=\"/";
                    echo twig_escape_filter($this->env, (isset($context["key"]) ? $context["key"] : null), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["_nav"]) ? $context["_nav"] : null), "name"), "html", null, true);
                    echo "</a></li>
\t\t\t\t\t\t";
                }
                // line 45
                echo "\t\t\t\t\t\t
\t\t\t\t\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['key'], $context['_nav'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        echo "\t\t\t\t\t<!--<li class=\"dropdown\">
\t\t\t\t\t\t<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Dropdown <span class=\"caret\"></span></a>
\t\t\t\t\t\t<ul class=\"dropdown-menu\" role=\"menu\">
\t\t\t\t\t\t\t<li><a href=\"#\">Action</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">Another action</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">Something else here</a></li>
\t\t\t\t\t\t\t<li class=\"divider\"></li>
\t\t\t\t\t\t\t<li class=\"dropdown-header\">Nav header</li>
\t\t\t\t\t\t\t<li><a href=\"#\">Separated link</a></li>
\t\t\t\t\t\t\t<li><a href=\"#\">One more separated link</a></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>-->
\t\t\t\t</ul>
\t\t\t\t<ul class=\"login_area nav navbar-nav navbar-right\">
\t\t\t\t\t<li class=\"login_hide\"><a href=\"#\" onclick=\"auth.login(\\'facebook\\');\">以facebook登入</a></li>
\t\t\t\t\t<li class=\"logout_hide user_pic\"><img src=\"\" class=\"img-rounded\"></li>
\t\t\t\t\t<li class=\"logout_hide user_name\"><a href=\"#\"></a></li>
\t\t\t\t\t<li class=\"logout_hide\"><a href=\"#\" onclick=\"auth.logout();\">登出</a></li>
\t\t\t\t</ul>
\t\t\t</div><!-- /.navbar-collapse -->
\t\t</div><!-- /.container-fluid -->
\t</nav>
\t<!-- 上方選單 end -->
\t<!-- container --> 
\t<div class=\"container\">\t
\t<!-- Main component for a primary marketing message or call to action -->
\t";
        // line 73
        $this->displayBlock('container', $context, $blocks);
        // line 74
        echo "\t
\t\t
\t</div>
\t<!-- container end -->

\t<script>/* google  Analytics */
\t  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
\t  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
\t  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
\t  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

\t  ga('create', 'UA-53250580-1', 'auto');
\t  ga('send', 'pageview');
\t</script>

\t<script type=\"text/javascript\" src=\"http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js\"></script>\t
\t<script src=\"//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js\"></script>
\t<script src=\"https://cdn.firebase.com/js/client/1.0.18/firebase.js\"></script>
\t<script src=\"https://cdn.firebase.com/js/simple-login/1.6.1/firebase-simple-login.js\"></script>
\t<script type=\"text/javascript\">
\t// Firebase
\tvar myRef = new Firebase(\"https://onininon.firebaseio.com\");
\tvar auth = new FirebaseSimpleLogin(myRef, function(error, user) {
\t\tif (error) {
\t\t\t// an error occurred while attempting login
\t\t\tconsole.log(error);
\t\t} else if (user) {
\t\t\t// user authenticated with Firebase
\t\t\t// console.log(\"User ID: \" + user.uid + \", Provider: \" + user.provider , user);
\t\t\t\$(\".login_hide\").hide();
\t\t\t\$(\".logout_hide\").show();
\t\t\t\$(\".user_name a\").html(user.displayName);
\t\t\t\$(\".user_pic img\").attr(\"src\", user.thirdPartyUserData.picture.data.url);
\t\t} else {
\t\t\t// user is logged out
\t\t\t\$(\".logout_hide\").hide();
\t\t\t\$(\".login_hide\").show();
\t\t}
\t});

\tfunction ajax_data(data){

\t\tif(data[\"type\"] == \"input_error\"){
\t\t\t\$(\"#\" + data[\"tag_id\"]).parents(\"div.form-group\").addClass(\"has-error has-feedback\").append('<span class=\"glyphicon glyphicon-remove form-control-feedback\"></span>');
\t\t\tconsole.log(\$(\"#\" + data[\"tag_id\"]));
\t\t}
\t}
\t</script>
\t<script type=\"text/javascript\">
\t\$(document).ready(function() {
\t\t// ajax
\t\t\$(\"body\").on(\"click\" , \".ajax_post\" , function(){
\t\t\tvar form = \$(this).parents(\"form\");
\t\t\tif(form){
\t\t\t\t\$.post(\"/ajax\" , form.serialize(), function(data) {
\t\t\t\t\tajax_data(data);
\t\t\t\t\t//console.log(data);
\t\t\t\t}, \"json\");
\t\t\t}\t
\t\t});

\t\t
\t});
\t</script>
</body>
</html>";
    }

    // line 73
    public function block_container($context, array $blocks = array())
    {
        // line 74
        echo "\t";
    }

    public function getTemplateName()
    {
        return "layout.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  200 => 74,  197 => 73,  128 => 74,  126 => 73,  98 => 47,  90 => 45,  82 => 43,  74 => 41,  71 => 40,  66 => 39,  42 => 18,  35 => 14,  20 => 1,);
    }
}
