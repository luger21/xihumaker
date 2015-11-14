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
class PagesController extends HomeController {

	protected function _initialize(){
		$_GET['category'] = 47;
	}

	public function detail()
	{
		$info = $this->article_detail($_GET['id']);
		//$info['title'] = $info['ch_title'];
		$info['content'] = $info['ch_content'];
		$this->assign('info', $info);
		$this->display();
	}


}