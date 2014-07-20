{% extends "templates/base.volt" %}

{% block stylesheets %}
    {{ super() }}
    <style>
        .alert-success {
            display: block;
        }
    </style>
{% endblock %}

{% block content %}

    {% set messages = this.flash.getMessages('notice') %}

    {% if messages|length > 0 %}
        <div class="alert alert-info">
            {% for m in messages %}
                {{ trans._(m) }}<br/>
            {% endfor %}
        </div>
    {% endif %}

    <br/>

    <div class="jumbotron">
        <div class="container">
            <h1>
                <i class="icon-smile icon-large text-muted"></i>
                {{ app_name }}
            </h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Duis et consectetur orci. Integer congue at lectus suscipit lobortis.
                Donec aliquet pulvinar mi id ultricies. Proin est mi, venenatis sed consequat quis, pretium in massa.
                Etiam aliquet mi urna, eget dictum sapien hendrerit in. Ut dapibus risus sit amet suscipit egestas.</p>
        </div>
    </div>

{% endblock %}