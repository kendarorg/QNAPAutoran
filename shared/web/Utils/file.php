<?php
function getTempPath(){
    $path = trim(implode("_",func_get_args()),"/");
    return rtrim(sys_get_temp_dir() . "/" .$path,"/");
}

function getFileLines(){
    $args = func_get_args();
    $path = "/".ltrim(implode("/",$args),"/");
    if(!is_file($path)) return 0;
    $cmd = $GLOBALS['settings']['wc']." -l ".$path;
    if(!iAmThisUser($GLOBALS['settings']['admin'])){
        $cmd = $GLOBALS['settings']['sudo']." -u ".$GLOBALS['settings']['admin']." ".$cmd;
    }
    $result = trim(shell_exec($cmd));
    return preg_split("/[\s]+/",$result,-1,PREG_SPLIT_NO_EMPTY)[0]+0;
}

function readFileIfExists(){
    $path = "/".ltrim(implode("/",func_get_args()),"/");

    if(!is_file($path)) return null;
    $cmd = $GLOBALS['settings']['cat']." ".$path;
    if(!iAmThisUser($GLOBALS['settings']['admin'])){
        $cmd = $GLOBALS['settings']['sudo']." -u ".$GLOBALS['settings']['admin']." ".$cmd;
    }

    return trim(shell_exec($cmd));
}
?>