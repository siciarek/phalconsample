{% extends "templates/base.volt" %}

{% block javascripts %}
    {{ super() }}
    <script>
        var updateParameterUrl = '{{ url({'for':'admin.update_parameter', 'model': 'User'}) }}';
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

                    $(resp.data).each(function (i, e) {
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

                    $(resp.data).each(function (i, e) {
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
{% block page_subheader %}({{ pager.count() }}){% endblock %}
{% block page_header_icon %}<i class="fa fa-user text-muted"></i>{% endblock %}
{% block content %}


<ul class="nav nav-tabs">
    <li class="active">
        <a href="#users" data-toggle="tab">
            <i class="fa fa-user"></i>
            {{ 'user.plural_name'|trans }}
        </a>
    </li>
    <li>
        <a href="#groups" data-toggle="tab">
            <i class="fa fa-users"></i>
            {{ 'group.plural_name'|trans }}
        </a>
    </li>
</ul>

<br/>

<div class="tab-content">

    <div id="users" class="tab-pane active in">

        {% if pager|length() == 0 %}
            <div class="alert alert-warning">
                {{ 'common.nothing_found'|trans }}
            </div>
        {% else %}
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
                {% for i in pager %}
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
                            {% set ugroups = [] %}
                            {% for g in i.userGroups %}
                                {% set ugroups = ugroups|merge([g.group_id]) %}
                            {% endfor %}
                            {{ xeditable_input('select2', 'groups', i.id, ugroups) }}
                        </td>
                        <td class="col-md-1">
                            {% set uroles = [] %}
                            {% for r in i.roles %}
                                {% set uroles = uroles|merge([r]) %}
                            {% endfor %}
                            {{ xeditable_input('select2', 'roles', i.id, uroles) }}
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

            {% if pager.haveToPaginate() %}
                {{ pager.getLayout() }}
            {% endif %}

        {% endif %}

    </div>

    <div id="groups" class="tab-pane">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-users text-muted"></i>
                            {{ 'group.plural_name'|trans }}
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>{{ 'common.name'|trans }}</th>
                                <th>{{ 'common.description'|trans }}</th>
                                <th>{{ 'role.plural_name'|trans }}</th>
                                <th>
                                    <div class="btn-group pull-right">
                                        <a href="#" class="btn btn-success btn-xs" title="{{ 'common.add'|trans }}">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </a>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for g in groups %}
                                <tr>
                                    <td>{{ g.name }}</td>
                                    <td>{{ g.info }}</td>
                                    <td>
                                        {% if g.roles|length() == 0 %}
                                            {{ value_or_dash('') }}
                                        {% else %}
                                            <ul class="list-unstyled">
                                            {% for r in g.roles %}
                                                <li>{{ r }}</li>
                                            {% endfor %}
                                            </ul>
                                        {% endif %}
                                    </td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <a href="#" class="btn btn-danger btn-xs" title="{{ 'common.remove'|trans }}">
                                                <i class="fa fa-times-circle fa-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title">
                            <i class="fa fa-cogs text-muted"></i>
                            {{ 'role.plural_name'|trans }}
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>{{ 'common.name'|trans }}</th>
                                <th>{{ 'role.dependencies'|trans }}</th>
                                <th>
                                    <div class="btn-group pull-right">
                                        <a href="#" class="btn btn-success btn-xs" title="{{ 'common.add'|trans }}">
                                            <i class="fa fa-plus-circle fa-lg"></i>
                                        </a>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for r, deps in roles %}
                                <tr>
                                    <td>{{ r }}</td>
                                    <td>{% if deps|length %}{{ deps|join(', ') }}{% else %}{{ value_or_dash('') }}{% endif %}</td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <a href="#" class="btn btn-danger btn-xs" title="{{ 'common.remove'|trans }}">
                                                <i class="fa fa-times-circle fa-lg"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            {% endfor %}
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {% endblock %}
