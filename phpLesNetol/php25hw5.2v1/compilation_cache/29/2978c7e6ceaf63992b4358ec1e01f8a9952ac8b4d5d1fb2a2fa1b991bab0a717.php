<?php

/* ./register.twig */
class __TwigTemplate_38d08c7bb68a0eec1d0e50302ae8da2d5ede87266b83a8ed8945c193b56a6253 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <title>Вход</title>
\t\t<style>
\t\t  body {
\t\t\t\tbackground-color: #E1F0FF;
\t\t\t\ttext-align: center;
\t\t\t\tcolor: #6A6BA3;
\t\t\t}
\t\t  form {
\t\t\t\tdisplay: inline-block;
\t\t\t\twidth: 220px;\t\t\t\t
\t\t\t}
\t\t\tinput {
\t\t\t\tmargin: 0 0 10px 0;
\t\t\t\tcolor: #3982C2;
\t\t\t}
\t\t\tbutton {
\t\t\t\tcolor: #6A6BA3;
\t\t\t}
\t\t</style>
  </head>
  <body>
    <form method=\"POST\">
\t\t  <p style=\"display: inline-block;\"><b>
\t\t\t\t";
        // line 28
        if (($context["isRegistration"] ?? null)) {
            // line 29
            echo "\t\t\t\t\tВаши данные отправлены! Войдите, используя свой логин и пароль:
\t\t\t\t";
        } elseif ((        // line 30
($context["isAuthorization"] ?? null) && twig_test_empty(($context["user"] ?? null)))) {
            // line 31
            echo "\t\t\t\t\tНеправильный логин и пароль!
\t\t\t\t";
        } else {
            // line 33
            echo "\t\t\t\t\tВойдите или зарегистрируйтесь:
\t\t\t\t";
        }
        // line 35
        echo "\t\t\t</b></p>
      <input name=\"login\" id=\"login\" placeholder=\"Логин\">
      <input name=\"password\" id=\"password\" placeholder=\"Пароль\">
\t\t\t<button type=\"submit\" name=\"registration\">Регистрация</button>
\t\t\t<button type=\"submit\" name=\"authorization\">Вход</button>
    </form><br>
  </body>
</html>
</html>
";
    }

    public function getTemplateName()
    {
        return "./register.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  63 => 35,  59 => 33,  55 => 31,  53 => 30,  50 => 29,  48 => 28,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "./register.twig", "C:\\OpenServer\\domains\\localhost\\homework_5.2\\templates\\register.twig");
    }
}
