function openModal(content, clickOverlay) {
    // помещаем переданный контент в модальное окно
    if (content.header !== undefined) {
        $("#modal .modal-header").html(content.header);
    }
    if (content.footer !== undefined) {
        $("#modal .modal-footer").html(content.footer);
    }
    if (content.body !== undefined) {
        $("#modal .modal-body").html(content.body);
    }
    // отображаем оверлей
    $("#modal").parents(".overlay").addClass("open");
    // отображаем модальное окно
    setTimeout(function () {
        $("#modal").addClass("open");
    }, 350);
    // вешаем эвент клика на крестик залрытия оверлея
    $(".btn-close-modal").one('click', function () {
        closeModal();
    });
    // вешаем эвент клика на оверлей
    if (clickOverlay === undefined || clickOverlay) {
        $(".overlay.open").one('click', function () {
            closeModal();
        });
    }
}

function closeModal() {
    $("#modal").removeClass("open");
    $("#modal .modal-header").html('');
    $("#modal .modal-footer").html('');
    $("#modal .modal-body").html('');
    setTimeout(function () {
        $("#modal").parents(".overlay").removeClass("open");
    }, 350);
}

//TODO: тестовая кнопка в дебаг режиме
$(".test-open-modal").on('click', function () {
    openModal({
            'header': 'Тестовый хидер модали',
            'footer': 'тестовый футер модали',
            'body': 'тестовый контент модали'
    });
});