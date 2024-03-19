<?php

setErrorLog();

const LERROR=1;
const LWARNING=2;
const LINFO=3;
const LTRACE=4;

//1 ERROR
//2 WARNING
//3 INFO
//4 ALL

function setErrorLog($path = null){
    if($path==null){
        $path = $GLOBALS['settings']['mainerrorlog'];
    }
    error_reporting(E_ALL);
    ini_set('error_reporting', E_ALL);
    ini_set('log_errors', 'On');
    ini_set('error_log', $path);
}

function canLog($level){
    $logLevel = $GLOBALS['settings']['loglevel']+0;
    return $level<=$logLevel;
}
function writeLog($value,$level=3){
    $logLevel = $GLOBALS['settings']['loglevel']+0;
    $id = "[ERROR]";
    if($level<=$logLevel){
        if($level==1)$id = "[ERROR]";
        if($level==2)$id = "[WARNING]";
        if($level==3)$id = "[INFO]";
        if($level==4)$id = "[TRACE]";

        if(!is_string($value)){
            $value = json_encode($value);
        }
        //error_log(var_export(debug_backtrace()[1],true));
        error_log($id." ".$value);
    }
}

function cleanLogs(){
    runShellCommand($GLOBALS['settings']['find']." ".getTempPath()." -mtime +5 -exec rm {} \; ",
        $GLOBALS['settings']['admin']);
}


function systemLog($data,$level=4){
    runShellCommand(
        $GLOBALS['settings']['writelog']." ".
        "\"[USBRun] ".str_replace('"',"'",$data)."\" ".$level,
        $GLOBALS['settings']['admin']);
}
?>