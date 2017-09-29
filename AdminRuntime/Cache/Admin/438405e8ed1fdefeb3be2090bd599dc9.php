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
   编辑任务分组

  </h1>
  <!--<ol class="breadcrumb">-->
   <!--<li><i class="fa fa-dashboard"></i> 首页</li>-->
   <!--<li>信息管理</li>-->
   <!--<li class="active">任务分组管理</li>-->
  <!--</ol>-->
 </section>

 <!-- Main content -->
 <section class="content">
  <div class="row">
   <div class="col-xs-12">
    <div class="nav-tabs-custom">
     <ul class="nav nav-tabs">
      <li class="active"><a href="#fa-icons" data-toggle="tab">基本设置</a></li>
      <!--<li><a href="#seoInfor" data-toggle="tab">seo信息</a></li>-->
      <!--<li><a href="#auxiliaryInfor" data-toggle="tab">附属信息</a></li>-->

     </ul>
     <div class="tab-content">
      <!--start 基本配置 -->
      <div class="tab-pane active" id="fa-icons">
       <section id="new">
        <div class="row fontawesome-icon-list">
         <form role="form" method="post" action="<?php echo U('Tasks/editTaskgroup');?>" enctype="multipart/form-data">
          <div class="box-body" style="margin-left:15px;">
           <input type="hidden" name="taskGroupid" value="<?php echo ($taskgroup["group_id"]); ?>">
           <div class="form-group">
                <label for="articlename">任务分组名称</label>
                <input type="text" class="form-control" name="groupname" value="<?php echo ($taskgroup["group_name"]); ?>" autofocus id="articlename">
            </div>

              <div class="form-group">
                  <label for="articledescription">配置列表</label>
                  <textarea class="form-control" rows="3"   name="equlist"><?php echo ($taskgroup["equlist"]); ?></textarea>
              </div>

           <!-- /.form group -->
          </div>

          <!-- /.box-body -->
         </div>

          <div class="box-footer">
           <input type="hidden" name="configid" value="<?php echo ($webconfig["config_id"]); ?>">
           <button type="submit" class="btn btn-primary">提交</button>
          </div>
          </section>		              
        </div>
        <!-- end基本配置 -->

        <!-- start seo信息-->
        <div class="tab-pane" id="seoInfor">

             <div class="box-body">

                  <div class="form-group">
                   <label for="articletitle">任务分组标题</label>
                   <input type="text" class="form-control" name="articletitle" value="<?php echo ($article["article_title"]); ?>" id="articletitle" placeholder="请输入任务分组标题">
                  </div>

                  <div class="form-group">
                   <label for="articlekeywords">任务分组关键字</label>
                   <input type="text" class="form-control" name="articlekeywords" value="<?php echo ($article["article_keywords"]); ?>" id="articlekeywords" placeholder="请输入任务分组关键字">
                  </div>

                  <div class="form-group">
                     <label for="articledescription">任务分组描述</label>
                     <textarea class="form-control" rows="3" id="articledescription" placeholder="请输入任务分组描述" name="articledescription"><?php echo ($article["article_description"]); ?></textarea>
                  </div>

             </div>

                 <div class="box-footer">
                  <input type="hidden" name="configid" value="<?php echo ($webconfig["config_id"]); ?>">
                  <button type="submit" class="btn btn-primary">提交</button>
                 </div>
         
        </div> <!-- end seo信息-->



        <!-- start 上传设置--><div class="tab-pane" id="auxiliaryInfor">
         <div class="box-body">
          <!-- radio -->
             <!--logo-->
            <div class="form-group">
                                <label for="art">任务分组缩略图</label>
                                <input type="file" value="<?php echo ($article["article_pic"]); ?>"  name="articlepic" id="art" />
                                <?php if(!empty($article["article_pic"])): ?><div id="imgdiv"><img src="<?php echo ($article["article_pic"]); ?>" id="img"></div><?php else: ?>
                                        <div id="imgdiv">无图</div><?php endif; ?>
                                <p class="help-block">图片上传的大小不应大于3M</p>
                 </div>
                  <!--logo-->
         <div class="form-group">
               <label for="articlebrowse">浏览量</label>
               <input type="text" class="form-control" name="articlebrowse" value="<?php echo ($article["article_browse"]); ?>" id="articlebrowse" placeholder="请输入浏览量">
         </div>

          <div class="form-group">
               <label for="articleclicks">点击次数</label>
               <input type="text" class="form-control" name="articleclick" value="<?php echo ($article["article_clicl"]); ?>" id="articleclicks" placeholder="请输入点击次数">
        </div>

             <div class="form-group">
               <label for="articleauthor">作者</label>
               <input type="text" class="form-control" name="articleauthor" value="<?php echo ($article["article_author"]); ?>"  id="articleauthor" placeholder="请输入任务分组作者">
           </div>
                 <div class="form-group">
                     <label>发布时间:</label>
                     <div>
                         <input type="text" class="some_class form-control" name="articleaddtime" value="<?php echo (date('m-d-Y h:m;s',$article["article_addtime"])); ?>">
                     </div>
                 </div>
         <div class="form-group">
                 <label for="articlesummary">任务分组摘要</label>
                  <input type="text" class="form-control" name="articlesummary" value="<?php echo ($article["article_summary"]); ?>" id="articlesummary" placeholder="请输入任务分组摘要">
          </div>

             </div>
             <!-- /.box-body -->
             <div class="box-footer">
              <input type="hidden" name="configid" value="<?php echo ($webconfig["config_id"]); ?>">
              <button type="submit" class="btn btn-primary">提交</button>
             </div>
            </div> <!-- end 上传设置-->
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