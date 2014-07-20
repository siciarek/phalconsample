<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}{{ app_name }}{% endblock %}</title>
    {% block stylesheets %}
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/redmond/jquery-ui.css"/>

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css"/>
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css"/>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2-bootstrap.min.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.css"/>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"/>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.2/css/bootstrap3/bootstrap-switch.min.css"/>

        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/redmond/jquery-ui.css"/>

        <link rel="stylesheet" href="/css/main.css"/>
    {% endblock %}
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
</head>
<body>

<div id="wrap">
    {% include 'partials/menu.volt' %}

    <div class="container">
        {% block content %}{% endblock %}
    </div>
</div>

<div id="footer">
    <div class="container">
        {% block footer %}
            <ul class="footer-links">
                {#<li><a href="/regulamin">Regulamin</a></li>#}
                {#<li><a href="/polityka-prywatnosci">Polityka prywatności</a></li>#}
            </ul>
            <p class="text-muted copy-info">
                <span style="white-space: nowrap">&copy; 2014.</span>
                <span style="white-space: nowrap">Wszelkie prawa zastrzeżone.</span>
                <span style="white-space: nowrap">{{ app_name }}</span>
            </p>
        {% endblock %}
    </div>
</div>

{% block javascripts %}
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
    <script src="//cdn.jsdelivr.net/jquery.cookie/1.3.1/jquery.cookie.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.2/js/bootstrap-switch.min.js"></script>
    <script src="/js/remember-last-tab.js"></script>
{% endblock %}
</body>
</html>

