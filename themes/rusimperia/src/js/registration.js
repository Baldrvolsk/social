function regUser(e) {
    "use strict";
    // Собираем данные формы
    var formData = new FormData();

    formData.append("email", $("#inputEmail").val());
    formData.append("login", $("#inputLogin").val());
    formData.append("first_name", $("#inputFName").val());
    formData.append("last_name", $("#inputLName").val());
    formData.append("google_photo", $("#avatar").val());
    formData.append("country", $("#inputCountry").val());
    formData.append("gender", $("#gender :selected").val());
    formData.append("rules", $("#rules").prop('checked'));

    //Begin the ajax call
    $.ajax({
        url: "/auth/register",
        type: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,

        beforeSend: function() {
            $(e).addClass("btn-primary").html('<i class="fas fa-spinner fa-spin"></i>');
        },

        success: function (json) {
            $(e).removeClass("btn-primary").html('Зарегистрироваться');
            if (json.status == "OK") { //ошибок не было
                $('.modal-header').css({'display':'none'});
                $('.modal-footer').css({'display':'none'});
                openModal({
                    'body': '<span class="text-success">'+json.message+'</span>',
                    'footer': '<s'+'cript>'+
                        'setTimeout(function(){location.reload()}, 3e3)'+
                        '</s'+'cript>'
                }, false);
                $('#status').addClass("bg-success")
                    .removeClass("bg-danger bg-info bg-warning")
                    .html('').css({'margin-bottom':'10px','padding':'10px 0'});

            } else { //ошибки были, показываем их описание
                $('#status').addClass("bg-danger")
                    .removeClass("bg-success bg-info bg-warning")
                    .html(json.message)
                    .css({'margin-bottom':'10px','padding':'10px 0'});

                $('#email_err').html(json.email_err);
                $('#login_err').html(json.login_err);
                $('#f_name_err').html(json.f_name_err);
                $('#l_name_err').html(json.l_name_err);
                $('#photo_err').html(json.photo_err);
                $('#country_err').html(json.country_err);
                $('#gender_err').html(json.gender_err);
                $('#rules_err').html(json.rules_err);
                //$('#privacy_err').html(json.privacy_err);
            }
        },

        error: function (r) {
            $('#status').addClass("bg-warning")
                .removeClass("bg-danger bg-info bg-success")
                .html('<span class="text-danger">Что-то пошло не так. Попробуйте позже.</span>')
                .css({'margin-bottom':'10px','padding':'10px 0'});
        }
    });
}
