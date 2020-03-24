/* 
  连接服务器

*/
const wsPort = 8011
const hostname = '127.0.0.1'
const ws = new WebSocket(`ws://${ hostname }:${ wsPort }`)

ws.onopen = () => {
    // 进入聊天室的提示
    ws.send('欢迎xxx来到xxx的直播间')
}

// 接收数据，然后将数据展示到界面上
ws.onmessage = (msg) => {
    const content = document.querySelector('#content')
    content.innerHTML += msg.data + '<br/>'
}

// 异常报出

// ws.onerror = ( 'error' ) => {
//   console.log( error )
// }


ws.onclose = () => {
    console.log('closed')
}