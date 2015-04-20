<?
	include "config.php";
	header('Content-Type: text/xml');
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Pragma: no-cache"); 
	if (ARCHIVAGE=="SQL"){
		$select = "SELECT count(id) FROM ".BDD_TABLE;
		$result = mysql_query($select) or die ('Erreur : '.mysql_error() );
		$row = mysql_fetch_row($result);
		$total = $row[0]-MAX_LINE;
		if ($total<40){
			$total=0;
			$limit="LIMIT 0,40";
		}else{
			$limit="LIMIT ".$total-MAX_LINE.",".MAX_LINE;
		}
		
		print '<?xml version="1.0" encoding="ISO-8859-1"?>';
		$res=mysql_query("SELECT * FROM ".BDD_TABLE." ORDER BY id DESC LIMIT ".MAX_LINE);
		$buffer="<rss version=\"2.0\">\n";
		$buffer.="\t<channel>\n";
		$rowBuffer="";
		while ($row = mysql_fetch_array($res)){ 
			$tmpBuffer="";		
			$tmpBuffer.="\t\t<item>\n";
			$tmpBuffer.="\t\t<datetime><![CDATA[".$row['date']." ]]></datetime>\n";
			$tmpBuffer.="\t\t<nick><![CDATA[".stripslashes($row['nick'])." ]]></nick>\n";
			$tmpBuffer.="\t\t<title><![CDATA[".smileyString(stripslashes($row['text']))."]]></title>\n";
			$tmpBuffer.="\t\t</item>\n";
			$rowBuffer=$tmpBuffer.$rowBuffer;
		}		
		$buffer.=$rowBuffer;
		$buffer.="\t</channel>\n</rss>";
		
	}else if (ARCHIVAGE=="XML"){
		$today=date("Y-m-d");
		checkArchives($today);
		include "XmlFeeder.php";
		$tab=xmlEnTableau(DIRECTORY.$today.".xml");
		$buffer='<?xml version="1.0" encoding="ISO-8859-1"?>';
		$buffer.='<rss version="2.0">';
		$buffer.='<channel>';
		for ($xx=0;$xx<$tab['maxelements'];$xx++){
			$fieldName='item'.($xx+1);
			if ($xx<1 || $xx>$tab['maxelements']-MAX_LINE){
				$buffer.=makeItem($tab['channel'][$fieldName]['datetime'],$tab['channel'][$fieldName]['nick'],$tab['channel'][$fieldName]['title']);
			}
		}
		$buffer.='</channel></rss>';
	}		
	
	
	function makeItem($date,$nick,$title){
		$tmpBuffer.="\t\t<item>\n";
		$tmpBuffer.="\t\t<datetime>".$date."</datetime>\n";
		$tmpBuffer.="\t\t<nick><![CDATA[".$nick." ]]></nick>\n";
		$tmpBuffer.="\t\t<title><![CDATA[".html_entity_decode($title)."]]></title>\n";
		$tmpBuffer.="\t\t</item>\n";
		return($tmpBuffer);
	}
		
	print $buffer;
	
?>