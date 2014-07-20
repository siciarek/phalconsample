{% extends "templates/base.volt" %}

{% block content %}

    {{ page_header('user.registration', 'icon-edit', trans) }}

    <div class="row">
        <div class="col-md-6">

            <form class="form-horizontal" method="post">
                {{ form.render('csrf') }}

                {% for field in [ 'first_name', 'last_name', 'email', 'password', 'confirm_password' ] %}
                    <div class="input-group">
                        {{ form.label(field, { 'class': 'input-group-addon' }) }}
                        {{ form.render(field, { 'class': 'form-control' }) }}
                    </div>
                {% endfor %}

                {{ form.render('submit', { 'class' : 'btn btn-default btn-lg pull-right' }) }}
            </form>

        </div>
        <div class="col-md-6">

            {% set messages = [] %}

            {# FORM ERRORS #}
            {% for e in form.getMessages() %}
                {% set messages = messages|merge([e.getMessage()]) %}
            {% endfor %}

            {# ENTITY ERRORS #}
            {% set errors = form.getEntity().getMessages() %}
            {% if errors %}
                {% for e in errors %}
                    {% set messages = messages|merge([e.getMessage()]) %}
                {% endfor %}
            {% endif %}

            {% if messages|length > 0 %}
                <div class="alert alert-warning">
                    {% for m in messages %}
                        <i class="icon-warning-sign icon-large"></i>
                        {{ trans._(m) }}<br/>
                    {% endfor %}
                </div>
            {% endif %}

        </div>
    </div>

{% endblock %}
