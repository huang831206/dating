<script id="match-card-template" type="text/x-handlebars-template">
    @{{#each this}}
    <div class="card match-card" data-hash="@{{hash}}">
        <div class="blurring dimmable image">
            <div class="ui dimmer">
                <div class="content">
                    <div class="center">
                        <div class="ui inverted button detail-history-btn">對話紀錄</div>
                    </div>
                </div>
            </div>
            <img src="/images/@{{other_profile.gender}}.png" data-gender="@{{other_profile.gender}}">
        </div>

        <div class="content">
            <div class="header">@{{ago created_at}}</div>
            <div class="meta">
                <span class="date">Your last conversation:</br>@{{updated_at}}</span>
            </div>
            <div class="description">
                這是一位來自@{{city other_profile.location_id}}專精於@{{area other_profile.research_area_id}}的@{{other_profile.gender}}
            </div>
        </div>
        <div class="extra">
            你給他:
            <div class="ui star rating my-rating" data-rating="@{{i_rate}}" data-max-rating="5"></div>
        </div>
        <div class="extra">
            他給你:
            <div class="ui star rating other-rating" data-rating="@{{me_rated}}" data-max-rating="5"></div>
        </div>
    </div>
    @{{/each}}
</script>
