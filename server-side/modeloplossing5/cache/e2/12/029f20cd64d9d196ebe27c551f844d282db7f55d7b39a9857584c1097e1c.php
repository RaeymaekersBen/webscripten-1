<?php

/* partials/formerrors.twig */
class __TwigTemplate_e212029f20cd64d9d196ebe27c551f844d282db7f55d7b39a9857584c1097e1c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if ((isset($context["formErrors"]) ? $context["formErrors"] : null)) {
            // line 2
            echo "<div class=\"box\" id=\"boxError\">
\t<p>One or more errors were encountered:</p>
\t<ul class=\"errors\">
\t\t";
            // line 5
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["formErrors"]) ? $context["formErrors"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["formError"]) {
                // line 6
                echo "\t\t<li>";
                echo twig_escape_filter($this->env, (isset($context["formError"]) ? $context["formError"] : null), "html", null, true);
                echo "</li>
\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['formError'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 8
            echo "\t</ul>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "partials/formerrors.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 6,  19 => 1,  95 => 39,  92 => 38,  87 => 22,  84 => 21,  73 => 46,  64 => 38,  48 => 24,  46 => 21,  21 => 2,  148 => 59,  144 => 57,  140 => 55,  131 => 52,  127 => 51,  123 => 50,  116 => 49,  112 => 48,  109 => 47,  107 => 46,  98 => 39,  96 => 38,  81 => 25,  66 => 41,  62 => 22,  56 => 19,  50 => 16,  42 => 10,  39 => 8,  34 => 6,  31 => 9,  26 => 5,);
    }
}
