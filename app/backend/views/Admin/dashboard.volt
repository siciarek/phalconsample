{% extends "templates/base.volt" %}

{% block content %}

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>
                        {{ stats.registeredUsers.all }}
                    </h3>
                    <p>
                        {{ trans._('admin.registered_users_all') }}
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">
                    {{ trans._('common.more_info') }} <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-light-blue">
                <div class="inner">
                    <h3>
                        {{ stats.registeredUsers.female }}
                    </h3>
                    <p>
                        {{ trans._('admin.registered_users_female') }}
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-woman"></i>
                </div>
                <a href="#" class="small-box-footer">
                    {{ trans._('common.more_info') }} <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                        {{ stats.registeredUsers.male }}
                    </h3>
                    <p>
                        {{ trans._('admin.registered_users_male') }}
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-man"></i>
                </div>
                <a href="#" class="small-box-footer">
                    {{ trans._('common.more_info') }} <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
    </div>
{% endblock %}
