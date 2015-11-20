<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 * 前台公共控制器
 * 为防止多分组Controller名称冲突，公共Controller名称统一使用分组名称
 */
class HomeController extends Controller {
	public $p_name = array(
		1=>'进行中',
		2=>'组团队',
		3=>'组队中',
		4=>'已商业',
		5=>'已结束',
	);

	public $area_name = array(
		1=>'河北省',
		2=>'山西省',
		3=>'辽宁省',
		4=>'吉林省',
		5=>'黑龙江省',
		6=>'江苏省',
		7=>'浙江省',
		8=>'安徽省',
		9=>'福建省',
		10=>'江西省',
		11=>'山东省',
		12=>'河南省',
		13=>'湖北省',
		14=>'湖南省',
		15=>'广东省',
		16=>'海南省',
		17=>'四川省',
		18=>'贵州省',
		19=>'云南省',
		20=>'陕西省',
		21=>'甘肃省',
		22=>'青海省',
		23=>'台湾省',
		24=>'北京市',
		25=>'天津市',
		26=>'上海市',
		27=>'重庆市',
		28=>'广西',
		29=>'内蒙古',
		30=>'西藏',
		31=>'宁夏',
		32=>'新疆',
		33=>'香港',
		34=>'澳门',
	);

	function __construct()
	{
		parent::__construct();
		//获取广告
		$where = array();
		$field = 'a.id,a.ch_title,a.en_title,a.out_url';
		$table = 'DocumentLinks';
		$links = $this->index_lists($table,$where,$field);
		foreach($links as $key=>$val){
			$links[$key]['title'] = $val['ch_title'];
		}

		$this->assign('links',$links);
	}

	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}


    protected function _initialize(){
        /* 读取站点配置 */
        $config = api('Config/lists');
        C($config); //添加配置

        if(!C('WEB_SITE_CLOSE')){
            $this->error('站点已经关闭，请稍后访问~');
        }


    }

	/* 用户登录检测 */
	protected function login(){
		/* 用户登录检测 */
		is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
	}


	/* 首页获取数据 */
	public function index_lists($table,$where,$field='*',$order='level desc',$limit = 3){
		/* 获取当前分类列表 */
		$list = M($table)->table(M($table)->getTableName().' a') ->join('left join xh_document b ON b.id = a.id')->where($where)->field($field)->order($order)->limit($limit)->select();;
		//echo M($table)->getLastSql();exit;
		if(false === $list){
			$this->error('获取列表数据失败！');
		}
		return $list;
	}

	/* 文档模型列表页 */
	public function pro_lists($table,$where,$field='*',$p = 1){
		/* 分类信息 */
		$category = $this->category();
		/* 获取当前分类列表 */
		$list = M($table)->where($where)->page($p, $category['list_row'])->field($field)->order('id')->select();;
		//echo M($table)->getLastSql();
		if(false === $list){
			$this->error('获取列表数据失败！');
		}
		return $list;
		/* 模板赋值并渲染模板 */
		//$this->assign('category', $category);
		//$this->assign('list', $list);
		//$this->display($category['template_lists']);
	}

	/* 文档模型列表页 */
	public function lists($p = 1){
		/* 分类信息 */
		$category = $this->category();

		/* 获取当前分类列表 */
		$Document = D('Document');
		$list = $Document->page($p, $category['list_row'])->lists($category['id'],'level desc');
		if(false === $list){
			$this->error('获取列表数据失败！');
		}
		return $list;
		/* 模板赋值并渲染模板 */
		//$this->assign('category', $category);
		//$this->assign('list', $list);
		//$this->display($category['template_lists']);
	}

	/* 文档分类检测 */
	private function category($id = 0){
		/* 标识正确性检测 */
		$id = $id ? $id : I('get.category', 0);
		if(empty($id)){
			$this->error('没有指定文档分类！');
		}

		/* 获取分类信息 */
		$category = D('Category')->info($id);
		if($category && 1 == $category['status']){
			switch ($category['display']) {
				case 0:
					$this->error('该分类禁止显示！');
					break;
				//TODO: 更多分类显示状态判断
				default:
					return $category;
			}
		} else {
			$this->error('分类不存在或被禁用！');
		}
	}

	/* 文档模型详情页 */
	public function article_detail($id){
		/* 标识正确性检测 */
		if(!($id && is_numeric($id))){
			$this->error('内容ID错误！');
		}

		/* 获取详细信息 */
		$Document = D('Document');
		$info = $Document->detail($id);
		if(!$info){
			$this->error($Document->getError());
		}

		/* 分类信息 */
		$category = $this->category($info['category_id']);


		/* 更新浏览数 */
		$map = array('id' => $id);
		$Document->where($map)->setInc('view');

		return $info;
	}
}
