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
    <script type="text/javascript" src="/wechat/jssdk/config"></script>

    <script type="text/javascript" src="/build/dist/js/base.min.js"></script>
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
                    <a href="/" class="friend-btn"></a>
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
	// 分享默认设置
	__base.baseInit();
    __base.sectionChange("works");
</script>


</body>
</html>

