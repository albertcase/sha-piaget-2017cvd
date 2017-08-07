<?php
namespace CampaignBundle;

use Core\Controller;

class PageController extends Controller
{
	public function indexAction() {
		return $this->render('index', array());
	}

	public function clearCookieAction() {
		setcookie('_user', '', time(), '/');
		$this->statusPrint('success');
	}

	/**
	 * 分享页面
	 */
	public function sharePicAction() {
		global $user;
        $pid = $_GET['pid'];
		$DatabaseAPI = new \Lib\DatabaseAPI();
        $img = $DatabaseAPI->getImageByPid($pid);
		$image = BASE_URL . $img->url;
        $isMe = 0;
        if($user->uid == $img->uid){
            $isMe = 1;
        } 
        $list = array(
            'pic' => $image,
            'isme' => $isMe
            );
		return $this->render('sharepic', array('list'=>$list));
	}

	/**
     * 模拟登陆
     */
    public function loginAction() { 
    	if(!isset($_GET['openid'])) {
    		$data = array('status' => 2, 'msg' => 'param failed');
    		$this->dataPrint($data);
    	}  
        $openid = $_GET['openid'];
        $userAPI = new \Lib\UserAPI();
        if($userAPI->userLogin($openid)) {
        	$user = $userAPI->userLogin($openid);
        } else {
        	$userAPI->userRegister($openid);
        	$user = $userAPI->userLogin($openid);
        }
        var_dump($user);exit;
        if(isset($user->openid)) {
        	$data = array('status' => 1, 'msg' => 'openid: ' . $user->openid . 'login success'); 
        } else {
        	$data = array('status' => 0, 'msg' => 'login failed');
        }
        $this->dataPrint($data);
    }

}