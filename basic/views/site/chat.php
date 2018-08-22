<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
<!-- 引入组件库 -->
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<div id="app">
    <el-container style="height: px; border: 1px solid #eee">
        <el-aside width="300px" style="background-color: rgb(238, 241, 246)">
            <el-menu>
                <p v-for="user in users">
                    {{ user.name }}
                </p>
            </el-menu>
        </el-aside>
        <el-container>
            <el-main style="text-align: left; font-size: 12px">
                <el-table :data="chatArr">
                    <el-body>
                        <el-table-column>
                            <template slot-scope="scope">
                                <span> {{ scope.row }} </span>
                            </template>
                        </el-table-column>
                    </el-body>
                </el-table>
            </el-main>
        </el-container>
    </el-container>
    <el-input v-if="!canChat" type="text" class="form-control" placeholder="填写聊天昵称" v-model="myName">
    </el-input>
    <el-input v-else
            type="textarea"
            :rows="2"
            placeholder="请输入内容"
            v-model="message">
    </el-input>
</div>



<style>
    .el-header, .el-footer {
        /*background-color: #B3C0D1;*/
        color: #333;
        text-align: center;
        line-height: 60px;
    }

    .el-aside {
        /*background-color: #D3DCE6;*/
        color: #333;
        text-align: center;
        line-height: 200px;
    }

    .el-main {
        /*background-color: #E9EEF3;*/
        color: #333;
        text-align: center;
        line-height: 160px;
    }
    .text {
        font-size: 14px;
    }

    .item {
        padding: 18px 0;
    }

    .box-card {
        width: 480px;
    }

    body > .el-container {
        margin-bottom: 40px;
    }

    .el-container:nth-child(5) .el-aside,
    .el-container:nth-child(6) .el-aside {
        line-height: 260px;
    }

    .el-container:nth-child(7) .el-aside {
        line-height: 320px;
    }
</style>
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
