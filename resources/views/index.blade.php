    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo config('web.web_site');?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/res/layui/css/layui.css">
        <link rel="stylesheet" href="/res/static/css/mian.css">
        {{--<link rel="stylesheet" href="/res/layui/css/modules/layer/default/layer.css">--}}
    </head>
    <body class="lay-blog">
    <div class="header">
        <ul class="layui-nav layui-bg-cyan">
            <li class="layui-nav-item"><a href="javascript:void(0);">云辉印象</a></li>
            <li class="layui-nav-item layui-this"><a href="/">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">实例</a>
                <dl class="layui-nav-child">
                    <dd><a href="/swoole/chat">swoole socket</a></dd>
                </dl>
            </li>
        </ul>
    </div>
    <div class="container-wrap">
        <div class="container">
            <div class="contar-wrap" id="ari-list">

            </div>
            <div style="display: none;" id="demo1"></div>
        </div>
    </div>
    <div class="footer">
        <p>
            <span>&copy; 2019</span>
            <span><a href="http://www.layui.com" target="_blank">或许期待一次绽放</a></span>
            <span>MIT license</span>
        </p>
    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/res/layui/layui.js"></script>
    {{--<script src="/res/layui/lay/modules/layer.js"></script>--}}
    <script>
        var ii = "";
        layui.config({
            base: '/res/static/js/'
        }).use('blog');
        $(".layui-nav-item").click(function(){
            $(".layui-nav-item").removeClass("layui-this");
            $(this).addClass("layui-this");
        })

        var  total = 0;
        $.ajax({
            url: "/article/count",
            async:false,
            type:"get",
            success: function(obj){
                total = obj.count; //取到数据总条数
            }
        });

        layui.use(['laypage', 'layer'], function(){
            var laypage = layui.laypage
                ,layer = layui.layer;
            laypage.render({
                elem: 'demo1'
                ,count: total //数据总数
                ,jump: function(obj){
                    ii = layer.load();
                    $.ajax({
                        url: "/article/lists",
                        type:"get",
                        data:{pageSize:10,page:obj.curr},
                        success: function(lists){
                            var html = "";
                            layui.each(lists.data, function(index, item){
                                html += `<div class="item">
                                            <div class="item-box  layer-photos-demo1 layer-photos-demo">
                                            <h3><a href="/articles/post/`+item.id+`.html">`+item.title+`</a></h3>
                                            <h5>发布于：<span>`+item.created_at+`</span></h5>
                                            <img src="`+item.img_url+`" alt="">
                                            </div>
                                        </div>`;
                            });
                            $("#ari-list").html(html);
                            $("#demo1").show();
                            layer.close(ii)
                        }
                    });
                }
            });
        });
    </script>
    </body>
    </html>