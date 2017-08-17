<!DOCTYPE HTML>
<html>
<head>
    <title>因为你，所以爱</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="format-detection" content="telephone=no">
    <!-- uc强制竖屏 -->
    <meta name="screen-orientation" content="landscape">
    <!-- QQ强制竖屏 -->
    <meta name="x5-orientation" content="landscape">

    <!-- <link rel="apple-touch-startup-image" href="/build/assets/img/bg1.png" />
 -->
    <!--禁用手机号码链接(for iPhone)-->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui" />
    <!--自适应设备宽度-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--控制全屏时顶部状态栏的外，默认白色-->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="Keywords" content="">
    <meta name="Description" content="...">
    
    <link rel="stylesheet" type="text/css" href="/build/dist/css/main.min.css">
    <script type="text/javascript" src="/build/dist/js/vendor.min.js"></script>
     <script type="text/javascript">
        document.write('<script type="text/javascript" src="/wechat/jssdk/config?v='+ Math.random() +'"><\/script>');
    </script>

    <script type="text/javascript" src="/build/dist/js/base.min.js"></script>

    <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?0bc1bde1ec10a60a065cdad3ad844f3d";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
    </script>

    <style type="text/css">
        #zuopin{
            position: relative;
        }
    
        #dreambox, #dreambox.inside{
            background: none;
        }
    </style>
</head>
<body>


<div id="dreambox">
    <div class="section" id="works">
        <div id="zuopin">
            <img src="<?php echo $list['pic'];?>" width="100%" />
            <div class="foot">
                <span class="btn">
                    <a href="/" class="friend-btn" onclick="_hmt.push(['_trackEvent', 'buttons', 'click', '我也要告白']);"></a>
                    <img src="/build/dist/img/friend-btn.png" width="100%" />
                </span>
            </div>
        </div>   
    </div>
    
<!-- 横屏代码 -->
<div id="orientLayer" class="mod-orient-layer">
    <div class="mod-orient-layer__content">
        <i class="icon mod-orient-layer__icon-orient"></i>
        <div class="mod-orient-layer__desc">为了更好的体验，请使用竖屏浏览<br><em>建议全程在wifi环境下观看</em></div>
    </div>
</div>


<script type="text/javascript">
    var shareSet = {
        "_title": '因为你，所以爱', //分享标题
        "_desc": "大胆向TA告白，为TA获取来自伯爵的惊喜",    // 分享朋友圈的描述
        "_desc_friend": "七夕告白不要怂，要从心",    // 分享好友的描述
        "_link": window.location.origin,    //分享的连接
        "_imgUrl": window.location.origin + "/build/dist/img/share.jpg",   //分享的图片
        "_shareAppMessageCallback": function(){
            _hmt.push(['_trackEvent', 'buttons', 'share', 'onMenuShareAppMessage(好友页面)']);
        },
        "_shareTimelineCallback": function(){
            _hmt.push(['_trackEvent', 'buttons', 'share', 'onMenuShareTimeline(好友页面)']);
        }
        //"_url": encodeURIComponent(window.location.href)//encodeURIComponent(window.location.href.split("#")[0]) //.replace('http%3A%2F%2F','')
    }

	// 分享默认设置
	__base.baseInit(shareSet);
    __base.sectionChange("works");
</script>


</body>
</html>

