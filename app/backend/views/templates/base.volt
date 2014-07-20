<!DOCTYPE html>
<html>
<head>
    <title>Panel administracyjny - {% block title %}Pulpit{% endblock %}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    {% block stylesheets %}

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2-bootstrap.min.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"/>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.2/css/bootstrap3/bootstrap-switch.min.css"/>

        <!-- bootstrap 3.0.2 -->
        <link href="/AdminLTE/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <!-- font Awesome -->
        <link href="/AdminLTE/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <!-- Ionicons -->
        <link href="/AdminLTE/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
        <!-- Morris chart -->
        <link href="/AdminLTE/css/morris/morris.css" rel="stylesheet" type="text/css"/>
        <!-- jvectormap -->
        <link href="/AdminLTE/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css"/>
        <!-- fullCalendar -->
        <link href="/AdminLTE/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
        <!-- Daterange picker -->
        <link href="/AdminLTE/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
        <link href="/AdminLTE/css/iCheck/all.css" rel="stylesheet" type="text/css"/>
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="/AdminLTE/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <link href="/AdminLTE/css/AdminLTE.css" rel="stylesheet" type="text/css"/>

        <style>
            .select2-choices {
                min-width: 200px;
                max-width: 300px;
            }
        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    {% endblock %}
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>
</head>

<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="{{ url({'for':'admin.dashboard'}) }}" class="logo" style="white-space: nowrap">
        <i class="fa fa-wrench"></i>
        Administracja
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>


        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-users"></i>
                        <span class="label label-success">{{ auth.getUser().groups|length }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You are member of {{ auth.getUser().groups|length }} groups</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu" style="padding-left: 12px">
                                {% for group in auth.getUser().groups %}
                                    <li>
                                        <h4>
                                            <i class="fa fa-users fa-fw"></i>&nbsp;
                                            {{  trans._(group) }}
                                        </h4>
                                    </li>
                                {% endfor %}
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-certificate"></i>
                        <span class="label label-info">{{ auth.getUser().roles|length }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have {{ auth.getUser().roles|length }} roles assigned</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu" style="padding-left: 12px">
                                {% for role in auth.getUser().roles %}
                                    <li>
                                        <h4>
                                            <i class="fa fa-certificate"></i>&nbsp;
                                            {{ trans._(role) }}
                                        </h4>
                                    </li>
                                {% endfor %}
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ auth.getUser().name }} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="http://www.gravatar.com/avatar/{{ auth.getUser().email|md5 }}.png?d=mysteryman" class="img-circle" alt="{{ auth.getUser().email }}"/>

                            <p>
                                {{ auth.getUser().name }} - Web Developer
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        {#<li class="user-body">#}
                        {#<div class="col-xs-4 text-center">#}
                        {#<a href="#">Followers</a>#}
                        {#</div>#}
                        {#<div class="col-xs-4 text-center">#}
                        {#<a href="#">Sales</a>#}
                        {#</div>#}
                        {#<div class="col-xs-4 text-center">#}
                        {#<a href="#">Friends</a>#}
                        {#</div>#}
                        {#</li>#}
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat disabled">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url({'for':'logout'}) }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>


    </nav>
</header>

<div class="wrapper row-offcanvas row-offcanvas-left">

    {% include 'partials/menu.volt' %}

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {% block page_header_icon %}<i class="fa fa-desktop text-muted"></i>{% endblock %}
                {% block page_header %}Dashboard{% endblock %}
                <small>{% block page_subheader %}Administracja{% endblock %}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Blank page</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            {% block content %}{% endblock %}
        </section>
        <!-- /.content -->
    </aside>
    <!-- /.right-side -->
</div>
<!-- ./wrapper -->

{% block javascripts %}

    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="/AdminLTE/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="/AdminLTE/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/AdminLTE/js/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="/AdminLTE/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="/AdminLTE/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="/AdminLTE/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- fullCalendar -->
    <script src="/AdminLTE/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="/AdminLTE/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="/AdminLTE/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/AdminLTE/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="/AdminLTE/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="/AdminLTE/js/AdminLTE/app.js" type="text/javascript"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.0/select2.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.2/js/bootstrap-switch.min.js"></script>
    <script src="https://raw.githubusercontent.com/eternicode/bootstrap-datepicker/master/js/locales/bootstrap-datepicker.pl.js"></script>

    <script>
        //        $(document).ready(function(){
        //            $('.left-side').addClass('collapse-left');
        //            $('.right-side').addClass('strech');
        //        });
    </script>
{% endblock %}
</body>
</html>

