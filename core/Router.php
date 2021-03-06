<?php

namespace Core;

class Router
{
	private $callback;
	private $param;

	public function __construct($request)
	{
		$this->setCallback($request);
	}

	public function setCallback($request)
	{
		include_once dirname(__FILE__) . "/../config/router.php";
		$server = $request->getServer();
		$current_router = preg_replace('/\?.*/', '', $server['REQUEST_URI']);
		
		if(isset($routers[$current_router])) {
			$callback = $routers[$current_router];
			$parameter = isset($callback[2]) ? $callback[2] : array();
			$this->callback = $callback;
			$this->param = $parameter;
            return;
		}
		foreach($routers as $router => $callback) {
			$pattern = '/' . preg_replace(array('/\//', '/%/'), array('\/', '(.*)'), $router) . '$/';
			if(preg_match($pattern, $current_router, $matches)  && $router != '/') {
				unset($matches[0]);
				$this->callback = $callback;
				$this->param = $matches;
				return;
			}			
		}
	}

	public function getCallback()
	{
		if($this->callback) {
			$class = $this->callback[0] . 'Controller';
			$method = $this->callback[1] . 'Action';
			return array(new $class, $method);			
		} else {
			return NULL;
		}

	}

	public function getCallbackParam()
	{
		$this->param;
	}
}



