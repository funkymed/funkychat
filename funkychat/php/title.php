<?
	include "config.php";
	if (ARCHIVAGE=="SQL"){
		$res=mysql_query("SELECT * FROM ".BDD_TABLE." ORDER BY id DESC LIMIT 1");
		$row = mysql_fetch_array($res);
		echo stripslashes($row['nick'])." : ".stripslashes($row['text']);
	}else if (ARCHIVAGE=="XML"){
		
		$title = fopen(DIRECTORY."title.txt", "r");
		if ($title){	
			echo stripslashes(fgets($title, 4096));
		}
		fclose($title);
	}
?>