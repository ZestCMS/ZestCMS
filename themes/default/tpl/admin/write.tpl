<p>{{error}}</p>
<form action='{{ROOT}}admin/write' method='POST'>
    <div>
    <label for='title'>Article title</label>
    <input type='text' name='title' id='title' value="{{article.title}}" required/>
    </div>
    <div>
    <label for='encoded_title'>Article URL : {{ROOT}}articles/</label>
    <input type='text' name='encoded_title' id='encoded_title' value="{{article.encoded_title}}" required/>
    </div>
    <div>
    <ul class='tabs'>
        <li><a href='#editor' id="editor_article">Content</a></li>
        <li><a href='#preview' id="preview_article">Preview</a></li>
    </ul>
    <div id="editor" class="tabbed">
        <textarea name='artcontent' id='artcontent' required>{{article.content}}</textarea>
    </div>
    <div id="preview" class="tabbed"></div>
    </div>
    <input type="hidden" name="id" value="{{article.id}}" />
    <input type="hidden" name="creation" value="{{article.creation}}" />
    <div class="buttons">
        <button type='submit' name="save_article">Submit</button>
        <button type="reset">Reset</button>
    </div>
</form>
    
<script>
$(document).ready(function(){
    $("#title").keyup(function(){
        $.post(
            '{{ROOT}}admin/write/getencodedtitle',
            {
                title : $("#title").val()
            },
            function(data){
                $("#encoded_title").val(data);
            },
            'text'
         );
    });
    
    $("#preview_article").click(function(){
        $.post(
            '{{ROOT}}admin/write/getpreview',
            {
                artcontent : $("textarea#artcontent").val()
            },
            function(data){
                $("#preview").html(data);
            },
            'text'
         );
    });
    
    $('ul.tabs').each(function(){
    // For each set of tabs, we want to keep track of
    // which tab is active and its associated content
    var $active, $content, $links = $(this).find('a');

    // If the location.hash matches one of the links, use that as the active tab.
    // If no match is found, use the first link as the initial active tab.
    $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');

    $content = $($active[0].hash);

    // Hide the remaining content
    $links.not($active).each(function () {
      $(this.hash).hide();
    });

    // Bind the click event handler
    $(this).on('click', 'a', function(e){
      // Make the old tab inactive.
      $active.removeClass('active');
      $content.hide();

      // Update the variables with the new link and content
      $active = $(this);
      $content = $(this.hash);

      // Make the tab active.
      $active.addClass('active');
      $content.show();

      // Prevent the anchor's default click action
      e.preventDefault();
    });
  });
  setTimeout(function() {
        $("#editor_article").trigger('click');
    },10);
  
});
</script>