#!/bin/sh

# */2 * * * * echo test >> /share/Public/Autoran/Scripts/test.txt
usage () {
    cat <<USAGE_END
Usage:
    $0 add 'job-spec'
    $0 list
    $0 remove 'job-spec'
USAGE_END
}



#crontab -l
#cat cron.txt
case "$1" in
    add)
        if [ -z "$2" ]; then
            usage >&2
            exit 1
        fi
        echo "Create CRON entry"
        crontab -l > allcrons
        while read p; do 
            if [ "$p" == "$2" ]; then
                exit 0
            fi
        done < allcrons
        printf '%s\n' "$2" >> allcrons
        cat allcrons > /etc/config/crontab
        rm allcrons
        crontab /etc/config/crontab && /etc/init.d/crond.sh restart
        ;;
    remove)
        if [ -z "$2" ]; then
            usage >&2
            exit 1
        fi
        echo "Remove CRON entry"
        crontab -l > allcrons
        touch allcronsrm
        while read p; do 
            if [ "$p" != "$2" ]; then
                echo "$p" >> allcronsrm
            fi
        done < allcrons
        cat allcronsrm > /etc/config/crontab
        rm allcrons
        rm allcronsrm
        crontab /etc/config/crontab && /etc/init.d/crond.sh restart
        ;;
    list)
        crontab -l | cat -n
        ;;
esac
