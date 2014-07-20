{% set menu = [

] %}

{% set loc = [
{
'name': 'Polski',
'locale': 'pl'
},
{
'name': 'English',
'locale': 'en'
}
] %}

<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url({ 'for':'index' }, true) }}">
                <i class="icon-smile"></i>
                {{ app_name }}
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                {% for m in menu %}
                    <li{% if this.di.get('router').getMatchedRoute() and m['route'] == this.di.get('router').getMatchedRoute().getName() %} class="active"{% endif %}>
                        <a title="{{ trans._(m['text']) }}" href="{{ url(['for': m['route'] ]) }}">
                            <i class="{{ m['icon'] }} icon-large"></i>
                            {{ trans._(m['text']) }}
                        </a>
                    </li>
                {% endfor %}

                {% if auth.hasGranted('ROLE_ADMIN') %}
                    <li>
                        <a target="_blank" href="{{ url({'for':'admin.dashboard'}) }}" title="{{ trans._('admin.dashboard') }}">
                            <i class="icon-wrench icon-large"></i>
                            {{ trans._('admin.dashboard') }}
                        </a>
                    </li>
                {% endif %}
            </ul>

            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown"><a href="#" title="Language" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-globe icon-large text-primary"></i>
                        {% for l in loc if l['locale'] == this.di.get('locale') %}
                            {{ l['name'] }}
                        {% endfor %}
                        &nbsp;<i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        {% for l in loc %}
                            <li>
                                <a href="{{ url({ 'for':'locale', 'locale': l['locale'] }) }}" title="{{ l['name'] }}">
                                    <i class="{% if l['locale'] == this.di.get('locale') %}icon-check{% else %}icon-check-empty text-muted{% endif %}"></i>
                                    {{ l['name'] }}
                                </a>
                            </li>
                        {% endfor %}
                    </ul>
                </li>



                <li>
                    {% if auth.isAuthenticated() %}
                        <a href="{{ url({'for':'logout'}) }}" title="{{ trans._('Log out') }}">
                            <i class="icon-lock icon-large"></i>
                            {{ trans._('Log out') }}
                        </a>
                    {% else %}
                        <a href="{{ url({'for':'login'}) }}" title="{{ trans._('Log in') }}">
                            <i class="icon-unlock icon-large"></i>
                            {{ trans._('Log in') }}
                        </a>
                    {% endif %}
                </li>
            </ul>
        </div>
    </div>
</div>

{% if auth.isAuthenticated() %}
    <div class="container">
        <span class="text-muted pull-right">{{ trans._('user.logged_in') }}: {{ auth.getUser().name }} &lt;{{ auth.getUser().email }}&gt;</span>
    </div>
{% endif %}
