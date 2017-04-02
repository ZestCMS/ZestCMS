<form action='{{ROOT}}admin/config' method='POST'>
    {{config_saved}}
    <fieldset>
        <legend>Site Config</legend>
        <div>
            <label for='sitename'>{{LANG.sitename}} :</label>
            <input type='text' name='sitename' id='sitename' value="{{sitename}}" required/>
        </div>
        <div>
            <label for='articles_per_page'>{{LANG.articles_per_page}} :</label>
            <input type='number' name='articles_per_page' id='articles_per_page' value="{{articles_per_page}}" min="1" max="10" required/>
        </div>
        <div>
            <label for='date_format'>{{LANG.date_format}} :</label>
            <input type='text' name='date_format' id='date_format' value="{{date_format}}" required/>
        </div>
    </fieldset>
        
    <fieldset>
        <legend>Core Config</legend>
            {{wrong_pass}}
        <div>
            <label for='original_password'>{{LANG.original_password}} :</label>
            <input type='password' name='original_password' id='original_password' />
        </div>
        <div>
            <label for='new_password'>{{LANG.new_password}} :</label>
            <input type='password' name='new_password' id='new_password' />
        </div>
            {{passwordsdiff}}
        <div>
            <label for='repeat_password'>{{LANG.repeat_password}} :</label>
            <input type='password' name='repeat_password' id='repeat_password' />
        </div>
    </fieldset>

    <div class="buttons">
        <button type='submit' name="save_config">{{LANG.form_submit}}</button>
        <button type="reset">{{LANG.form_reset}}</button>
    </div>
</form>