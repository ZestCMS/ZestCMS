{%FOR article IN articles %}
<article class="article">
    <header>
    <h1><a href="{{article.url}}">{{article.title}}</a></h1>
        {{article.date}}
    </header>
    <div class="article-content">
        {{article.truncated_content}}
    </div>
</article>
{%ENDFOR%}