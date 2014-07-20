{% extends "templates/base.volt" %}

{% block page_header %}{{ trans._('user.plural_name') }}{% endblock %}
{% block page_subheader %}Stats{% endblock %}
{% block page_header_icon %}<i class="fa fa-bar-chart-o text-muted"></i>{% endblock %}

{% block javascripts %}
    {{ super() }}
    <script>
        var bar = new Morris.Bar({
            element: 'user-female-names-bar-chart',
            resize: true,
            data: {{ user_female_names|json_encode }},
            barColors: ['#00a65a'],
            xkey: 'name',
            ykeys: ['count'],
            hideHover: 'auto'
        });

        var bar = new Morris.Bar({
            element: 'user-male-names-bar-chart',
            resize: true,
            data: {{ user_male_names|json_encode }},
            barColors: ['#a6005a'],
            xkey: 'name',
            ykeys: ['count'],
            hideHover: 'auto'
        });
    </script>
{% endblock %}

{% block content %}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-female text-muted"></i>
                        Female names
                    </h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="user-female-names-bar-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="fa fa-male text-muted"></i>
                        Male names
                    </h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="user-male-names-bar-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
{% endblock %}
