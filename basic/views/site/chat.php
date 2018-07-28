<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<div class="container" id="app" style="height: 500px; font-size: 20px; margin-top: 20px;">
    <div class="row" style="width: 1100px; height: 300px;">
        <div class="col-lg-5">
            <span v-for="user in users">
                <p v-if="user" class="card-text">昵称：{{ user.name }}-- IP：{{ user.ip }}</p>
            </span>
        </div>
        <div class="col-lg-6 ml-2">
            <p v-for="cha in chatArr" class="card-text">{{ cha }}</p>
        </div>
    </div>
    <div v-if="canChat">
        <input type="text" class="form-control" v-model="message">
        <button class="btn btn-primary mr-3" @click="sendMsg">发送</button>
    </div>
    <div v-else>
        <div>
            <input type="text" class="form-control" placeholder="填写聊天昵称" v-model="myName">
        </div>
        <div>
            <button  @click="startChat" class="btn btn-primary m-3">开始聊天</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript">
    var app = new Vue({
        el: '#app',
        data: {
            message: '',
            chatArr: [],
            wg: null,
            myName: '',
            canChat: false,
            users: []
        },
        mounted: function () {
            const myApp = this;
            $('#app').bind('keyup', function(event) {
                if (event.keyCode == "13") {
                    //回车执行查询
                    if (myApp.canChat) {
                        myApp.sendMsg();
                    } else {
                        myApp.startChat();
                    }
                }
            });
        },
        methods: {
            startChat: function() {
                if (this.myName === '') {
                    alert('请先填写您的昵称');
                    return false;
                }
                this.wg = this.getWebSocket(this.myName);
            },
            getWebSocket: function(myName) {
                var ws = new WebSocket('ws://localhost:9502?name=' + myName);
                this.canChat = true;
                var myApp = this;
                ws.onopen = function(evt) {
                    console.log("Connection open ...");
                };
                ws.onmessage = function(evt) {
                    const info = JSON.parse(evt.data);
                    if (info.type === 'msg') {
                        console.log(info.data);
                        myApp.chatArr.push(info.data);
                    } else if (info.type === 'list') {
                        console.log(info.data);
                        myApp.users = info.data;
                    } else if (info.type === 'del') {
                        const index = myApp.users.indexOf(myApp.users.find(item => item.fd === info.data));
                        console.log(index);
                        myApp.users.splice(index, 1);
                    }
                };
                ws.onclose = function(evt) {
                  myApp.canChat = false;
                };
                return ws;
            },
            sendMsg: function() {
                if (this.message === '') {
                    alert('请填写聊天内容后发送');
                    return false;
                }
                this.wg.send(this.message);
                this.message = '';
            }
        }
    });
</script>
