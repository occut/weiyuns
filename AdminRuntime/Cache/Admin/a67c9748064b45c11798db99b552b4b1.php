<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>微云控后台管理系统</title>
    <link rel='Shortcut Icon' type='image/x-icon' href='/AdminResource/adminhome/images//windows.ico'>
    <script type="text/javascript" src="/AdminResource/adminhome/js//jquery-2.2.4.min.js"></script>
    <link href="/AdminResource/adminhome/css//animate.css" rel="stylesheet">
    <script type="text/javascript" src="/AdminResource/adminhome/component//layer-v3.0.3/layer/layer.js"></script>
    <link rel="stylesheet" href="/AdminResource/adminhome/component//font-awesome-4.7.0/css/font-awesome.min.css">
    <link href="/AdminResource/adminhome/css//default.css" rel="stylesheet">
    <script type="text/javascript" src="/AdminResource/adminhome/js//win10.js"></script>
    <style>
        * {
            font-family: "Microsoft YaHei", 微软雅黑, "MicrosoftJhengHei", 华文细黑, STHeiti, MingLiu
        }
        /*磁贴自定义样式*/
        .win10-block-content-text {
            line-height: 44px;
            text-align: center;
            font-size: 16px;
        }
    </style>
    <script>
        Win10.onReady(function () {

            //设置壁纸
            Win10.setBgUrl({
                main:"<?php echo ($res); ?>",
                mobile:'/AdminResource/adminhome/images//wallpapers/mobile.jpg',
            });

            Win10.setAnimated([
                'animated flip',
                'animated bounceIn',
            ], 0.01);
            setTimeout(function () {
                Win10.newMsg('推荐全屏', '按下F11全屏以达到最佳视觉效果(点击进入)',function () {
                    Win10.enableFullScreen();
                })
            }, 1500);
        })
    </script>
</head>
<body>
<div id="win10">
    <div class="desktop">
        <div id="win10-shortcuts" class="shortcuts-hidden">
            <!--$resources-->
            <?php if(is_array($resources)): $i = 0; $__LIST__ = $resources;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="shortcut" onclick="Win10.openUrl('/admin.php/<?php echo ($vo['url']); ?>','<img class=\'icon\' src=\'/AdminResource/adminhome/images//icon/<?php echo ($vo['ico']); ?>\'/><?php echo ($vo['group_name']); ?>')">
                    <img class="icon" src="/AdminResource/adminhome/images//icon/<?php echo ($vo['ico']); ?>"/>
                    <div class="title"><?php echo ($vo["group_name"]); ?></div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
            <div class="item" onclick="Win10.openUrl('/admin.php/Admin/editAdmin/adminid/<?php echo session('adminId');?>','<img class=\'icon\' src=\'/AdminResource/adminhome/images//icon/<?php echo ($vo['ico']); ?>\'/><?php echo ($vo['group_name']); ?>')"><img class="icon" src="<?php echo session('header');?>"/><?php echo session('adminName');?></div>
            <div class="item" onclick="Win10.openUrl('/admin.php/Admin/setup/adminid/<?php echo session('adminId');?>','<img class=\'icon\' src=\'/AdminResource/adminhome/images//icon/equ_manage.png\'/>设置')"><i class="red icon fa fa-wrench fa-fw"></i><span>设置</span></div>
            <div class="item" onclick="Win10.aboutUs()"><i class="purple icon fa fa-info-circle fa-fw"></i>关于</div>
            <div class="item" onclick=" Win10.exit();"><i class="black icon fa fa-power-off fa-fw"></i>关闭</div>
        </div>
        <div class="blocks">
            <div class="menu_group">
                <div class="title">
                    应用示例
                </div>
                <input type="hidden" value="<?php echo ($address['result']['location']['lng']); ?>" id="lng">
                <input type="hidden" value="<?php echo ($address['result']['location']['lat']); ?>" id="lat">
                <div loc="1,1" size="6,3" class="block">
                    <div class="content" style="background: url('/AdminResource/adminhome/images//presentation/1.png');background-size: auto" onclick="Win10.openUrl('<?php echo U('Index/map');?>','<img class=\'icon\' src=\'/AdminResource/adminhome/images//icon/vpn.png\'/>腾讯地图')">
                        <div style="line-height:132px;text-align: center;" id="container" width="300px" height="300px">地图</div>
                    </div>
                </div>
            </div>
            <div class="menu_group">
                <div class="title">
                    常用场景
                </div>
            </div>
        </div>
        <div id="win10-menu-switcher"></div>
    </div>
    <div id="win10_command_center" class="hidden_right">
        <div class="title">
            <h4 style="float: left">消息中心 </h4>
            <span id="win10_btn_command_center_clean_all">全部清除</span>
        </div>
        <div class="msgs"></div>
    </div>
    <div id="win10_task_bar">
        <div id="win10_btn_group_left" class="btn_group">
            <div id="win10_btn_win" class="btn"><span class="fa fa-windows"></span></div>
            <div class="btn" id="win10-btn-browser"><span class="fa fa-internet-explorer"></span></div>
        </div>
        <div id="win10_btn_group_middle" class="btn_group"></div>
        <div id="win10_btn_group_right" class="btn_group">
            <div class="btn" id="win10_btn_time">
                <!--0:00<br/>-->
                <!--1993/8/13-->
            </div>
            <div class="btn" id="win10_btn_command"><span id="win10-msg-nof" class="fa fa-comment-o"></span></div>
            <div class="btn" id="win10_btn_show_desktop"></div>
        </div>
    </div>
</div>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script>

window.onload = function(){
    var lng=parseFloat(document.getElementById("lng").value);
    var lat=parseFloat(document.getElementById("lat").value);
//直接加载地图


    //初始化地图函数  自定义函数名init
    function init() {
        //定义map变量 调用 qq.maps.Map() 构造函数   获取地图显示容器
         var map = new qq.maps.Map(document.getElementById("container"), {
             center: new qq.maps.LatLng(lat,lng),      // 地图的中心地理坐标。
            zoom:8                                                 // 地图的中心地理坐标。
        });
    }

    //调用初始化函数地图
    init();
}

</script>
</body>
</html>