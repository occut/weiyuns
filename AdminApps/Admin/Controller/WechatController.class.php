<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class WechatController extends SuperController {
    /**
     * 显示weichat用户  正常
     */
    public function WechaGroups() {
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
        $this->assign('alleqs', $options);
        //获取总的用户数
        $id = 1;
        $count = $WechaModel->selectWeichatTotalSize($id);
//        dump($count);die;
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage($page,$id);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
       
        $this->assign('usergroups', $userGroups);
        $this->assign('value', '正常账户');
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->display('Wechat/listWechatGroups');
    }
    //账户异常
    public function WechaAbnormal() {
        $this->assign('value', '账户异常');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
         $eqsModel=D('grouping');
        $options=$eqsModel->select();
$this->assign('alleqs', $options);
        //获取总的用户数
        $id = 5;
        $count = $WechaModel->selectWeichatTotalSize($id);
//        dump($count);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage($page,$id);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',0);
        $this->display('Wechat/listWechatGroups');
    }
//导出
    public function WeExport(){
        $taskid=I('wei_static');
        $WechaModel = D('Weichat');
        $data['wei_static']= $taskid;
        if($taskid == ""){
            $Weicha = $WechaModel->select();
        }else{
            $Weicha = $WechaModel->where($data)->select();
        }
        $a = implode("\r\n",[1,2]);
        $arr = [];
        foreach ($Weicha as $vo){
            $arr[] = $vo['wei_name'].'----'.$vo['wei_password'].'----'.$vo['wei_data'];
        }
        $a = implode("\r\n",$arr);
        $this->assign('data',$a);
        $this->display('Wechat/WeExport');
    }
    //导入
    public function Import(){
        if(IS_GET){
            $this->display('Wechat/Import');
        }else{
         $taskid=I('desc');
         $WechaModel = D('Weichat');
            $result = preg_split('/[;\r\n]+/s', $taskid);

            $a = explode("\r\n",$taskid);
//        var_dump($result);
//        die;
        foreach ($result as $b){
            $c = explode("----",$b);
            $data['wei_name'] = $c[0];
            $f['wei_name'] = $c[0];
            $data['wei_password'] = $c[1];
            $data['wei_data'] = $c[2];
            $data['admin_id']=session('adminId');
            $va = $WechaModel->where($f)->select();
            if(!empty($va)){
                $data = '';
            }
            if($data !=''){
                $value = $WechaModel->add($data);
//                var_dump($value."1");
            }

        }
            echo 1;
        }
    }
    public function idcardImport(){
        if(IS_GET){
            $this->display('Wechat/idcardImport');
        }else{
            $taskid=I('desc');
            $WechaModel = D('IdCard');
            $result = preg_split('/[;\r\n]+/s', $taskid);
            foreach ($result as $b){
                $c = explode("----",$b);
                $data['card_name'] = $c[0];
                $f['card_number'] = $c[1];
                $data['card_number'] = $c[1];
                $data['admin_id'] = session('adminId');
                $va = $WechaModel->where($f)->select();
                if(!empty($va)){
                    $data = '';
                }
                if($data !=''){
                    $value = $WechaModel->add($data);
                }
            }
            echo 1;
        }
    }
    //禁用
    public function WechaGroupsDisable(){
        $this->assign('value', '禁用异常');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
         $eqsModel=D('grouping');
        $options=$eqsModel->select();
$this->assign('alleqs', $options);
        //获取总的用户数
        $id = 0;
        $count = $WechaModel->selectWeichatTotalSize($id);
        //实例化分页类
        $page = new \Org\Page\Page($count, $this->adminPageSize);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage($page,$id);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static',1);
        $this->display('Wechat/listWechatGroups');
    }
    //全部
    public function WechaGroupsWhole(){
        $this->assign('value', '全部账号');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
        //获取总的用户数
        $id = '';
        $count = $WechaModel->selectWeichatTotalSize($id);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage2($page,$id);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('alleqs', $options);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','');
        $this->display('Wechat/listWechatGroups');
    }
    //登录中
    public function WechaGroupsLogin(){
        $this->assign('value', '使用中');
        //实例化UserGroup模型
        $WechaModel = D('Weichat');
        //获取总的用户数
        $id = 0;
        $count = $WechaModel->selectWeichatTotalSize($id);
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $WechaModel->selectWeichatByPage3($page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','2');
        $this->display('Wechat/listWechatGroups');
    }
//    实名认证
    public function  WechaIdCard(){
        $IdCard = D('IdCard');
        $count = $IdCard->selectIdCardTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count, 100);
        //获取每页显示的数据集
        $userGroups = $IdCard->selectIdCardByPage($page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent = C('SYS_LOG_ACTION_SELECT') . "会员分组查询成功。";
        sys_log(session('adminId'), session('adminName'), $logcontent);
        //赋值到模版
        $this->assign('usergroups', $userGroups);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('static','2');
        $this->display('Wechat/WechaIdCard');
    }
    public function deleteWechat(){
        $WechaModel = D('Weichat');
        $taskid=I('wei_id');
        $a['wei_id'] = $taskid;
        $value = $WechaModel->where($a)->delete();
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
    }
    public function deleteWechats(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
        $a['wei_id'] = array('in',$taskid);
        $value = $WechaModel->where($a)->delete();
//        dump($taskid);die;
        if ($value){
            echo 1;
            die;
        }
           echo 2;
    }
    public function state(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');
//        var_dump($taskid);
        $a['wei_id'] = array('in',$taskid);
        $data['wei_static'] = 0;
        $value = $WechaModel->where($a)->save($data);
        if ($value){
            echo 1;
        }else{
            echo 2;
        }

    }
// 显示评论
    public function  comment(){
        $WechaModel = D('Weichat');
        $wei_number = I('wei_number');//相当于 $_GET['wei_id']
        // dump($wei_id);
        $data['wei_number']= $wei_number;
        $Weicha = $WechaModel->where($data)->find();
        // dump($Weicha['comment']);
        $this->assign('data',$Weicha['comment']);
        $this->assign('number',$wei_number);
        $this->display('Wechat/comment');
    }

    public function  editComment(){
        $WechaModel = D('Weichat');
        $wei_number = I('wei_number');
        $comment = I('comment');
        // die;
        $a['wei_number']= $wei_number;
        $data['comment'] =  $comment;
        $value = $WechaModel->where($a)->save($data);
        if($value){
            echo 1;
             // $this->success(L('添加成功'), U('Shop/shops'));
        }else{
            echo 0;
            // $this->success(L('添加失败'), U('Shop/shops'));
        }

    }

     public function bindeqis(){
        $WechaModel = D('Weichat');
        $taskid=I('ids');//wechat
        // if(empty($taskid)){
        //     echo 2;
        // }
        // var_dump($taskid);
        $sid=I('id');//shebei
        $grouping = D('grouping');
        $a['id'] = $sid;
        $gr = $grouping->where($a)->find();
        $gr_name = $gr['equlist'];
        $a['wei_id'] = array('in',$taskid);
        $data['wei_equipment'] = $gr_name;
        $value = $WechaModel->where($a)->save($data);
        if ($value){
            echo 1;
            die;
        }
           echo 2;
    }

    // 搜索地址
    public function searchAddr(){
        $wechatModel=D('weichat');
        $eqsModel=D('grouping');
        $options=$eqsModel->select();
        $title=I('title');
        $where['wei_address'] = array('like','%'.$title.'%');//模糊查询
        $result=$wechatModel->where($where)->select();
        $count=$wechatModel->where($where)->count();
        $page = new \Org\Page\Page($count, 100);
        $usergroups=$wechatModel->selectByPage($page);
        $show = $page->show();
        $this->assign("usergroups",$result);
        $this->assign("count",$count);
        $this->assign('alleqs', $options);
        $this->assign('page', $show);//显示分页
        $this->display('Wechat/listWechatGroups');
    }
   
}