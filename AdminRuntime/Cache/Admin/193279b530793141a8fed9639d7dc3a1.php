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
          编辑管理员

        </h1>
        <!--<ol class="breadcrumb">-->
            <!--<li><i class="fa fa-dashboard"></i> 首页</li>-->
            <!--<li>用户中心</li>-->
            <!--<li class="active">管理员</li>-->
        <!--</ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                   <h3 class="box-title"><a href="<?php echo U('Admin/listAdmins');?>"><button type="button" class="btn btn-block btn-default">管理员列表</button></a></h3>
                   <h3 class="box-title"><a href="<?php echo U('Admin/editPass',array('adminid'=>$selectadmin['admin_id'],'gd'=>$groupId,'md'=>$menuId));?>"><button type="button" class="btn btn-block btn-default">修改密码</button></a></h3>
                   <h3 class="box-title"><a href="#"><button type="button" class="btn btn-block btn-primary">编辑管理员</button></a></h3>
                 
                    </div>
            
            
   
            <!-- form start -->
            <form action="<?php echo U('Admin/editAdmin');?>" method="post" >
                <input type="hidden" name="adminid" value="<?php echo ($selectadmin["admin_id"]); ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="adminname">用户名</label>
                  <input type="text" class="form-control" name="adminname" value="<?php echo ($selectadmin["admin_name"]); ?>" autofocus id="adminname" placeholder="请输入用户名" required="required">
                </div>
                  <div class="form-group">
                  <label for="realname">真实姓名</label>
                  <input type="text" class="form-control" name="adminrealname" value="<?php echo ($selectadmin["admin_realname"]); ?>" id="realname" placeholder="请输入真实姓名">
                </div>
                  <div class="form-group">
                  <label for="email">邮箱</label>
                  <input type="email" class="form-control" name="adminemail" value="<?php echo ($selectadmin["admin_email"]); ?>" id="email" placeholder="请输入邮箱">
                </div>
                  <div class="form-group">
                  <label for="tel">手机号码</label>
                  <input type="text" class="form-control" name="adminmobile" value="<?php echo ($selectadmin["admin_mobile"]); ?>"  id="tel" pattern="^((13)|18|15)+\d{9}$" placeholder="请输入手机号码">
                </div>
                 
                    <!-- radio -->
                 <div class="form-group">
                   <label for="t7">状态</label>
                <div class="radio">
                
                <label>
                  <input type="radio" name="adminstatus" class="flat-red" value="1" <?php if(($selectadmin["admin_status"]) == "1"): ?>checked<?php endif; ?>>
                  正常
                </label>
                <label class="paat">
                  <input type="radio" name="adminstatus"  value="0" class="flat-red" <?php if(($selectadmin["admin_status"]) == "0"): ?>checked<?php endif; ?>>
                  禁用
                </label>
              </div>
              </div>
                 
                  
                  
                  
                  
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">提交</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
       </div>
	     </section>
        <!--/.col (right) -->
      </div>
<scrip>

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