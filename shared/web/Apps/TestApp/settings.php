<?php
$UTILS_DIR= "/share/Public/Autoran/Apps/Utils";
$APP_DIR= dirname(dirname(dirname(__FILE__)));
require_once($UTILS_DIR."/settings.php");

$GLOBALS['settings']['appname']='TestApp';
$GLOBALS['settings']['logs']='/share/Public/Autoran/TestApp.log';
$GLOBALS['settings']['mainerrorlog']='/share/Public/Autoran/TestApp.Error.log';
require_once($UTILS_DIR."/commons.php");

$uidAndGroup = findUserId();
$isAdmin = isAdmin($uidAndGroup);
if(!$isAdmin){
    notAuthorized();
}
?>
