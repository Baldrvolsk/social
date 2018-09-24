$(document).ready(function(){
    var inProgress = false;
    var startFrom = 40;
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !inProgress) {
            checkZero();
            $.ajax({
                url: '/' + controller + '/get_lazy',
                method: 'POST',
                data: {"startFrom" : startFrom},
                beforeSend: function() {
                    inProgress = true;
                }
            }).done(function(json){
                var dataArr = jQuery.parseJSON(json);
                if (dataArr.length > 0) {
                    $.each(dataArr, function(index, data){

                        /* Отбираем по идентификатору блок со статьями и дозаполняем его новыми данными */
                        $(".content-list").append(data);
                        var elem = $(".content-list .content-item:last-child");
                        switch (controller) {
                            case 'people':
                                if (peopleOnline && elem.data('online') !== 1) {
                                    elem.hide();
                                }
                                break;
                        }
                    });
                    inProgress = false;
                    startFrom += 30;
                }
                checkEven();
            });
        }
    });
});