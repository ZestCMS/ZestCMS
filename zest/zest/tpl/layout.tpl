<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>{{page_title}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}libs/css/normalize.css" />
        <link rel="stylesheet" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/css/style.css" />
        <link rel="shortcut icon" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/favicon.ico" type="image/x-icon">
        <link rel="icon" href="{{PUBLIC_FOLDER_URL}}themes/{{THEME}}/favicon.ico" type="image/x-icon">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <base href="{{ROOT}}" />
    </head>
    <body>
        <header id="header-wrapper">
            <div id="header">
                <h1 id="site_name"><a href="{{ROOT}}">{{SITENAME}}</a></h1>
            </div>
        </header>
        <div id="main-nav-wrapper">
            <nav id="main-nav">
                <a href="{{ROOT}}">Home</a>
            </nav>
        </div>
        
        
        <section id="content-wrapper">
            <div id="content">
                {{FLASH_MESSAGES}}
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