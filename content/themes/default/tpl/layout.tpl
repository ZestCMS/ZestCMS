<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>{{page_title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="{{ROOT}}content/themes/default/css/style.css" />
        <link rel="shortcut icon" href="{{ROOT}}content/themes/default/favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{ROOT}}content/themes/default/favicon.ico" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <base href="{{ROOT}}" />
    </head>
    <body>
        <header id="header-wrapper">
            <div id="header">
                <a href="{{ROOT}}"><img src="{{ROOT}}content/themes/default/img/logo.png" title="{{site_name}}" alt="{{site_name}}"/></a>
                <h1 id="site_name"><a href="{{ROOT}}">{{SITENAME}}</a></h1>
            </div>
        </header>
        <section id="content-wrapper">
            <div id="content">
                {{content}}
            </div>
        </section>
        <footer id="footer-wrapper">
            <div id="footer">
                {{LANG.powered_by}} <a href="https://github.com/ZestCMS/ZestCMS">Zest</a> • © 2017 {{SITENAME}} •
                {% if IS_ADMIN %}
                <a href="{{ROOT}}admin">{{LANG.admin_panel}}</a><br/>
                <a href="{{ROOT}}logout">{{LANG.logout}}</a>
                {% else %}
                <a href="{{ROOT}}login">{{LANG.login}}</a>
                {% endif %}
            </div>
        </footer>
    </body>
</html>