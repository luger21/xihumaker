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
class ResourcesController extends HomeController {

	protected function _initialize(){
		$_GET['category'] = 46;
	}

	//系统首页
    public function index(){
	    $where = '';
	    $field = 'a.id,a.ch_title,a.ch_content,a.en_title,a.en_content';
	    $table = 'DocumentResources';
	    $order = 'b.level DESC';
	    $resources = $this->index_lists($table,$where,$field,$order,10);
	    foreach($resources as $key=>$val){
		    $resources[$key] = $val;
		    $resources[$key]['title'] = $val['ch_title'];
		    $resources[$key]['content'] = $val['ch_content'];
	    }
	    $this->assign('list',$resources);
        $this->display();
    }

	public function detail()
	{
		$info = $this->article_detail($_GET['id']);
		$info['title'] = $info['ch_title'];
		$info['content'] = $info['ch_content'];
		$this->assign('info', $info);
		$this->display();
	}

}