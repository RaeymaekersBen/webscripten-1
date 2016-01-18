<?php

/* delete.twig */
class __TwigTemplate_c5890f8a3a05234640347c9010c406f400b75b539f9cd6822235fa1f8b1d68bb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("master.twig");

        $this->blocks = array(
            'javaScript' => array($this, 'block_javaScript'),
            'pageContent' => array($this, 'block_pageContent'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "master.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $context["pageTitle"] = (("Todolist - Delete “" . $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "what")) . "”");
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_javaScript($context, array $blocks = array())
    {
        // line 6
        echo "\t<script src=\"js/delete.js\"></script>
";
    }

    // line 9
    public function block_pageContent($context, array $blocks = array())
    {
        // line 10
        echo "
\t<div class=\"box\" id=\"boxCompleteTodo\">

\t\t<h2>Complete todo</h2>

\t\t<div class=\"boxInner\">
\t\t\t<p>Are you sure you want to complete the todo <strong>";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "what"), "html", null, true);
        echo "</strong>?</p>
\t\t\t<form action=\"";
        // line 17
        echo twig_escape_filter($this->env, (isset($context["PHP_SELF"]) ? $context["PHP_SELF"] : null), "html", null, true);
        echo "?id=";
        echo twig_escape_filter($this->env, twig_urlencode_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id")), "html", null, true);
        echo "\" method=\"post\">
\t\t\t\t<fieldset class=\"columns\">
\t\t\t\t\t<label class=\"column column-12 cancel alignLeft\"><a href=\"index.php\" title=\"Cancel and go back\">Cancel and go back</a></label>
\t\t\t\t\t<label for=\"btnSubmit\" class=\"column column-12 alignRight\"><input type=\"submit\" id=\"btnSubmit\" name=\"btnSubmit\" value=\"Complete\" /></label>
\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t<input type=\"hidden\" name=\"moduleAction\" id=\"moduleAction\" value=\"delete\" />
\t\t\t\t</fieldset>
\t\t\t</form>
\t\t</div>

\t</div>

\t";
        // line 29
        $this->env->loadTemplate("partials/formerrors.twig")->display($context);
        // line 30
        echo "
";
    }

    public function getTemplateName()
    {
        return "delete.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 30,  74 => 29,  63 => 21,  54 => 17,  50 => 16,  42 => 10,  39 => 9,  34 => 6,  31 => 5,  26 => 3,);
    }
}
