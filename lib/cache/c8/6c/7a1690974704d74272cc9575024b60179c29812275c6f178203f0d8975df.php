<?php

/* ptt.html */
class __TwigTemplate_c86c7a1690974704d74272cc9575024b60179c29812275c6f178203f0d8975df extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("layout.html");

        $this->blocks = array(
            'container' => array($this, 'block_container'),
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
\t\t<div class=\"form-group\">
\t\t\t<label for=\"exampleInputEmail1\">Ptt網頁版網址</label>
\t\t\t<input id=\"ptt_url\" type=\"text\" name=\"ptt_url\" class=\"form-control\" placeholder=\"範例:http://www.ptt.cc/bbs/Gossiping/M.1408188026.A.085.html\">
\t\t</div>
\t\t<input type=\"hidden\" name=\"post_type\" value=\"ptt\">
\t\t<button type=\"button\" class=\"ajax_post btn btn-default\">Go</button>
\t</form>
</div>
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
        return array (  31 => 4,  28 => 3,);
    }
}
