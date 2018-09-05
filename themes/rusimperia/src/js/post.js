var lang = $("html").prop('lang');
$(function() {

    var wbbOpt = {
        buttons: "bold,italic,underline,|,img,video,link,|,bullist,numlist,|,fontcolor,smilebox,|,justifyleft,justifycenter,justifyright,|,quote,removeFormat",
        lang: lang,
        smileList: [
            {title:CURLANG.sm1, img: '<img src="/assets/img/smiles/2.gif" class="sm">', bbcode:":)"},
            {title:CURLANG.sm1, img: '<img src="/assets/img/smiles/7.gif" class="sm">', bbcode:":D"},
            {title:CURLANG.sm8 ,img: '<img src="/assets/img/smiles/3.gif" class="sm">', bbcode:":("},
            {title:CURLANG.sm3, img: '<img src="/assets/img/smiles/4.gif" class="sm">', bbcode:";)"},
            {title:CURLANG.sm4, img: '<img src="/assets/img/smiles/25.gif" class="sm">', bbcode:":up:"},
            {title:CURLANG.sm5, img: '<img src="/assets/img/smiles/28.gif" class="sm">', bbcode:":down:"},
            {title:CURLANG.sm7, img: '<img src="/assets/img/smiles/17.gif" class="sm">', bbcode:":angry:"},
            {title:CURLANG.sm6, img: '<img src="/assets/img/smiles/9.gif" class="sm">', bbcode:":shock:"},
            {title:CURLANG.sm9, img: '<img src="/assets/img/smiles/20.gif" class="sm">', bbcode:":sick:"},
        ],
    };
    $("#postEditor").wysibb(wbbOpt);
});

function add_post() {
    //Collect our form data.
    var formData = new FormData();
    formData.append('type', $("[name='type']").val());
    formData.append('owner_id', $("[name='owner_id']").val());
    formData.append('add_id', $("[name='add_id']").val());
    formData.append('content', $("#postEditor").htmlcode());

    $.ajax({
        type: "POST",
        url: '/post/add',
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('#status').addClass("bg-info")
                .removeClass("bg-danger bg-success bg-warning")
                .html('<i class="fas fa-spinner fa-spin"></i>')
                .css({'margin-bottom':'10px', 'padding':'10px 0'});
        },

        success: function (json) {
            //ошибок не было
            if (json.status == "OK") {
                $('#status').addClass("bg-success")
                    .removeClass("bg-danger bg-info bg-warning")
                    .html(json.message+'<s'+'cript>' +
                        'setTimeout(function(){location.reload()}, 2e3)' +
                        '</s'+'cript>')
                    .css({'margin-bottom':'10px','padding':'10px 0'});

            }
            //ошибки были, показываем их описание
            else {
                var text = json.message + '<br>' + json.content_err;
                $('#status').addClass("bg-danger").removeClass("bg-success bg-info bg-warning")
                    .html(text).css({'margin-bottom':'10px','padding':'10px 0'});
            }
        },

        error: function (r) {
            $('#status').addClass("bg-warning").removeClass("bg-danger bg-info bg-success")
                        .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                        .css({'margin-bottom':'10px','padding':'10px 0'});
        }
    });
}