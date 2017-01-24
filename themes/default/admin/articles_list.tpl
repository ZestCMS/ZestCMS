<table>
    <caption>Articles list</caption>
    <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        {% FOR article IN articles %}
        <tr>
            <td><a href="{{article.url}}">{{article.title}}</a></td>
            <td>{{article.creationDate}}</td>
            <td><a href="{{article.edit_url}}">Edit</a></td>
            <td><a href="{{article.delete_url}}" onclick="return(confirm('Are you sure to want to delete this article ?'));">Delete</a></td>
        </tr>
        {% ENDFOR %}
    </tbody>
</table>
    
<a href="{{ROOT}}admin/write" class="button">Write a new article</a>

