<?php

namespace WechatBundle;

use Core\Request;
use Core\Event;

class EventListener 
{
	private $request;

	public function initUser(Event $event)
	{
		if(preg_match('/MicroMessenger/i', $_SERVER['HTTP_USER_AGENT'])) {
			Header('Location:' . 'http://piaget2017cvd.samesamechina.com/compatible.html');
			exit;
		}
		global $user;
		$this->request = $event->getRequest();
		$UserAPI = new \Lib\UserAPI();
		$user = $UserAPI->userLoad();
		$this->authorize();
	}

	private function authorize()
	{
		global $user;
		$authorize_url = json_decode(AUTHORIZE_URL);
        if(!$user->uid) {
        	$request = $this->request;
        	$current_router = $request->getRouter();
        	if(in_array($current_router, $authorize_url)) {
        		$current_url = $request->getUrl(TRUE);
        		$function_name = WECHAT_VENDOR . 'WechatAuthoize';
				call_user_func_array(array($this, $function_name), array($request, $current_url));		
        	}
        }
	}

	private function defaultWechatAuthoize($request, $current_url)
	{
	    $wechatUserAPI = new \Lib\UserAPI();
	    $wechatUserAPI->oauthAction(SCOPE, $current_url);   
	}

	private function curioWechatAuthoize($request, $current_url)
	{
		$request->setSourceUrl($current_url);
		$WechatAPI = new \Lib\CurioWechatAPI();
		$WechatAPI->wechatAuthorize();
	}

}