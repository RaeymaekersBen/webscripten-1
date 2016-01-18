<?php

/* master.twig */
class __TwigTemplate_06c5edb77c061f7ae8c4ee7315132b75c7d8b49cb66a447b9180cc13f9e955f2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'pageContent' => array($this, 'block_pageContent'),
            'javaScript' => array($this, 'block_javaScript'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<!--[if lt IE 7 ]><html class=\"oldie ie6\" lang=\"en\"><![endif]-->
<!--[if IE 7 ]><html class=\"oldie ie7\" lang=\"en\"><![endif]-->
<!--[if IE 8 ]><html class=\"oldie ie8\" lang=\"en\"><![endif]-->
<!--[if IE 9 ]><html class=\"ie9\" lang=\"en\"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang=\"en\"><!--<![endif]-->
<head>

\t<title>";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["pageTitle"]) ? $context["pageTitle"] : null), "html", null, true);
        echo "</title>

\t<meta charset=\"UTF-8\" />
\t<meta name=\"viewport\" content=\"width=520\" />
\t<meta http-equiv=\"cleartype\" content=\"on\" />
\t<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge,chrome=1\" />

\t<!--[if lt IE 9]><script src=\"http://html5shiv.googlecode.com/svn/trunk/html5.js\"></script><![endif]-->

\t<link rel=\"stylesheet\" media=\"screen\" href=\"css/reset.css\" />
\t<link rel=\"stylesheet\" media=\"screen\" href=\"css/screen.css\" />

</head>
<body>

\t<div id=\"siteWrapper\">

\t\t<!-- header -->
\t\t<header>
\t\t\t<h1><a href=\"index.php\">Todolist</a></h1>
\t\t</header>

\t\t<!-- content -->
\t\t<section>

\t    ";
        // line 34
        $this->displayBlock('pageContent', $context, $blocks);
        // line 37
        echo "
\t\t</section>

\t\t<!-- footer -->
\t\t<footer>
\t\t\t<p>&copy; ";
        // line 42
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y"), "html", null, true);
        echo ", <a href=\"http://www.ikdoeict.be/\" title=\"IkDoeICT.be\">IkDoeICT.be</a></p>
\t\t</footer>

\t</div>

";
        // line 47
        $this->displayBlock('javaScript', $context, $blocks);
        // line 50
        echo "
</body>
</html>";
    }

    // line 34
    public function block_pageContent($context, array $blocks = array())
    {
        // line 35
        echo "
\t    ";
    }

    // line 47
    public function block_javaScript($context, array $blocks = array())
    {
        // line 48
        echo "
";
    }

    public function getTemplateName()
    {
        return "master.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 48,  92 => 47,  87 => 35,  84 => 34,  78 => 50,  76 => 47,  68 => 42,  61 => 37,  59 => 34,  21 => 1,  148 => 59,  144 => 57,  140 => 55,  131 => 52,  127 => 51,  123 => 50,  116 => 49,  112 => 48,  109 => 47,  107 => 46,  98 => 39,  96 => 38,  81 => 25,  66 => 23,  62 => 22,  56 => 19,  50 => 16,  42 => 10,  39 => 9,  34 => 6,  31 => 9,  26 => 3,);
    }
}
