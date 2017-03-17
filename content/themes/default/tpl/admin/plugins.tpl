{% FOR plugin IN plugins %}
{% if plugin.isActive %}
{{plugin.getName}} | <a href="{{plugin.getUnactiveUrl}}">Disable</a>
{% else %}
{{plugin.getName}} | <a href="{{plugin.getActiveUrl}}">Enable</a>
{% endif %}
{% endfor %}