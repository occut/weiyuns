<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class VpnaddressController extends SuperController {
  //显示所有vpn账号
  public function showvpnaddress(){
    $AddressModel = D('vpnaddress');//查找数据表vpnaccount
    $count=$AddressModel->selectVpnAddress();

    $total=$AddressModel->countaddress();
    $page = new \Org\Page\Page($total, 100);
    $usergroups=$AddressModel->selectaddressByPage($page);
    $show = $page->show();
    // //赋值到模版
    $this->assign('count', $total);//显示总条数
    $this->assign('page', $show);//显示分页

     $this->assign("allAccounts",$count);
    $this->display('Vpn/vpnaddresslist');//将值显示在静态页面上
  }

  public function addVpnAddress(){
   $AddressModel = D('vpnaddress');
   $provinceModel = D('province');
   // $cityModel = D('city');

    $option=$AddressModel->select();
    $province=$provinceModel->select();

    // $city=$cityModel->select();
    

    $this->assign("province",$province);
    $this->assign("city",$city);
    $this->assign("allEquipment",$option);
    $this->display('Vpn/addVpnAddress');//将值显示在静态页面上
  }

  public function vpnAddressStore(){
     $provinceModel = D('province');
     $cityModel = D('city');
     $title=I("title");
     $address_city=I("title1");

     $address_url=I("address_url");
    

     $data['address_url']=$address_url;

     $a['id']=$title;
     $b['id']=$address_city;
     $rel=$provinceModel->where($a)->find();
     $rel1=$cityModel->where($b)->find();
     $data['address_addr']=$rel['province'];
      $data['address_city']=$rel1['city'];

    $AddressModel = D('vpnaddress');

     $value = $AddressModel->addVpnAddress($data);
     if ($value) {
        $this->success(L('添加成功'), U('Vpnaddress/showvpnaddress'));
     } else {
        $this->error(L('添加失败'));
     }
  }
// 删除vpn地址
   public function deletevpnaddress(){
   $AddressModel = D('vpnaddress');
    $address_id=I('address_id');
     $value = $AddressModel->deletevpnaddressById($address_id);
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
  }
  // 批量删除账号
   public function deleteaddrs(){
       $AddressModel = D('vpnaddress');
        $address_id=I('ids');
        $a['address_id'] = array('in',$address_id);
       
        $value = $AddressModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
//将编辑的内容显示出来
    public function editvpnaddress(){
        $AddressModel = D('vpnaddress');
        $provinceModel = D('province');
        $cityModel = D('city');

        $province=$provinceModel->select();

        $city1=$cityModel->select();

        $pr['province'] = I('address_addr');
        $ci['city'] = I('address_city');
        $cityid = $cityModel->where($ci)->find();
        
        // $ci_id = $cityid['id'];
        $provincevalue=$provinceModel->where($pr)->find();
        // $pr_id = $provincevalue['id'];
        $ci1['fatherID'] = $provincevalue['provinceid'];
        $city=$cityModel->where($ci1)->select();
        $address_id = I('address_id');//相当于 $_GET['wei_id']
        // $address_addr = I('address_addr');
        // $address_city = I('address_city');

        $data['address_id']= $address_id;
        // $data['address_addr']= $address_addr;
        // $data['address_city']= $address_city;
        $result = $AddressModel->where($data)->find();
        $ID = ['ci_id'=>$cityid['id'],'pr_id'=>$provincevalue['id']];
        // dump($result);die;
        $this->assign("city",$city);
        $this->assign("id",$ID);
        $this->assign("province",$province);
        $this->assign('data',$result);
        $this->display('Vpn/editvpnaddress');
    }

    // 保存编辑好的vpn账号
public function saveEdit(){
      if (IS_POST) {
            $provinceModel = D('province');
            $cityModel = D('city');
            //接受POST传递过来的参数
            $address_id = I('address_id');
            $address_url = I('address_url');
            $pr_id['id'] = I('address_addr');
            $ci_id['id'] = I('address_city');
            // dump($pr_id);die;
            $pr_name = $provinceModel->where($pr_id)->find();

            $address_addr = $pr_name['province'];

            $ci_name = $cityModel->where($ci_id)->find();
            $address_city = $ci_name['city'];
            // dump($ci_id);die;
            // dump($address_addr);dump($address_city);die;
            //封装数据
            $data['address_url'] = $address_url;
            $data['address_id'] = $address_id;
            $data['address_addr'] = $address_addr;
            $data['address_city'] = $address_city;

            // dump($data);die;
            $AddressModel = D('vpnaddress');
            $result = $AddressModel->save($data);
            //返回编辑结果
            if ($result) {
                $this->success(L('修改成功'), U('Vpnaddress/showvpnaddress'));
            } else {
                $this->error(L('修改失败'));
            }
        } else{
            //接受GET传递过来的参数
             $address_id = I('address_id');
            //实列化Tasks模型
             $AddressModel = D('vpnaddress');
            //查找任务表中account_id为$account_Id的一条数据
            $taskgroup = $AddressModel->selectaddressById($address_id);
            //赋值到模版
            // $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
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
       // var_dump($province['provinceid']);
        $cityMode = D('city');
        $a['fatherID'] = $province['provinceid'];
        $aa = $cityMode->where($a)->select();
        // var_dump($aa);
        $value = '';
        foreach ($aa as $vo){
            $value .= "<option value=".$vo['id'].">".$vo['city']."</option>";
        }
       // $value = "<select  name='title' lay-verify='required' >".$value."</select>";
        $datas = ['error' => 1,'value'=>$value];

        echo json_encode($datas);

    }
}