<?php
namespace Admin\Controller;
use Think\Controller;
class AticalController extends Controller{
	public function _initialize(){
        $this->company = D('Atical');
        $this->cate=D("Lnav");
        $this->lnavcate=D("Lnavati");
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * 菜单列表
     */
    public function aticalList(){
    	if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
		$where['status'] = array('neq' , '9');
		$count = $this ->lnavcate -> where($where) -> count();
		$page = new \Think\Page($count,15);
		$art_result=$this ->lnavcate -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        $this->assign('list',$art_result);
		$this->assign('page',$page->show());
        $this->display('aticalList');
    }

    /**
     * 添加文章
     */
    public function addAtical(){
    	if (empty($_POST)) {
    		$where['status'] = array('neq' , '9');
			$res=$this ->cate -> where($where) -> select();
			$this->assign('list',$res);
    		$this -> display('addAtical');
    	}else{
	        if(empty($_POST['name']) || empty($_POST['desc'])){
	            $this->error('公司名和描述不能为空');
	        }
	        $data['name'] = $_POST['name'];
	        $data['desc'] = $_POST['desc'];

	        $data['nav_id'] = $_POST['nav_id'];
	        $data['c_time'] = time();
	        $data['u_time'] = time();
	        $result = $this->company->add($data);
	        if($result){
	            $this->success('添加成功',U('Atical/aticalList'));
	        }else{
	            $this->error('添加失败');
	        }
	    }
    }
    /**
     * 编辑菜单
     */
    public function editAtical(){
        if(empty($_POST)){
        	$where['status'] = array('neq' , '9');
			$res=$this ->cate -> where($where) -> select();
			$this->assign('list',$res);
            $cominfo = $this->lnavcate->where(array('id'=>$_GET['id'],'stauts'=>array('neq',9)))->select();
            $this->assign('cominfo',$cominfo[0]);
            $this->display('editAtical');
        }else{
            if(empty($_POST['name']) || empty($_POST['desc'])){
	            $this->error('公司名和描述不能为空');
	        }
	        $data['id'] = $_POST['id'];
	        $data['name'] = $_POST['name'];
	        $data['desc'] = $_POST['desc'];
	        $data['nav_id'] = $_POST['nav_id'];
	        $data['u_time'] = time();
	        $result = $this->company->save($data);
	        if($result){
	            $this->success('修改成功',U('Atical/aticalList'));
	        }else{
	            $this->error('修改失败');
	        }
        }
    }
    /**
     * 删除公司
     */
    public function delAtical(){
        if(empty($_GET['id']))$this->error('没有公司id');
		$res=$this->company->save(array('id'=>$_GET['id'],'status'=>"9"));
        if(!empty($res)){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
}