<?php

function handleCurlError(&$curl)
{
    $error = curl_error($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    writeLog("Curl error [".$httpCode."] ".$error,LERROR);
    http_response_code($httpCode);
}

?>