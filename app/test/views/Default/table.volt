{% extends "templates/base.volt" %}

{% block javascripts %}
    {{ super() }}
    {#<script src="/aceadmin/assets/js/jquery.dataTables.bootstrap.js"></script>#}
    <script>

    $(document).ready(function() {
        $('#example').dataTable( {
            processing: true,
            serverSide: true,
            ajax: {
                type: 'GET',
                url: '/test/companies'
            },
            columns: [
                { data: 'status' },
                { data: 'name' },
                { data: 'info', sortable: false }
            ]
        } );
    } );

    </script>
{% endblock %}

{% block content %}

    <table id="example" class="table table-condensed" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="col-xs-1">{{ 'company.status'|trans }}</th>
            <th>{{ 'company.name'|trans }}</th>
            <th class="col-xs-6">{{ 'company.info'|trans }}</th>
        </tr>
        </thead>
    </table>

{% endblock %}