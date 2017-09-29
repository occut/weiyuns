<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin\Model;

use Think\Model;

class VpnaccountModel extends Model {
    /**
     *  保存账号
     */
    public function addVpnAccount($vpnaccount){
        $result = M('vpnaccount')->add($vpnaccount);
        return $result;
    }
    
     /**
     * 获取总数
     */
    public function countaccount(){
        $result = M('vpnaccount')->count();
        return $result;
    }
    /**
     * 获取每页的数据集
     */
    public function selectaccountByPage($page){
        $result = M('vpnaccount')->limit($page->firstRow . ',' . $page->listRows)->order('account_id desc')->select();
        return $result;
    }
    /**
     * 删除账号
     */
    /**
     *根据账号的id来删除账号
     */
    public function deletevpnaccountById($account_id){
        $result = M('vpnaccount')->where('account_id ='.$account_id)->delete();
        return $result;
    }
    
    /**
     * 查询角色
     */
    public function selectVpnAccount() {
        $result = M('vpnaccount')->select();
        return $result;
    }

    /**
     * 根据vpn账号的id来编辑
     */
    public function saveAccount($account_id,$account){
        $result = M('vpnaccount')->where('account_id ='.$account_id)->save($account);
        return $result;
    }
    
/**
     * 根据店铺的id来查找企业店铺
     */
    public function selectaccountById($account_id){
        $result = M('vpnaccount')->where('account_id='.$account_id)->find();
        return $result;
    }
    
}
