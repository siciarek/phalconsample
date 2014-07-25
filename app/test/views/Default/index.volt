{% extends "templates/base.volt" %}

{% block javascripts %}
    {{ super() }}
    <script>
        $(document).ready(function () {
            $('th.sort').click(function () {
                var self = $(this);
                var field = self.attr('class').split(' ').pop();
                var dir = self.attr('class').match(/asc|desc/);
                dir = dir == null ? 'desc' : dir.pop();
                dir = dir === 'asc' ? 'desc' : 'asc';

                var url = '/test';
                var url = url + '?order=' + field + ':' + dir;

                location.href = url;
            });
            $('table.companies tbody').on('click', 'td button.status', function () {
                var self = $(this);
                var row = self.closest('tr');
                var data = row.attr('id').split('-');
                var model = data.shift();
                var id = data.shift();

                var url = '/test/toggle-status/' + model + '/' + id;

                $.ajax({
                    url: url,
                    success: function (resp) {
                        var status = row.find('td:nth-child(2) span.label');
                        status.addClass('hidden');

                        if (resp.enabled == 0) {
                            row.find('td:nth-child(2) span.label.disabled').removeClass('hidden');
                            self.removeClass('btn-success').addClass('btn-warning');
                            self.find('i').removeClass('fa-check').addClass('fa-ban');
                        }
                        else {
                            row.find('td:nth-child(2) span.label.enabled').removeClass('hidden');
                            self.removeClass('btn-warning').addClass('btn-success');
                            self.find('i').removeClass('fa-ban').addClass('fa-check');
                        }
                    }
                });
            });
        });
    </script>
{% endblock %}

{% block content %}

    {%- macro sortable_header(req, field, text) %}
        {% set order_name = null %}
        {% set order_dir = null %}
        {% set temp = req|split(':') %}
        {% if req is empty or temp is empty %}
        {% else %}
            {% set order_name = temp[0] %}
            {% set order_dir = temp[1] %}
        {% endif %}
        <th class="sort{% if order_name == field %} {{ order_dir }}{% endif %} {{ field }}">{{ text }}</th>
    {% endmacro -%}

    <style>
        th.sort:after {
            content: "\f0dc";
            font-family: FontAwesome;
            float: right;
        }

        th.sort.asc:after {
            content: "\f0de";
        }

        th.sort.desc:after {
            content: "\f0dd";
        }

        th.sort {
            cursor: pointer;
        }

        th.sort:hover, th.sort.asc, th.sort.desc {
            background-color: #7db4d8;
            color: #fff;
        }

        ul#initials {
            margin-bottom: 8px !important;
        }
    </style>

    <div class="page-header">
        <h1>
            <i class="fa fa-cog text-info"></i>
            Companies
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Registered companies ({{ pager.count() }})
            </small>
        </h1>
    </div>

    {% if pager|length() == 0 or pager.getCurrentPage() > pager.getLastPage() %}

        <div class="alert alert-danger">
            <i class="ace-icon fa fa-warning"></i>
            {{ 'company.error.no_items_found'|trans }}
            <br>
        </div>

    {% else %}

        <ul id="initials" class="nav nav-tabs padding-12 tab-color-blue background-blue">
            {% set initial = request.get('filter_field') == 'initial' ? request.get('filter_value') : null %}
            {% for key, val in initials %}
                <li class="{% if initial == null and loop.first or initial == key %} active{% endif %}">
                    <a href="{{ url({'for': 'test.index'}) }}?filter_field=initial&filter_value={{ key }}"><strong>{{ val }}</strong></a>
                </li>
            {% endfor %}
        </ul>

        <table class="table table-striped table-bordered table-hover companies">
            <thead>
            <tr>
                <th class="center">
                    <label class="position-relative">
                        <input type="checkbox" class="ace">
                        <span class="lbl"></span>
                    </label>
                </th>

                {{ sortable_header(''~request.get('order'), 'enabled', 'company.status'|trans) }}
                {{ sortable_header(''~request.get('order'), 'name', 'company.name'|trans) }}

                <th>{{ 'company.info'|trans }}</th>
                <th>
                    <div class="hidden-sm hidden-xs btn-group">
                        <button class="btn btn-xs btn-success add">
                            <i class="ace-icon fa fa-fw fa-plus-circle bigger-120"></i>
                        </button>
                        <button class="btn btn-xs btn-primary add">
                            <i class="ace-icon fa fa-fw fa-list-alt bigger-120"></i>
                        </button>
                    </div>
                </th>
            </tr>
            </thead>

            <tbody>
            {% for i in pager %}
                <tr id="company-{{ i.getId() }}">
                    <td class="center col-lg-1">
                        <label class="position-relative">
                            <input type="checkbox" class="ace">
                            <span class="lbl"></span>
                        </label>
                    </td>

                    <td class="col-xs-1 hidden-480">
                        <span class="label label-sm label-success enabled{% if i.getEnabled() == false %} hidden{% endif %}">Enabled</span>
                        <span class="label label-sm label-warning disabled{% if i.getEnabled() == true %} hidden{% endif %}">Disabled</span>
                    </td>

                    <td class="col-lg-3">
                        {{ i.getName() }}
                    </td>

                    <td>
                        <em>{{ i.getInfo() }}</em>
                        <br/>
                        <strong>{{ i.revenue.getWorkersCount() }}</strong>
                        <br/>
                        <strong>{{ i.revenue.getRevenue() }}</strong>
                    </td>

                    <td class="col-xs-1">
                        <div class="hidden-sm hidden-xs btn-group">
                            {% if i.getEnabled() == 1 %}
                                <button class="btn btn-xs btn-success status">
                                    <i class="ace-icon fa fa-fw fa-check bigger-120"></i>
                                </button>
                            {% else %}
                                <button class="btn btn-xs btn-warning status">
                                    <i class="ace-icon fa fa-fw fa-ban bigger-120"></i>
                                </button>
                            {% endif %}

                            <button class="btn btn-xs btn-info edit">
                                <i class="ace-icon fa fa-fw fa-pencil bigger-120"></i>
                            </button>

                            <button class="btn btn-xs btn-danger remove">
                                <i class="ace-icon fa fa-fw fa-trash-o bigger-120"></i>
                            </button>
                        </div>
                    </td>

                </tr>
            {% endfor %}

            </tbody>
        </table>


    {% endif %}


    {% if pager.haveToPaginate() %}
        {{ pager.getLayout() }}
    {% endif %}

{% endblock %}

