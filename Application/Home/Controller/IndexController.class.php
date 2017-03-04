<?php
namespace Home\Controller;
use Think\Controller;

/**
 * Class IndexController
 * @package Home\Controller
 */
class IndexController extends BaseController {
    public function _initialize(){
    	parent::_initialize();

        $this -> nav = D('Nav');
        $this -> lnav = D('Lnav');
        $this -> catecompany = D('Catecompany');
        $this -> coocom = D('Coocom');
        $this -> navcate = D('Navcate');
    	//完善购物车数量查询
    }

    public function index(){
        $where['status'] = array('neq', 9);
        $res = $this -> nav -> where($where) -> select();
        $lnav = $this -> lnav -> where($where) -> select();
        foreach ($res as $key => $nav) {
            $numcount = array('nav_id' => array('eq',$nav['id']));
            $res[$key]['compcount'] = $this -> catecompany -> where($numcount) -> count();
            $res[$key]['catecount'] = $this -> navcate -> where($numcount) -> count(); 
        }
        $complist = $this -> coocom-> field('id,logo,href') -> select();
        $this -> assign('lnavlist',$lnav);
        $this -> assign('navlist',$res);
        $this -> assign('complist',$complist);
        $this -> display();
    }


    public function filelist(){
        $id = $_GET['id'];
        if (isset($id)) {
            $lnavati = D('Lnavati');
            
            $res = $lnavati -> where(array('status' => array('neq',9),'nav_id' => $id)) -> select();

            if (isset( $res )) {
                $this -> assign( 'atilist' , $res );
            }

        }
        $this -> display();
    }

    public function atiinfo(){
        $id = $_GET['id'];
        if (isset($id)) {
            $lnavati = D('Lnavati');
            
            $res = $lnavati -> where(array('status' => array('neq',9),'id' => $id)) -> select();

            if (isset( $res )) {
                $this -> assign( 'comp' , $res[0] );
            }
        }

        $this -> display('Company/ourinfo');
    }

}
