<script type="text/javascript">
    $('#{{CONFIRM.id}}').click(function() {
    // Open customized confirmation dialog window
    $.fancyConfirm({
      title     : "{{CONFIRM.title}}",
      message   : "{{CONFIRM.text}}",
      okButton  : "{{CONFIRM.yesBtn}}",
      noButton  : "{{CONFIRM.noBtn}}",
      callback  : function (value) {
        if (value) {
          window.location.replace("{{CONFIRM.yesBtnUrl}}");
        } 
        {% if CONFIRM.hasNoBtnUrl %}
    else {
          window.location.replace("{{CONFIRM.noBtnUrl}}");
        }
    {% endif %}
      }
    });

  });
</script>