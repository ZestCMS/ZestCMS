{%FOR article IN articles %}
    <div class="article">
        <h2><a href="{{article.url}}">{{article.title}}</a></h2>
        {{article.date}}
        <div class="article-content">
            {{article.htmlContent}}
        </div>
    </div>
{%ENDFOR%}

{# 
{% NOPARSE %}
{% if arr.namee !== 5 %}
    Yoooooooooooooooooo !
{{arr.name}}
Soooooooooo....
{% else%}
    Test else
{% ENDIF %}

{% if arr.namee %}
    Yoooooooooooooooooo !
{{arr.name}}
Soooooooooo....
{% else%}
    Test else
{% ENDIF %}

<pre><script>alert('test');</script></pre>
<pre>
{%FOR article In articles %}
    Un article ! <br/>
    {{article.name}}
{%ENDFOR%}

{% if arr.namee !== 5 %}
    Yoooooooooooooooooo !
{{arr.name}}
Soooooooooo....
{% else%}
    Test else
{% ENDIF %}

{% if arr.namee %}
    Yoooooooooooooooooo !
{{arr.name}}
Soooooooooo....
{% else%}
    Test else
{% ENDIF %}

  <pre>
2
  </pre>
</pre>

<pre>
3
hvdhkvjkzdkvzd
VDVD
</pre>
{% ENDNOPARSE %}
#}