<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Model;

use Think\Model;

class VpnaddressModel extends Model {
    /**
     *  保存账号
     */
    public function addVpnAddress($vpnaddress){
        $result = M('vpnaddress')->add($vpnaddress);
        return $result;
    }
    
     /**
     * 获取总数
     */
    public function countaddress(){
        $result = M('vpnaddress')->count();
        return $result;
    }
    /**
     * 获取每页的数据集
     */
    public function selectaddressByPage($page){
        $result = M('vpnaddress')->limit($page->firstRow . ',' . $page->listRows)->order('address_id desc')->select();
        return $result;
    }
    /**
     * 删除账号
     */
    /**
     *根据账号的id来删除账号
     */
    public function deletevpnaddressById($address_id){
        $result = M('vpnaddress')->where('address_id ='.$address_id)->delete();
        return $result;
    }
    
    /**
     * 查询角色
     */
    public function selectVpnAddress() {
        $result = M('vpnaddress')->order('address_id')->select();
        return $result;
    }

    /**
     * 根据vpn账号的id来编辑
     */
    public function saveAddress($address_id,$address){
        $result = M('vpnaddress')->where('address_id ='.$address_id)->save($address);
        return $result;
    }
    
/**
     * 根据店铺的id来查找企业店铺
     */
    public function selectaddressById($address_id){
        $result = M('vpnaddress')->where('address_id='.$address_id)->find();
        return $result;
    }
    
}
