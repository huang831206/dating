var areas = [
    {value: 1, name: '教育學門'},
    {value: 2, name: '藝術學門'},
    {value: 3, name: '人文學門'},
    {value: 4, name: '設計學門'},
    {value: 5, name: '社會及行為科學學門'},
    {value: 6, name: '傳播學門'},
    {value: 7, name: '商業及管理學門'},
    {value: 8, name: '法律學門'},
    {value: 9, name: '生命科學學門'},
    {value: 10, name: '自然科學學門'},
    {value: 11, name: '數學及統計學門'},
    {value: 12, name: '電算機學門'},
    {value: 13, name: '工程學門'},
    {value: 14, name: '建築及都市規劃學門'},
    {value: 15, name: '農業科學學門'},
    {value: 16, name: '獸醫學門'},
    {value: 17, name: '醫藥衛生學門'},
    {value: 18, name: '社會服務學門'},
    {value: 19, name: '民生學門'},
    {value: 20, name: '運輸服務學門'},
    {value: 21, name: '環境保護學門'}
];

var cities = [
    {value: 1, name: '臺北市'},
    {value: 2, name: '新北市'},
    {value: 3, name: '桃園市'},
    {value: 4, name: '臺中市'},
    {value: 5, name: '臺南市'},
    {value: 6, name: '高雄市'},
    {value: 7, name: '基隆市'},
    {value: 8, name: '新竹市'},
    {value: 9, name: '嘉義市'},
    {value: 10, name: '新竹縣'},
    {value: 11, name: '苗栗縣'},
    {value: 12, name: '彰化縣'},
    {value: 13, name: '南投縣'},
    {value: 14, name: '雲林縣'},
    {value: 15, name: '嘉義縣'},
    {value: 16, name: '屏東縣'},
    {value: 17, name: '宜蘭縣'},
    {value: 18, name: '花蓮縣'},
    {value: 19, name: '臺東縣'},
    {value: 20, name: '澎湖縣'},
    {value: 21, name: '金門縣'},
    {value: 22, name: '連江縣'}
];

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});

var userList;
var newHere = true;

$('.ui.dropdown.gender').dropdown();

// set form dropdown options of research-area
$('.ui.dropdown.research-area').dropdown({
    values: areas
});

// set form dropdown options of cities
$('.ui.dropdown.location').dropdown({
    values: cities
});

$('#do-search').click(function () {

    $('#search-loader').addClass('active');
    // connect to pair channel
    window.Echo.join('pair')
        .here(function (users) {
            // join the channel successfully
            console.log(users);

            if(newHere){
                newHere = false;
                userList = users;

                if(users.length != 1){

                    var pickedUser = _.sample(_.filter(userList, function (u) {
                        return u.user.id != uid;
                    }));

                    axios.post('/match/create',{
                            user_a_id: uid,
                            user_b_id: pickedUser.user.id
                        })
                        .then(function (response) {
                            console.log(response);
                            if (response.data.success) {
                                window.Echo.join('pair').whisper('chosen', {id: pickedUser.user.id, hash: response.data.hash});
                                setTimeout(function(){
                                    location.href = '/chat/' + response.data.hash;
                                }, 7000);

                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                }
            }


        })
        .joining(function (user) {
            console.log('he/she just joined the room');
            console.log(user);

        })
        .leaving(function (user) {
            // console.log('he/she is afk');
            // console.log(user);
        })
        .listenForWhisper('chosen', function (event) {
            console.log('chosen');
            console.log(event);
            if (event.id == uid) {
                setTimeout(function(){
                    location.href = '/chat/' + event.hash;
                }, 7000);
            }
        })
        .listen('UserWaiting', function (event) {

        });

});
