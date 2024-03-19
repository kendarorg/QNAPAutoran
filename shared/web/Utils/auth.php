<?php
function getSid($uid){
    $scriptsPath =dirname(__FILE__);
    $id = guidv4();
    try {
        shell_exec("/usr/local/bin/python " . $scriptsPath . "/getsid.py " . $uid . " > " . $scriptsPath . "/test.txt");
        $result = file_get_contents($scriptsPath . "/test.txt");
        return trim($result);
    }finally{
        shell_exec("rm -f " . $scriptsPath . "/test.txt");
    }
}

function notAuthorized(){
    http_response_code(401);
    echo "Unauthorized";
    die();
}

function findUserId(){
    if(!isset($_SERVER['HTTP_COOKIE'])){
        notAuthorized();
    }
    $cookie = explode(";",$_SERVER['HTTP_COOKIE']);

    foreach($cookie as $coval){
        $val = trim($coval);
        $ar = explode("=",$val);
        $key = trim(trim($ar[0]),"_");
        $value = trim($ar[1]);
        if($key=="NAS_USER"){
            $GLOBALS['variables']['uid']=$value;
            //$groupsResult = runShellCommand("groups ".$value,$GLOBALS['uid'],true);
            $cmd = "groups ".$GLOBALS['variables']['uid'];
            $groupsResult = trim(shell_exec($cmd ));
            $groups = preg_split("/[\s]+/",$groupsResult,-1,PREG_SPLIT_NO_EMPTY);

            return [
                "uid"=>$value,
                "groups"=>$groups
            ];
        }
    }
    notAuthorized();
}

function isAdmin($uidData){
    foreach($uidData["groups"] as $group){
        if(strtolower($group) == $GLOBALS['settings']['admingroup']){
            return true;
        }
    }
    return false;
}

