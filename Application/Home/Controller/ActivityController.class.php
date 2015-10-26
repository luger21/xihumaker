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

	public function detail()
	{

		$info = $this->article_detail($_GET['id']);
		$info['address'] = $info['ch_address'];
		$info['title'] = $info['ch_title'];
		$info['content'] = $info['ch_content'];
		$this->assign('info', $info);
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
			if(empty($new_list[$key]['cover_url']))
				$new_list[$key]['cover_url'] = __ROOT__.'/Public/Home/images/img1.png';
			$new_list[$key]['title'] = $value['title'];
			$new_list[$key]['description'] = $value['description'];
			$new_list[$key]['year'] = date('Y年',$value['create_time']);
			$new_list[$key]['month'] = date('m月d日',$value['create_time']);
		}
		//print_r($new_list);

		$nextlist = $this->lists($p+1);
		if(count($nextlist)>0)
			$data['haspage'] = 1;
		else
			$data['haspage'] = 0;
		$data['list'] = $new_list;
        echo json_encode($data);
	}

}