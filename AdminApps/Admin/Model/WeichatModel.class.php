<?php

/**
 * Functions: .
 * Author: Zhu Jinhao
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */

namespace Admin \ Model;

use Think \ Model;

class WeichatModel extends Model {

    /**
     * 获取文章表中的总条数
     */
    public function selectWeichatTotalSize($id) {
        if($id == 0){
            $result = M('Weichat')->count();
            return $result;
        }else{
            $data['wei_static']= $id;
//            var_dump($id);
            $result = M('Weichat')->where($data)->count();
            return $result;
        }

    }
    /**
     * 分页数据集
     */

    public function selectWeichatByPage($Page,$id) {
        $data['wei_static'] = $id;
        $data['admin_id'] = session('adminId');
        if(session('adminId') == 46){
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }else{
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }
    }
    public function selectWeichatByPage1($Page) {
        $data['wei_static']= 1;
        $data['admin_id'] = session('adminId');
        if(session('adminId') == 46){
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }else{
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }
    }
    public function selectWeichatByPageabnormal($Page) {
        $data['wei_static']= 5;
        $data['admin_id'] = session('adminId');
        if(session('adminId') == 46){
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }else{
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }
    }
    public function selectWeichatByPage2($Page) {
        $data['admin_id'] = session('adminId');
        if(session('adminId') == 46){
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }else{
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }
    }
    public function selectWeichatByPage3($Page) {
        $data['wei_static']= 3;
        $data['admin_id'] = session('adminId');
        if(session('adminId') == 46){
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }else{
            $result = M('Weichat')->order('wei_id')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            return $result;
        }
    }
    /**
     * 查找WebConfig
     */
    public function selectWebConfig() {
        $result = M('Weichat')->find();
        return $result;
    }
    public function selectAllTasks() {
        $result = M('tasks')->select();
        return $result;
    }

    /**
     * 获取每页的数据集
     */
    public function selectByPage($page){
        $result = M('Weichat')->limit($page->firstRow . ',' . $page->listRows)->order('wei_id desc')->select();
        return $result;
    }
}