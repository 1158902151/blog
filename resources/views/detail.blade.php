<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/static/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/res/layui/css/layui.css">
    <link rel="stylesheet" href="/res/static/css/mian.css">
    <link rel="stylesheet" href="/edit/css/editormd.preview.css" />
</head>
<body class="lay-blog">
<div class="header">
    <ul class="layui-nav layui-bg-cyan">
        <li class="layui-nav-item"><a href="javascript:void(0);">云辉印象</a></li>
        <li class="layui-nav-item"><a href="/">首页</a></li>
        <li class="layui-nav-item"><a href="/swoole/chat">SWOOLE</a></li>
    </ul>
</div>
<div class="container-wrap">
    <div class="container container-message container-details">
        <div class="contar-wrap">
            <div class="item">
                <div class="item-box  layer-photos-demo1 layer-photos-demo">
                    <h3><a href="javascript:void(0);"><?php echo $detail->title;?></a></h3>
                    <h5>发布于：<span><?php echo getNowTimeLength(strtotime($detail->created_at));?></span></h5>
                    <div id="test-editormd">

                    </div>
                    <textarea id="content" cols="30" rows="10"  style="display:none;">
                        <?php echo $detail->content?>
                    </textarea>
                    <img src="<?php echo $detail->img_url;?>" alt="">
                    <div class="count layui-clear">
                        <span class="pull-left">阅读 <span id="view"><?php echo $detail->view;?></span></span>
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
        <span>&copy; 2018</span>
        <span><a href="http://www.layui.com" target="_blank">或许期待一次绽放</a></span>
        <span>MIT license</span>
    </p>
    <p><span>人生就是一场修行</span></p>
</div>
<script src="/js/jquery.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('static/bootstrap/bootstrap.min.js') }}"></script>
<script src="/res/layui/layui.js"></script>
<script type="text/javascript" src="{{ URL::asset('edit/editormd.js') }}"></script>
<script src="/edit/lib/marked.min.js"></script>
<script src="/edit/lib/prettify.min.js"></script>
<script src="/edit/lib/raphael.min.js"></script>
<script src="/edit/lib/underscore.min.js"></script>
<script src="/edit/lib/sequence-diagram.min.js"></script>
<script src="/edit/lib/flowchart.min.js"></script>
<script src="/edit/lib/jquery.flowchart.min.js"></script>
<script src="/edit/editormd.js"></script>

<script>
    layui.config({
        base: '/res/static/js/'
    }).use('blog');

    $("#test-editormd").html('<textarea id="appendTest"></textarea>');
    var content=$("#content").val();//获取需要转换的内容
    $("#appendTest").val(content);//将需要转换的内容加到转换后展示容器的textarea隐藏标签中
    //转换开始,第一个参数是上面的div的id
    editormd.markdownToHTML("test-editormd", {
        htmlDecode: "style,script,iframe", //可以过滤标签解码
        emoji: true,
        taskList:true,
        tex: true,               // 默认不解析
        flowChart:true,         // 默认不解析
        sequenceDiagram:true,  // 默认不解析
    });
    /***记录查看人数**/
    $(document).ready(function() {
        var id      = "<?php echo $detail->id;?>";
        $.post("/article/view",{id:id,'_token':'{{csrf_token()}}'},function(res){
            var n= $("#view").text();
            var num = parseInt(n)+1;
            $("#view").text(num);
        })
    })

    /*****/
</script>
</body>
</html>