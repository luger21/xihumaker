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
class BigshotController extends HomeController {

	private $table = 'DocumentBigshot';

	protected function _initialize(){
		$_GET['category'] = 48;

	}
	//系统首页
    public function index(){
	    //获取热门创客
	    $where = '';

	    $field = 'a.id,a.ch_title,a.en_title,a.ch_content,a.en_content,a.cover_url';

	    $list = M($this->table)->table(M($this->table)->getTableName().' a') ->join('left join xh_document b ON b.id = a.id')->where($where)->field($field)->order('level desc')->select();;

	    foreach($list as $key=>$val) {
		    $list[$key]['title'] = $val['ch_title'];
		    $list[$key]['content'] = $val['ch_content'];
	    }

	    $this->assign('list',$list);//列表
        $this->display();
    }

	public function detail()
	{

		$info = $this->article_detail($_GET['id']);
		$info['title'] = $info['ch_title'];
		$info['content'] = $info['ch_content'];
		$this->assign('info', $info);
		//获取相关项目
		$where['maker_id'] = $_GET['id'];
		$field = 'a.id,a.ch_title as title,a.begin_time,a.cover_url';
		$table = 'DocumentProject';
		$projects = $this->index_lists($table,$where,$field);
		$this->assign('projects',$projects);
		$this->assign('p_name',$this->p_name);
		$this->display();
	}

	//翻页api接口
	public function api(){
		if($_GET['area'])
			$where['area'] = $_GET['area'];
		$p = $_GET['p']?$_GET['p']:0;
		$field = 'id,ch_title as title,ch_content as content,cover_url,area';
		$list = $this->pro_lists($this->table,$where,$field,$p);
		foreach($list as $key=>$value){
			$new_list[$key]['id'] = $value['id'];
			$new_list[$key]['cover_url'] = get_cover($value['cover_url'], 'path');
			$new_list[$key]['title'] = $value['title'];
			$new_list[$key]['begin_time'] = $value['begin_time'];
		}
		echo json_encode($new_list);
	}

}