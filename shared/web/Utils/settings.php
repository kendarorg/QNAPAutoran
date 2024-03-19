<?php
function getServerUrl()
{
    $server_name = $_SERVER['SERVER_NAME'];

    if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
        $port = ":$_SERVER[SERVER_PORT]";
    } else {
        $port = '';
    }

    if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
        $scheme = 'https';
    } else {
        $scheme = 'http';
    }
    return $scheme.'://'.$server_name.$port;
}

$GLOBALS['settings']=[
    'appname'=>'Autoran',
	'udevadm'=>'/sbin/udevadm',
	'blkid'=>'/usr/local/sbin/blkid',
	'lsusb'=>'/usr/sbin/lsusb',
	'sudo'=>'/usr/local/sudo/bin/sudo',
	'screen'=>'/usr/sbin/screen',
	'python'=>'/usr/local/bin/python',
	'find'=>'/usr/bin/find',
	'cat'=>'/bin/cat',
	'chmod'=>'/bin/chmod',
	'writelog'=>'/sbin/write_log',
	'whoami'=>'/usr/bin/whoami',
	'sed'=>'/bin/sed',
	'wc'=>'/usr/bin/wc',
	'homes'=>'/share/homes',
	'admin'=>'admin',
	'loglevel'=>'1',
	'admingroup'=>'administrators',
	'uiport'=>getServerUrl(),
	'logs'=>'/share/Public/Autoran/Autoran.log',
    'mainerrorlog'=>'/share/Public/Autoran/Autoran.Error.log'
];
$GLOBALS['variables']=[
    'userid'=>'',
    'uid'=>''
];

//Should load them from a dumb file