<?php
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class CompanyController extends BaseController{
	
	public function _initialize(){
		parent::_initialize();

		$this -> catecompany = D('Catecompany');
	}

	public function complist(){
		$cate_id = $_GET['cate_id'];
		if ( isset($cate_id) ) {
			$where['cate_id'] = $cate_id;
			$count = $this -> catecompany -> where($where) -> count();
			$this -> assign('count', $count );
			if (isset($count)) {
				$res = $this -> catecompany-> where($where) -> field('id,name,logo') -> select();
				if (isset($res)) {
					$this -> assign('complist', $res);
				}
			}
		}
		$this -> display();
	}

	public function company(){
		
		$id = $_GET['id'];
		
		if ( isset($id) ) {
			
			$res = $this->catecompany -> where(array('id'=>$id)) -> select();

			if (isset($res)) {
				$this -> assign('comp', $res[0]);
			}
		}
		$this -> display();
	}

	public function ourinfo(){
		$type = $_GET['type'];
		$id = $_GET['id'];

		$res = $this -> catecompany -> field('id,name,'.$type) -> where(array('id'=>$id))->select();
		
		if (isset($res)) {
			$this -> assign('comp',$res[0]);
		}
		$this -> display();
	}
	
}