<table>
    <caption>{{LANG.articles_list}}</caption>
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
            <td><a href="{{article.edit_url}}"><i class="fa fa-pencil-square-o"></i></a></td>
            <td><a href="{{article.delete_url}}"
                   onclick="return(confirm({{LANG.articles_confirm_delete}}));"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        {% ENDFOR %}
    </tbody>
</table>

<a href="{{ROOT}}admin/write" class="button">{{LANG.articles_write_new}}</a>

