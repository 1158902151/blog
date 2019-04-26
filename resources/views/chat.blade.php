<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/res/layui/css/layui.css">
    <link rel="stylesheet" href="/res/static/css/mian.css">
</head>
<body class="lay-blog">
<div class="header">
    <ul class="layui-nav layui-bg-cyan">
        <li class="layui-nav-item"><a href="javascript:void(0);">云辉印象</a></li>
        <li class="layui-nav-item"><a href="/">首页</a></li>
        <li class="layui-nav-item">
            <a href="javascript:;">实战</a>
            <dl class="layui-nav-child">
                <dd><a href="/swoole/chat">swoole socket</a></dd>
                <dd><a href="">消息队列</a></dd>
                <dd><a href="">redis订阅</a></dd>
            </dl>
        </li>
    </ul>
</div>
<div class="container-wrap">
    <div class="container container-message container-details">
        <div class="contar-wrap">
            <div class="item">
                <div class="item-box  layer-photos-demo1 layer-photos-demo">
                    <div>
                        <div style="width: 600px;height: 500px;background-color: #5FB878">
                            <div id="msgArea" style="width:100%;height: 100%;text-align:start;resize: none;font-size: 16px;overflow-y: scroll"></div>
                        </div>
                        <div style="width: 710px;height: 200px;margin-left: -110px;">
                            <div class="layui-form-item layui-form-text">
                                <div class="layui-input-block">
                                    <textarea id="userMsg" name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
                                </div>
                            </div>
                            <button style="float: right;" type="button"  class="layui-btn layui-btn-sm" onclick="sendMsg()">发送</button>
                        </div>
                    </div>
                </div>
            </div>
            <a name="comment"> </a>
            <div class="comt layui-clear">

            </div>

        </div>
    </div>
</div>
<div class="footer">
    <p>
        <span>&copy; 2019</span>
        <span><a href="http://www.layui.com" target="_blank">或许期待一次绽放</a></span>
        <span>MIT license</span>
    </p>
</div>
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('static/bootstrap/bootstrap.min.js') }}"></script>
<script src="/res/layui/layui.js"></script>

<script>
    layui.config({
        base: '/res/static/js/'
    }).use('blog');

    var ws;
    $(function(){
        link();
    })
    function link () {
        ws = new WebSocket("ws://39.107.122.217:9501");//连接服务器
        ws.onopen = function(event){
            var msg = "<p>【欢迎您进入房间】</p>";
            $("#msgArea").append(msg);
        };
        ws.onmessage = function (event) {
            var msg = "<p>"+event.data+"</br></p>";
            $("#msgArea").append(msg);
        }
        ws.onclose = function(event){alert("已经与服务器断开连接\r\n当前连接状态："+this.readyState);};

        ws.onerror = function(event){alert("WebSocket异常！");};
    }

    function sendMsg(){
        var msg = $("#userMsg").val();
        if(msg === ""){
            alert("请输入内容");
            return false;
        }
        ws.send(msg);
        $("#msgArea").append("【我】"+msg);
    }
</script>
</body>
</html>