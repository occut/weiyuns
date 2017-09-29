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
<!--主体内容-->
<div class="layui-body">
    <div class="content-wrapper" style = "margin-left:1px ;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                任务管理列表
            </h1>
        </section>

        <div class="layui-field-box">
            <div id="dataContent" class="">
                <!--内容区域 ajax获取-->
                <div class="box-header">
                    <a href="<?php echo U('Tasks/taskscreate');?>" class="layui-btn ">添加任务</a>
                   <h3 class="box-title layui-btn"><button class="btn layui-btn " onclick="delAll('<?php echo U('Tasks/deletesTasks');?>')">批量删除</button></h3>
                    <form class="layui-form"  style="float:right;width:350px;" action="<?php echo U('Tasks/listTasks');?>">
                    <input style="float:left;width:200px;" type="text" name="title" required  lay-verify="required" placeholder="请输入任务名称或关键字" autocomplete="off" class="layui-input">
                    <button style="float:right;width:100px;margin-right:20px;" class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
                    </form>
                   <!--  <div style="margin:10px 10px;">
                        使用率：

                        <a style="color: <?php if((80 < $rate)): ?>red<?php else: ?> black<?php endif; ?>;"><?php echo ($rate); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php if((80 < $rate)): ?>请添加设备<?php endif; ?></a>
                    </div> -->
                <table style="" class="layui-table" lay-even="">
                    <thead>
                    <tr class="tng" >
                        <th style = "width:5%;text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                        <!--<th style = "width:5%;text-align: center;"><input type="checkbox" id="dellAll" value=""></th>-->
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">任务名称</th>
                        <th style="text-align: center;">分组名</th>
                        <!-- <th style="text-align: center;">网站地址</th> -->
                        <th style="text-align: center;">经纬度</th>
                        <th style="text-align: center;">下单量</th>
                        <th style="text-align: center;">地址</th>
                        <!-- <th style="text-align: center;">设备</th> -->
                        <!-- <th style="text-align: center;">开始时间</th> -->
                        <!-- <th style="text-align: center;">剩余时间</th> -->
                        <!-- <th style="text-align: center;">昨天/今天</th> -->
                        <th style="text-align: center;">总量/完成</th>
                        <!-- <th style="text-align: center;">任务状态</th> -->
                        <th style="text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($tasks)): $i = 0; $__LIST__ = $tasks;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                            <td style="text-align: center;"><input type="checkbox" id="<?php echo ($vo["time_id"]); ?>" value="<?php echo ($vo["time_id"]); ?>" name="delAll"></td>
                            <td style="text-align: center;"><span><?php echo ($vo["time_id"]); ?></span></td>
                            <td style="text-align: center;"><span><?php echo ($vo["time_title"]); ?></span></td>
                            <td style="text-align: center;"><span><?php echo ($vo["group_name"]); ?></span></td>
                           <!--  <td style="text-align: center;"><span><?php echo (subtext($vo["time_url"],20)); ?></span></td> -->
                            <td style="text-align: center;">
                                <span>
                                    <!-- <input data-node_id="<?php echo ($vo["time_id"]); ?>" class="input" value="<?php echo ($vo["time_ip"]); ?>"  class="layui-input sortid" placeholder="请输入ID" type="text"> -->
                                    <?php echo ($vo["time_ip"]); ?>
                                </span></td>
                            <td style="text-align: center;"><span><?php echo ($vo["time_flow"]); ?></span></td>
                            <td style="text-align: center; cursor: pointer" onclick="add('腾讯地图','<?php echo U('Tasks/map',array('val'=>$vo['wei_province'].$vo['wei_city']));?>')"><span ><?php echo ($vo["wei_province"]); ?>,<?php echo ($vo["wei_city"]); ?></span></td>
                            <!-- <td style="text-align: center;"><span><?php echo ($vo["equipment_id"]); ?></span></td> -->
                            <!-- <td style="text-align: center;"><span><?php echo ($vo["time_starttime"]); ?></span></td> -->
                            <!-- round((strtotime($vo['time_endtime']) - strtotime($vo['time_starttime']))/(24*3600)) -->
                            <!-- <td style="text-align: center;"><span>
                                <?php
 $a = (strtotime($vo['time_endtime']) - time()); $day = floor($a/(24*3600)); if($day == 0){ $h = floor($a/3600); }else{ $h = floor($a/3600); $h = $h - 24*$day; } $d = $a % 3600; $s = floor($d/60); $day = $day+1; if($day>=0){ if($day>=3){ echo "<p style=''>剩余天数:".$day."天" .$h."小时</p>"; }else{ echo "<p style='color:red;'>剩余天数:".$day."天" .$h."小时</p>"; } }else{ echo "<p style='color:red;'>已过期</p>"; } ?>
                            </span></td> -->
                            <!-- <td style="text-align: center;"><span><?php echo ($vo["time_lcomplete"]); ?>/<?php echo ($vo["time_complete"]); ?></span></td><?php echo ($vo["total"]); ?>/ -->
                            <td style="text-align: center;"><span><?php echo ($vo["finish"]); ?></span></td>
                            <!-- <td style="text-align: center;"><?php if(($vo["time_status"]) == "0"): ?><a href="#" name="0" onclick="ishide(this,<?php echo ($vo["time_id"]); ?>)">开始任务</a><?php else: ?><a href="#" name="1" onclick="ishide(this,<?php echo ($vo["time_id"]); ?>)" style="color: red">关闭任务</a><?php endif; ?></td> -->
                            <td style="text-align: center;">
                                <a  href="<?php echo U('Tasks/edittimeTasks',array('time_id'=>$vo['time_id'],'wei_province'=>$vo['wei_province'],'wei_city'=>$vo['wei_city']));?>">编辑</a>
                                <a  href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Tasks/deletetimeTasks',array('time_id'=>$vo['time_id']));?>'">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div id="pageNav"></div>
            </div>
        </div>
        <div class="pagepadding">
            <div class="col-sm-5"><div aria-live="polite" role="status" id="example2_info" class="dataTables_info">共<?php echo ($count); ?>条</div></div><div class="col-sm-7"><div id="example2_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><?php echo ($page); ?></ul></div></div>
        </div>
</div>
        <script>
            $(".input").change(function(data){

                var id = $(this).attr('data-node_id');
                var value = $(this).val();
                $.ajax({
                    url:"<?php echo U('Tasks/ip');?>",
                    type:"post",
                    dataType: "json",
                    data:{'time_id':id ,'ip':value },
                    async: "false",
                    success:function(result){
                        if(result == 1){
                            layer.msg("更新经纬度成功", { icon: 6 });
                            parent.location.reload();
                        }
                        if(result == 2){
                            layer.msg("更新经纬度失败", { icon: 5 });
                        }
                        if(result == 3){
                            layer.msg("当前任务已过期", { icon: 5 });
                        }
                    }
                })
            })
        </script>
        <script>
            $(document).ready(function () {
                var num = 1;
                var checkbox = $("input[type='checkbox'][name='delAll']");
                $('#dellAll').on('click',function () {
//                alert(123);
                    if (num%2){
                        $.each(checkbox, function(i, n){
                            checkbox[i].checked = true;
                        });
                    }else{
                        $.each(checkbox, function(i, n){
                            checkbox[i].checked = false;
                        });
                    }
                    num++;
                });
                $('.selectRule').on('click',function () {
                    var classname = $(this).children(".layui-form-checkbox")[0].className;
                    var classArr = classname.split(' ');
                    var checkbox = $(this).next('td').find("input[type='checkbox']");
                    if($.inArray('layui-form-checked',classArr) >= 0){
                        $.each(checkbox,function (i,n) {
                            checkbox[i].checked = true;
                        });
                        $(this).next('td').find(".layui-form-checkbox").addClass('layui-form-checked');
                    }else{
                        $.each(checkbox,function (i,n) {
                            checkbox[i].checked = false;
                        });
                        $(this).next('td').find(".layui-form-checkbox").removeClass('layui-form-checked');
                    }
                });

            });
        </script>
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
        $(document).ready(function () {
            var num = 1;
            var checkbox = $("input[type='checkbox'][name='delAll']");
            $('#dellAll').on('click',function () {
//                alert(123);
                if (num%2){
                    $.each(checkbox, function(i, n){
                        checkbox[i].checked = true;
                    });
                }else{
                    $.each(checkbox, function(i, n){
                        checkbox[i].checked = false;
                    });
                }
                num++;
            });
            $('.selectRule').on('click',function () {
                var classname = $(this).children(".layui-form-checkbox")[0].className;
                var classArr = classname.split(' ');
                var checkbox = $(this).next('td').find("input[type='checkbox']");
                if($.inArray('layui-form-checked',classArr) >= 0){
                    $.each(checkbox,function (i,n) {
                        checkbox[i].checked = true;
                    });
                    $(this).next('td').find(".layui-form-checkbox").addClass('layui-form-checked');
                }else{
                    $.each(checkbox,function (i,n) {
                        checkbox[i].checked = false;
                    });
                    $(this).next('td').find(".layui-form-checkbox").removeClass('layui-form-checked');
                }
            });

        });

    </script>

<script>
    function ishide(obj,id){
        var b= $(obj).html();
        console.log(b);
        console.log(id);
        if(b =="开始任务"){
            var c =1
        }
        else if(b=="关闭任务"){
            var c = 0
        }
        $.ajax({
            url:"<?php echo U('Tasks/isHidden');?>",
            type:"post",
            dataType: "json",
            data:{'time_id':id ,'time_status':c },
            async: "false",
            success:function(result){
                    if(result == 1){
                        layer.msg("更新状态成功", { icon: 6 });
                        parent.location.reload();
                    }
                    if(result == 2){
                        layer.msg("更新状态失败", { icon: 5 });
                    }
                    if(result == 3){
                        layer.msg("当前任务已过期", { icon: 5 });
                    }
            }
        })
    }
    function isstate(obj,aid){
        var b= $(obj).html();
        console.log(aid);
        var c = 0;
        $.ajax({
            url:"<?php echo U('Article/isHidden');?>",
            type:"post",
            dataType: "json",
            data:{'articleid':aid ,'ishidden':c },
            async: "false",
            success:function(ishiddens){
                layer.alert("重启中",{ icon: 1,skin: 'layer-ext-moon' },function(){
                    location.reload();
                });
//                if(b=="开始任务"){
//                    $(obj).html('关闭任务');
//                    $(obj).css('color','red');
//                }
                if(b=="关闭任务"){
                    $(obj).html('开始任务');
                    $(obj).css('color','#3c8dbc');
                }
            }

        })

    }

    function geolocation_localcity(obj){
        var val=$(obj).html();
        var s=val.substr(0,val.lastIndexOf(','));
        $.ajax({
                url:"<?php echo U('Tasks/map');?>",
                type:"post",
                dataType: "json",
                data:{'val':s},
                async: "false",
                success:function(){
                    alert(1);
                }
                    
                })
    }
</script>