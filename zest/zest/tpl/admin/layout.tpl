<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>{{page_title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/icofont/icofont.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/normalize.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/default/menus.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/default/admin.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/css/menus.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/css/admin.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/jquery.fancybox.min.css" />
        <link rel="shortcut icon" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/favicon.ico" type="image/x-icon">
        <script src="{{PUBLIC_FOLDER_URL}}libs/js/jquery.min.js"></script>
        <script src="{{PUBLIC_FOLDER_URL}}libs/js/menus.js"></script>
        <script src="{{PUBLIC_FOLDER_URL}}libs/js/jquery.fancybox.min.js"></script>
        <base href="{{ROOT}}admin/" />
    </head>
    <body>
        <header id="header">
            <div class="sidebar-toggle-box"><a id="sidebar-toggle" title="{{LANG.menu}}"><i class="icofont-navigation-menu"></i></a></div>
        </header>
        <div id="page-container">
            <nav id="sidebar-wrapper">
                {{SIDEBAR_ADMIN_MENU}}
            </nav>
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
        <script src="{{PUBLIC_FOLDER_URL}}libs/js/admin.js"></script>
    </body>
</html>