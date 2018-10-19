Vue.component('room', {
    props: ['id','title','contents'],
    data: function () {
        return {
            name: '',
            content: '',
            members: {},
            viewindex: 0,
            views: ['room'],
        }
    },
    methods: {
        send: function () {
            ms.send('message', this.content)
        }
    },
    created(){
        connect()
        
    },
    template:
        `<div class="room">
    <h1>Simple Chat</h1>
    <span>你的昵称</span>
    <input type="text" v-model="name">
    <br>
    <input type="text" v-model="content" id="msg">
    <button type="button" @click="send" id="send">send</button>
    <div id="content">
        <div v-for="v in contents">
            {{v}}
        </div>
    </div>
</div>`,

})