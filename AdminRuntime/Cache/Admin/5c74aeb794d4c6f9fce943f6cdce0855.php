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
<!--引用编辑器-->
<script type="text/javascript" src="<?php echo ($resource); ?>editor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="<?php echo ($resource); ?>editor/ueditor.all.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
</script>
<!--引用编辑器-->
<!-- Content Wrapper. Contains page content -->
<div class="layui-body">
    <div class="content-wrapper" style = "margin-left:1px ;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            添加设备
        </h1>
        <h1 style="margin-top:10px;"><a href="<?php echo U('Navigation/deviceGrouping');?>" class="layui-btn ">设备列表</a></h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#fa-icons" data-toggle="tab">基本设置</a></li>
                        <!--li><a href="#seoInfor" data-toggle="tab">seo信息</a></li-->
                    </ul>
                    <div class="tab-content">
                        <!--start 基本配置 -->
                        <div class="tab-pane active" id="fa-icons">
                            <section id="new">
                            <form action="<?php echo U('Navigation/addNavigation');?>" method="post">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="username">任务名称</label>
                                        <input type="text" class="form-control" name="navname" value=""autofocus id="username" placeholder="">
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group" style="display:none">
                                        <label>配置所属分类</label>
                                        <select class="form-control select2" name="parentid">
                                            <option value="0">顶级分类</option>
                                            <?php echo getnavigationtypeoptions(0);?>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="articledescription">参数配置</label>
                                        <textarea class="form-control" rows="3" id="navorder"  name="navtitle"></textarea>
                                    </div>
                                    <!--是否为外部链接-->
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1">附带图片</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="isout" id="inner" class="iradio_flat-green" value="0" checked="checked">是

                                            </label>
                                            <label>
                                                <input type="radio" name="isout" id="out" class="flat-red" value="1" >否
                                            </label>
                                        </div>
                                    </div>

                                        <!--内部链接-->
                                    <div class="form-group" id="isinner" >
                                        <input name="navigationurl" class="form-control" placeholder="" id="innername"  type="text" style="background-color: white">
                                        <input name="urlnum" class="form-control" type="text" value="" id="innernum" placeholder="请选择图片张数" >
                                    </div>
                                    <!--外部链接-->
                                    <div class="form-group" id="isout" style="display: none">

                                    </div>


                                    <div class="form-group" style="display:none">
                                        <label for="exampleInputEmail1">是否显示</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="ishidden" class="iradio_flat-green" value="0" checked>是
                                            </label>
                                            <label>
                                                <input type="radio" name="ishidden" class="flat-red" value="1">否
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.form-group -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">提交</button>
                                    </div>
                        <!-- /.box -->

                        </div>
                        <!-- end基本配置 -->

                        <!-- start seo信息-->
                        <div class="tab-pane" id="seoInfor" >

                            <div class="box-body">

                                <div class="form-group">
                                    <label for="exampleInputEmail1">标题</label>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">关键字</label>
                                    <input  value="11111"  type="text" name="navkeywords" class="form-control"  placeholder="请填写关键字">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">描述</label>
                                    <input  value="11111" type="text" name="navdescription" class="form-control"  placeholder="请填写描述">
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="hidden" name="configid" value="<?php echo ($webconfig["config_id"]); ?>">
                                <button type="submit" class="btn btn-primary">提交</button>
                            </div>

                            </form>

                        </div> <!-- end seo信息-->

                        <!-- /#ion-icons -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<!-- /.content-wrapper -->

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
<style type="text/css">

    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-top: 0 solid #f4f4f4;
    }

</style>
<div class="modal modal fade" id="myModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header btn-primary" style="padding-top: 8px ;padding-bottom: 8px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">URL列表</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="box-body" style="overflow-y: scroll; height: 300px" >
                        <input type='hidden' id='current_page'/>
                        <input type='hidden' id='show_per_page'/>
                        <table class="table" id="userlist">
                            <tbody >

                            </tbody>
                        </table>
                        <div>               
                            <div class="col-sm-5"><div aria-live="polite" role="status" id="usercout" class="dataTables_info"></div></div><div class="col-sm-7"><div class="dataTables_paginate paging_simple_numbers"><ul class="pagination" id="userpage"></ul></div></div>
                        </div>
                        <div>               
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    //调用url
        $.ajax({
            url: "<?php echo U('Navigation/geturl');?>",
            type: "get",
            dataType: "json",
            async: "false",
            success: function (userdata) {
                if (userdata .status) {
                    $('#userlist tbody').html(userdata.content);
                }
            }
        });

    function selectuser(item) {
        var urlid = "#username_" + item;
        var usernameval = $(usernameid).html();

        $('#userinfoname').val(usernameval);
        $('#myModal').modal('hide');
    }

</script>
<script>
    function urllist(obj){
   var a= $(obj).parent('td').next('td').html();
        var b=$(obj).parent('td').prev('td').html();
        var c=  b.replace("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;","");
    $('#innerurl').val(a);
        $('#innername').val(c);
        $('#myModal').modal('hide');
    }
</script>
<script>

    $('#out').change(function(){
        $('#oldpages').prop('checked',false);
        $('#newpages').prop('checked',true);
        $('#isinner').hide();
        $('#outurl').attr('name','navigationurl');
        $('#isout').show()

    });

    $('#inner').change(function(){
        $('#isinner').show();
        $('#newpages').prop('checked',false);
        $('#oldpages').prop('checked',true);
        $('#outurl').removeAttr('name');
        $('#isout').hide();
    });


</script>