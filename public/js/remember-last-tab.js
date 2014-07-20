var _remember_last_tab_cookie_name = '__remember_last_tab';

function setLastTab(name) {
    $.cookie(_remember_last_tab_cookie_name, name, { path: '/' });
}

function getLastTab() {
    return $.cookie(_remember_last_tab_cookie_name);
}

function rememberLastTab(tabsClass) {

    $('.' + tabsClass + ' a[data-toggle="tab"]').on('click', function (e) {
        // save the latest tab using a cookie:
        setLastTab($(e.target).attr('href'));
    });

    // activate latest tab, if it exists:
    var lastTab = getLastTab();

    if (lastTab) {
        $('.' + tabsClass + ' a[href=' + lastTab + ']').tab('show');
    }
    else {
        // set the first tab if cookie do not exist:
        $('.' + tabsClass + ' a[data-toggle="tab"]:first').trigger('click');
    }
}

function clearLastTab() {
    return $.removeCookie(_remember_last_tab_cookie_name, { path: '/' });
}
