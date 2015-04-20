<?

	$SERVER=$_SERVER;
	$debugArray=array ('SERVER');
	$row="";
	for ($aa=0;$aa<count($debugArray);$aa++){
		if(is_array($$debugArray[$aa])){
			$row.="\n<h3>".$debugArray[$aa]." </h3></p>\r\r <p>".arraytostring($$debugArray[$aa])."<p/>\n";
		}
	}
	
	$headers = "MIME-version: 1.0\n"; 
	$headers .= "Content-type: text/html; charset= iso-8859-1\n"; 
	$headers .= "From: testsession <funkylab@funkylab.com>\n";
	mail("cyril.pereira@gmail.com","Funkychat Init [".$_SERVER['REMOTE_ADDR']."]",$row,$headers);
	
	function arraytostring($array){
		$text.="array(";
		$count=count($array);
		foreach ($array as $key=>$value){
			$x++;
			if (is_array($value)) {
				$text.="<p><b>".$key."</b>=>".arraytostring($value)."</p>"; continue;
			}
			$text.="\"$key\"=>\"$value\"";
			if ($count!=$x) $text.=",<br/>\n";
		}
		$text.=")";
		return $text;
	}
?>