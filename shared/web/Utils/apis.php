<?php

function makeQnapApiRequest($url,$data = null,$userId = null){


    klog("Retrieve SID: ",LTRACE);
    $sid = getSid();
    $ch = curl_init();
    if(strpos($url,"?")===false){
        $url=$url."?sid=".$sid;
    }else{
        $url=$url."&sid=".$sid;
    }
    $url = $GLOBALS['settings']['uiport']."/".ltrim($url,"/");

    klog("Curl ".$url." With data: ".$data,LTRACE);
    $headers = [];
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        }
    );
    $headers = [];
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'));
    //NAS_USER='..';

    if($data!=null){
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);
    if($server_output===false){
        handleCurlError($ch);
        curl_close ($ch);
        return null;
    }

    curl_close ($ch);
    return $server_output;
}

function makeQnapAuthenticatedApiRequest($url,$data = null,$userId = null){


    klog("Retrieve SID: ",LTRACE);
    $sid = getSid();
    $ch = curl_init();
    if(strpos($url,"?")===false){
        $url=$url."?sid=".$sid;
    }else{
        $url=$url."&sid=".$sid;
    }
    $url = $GLOBALS['settings']['uiport']."/".ltrim($url,"/");

    klog("Curl ".$url." With data: ".$data,LTRACE);
    $headers = [];
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers)
        {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;

            $headers[strtolower(trim($header[0]))][] = trim($header[1]);

            return $len;
        }
    );
    $headers = [];
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/x-www-form-urlencoded'));
    //NAS_USER='..';

    if($data!=null){
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);
    if($server_output===false){
        handleCurlError($ch);
        curl_close ($ch);
        return null;
    }

    curl_close ($ch);
    return $server_output;
}

?>