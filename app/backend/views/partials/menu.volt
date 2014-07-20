{%- set menu = [
{
'text': 'Dashboard',
'icon': 'fa-desktop',
'route': 'admin.dashboard'
},
{
'text': 'Users',
'icon': 'fa-user',
'children': [
{
'text': 'List',
'icon': 'fa-list-alt',
'route': 'admin.users'
},
{
'text': 'Stats',
'icon': 'fa-bar-chart-o',
'route': 'admin.users.stats'
}
]
}
] -%}

<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="http://www.gravatar.com/avatar/{{ auth.getUser().email|md5 }}.png?d=mysteryman" class="img-circle" alt="{{ auth.getUser().name }}"/>
            </div>
            <div class="pull-left info">
                <p>{{ auth.getUser().name }}</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            {% for m in menu %}
                {% if m['children'] is defined %}
                    {% set active = false %}
                    {% for c in m['children'] %}
                        {% if router.getMatchedRoute().getName() and c['route'] == router.getMatchedRoute().getName() %}
                            {% set active = true %}
                        {% endif %}
                    {% endfor %}
                    <li class="treeview{% if active == true %} active{% endif %}">
                        <a href="#">
                            <i class="fa {{ m['icon'] }}"></i>
                            <span>{{ m['text'] }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            {% for c in m['children'] %}
                                <li{% if router.getMatchedRoute().getName() and c['route'] == router.getMatchedRoute().getName() %} class="active"{% endif %}>
                                    <a href="{{ url({'for':c['route']}) }}" style="margin-left: 10px;"><i class="fa {{ c['icon'] }}"></i> {{ c['text'] }}</a>
                                </li>
                            {% endfor %}
                        </ul>
                    </li>
                {% else %}
                    <li{% if router.getMatchedRoute().getName() and m['route'] == router.getMatchedRoute().getName() %} class="active"{% endif %}>
                        <a href="{{ url({'for':m['route']}) }}">
                            <i class="fa {{ m['icon'] }}"></i>
                            <span>{{ m['text'] }}</span>
                        </a>
                    </li>
                {% endif %}
            {% endfor %}
        </ul>
    </section>
</aside>