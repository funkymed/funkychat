<?
	function simpleQuery($str){
		$resultat=@mysql_query($str);
	}
	function smileyString ($_string){
		include "smileys.php";
		for ($xx=0;$xx<count($smileysREF);$xx++){
			$_string=str_replace($smileysREF[$xx],"<img src=\"".$smileys[$xx]."\" align=\"absmiddle\"/>",$_string);	
		}
		$_string = eregi_replace( "( www|http|mailto|news|ftp|https)://(([-éa-z0-9\/\.\?_=@:~])*)", "<a href=\"\\1://\\2\" target=\"_blank\">\\1://\\2</a>", $_string );
		return $_string;
	}
	
	function checkArchives($today){
		if (!is_file(DIRECTORY.$today.".xml")){
			$archives=fopen(DIRECTORY.$today.".xml","w");
			$newdate=date('Y-m-d H:i:s');
			$bufferHeader='<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
	<channel>
		<item>
			<datetime><![CDATA['.$newdate.' ]]></datetime>
			<nick><![CDATA[Funkychat]]></nick>
			<title><![CDATA[initialisation (mode : Xml)<br/>Date '.$newdate.'<br/>Serveur : '.$_SERVER["SERVER_NAME"].' ('.$_SERVER["SERVER_ADDR"].')]]></title>
		</item>
	</channel>
</rss>';
			fputs($archives,$bufferHeader);
			fclose($archives);
		}
	}
	

?>