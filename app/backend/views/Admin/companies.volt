{% extends "templates/base.volt" %}

{% block javascripts %}
    {{ super() }}
    <script>
        var updateParameterUrl = '{{ url({'for':'admin.update_parameter', 'model' : 'Company' }) }}';

        function setControls() {
            $('.editable.name, .editable.info').editable({
                url: updateParameterUrl,
                mode: 'inline',
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

            $('table.companies').on('click', '.btn.remove', function(event){
                event.preventDefault();
                var row = $(this).closest('tr');
                var id = row.attr('id').replace(/\D+/, '');

                if(id == 0) {
                    row.remove();
                }
                else {
                    console.log(id);
                }
            });
        }

        $(document).ready(function () {

            setControls();

            $('table.companies').on('click', '.btn.add', function(event){
                event.preventDefault();

                var nameCtrl = '<a class="editable name" data-name="name" data-pk="0" data-value="" data-type="text" href="#"></a>';
                var infoCtrl = '<a class="editable info" data-name="info" data-pk="0" data-value="" data-type="textarea" href="#"></a>';
                var buttonRemove = '<div class="btn-group pull-right"><a href="#" class="btn btn-danger btn-xs remove" title="{{ 'common.remove'|trans }}"><i class="fa fa-times-circle fa-lg"></i></a></div>';

                var row = '<tr id="company-0"><td>' + nameCtrl +'</td><td>' + infoCtrl + '</td><td>' + buttonRemove + '</td></tr>';

                $('table.companies tbody').prepend(row);

                setControls();
            });
        });
    </script>
{% endblock %}

{% block page_header %}{{ trans._('company.plural_name') }}{% endblock %}
{% block page_subheader %}({{ pager.count() }}){% endblock %}
{% block page_header_icon %}<i class="fa fa-user text-muted"></i>{% endblock %}
{% block content %}

    <div id="companies" class="row">
        <div class="col-lg-12">

            {% if pager|length() == 0 %}
                <div class="alert alert-warning">
                    {{ 'common.nothing_found'|trans }}
                </div>
            {% else %}
                <table class="table table-condensed companies" id="no-more-tables">
                    <thead>
                    <tr>
                        <th>{{ 'company.company_name'|trans }}</th>
                        <th class="col-lg-6">{{ 'company.info'|trans }}</th>
                        <th>
                            <div class="btn-group pull-right">
                                <a href="#" class="btn btn-success btn-xs add" title="{{ 'common.add'|trans }}">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for i in pager %}
                        <tr id="company-{{ i.getId() }}">
                            <td data-title="{{ trans._('company.company_name') }}">{{ xeditable_input('text', 'name', i.getId(), i.getName()) }}</td>
                            <td data-title="{{ trans._('company.info') }}">{{ xeditable_input('textarea', 'info', i.getId(), i.getInfo()) }}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="#" class="btn btn-danger btn-xs remove" title="{{ 'common.remove'|trans }}">
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
    </div>
{% endblock %}
