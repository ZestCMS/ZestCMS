<div class="card">
    <header>
        <h3>{{LANG.articles_list}}</h3>
    </header>
    <table>
        <thead>
            <tr>
                <th>{{LANG.title}}</th>
                <th>{{LANG.date}}</th>
                <th>{{LANG.edit}}</th>
                <th>{{LANG.delete}}</th>
            </tr>
        </thead>
        <tbody>
            {% FOR article IN articles %}
            <tr>
                <td><a href="{{article.url}}">{{article.title}}</a></td>
                <td>{{article.date}}</td>
                <td><a href="{{article.edit_url}}"><i class="icofont-ui-edit"></i></a></td>
                <td><a href="{{article.confirm.href}}" id="{{article.confirm.id}}"><i class="icofont-ui-delete"></i></a>
                </td>
            </tr>
            {% ENDFOR %}
        </tbody>
    </table>

    <a href="{{ROOT}}admin/write" class="button">{{LANG.articles_write_new}}</a>
</div>

{% FOR article IN articles %}
    {{article.confirm}}
{% ENDFOR %}

