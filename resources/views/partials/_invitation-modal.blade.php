{{-- <script id="invitation-modal-template" type="text/x-handlebars-template"> --}}
    <div class="ui large modal invitation">

    	<div class="header">邀請</div>
    	<div class="scrolling content">
            <div class="ui grid stackable container">

                <div class="ten wide column">
                    <div class="ui icon input fluid">
                        <input id="location" type="text" name="location" placeholder="search..." ref="location_autocomplete">
                        <i class="inverted circular search link icon"></i>
                    </div>
                    <div id="map" style="width:100%;height:350px"></div>
                </div>

                <div class="six wide column">
                    <div class="ui calendar" id="invitation-date">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Date" name="invitation_date">
                        </div>

                        <div class="ui list">
                            <div class="item">
                                <i class="cloud icon"></i>
                                <div class="content">天氣分數
                                    <span id="weather-score"style="padding-left:1em;"></span>
                                </div>
                            </div>
                            <div class="item">
                                <i class="bicycle icon"></i>
                                <div class="content">交通分數
                                    <span id="traffic-score" style="padding-left:1em;"></span>
                                </div>
                            </div>
                            {{-- <div class="item">
                                <i class="users icon"></i>
                                <div class="content">推薦論文
                                    <div class="ui list" id="paper-list">
                                        <div class="item">
                                            <i class="file icon"></i>
                                            <div class="content"><a href="link">一個具有聲音支援的情感導向式資訊視覺化系統</a></div>
                                        </div>
                                        <div class="item">
                                            <i class="file icon"></i>
                                            <div class="content"><a href="link">應用於程式行為分析之彈性資訊流追蹤技術</a></div>
                                        </div>
                                        <div class="item">
                                            <i class="file icon"></i>
                                            <div class="content"><a href="link">探討腦波資訊回饋對民眾求籤態度的影響</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="item" id="loader-item" style="display:none;">
                                <div class="ui active centered inline inverter loader"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="actions">
            <div class="ui negative button">Cancel</div>
            <div class="ui positive right labeled icon button" id="check-btn">
                Send
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>
{{-- </script> --}}
