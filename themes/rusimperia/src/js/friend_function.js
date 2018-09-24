var peopleOnline;
peopleOnline = false;

$(document).ready(function(){
    if($("div").is(".content-list")) {
        checkEven();
    }
});

function filterPeople(e, filter) {
    peopleOnline = filter.status === 'online';
    $(e).addClass('sub-nav-item-selected');
    $(e).siblings().removeClass('sub-nav-item-selected');
    checkZero();
    var collectionItem = $('.content-list .content-item');
    collectionItem.each(function (i, elem) {
        if (filter.status === 'all') {
            $(elem).removeClass('item-hidden');
        } else if (filter.status === 'online' && !$(this).data("online")) {
            $(elem).addClass('item-hidden');
        }
    });
    checkEven();
}

function filterFriend(e, filter) {
    peopleOnline = filter.status === 'online';
    $(e).addClass('sub-nav-item-selected');
    $(e).siblings().removeClass('sub-nav-item-selected');
    var list = $('.content-list');
    var lastFilter = list.data('nav');
    list.data('nav', filter.status);
    checkZero();
    switch (filter.status) {
        case 'all':
        case 'online':
            if (lastFilter !== 'online' && lastFilter !== 'all') {
                getFriendList('friend');
            }
            var collectionItem = $('.content-list .content-item');
            collectionItem.each(function (i, elem) {
                if (filter.status === 'all') {
                    $(elem).removeClass('item-hidden');
                } else if (filter.status === 'online' && !$(this).data("online")) {
                    $(elem).addClass('item-hidden');
                }
            });
            break;
        case 'confirm':
            getFriendList('confirm');
            break;
        case 'request':
            getFriendList('request');
            break;
        case 'blacklist':
            getFriendList('blacklist');
            break;
    }
    checkEven();
}

function getFriendList(type) {
    var list = $('.content-list');
    $.ajax({
        url: "/friend/get_friend_list",
        type: "POST",
        data: {type: type},
        dataType: "json",
        success: function (json) {
            if (json.status === "OK") { //ошибок не было
                list.html(json.html);
            } else { //ошибки были, показываем их описание
                $('.modal-header').css({'display': 'none'});
                $('.modal-footer').css({'display': 'none'});
                openModal({
                    'body': '<span class="text-danger">' + json.message + '</span>',
                    'footer': '<s' + 'cript>' +
                        'setTimeout(function(){closeModal()}, 2e3)' +
                        '</s' + 'cript>'
                }, false);
            }
        },
        error: function () {
            $('.modal-header').css({'display': 'none'});
            $('.modal-footer').css({'display': 'none'});
            openModal({
                'body': '<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>',
                'footer': '<s' + 'cript>' +
                    'setTimeout(function(){closeModal()}, 2e3)' +
                    '</s' + 'cript>'
            }, false);
        }
    });
}

function checkEven() {
    var list = $('.content-list');
    if (list.find('li:not(.item-hidden)').length % 2 === 1) {
        list.append($('<li class="content-item people-item" data-zero="true"></li>'));
    }
}

function checkZero() {
    var list = $('.content-list');
    var last = list.find('li[data-zero="true"]');
    if (list.find('li:not(.item-hidden)').length % 2 === 0 && last.data('zero')) {
        last.remove();
    }
}

/* Отправить запрос на добавление в друзья */
function addFriends(e, id) {
    changeStatus(e, id, 'request');
}

/* Подтвердить запрос на добавление в друзья */
function confirmFriends(e, id) {
    changeStatus(e, id, 'confirmed');
}

/* Удалить запрос на добавление в друзья */
function deleteRequest(e, id) {
    changeStatus(e, id, 'delete');
}

/* Добавить в черный список */
function addBlackList(e, id) {
    changeStatus(e, id, 'blacklist');
}

/* Оставить пользователя в подписчиках */
function addSubscriber(e, id) {
    changeStatus(e, id, 'subscriber');
}

/* Удалить из подписчиков */
function deleteSubscriber(e, id) {
    changeStatus(e, id, 'delete');
}

/* Удалить из черного списка */
function deleteBlackList(e, id) {
    changeStatus(e, id, 'delete');
}

/* Удалить из друзей */
function deleteFriends(e, id) {
    changeStatus(e, id, 'delete');
}

function changeStatus(e, id, status) {
    var oldHtml = $(e).html();
    $.ajax({
        url: "/friend/change_status",
        type: "POST",
        data: {id: id, status: status},
        dataType: "json",
        beforeSend: function () {
            $(e).html('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (json) {
            if (json.status === "OK") { //ошибок не было
                $('.modal-header').css({'display': 'none'});
                $('.modal-footer').css({'display': 'none'});
                openModal({
                    'body': '<span class="text-success">' + json.message + '</span>',
                    'footer': '<s' + 'cript>' +
                        'setTimeout(function(){closeModal()}, 2e3)' +
                        '</s' + 'cript>'
                }, false);
                $("#people-" + id).html(json.html);
            } else { //ошибки были, показываем их описание
                $('.modal-header').css({'display': 'none'});
                $('.modal-footer').css({'display': 'none'});
                openModal({
                    'body': '<span class="text-danger">' + json.message + '</span>',
                    'footer': '<s' + 'cript>' +
                        'setTimeout(function(){closeModal()}, 2e3)' +
                        '</s' + 'cript>'
                }, false);
                $(e).html(oldHtml);
            }
        },
        error: function () {
            $('.modal-header').css({'display': 'none'});
            $('.modal-footer').css({'display': 'none'});
            openModal({
                'body': '<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>',
                'footer': '<s' + 'cript>' +
                    'setTimeout(function(){closeModal()}, 2e3)' +
                    '</s' + 'cript>'
            }, false);
            $(e).html(oldHtml);
        }
    });
}

