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

var profile;

// diff for human
Handlebars.registerHelper('ago', function(time) {
    return moment(time).fromNow();
});
// get city name by id
Handlebars.registerHelper('city', function(city_id) {
    return cities[city_id-1].name;
});
// get area name by id
Handlebars.registerHelper('area', function(area_id) {
    return areas[area_id-1].name;
});

Handlebars.registerPartial('my-message', document.getElementById("my-message-template").innerHTML);
Handlebars.registerPartial('other-message', document.getElementById("other-message-template").innerHTML);

// close hint
$('.message .close').on('click', function() {
    $(this)
        .closest('.message')
        .transition('fade');
});

$('.help.circle.icon').popup();

$('.ui.dropdown.gender').dropdown();

// set form dropdown options of research-area
$('.ui.dropdown.research-area').dropdown({
    values: areas
});

// set form dropdown options of cities
$('.ui.dropdown.location').dropdown({
    values: cities
});

// setup form validation rules
$('.ui.user-info.form').form({
    on: 'blur',
    onSuccess: function (e, fields) {
        e.preventDefault();
        console.log(fields);
        axios.post('/user/profile', fields)
            .then(function (response) {
                console.log(response);
                if (response.data.success) {
                    swal(
                        'Good job!',
                        'Now you cant start your chat!',
                        'success'
                    ).then(function (result) {
                        location.href = '/pair';
                    });
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    },
    fields: {
        gender: {
            identifier: 'gender',
            rules: [{
                type: 'empty',
                prompt: 'You must select your gender.'
            }]
        },
        area: {
            identifier: 'area',
            rules: [{
                type: 'empty',
                prompt: 'You must select your research area/field.'
            }]
        },
        location: {
            identifier: 'location',
            rules: [{
                type: 'empty',
                prompt: 'You must select a city.'
            }]
        },
        hobby: {
            identifier: 'hobby',
            rules: [{
                type: 'empty',
                prompt: 'You must input some hobbies.'
            }]
        },
        introduction: {
            identifier: 'introduction',
            rules: [{
                type: 'empty',
                prompt: 'Please talk about yourself.'
            }]
        }
    }
});

// setup left menu click action
$('.side-menu .item').click(function () {
    $('.side-menu .item').removeClass('active');
    $('.side-menu .item .label').removeClass('teal left pointing');
    $(this).addClass('active');
    $(this).find('.label').addClass('teal left pointing');

    var tabName = $(this).data('tab');
    $('.tab-content').hide()
    $('.tab-content[data-tab="' + tabName + '"]').show();
    resetProfileDefault();
});


// get profile data and render
axios.get('/user/profile')
    .then(function (response) {
        if (response.data.success) {
            if (response.data.is_profile_complete) {
                profile = response.data.profile;
                resetProfileDefault();
            }
        }
    })
    .catch(function (error) {
        console.log(error);
    });

// get matches data and render
axios.get('/match/all')
    .then(function (response) {
        if(response.data.success){
            var data = response.data.data;
            // console.log(data);
            // generate current matches data
            var source  = document.getElementById("match-card-template").innerHTML;
            var html = Handlebars.compile(source)(data);
            $('.ui.three.special.cards').append(html);

            // setup semantic ui
            $('.special.cards .image').dimmer({
                on: 'hover'
            });

            $('.ui.rating').rating({
                maxRating: 5
            }).rating('disable');

            // show modal for chat history
            $('.detail-history-btn').click(function () {
                // find hash of card(the match)
                var hash  = $(this).parents().eq(4).data('hash');
                var source = document.getElementById("chat-history-modal-template").innerHTML;
                var html = Handlebars.compile(source)({hash: hash});
                console.log(hash);
                // register modal for edit details
                $(html).modal({
                    onHidden: function () {
                        $(this).remove();
                    },
                    onShow: function () {

                    }
                })
                .modal('setting', 'transition', 'vertical flip')
                .modal('show');

                // get messages nad render
                axios.get('/match/' + hash + '/messages')
                    .then(function (response) {
                        if(response.data.success){
                            console.log(response.data.data);
                            var html = '';
                            if (_.isEmpty(response.data.data)) {
                                html = 'You two didn\'t even Chat!!';
                            } else {
                                console.log('start crafting message blocks');
                                _.each(response.data.data, function (msg) {
                                    if(msg.from_me){        // the message was sent from me
                                        var source = document.getElementById("my-message-template").innerHTML;
                                    } else {                // the message was not sent from me
                                        var source = document.getElementById("other-message-template").innerHTML;
                                    }
                                    html += Handlebars.compile(source)({message: msg.message});
                                });
                            }
                            $('.ui.modal .chat-messages').append(html);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        } else if(response.data.errors.type == 'authentication'){
            alert(response.data.errors.message);
            location.href = '/home';
        }

    })
    .catch(function (error) {
        console.log(error);
    });


// $('.side-menu .item')[1].click();

// render form value to default
function resetProfileDefault() {
    if( profile ) {
        $('.ui.user-info.form').form('set values', {
            'gender': profile.gender,
            'hobby': profile.hobby,
            'area': profile.research_area_id,
            'location': profile.location_id,
            'introduction': profile.introduction
        });
    }
}
