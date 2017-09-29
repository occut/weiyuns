<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class IpJudgeController extends SuperController {
    /**
     * 显示weichat用户  正常
     */
   public function index(){
       $taskModel = D('Ipjudge');
       //获取总的任务数
       $count = $taskModel->selectIpJudgeTotalSize();
       //实例化分页类
       $page = new \Org\Page\Page($count,100);
       //获取每页显示的数据集
       $tasks = $taskModel->selectIpjudgeByPage($page);
       //分页显示输出
       $show = $page->show();
       //管理员操作记录到日志表中
       $logcontent =  C('SYS_LOG_ACTION_SELECT')."任务管理查询成功";
       sys_log(session('adminId'),session('adminName'),$logcontent);
       $this->assign('tasks', $tasks);
       $this->assign('count', $count);
       $this->assign('page', $show);
       $this->display('Upload/ipjudge');
   }

       public function dell(){
           $TextaraeaModel=D('Ipjudge');
           $ip_id=I('ip_id');
           $b['ip_id'] = $ip_id;
           $value = $TextaraeaModel->where($b)->delete();
           if($value){
               $this->success('删除成功', U('IpJudge/index'));
           }else{
               $this->success('删除失败', U('IpJudge/index'));
           }

       }

       public function dells(){
           $IpjudgeModel=D('Ipjudge');
           $ip_id=I('ids');
           $a['ip_id'] = array('in',$ip_id);
           $value = $IpjudgeModel->where($a)->delete();
//           dump($a);
           if ($value){
               echo 1;
               die;
           }
           echo 2;

       }
}