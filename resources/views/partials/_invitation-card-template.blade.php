<script id="invitation-card-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card">
        <div class="content">
            <div class="header">@{{data.address}}</div>
            <div class="meta">
                <span class="date">@{{data.time}}</span>
            </div>
            <div class="description">
                <ul>
                    @{{#each data.papers}}
                    <li>@{{name_ch}}</li>
                    @{{/each}}
                </ul>
            </div>
        </div>
    </div>
    @{{/each}}
</script>
