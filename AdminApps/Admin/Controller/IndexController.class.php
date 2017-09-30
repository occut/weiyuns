<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Controller;

use Think\Controller;

class IndexController extends SuperController {

    /**
     * 展示后台首页
     */
    public function index() {
        //实例化MenuGroup模型
        $uploadModel=D('upload');
        $MenuGroupModel =  D('MenuGroup');
        $con['admin_id']=session('adminId');
        $res=$uploadModel->where($con)->find();
        $ex=explode("|",$res['upload_name']);
        $ex1=explode("|",$res['upload_path']);
//        有上传的头像就用，没有就系统默认的
        if(!empty($ex[1])){
            $path=$ex1[1].$ex[1];
        }else{
            $path='/UploadImages/images/main.jpg';
        }
        //查询首页图标
        $resources = $MenuGroupModel->selectAllMenuGroupByIsHidden(0);
        //赋值模板
        $this->assign('res',$path);
        $this->assign('resources', $resources);
        $this->display('Index/index');
    }

//根据ip获取当前所在位置hj
    public function maps()
    {
        $addr=I('addr');
        $file="http://apis.map.qq.com/ws/location/v1/ip?&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";//根据端ip获取所在位置
        $address = get($file,'array');
        $this->assign('LngLat',$address);
        $this->display("Index/map");
    }

    public function map(){
        $addr=I('addr');
        $file="http://apis.map.qq.com/ws/location/v1/ip?&key=AYTBZ-ZREKJ-ATVF3-FWMEW-FFXC5-CVF5Y";//根据端ip获取所在位置
        $addr = get($file,'array');
        $this->assign('LngLat',$addr);
        $this->display("Index/map");
    }
}
