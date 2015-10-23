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
class AttentionsController extends HomeController {

	//系统首页
    public function index(){

	    $list = $this->lists();
	    print_r($list);
        $this->assign('list',$list);//列表
        $this->assign('page',D('Document')->page);//分页

                 
        $this->display();
    }


}