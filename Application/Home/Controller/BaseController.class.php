<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller{
	public function _initialize(){
		$user = session("userid");
		$this -> appid = "wx091dbcec9f34322f";
		$this -> scret = "d4049d17f6780e6cee4f82870a4f3545";
		if (!isset($user)) {
			session("userid",1);
			// $code = session('code');
			// if (!isset($code)) {
			// 	$redirect_uri = "http://www.happydaze.cn/index.php?s=/User/index";
			// 	$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=snsapi_userinfo&state=weixin#wechat_redirect";
			// 	Header("Location: $url");
			// }
			// $this -> display("User/login");
			// exit();
		}else{
			
		}
	}
}