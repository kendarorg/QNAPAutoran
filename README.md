# QNAP Autoran

This package installs a new application (Autoran) that can

* Run arbitrary commands at startup
* Expose an arbitrary application via the QNAP Ui

## Installation

In QTS Desktop, open **App Center**.
On the settings enable the "installation without valid signature"
Download the appropriate package from the releases 
Upload it on App Center with the Plus sign (manual installation)

## Usage

The application creates a folder /Public/Autoran containing

* Apps (here you can add a directory containing your php application
* Apps/Utils (some utilities to handle special qnap functions)
* Scripts (contains the up-*.sh and down-*.sh scripts for the services)
* Scripts/Utils (actually only a command line utility to add/remove crontabs via bash)

### Apps 

For example you can add under Apps a folder with phpMyAdmin, opening the Autoran app you will
be propsed a screen containing the list of Apps folder

If inside the specific application folder exists an empty file named "ext" the click on the Autoran 
app will open a new window

An example app can be a directory TestApp containing an index.php
<pre>
	<?php
		phpinfo();
	?>
</pre>

### Scripts

The up-*.sh scripts are run starting the application (and the NAS)
The down-*.sh scripts are run closing the application (and the NAS)

If you want a specific order just name them with numbers

<pre>
	up-01-nfs.sh
	up-02-cron.sh
	down-01-cron.sh
	up-02-sh.sh
</pre>

An example can be mounting and unmounting an nfs share

Up:
<pre>
sudo mount -t nfs -o username=svc_account,password=password //othernas /share/Public/othernas
</pre>

Down:
<pre>
sudo umount /share/Public/othernas
</pre>

## Build on your QNAP

### Setup QDK

In QTS Desktop, open **App Center**.

Search **QDK** and install the latest version.

### Build

Upload this project to one of your NAS folder.

Login via ssh on you QNAP NAS, go inside this package directory
and execute **qbuild** command to build this qpkg.

	$ cd /share/Public/USBRun
	$ qbuild
	Creating archive with data files for arm-x19...
	Creating archive with control files...
	Creating QPKG package...
	...
	Creating QPKG package...
	
Now inside the build directory you will find your package!

	$ ls build/
	USBRun_0.1_arm-x19.qpkg         
	...
	USBRun_0.1_x86_64.qpkg.md5
	
### Install

Then choose the one for your CPU, go to AppCenter and upload :)


