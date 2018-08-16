var socket = new WebSocket("wss://89.223.88.108:8000");
socket.onopen = function() {
    console.log("Соединение установлено.");
};

socket.onclose = function(event) {
    if (event.wasClean) {
        console.log('Соединение закрыто чисто');
    } else {
        console.log('Обрыв соединения'); // например, "убит" процесс сервера
    }
    alert('Код: ' + event.code + ' причина: ' + event.reason);
};

socket.onmessage = function(event) {
    $.message.info({
        message:'Получены данные '+event.data,
        showClose: true,
        duration:1000
    })
    console.log("Получены данные " + event.data);
};

socket.onerror = function(error) {
    console.log("Ошибка " + error.message);
};
var timerId = setInterval(function() {
    socket.send("тик!");
}, 2000);