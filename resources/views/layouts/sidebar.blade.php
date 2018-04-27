<div class="ui top sidebar segment">
    <div class="ui center aligned page grid">
        <div class="one column row">
            <div class="sixteen wide column">
                <h2 class="ui header">關於對方</h2>
            </div>
        </div>
        <div class="four column divided row">
            <div class="column">
                {{dump($data)}}
                <img  class="ui image" src="{{asset('images/'. $data['other_profile']->gender .'.png')}}">
            </div>
            <div class="column">
                <img class="ui wireframe image" src="/images/wireframe/media-paragraph.png">
            </div>
            <div class="column">
                <img class="ui wireframe image" src="/images/wireframe/media-paragraph.png">
            </div>
            <div class="column">
                <img class="ui wireframe image" src="/images/wireframe/media-paragraph.png">
            </div>
        </div>
    </div>
</div>
