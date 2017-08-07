<?php
namespace Lib;
/**
 * DatabaseAPI class
 */
class DatabaseAPI {

	private $db;

	private function connect() {
		$connect = new \mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
		$this->db = $connect;
		$this->db->query('SET NAMES UTF8');
		return $this->db;
	}

	/**
	 * 存储图片
	 */
	public function saveImage($uid, $image) {
		$nowtime = NOWTIME;
		$sql = "INSERT INTO `image` SET `uid` = ?, `url` = ?, `created` = ?";
        $res = $this->connect()->prepare($sql);
        $res->bind_param("sss", $uid, $image, $nowtime);
		if($res->execute()) 
			return $res->insert_id;
		else 
			return FALSE;
	}

	/**
	 * 查询图片
	 */
	public function getImage($uid) {
		$sql = "SELECT `id`, `url` FROM `image` WHERE `uid` = ?"; 
		$res = $this->connect()->prepare($sql);
		$res->bind_param("s", $uid);
		$res->execute();
		$res->bind_result($id, $url);
		if($res->fetch()) {
			$image = new \stdClass();
			$image->id = $id;
			$image->url = $url;
			return $image;
		}
		return FALSE;
	}

	public function getImageByPid($pid) {
		$sql = "SELECT `uid`, `url` FROM `image` WHERE `id` = ?"; 
		$res = $this->connect()->prepare($sql);
		$res->bind_param("s", $pid);
		$res->execute();
		$res->bind_result($uid, $url);
		if($res->fetch()) {
			$image = new \stdClass();
			$image->uid = $uid;
			$image->url = $url;
			return $image;
		}
		return FALSE;
	}

	/**
	 * 保存信息
	 */
	public function saveSubmitInfo($info) {
		$nowtime = NOWTIME;
		$sql = "INSERT INTO `submit` SET `uid` = ?, `taTitle` = ?, `taName` = ?, `taTel` = ?, `taAddress` = ?, `ownTitle` = ?, `ownName` = ?, `ownTel` = ?, `ownEmail` = ?, `created` = ?";
        $res = $this->connect()->prepare($sql);
        $res->bind_param("ssssssssss", $info->uid, $info->taTitle, $info->taName, $info->taTel, $info->taAddress, $info->ownTitle, $info->ownName, $info->ownTel, $info->ownEmail, $nowtime);
		if($res->execute()) 
			return $this->findSubmitByUid($info->uid);
		else 
			return FALSE;
	}

	/**
	 * 查找用户是否提交过信息
	 */
	public function findSubmitByUid($uid) {
		$sql = "SELECT `id` FROM `submit` WHERE `uid` = ?"; 
		$res = $this->connect()->prepare($sql);
		$res->bind_param("s", $uid);
		$res->execute();
		$res->bind_result($id);
		if($res->fetch()) {
			return $id;
		}
		return FALSE;
	}
	
	/**
	 * Create user in database
	 */
	public function insertUser($userinfo){
		$nowtime = NOWTIME;
		$nickname = isset($userinfo->nickname) ? $userinfo->nickname : '';
		$sex = isset($userinfo->sex) ? $userinfo->sex : '';
		$city = isset($userinfo->city) ? $userinfo->city : '';
		$province = isset($userinfo->province) ? $userinfo->province : '';
		$country = isset($userinfo->country) ? $userinfo->country : '';
		$headimgurl = isset($userinfo->headimgurl) ? $userinfo->headimgurl : '';
        $sql = "INSERT INTO `user` SET `openid` = ?, `nickname` = ?, `sex` = ?, `city` = ?, `province` = ?, `country` = ?, `headimgurl` = ?, `created` = ?, `updated` = ?";
        $res = $this->connect()->prepare($sql);
        $res->bind_param("sssssssss", $userinfo->openid, $nickname, $sex, $city, $province, $country, $headimgurl, $nowtime, $nowtime);
		if($res->execute()) 
			return $this->findUserByOpenid($userinfo->openid);
		else 
			return FALSE;
	}

	public function updateUser($userinfo) {
        $userinfo = (object)$userinfo;
		if ($this->findUserByOpenid($userinfo->openid)) {
            $nowtime = NOWTIME;
            $sql = "UPDATE `user` SET `nickname` = ?, `sex` = ?, `city` = ?, `province` = ?, `country` = ?, `headimgurl` = ?, `created` = ?, `updated` = ? WHERE `openid` = ?";
            $res = $this->connect()->prepare($sql);
            $res->bind_param("sssssssss", $userinfo->nickname, $userinfo->sex, $userinfo->city, $userinfo->province, $userinfo->country, $userinfo->headimgurl, $nowtime, $nowtime, $userinfo->openid);
            if($res->execute())
                return $this->findUserByOpenid($userinfo->openid);
		}else{
            $this->insertUser($userinfo);
        }
	}

	public function findUserByOauth($openid) {
		$sql = "SELECT id  FROM `oauth` WHERE `openid` = ?"; 
		$res = $this->db->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid);
		if($res->fetch()) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Create user in database
	 */
	public function findUserByOpenid($openid){
		$sql = "SELECT `uid`, `openid` FROM `user` WHERE `openid` = ?"; 
		$res = $this->connect()->prepare($sql);
		$res->bind_param("s", $openid);
		$res->execute();
		$res->bind_result($uid, $openid);
		if($res->fetch()) {
			$user = new \stdClass();
			$user->uid = $uid;
			$user->openid = $openid;
			return $user;
		}
		return NULL;
	}

	/**
	 * 
	 */
	public function saveInfo($data){
		if($this->findInfoByUid($data->uid)) {
			$this->updateInfo($data);
		} else {
			$this->insertInfo($data);
		}
	} 

	/**
	 * 
	 */
	public function insertInfo($data){
		$nowtime = NOWTIME;
		$sql = "INSERT INTO `info` SET `uid` = ?, `name` = ?, `cellphone` = ?, `address` = ?, `created` = ?, `updated` = ?"; 
		$res = $this->connect()->prepare($sql); 
		$res->bind_param("ssssss", $data->uid, $data->name, $data->cellphone, $data->address, $nowtime, $nowtime);
		if($res->execute()) 
			return $res->insert_id;
		else 
			return FALSE;
	}

	/**
	 * 
	 */
	public function updateInfo($data){
		$nowtime = NOWTIME;
		$sql = "UPDATE `info` SET `name` = ?, `cellphone` = ?, `address` = ?, `updated` = ? WHERE `uid` = ?"; 
		$res = $this->connect()->prepare($sql); 
		$res->bind_param("sssss", $data->name, $data->cellphone, $data->address, $nowtime, $data->uid);
		if($res->execute()) 
			return $this->findInfoByUid($data->uid);
		else 
			return FALSE;
	}

	/**
	 * Create user in database
	 */
	public function findInfoByUid($uid){
		$sql = "SELECT `id`, `name`, `cellphone`, `address` FROM `info` WHERE `uid` = ?"; 
		$res = $this->connect()->prepare($sql);
		$res->bind_param("s", $uid);
		$res->execute();
		$res->bind_result($id, $name, $cellphone, $address);
		if($res->fetch()) {
			$info = new \stdClass();
			$info->id = $id;
			$info->name = $name;
			$info->cellphone = $cellphone;
			$info->$address = $address;
			return $info;
		}
		return NULL;
	}

}
