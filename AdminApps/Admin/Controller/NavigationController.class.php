<?php
/**
 * Functions: 导航.
 * Author: Li Ming
 * Link: http://www.hfyefan.com
 * Copyright: HfYefan NetWork Co.,Ltd.
 */
namespace Admin\Controller;

use Think\Controller;

class NavigationController extends SuperController{
    /**
     * 显示导航分组界面
     */
    public function listNavigations() {
        //管理员操作记录到日志表中
        $logcontent =C('SYS_LOG_ACTION_SELECT')."导航分组查询成功。";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        $this->display('Navigation/listnavigations');
    }
    //显示设备分组
    public function deviceGrouping(){
        $taskGroupModel = D('TasksGroup');
        $Grouping = D('Grouping');
        $tasks = $Grouping->order('id ASC')->select();
        //获取总的任务数
        $count = $Grouping->selectUserGroupTotalSize();
        //实例化分页类
        $page = new \Org\Page\Page($count,$this->adminPageSize);
        //获取每页显示的数据集
        $tasksGroup = $Grouping->selectGroupingByPage($page);
        //分页显示输出
        $show = $page->show();
        //管理员操作记录到日志表中
        $logcontent =  C('SYS_LOG_ACTION_SELECT')."任务管理查询成功";
        sys_log(session('adminId'),session('adminName'),$logcontent);
        $taskModel = D('Tasks');
        $this->assign('tasksGroup',$tasksGroup);
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->display('Navigation/deviceGrouping');
    }
    /**
     *   添加导航分组大的方法
     */
    public function addNavigation() {
        //实例化Navigation模型
        $NavigationModel = D('Navigation');
        if (IS_POST) {
            //配置名称
            $groupName=I('navname');
            $parentId=I('parentid');
            //附带图片
            $ishidden=I('ishidden');
            $url=I('navigationurl');
            $num=I('urlnum');
            $isout=I('isout');
            $isnewpage=I('isnewpage');
            $navtitle=I('navtitle');
            $navkeywrods=I('navkeywords');

            $navdescription=I('navdescription');
            //配置参数
            $navOrder=I('navorder');
            if(empty($groupName)){
                $this->error('导航分组名不能为空');
            }
            //封装数据
            $data['nav_order']=$navOrder;
            $data['is_out']=$isout;
            $data['is_new_page']=$isnewpage;
            $data['nav_keywords']=$navkeywrods;
            $data['nav_title']=$navtitle;
            $data['nav_description']=$navdescription;
            $data['nav_name'] = $groupName;
            $data['parent_id']= $parentId;
            $data['is_hidden']=  $ishidden;
            $data['nav_url']=$url;
            $data['url_num']=$num;
            $data['admin_id']=session('adminId');
            $result =  $NavigationModel->addNavigation($data);
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."导航分组添加成功。" . "导航分组名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('ADD_NAVGROUP_SUCCESS'), U('Navigation/deviceGrouping'));
            }
            else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_ADD')."导航分组添加成功。" . "导航分组名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('ADD_NAVGROUP_FAILURE'));
            }
        }
        else{
            $this->display('Navigation/addnavigation');
        }
    }

    /**
     * 编辑导航分组的方法
     */
    public function editNavigation() {
        if (IS_POST) {
            //接受POST传递过来的参数
            $navOrder=I('navorder');
            $groupId = I('navid');
            $groupName = I('navname');
            $parentId=I('parentid');
            $num=I('urlnum');
            $url=I('navigationurl');
            $ishidden=I('ishidden');
            $isout=I('isout');
            $isnewpage=I('isnewpage');
            $navtitle=I('navtitle');
            $navkeywrods=I('navkeywords');
            $navdescription=I('navdescription');
            //封装数据
            $data['nav_order']=$navOrder;
            $data['is_out']=$isout;
            $data['is_new_page']=$isnewpage;
            $data['nav_keywords']=$navkeywrods;
            $data['nav_title']=$navtitle;
            $data['nav_description']=$navdescription;
            $data['nav_url']=$url;
            $data['url_num']=$num;
            $data['is_hidden']=$ishidden;
            $data['nav_name'] = $groupName;
            $data['parent_id']=$parentId;
            //实例化Navigation模型
            $NavigationModel = D('Navigation');

            $result =  $NavigationModel->saveNavigation($groupId, $data);
            if ($result) {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."导航分组编辑成功。" . "导航分组名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->success(L('EDIT_NAVGROUP_SUCCESS'), U('Navigation/listnavigations'));
            }
 else {
                //管理员操作记录到日志表中
                $logcontent = C('SYS_LOG_ACTION_MODIFY')."导航分组编辑失败。" . "导航分组名：" . $groupName;
                sys_log(session('adminId'),session('adminName'),$logcontent);

                $this->error(L('EDIT_NAVGROUP_FAILURE'));
            }
        } else{
            //接受GET传递过来的参数
            $groupId = I('navid');

            //实例化Navigation模型
            $NavigationModel = D('Navigation');
            //编辑导航分组navigation_group中group_id为$groupid的一条数据
            $Navigation =$NavigationModel->selectNavigationById($groupId);
//			print_r($Navigation);

            //查找父行业信息
            $parentNavigation =$NavigationModel->selectNavigationById($Navigation['parent_id']);

            //赋值到模版
            $this->assign('navigation', $Navigation);
            $this->assign('parentnavigation',$parentNavigation);
            $this->display();
        }
    }

    /**
     * 删除导航分组的方法
     */
    public function deleteNavigation() {
        //接受GET传递过来的参数
        $groupId = I('navid');

        //实例化Navigation模型
        $navigationModel = D('Navigation');

        //查找导航分组navigation_group中group_id为$groupid的一条数据
        $navigation = $navigationModel->selectNavigationById($groupId);

        //查找导航分组中的parentId
        $groupParentId= $navigationModel->selectNavigationByParentId($groupId);

            if(empty($groupParentId)){

                //删除导航分组
                $del = $navigationModel->deleteNavigationById($groupId);

                if ($del) {
                    //管理员操作记录到日志表中
                    $logcontent = C('SYS_LOG_ACTION_DELETE')."配置删除成功。" . "导航分组名：" . $navigation['nav_name'];
                    sys_log(session('adminId'),session('adminName'),$logcontent);

                    $this->success(L('DELTE_NAVGROUP_SUCCESS'), U('Navigation/listnavigations'));
                } else {
                    //管理员操作记录到日志表中
                    $logcontent = C('SYS_LOG_ACTION_DELETE')."配置删除失败。" . "导航分组名：" .$navigation['nav_name'];
                    sys_log(session('adminId'),session('adminName'),$logcontent);

                    $this->error(L('DELTE_NAVGROUP_FAILURE'));
                }
            }else{
                $this-> error(L('EXIST_SUBPARENTID'));
            }
        }

    //ajax 提交改变ishidden 字段参数
    public function isHidden(){
        if(IS_POST){
            $ishidden=I('ishidden');
            $navId=I('navid');
            //实例化Singlepagemodel类
            $NavigationModel=D('Navigation');
            //封装数据
            $data['is_hidden']= $ishidden;
            //编辑单页表singlepage中singlepage_id为$singlepageId的一条数据
            $result= $NavigationModel->saveNavigation($navId, $data);
            if($result){
                $ishiddens = array(
                    'status' => C('JSON_SUCCESS_CODE'),
                );
            }
            $this->ajaxReturn($ishiddens);
        }
    }


}

