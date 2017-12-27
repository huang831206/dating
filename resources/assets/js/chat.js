// var io = require('socket.io-client');
// // 建立 socket.io 的連線
// var notification = io.connect('http://dating.my:3000');
// // 當從 socket.io server 收到 notification 時將訊息印在 console 上
// notification.on('message', function(message) {
//     console.log(message);
// });

import Echo from "laravel-echo"

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
    });

$(document).ready(function () {
    // CSR messages
});

$('#sendMessage').click(function () {
    var message = $('#textBox').val().trim();
    if(message){
        axios.post('/newChatMessage',{
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
