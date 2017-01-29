<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>{{page_title}}</title>
    <link rel="stylesheet" href="{{ROOT}}themes/default/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <base href="{{ROOT}}" />
</head>
<body>
    <header id="header-wrapper">
        <div id="header">
            <a href="{{ROOT}}"><img src="{{ROOT}}themes/default/img/logo.png" title="{{site_name}}" alt="{{site_name}}"/></a>
            <h1 id="site_name"><a href="{{ROOT}}">{{site_name}}</a></h1>
        </div>
    </header>
    <section id="content-wrapper">
        <div id="content">
            {{content}}
        </div>
    </section>
    <footer id="footer-wrapper">
        <div id="footer">
            Powered by <a href="https://github.com/MaxenceCauderlier/ZestCMS">Zest</a> • © 2017 {{site_name}} • 
            {% if IS_ADMIN %}
                <a href="{{ROOT}}admin">Admin Panel</a><br/>
                <a href="{{ROOT}}logout">Logout</a>
            {% else %}
                <a href="{{ROOT}}login">Login</a>
            {% endif %}
        </div>
    </footer>
</body>
</html>