<?php

/* index.twig */
class __TwigTemplate_1f24a5b95d104f77672b6b8a2a4ec9606d7f8136e385b61983bd9a1eaaa8f628 extends Twig_Template
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
        // line 10
        echo call_user_func_array($this->env->getFunction('widget')->getCallable(), array("SearchForm", array("searchRequest" => (isset($context["searchRequest"]) ? $context["searchRequest"] : null))));
        echo "

";
    }

    public function getTemplateName()
    {
        return "index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 10,);
    }

    public function getSource()
    {
        return "{#% 
include \"Site/assets.twig\"
<link rel=\"stylesheet\" type=\"text/css\" href=\"{{staticUrl}}static/css/booking.css\" media=\"all\"/>
<link rel=\"stylesheet\" type=\"text/css\" href=\"{{staticUrl}}static/css/jquery.datetimepicker.css\" media=\"all\"/>

<script type=\"text/javascript\" src=\"{{staticUrl}}static/js/jquery.datetimepicker.js\"></script>
<script type=\"text/javascript\" src=\"{{ staticUrl }}static/js/servio.{{ lang }}.js\"></script>
<script type=\"text/javascript\" src=\"{{ staticUrl }}static/js/servio.js\"></script>
%#}
{{ widget('SearchForm', {'searchRequest': searchRequest }) | raw }}

";
    }
}
