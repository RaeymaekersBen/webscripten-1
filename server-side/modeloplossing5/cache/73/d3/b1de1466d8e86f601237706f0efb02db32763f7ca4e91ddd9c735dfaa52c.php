<?php

/* edit.twig */
class __TwigTemplate_73d3b1de1466d8e86f601237706f0efb02db32763f7ca4e91ddd9c735dfaa52c extends Twig_Template
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
        $context["pageTitle"] = (("Todolist - Edit “" . $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "what")) . "”");
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_javaScript($context, array $blocks = array())
    {
        // line 6
        echo "<script src=\"js/edit.js\"></script>
";
    }

    // line 9
    public function block_pageContent($context, array $blocks = array())
    {
        // line 10
        echo "
\t<div class=\"box\" id=\"boxAddTodo\">

\t\t<h2>Edit existing todo</h2>

\t\t<div class=\"boxInner\">
\t\t\t<form action=\"";
        // line 16
        echo twig_escape_filter($this->env, (isset($context["PHP_SELF"]) ? $context["PHP_SELF"] : null), "html", null, true);
        echo "?id=";
        echo twig_escape_filter($this->env, twig_urlencode_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id")), "html", null, true);
        echo "\" method=\"post\">
\t\t\t\t<fieldset>
\t\t\t\t\t<dl class=\"clearfix columns\">
\t\t\t\t\t\t<dd class=\"column column-46\"><input type=\"text\" name=\"what\" id=\"what\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["what"]) ? $context["what"] : null), "html", null, true);
        echo "\" /></dd>
\t\t\t\t\t\t<dd class=\"column column-16\" id=\"col-priority\">
\t\t\t\t\t\t\t<select name=\"priority\" id=\"priority\">
\t\t\t\t\t\t\t";
        // line 22
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["priorities"]) ? $context["priorities"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["prior"]) {
            // line 23
            echo "\t\t\t\t\t\t\t\t<option value=\"";
            echo twig_escape_filter($this->env, (isset($context["prior"]) ? $context["prior"] : null), "html", null, true);
            echo "\"";
            if (((isset($context["prior"]) ? $context["prior"] : null) == (isset($context["priority"]) ? $context["priority"] : null))) {
                echo " selected=\"selected\"";
            }
            echo ">";
            echo twig_escape_filter($this->env, (isset($context["prior"]) ? $context["prior"] : null), "html", null, true);
            echo "</option>
\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prior'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t</dd>
\t\t\t\t\t\t<dd class=\"column column-16\" id=\"col-submit\">
\t\t\t\t\t\t\t<label for=\"btnSubmit\"><input type=\"submit\" id=\"btnSubmit\" name=\"btnSubmit\" value=\"Edit\" /></label>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"id\" value=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id"), "html", null, true);
        echo "\" />
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"moduleAction\" id=\"moduleAction\" value=\"edit\" />
\t\t\t\t\t\t</dd>
\t\t\t\t\t</dl>
\t\t\t\t</fieldset>
\t\t\t</form>
\t\t\t<p class=\"cancel\">or <a href=\"index.php\" title=\"Cancel and go back\">Cancel and go back</a></p>
\t\t</div>

\t</div>

\t";
        // line 40
        $this->env->loadTemplate("partials/formerrors.twig")->display($context);
        // line 41
        echo "
";
    }

    public function getTemplateName()
    {
        return "edit.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 41,  103 => 40,  89 => 29,  83 => 25,  68 => 23,  64 => 22,  58 => 19,  50 => 16,  42 => 10,  39 => 9,  34 => 6,  31 => 5,  26 => 3,);
    }
}
