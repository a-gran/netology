<?php

/* ./tasks.twig */
class __TwigTemplate_f81001dbc58ebcc1c200c6ab793176e26d2b0c158ea10dec06391f54fc24b14f extends Twig_Template
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
<html lang=\"ru\">
  <head>
\t  <meta charset=\"utf-8\">
    <title>Список дел на сегодня</title>
\t\t<style>
\t\t  body {
\t\t\t\tmax-width: 1160px;
\t\t\t\tmargin: 0 auto;
\t\t\t}
\t\t  form {
\t\t\t\tdisplay: block;
\t\t\t\tmargin-bottom: 1rem;
\t\t\t\tmargin-right: 1rem;
\t\t\t\tfloat: left;
\t\t\t}
\t\t  table {
\t\t\t\tclear: both;
\t\t\t\tborder-collapse: collapse;
\t\t\t}
\t\t  th {
\t\t\t\tbackground: #eee;
\t\t\t}
\t\t\tth, td {
\t\t\t\tpadding: 5px;
\t\t\t\tborder: 1px solid #ccc;
\t\t\t}
\t\t\t.logout {
\t\t\t\tfloat: right;
\t\t\t\tmargin: 10px;
\t\t\t\tpadding: 6px 15px;
\t\t\t\tbackground-color: #E36116;
\t\t\t\ttext-decoration: none;
\t\t\t\tcolor: white;
\t\t\t\tfont-size: 18px;
\t\t\t\tborder: none;
\t\t\t\tborder-radius: 6px;
\t\t\t\tbox-shadow: 1px 1px 6px rgba(0, 0, 0, 0.5);
\t\t\t}
\t\t</style>
  </head>
\t<body>
\t  <a class=\"logout\" href=\"logout.php\">Выход из системы</a>

\t  <h1>Здравствуйте, ";
        // line 45
        echo twig_escape_filter($this->env, ($context["user_login"] ?? null), "html", null, true);
        echo "! Ваш список дел:</h1>

  \t<form method=\"POST\">
\t\t\t<input type=\"text\" name=\"description\" placeholder=\"Описание задачи\" value=\"";
        // line 48
        echo twig_escape_filter($this->env, $this->getAttribute(($context["get"] ?? null), "description", array()), "html", null, true);
        echo "\">
      <input type=\"submit\" name=\"save\" value=\"Сохранить\">
\t\t</form>

    <form method=\"POST\">
\t\t  <label for=\"sort\">Сортировать по:</label>
\t\t\t<select name=\"sort_by\">
\t\t\t  <option value=\"date_added\">Дате добавления</option>
\t\t\t\t<option value=\"is_done\">Статусу</option>
\t\t\t\t<option value=\"description\">Описанию</option>
\t\t\t</select>
\t\t\t<input type=\"submit\" name=\"sort\" value=\"Отсортировать\">
    </form>

\t\t<table>
\t\t  <tr>
\t\t\t  <th>Описание задачи</th>
\t\t\t\t<th>Дата добавления</th>
\t\t\t\t<th>Статус</th>
\t\t\t\t<th></th>
\t\t\t\t<th>Ответственный</th>
\t\t\t\t<th>Автор</th>
\t\t\t\t<th>Закрепить задачу за пользователем</th>
\t\t\t</tr>
\t\t\t";
        // line 72
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tasks"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
            // line 73
            echo "\t\t\t<tr>
\t\t\t\t<td>";
            // line 74
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "description", array()), "html", null, true);
            echo "</td>

\t\t\t\t<td>";
            // line 76
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "date_added", array()), "html", null, true);
            echo "</td>

\t\t\t\t<td ";
            // line 78
            if (($this->getAttribute($context["row"], "is_done", array()) == 1)) {
                echo " style=\"color: green;\" ";
            }
            echo ">
\t\t\t\t  ";
            // line 79
            if (($this->getAttribute($context["row"], "is_done", array()) == 0)) {
                // line 80
                echo "\t\t\t\t    В процессе
\t\t\t\t  ";
            } else {
                // line 82
                echo "\t\t\t\t    Выполнено
\t\t\t\t  ";
            }
            // line 84
            echo "\t\t\t\t</td>

\t\t\t\t<td>
\t\t\t\t  <a href=\"?id=";
            // line 87
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "id_description", array()), "html", null, true);
            echo "&action=edit&description=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "description", array()), "html", null, true);
            echo "\">Изменить</a>
\t\t\t\t  <a href=\"?id=";
            // line 88
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "id_description", array()), "html", null, true);
            echo "&action=done\">Выполнить</a>
\t\t\t\t  <a href=\"?id=";
            // line 89
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "id_description", array()), "html", null, true);
            echo "&action=delete\">Удалить</a>
\t\t\t\t</td>

\t\t\t\t<td>";
            // line 92
            if (($this->getAttribute($context["row"], "user_id", array()) == $this->getAttribute($context["row"], "assigned_user_id", array()))) {
                // line 93
                echo "\t\t\t\t  Вы
\t\t\t\t";
            } else {
                // line 95
                echo "\t\t\t\t  ";
                echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "login", array()), "html", null, true);
                echo "
\t\t\t\t";
            }
            // line 97
            echo "\t\t\t\t</td>

\t\t\t\t<td>";
            // line 99
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "user_login", array()), "html", null, true);
            echo "</td>

\t\t\t\t<td>
\t\t\t\t\t<form method=\"POST\" style=\"margin: 0;\">
\t\t\t\t\t\t<select name=\"assigned_user_id\">
\t\t\t\t\t\t\t";
            // line 104
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["users"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["user"]) {
                // line 105
                echo "\t\t\t\t\t\t\t\t<option value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "id", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["user"], "login", array()), "html", null, true);
                echo "</option>
\t\t\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['user'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 106
            echo "\t\t\t\t\t
\t\t\t\t\t\t</select>
\t\t\t\t\t\t<input type=\"hidden\" name=\"id_description\" value=\"";
            // line 108
            echo twig_escape_filter($this->env, $this->getAttribute($context["row"], "id_description", array()), "html", null, true);
            echo "\">
\t\t\t\t\t\t<input type=\"submit\" name=\"assign\" value=\"Переложить ответственность\">
\t\t\t\t\t</form>
\t\t\t\t</td>
\t\t\t</tr>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 114
        echo "\t\t</table>

\t\t<h3>Также посмотрите, что от вас требуют другие люди:</h3>

\t\t<table>
\t\t  <tr>
\t\t\t  <th>Описание задачи</th>
\t\t\t\t<th>Дата добавления</th>
\t\t\t\t<th>Статус</th>
\t\t\t\t<th></th>
\t\t\t\t<th>Ответственный</th>
\t\t\t\t<th>Автор</th>
\t\t\t</tr>
\t\t\t";
        // line 127
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["myTasks"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["rowMyList"]) {
            // line 128
            echo "\t\t\t<tr>
\t\t\t\t<td>";
            // line 129
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "description", array()), "html", null, true);
            echo "</td>

\t\t\t\t<td>";
            // line 131
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "date_added", array()), "html", null, true);
            echo "</td>

\t\t\t\t<td ";
            // line 133
            if (($this->getAttribute($context["rowMyList"], "is_done", array()) == 1)) {
                echo " style=\"color: green;\" ";
            }
            echo ">
\t\t\t\t  ";
            // line 134
            if (($this->getAttribute($context["rowMyList"], "is_done", array()) == 0)) {
                // line 135
                echo "\t\t\t\t    В процессе
\t\t\t\t  ";
            } else {
                // line 137
                echo "\t\t\t\t    Выполнено
\t\t\t\t  ";
            }
            // line 139
            echo "\t\t\t\t</td>

\t\t\t\t<td>
\t\t\t\t  <a href=\"?id=";
            // line 142
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "id_description", array()), "html", null, true);
            echo "&action=edit&description=";
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "description", array()), "html", null, true);
            echo "\">Изменить</a>
\t\t\t\t  <a href=\"?id=";
            // line 143
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "id_description", array()), "html", null, true);
            echo "&action=done\">Выполнить</a>
\t\t\t\t  <a href=\"?id=";
            // line 144
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "id_description", array()), "html", null, true);
            echo "&action=delete\">Удалить</a>
\t\t\t\t</td>

\t\t\t\t<td>
\t\t\t\t\t";
            // line 148
            if (($this->getAttribute($context["rowMyList"], "login", array()) == ($context["user_login"] ?? null))) {
                // line 149
                echo "\t\t\t\t\t\tВы 
\t\t\t\t\t";
            } else {
                // line 151
                echo "\t\t\t\t\t\t";
                echo twig_escape_filter($this->env, $this->getAttribute(($context["row"] ?? null), "login", array()), "html", null, true);
                echo "
\t\t\t\t\t";
            }
            // line 152
            echo "\t
\t\t\t\t</td>

\t\t\t\t<td>";
            // line 155
            echo twig_escape_filter($this->env, $this->getAttribute($context["rowMyList"], "user_login", array()), "html", null, true);
            echo "</td>
\t\t\t</tr>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rowMyList'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 158
        echo "\t\t</table>
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "./tasks.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  303 => 158,  294 => 155,  289 => 152,  283 => 151,  279 => 149,  277 => 148,  270 => 144,  266 => 143,  260 => 142,  255 => 139,  251 => 137,  247 => 135,  245 => 134,  239 => 133,  234 => 131,  229 => 129,  226 => 128,  222 => 127,  207 => 114,  195 => 108,  191 => 106,  180 => 105,  176 => 104,  168 => 99,  164 => 97,  158 => 95,  154 => 93,  152 => 92,  146 => 89,  142 => 88,  136 => 87,  131 => 84,  127 => 82,  123 => 80,  121 => 79,  115 => 78,  110 => 76,  105 => 74,  102 => 73,  98 => 72,  71 => 48,  65 => 45,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "./tasks.twig", "C:\\OpenServer\\domains\\localhost\\homework_5.2\\templates\\tasks.twig");
    }
}
