<?php
function runShellCommandExec($cmd,$env=null){
    if($env!=null){
        $msg = "commons::runShellCommandExec ".$cmd." ENV NOT SUPPORTED";
        writeLog($msg,LERROR);
        throw new Exception();
    }
    return shell_exec($cmd);


}


function runShellCommandOpen($command,$env=null){

    $process = proc_open(
        $command,
        [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ],
        $pipes,
        null,
        $env
    );

    if (!is_resource($process)) {
        writeLog("Could not create a valid process: ".$command,LERROR);
        return "";
    }

    // This will prevent to program from continuing until the processes is complete
    // Note: exitcode is created on the final loop here
    $status = proc_get_status($process);
    while($status['running']) {
        $status = proc_get_status($process);
    }

    $stdOutput = trim(stream_get_contents($pipes[1]));
    $stdError  = trim(stream_get_contents($pipes[2]));

    proc_close($process);

    if($status['exitcode']!=0){

        if(strlen($stdError)>0){
            $e = new \Exception();
            writeLog("Running ".$command." ExitCode ".$status['exitcode'],LERROR);
            writeLog("StackTrace:\n".$e->getTraceAsString(),LERROR);
            writeLog($stdError,LERROR);
        }else{
            writeLog("Running ".$command." ExitCode ".$status['exitcode']);
        }
    }

    return $stdOutput;
}

function runShellCommand($command, $uid=null,$implode=false,$env = null){
    if($uid==null){
        $uid = $GLOBALS['variables']['uid'];
    }
    $final=[];



    $cmd = $command;
    if(!iAmThisUser($uid)){
        $cmd = $GLOBALS['settings']['sudo']." -u ".$uid." ".$cmd;
    }
    writeLog("commons::runShellCommand ".$cmd,LTRACE);

    $result = runShellCommandOpen($cmd,$env);

    if(canLog(LTRACE))writeLog("result ".$result,LTRACE);

    $partial = preg_split("/[\n\r\f]+/",$result,-1,PREG_SPLIT_NO_EMPTY);
    for($i=0;$i< sizeof($partial);$i++){
        $partial[$i]=trim($partial[$i]);
        if(strlen($partial[$i])>0){
            $final[]=$partial[$i];
        }
    }
    if($implode){
        return implode("\n",$final);
    }
    return $final;
}


function findChildProcesses($ppid){
    $result=[];
    $data = runShellCommand(
        "ps -o pid,ppid,comm,args|grep -E '[0-9]+\\s+".$ppid."\\s+.*' || true",
        $GLOBALS['settings']['admin'],false);

    foreach($data as $pidLine){
        $pidLineExploded = preg_split("/[\s]+/",$pidLine,-1,PREG_SPLIT_NO_EMPTY);
        $result[]=$pidLineExploded[0];
        foreach(findChildProcesses($pidLineExploded[0]) as $chpid){
            $result[]=$chpid;
        }

    }
    return $result;

}

function isPidRunning($pidPath){
    $pid = readFileIfExists($pidPath);
    if ($pid!=null && strlen($pid)>0){
        if (file_exists( "/proc/".$pid )){
            return true;
        }
    }
    $screenId = pathinfo($pidPath)['filename'];
    return runShellCommand(
            $GLOBALS['settings']['screen']." -list|grep  ".$screenId."|cut -f2",
            $GLOBALS['settings']['admin'],true)!="";
}
?>