{% extends "templates/base.volt" %}

{% block javascripts %}
    {{ super() }}
    <script>
        var updateParameterUrl = '{{ url({'for':'admin.update_parameter'}) }}';
        var groupList = {{ groupList|json_encode }};
        var roleList = {{ roleList|json_encode }};

        $(document).ready(function () {

            $('.editable.firstName, .editable.lastName, .editable.email, .editable.info').editable({
                url: updateParameterUrl,
                showbuttons: false,
                placement: 'right',
                clear: false,
                success: function (resp, config) {
                    if (resp.hasOwnProperty('success') === false) {
                        return 'common.error.unexpected_error';
                    }
                    else {
                        if (resp.success === false) {
                            return resp.data.join("\n");
                        }
                        return { newValue: resp.data === {} ? null : resp.data };
                    }
                }
            });

            $('.editable.expires_at').editable({
                url: updateParameterUrl,
                showbuttons: false,
                placement: 'right',
                datepicker: {
                    language: 'pl',
                    startDate: '-1d',
                    autoclose: true,
                    weekStart: 1
                },
                success: function (resp, config) {
                    if (resp.hasOwnProperty('success') === false) {
                        return 'common.error.unexpected_error';
                    }
                    else {
                        if (resp.success === false) {
                            return resp.data.join("\n");
                        }
                    }
                }
            });

            $('.editable.groups').editable({
                url: updateParameterUrl,
                showbuttons: true,
                placement: 'left',
                source: groupList,
                select2: {
                    multiple: true,
                    allowClear: true
                },
                success: function (resp, config) {
                    if (resp.success === false) {
                        return resp.data.join("\n");
                    }
                    var data = [];

                    $(resp.data).each(function(i, e){
                        data.push(e.id);
                    });
                    return { newValue: resp.data === {} ? null : data };
                }
            });

            $('.editable.roles').editable({
                url: updateParameterUrl,
                showbuttons: true,
                placement: 'left',
                source: roleList,
                select2: {
                    multiple: true,
                    allowClear: true
                },
                success: function (resp, config) {
                    if (resp.success === false) {
                        return resp.data.join("\n");
                    }
                    var data = [];

                    $(resp.data).each(function(i, e){
                        data.push(e);
                    });

                    return { newValue: resp.data === {} ? null : data };
                }
            });

                //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-green, input[type="radio"].flat-green')
                    .iCheck({
                        checkboxClass: 'icheckbox_flat-green',
                        radioClass: 'iradio_flat-green'
                    }).
                    on('ifToggled', function (event, val) {
                        var data = {
                            name: 'enabled',
                            pk: $(this).closest('tr').attr('id').replace(/\D+/, ''),
                            value: this.checked ? 1 : 0
                        };

                        $.ajax({
                            method: 'POST',
                            url: updateParameterUrl,
                            data: data
                        });
                    });

        });
    </script>
{% endblock %}

{% block page_header %}{{ trans._('user.plural_name') }}{% endblock %}
{% block page_subheader %}({{ page.total_items }}){% endblock %}
{% block page_header_icon %}<i class="fa fa-user text-muted"></i>{% endblock %}
{% block content %}

    <table class="table table-condensed" id="no-more-tables">
        <thead>
        <tr>
            <th>{{ 'user.signed_up'|trans }}</th>
            <th class="center">{{ 'user.enabled'|trans }}</th>
            <th class="center">{{ 'user.gender'|trans }}</th>
            <th>{{ 'user.first_name'|trans }}</th>
            <th>{{ 'user.last_name'|trans }}</th>
            <th>{{ 'user.email'|trans }}</th>
            <th class="nowrap">{{ 'user.expires_at'|trans }}</th>
            <th>{{ 'user.info'|trans }}</th>
            <th>{{ 'Groups'|trans }}</th>
            <th>{{ 'Roles'|trans }}</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        {% for i in page.items %}
            <tr id="user-{{ i.id }}">
                <td class="nowrap" data-title="{{ 'user.signed_up'|trans }}">{{ i.created_at|date('Y-m-d H:i') }}</td>
                <td data-title="{{ trans._('user.enabled') }}" class="center">
                    <label>
                        <input class="flat-green" type="checkbox" {% if i.enabled %}checked{% endif %}/>
                    </label>
                </td>
                <td data-title="{{ trans._('user.gender') }}" class="center"><i class="fa fa-{{ i.gender }} fa-lg"></i></td>
                <td data-title="{{ trans._('user.first_name') }}">{{ xeditable_input('text', 'firstName', i.id, i.firstName) }}</td>
                <td data-title="{{ trans._('user.last_name') }}">{{ xeditable_input('text', 'lastName', i.id, i.lastName) }}</td>
                <td data-title="{{ trans._('user.email') }}">{{ xeditable_input('email', 'email', i.id, i.email) }}</td>
                <td data-title="{{ trans._('user.expires_at') }}">
                    {{ xeditable_input('date', 'expires_at', i.id, i.expires_at ? (i.expires_at|date('Y-m-d')) : '') }}
                </td>
                <td data-title="{{ trans._('user.info') }}">{{ xeditable_input('textarea', 'info', i.id, ''~i.info) }}</td>
                <td class="col-md-1">
                    {% set groups = [] %}
                    {% for g in i.groups %}
                        {% set groups = groups|merge([g.id]) %}
                    {% endfor %}
                    {{ xeditable_input('select2', 'groups', i.id, groups) }}
                </td>
                <td class="col-md-1">
                    {% set roles = [] %}
                    {% for r in i.roles %}
                        {% set roles = roles|merge([r]) %}
                    {% endfor %}
                    {{ xeditable_input('select2', 'roles', i.id, roles) }}
                </td>
                <td class="col-md-1 right">
                    <div class="btn-group">
                        <a class="btn btn-primary btn-xs" title="{{ trans._('common.send_email') }}">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>
                        <a class="btn btn-danger btn-xs" title="{{ trans._('common.remove') }}">
                            <i class="fa fa-times-circle fa-lg"></i>
                        </a>
                    </div>
                </td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

    {% if page.total_pages > 1 %}
        <hr/>

        {% set route = 'admin.users' %}

        <ul class="pagination pagination-sm pull-right">

            <li>
                <span>
                    <a href="{{ url({ 'for' : route }) }}">
                        <i class="fa fa-fast-backward"></i>
                    </a>
                </span>
            </li>
            <li>
                <span>
                    <a href="{{ url({ 'for' :  route }) }}?page={{ page.before }}">
                        <i class="fa fa-step-backward"></i>
                    </a>
                </span>
            </li>

            {% for p in page.start .. page.end %}
                <li{% if page.current == p %} class="active"{% endif %}><a href="{{ url({ 'for' : route }) }}?page={{ p }}">{{ p }}</a></li>
            {% endfor %}

            <li{% if page.current == page.last %} class="disabled"{% endif %}>
                <span>
                    <a href="{{ url({ 'for' : route }) }}?page={{ page.next }}">
                        <i class="fa fa-step-forward"></i>
                    </a>
                </span>
            </li>

            <li{% if page.current == page.last %} class="disabled"{% endif %}>
                <span>
                    <a href="{{ url({ 'for' : route }) }}?page={{ page.last }}">
                        <i class="fa fa-fast-forward"></i>
                    </a>
                </span>
            </li>

            <li>
                <span><strong>{{ page.current }}/{{ page.total_pages }}</strong></span>
            </li>
        </ul>
    {% endif %}

{% endblock %}
