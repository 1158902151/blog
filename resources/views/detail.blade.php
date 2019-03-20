<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/static/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/res/layui/css/layui.css">
    <link rel="stylesheet" href="/res/static/css/mian.css">
</head>
<body class="lay-blog">
<div class="header">
    <ul class="layui-nav layui-bg-cyan">
        <li class="layui-nav-item"><a href="javascript:void(0);">云辉印象</a></li>
        <li class="layui-nav-item layui-this"><a href="">首页</a></li>
    </ul>
</div>
<div class="container-wrap">
    <div class="container container-message container-details">
        <div class="contar-wrap">
            <div class="item">
                <div class="item-box  layer-photos-demo1 layer-photos-demo">
                    <h3><a href="javascript:void(0);"><?php echo $detail->title;?></a></h3>
                    <h5>发布于：<span><?php echo getNowTimeLength(strtotime($detail->created_at));?></span></h5>
                    <p><?php echo $detail->content;?></p>
                    <img src="<?php echo $detail->img_url;?>" alt="">
                    <div class="count layui-clear">
                        <span class="pull-left">阅读 <em><?php echo $detail->view;?></em></span>
                    </div>
                </div>
            </div>
            <a name="comment"> </a>
            <div class="comt layui-clear">
                {{--<a href="javascript:;" class="pull-left">评论</a>--}}
                {{--<a href="comment.html" class="pull-right">写评论</a>--}}
            </div>
            {{--<div id="LAY-msg-box">--}}
                {{--<div class="info-item">--}}
                    {{--<img class="info-img" src="/res/static/images/info-img.png" alt="">--}}
                    {{--<div class="info-text">--}}
                        {{--<p class="title count">--}}
                            {{--<span class="name">一片空白</span>--}}
                            {{--<span class="info-img like"><i class="layui-icon layui-icon-praise"></i>5.8万</span>--}}
                        {{--</p>--}}
                        {{--<p class="info-intr">父爱如山，不善表达。回想十多年前，总记得父亲有个宽厚的肩膀，小小的自己跨坐在上面，越过人山人海去看更广阔的天空，那个时候期望自己有一双翅膀，能够像鸟儿一样飞得高，看得远。虽然父亲有时会和自己开玩笑，但在做错事的时候会受到严厉的训斥。父亲有双粗糙的大手掌。</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="info-item">--}}
                    {{--<img class="info-img" src="/res/static/images/info-img.png" alt="">--}}
                    {{--<div class="info-text">--}}
                        {{--<p class="title count">--}}
                            {{--<span class="name">一片空白</span>--}}
                            {{--<span class="info-img like"><i class="layui-icon layui-icon-praise"></i>5.8万</span>--}}
                        {{--</p>--}}
                        {{--<p class="info-intr">父爱如山，不善表达。回想十多年前，总记得父亲有个宽厚的肩膀，小小的自己跨坐在上面，越过人山人海去看更广阔的天空，那个时候期望自己有一双翅膀，能够像鸟儿一样飞得高，看得远。虽然父亲有时会和自己开玩笑，但在做错事的时候会受到严厉的训斥。父亲有双粗糙的大手掌。</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
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
<script type="text/javascript" src="{{ URL::asset('static/bootstrap/bootstrap.min.js') }}"></script>
<script src="/res/layui/layui.js"></script>

<script>
    layui.config({
        base: '/res/static/js/'
    }).use('blog');
</script>
</body>
</html>