<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="/AdminResource/adminhome/layui/css/layui.css" />
    <link rel="stylesheet" href="<?php echo ($resource); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ($resource); ?>dist/css/AdminLTE.min.css">
    
    <title>个性设置</title>
</head>
<body>

    <p class="layui-anim layui-anim-fadein">
    <blockquote class="layui-elem-quote layui-anim layui-anim-fadein">个性设置</blockquote>
    </p>
    <hr />
    <br />


    <form class="layui-form" action="">
        <!--<div class="layui-form-item">-->
            <!--<label class="layui-form-label">标题头</label>-->
            <!--<div class="layui-input-inline">-->
                <!--<input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">-->
            <!--</div>-->
        <!--</div>-->
        <div class="layui-form-item">
            <label class="layui-form-label">背景图片</label>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <div class="layui-upload-list" style="margin-left: 15px;">
                    <img class="layui-upload-img" id="demo1" style="margin-left: 15px;">
                    <p id="demoText"></p>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">头像</label>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test2">上传图片</button>
                <div class="layui-upload-list" style="margin-left: 15px;">
                    <img class="layui-upload-img" id="demo2" style="margin-left: 15px;">
                    <p id="demoText1"></p>
                </div>
            </div>
        </div>
        <!--<div class="layui-form-item">-->
            <!--<div class="layui-input-block">-->
                <!--<button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>-->
                <!--<button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
            <!--</div>-->
        <!--</div>-->
    </form>

</body>
<script type="text/javascript" src="/AdminResource/adminhome/layui/layui.js"></script>
<script type="text/javascript" src="/AdminResource/adminhome/layui/layui.all.js"></script>
<script src="<?php echo ($resource); ?>js/script123.js"></script>

    <script>
        //Demo
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
            form.on('submit(formDemo)', function(data){
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });

        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test1'
                ,url: "<?php echo U('Admin/upload');?>"
                ,data: {'image':'wallpaper'}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo1').attr('src', result); //图片链接（base64）
                        $('#demo1').attr('style', "height: 120px"); //图片链接（base64）
                    });
                }
                ,done: function(res){
                    if (res == 1){
                        return layer.msg('上传成功');
                    }else{
                        return layer.msg('上传失败');
                        var demoText = $('#demoText');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function(){
                            uploadInst.upload();
                        });
                    }
                }
            });
        });


        layui.use('upload', function(){
            var $ = layui.jquery
                ,upload = layui.upload;
            //普通图片上传
            var uploadInst = upload.render({
                elem: '#test2'
                ,url: "<?php echo U('Admin/upload');?>"
                ,data: {'image':'header'}
                ,before: function(obj){
                    //预读本地文件示例，不支持ie8
                    obj.preview(function(index, file, result){
                        $('#demo2').attr('src', result); //图片链接（base64）
                        $('#demo2').attr('style', "height: 120px"); //图片链接（base64）
                    });
                }
                ,done: function(res){
                    if (res == 1){
                        return layer.msg('上传成功');
                    }else{
                        return layer.msg('上传失败');
                        var demoText = $('#demoText1');
                        demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                        demoText.find('.demo-reload').on('click', function(){
                            uploadInst.upload();
                        });
                    }
                }
            });
        });
    </script>

</html>