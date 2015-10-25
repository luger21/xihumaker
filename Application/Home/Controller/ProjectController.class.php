<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class ProjectController extends HomeController {
	protected function _initialize(){
		$_GET['category'] = 2;
	}

	private $table = 'DocumentProject';


	//系统首页
    public function index(){
	    if($_GET['p_status'])
	        $where['p_status'] = $_GET['p_status'];
	    $field = 'id,ch_title as title,ch_content as content,cover_url,p_status,begin_time';
	    $list = $this->pro_lists($this->table,$where,$field);
	    $this->assign('list',$list);//列表
	    $this->assign('p_name',$this->p_name);
        $this->display();
    }

	//翻页api接口
	public function api(){
		if($_GET['p_status'])
			$where['p_status'] = $_GET['p_status'];
		$p = $_GET['p']?$_GET['p']:0;
		$field = 'id,ch_title as title,ch_content as content,cover_url,p_status,begin_time';
		$table = 'DocumentProject';
		$list = $this->pro_lists($this->table,$where,$field,$p);
		foreach($list as $key=>$value){
			$new_list[$key]['id'] = $value['id'];
			$new_list[$key]['cover_url'] = get_cover($value['cover_url'], 'path');
			$new_list[$key]['title'] = $value['title'];
			$new_list[$key]['begin_time'] = $value['begin_time'];
			$new_list[$key]['p_name'] = $this->p_name[$value['p_status']];
		}
		//print_r($new_list);
        echo json_encode($new_list);
	}

}