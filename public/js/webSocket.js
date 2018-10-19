
function connect(){
    ms = new MyWebSocket({
        url: "ws://127.0.0.1:2347?name=jery",
        onopen: onopen,
        onclose: onclose,
        onmessage: onmessage

    })
}

function onopen(e) {
    console.log('连接成功1', e);
}
function onclose(e) {
    console.log('断开连接', e);
}
function onmessage(data) {
    console.log('onmessage->data', data);
    var el = document.getElementById(content);
    // el.append(`${data.uid}说${data.msg}`)
    app.roomData.contents.push(`${data.data.uid}说${data.data.msg}`)
}