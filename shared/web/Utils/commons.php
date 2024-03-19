<?php
set_time_limit(86400);

$baseDir= dirname(__FILE__);
require_once($baseDir . "/auth.php");
require_once($baseDir . "/exec.php");
require_once($baseDir . "/file.php");
require_once($baseDir . "/http.php");
require_once($baseDir . "/log.php");
require_once($baseDir . "/utils.php");
require_once($baseDir . "/apis.php");

$GLOBALS['variables']['userid']=trim(shell_exec($GLOBALS['settings']['whoami']));

function iAmThisUser($user){
	$whoami = trim(shell_exec($GLOBALS['settings']['whoami']));
	return $whoami == $user;
}


/*

function readPartialFileIfExists(){
	$args = func_get_args();
	$pathArray = array_slice($args,0,sizeof($args)-2);
	$from = $args[sizeof($args)-2]+0;
	$to = $args[sizeof($args)-1]+0;
	$path = "/".ltrim(implode("/",$pathArray),"/");
	
	$fileLines = getFileLines($path);
	
	if($to< 0){
		$from = max(0,$fileLines+$to);
		$to = $fileLines;
	}
	if($from >= $fileLines) return "";
	if($to >= $fileLines) {
		$to = $fileLines-1;
	}
	if(!is_file($path)) return null;
	$cmd = $GLOBALS['settings']['sed']." -n ".($from+1).",".($to+1)."p ".$path;
	if(!iAmThisUser($GLOBALS['settings']['admin'])){
		$cmd = $GLOBALS['settings']['sudo']." -u ".$GLOBALS['settings']['admin']." ".$cmd;
	}
	
	return trim(shell_exec($cmd));
}


function tailExists(){
	$args = func_get_args();
	$pathArray = array_slice($args,0,sizeof($args)-2);
	$from = $args[sizeof($args)-2]+0;
	$to = $args[sizeof($args)-1]+0;
	$path = "/".ltrim(implode("/",$pathArray),"/");
	
	$fileLines = getFileLines($path);
	if($from >= $fileLines) return "";
	if($to >= $fileLines) {
		$to = $fileLines-1;
	}
	if(!is_file($path)) return null;
	$cmd = $GLOBALS['settings']['sed']." -n ".($from+1).",".($to+1)."p ".$path;
	if(!iAmThisUser($GLOBALS['settings']['admin'])){
		$cmd = $GLOBALS['settings']['sudo']." -u ".$GLOBALS['settings']['admin']." ".$cmd;
	}
	
	return trim(shell_exec($cmd));
}
*/










