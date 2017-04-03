<ul class='tabs'>
    <li><a href='#{{ID}}editor' id="{{ID}}_linkedit">{{LANG.content}}</a></li>
    <li><a href='#{{ID}}preview' id="{{ID}}_linkpreview">{{LANG.preview}}</a></li>
</ul>
<div id="{{ID}}editor" class="tabbed">
    {{before_editor}}
    <textarea name='{{ID}}content' id='{{ID}}content' required>{{CONTENT}}</textarea>
</div>
<div id="{{ID}}preview" class="tabbed"></div>

<script>
    $(document).ready(function () {
        $("#{{ID}}_linkpreview").click(function () {
            $.post(
                    '{{ROOT}}admin/write/getpreview',
                    {
                        editor_preview: $("textarea#{{ID}}content").val()
                    },
                    function (data) {
                        $("#{{ID}}preview").html(data);
                    },
                    'text'
                    );
        });
    });
</script>