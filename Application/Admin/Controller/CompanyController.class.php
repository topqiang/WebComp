<?php
namespace Admin\Controller;
use Think\Controller;
class CompanyController extends Controller{
	public function _initialize(){
        $this->company = D('Company');
        $this->cate=D("Cate");
        $this->cateCompany = D('Catecompany');
        header("Content-type: text/html; charset=utf-8");
    }
    /**
     * 菜单列表
     */
    public function companyList(){
    	if(!empty($_POST['name']))$where['name']=array('like','%'.$_POST['name'].'%');
		$where['status'] = array('neq' , '9');
		$count = $this ->cateCompany -> where($where) -> count();
		$page = new \Think\Page($count,15);
		$art_result=$this ->cateCompany -> where($where) -> limit($page->firstRow,$page->listRows) -> select();
        $this->assign('list',$art_result);
		$this->assign('page',$page->show());
        $this->display('companyList');
    }

    /**
     * 添加文章
     */
    public function addCompany(){
    	if (empty($_POST)) {
    		$where['status'] = array('neq' , '9');
			$res=$this ->cate -> where($where) -> select();
			$this->assign('list',$res);
    		$this -> display('addCompany');
    		exit();
    	}else{
	        if(empty($_POST['name']) || empty($_POST['desc'])){
	            $this->error('公司名和描述不能为空');
	        }
	        $data['name'] = $_POST['name'];
	        $data['desc'] = $_POST['desc'];
	        if (!empty($_FILES['logo'])) {
	        	$res = $this -> upload('logo','logo');
	        	if ($res != 'error') {
	        		$data['logo'] = $res;
	        	}else{

	        	}
	        }
	        if (!empty($_FILES['profile'])) {
	        	$res = $this -> upload('profile','pdf');
	        	if ($res != 'error') {
	        		$data['protype'] = $res;
	        	}
	        }else{
        		$data['protype'] = $_POST['protype'];
        	}
	        if (!empty($_FILES['videosrc'])) {
	        	$res = $this -> upload('videosrc','mp4');
	        	if ($res != 'error') {
	        		$data['videosrc'] = $res;
	        	}else{
	        		
	        	}
	        }
	        $data['tel'] = $_POST['tel'];
	        $data['cate_id'] = $_POST['cate_id'];
	        $data['shoplink'] = $_POST['shoplink'];
	        $data['c_time'] = time();
	        $data['u_time'] = time();
	        $result = $this->company->add($data);
	        if($result){
	            $this->success('添加成功','Company/companyList');
	        }else{
	            $this->error('添加失败');
	        }
	    }
    }
    /**
     * 编辑菜单
     */
    public function editArticle(){
        if(empty($_POST)){
            $art_info = $this->article->findArticle(array('art_id'=>$_GET['art_id']));
            $this->assign('art_info',$art_info);
            $this->display('editArticle');
        }else{
            if(empty($_POST['art_title']) || empty($_POST['art_content'])){
                $this->error('您未填写文章标题或内容');
            }
            $where['art_id'] = $_POST['art_id'];
            $data['art_title'] = $_POST['art_title'];
            $data['art_content'] = $_POST['art_content'];
            $result = $this->article->editArticle($where,$data);
            if($result){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
        }
    }
    /**
     * 删除菜单
     */
    public function delArticle(){
        $where['art_id'] = $_GET['art_id'];
        $result = $this->article->deleteArticle($where);
        if($result){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }


    public function upload($filename,$path){
    	$config = array(
            'subName'    =>    $path, //设置文件名
        );
        $upload = new \Think\Upload($config);
	    $upload->maxSize   =     30145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'pdf', 'mp4');// 设置附件上传类型
	    $upload->rootPath  =      './Uploads/' .$path. '/'; // 设置附件上传根目录
	    $upload->saveRule       = !empty($name) ? $name : 'uniqid' ;       //保存文件命名规则
	    // 上传单个文件 
	    $info = $upload->uploadOne($_FILES[$filename]);
	    if(!$info) {// 上传错误提示错误信息
	        return "error";
	    }else{// 上传成功 获取上传文件信息
	        return $info['savepath'].$info['savename'];
	    }
	}
}