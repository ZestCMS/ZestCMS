<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>{{page_title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="{{ROOT}}content/themes/default/css/menus.css" />
        <link rel="stylesheet" href="{{ROOT}}content/themes/default/css/admin.css" />
        <link rel="stylesheet" href="{{ROOT}}content/themes/default/css/jquery.fancybox.min.css" />
        <link rel="shortcut icon" href="{{ROOT}}content/themes/default/favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{ROOT}}content/themes/default/favicon.ico" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="{{ROOT}}content/themes/default/js/menus.js"></script>
        <script src="{{ROOT}}content/themes/default/js/jquery.fancybox.min.js"></script>

        <base href="{{ROOT}}admin/" />
    </head>
    <body>
        <div id="page-container">
            <nav id="sidebar-wrapper">
                {{SIDEBAR_ADMIN_MENU}}
            </nav>
            <header id="header-wrapper">
                <span><a id="sidebar-toggle">{{LANG.menu}}</a></span>
            </header>
            <section id="content-wrapper">
                <div id="content">
                    {{FLASH_MESSAGES}}
                    {{content}}
                </div>
            </section>
        </div>
        <footer id="footer-wrapper">
            <div id="footer">
                {{LANG.powered_by}} <a href="https://github.com/ZestCMS/ZestCMS">Zest</a> • © 2017 {{SITENAME}} •
                <a href="{{ROOT}}logout">{{LANG.logout}}</a>
            </div>
        </footer>
        <script src="{{ROOT}}content/themes/default/js/admin.js"></script>
    </body>
</html>