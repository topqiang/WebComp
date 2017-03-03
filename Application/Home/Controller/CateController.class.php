<?php
namespace Home\Controller;
use Think\Controller;
class CateController extends BaseController{
	public function _initialize(){
		parent::_initialize();
		$this -> navcate = D('Navcate');
	}


	public function catelist(){
		$nav_id = $_GET['id'];
		$navname = $_GET['navname'];
		if (isset($nav_id)) {
			$where['nav_id'] = $nav_id;
			$res = $this -> navcate -> field('id ,name,logourl') -> where($where) ->select();

			if (isset($res)) {
				$this -> assign('catelist',$res);
			}
		}
		$this -> assign('navname', $navname);
		$this -> display();
	}
}