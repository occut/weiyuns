<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class VpnAccountController extends SuperController {
  //显示所有vpn账号
  public function ShowVpnAccount(){
    $VpnModel = D('vpnaccount');//查找数据表vpnaccount
    $count=$VpnModel->order()->selectVpnAccount();

    $total=$VpnModel->countaccount();
    $page = new \Org\Page\Page($total, 100);
    $usergroups=$VpnModel->selectaccountByPage($page);
    $show = $page->show();
    // //赋值到模版
    $this->assign('count', $total);//显示总条数
    $this->assign('page', $show);//显示分页

     $this->assign("allAccounts",$count);
    $this->display('Vpn/vpnlist');//将值显示在静态页面上
  }

  public function addVpnAccount(){
    $VpnModel = D('vpnaccount');//查找数据表vpnaccount
    $groupingModel=D('grouping');//查找数据表grouping

    $option=$groupingModel->select();
    $this->assign("allEquipment",$option);
     $this->display('Vpn/addvpnaccount');//将值显示在静态页面上
  }

  public function vpnAccountStore(){
     $equipment=I("equipment");
     $account_name=I("account_name");
     $account_password=I("account_password");

     $data['equipment']=$equipment;
     $data['account_name']=$account_name;
     $data['account_password']=$account_password;

     $VpnModel = D('vpnaccount');//查找数据表vpnaccount
     $value = $VpnModel->addVpnAccount($data);
     if ($value) {
        $this->success(L('添加成功'), U('VpnAccount/ShowVpnAccount'));
     } else {
        $this->error(L('添加失败'));
     }
  }
// 删除vpn账号
   public function deletevpnaccount(){
    $VpnModel = D('vpnaccount');//查找数据表vpnaccount
    $account_id=I('account_id');
     $value = $VpnModel->deletevpnaccountById($account_id);
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
  }
  // 批量删除账号
   public function deleteaccounts(){
        $VpnModel = D('vpnaccount');
        $account_id=I('ids');
        $a['account_id'] = array('in',$account_id);
        $value = $VpnModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
//将编辑的内容显示出来
    public function editvpnaccount(){
         $VpnModel = D('vpnaccount');

        $account_id = I('account_id');//相当于 $_GET['wei_id']

        $data['account_id']= $account_id;

        $result = $VpnModel->where($data)->find();

        $this->assign('data',$result);
        $this->display('Vpn/editvpnaccount');
    }

    // 保存编辑好的vpn账号
public function saveEdits(){
      if (IS_POST) {
            //接受POST传递过来的参数
            $account_id = I('account_id');
            $account_name = I('account_name');
            $account_password = I('account_password');
            //封装数据
            $data['account_name'] = $account_name;
            $data['account_password'] = $account_password;

            $VpnModel = D('vpnaccount');
            $result = $VpnModel->saveAccount($account_id,$data);
            //返回编辑结果
            if ($result) {
                $this->success(L('修改成功'), U('VpnAccount/ShowVpnAccount'));
            } else {
                $this->error(L('修改失败'));
            }
        } else{
            //接受GET传递过来的参数
             $account_id = I('account_id');
            //实列化Tasks模型
             $VpnModel = D('vpnaccount');
            //查找任务表中account_id为$account_Id的一条数据
            $taskgroup = $VpnModel->selectaccountById($account_id);
            //赋值到模版
            // $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
    }
}