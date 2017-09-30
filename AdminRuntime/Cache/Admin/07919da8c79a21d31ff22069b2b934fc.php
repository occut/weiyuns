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
        <h4 class="pull-left">
            <a href="<?php echo U('Wechat/WechaGroupsWhole');?>" style='color:<?php if($value == '全部账号'): ?>#000<?php endif; ?>'>全部账号</a>
            <!--<?php echo ($value); ?>-->
        </h4>
        <h4 class="box-title pull-left"><a href="<?php echo U('Wechat/WechaGroups');?>" style='color:<?php if($value == '正常账户'): ?>#000<?php endif; ?>'>正常账号</a></h4>
        <h4 class="box-title pull-left"><a href="<?php echo U('Wechat/WechaAbnormal');?>" style='color:<?php if($value == '账户异常'): ?>#000<?php endif; ?>'>异常账号</a></h4>
        <h4 class="box-title pull-left"><a href="<?php echo U('Wechat/WechaGroupsDisable');?>" style='color:<?php if($value == '禁用异常'): ?>#000<?php endif; ?>'>禁用账号</a></h4>
        <h4 class="box-title pull-left"><a href="<?php echo U('Wechat/WechaIdCard');?>" style='color:<?php if($value == '实名认证'): ?>#000<?php endif; ?>'>实名认证</a></h4>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><a href="javascript:;" onclick="add('导出账号','<?php echo U('Wechat/WeExport',array('wei_static'=>$static));?>')"><button type="button" class="btn btn-block btn-primary">导出账号</button></a></h3>
                        <h3 class="box-title"><a href="javascript:;" onclick="add('导入账号','<?php echo U('Wechat/Import',array('wei_static'=>$static));?>')"><button type="button" class="btn btn-block btn-primary">导入账号</button></a></h3>
                        <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="delAll('<?php echo U('Wechat/deleteWechats');?>')">批量删除</button></h3>
                        <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="delAll('<?php echo U('Wechat/state');?>','确定更新状态么')">批量更新</button></h3>
                        <h3 class="box-title">
                        <select style="width:200px;height: 40px;border: 1px solid #E6E6E6;padding-left: 10px;" name='id' id = "eq_id">
                        <?php if(is_array($alleqs)): $i = 0; $__LIST__ = $alleqs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$eqs): $mod = ($i % 2 );++$i;?><option value="<?php echo ($eqs["id"]); ?>"><?php echo ($eqs["equlist"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                       </select>
                        </h3>
                         <h3 class="box-title"><button class="btn btn-block btn-primary" onclick="bindEqis('<?php echo U('Wechat/bindeqis');?>')">绑定设备</button></h3>
                        <!-- <h3 class="box-title"> <input type="submit" value="绑定设备" class="layui-input btn-primary" onclick="bindEqis('<?php echo U('Wechat/bindeqis');?>')" style="width: 100px;margin-left: 20px;"></h3> -->
                        <!--  <h3 class="box-title pull-right">
                             <input type="text" name="" placeholder="请输入地址" class="layui-input searcharea" style="display: inline; width: 200px">
                             <button class="btn btn-block btn-primary layui-input"  style="display: inline; width: 100px" onclick="search('<?php echo U('Wechat/searchAddr');?>')">搜索</button>
                         </h3> -->
                          <form class="layui-form"  style="float:right;width:350px;" action="<?php echo U('Wechat/searchAddr');?>">
                    <input style="float:left;width:200px;" type="text" name="title" required  lay-verify="required" placeholder="请输入地址" autocomplete="off" class="layui-input">
                    <button style="float:right;width:100px;margin-right:20px;" class="layui-btn btn-primary" lay-submit lay-filter="formDemo">搜索</button>
                    </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example2" class="table table-bordered table-hover layui-table" style = "text-align: center;">
                            <thead >
                            <tr class="tng">
                                <th style = "text-align: center;"><input type="checkbox" id="dellAll" value=""></th>
                                <th style = "text-align: center;">ID</th>
                                <th style = "text-align: center;">手机号</th>
                                <th style = "text-align: center;">账号</th>
                                <th style = "text-align: center;">密码</th>
                                <th style = "text-align: center;">支付密码</th>
                                <th style = "text-align: center;">注册时间</th>
                                <th style = "text-align: center;">IP</th>
                                <th style = "text-align: center;">地址</th>
                                <th style = "text-align: center;">状态</th>
                                <th style = "text-align: center;">评论</th>
                                <th style = "text-align: center;">备注</th>
                                <th style = "text-align: center;">设备</th>
                                <th style = "text-align: center;">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($usergroups)): $i = 0; $__LIST__ = $usergroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="tnd">
                                    <td><input type="checkbox" value="<?php echo ($vo["wei_id"]); ?>" name="delAll"></td>
                                    <td><?php echo ($vo["wei_id"]); ?></td>
                                    <td><?php echo ($vo["wei_number"]); ?></td>
                                    <td><?php echo ($vo["wei_name"]); ?></td>
                                    <td><?php echo ($vo["wei_password"]); ?></td>
                                    <td><?php echo ($vo["pay_password"]); ?></td>
                                    <td><?php echo ($vo["wei_time"]); ?></td>
                                    <td><?php echo ($vo["wei_ip"]); ?></td>
                                    <td><?php echo ($vo["wei_address"]); ?></td>
                                    <!--<td><?php echo ($vo["wei_address"]); ?></td>-->
                                    <!--<td><?php echo substr($vo['wei_data'],0,20); ?>...</td>-->
                                    <!--<td><?php echo ($vo["wei_gold"]); ?></td>-->
                                    <td>
                                        <?php if(($vo["wei_static"]) == "1"): ?>正常
                                            <?php elseif($vo['wei_static'] == 2): ?>禁用异常
                                            <?php elseif($vo['wei_static'] == 3): ?>登录成功
                                            <?php elseif($vo['wei_static'] == 4): ?>任务完成
                                            <?php elseif($vo['wei_static'] == 5): ?>账户异常
                                            <?php else: ?>禁用<?php endif; ?></td>
                                    <td onclick="add('评论','<?php echo U('Wechat/comment',array('wei_number'=>$vo['wei_number']));?>')" style="cursor: pointer">
                                        <a href="javascript:;"><?php echo (subtext($vo["comment"],8)); ?></a>
                                    </td>
                                    <td><?php echo ($vo["wei_remarks"]); ?></td>
                                    <td><?php echo (subtext($vo["wei_equipment"],15)); ?></td>
                                    <td>
                                        <?php if(($vo["wei_static"]) == "2"): ?><a href="javascript:;" onclick="static(<?php echo ($vo['wei_id']); ?>)">
                                                正常
                                            </a><?php endif; ?>
                                        <a href="javascript:if(confirm('确实要删除吗?'))location='<?php echo U('Wechat/deleteWechat',array('wei_id'=>$vo['wei_id'],'gd'=>$groupId,'md'=>$menuId));?>'">删除</a>
                                    </td>
                                </tr>
                                <script>
                                    function static(id){
                                        console.log(id);
                                        $.ajax({
                                            url:"<?php echo U('Wechat/state');?>",
                                            type:"post",
                                            dataType: "json",
                                            data:{'ids':id},
                                            async: "false",
                                            success:function(result){
                                                if(result){
                                                    layer.msg("更新状态成功", { icon: 6 });
                                                    parent.location.reload();
                                                }else{
                                                    layer.msg("更新状态失败", { icon: 5 });
                                                }
                                            }
                                        })
                                    }
                                </script><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <div class="pagepadding">
                            <div class="col-sm-5"><div aria-live="polite" role="status" id="example2_info" class="dataTables_info">共<?php echo ($count); ?>条</div></div><div class="col-sm-7"><div id="example2_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><?php echo ($page); ?></ul></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
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
        // 搜索地址
        // function search(){
        //     var val=$(".searcharea").val();
        //     $.ajax({
        //         url:"<?php echo U('Wechat/searchAddr');?>",
        //         type:"post",
        //         dataType: "json",
        //         data:{'value':val},
        //         async: "false",
        //         success:function(result){
        //         if(result){
        //             layer.msg("更新状态成功", { icon: 6 });
        //             parent.location.reload();
        //         }else{
        //             layer.msg("更新状态失败", { icon: 5 });
        //             }
        //         }
        //     })

        // }

//批量绑定设备

       function bindEqis (url,title) {
        if(title === undefined){
            title = '确定绑定么';
        }
        layer.confirm(title,function(index){
            var checkbox = $("input[type='checkbox'][name='delAll']");
            var str = [];
            $.each(checkbox, function(i, n){
                if(checkbox[i].checked == true){
                   str[i] = checkbox[i].value;                   
                }
            });
           var eq_id = $('#eq_id').val();
           // console.log(str);
           // alert(str);
           // alert(eq_id);
            $.ajax({
                url:"<?php echo U('Wechat/bindeqis');?>",
                type:"post",
                dataType: "json",
                data:{'ids':str,'id':eq_id},
                async: "false",
                success:function(result){
                if(result){
                    layer.msg("绑定设备成功", { icon: 6 });
                    parent.location.reload();
                }else{
                    layer.msg("绑定设备失败", { icon: 5 });
                    }
                }
            })

        });
    }

//        $(function(){
//            $(".content-header h4").click(function(){
//                $(this).find("a").css("color","#000");
//            });
//        });
    </script>

<!-- Content Wrapper. Contains page content -->

<!-- /.box -->