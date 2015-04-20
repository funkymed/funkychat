<?
	include "config.php";
	include "XmlFeeder.php";
	
	$tab=xmlEnTableau("whois.xml");
	$bufferXml='<?xml version="1.0" encoding="ISO-8859-1"?>';
	$bufferXml.='<whois>';
	$tabAllUserName=array();
	$current_name=htmlentities($_GET['nick']);
	$current_IP=$_SERVER['REMOTE_ADDR'];;
	$current_time=mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))+TIME_OUT*60;
	
	$foundCurrentUSer=false;
	for ($xx=0;$xx<$tab['maxelements'];$xx++){
		$arrayUser=$tab['User'.($xx+1)];
		$User_name	= $arrayUser['name'];
		$User_ip	= $arrayUser['ip'];
		$User_time	= $arrayUser['time'];
		if (!in_array($User_name,$tabAllUserName)){
			if ($_SERVER['REMOTE_ADDR']==$User_ip && $_GET['nick']==$User_name && $foundCurrentUSer==false){
				$bufferXml.=insertUser($current_name,$current_IP,$current_time);
				$foundCurrentUSer=true;
			}else if(checkUtilisteur($User_time)==true && $_SERVER['REMOTE_ADDR']!=$User_ip && $_GET['nick']!=$User_name){
				$bufferXml.=insertUser($arrayUser['name'],$arrayUser['ip'],$arrayUser['time']);
				
			}
		}
	}
	
	if ($foundCurrentUSer==false){
			$bufferXml.=insertUser($current_name,$current_IP,$current_time);
	}
	
	$bufferXml.='</whois>';
	
 	echo $bufferXml;
	 	
	$updateXML=fopen("whois.xml","w+");
	fwrite($updateXML,trim($bufferXml));
	fclose($updateXML);

	function insertUser($User_name,$User_ip,$User_time){
		$stringBuffer='<User>';
		$stringBuffer.='<name>'.$User_name.'</name>';
		$stringBuffer.='<ip>'.$User_ip.'</ip>';
		$stringBuffer.='<time>'.$User_time.'</time>';
		$stringBuffer.='</User>';
		return $stringBuffer;
	}
	
	
	function checkUtilisteur($date_user_saved){
		$date_now_timecode=mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
		$user_timeout=(($date_user_saved-$date_now_timecode));
		 if($user_timeout<TIME_OUT){;
			return false;
		}else{
			return true;
		}
	}
	
?>