#!/bin/sh

CONF=/etc/config/qpkg.conf
QPKG_NAME=Autoran
QPKG_ROOT=`/sbin/getcfg $QPKG_NAME Install_Path -f ${CONF}`
#APACHE_ROOT=`/sbin/getcfg SHARE_DEF defWeb -d Qweb -f /etc/config/def_share.info`
SCRIPT_STORE_PATH=/share/Public/Autoran
LOGFILE=/share/Public/Autoran/Autoran.log
# WEB_SERVER=/home/Qhttpd/$APACHE_ROOT
WEB_SERVER=/home/httpd/cgi-bin/qpkg
# Location of php /home/httpd/cgi-bin/qpkg/Autoran
case "$1" in
  start)
    echo $(date) -- Starting Autoran -- >> $LOGFILE

    ENABLED=$(/sbin/getcfg $QPKG_NAME Enable -u -d FALSE -f $CONF)
    if [ "$ENABLED" != "TRUE" ]; then
        echo $(date) -- Autoran not enabled -- >> $LOGFILE
        exit 1
    fi

    echo $(date) -- Starting Autoran -- >> $LOGFILE
	
    mkdir -p $SCRIPT_STORE_PATH/Apps
    mkdir -p $SCRIPT_STORE_PATH/Scripts

    chmod -R 777 $QPKG_ROOT/utils

    ln -sf $QPKG_ROOT/utils $SCRIPT_STORE_PATH/Scripts/Utils
    ln -sf $QPKG_ROOT/web $WEB_SERVER/$QPKG_NAME
    ln -sf $SCRIPT_STORE_PATH/Apps $WEB_SERVER/$QPKG_NAME/Apps
    ln -sf $QPKG_ROOT/web/Utils $SCRIPT_STORE_PATH/Apps/Utils

    f=''

    echo $(date) -- Startup begin processing-- >> $LOGFILE
    chmod -R +x $SCRIPT_STORE_PATH/Scripts/*.sh
    for f in $SCRIPT_STORE_PATH/Scripts/up-*; do
      if [[ -x $f ]]; then
        echo $(date) executing $f ... >> $LOGFILE
        $f >> $LOGFILE 2>&1 || true
      fi
    done

    echo $(date) -- Startup end processing -- >> $LOGFILE
    ;;

  stop)
    : ADD STOP ACTIONS HERE
    echo $(date) -- Shutdown begin processing-- >> $LOGFILE
    chmod -R +x $SCRIPT_STORE_PATH/Scripts/*.sh
    f=''
    for f in $SCRIPT_STORE_PATH/Scripts/down-*; do
      if [[ -x $f ]]; then
        echo $(date) executing $f ... >> $LOGFILE
        $f >> $LOGFILE 2>&1 || true
      fi
    done

    echo $(date) -- Shutdown end processing -- >> $LOGFILE

#    rm -f $WEB_SERVER/$QPKG_NAME/Apps
#    rm -f $WEB_SERVER/$QPKG_NAME
#    rm -f $SCRIPT_STORE_PATH/Scripts/Utils
    echo $(date) -- Stopping Autoran -- >> $LOGFILE
    ;;

  restart)
    $0 stop
    $0 start
    ;;

  *)
    echo "Usage: $0 {start|stop|restart}"
    exit 1
esac

exit 0
