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
class ActivityController extends HomeController {
	protected function _initialize(){
		$_GET['category'] = 2;
	}

	//系统首页
    public function index(){

	    $list = $this->lists();
	    $this->assign('list',$list);//列表
	    $this->assign('page',D('Document')->page);//分页
                 
        $this->display();
    }

	//翻页api接口
	public function api(){
		$p = $_GET['p']?$_GET['p']:0;
		$list = $this->lists($p);
		foreach($list as $key=>$value){
			$new_list[$key]['id'] = $value['id'];
			$new_list[$key]['act-icon'] = 'act-icon'.rand(0,4);
			$new_list[$key]['cover_url'] = get_cover($value['cover_id'], 'path');
			$new_list[$key]['title'] = $value['title'];
			$new_list[$key]['description'] = $value['description'];
			$new_list[$key]['create_time'] = $value['create_time'];
		}
		//print_r($new_list);
        echo json_encode($new_list);
	}

}