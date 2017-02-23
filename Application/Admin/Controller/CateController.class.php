<?php
namespace Admin\Controller;
use Think\Controller;
class CateController extends Controller{
	public function _initialize(){
		$this->cate=D("Cate");
		$this->navCate=D("Navcate");
		$this->nav=D("Nav");
	}

	public function cateList(){
		if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
		$where['status'] = array('neq' , '9');
		$count = $this ->navCate -> where($where) -> count();
		$page = new \Think\Page($count,15);
		$res=$this ->navCate -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
		$this->assign('list',$res);
		$this->assign('page',$page->show());
		$this->display('cateList');
	}

	public function cateAdd(){
		if(empty($_POST)){
			$where['status'] = array('neq' , '9');
			$res=$this -> nav -> where($where) -> select();
			$this->assign('list',$res);
			$this->display('cateAdd');
		}else{
			$data=array(
				'name'		=>$_POST['name'],
				'nav_id'	=>$_POST['nav_id'],
				'c_time'	=>time(),
				'u_time'	=>time(),
				'status'		=>0,
			);
			$res=$this->cate->add($data);
			if($res){
				$this->success('添加成功',U('Cate/cateList'));
			}else{
				$this->error('添加失败');
			}
		}
	}

	public function cateEdit(){
		if(empty($_GET['id']))$this->error('没有分类id');
		if(empty($_POST)){
			$info=$this->cate->where(array('id'=>$_GET['id']))->select();
			$this->assign('info',$info[0]);
			$where['status'] = array('neq' , '9');
			$res=$this -> nav -> where($where) -> select();
			$this->assign('list',$res);	
			$this->display('cateEdit');
		}else{
			$data=array(
				'id'			=>$_GET['id'],
				'name'			=>$_POST['name'],
				'u_time'	=>time(),
				'nav_id' => $_POST['nav_id']
			);
			$res=$this->cate->save($data);
			if($res){
				$this->success('修改成功',U('Cate/cateList'));
			}else{
				$this->error('修改失败');
			}
		}
	}
	public function cateDel(){
		if(empty($_GET['id']))$this->error('没有商品id');
		
		$res=$this->cate->save(array('id'=>$_GET['id'],'status'=>"9"));
		if($res){
			$this->success('删除成功',U('Cate/cateList'));
		}else{
			$this->error('删除失败');
		}
	}
}