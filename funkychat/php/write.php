<?
	include "config.php";
	
	$newdate=date("Y-m-d H:i:s");
	if (ARCHIVAGE=="SQL"){
		simpleQuery("INSERT INTO ".BDD_TABLE." (nick,text,date) VALUES ('".addslashes(utf8_decode(strip_tags($_POST['nock'])))."','".addslashes(utf8_decode(strip_tags($_POST['mossage'])))."','".$newdate."')");
	}else if (ARCHIVAGE=="XML"){
		$today=date("Y-m-d");
		checkArchives($today);
		$archives = fopen(DIRECTORY.$today.".xml", "r");
		$tmpBuffer="";		
		$tmpBuffer.="\t\t<item>\n";
		$tmpBuffer.="\t\t\t<datetime><![CDATA[".$newdate." ]]></datetime>\n";
		$tmpBuffer.="\t\t\t<nick><![CDATA[".utf8_decode(strip_tags($_POST['nock']))." ]]></nick>\n";
		$tmpBuffer.="\t\t\t<title><![CDATA[".smileyString(utf8_decode(strip_tags($_POST['mossage'])))."]]></title>\n";
		$tmpBuffer.="\t\t</item>\n";
		$bufferTMP="";
		$buffer="";
		if ($archives){	
			while (!feof($archives)){
				$bufferTMP=fgets($archives, 4096);
				if (trim($bufferTMP)=="</channel>"){
					$bufferTMP=stripslashes($tmpBuffer).$bufferTMP;
				}
				$buffer.=$bufferTMP;
			}
		}		
		
		$archives=fopen(DIRECTORY.$today.".xml","w");
		fwrite($archives,$buffer);
		fclose($archives);
		
		$title=fopen(DIRECTORY."title.txt","w");
		fwrite($title,utf8_decode($_POST['nock'])." : ".$_POST['mossage']);
		fclose($title);
		
		
		
	}
?>

