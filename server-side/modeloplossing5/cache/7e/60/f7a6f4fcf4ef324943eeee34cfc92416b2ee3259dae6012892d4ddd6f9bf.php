<?php

/* browse.twig */
class __TwigTemplate_7e60f7a6f4fcf4ef324943eeee34cfc92416b2ee3259dae6012892d4ddd6f9bf extends Twig_Template
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
        $context["pageTitle"] = "Todolist - Browse";
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_javaScript($context, array $blocks = array())
    {
        // line 6
        echo "\t<script src=\"js/browse.js\"></script>
";
    }

    // line 9
    public function block_pageContent($context, array $blocks = array())
    {
        // line 10
        echo "
\t<div class=\"box\" id=\"boxAddTodo\">

\t\t<h2>Add new todo</h2>

\t\t<div class=\"boxInner\">
\t\t\t<form action=\"";
        // line 16
        echo twig_escape_filter($this->env, (isset($context["PHP_SELF"]) ? $context["PHP_SELF"] : null), "html", null, true);
        echo "\" method=\"post\">
\t\t\t\t<fieldset>
\t\t\t\t\t<dl class=\"clearfix columns\">
\t\t\t\t\t\t<dd class=\"column column-46\"><input type=\"text\" name=\"what\" id=\"what\" value=\"";
        // line 19
        echo twig_escape_filter($this->env, (isset($context["what"]) ? $context["what"] : null), "html", null, true);
        echo "\" /></dd>
\t\t\t\t\t\t<dd class=\"column column-16\" id=\"col-priority\">
\t\t\t\t\t\t\t<select name=\"priority\" id=\"priority\">
\t\t\t\t\t\t\t\t";
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
\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['prior'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t</dd>
\t\t\t\t\t\t<dd class=\"column column-16\" id=\"col-submit\">
\t\t\t\t\t\t\t<label for=\"btnSubmit\"><input type=\"submit\" id=\"btnSubmit\" name=\"btnSubmit\" value=\"Add\" /></label>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"moduleAction\" id=\"moduleAction\" value=\"add\" />
\t\t\t\t\t\t</dd>
\t\t\t\t\t</dl>
\t\t\t\t</fieldset>
\t\t\t</form>
\t\t</div>

\t</div>

\t";
        // line 38
        $this->env->loadTemplate("partials/formerrors.twig")->display($context);
        // line 39
        echo "
\t<div class=\"box\" id=\"boxYourTodos\">

\t\t<h2>Your todos</h2>

\t\t<div class=\"boxInner\">

\t\t";
        // line 46
        if ((isset($context["items"]) ? $context["items"] : null)) {
            // line 47
            echo "\t\t\t<ul>
\t\t\t";
            // line 48
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 49
                echo "\t\t\t\t<li id=\"item-";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id"), "html", null, true);
                echo "\" class=\"item ";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "priority"), "html", null, true);
                echo " clearfix\">
\t\t\t\t\t<a href=\"delete.php?id=";
                // line 50
                echo twig_escape_filter($this->env, twig_urlencode_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id")), "html", null, true);
                echo "\" class=\"delete\" title=\"Delete/Complete this item\">delete/complete</a>
\t\t\t\t\t<a href=\"edit.php?id=";
                // line 51
                echo twig_escape_filter($this->env, twig_urlencode_filter($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id")), "html", null, true);
                echo "\" class=\"edit\" title=\"Edit this item\">edit</a>
\t\t\t\t\t<span>";
                // line 52
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "what"), "html", null, true);
                echo "</span>
\t\t\t\t</li>
\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 55
            echo "\t\t\t</ul>
\t\t";
        } else {
            // line 57
            echo "\t\t\t<p>No todos, it must be your lucky day!</p>
\t\t";
        }
        // line 59
        echo "\t\t</div>

\t</div>

";
    }

    public function getTemplateName()
    {
        return "browse.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  148 => 59,  144 => 57,  140 => 55,  131 => 52,  127 => 51,  123 => 50,  116 => 49,  112 => 48,  109 => 47,  107 => 46,  98 => 39,  96 => 38,  81 => 25,  66 => 23,  62 => 22,  56 => 19,  50 => 16,  42 => 10,  39 => 9,  34 => 6,  31 => 5,  26 => 3,);
    }
}
