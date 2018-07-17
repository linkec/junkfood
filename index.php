<?php
// $redis = new Redis();

	error_reporting(E_ALL ^ E_NOTICE);
	@ini_set('display_errors', 'On');
	
$arr = explode('?',$_SERVER['REQUEST_URI']);
$route = explode('/',$arr[0]);
switch($route[1]){
	case'announce':
		//广播
		$info_hash = md5($_GET['info_hash']);
		$device = $_GET['device'];
		$netType = $_GET['device'];
		$host = $_GET['host'];
		$version = $_GET['version'];
		$tag = $_GET['tag'];
		$peer_id = uniqid();
		
		$roomDir = 'peers/'.hashDir($info_hash);
		makeDir($roomDir);
		insertPeer(
			$roomDir,
			array(
				"id"=>$peer_id,
				"Ip"=>"",
				"Browser"=>"",
				"Device"=>$device,
				"Host"=>$host,
				"Source"=>0,
				"P2p"=>0,
				"ErrsFragLoad"=>0,
				"ErrsBufStalled"=>0,
				"ErrsInternalExpt"=>0
			)
		);
		$out = array(
			'peer_id'=>$peer_id,
			'report_limit'=>10,
			'report_interval'=>15,
			'heartbeat_interval'=>17,
			'peers'=>get_peers($roomDir,$peer_id),
		);
		echo json_encode($out);
		break;
	case'get_peers':
		$info_hash = md5($_GET['info_hash']);
		$peer_id = $_GET['peer_id'];
		$roomDir = 'peers/'.hashDir($info_hash);
		$out = array(
			'peers'=>get_peers($roomDir,$peer_id),
		);
		echo json_encode($out);
		break;
	case'heartbeat':
		$info_hash = md5($_GET['info_hash']);
		$peer_id = $_GET['peer_id'];
		$roomDir = '/peers/'.hashDir($info_hash);
		touch(__DIR__ .$roomDir.$peer_id);
		break;
}
function insertPeer($room,$info){
	file_put_contents($room.$info['id'],json_encode($info));
}
function get_peers($room,$exclude=''){
	$arr = glob(__DIR__ . '/' .$room . '*');
	if($arr){
		$out = array();
		$expTime = time()-30;
		foreach($arr as $v){
			if(filemtime($v)>$expTime){
				if($v!=__DIR__ . '/' .$room . $exclude){
					$out[] = json_decode(file_get_contents($v));
				}
			}else{
				unlink($v);
			}
		}
		return $out;
	}else{
		return array();
	}
}
function makeDir($path){
	if(!is_dir($path)){
		$str = dirname($path);
		if($str){
			makeDir($str.'/');
			@mkdir($path,0777);
			chmod($path,0777);
		}
	}
}
function hashDir($hash){
	$dir1 = substr($hash,0,1);
	$dir2 = substr($hash,1,2);
	return "$dir1/$dir2/";
}
function cleanSession($dir){
	// glob(__DIR__ . $dir);
	var_dump(glob(__DIR__ .$dir));
}
?>