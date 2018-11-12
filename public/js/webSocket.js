
function connect(){
    ms = new MyWebSocket({
        url: "ws://192.168.13.89:2347",
        onopen: onopen,
        onclose: onclose,
        onmessage: onmessage

    })
}

function onopen(e) {
    console.log('服务器连接成功', e);
    ms.send('login',{
        uname:app.uname,
        uid:app.uid
    })
}
function onclose(e) {
    console.log('断开连接', e);
}
function onmessage(e) {
    // e 为 e.data ;
    let action = e.action;
    let data = e.data;
    console.log('ACTION->',action);
    
    console.log('onmessage->data',data);
    // var el = document.getElementById(content);
    switch (action) {
        case 'userConnect':
            app.roomData.contents.push(`${data.uname}加入聊天`)
            app.roomData.clients = data.clients_list
            break;
        case 'userClose':
            app.roomData.contents.push(`${data.uname}离开聊天`)
            app.roomData.clients = data.clients_list
            break;
        case 'all':
            app.roomData.contents.push(`${data.uname} 对大家说：${data.msg}`)
            break;
        case 'to':
            app.roomData.contents.push(`${data.uname} 私聊你说：${data.msg}`)
            break;
    
        default:
            break;
    }
    // console.log('data->',data);
    
    // el.append(`${data.uid}说${data.msg}`)
    
}