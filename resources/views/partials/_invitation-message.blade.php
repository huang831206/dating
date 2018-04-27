<script id="invitation-message-template" type="text/x-handlebars-template">
    <div class="item">
        <div class="content message ui large olive" style="max-width:100%">
            @{{#if from_me}}

            您已邀請對方參加@{{invitation.data.time}}，在@{{invitation.data.address}}的聚會
            你們的推薦論文為：
            <ul>
                @{{#each invitation.data.papers}}
                <li>@{{name_ch}}</li>
                @{{/each}}
            </ul>

            @{{else}}

            請確認是否參加@{{time}}，在@{{address}}的聚會？
            你們的推薦論文為：
            <ul>
                @{{#each papers}}
                <li>@{{name_ch}}</li>
                @{{/each}}
            </ul>
            <div class="actions" style="margin-top:1em">
                <div class="ui negative button deny-invitation-btn">No</div>
                <div class="ui positive right labeled icon button approve-invitation-btn" data-id="@{{id}}">
                    Yes
                    <i class="checkmark icon"></i>
                </div>
            </div>

            @{{/if}}
        </div>

    </div>
</script>
