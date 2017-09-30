<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>微云控后台管理</title>
    <!-- layui.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/layui/css/layui.css" rel="stylesheet" />
    <!-- font-awesome.css -->
    <link href="<?php echo ($resource); ?>admin/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- animate.css -->
    <link href="<?php echo ($resource); ?>admin/css/animate.min.css" rel="stylesheet" />
    <!-- 本页样式 -->
    <link href="<?php echo ($resource); ?>css/main.css" rel="stylesheet" />
    <link href="<?php echo ($resource); ?>css/index_style.css" rel="stylesheet" type="text/css">
    <!--<script type="text/javascript" src="<?php echo ($resource); ?>js/jquery-1.12.3.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <!--<script type="text/javascript" src="<?php echo ($resource); ?>js/main.js"></script>-->

    <link rel="stylesheet" href="<?php echo ($resource); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ($resource); ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.theme.default.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/treeTable/jquery.treetable.css">
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/component/zTree/css/zTreeStyle/zTreeStyle.css">
</head>
<body>
<div class="layui-body">
<div class="content-wrapper" style = "margin-left:1px ;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            配置列表
        </h1>
    </section>
    <div class="layui-field-box">
        <div id="dataContent" class="">
            <a href="<?php echo U('Navigation/addNavigation');?>" class="layui-btn ">添加配置</a>
            <a class="layui-btn" onclick="delAll('<?php echo U('Navigation/deleteNavigation');?>')">批量删除</a>
            <!--<a href="<?php echo U('Navigation/deleteNavigation');?>" class="layui-btn ">删除</a>-->
            <!--内容区域 ajax获取-->
            <table style="" class="layui-table" lay-even="">
                <thead>
                <tr class="tng">
                    <th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                    <th style="text-align: center;">配置ID</th>
                    <th style="text-align: center;">任务名称</th>
                    <th style="text-align: center;">配置参数</th>
                    <th style="text-align: center;">附带图片</th>
                    <th style="text-align: center;">操作</th>
                </tr>
                </thead>
                <tbody style="text-align: center;">
                <?php echo getnavigationgrouplist(0);?>
                <!--</volist>-->

                </tbody>
            </table>
            <div class="pagepadding">
        </div>
    </div>

    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Content Wrapper. Contains page content -->

<!-- /.box -->
<!--底部信息-->
<div class="layui-footer">
    <!--<p style="line-height:44px;text-align:center;">Copyright &copy; 2012-2016 微云控云控管理系统</p>-->
    <p style="line-height:44px;text-align:center;">tom工作室(QQ群:516472075)</p>
</div>
<!--个性化设置-->
<div class="individuation animated flipOutY layui-hide">
    <ul>
        <li><i class="fa fa-cog" style="padding-right:5px"></i>个性化</li>
    </ul>
    <div class="explain">
        <small>从这里进行系统设置和主题预览</small>
    </div>
    <div class="setting-title">设置</div>
    <div class="setting-item layui-form">
        <span>侧边导航</span>
        <input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>
    </div>
    <!--<div class="setting-item layui-form">-->
    <!--<span>管家提醒</span>-->
    <!--<input type="checkbox" lay-skin="switch" lay-filter="steward" lay-text="ON|OFF" checked>-->
    <!--</div>-->
    <div class="setting-title">主题</div>
    <div class="setting-item skin skin-default" data-skin="skin-default">
        <span>低调优雅</span>
    </div>
    <div class="setting-item skin skin-deepblue" data-skin="skin-deepblue">
        <span>蓝色梦幻</span>
    </div>
    <div class="setting-item skin skin-pink" data-skin="skin-pink">
        <span>姹紫嫣红</span>
    </div>
    <div class="setting-item skin skin-green" data-skin="skin-green">
        <span>一碧千里</span>
    </div>
</div>
</div>
<!-- layui.js -->

<script src="<?php echo ($resource); ?>admin/plugin/layui/layui.js"></script>
<script src="<?php echo ($resource); ?>js/script123.js"></script>
<!--<script src="<?php echo ($resource); ?>plugins/jQuery/jQuery-2.2.0.min.js"></script>-->

<!--<script src="<?php echo ($resource); ?>dist/js/app.min.js"></script>-->
<!--<script src="<?php echo ($resource); ?>bootstrap/js/bootstrap.min.js"></script>-->
<script type="text/javascript" src="/AdminResource/adminhome/component/treeTable/jquery.treetable.js"></script>
<script>
//    $(function () {
//        $("#example1").DataTable();
//        $('#example2').DataTable({
//            "paging": true,
//            "lengthChange": false,
//            "searching": false,
//            "ordering": true,
//            "info": true,
//            "autoWidth": false
//        });
//    });

//    $('.some_class').datetimepicker();

</script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    layui.config({
        base: '<?php echo ($resource); ?>admin/js/'
    }).use('main');
</script>
</body>
</html>
<script>
    function ishide(obj){
        var ishidden=$(obj).html();
        var nid =$(obj).next().val();
        if(ishidden =="是"){
            var ishides =1
        }
        else if(ishidden=="否"){
            var ishides = 0
        }
        $.ajax({
            url:"<?php echo U('Navigation/isHidden');?>",
            type:"post",
            dataType: "json",
            data:{'navid':nid ,'ishidden':ishides },
            async: "false",
            success:function(ishiddens){
                if(ishidden=="是"){
                    $(obj).html('否');
                    $(obj).css('color','red');
                }
                if(ishidden=="否"){
                    $(obj).html('是');
                    $(obj).css('color','#3c8dbc');

                }
            }

        })
    }
</script>