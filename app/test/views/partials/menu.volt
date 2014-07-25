<!-- #section:basics/sidebar -->

<div id="sidebar" class="sidebar responsive">

<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'fixed')
    } catch (e) {
    }
</script>

<div class="sidebar-shortcuts" id="sidebar-shortcuts">

    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success">
            <i class="ace-icon fa fa-signal"></i>
        </button>
        <button class="btn btn-info">
            <i class="ace-icon fa fa-pencil"></i>
        </button>
        <button class="btn btn-warning">
            <i class="ace-icon fa fa-users"></i>
        </button>
        <button class="btn btn-danger">
            <i class="ace-icon fa fa-cogs"></i>
        </button>
    </div>

    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>
        <span class="btn btn-info"></span>
        <span class="btn btn-warning"></span>
        <span class="btn btn-danger"></span>
    </div>
</div>

<!-- /.sidebar-shortcuts -->

<ul class="nav nav-list">

    <li>
        <a href="index.html">
            <i class="menu-icon fa fa-desktop"></i>
            <span class="menu-text">Pulpit</span>
        </a>
        <b class="arrow"></b>
    </li>

    <li>

        <a href="#" class="dropdown-toggle">
            <i class="menu-icon fa fa-cog"></i>
            <span class="menu-text">Companies</span>

            <b class="arrow fa fa-angle-down"></b>
        </a>

        <ul class="submenu">
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    List
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Stats
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Messages
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>
            </li>
        </ul>

    </li>
</ul>
<!-- /.nav-list -->

<!-- #section:basics/sidebar.layout.minimize -->
<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
</div>

<!-- /section:basics/sidebar.layout.minimize -->
<script type="text/javascript">
    try {
        ace.settings.check('sidebar', 'collapsed')
    } catch (e) {
    }
</script>

</div>
<!-- /section:basics/sidebar -->