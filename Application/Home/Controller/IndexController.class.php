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
	    $where['b.status'] = 1;
	    $where['ad_type'] = 1;
	    $field = 'a.id,a.ch_title as title,a.ch_img as img';
	    $table = 'DocumentAds';
	    $ads = $this->index_lists($table,$where,$field,'level desc',10);
	    $this->assign('ads',$ads);
	    unset($where);
	    //获取创客活动
	    $where['b.status'] = 1;
	    $field = 'a.id,a.ch_title as title,a.ch_content as content,b.cover_id';
	    $table = 'DocumentActivity';
	    $activitys = $this->index_lists($table,$where,$field);
	    $this->assign('activitys',$activitys);
	    unset($where);
		//获取1566项目
	    $where['is_1566'] = 1;
	    $field = 'a.id,a.ch_title as title,a.cover_url';
	    $table = 'DocumentProject';
	    $projects = $this->index_lists($table,$where,$field);
	    $this->assign('projects',$projects);
	    unset($where);
	    //获取各界关注
	    $where['b.status'] = 1;
	    $field = 'a.id,a.ch_title as title,b.cover_id';
	    $table = 'DocumentAttentions';
	    $attentions = $this->index_lists($table,$where,$field);
	    $this->assign('attentions',$attentions);
        $this->display();
    }

	public function about(){
		//获取广告
		$where['b.status'] = 1;
		$where['ad_type'] = 2;
		$field = 'a.id,a.ch_title as title,a.ch_img as img';
		$table = 'DocumentAds';
		$ads = $this->index_lists($table,$where,$field,'level desc',10);
		$this->assign('ads',$ads);
		$this->display();
	}

	public function a(){
		echo $_GET['l'];

		echo C('DEFAULT_LANG');
		echo L('_MODULE_NOT_EXIST_');
		$this->display('index_old');
	}
}