<?php
/**
 * Created by PhpStorm.
 * User: occur
 * Date: 2017/7/9
 * Time: 18:49
 */
namespace Admin\Controller;

use Think\Controller;

class ShopController extends SuperController {
  public function Shops(){
    $WechaModel = D('Shop');//查找数据表shop
    $count=$WechaModel->selectShops();
    $total=$WechaModel->countShops();
    $page = new \Org\Page\Page($total, 100);
    $usergroups=$WechaModel->selectShopsByPage($page);
    $show = $page->show();

// 计算剩余天数
    // $currentTime=time();
    // $delivery_time=$WechaModel->getField("delivery_time");//获取预计收货时间
    // $data['delivery_time']=$delivery_time;
    // $cnt=$currentTime-$data['delivery_time'];//与已知时间的差值  
    // $days = floor($cnt/(3600*24));//算出天数 
    // $this->assign('days',$days);


    //赋值到模版
    $this->assign('usergroups', $usergroups);
    $this->assign('count', $total);//显示总条数
    $this->assign('page', $show);//显示分页
    $this->display('Shop/listshops');//将值显示在静态页面上
  }

  public function deleteshop(){
    $WechaModel = D('Shop');//查找数据表shop
    $id=I('id');
     $value = $WechaModel->deleteShopById($id);
        if($value){
            $this->success(L('删除成功'));
        }else{
            $this->error(L('删除失败'));
        }
  }

    public function deleteshops(){
        $WechaModel = D('Shop');
        $id=I('ids');
        $a['id'] = array('in',$id);
        $value = $WechaModel->where($a)->delete();
        if ($value){
            echo 1;
            die;
        }
        echo 2;
    }
    //将编辑的内容显示出来
    public function showShopDetails(){
     $WechaModel = D('Shop');
        $id = I('id');//相当于 $_GET['wei_id']
        // dump($wei_id);
        $data['id']= $id;
        $Weicha = $WechaModel->where($data)->find();
        // dump($Weicha['comment']);
        $this->assign('data',$Weicha);
        // $this->assign('number',$wei_number);
        $this->display('Shop/editshop');
    }

    // 编辑店铺
    public function editshop(){
      if (IS_POST) {
            //接受POST传递过来的参数
            $id = I('id');
            $shop_name = I('shop_name');
            $delivery_time = I('delivery_time');
            $order_number = I('order_number');
            $order_details = I('order_details');
            //封装数据
            $data['shop_name'] = $shop_name;
            $data['delivery_time'] = $delivery_time;
             $data['order_number'] = $order_number;
            $data['order_details'] = $order_details;
            $WechaModel = D('Shop');
            $result = $WechaModel->saveShop($id,$data);
            // dump($data);
            // dump($results);
            // die;
            //返回编辑结果
            if ($result) {
                $this->success(L('修改成功'), U('Shop/shops'));
            } else {
                $this->error(L('修改失败'));
            }
        } else{
            //接受GET传递过来的参数
            $id = I('id');
            //实列化Tasks模型
             $WechaModel = D('Shop');
            //查找任务表中task_id为$taskId的一条数据
            $taskgroup = $WechaModel->selectShopById($id);
            //赋值到模版
            $this->assign('taskgroup', $taskgroup);
            $this->display();
        }
    }
//添加店铺
    public function shopStore(){
      $shop_name=I('shop_name');
       $delivery_time=I('delivery_time');
       $order_number=I('order_number');
       $order_details=I('order_details');
       $data['shop_name'] = $shop_name;
       $data['delivery_time'] = $delivery_time;
        $data['order_number'] = $order_number;
       $data['order_details'] = $order_details;
       $WechaModel = D('Shop');
       $value = $WechaModel->addShop($data);
        if ($value) {
            $this->success(L('添加成功'), U('Shop/shops'));
        } else {
            $this->error(L('添加失败'));
        }
    }

    //通过店铺名查询
    public function shopSearch(){
      $WechaModel = D('Shop');//查找数据表shop
      $WeichatModel = D('weichat');//查找数据表weichat
      $id = I('id');

      if(empty($id)){
        $shop = $WechaModel->order('id')->find();
        $a['shop_name'] = $shop['shop_name'];
        $con = $WeichatModel->where($a)->select();
      }else{
        $a['id'] = $id;
        $shop = $WechaModel->where($a)->find();
        $data['shop_name'] = $shop['shop_name'];
        $con = $WeichatModel->where($data)->select();
      }
      $val = $WechaModel->order('id')->select();
      $total=$WeichatModel->selectWeichatTotalSize();
      $page = new \Org\Page\Page($total, 100);
      $shoppages=$WeichatModel->selectWeichatByPage1($page);
      $show = $page->show();

    //赋值到模版
    $this->assign('id',$id);
    $this->assign('shoppages', $shoppages);
    $this->assign('shoppage', $show);//显示分页
      //赋值到模版
      $this->assign('allShops',$val);//下拉列表的店铺显示
      $this->assign('content',$con);
      $this->assign('shop',$shop);
      $this->assign('all',$total);
      $this->display('Shop/shopSearch');//将值显示在静态页面上
    }

// 将订单详情显示出来
     public function showOrderDetails(){
     $WechaModel = D('Shop');
        $id = I('id');//相当于 $_GET['wei_id']
        $data['id']= $id;
        $Weicha = $WechaModel->where($data)->find();
        $this->assign('data',$Weicha);
        $this->display('Shop/editorder');
    }
}