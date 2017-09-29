<?php

/**
 * Functions: 任务管理控制器.
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Controller;

use Think\Controller;

class TasksController extends SuperController {

    /**
     * 任务界面
     */
    public function listTasks() {
        //实列化Tasks模型
        $taskModel = D('Taskstime');
        $title = I('title');
        $res = $taskModel->select();
        $flow = '';
        foreach ($res as $vo){
            $flow += $vo['time_flow'];
            $time = (strtotime($vo['time_endtime']) - time());
            $day = floor($time/(24*3600));
            $day = $day+1;
            if($day < 0){
                $b['time_id'] = $vo['time_id'];
                $data['time_status'] = 1;
                $data['equipment_id'] = 0;
                $res = $taskModel->where($b)->save($data);
            }
        }
        $tasksgroupModel = D('TasksGroup');

        $a = $tasksgroupModel->order('group_id')->find();
        $aa = count(explode(',',$a['equlist']));
        $rate = ((($flow/1000)/$aa)*100)."%";
        //获取总的任务数
        $count = $taskModel->selectTasksTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count,100);
        //获取每页显示的数据集
        $tasks = $taskModel->selectTasksByPage($page,$title);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent =  C('SYS_LOG_ACTION_SELECT')."任务管理查询成功";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        $this->assign('tasks', $tasks);
        $this->assign('rate', round($rate,2)."%");
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Tasks/listtasks');
    }
   /**
   * 添加任务的方法
   */
   public function taskscreate(){
       $navModel=D('navigation');
       //取id，任务名
       $nav= $navModel->selectAllNavigations();
       //实例化TasksGroup类
       $tasksgroupModel = D('TasksGroup');
       //取id，组名
       $tasksgroup=$tasksgroupModel->selectAllTasksGroups();
       //实例化TasksGroup模型
       $taskModel = D('Tasks');
       //查找任务分组表中所有的数据
       $task = $taskModel->selectAllTasks();
       $navLen = count($nav);
       if($navLen > 0){
           $this->assign('firstNavId',$nav[0]['nav_id']);
       }
       $ProvinceModel = D('Province');
       $province = $ProvinceModel->select();
       //赋值到模版
       $this->assign('nav',$nav);
       $this->assign('province',$province);
       $this->assign('tasksgroup',$tasksgroup);
       $this->assign('task', $task);
       $this->assign('tasksgroup',$tasksgroup);
       $this->display('Tasks/taskscreate');
   }
    /**
     * city
     */
    public function city(){
        $id = I('configId');
//        var_dump($id);
        $ProvinceModel = D('Province');
        $data['id'] = $id;
        $province = $ProvinceModel->where($data)->find();
//        var_dump($province['provinceid']);
        $cityMode = D('city');
        $a['fatherID'] = $province['provinceid'];
        $aa = $cityMode->where($a)->select();
        $value = '';
        foreach ($aa as $vo){
            $value .= "<option value=".$vo['id'].">".$vo['city']."</option>";
        }
        $data = ['error' => 1,'value'=>$value];
        echo json_encode($data);
    }
    /**
     * 更改IP
     */
    public function ip(){
        $time_id=I('time_id');
        $ip=I('ip');
        $data['time_ip'] = $ip;
        $a['time_id'] = $time_id;
        $taskModel = D('Taskstime');
        $res = $taskModel->where($a)->save($data);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    /**
     * 保存任务的方法
     */
    public function tasksstore(){
        $proModel=D('province');
        $ctModel=D('city');
        $title=I('title');
        $provinceId=I('provinceId');//省id
        $cityId=I('cityId');
        $flow=I('flow');
        $time=I('time');
        // $ip=I('ip');
        $ip['lng']=F('LOCATION')['lng'];//取出经度
        $ip['lat']=F('LOCATION')['lat'];//取出纬度
        // dump($ip);die;
        $tasksgroupid =I('tasksgroupid');
        $tasksgroupModel = D('TasksGroup');
        //取id，组名
        $tasksgroup=$tasksgroupModel->selectTasksGroupById($tasksgroupid);
        $a = (strtotime($time['end']) - strtotime($time['start']));
        $day = ceil($a/(24*3600));

       
        $pro['id'] = $provinceId;//封装省的id
        $ct['id'] = $cityId;//封装省的id
        // dump($ct['id']);die;
        $proAll=$proModel->where($pro)->find();//根据id查找到省级
        $ctAll=$ctModel->where($ct)->find();//根据id查找到市级
        $data['wei_province']=$proAll['province'];//封装数据添加到数据库
        $data['wei_city']=$ctAll['city'];//封装数据添加到数据库
        $data['time_title'] = $title;
        $data['time_flow'] = $flow;
        $data['time_ip'] = $ip['lat'].','.$ip['lng'];//经纬度
        $data['group_name'] = $tasksgroup['group_name'];
        $data['admin_id'] = session('adminId');//
        $TaskstimeModel = D('Taskstime');
        if($flow > 500){
            $flows = ceil($flow/500);
            for ($i=1; $i<=$flows; $i++) {
                $data['time_flow'] = 500;
                if($i == $flows){
                    $data['time_flow'] = $flow - (500*($flows - 1));
                }
                $data['total'] = $data['time_flow']*$day;
                $value = $TaskstimeModel->add($data);
            }
        }else{
            $data['total'] = $flow*$day;
            $value = $TaskstimeModel->add($data);
        }

        if ($value) {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."添加任务。" . "任务名：" .$title;
            sys_log(session('adminId'),session('adminName'),$logcontent);
            $this->success(L('添加成功'), U('Tasks/listTasks'));
        } else {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."添加失败。" . "任务名：" .$title;
            sys_log(session('adminId'),session('adminName'),$logcontent);

            $this->error(L('添加失败'));
        }
    }
    /**
     * 开启和关闭任务
     */
    public function isHidden(){
        $time_id=I('time_id');
        $time_status=I('time_status');
        $TaskstimeModel = D('Taskstime');
        $a['time_id'] = $time_id;
        $data['time_status'] = $time_status;
        $res = $TaskstimeModel->where($a)->find();
        $data['equipment_id'] = 0;
        $data['time_status'] = $time_status;
        $time = strtotime($res['time_endtime']) - time();
        $day = floor($time/(24*3600));
        $day = $day+1;
        if($day >= 0){
            $value = $TaskstimeModel->where($a)->save($data);
            if($value){
                echo 1;
            }else{
                echo 2;
            }
        }else{
            echo 3;
        }



    }
    /**
     * 编辑任务
     */
    public function edittimeTasks(){
        if(IS_GET) {
            $taskstimeModel=D('taskstime');
            $proModel=D('province');
            $ctModel=D('city');
            $province=$proModel->select();
            $pr['province'] = I('wei_province');//将获取到的值封装
            $ci['city'] = I('wei_city');
             $ip['lng']=F('LOCATION')['lng'];//取出经度
            $ip['lat']=F('LOCATION')['lat'];//取出纬度
            $data['time_ip'] = $ip['lat'].','.$ip['lng'];//经纬度
            $cityid = $ctModel->where($ci)->find();//根据条件查找所有城市的id
            $provincevalue=$proModel->where($pr)->find();
            $wei_province = $provincevalue['province'];
            $wei_city = $cityid['city'];
            $data['wei_province'] = $wei_province;
            $data['wei_city'] = $wei_city;
            $ci1['fatherID'] = $provincevalue['provinceid'];
            $city=$ctModel->where($ci1)->select();
             $time_id = I('time_id');
             $data['time_id']= $time_id;
             $result = $taskstimeModel->where($data)->find();
             $ID = ['ci_id'=>$cityid['id'],'pr_id'=>$provincevalue['id']];
            $navModel=D('navigation');
            //取id，任务名
            $nav= $navModel->selectAllNavigations();
            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectAllTasksGroups();
            //实例化TasksGroup模型
            $taskModel = D('Tasks');
            //查找任务分组表中所有的数据
            $task = $taskModel->selectAllTasks();
            $navLen = count($nav);
            if($navLen > 0){
                $this->assign('firstNavId',$nav[0]['nav_id']);
            }
            //赋值到模版
            $taskModel = D('Taskstime');
            $a['time_id'] = $time_id;
            $res = $taskModel->where($a)->find();
            $this->assign("id",$ID);
            $this->assign('data',$result);
            $this->assign('city',$city);
            $this->assign('province',$province);
            $this->assign('nav',$nav);
            $this->assign('tasksgroup',$tasksgroup);
            $this->assign('tasks', $res);
            $this->display('Tasks/edittimeTasks');
        }else{
            $proModel=D('province');
            $ctModel=D('city');
            $pr['id'] = I('provinceId');
            $ci['id'] = I('cityId');
            $provincevalue=$proModel->where($pr)->find();
            $cityid = $ctModel->where($ci)->find();
            $title=I('title');
            $url=I('url');
            $flow=I('flow');
            $time=I('time');
            $frequency=I('frequency');
            $stop=I('stop');
            $behavior=I('behavior');
            $time_id = I('time_id');
            $time_status = I('time_status');
            $ip['lng']=F('LOCATION')['lng'];//取出经度
            $ip['lat']=F('LOCATION')['lat'];//取出纬度
            $data['time_ip'] = $ip['lat'].','.$ip['lng'];//经纬度
            $data['time_title'] = $title;
            $data['time_url'] = $url;
            $data['time_flow'] = $flow;
            $data['time_starttime'] = $time['start'];
            $data['time_endtime'] = $time['end'];
            $data['time_frequency'] = $frequency;
            $data['time_stop'] = $stop;
            $data['time_behavior'] = $behavior;
            $data['time_resources'] = $time['start'];
            $data['time_status'] = $time_status;
            $data['wei_province'] = $provincevalue['province'];
            $data['wei_city'] = $cityid['city'];
            $tasksgroupid =I('tasksgroupid');
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectTasksGroupById($tasksgroupid);
            $data['group_name'] = $tasksgroup['group_name'];
            $a['time_id'] = $time_id;
            $taskModel = D('Taskstime');
            $res = $taskModel->where($a)->save($data);
            if ($res) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."修改任务。" . "任务名：" .$title;
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('修改成功'), U('Tasks/listTasks'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."修改失败。" . "任务名：" .$title;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('修改失败'));
            }

        }
    }
    /**
     * 删除任务
     */
    public function deletetimeTasks(){
        $time_id = I('time_id');
        $taskModel = D('Taskstime');
        $a['time_id'] = $time_id;
        $res = $taskModel->where($a)->delete();
        if ($res) {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除成功" . "任务ID：" .$time_id;
            sys_log(session('adminId'),session('adminName'),$logcontent);
            $this->success(L('删除成功'), U('Tasks/listTasks'));
        } else {
            //管理员操作记录到日志表中
            $logcontent = C('SYS_LOG_ACTION_DELETE')."删除失败" . "任务ID：" .$time_id;
            sys_log(session('adminId'),session('adminName'),$logcontent);

            $this->error(L('删除失败'));
        }
    }
    /**
     * 清空
     */
    public function disable(){
        $DisableModel = D('Disable');
        $test=$DisableModel->select();
        $value = $test[0]['id'];
        $a = $DisableModel->where('id',$value)->save(['value'=>0]);
        if ($a){
            echo 1;
            die;
        }else{
            echo 2;
        }
    }
    /**
     *一键开启关闭
     */
    public function buttonopen(){
        $taskid=I('id');
        $taskModel = D('Tasks');
        $a['tasks_status'] = $taskid;
        if($taskid ==1){
            $b = 0;
        }else{
            $b = 1;
        }
       $aaa = $taskModel->where($b)->save($a);
        echo 1;
    }
    /**
     * 添加任务的方法
     */
public function Upload(){
	$taskid=I('taskid');
    $navModel=D('Navigation');
    $nav= $navModel->selectNavigationById($taskid);
    $url=$nav['nav_url'];
    if($url==1212){
        $file = $_FILES['tasks'];
        $webConfigModel = D('WebConfig');
        $webConfig = $webConfigModel->selectWebConfig();
        // 实例化上传类
        $upload = new \Think\Upload();
        // 设置附件上传大小
        $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
        // 设置附件上传类型
        $upload->exts = explode('|', $webConfig['upload_type']);
        // 设置附件上传根目录
        $upload->rootPath = './';
        $upload->saveName="";
        // 设置附件上传（子）目录
        $upload->savePath = C('UPLOAD_IMG_DIRECTORY').$url."/";
        $info = $upload->uploadOne($file);
        //获取上传路径
        var_dump($info);
        $taskPic = $info['savepath'].$info['savename'];
        die;
    }
    //调用上传图片的方法
    $file = $_FILES['tasks'];
    $webConfigModel = D('WebConfig');
    $webConfig = $webConfigModel->selectWebConfig();
    // 实例化上传类
    $upload = new \Think\Upload();
    // 设置附件上传大小
    $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
    // 设置附件上传类型
    $upload->exts = explode('|', $webConfig['upload_type']);
    // 设置附件上传根目录
    $upload->rootPath = './';
    $upload->saveName="";
    // 设置附件上传（子）目录
    $upload->savePath = C('UPLOAD_IMG_DIRECTORY')."/".$url."/";
    $info = $upload->uploadOne($file);
    //获取上传路径
    $taskPic = $info['savepath'].$info['savename'];

    $this->redirect('Tasks/addtask');

}
public function addTask(){
        if (IS_POST) {
            //接受POST传递过来的值
            $tasksid= I('navid') ;
            $groupid=I('tasksgroupid');
            //实例化导航
            $navModel=D('navigation');
            //取id，任务名
            $nav= $navModel->selectNavigationById($tasksid);
            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectTasksGroupById( $groupid);
            $groupname=$tasksgroup['group_name'];
            $tasksname=$nav['nav_name'];
            $taskskey=I('taskkey');
            $tasksvalue=I('taskvalue');
            $taskstatus=I('taskstutas');
            $taskName = I('taskname');
            $taskTitle = I('tasktitle');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');
            $str='';
            $index = 1;
            for ($i = 0;$i< count($taskskey) ; $i++){
                if($index != 1){
                    $str .= ";";
                }
                $str =  $str .$taskskey[$i] .":" .$tasksvalue[$i];

                $index ++;
            }
          for($i =0; $i++ ; $i < len($tasksvalue)){
          }
            $url=$nav['nav_url'];
            //调用上传图片的方法
            $file = $_FILES['tasks'];
            //echo $file;
            $webConfigModel = D('WebConfig');
            $webConfig = $webConfigModel->selectWebConfig();
            // 实例化上传类
            $upload = new \Think\Upload();
            // 设置附件上传大小
            $upload->maxSize = $webConfig['upload_size'] * 1024 * 1024;
            // 设置附件上传类型
            $upload->exts = explode('|', $webConfig['upload_type']);
            // 设置附件上传根目录
            $upload->rootPath = './';
            $upload->saveName="";
            // 设置附件上传（子）目录
            $upload->savePath = C('UPLOAD_IMG_DIRECTORY')."/".$url."/";
            $info = $upload->uploadOne($file);
            //获取上传路径
            $taskPic = $info['savepath'].$info['savename'];
            $taskContent = I('taskcontent');
            $taskbrowse=I('taskbrowse');
            $taskclick=I('taskclick');
            $taskauthor=I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime=I('taskaddtime');
            $tasksnumber=I('tasksnumber');
            //封装数据
            $data['group_name'] = $groupname;
            $data['tasks_name'] = $tasksname;
            $data['tasks_status']=$taskstatus;
            $data['tasks_configs']=$str;
            $data['task_title'] = $taskTitle;
            $data['task_keywords'] = $taskKeywords;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse']= $taskbrowse;
            $data['task_click']=$taskclick;
            $data['task_author']=$taskauthor;
            $data['tasks_number']=$tasksnumber;
            $data['admin_id']=session('adminId');
            if(empty($taskaddTime)){
               $data['task_addtime'] = time();
            }else{
               $data['task_addtime']=strtotime($taskaddTime);
            }
            //实列化Tasks模型
            $taskModel = D('Tasks');
            //添加任务信息
            $result = $taskModel->addTasks($data);
            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加成功。" . "任务名：" . $taskName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加失败。" . "任务名：" . $taskName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else{
                //实例化导航
            $navModel=D('navigation');
            //取id，任务名
            $nav= $navModel->selectAllNavigations();
            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup=$tasksgroupModel->selectAllTasksGroups();
            //实例化TasksGroup模型
            $taskModel = D('Tasks');
            //查找任务分组表中所有的数据
            $task = $taskModel->selectAllTasks();
            $navLen = count($nav);
            if($navLen > 0){
                $this->assign('firstNavId',$nav[0]['nav_id']);
            }
            //赋值到模版
            $this->assign('nav',$nav);
            $this->assign('string',$string);
            $this->assign('tasksgroup',$tasksgroup);
            $this->assign('task', $task);
            $this->display('Tasks/addtask');
        }
    }
    
    /**
     * 删除任务的方法
     */
    public function deleteTasks() {
        if (IS_GET){
            //接受GET传递过来的值
            $taskId = I('tasksid');
            //实列化Tasks模型
            $taskModel = D('Tasks');
            //查找任务表中task_id为$taskId的一条数据
            $task = $taskModel->selectTasksById($taskId);
            // 删除任务表中task_id为$taskid的一条数据
            $result = $taskModel->deleteTasksById($taskId);
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."任务删除成功。" . "任务名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->success(L('DELTE_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
        } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."会员删除成功。" . "用户名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);
                $this->error(L('DELTE_ARTICLE_FAILURE'));
        }
    }
    }
    public function deletesTasks(){
        $time_id = I('time_id');
        $taskModel = D('Taskstime');
        $taskid=I('ids');
        $a['time_id'] = array('in',$taskid);
        $value = $taskModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
    /*
     * ajax调取数据
     */
    public function getConfigs(){
        $navid=I('configId');
        //实例化导航
        $navModel=D('navigation');
        //取id，任务名
        $nav= $navModel->selectNavigationById($navid);
        $navconfigs=$nav['nav_title'];
        $navimg=$nav['nav_url'];
        $navid=$nav['nav_id'];
        if(empty($navimg))
        {
            $aaa=0;
        }
        else {$aaa=1;}
        $navconfig=explode(',',$navconfigs);
        $str='';
        foreach( $navconfig as $v){
            $str.="<lable><input value=" .$v." type='text'   readonly='true' name='taskkey[]' style='backgroud:#fff; width:200px; border:0px ; border: 0px;' ></lable>";
            $str.='<input type="text"  name="taskvalue[]">';
            $str.='<br>';
        }
        $userdata = array(
            'status' => C('JSON_SUCCESS_CODE'),
            'content' => $str,
            'uploadimg'=>$navimg,
            'id'=>$navid,
        );
        
        $this->ajaxReturn($userdata);
    }


    /*
     * ajax调取数据
     */
    public function getConfigsEdit(){
        $taskid=I('taskid');
        $tasksModel=D('Tasks');
        $tasks=$tasksModel->selectTasksById($taskid);
        $configs=explode(';',$tasks[tasks_configs]);
        $str='';
        for($i = 0;$i < count($configs);$i++){
            $subConfig = explode(':',$configs[$i]);
            $str.="<lable><input value=".$subConfig[0]." type='text'   readonly='true' name='taskkey[]' style='backgroud:#fff; width:200px; border:0px ; border: 0px;' ></lable>";
            $str.="<input type='text'  name='taskvalue[]' value='".$subConfig[1]."'>";
            $str.="<br>";
        }
        $userdata = array(
            'status' => C('JSON_SUCCESS_CODE'),
            'content' => $str,
        );
        $this->ajaxReturn($userdata);
    }

    /**
     * 编辑任务
     */
    public function editTasks()
    {
        if (IS_POST) {
            //接受POST传递过来的值
            $tasksid = I('tasksid');
            $groupid = I('tasksgroupid');
            $navid=I('navid');
            //实例化导航
            $navModel = D('navigation');
            //取id，任务名
            $nav = $navModel->selectNavigationById($navid);
            //实例化TasksGroup模型
            $taskModel = D('Tasks');
            //查找任务分组表中所有的数据
            $task = $taskModel->selectAllTasks();
            $navLen = count($nav);
            if($navLen > 0){
                $this->assign('firstNavId',$nav[0]['nav_id']);
            }
            //实例化TasksGroup类
            $tasksgroupModel = D('TasksGroup');
            //取id，组名
            $tasksgroup = $tasksgroupModel->selectTasksGroupById($groupid);
            $groupname = $tasksgroup['group_name'];
            $tasksname = $nav['nav_name'];
            if(I('taskkey')!=" "&&I('taskvalue')!=" ")
            {
                $taskskey = I('taskkey');
                $tasksvalue = I('taskvalue');
            }
            $taskstatus = I('taskstutas');
            $taskName = I('taskname');
            $taskTitle = I('tasktitle');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');
            $str = '';
            $index = 1;
            for ($i = 0; $i < count($taskskey); $i++) {
                if ($index != 1) {
                    $str .= ";";
                }
                $str = $str . $taskskey[$i] . ":" . $tasksvalue[$i];
                $index++;
            }
            for ($i = 0; $i++; $i < len($tasksvalue)) {
            }
            //调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            $taskPic = $info['savepath'] . $info['savename'];
            $taskContent = I('taskcontent');
            $taskbrowse = I('taskbrowse');
            $taskclick = I('taskclick');
            $taskauthor = I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime = I('taskaddtime');
            $tasksnumber=I('tasksnumber');
            //接收到的值不能为空
            //封装数
            $data['group_name'] = $groupname;
            $data['tasks_name'] = $taskName;
            $data['tasks_status'] = $taskstatus;

            $data['tasks_configs'] = $str;

            $data['task_title'] = $taskTitle;
            $data['task_keywords'] = $taskKeywords;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse'] = $taskbrowse;
            $data['task_click'] = $taskclick;
            $data['task_author'] = $taskauthor;
            $data['tasks_number']=$tasksnumber;
            if (empty($taskaddTime)) {
                $data['task_addtime'] = time();
            } else {
                $data['task_addtime'] = strtotime($taskaddTime);
            }

            //实列化Tasks模型
            $taskModel = D('Tasks');
            //添加任务信息
            $result = $taskModel->saveTask($tasksid,$data);
            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD') . "任务管理添加成功。" . "任务名：" . $taskName;
                sys_log(session('adminId'), session('adminName'), $logcontent);

                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtasks'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD') . "任务管理添加失败。" . "任务名：" . $taskName;
                sys_log(session('adminId'), session('adminName'), $logcontent);

                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else {

            

                $tasksid=I('tasksid');
                $data['tasks_id']=$tasksid;
                $user=M('tasks')->where($data)->find(); 
                $name=$user["tasks_name"];
                $data['nav_name']=$name;
                $navuser=M('navigation')->where($data)->find();
                $navname=$navuser["nav_url"];
                $this->assign('tasksid',$tasksid);
                $this->assign('navname',$navname);
                $tasksModel=D('Tasks');
                $tasks=$tasksModel->selectTasksById($tasksid);
                $data['nav_name']=$tasks['tasks_name'];
 
                //实例化导航
                $navModel = D('navigation');
                //取id，任务名
                //实例化TasksGroup模型
                $taskModel = D('Tasks');
                //查找任务分组表中所有的数据
                $task = $taskModel->selectAllTasks();
                $navLen = count($nav);
                if($navLen > 0){
                    $this->assign('firstNavId',$nav[0]['nav_id']);
                }

                //实例化TasksGroup类
                $tasksgroupModel = D('TasksGroup');
                //取id，组名
                $tasksgroup = $tasksgroupModel->selectAllTasksGroups();
                //实例化TasksGroup模型
                $taskModel = D('Tasks');
                //查找任务分组表中所有的数据
                $task = $taskModel->selectAllTasks();


                //赋值到模版
                $this->assign('tasks',$tasks);
                $this->assign('nav', $nav);
                $this->assign('tasksgroup', $tasksgroup);
                $this->assign('task', $task);
                $this->assign('tasksid',$tasksid);
                $this->display();


            }
     




    }









    /**
     * 任务分组界面
     */
    public function listTaskGroups() {
        //select all task information
        //实列化Tasks模型
        $taskGroupModel = D('TasksGroup');


        //获取总的任务数
        $count = $taskGroupModel->selectTasksGroupTotalSize();

        //实例化分页类
        $page = new \Org\Page\Page($count,$this->adminPageSize);


        //获取每页显示的数据集
        $tasksGroup = $taskGroupModel->selectTasksGroupByPage($page);
//        var_dump($tasksGroup);
//        die;
        //分页显示输出
        $show = $page->show();


        //管理员操作记录到日志表中
        $logcontent =  C('SYS_LOG_ACTION_SELECT')."任务管理查询成功";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        $this->assign('tasksGroup', $tasksGroup);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Tasks/listtaskgroups');
    }

    /**
     * 添加任务分组的方法
     */
    public function addTaskGroup(){
        if (IS_POST) {
            //接受POST传递过来的值
            $groupName = I('groupname');
            $equlist = I('equlist');
            $taskKeywords = I('taskkeywords');
            $taskDescription = I('taskdescription');
            $groupId = I('groupid');

            //调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            $taskPic = $info['savepath'] . $info['savename'];

            $taskContent = I('taskcontent');
            $taskbrowse=I('taskbrowse');
            $taskclick=I('taskclick');
            $taskauthor=I('taskauthor');
            $taskSummary = I('tasksummary');
            $taskaddTime=I('taskaddtime');
            //接收到的值不能为空
            if (empty($groupName)) {
                $this->error('任务分组名称不能为空');
            }
            if (empty(  $equlist)) {
                $this->error('设备列表不能为空');
            }

            //封装数据
            $data['group_name'] =$groupName;
            $data['equlist'] = $equlist;
            $data['task_keywords'] = $taskKeywords;
            $data['group_id'] = $groupId;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            $data['task_browse']= $taskbrowse;
            $data['task_click']=$taskclick;
            $data['task_author']=$taskauthor;
            $data['admin_id']=session('adminId');
            if(empty($taskaddTime)){
                $data['task_addtime'] = time();
            }else{
                $data['task_addtime']=strtotime($taskaddTime);
            }
            $array =  explode(',',$equlist);
            //添加设备信息
            foreach ($array as $va){
                $data1['equlist'] = $va;
                $data1['group_name'] = $groupName;
                $data1['admin_id']=session('adminId');
                $Grouping = D('Grouping');
                $result =  $Grouping->addUserGroup($data1);
            }
            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            //添加任务信息
            $result = $taskModel->addTasksGroup($data);

            //返回添加结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加成功。" . "任务名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('ADD_ARTICLE_SUCCESS'), U('Tasks/listtaskGroups'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."任务管理添加失败。" . "任务名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('ADD_ARTICLE_FAILURE'));
            }
        } else{
            //实例化TasksGroup模型
            $taskGroupModel = D('TasksGroup');
            //查找任务分组表中所有的数据
            $taskGroup = $taskGroupModel->selectAllTasksGroups();
            //赋值到模版
            $this->assign('taskgroup', $taskGroup);
            $this->display('Tasks/addtaskGroup');
        }
    }

    /**
     * 删除任务分组的方法
     */
    public function deleteTaskGroup() {
        if (IS_GET){
            //接受GET传递过来的值
            $taskGroupId = I('taskGroupid');

            //实列化Tasks模型
            $taskGroupModel = D('TasksGroup');
            $Grouping = D('Grouping');
            $a['group_id']=$taskGroupId;
            $taskGroupModel1 =$taskGroupModel->where($a)->select();
            $arr = explode(',',$taskGroupModel1[0]['equlist']);
            foreach ($arr as $va){
                $b['equlist']=$va;
                $Groupingmodel = $Grouping->where($b)->delete();
            }
            //查找任务表中task_id为$taskId的一条数据
            $task =  $taskGroupModel->selectTasksGroupById($taskGroupId);
            // 删除任务表中task_id为$taskid的一条数据
            $result = $taskGroupModel->deleteTasksGroupById($taskGroupId);
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."任务删除成功。" . "任务名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('DELTE_ARTICLE_SUCCESS'), U('Tasks/listtaskGroups'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_DELETE')."会员删除成功。" . "用户名：" .$task['task_name'];
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('DELTE_ARTICLE_FAILURE'));
            }
        }
    }

    /**
     * 编辑任务分组
     */
    public function editTaskGroup() {
        if (IS_POST) {
            //接受POST传递过来的参数
            $taskGroupId = I('taskGroupid');
            $groupName = I('groupname');
            $equlist = I('equlist');
            $taskDescription = I('taskdescription');

            // 调用上传图片的方法
            $file = $_FILES['taskpic'];
            $info = upload_img($file);
            //获取上传路径
            if ($info) {
                $taskPic = $info['savepath'] . $info['savename'];
            } else {
                $taskPic = $_FILES['taskpic'];
            }
            $taskContent = I('taskcontent');
            $taskSummary = I('tasksummary');
            $taskaddtime=I('taskaddtime');

            //接收到的值不能为空
            if (empty($groupName)) {
                $this->error('任务分组名称不能为空');
            }
            if (empty( $equlist)) {
                $this->error('配置列表不能为空');
            }
            //封装数据
            $data['group_name'] = $groupName;
            $data['equlist'] = $equlist;
            $data['group_id'] = $taskGroupId;
            $data['task_pic'] = $taskPic;
            $data['task_description'] = $taskDescription;
            $data['task_content'] = $taskContent;
            $data['task_summary'] = $taskSummary;
            if(empty($taskaddtime)){
                $data['task_addtime'] = time();
            }else{
                $data['task_addtime']=strtotime($taskaddtime);
            }
            //修改设备信息先删后插入
            $Grouping = D('Grouping');
            $a['group_id']=$taskGroupId;
            $taskGroupModel = D('TasksGroup');
            $taskGroupModel1 =$taskGroupModel->where($a)->select();
            $arr = explode(',',$taskGroupModel1[0]['equlist']);
            foreach ($arr as $va){
                $b['equlist']=$va;
                $Grouping->where($b)->delete();
            }
            $array =  explode(',',$equlist);
            foreach ($array as $va){
                $data1['equlist'] = $va;
                $data1['group_name'] = $groupName;
                $Grouping = D('Grouping');
                $result =  $Grouping->addUserGroup($data1);
            }

            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            //添加任务信息
            $result = $taskModel->saveAriticle($taskGroupId, $data);
            //返回编辑结果
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."任务编辑成功。" . "任务名：" . $taskName ;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('EDIT_ARTICLE_SUCCESS'), U('Tasks/listtaskgroups'));
            } else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."任务编辑失败。" . "任务名：" . $taskName ;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('EDIT_ARTICLE_FAILURE'));
            }
        } else{

            //接受GET传递过来的参数
            $taskGroupId = I('taskGroupid');

            //实列化Tasks模型
            $taskModel = D('TasksGroup');
            // //实例化TasksGroup模型
            $taskGroupModel = D('TasksGroup');

            //查找任务表中task_id为$taskId的一条数据
            $taskgroup = $taskGroupModel->selectTasksGroupById($taskGroupId );

            //赋值到模版
            $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
    }

    public function map(){
        $val=I('val');//AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y
        $flie = "http://apis.map.qq.com/ws/geocoder/v1/?address=".$val."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";

       $arr = get($flie,'array');
       $jinwei = $arr['result']['location'];

        $this->assign('jinwei',$jinwei);
        $this->assign('pro',$val);
        $this->display('Tasks/map');
    }

   public function getlocation(){
        if(IS_GET){
            $keyword=I('keyword');
            // $html=I('html');//获取显示在地图页面的经纬度值
            $flie = "http://apis.map.qq.com/ws/geocoder/v1/?address=".$keyword."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";

        $arr = get($flie,'array');
        $jinwei = $arr['result']['location'];
         // $this->assign('location',$html);//将获取的值传到搜索框
        $this->assign('jinwei',$jinwei);
        $this->display('Tasks/map2');
    }else{
        $keyword=I('keyword');
        // $html=I('html');//获取显示在地图页面的经纬度值
        $flie = "http://apis.map.qq.com/ws/geocoder/v1/?address=".$keyword."&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";
        $arr = get($flie,'array');
        $jinwei = '纬度为：'.$arr['result']['location']['lat'].'经度为：'.$arr['result']['location']['lng'];
        $data=['error'=>true,'data'=>$jinwei];
        echo json_encode($data);
        F('LOCATION',$arr['result']['location']);
    }
   }
}
