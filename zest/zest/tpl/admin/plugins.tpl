{% FOR plugin IN plugins %}
    {% if plugin.isInstalled %}
        {% if plugin.isActive %}
            {{plugin.getName}} | <a href="{{plugin.getUnactiveUrl}}" class="button">{{LANG.disable}}</a>
        {% else %}
            {{plugin.getName}} | <a href="{{plugin.getActiveUrl}}" class="button">{{LANG.enable}}</a> | <a href="{{plugin.getUninstallUrl}}" class="button">{{LANG.uninstall}}</a>
        {% endif %}
    {% else %}
            {{plugin.getName}} | <a href="{{plugin.getInstallUrl}}" class="button">{{LANG.install}}</a>
    {% endif %}

{% endfor %}