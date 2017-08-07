<?php

$routers = array();
$routers['/wechat/oauth2'] = array('WechatBundle\Wechat', 'oauth');
$routers['/wechat/callback'] = array('WechatBundle\Wechat', 'callback');
$routers['/wechat/curio/callback'] = array('WechatBundle\Curio', 'callback');
$routers['/wechat/curio/receive'] = array('WechatBundle\Curio', 'receiveUserInfo');
$routers['/wechat/jssdk/config/js'] = array('WechatBundle\Wechat', 'jssdkConfigJs');
$routers['/ajax/post'] = array('CampaignBundle\Api', 'form');
$routers['/'] = array('CampaignBundle\Page', 'index');
$routers['/clear'] = array('CampaignBundle\Page', 'clearCookie');
$routers['/api/createPic'] = array('CampaignBundle\Api', 'createPic');
$routers['/api/submit'] = array('CampaignBundle\Api', 'submit');
$routers['/api/checkSubmit'] = array('CampaignBundle\Api', 'checkSubmit');
$routers['/sharePic'] = array('CampaignBundle\Page', 'sharePic');
$routers['/login'] = array('CampaignBundle\Page', 'login');
$routers['/test'] = array('CampaignBundle\Api', 'test');
