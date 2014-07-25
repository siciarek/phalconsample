{% extends "templates/base.volt" %}
{% block stylesheets %}
    {{ super() }}
    <style>

    </style>
{% endblock %}

{% block javascripts %}
    {{ super() }}

    <script src="/aceadmin/assets/js/flot/jquery.flot.min.js"></script>

    <script>
        $(document).ready(function () {

            var chartData = {{ chartData|json_encode }};

            $("#workers-chart, #revenue-chart").css({'width': '100%', 'height': '300px'});

            $.plot(
                    "#workers-chart",
                    [
                        { label: "Workers", data: chartData.workers }
                    ]
            );

            $.plot(
                    "#revenue-chart",
                    [
                        { label: "Revenue", data: chartData.revenue }
                    ]
            );
        });
    </script>
{% endblock %}

{% block content %}
    <div class="page-header">
        <h1>
            <i class="fa fa-cog text-info"></i>
            Companies
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Workers/Revenue
            </small>
        </h1>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-flat">
                    <h4 class="widget-title lighter">
                        <i class="ace-icon fa fa-signal"></i>
                        Workers
                    </h4>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-4">
                        <div id="workers-chart"></div>
                    </div>
                    <!-- /.widget-main -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-box -->
        </div>
        <!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="widget-box transparent">
                <div class="widget-header widget-header-flat">
                    <h4 class="widget-title lighter">
                        <i class="ace-icon fa fa-signal"></i>
                        Revenue
                    </h4>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-4">
                        <div id="revenue-chart"></div>
                    </div>
                    <!-- /.widget-main -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-box -->
        </div>
        <!-- /.col -->
    </div><!-- /.row -->

{% endblock %}

