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
class IndexController extends HomeController {

	//系统首页
    public function index(){
	    //获取广告
	    $_GET['category'] = 42;
	    $where['ad_type'] = 1;
	    $field = 'id,ch_title as title,ch_img as img';
	    $table = 'DocumentAds';
	    $ads = $this->pro_lists($table,$where,$field);
	    $this->assign('ads',$ads);//列表
        $this->display();
    }

	public function about(){

		$this->display();
	}

	public function a(){
		echo $_GET['l'];

		echo C('DEFAULT_LANG');
		echo L('_MODULE_NOT_EXIST_');
		$this->display('index_old');
	}
}