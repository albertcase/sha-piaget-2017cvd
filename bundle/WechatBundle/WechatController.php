<?php
namespace WechatBundle;

use Core\Controller;

class WechatController extends Controller
{

	public function callbackAction()
	{
		$request = $this->request;
		$fields = array(
			'redirect_uri' => array('notnull', '120'),
			'code' => array('notnull', '121'),
		);
		$request->validation($fields);
		$redirect_uri = $request->query->get('redirect_uri');
		$code = $request->query->get('code');
		$url = urldecode($redirect_uri);
		$wechatUserAPI = new \Lib\WechatAPI();

		$access_token = $wechatUserAPI->getSnsAccessToken($code, APPID, APPSECRET);

		if(isset($access_token->openid)) {
			$param = array();
			if($access_token->scope == 'snsapi_base') {
				$userAPI = new \Lib\UserAPI();
				$user = $userAPI->userLogin($access_token->openid);
				if(!$user) {
					$userAPI->userRegister($access_token->openid);
				}
			} 
			if($access_token->scope == 'snsapi_userinfo') {
				$param['openid'] = $access_token->openid;
				$param['access_token'] = $access_token->access_token;
			}
			$this->redirect($url);
		}
	}

	/**
	 * JSSDK JS
	 */
	public function jssdkConfigJsAction()
	{
		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$debug = isset($_GET['debug']) ? (bool)$_GET['debug'] : false;
	  	//$this->hostValid($url);
	  	$config = $this->jssdkConfig($url, $debug);
	  	header("Content-type: application/json");
	  	return $this->Response($config);
	}

	public function jssdkConfig($url, $debug = false)
	{
		$RedisAPI = new \Lib\RedisAPI();
		$jsapi_ticket = $RedisAPI->getJSApiTicket();
		$wechatJSSDKAPI = new \Lib\JSSDKAPI();
		return $wechatJSSDKAPI->getJSSDKConfig(APPID, $jsapi_ticket, $url, $debug);
	}

	public function clearCookieAction() {
		setcookie('_user', json_encode($user), time(), '/');
		$this->statusPrint('success');
	}

	public function hostValid($url, $type = OAUTH_ACCESS)
	{
		$parse_url = parse_url($url);
		if(!isset($parse_url['host'])) {
			$this->statusPrint('101', 'the host is invalid');
		}
		if(!in_array(preg_replace('/^.*?\./', '', $parse_url['host'], 1), (array)json_decode($type))) {
			$this->statusPrint('101', 'the host is invalid');
		}
	}
}
