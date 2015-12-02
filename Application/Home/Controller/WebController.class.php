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
class WebController extends HomeController {

	protected function _initialize(){
		$_GET['category'] = 43;
	}

	//系统首页
	public function index(){

		$list = $this->lists();
		foreach($list as $key=>$value){
			$new_list[$key] = $value;
			$detail = $this->article_detail($value['id']);
			$new_list[$key]['title'] = $detail['ch_title'];
			$new_list[$key]['content'] = $detail['ch_content'];
			$new_list[$key]['begin_time'] = $detail['begin_time'];
		}
		$this->assign('list',$new_list);//列表
		$nextlist = $this->lists(1);
		if(count($nextlist)>0)
			$haspage = 1;
		else
			$haspage = 0;
		$this->assign('haspage',$haspage);

		$this->display();
	}

	//系统首页
	public function pro_index(){
		$_GET['category'] = 39;
		$list = $this->lists();
		foreach($list as $key=>$value){
			$new_list[$key] = $value;
			$detail = $this->article_detail($value['id']);
			$new_list[$key]['title'] = $detail['ch_title'];
			$new_list[$key]['content'] = $detail['ch_content'];
			$new_list[$key]['begin_time'] = $detail['begin_time'];
		}

		$where = '';
		$field = 'a.id,a.ch_title,a.ch_content,a.en_title,a.en_content';
		$table = 'DocumentProject';
		$order = 'b.level DESC';
		$pros = $this->index_lists($table,$where,$field,$order,100);
		foreach($pros as $key=>$val){
			$new_list[$key] = $val;
			$new_list[$key]['title'] = $val['ch_title'];
			$new_list[$key]['content'] = $val['ch_content'];
		}
		$this->assign('list',$new_list);//列表
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

	public function pro_detail()
	{
		$_GET['category'] = 39;
		$info = $this->article_detail($_GET['id']);
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
			$new_list[$key] = $value;
			$detail = $this->article_detail($value['id']);
			$new_list[$key]['title'] = $detail['ch_title'];
			$new_list[$key]['content'] = getstr($detail['ch_content'],200);
		}
		$nextlist = $this->lists($p+1);
		if(count($nextlist)>0)
			$data['haspage'] = 1;
		else
			$data['haspage'] = 0;
		$data['list'] = $new_list;
		echo json_encode($data);
	}

	//翻页api接口
	public function pro_api(){
		$_GET['category'] = 39;
		$p = $_GET['p']?$_GET['p']:0;
		$list = $this->lists($p);
		foreach($list as $key=>$value){
			$new_list[$key] = $value;
			$detail = $this->article_detail($value['id']);
			$new_list[$key]['title'] = $detail['ch_title'];
			$new_list[$key]['content'] = getstr($detail['ch_content'],200);
		}
		$nextlist = $this->lists($p+1);
		if(count($nextlist)>0)
			$data['haspage'] = 1;
		else
			$data['haspage'] = 0;
		$data['list'] = $new_list;
		echo json_encode($data);
	}

}