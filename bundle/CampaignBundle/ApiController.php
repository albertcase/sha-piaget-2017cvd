<?php
namespace CampaignBundle;

use Core\Controller;
use GDText\Box;
use GDText\Color;


class ApiController extends Controller
{
    public function __construct() {

    	global $user;

        parent::__construct();

        if(!$user->uid) {
	        //$this->statusPrint('100', 'access deny!');
        } 
    }

    public function testAction() {
       $im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . '/pic/tmp.jpg');
        $imgSize = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/pic/tmp.jpg');
        $imgHight = $imgSize['1']; //750
        $imgWidth = $imgSize['0']; //1206

        //toName
        $boxToname = new Box($im);
        $boxToname->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/pic/pic2.ttf'); 
        // $boxToname->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxToname->setFontSize(12);
        $boxToname->setBox(20, 20, 720, 660);
        $boxToname->setTextAlign('center', 'center');
        $boxToname->draw($this->convertStr('得到的22dd'));
        $name = $this->create_uuid();
        $fileName = './pic/created/' . $name . '.jpg';
        imagejpeg($im, $fileName);
    }
    /**
     * 判断用户是否添加过信息
     */
    public function checkSubmitAction() {
        global $user;
        $DatabaseAPI = new \Lib\DatabaseAPI();
        if($DatabaseAPI->findSubmitByUid($user->uid)) {
            $this->statusPrint('1', 'ok');
        } else {
            $this->statusPrint('0', 'failed');
        }
    }

    /** 
     * 提交信息
     */
    public function submitAction() {
        global $user;

        $request = $this->request;
        $fields = array(
            'taTitle' => array('notnull', '120'),
            'taName' => array('notnull', '120'),
            'taTel' => array('notnull', '120'),
            'taAddress' => array('notnull', '120'),
            'ownTitle' => array('notnull', '120'),
            'ownName' => array('notnull', '120'),
            'ownTel' => array('notnull', '120'),
            'ownEmail' => array('notnull', '120'),
        );
        $request->validation($fields);
        $info = new \stdClass();
        $info->uid = $user->uid;
        $info->taTitle = $request->request->get('taTitle');
        $info->taName = $request->request->get('taName');
        $info->taTel = $request->request->get('taTel');
        $info->taAddress = $request->request->get('taAddress');
        $info->ownTitle = $request->request->get('ownTitle');
        $info->ownName = $request->request->get('ownName');
        $info->ownTel = $request->request->get('ownTel');
        $info->ownEmail = $request->request->get('ownEmail');
        $DatabaseAPI = new \Lib\DatabaseAPI();
        if($DatabaseAPI->findSubmitByUid($user->uid)) {
        	$data = array('status' => 2, 'msg' => '您已经提交过信息！');
            $this->dataPrint($data);
        }
        if($DatabaseAPI->saveSubmitInfo($info)) {
            $data = array('status' => 1, 'msg' => '信息提交成功！');
            $this->dataPrint($data);
        } else {
            $data = array('status' => 0, 'msg' => '信息提交失败！');
            $this->dataPrint($data);
        }
    }

    # 合成图片
    public function createPicAction()
    {

    	global $user;

        $request = $this->request;
        $fields = array(
            'toName' => array('notnull', '120'),
            'toMsg' => array('notnull', '120'),
            'fromName' => array('notnull', '120'),
            'fs' => array('notnull', '120'),
            'isCenter' => array('notnull', '120'),
            'color' => array('notnull', '120'),
        );
        $request->validation($fields);
        $isCenter = $request->request->get('isCenter');
        $textObj = new \stdClass();
        $textObj->toName = $request->request->get('toName');
        $textObj->toMsg = explode(',', $request->request->get('toMsg'));
        $textObj->fromName = $request->request->get('fromName');
        $textObj->fs = $request->request->get('fs') * 2;
        $textObj->isCenter = $request->request->get('isCenter');
        $textObj->color = explode(',', $request->request->get('color'));

        $image = $this->createPic($textObj);
        $DatabaseAPI = new \Lib\DatabaseAPI();

        // if($DatabaseAPI->getImage($user->uid)) {
        //     $data = array(
        //         'status' => 2,  
        //         'msg' => '您已经创建过！',
        //     );
        //     $this->dataPrint($data);
        // }

        $pid = $DatabaseAPI->saveImage($user->uid, $image);
        $iswrite = $DatabaseAPI->findSubmitByUid($user->uid);
        if($iswrite) {
        	$iswrite = 1;
        } else {
        	$iswrite = 0;
        }
        $data = array(
        		'status' => 1,	
                'msg' => '生成成功！',
        		'work_url' => BASE_URL . 'sharePic?pid=' . $pid,
        		'work_img__url' => BASE_URL . $image,
        		'is_write' =>  $iswrite,
        	);
        $this->dataPrint($data);
    }

    private function createPic($textObj)
    {
       $im = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . '/font/tmp.jpg');
        $imgSize = getimagesize($_SERVER['DOCUMENT_ROOT'] . '/font/tmp.jpg');
        $imgHight = $imgSize['1']; //750
        $imgWidth = $imgSize['0']; //1206

        //toName
        $boxToname = new Box($im);
        $boxToname->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/font/pic3.otf'); 
        $boxToname->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxToname->setFontSize($textObj->fs+3);
        $boxToname->setBox(20, 20, 720, 660);
        $boxToname->setTextAlign('center', 'center');
        $boxToname->draw($this->convertStr($textObj->toName));

        //toMsg1
        $boxTomsg1 = new Box($im);
        $boxTomsg1->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/font/pic3.otf'); 
        $boxTomsg1->setFontSize($textObj->fs);
        $boxTomsg1->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxTomsg1->setBox(20, 20, 720, 860);
        $boxTomsg1->setTextAlign('center', 'center');
        $boxTomsg1->draw($this->convertStr($textObj->toMsg['0']));
        //toMsg2
        $boxTomsg2 = new Box($im);
        $boxTomsg2->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/font/pic3.otf'); 
        $boxTomsg2->setFontSize($textObj->fs);
        $boxTomsg2->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxTomsg2->setBox(20, 20, 720, 1040);
        $boxTomsg2->setTextAlign('center', 'center');
        $boxTomsg2->draw($this->convertStr($textObj->toMsg['1']));
        //toMsg3
        $len = mb_strlen($textObj->toMsg['2']);
        if($len >15) {
            $textObj->toMsg['2'] = substr($textObj->toMsg['2'], 0, 15-$len);
        }
        $boxTomsg3 = new Box($im);
        $boxTomsg3->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/font/pic3.otf'); 
        $boxTomsg3->setFontSize($textObj->fs);
        $boxTomsg3->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxTomsg3->setBox(20, 20, 720, 1230);
        $boxTomsg3->setTextAlign('center', 'center');
        $boxTomsg3->draw($this->convertStr($textObj->toMsg['2']));

        //fromName
        $boxFromname = new Box($im);
        $boxFromname->setFontFace($_SERVER['DOCUMENT_ROOT'] . '/font/pic3.otf'); 
        $boxFromname->setFontSize($textObj->fs+3);
        $boxFromname->setFontColor(new Color($textObj->color['0'], $textObj->color['1'], $textObj->color['2']));
        $boxFromname->setBox(20, 20, 500, 880);
        $boxFromname->setTextAlign('right', 'bottom');
        $boxFromname->draw($this->convertStr($textObj->fromName));
        $name = $this->create_uuid();
        $fileName = './upload/' . $name . '.jpg';
        imagejpeg($im, $fileName);
        return 'upload/' . $name . '.jpg';
    }

    /**
     * 解决中文乱码
     */
    private function convertStr($str)
    {
        // $str = preg_replace('# #', " ", $str);
        //去掉苹果手机中文输入法半个空格乱码的问题
        $str = str_replace('\u0026', '', $str);
        return mb_convert_encoding($str, "utf-8");
    }

    /**
     * 生成UUID
     */
    private function create_uuid($prefix = "") 
    { 
        //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $prefix . $uuid;
    }

}
