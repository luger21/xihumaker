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
		$_GET['category'] = 39;
	}

	private $table = 'DocumentProject';


	//系统首页
    public function index(){
	    if($_GET['p_status']>0){
		    $where['p_status'] = $_GET['p_status'];
		    $this->assign('p_status',$_GET['p_status']);
	    }else{
		    $this->assign('p_status',0);
	    }
		$p = $_GET['p']?$_GET['p']:1;
		$where2['model_id'] = 4;
		$list2 = M('Document')->where($where2)->order('level desc')->page($p, 9)->getField('id',true);
		$where['id'] = array('in',$list2);
	    $field = 'id,ch_title as title,ch_content as content,cover_url,p_status,begin_time';
	    $list = $this->pro_lists($this->table,$where,$field,$p);
		//print_r($list2);exit;
		foreach($list2 as $val){
			foreach($list as $key2=>$val2){
				if($val == $val2['id']){
					unset($list[$key2]);
					$list_new[] = $val2;
					continue;
				}
			}
		}
		//exit;
		//print_r($list_new);
	    $this->assign('list',$list_new);//列表
	    $this->assign('p_name',$this->p_name);
	    $nextlist = $this->pro_lists($this->table,$where,$field,$p+1);
	    if(count($nextlist)>0)
		    $haspage = 1;
	    else
		    $haspage = 0;
	    $this->assign('haspage',$haspage);
        $this->display();
    }

	//系统首页
	public function pro1566(){
		$where['is_1566'] = 1;
		if($_GET['p_status'])
			$where['p_status'] = $_GET['p_status'];
		$field = 'id,ch_title as title,ch_content as content,cover_url,p_status,begin_time';
		$list = $this->pro_lists($this->table,$where,$field);
		$this->assign('list',$list);//列表
		$this->assign('p_name',$this->p_name);
		$nextlist = $this->pro_lists($this->table,$where,$field,1);
		if(count($nextlist)>0)
			$haspage = 1;
		else
			$haspage = 0;
		$this->assign('haspage',$haspage);
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

	//翻页api接口
	public function api(){
		if($_GET['is_1566'] == 1)
			$where['is_1566'] = 1;
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
			$new_list[$key]['begin_time'] = date('Y/m/d',$value['begin_time']);
			$new_list[$key]['p_name'] = $this->p_name[$value['p_status']];
			if($key%3==2){
				$new_list[$key]['class'] = 'class="gyli"';
			}
		}

		$nextlist = $this->pro_lists($this->table,$where,$field,$p+1);
		if(count($nextlist)>0)
			$data['haspage'] = 1;
		else
			$data['haspage'] = 0;
		$data['list'] = $new_list;
		echo json_encode($data);
	}

}