<?
	include "XmlFeeder.php";
	$tab=xmlEnTableau("whois.xml");
	for ($xx=0;$xx<$tab['maxelements'];$xx++){
		$fieldName='User'.($xx+1);
		print ' <div class="user">'.$tab[$fieldName]['name'].'</div> ';
	}
?>