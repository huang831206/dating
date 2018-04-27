<script id="invitation-card-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card" data-id="@{{id}}">
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
        <div class="extra content">
            <div class="right floated">
                <button class="circular ui icon red inverted button remove-invitation-btn" data-tooltip="delete">
                    <i class="remove large icon"></i>
                </button>
            </div>
        </div>
    </div>
    @{{/each}}
</script>
