{% FOR plugin IN plugins %}
    <div class="block full">
        <h3><a href="{{plugin.author_url}}">{{plugin.name}}</a></h3>
        <p>{{plugin.description}}</p>
        <span><a href="mailto:{{plugin.author_mail}}">{{plugin.author}}</a></span>
        {% if plugin.isInstalled %}
            {% if plugin.isActive %}
                <span><a href="{{plugin.getUnactiveUrl}}" class="button">{{LANG.disable}}</a></span>
            {% else %}
                <span><a href="{{plugin.getActiveUrl}}" class="button">{{LANG.enable}}</a></span><span><a href="{{plugin.getUninstallUrl}}" class="button">{{LANG.uninstall}}</a></span>
            {% endif %}
        {% else %}
                <span><a href="{{plugin.getInstallUrl}}" class="button">{{LANG.install}}</a></span>
        {% endif %}
    </div>
{% endfor %}