    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo config('web.web_site');?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <div class="container">
            <div class="contar-wrap">
                <h4 class="item-title">
                    <p><i class="layui-icon layui-icon-speaker"></i>公告：<span><?php echo config('web.gonggao');?></span></p>
                </h4>
                <div class="item">
                    <div class="item-box  layer-photos-demo1 layer-photos-demo">
                        <h3><a href="details.html">拥有诗意的心态,才能拥有诗意的生活</a></h3>
                        <h5>发布于：<span>刚刚</span></h5>
                        <p>父爱如山，不善表达。回想十多年前，总记得父亲有个宽厚的肩膀，小小的自己跨坐在上面，越过人山人海去看更广阔的天空，那个时候期望自己有一双翅膀，能够像鸟儿一样飞得高，看得远。虽然父亲有时会和自己开玩笑，但在做错事的时候会受到严厉的训斥。父亲有双粗糙的大手掌，手把手教我走路、骑车，却会在该放手的时刻果断地放开让自己去大胆尝试，那个时候期望快快长大，能够做自己想做的事，不用受父亲的“控制”。父亲是智慧树，他无所不知、无所不晓，虽然你有十万个为什么，但是也难不倒他。</p>
                        <img src="/res/static/images/item.png" alt="">
                    </div>
                    <div class="comment count">
                        <a href="details.html#comment">评论</a>
                        <a href="javascript:;" class="like">点赞</a>
                    </div>
                </div>
            </div>
            <div class="item-btn">
                <button class="layui-btn layui-btn-normal">下一页</button>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>
            <span>&copy; 2018</span>
            <span><a href="http://www.layui.com" target="_blank">layui.com</a></span>
            <span>MIT license</span>
        </p>
        <p><span>人生就是一场修行</span></p>
    </div>
    <script src="/res/layui/layui.js"></script>
    <script>
        layui.config({
            base: '/res/static/js/'
        }).use('blog');
    </script>
    </body>
    </html>