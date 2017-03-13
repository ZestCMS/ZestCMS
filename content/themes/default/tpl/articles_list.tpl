{%FOR article IN articles %}
<div class="article">
    <h2><a href="{{article.url}}">{{article.title}}</a></h2>
        {{article.date}}
    <div class="article-content">
        {{article.htmlContent}}
    </div>
</div>
{%ENDFOR%}