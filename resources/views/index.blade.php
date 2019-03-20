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
				<?php foreach($aic_list as $k => $v){?>
                    <div class="item">
                        <div class="item-box  layer-photos-demo1 layer-photos-demo">
                            <h3><a href="/articles/post/<?php echo set_key_val($v['id']);?>.html"><?php echo $v['title'];?></a></h3>
                            <h5>发布于：<span><?php echo getNowTimeLength(strtotime($v['created_at']));?></span></h5>
                            <img src="<?php echo $v['img_url'];?>" alt="">
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="item-btn">
                {{ $aic_list->links('vendor.pagination.simple-default') }}
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
    <script src="/res/layui/layui.js"></script>
    <script>
        layui.config({
            base: '/res/static/js/'
        }).use('blog');
    </script>
    </body>
    </html>