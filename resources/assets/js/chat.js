// var io = require('socket.io-client');
// // 建立 socket.io 的連線
// var notification = io.connect('http://dating.my:3000');
// // 當從 socket.io server 收到 notification 時將訊息印在 console 上
// notification.on('message', function(message) {
//     console.log(message);
// });

import Echo from "laravel-echo"
window.calendar = require('calendar');

var hash = location.pathname.substring(6);


window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});



// connect to chat after paring, and retreiving channel hash
window.Echo.join('chat.' + hash)
    .here(function (user) {     // paass [ok => true] instead of users, because it should anonymous
        // join the channel successfully
        console.log(user.length > 1 ? 'he/she is here!' : 'he/she is afk');
        console.log(user);
    })
    .joining(function (user) {
        console.log('he/she just joined the room');
        console.log(user);
    })
    .leaving(function (user) {
        console.log('he/she is afk');
        console.log(user);
    })
    .listenForWhisper('typing', function (event) {
        console.log('he/she is typing');
    })
    .listen('MessageReceived', function (event) {
        console.log(event);
        var source  = document.getElementById("other-message-template").innerHTML;
        var html = Handlebars.compile(source)({message: event.message.message});
        $('.chat-messages').append(html);
        // when new message comes, scroll content to bottom
        toBottom();
    })
    .listen('InvitationRecieved', function (event) {
        console.log(event);
        var data = JSON.parse(event.invitation.data);
        data.from_me = false;
        data.id = event.invitation.id;
        console.log(data);
        var source  = document.getElementById("invitation-message-template").innerHTML;
        var html = Handlebars.compile(source)(data);
        console.log(html);
        $('.chat-messages').append(html);
        toBottom();
    })
    .listen('MatchEnded', function (event) {
        console.log('he/she ended the chat');
        console.log(event);
        disableChat();
    });

$(document).ready(function () {
    // CSR messages
    toBottom();
});

$('.sidebar')
    .sidebar({
        context: $('#app')
    })
    .sidebar('attach events', '#info-profile')
    .sidebar('setting', 'transition', 'overlay')
    .sidebar('setting', 'dimPage', false);

$('#sendMessage').click(function () {
    var message = $('#textBox').val().trim();
    if(message){
        axios.post('/message/new',{
            hash: hash,
            message: message
        })
        .then(function (response) {
            if(response.data.success){
                console.log(response);
                iTalk(message);
            } else if(response.data.errors.type == 'authentication'){
                alert(response.data.errors.message);
                location.href = '/home';
            }

        })
        .catch(function (error) {
            console.log(error);
        });

    }
    $('#textBox').val('');
});

$('#textBox').keypress(function (e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    if (code == 13){
        $('#sendMessage').click();
    } else {
        window.Echo.join('chat.' + hash).whisper('typing', {});
    }
});

$('.invitation.modal').modal({
    onHidden: function () {
        console.log('hide');
        $('#weather-score').text('');
        $('#traffic-score').text('');
        $('#loader-item').hide();
        $('#invitation-date input').val('');
        // $('#check-btn').removeClass('disabled');
    },
    onShow: function () {
        console.log('show');
        if(marker){
            marker.setMap(null);
        }
        $('#location').val('');


    },
    onApprove: function () {
        console.log('approved');
        console.log(point);

        if( !point.address || !$('#invitation-date input').val()){
            console.log('no');
            return;
        }

        axios.post('/invitation/new',{
            hash: hash,
            data: {
                address: point.address?point.address:'',
                time: $('#invitation-date input').val(),
                weather_score: $('#weather-score').text()?$('#weather-score').text():0,
                traffic_score: $('#traffic-score').text()?$('#traffic-score').text():0,
            }
        })
        .then(function (response) {
            if(response.data.success){
                console.log(response);
                var source  = document.getElementById("invitation-message-template").innerHTML;
                var html = Handlebars.compile(source)(_.extend(response.data, {from_me: true}));
                console.log(html);
                $('.chat-messages').append(html);
                toBottom();
            }
        })
        .catch(function (error) {
            console.log(error);
        });
    },
    onDeny: function () {
        console.log('deny');
    }
})
.modal('setting', 'transition', 'vertical flip');

$(document).on('click', '.approve-invitation-btn', function () {
    console.log('attempt to approve');
    var id = $(this).data('id');

    var msgBlock = $(this).parent().parent().parent();

    axios.post('/invitation/approve',{
        invitation_id: id
    })
    .then(function (response) {
        if(response.data.success){
            msgBlock.remove();
            swal(
                'Nice!',
                '很期待吧!',
                'success'
            );
        }
    })
    .catch(function (error) {
        console.log(error);
    });
});

$(document).on('click', '.deny-invitation-btn', function () {
    $(this).parent().parent().parent().remove();
});


$('#new-invitation-btn').click(function () {
    $('.invitation.modal').modal('show');
});

$('#end-btn').click(function () {
    axios.post('/match/' + hash + '/destroy', {})
        .then(function (response) {
            console.log(response);
            disableChat();
        })
        .catch(function (error) {
            console.log(error);
        });
});

var papers;

$('#invitation-date').calendar({
    startMode: 'year',
    monthFirst: true,
    formatter: {
        date: function (date, settings) {
            if (!date) return '';
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return year + '-' + month + '-' + day;
        }
    },
    onHidden: function () {

        $('#invitation-date').calendar('refresh');
        console.log('on calender close');
        // bind date to vue teaching since data
        var date = $('#invitation-date input').val();

        if (date) {
            // a date is chosen
            if(point){
                $('#loader-item').show();
                // $('#check-btn').addClass('disabled');

                axios.post('/invitation/calculate',{
                    lat: point.latitude,
                    lng: point.longitude
                })
                .then(function (response) {
                    if(response.data.success){
                        console.log(response);
                        $('#loader-item').hide();
                        // $('#check-btn').removeClass('disabled');
                        $('#weather-score').text(response.data.data.weather);
                        $('#traffic-score').text(response.data.data.traffic);
                    } else {
                        $('#weather-score').text(Math.floor(Math.random()*20+30));
                        $('#traffic-score').text(Math.floor(Math.random()*20+30));
                    }
                })
                .catch(function (error) {
                    console.log(error);
                    $('#weather-score').text(Math.floor(Math.random()*20+30));
                    $('#traffic-score').text(Math.floor(Math.random()*20+30));
                });


            }

        } else {

        }
    }
});

var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 7,
    center: {lat: 23.6, lng: 120.8},
    mapTypeControl: false,
    panControl: false,
    zoomControl: false,
    streetViewControl: false
});

var autocomplete = new google.maps.places.Autocomplete(
    (document.getElementById('location')),
    {types: []}
);

var marker = null;
var point = {};

autocomplete.addListener('place_changed', function () {
    var place = autocomplete.getPlace();
    console.log(place);
    if (place.geometry) {
        map.panTo(place.geometry.location);
        map.setZoom(15);

        if(marker){
            marker.setMap(null);
        }
        marker = new google.maps.Marker({
            position: place.geometry.location,
            map: map,
            title: 'Hello World!'
        });

        // save location data
        point.latitude = place.geometry.location.lat();
        point.longitude = place.geometry.location.lng();
        point.address = document.getElementById('location').value;
    } else {
        document.getElementById('location').placeholder = 'Enter a city';
    }
});

function displayInvitation(event) {
    var data = JSON.parse(event.invitation.data);
    data.from_me = false;
    data.id = event.invitation.id;
    console.log(data);
    var source  = document.getElementById("invitation-message-template").innerHTML;
    var html = Handlebars.compile(source)(data);
    console.log(html);
    $('.chat-messages').append(html);
    toBottom();
}

function disableChat() {
    swal(
        '您已離開對話!',
        '失去的緣分不再重來...',
        'warning'
    ).then(function (result) {
        location.href = '/home';
    });
}

function iTalk(message) {
    var source  = document.getElementById("my-message-template").innerHTML;
    var html = Handlebars.compile(source)({message: message});
    $('.chat-messages').append(html);
    toBottom();
}

function youTalk(message) {
    var source  = document.getElementById("other-message-template").innerHTML;
    var html = Handlebars.compile(source)({message: message});
    $('.chat-messages').append(html);
    toBottom();
}

// scroll content to bottom(newest)
function toBottom() {
    $('#scroll-content')[0].scrollTop = $('#scroll-content')[0].scrollHeight;
}
