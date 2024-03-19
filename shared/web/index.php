<?php
$currentDir = dirname(__FILE__);
$base_dir = $currentDir.DIRECTORY_SEPARATOR."Apps";
$files = scandir($base_dir);
?>
<html>
	<head></head>
	<body>
		<ul>
			<li>Autorun in your /share/Public/Autorun/Scripts folder</li>
			<li>Web in your /share/Public/Autorun/Apps folder</li>
		</ul>
		<ul>
		<?php
			foreach ($files as $item){
				if ($item != '..' && $item != '.'&& $item != 'Apps'&& $item != 'Utils' && is_dir($base_dir . "/" . $item)){
                    if(file_exists($base_dir . "/" . $item."/ext")){
                        echo '<li><a target="_blank" href="Apps/'.$item.'">'.$item.'</a></li>';
                    }else{
                        echo '<li><a href="Apps/'.$item.'">'.$item.'</a></li>';
                    }
				}
			}
		?>
		</ul>
	</body>
</html>