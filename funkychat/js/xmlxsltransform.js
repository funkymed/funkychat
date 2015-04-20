//---------------------------------------------------------
// Xml / Xsl : Load - Transform & Display
//--

var tmpXSL;
var tmpDIV;
var xmlDoc;
var xslDoc;
var tmpXML=null;
var xslStylesheet;
var xsltProcessor ;
var oldXML;

function XmlXsl(fileXML,fileXSL,DivName){
	loader(true);
	var target = $(DivName);
	tmpXSL=fileXSL;
	tmpDIV=target;
	var myAjax = new Ajax.Request(fileXML,{method: 'get', onComplete: showResponse});
}

function showResponse(originalRequest){
	xmlDoc = originalRequest.responseXML ;
	
	if (window.ActiveXObject) {
		xslDoc = new ActiveXObject('Microsoft.XMLDOM');	
		xslDoc.async = false;	
		xslDoc.load( tmpXSL);	
		var tmpHTML=cleanResultSearch(xmlDoc.documentElement.transformNode(xslDoc));	
	}else{
		xsltProcessor = new XSLTProcessor();
		xhr_object = new XMLHttpRequest();	  					
		xhr_object.open("GET", tmpXSL, false);	  
		xhr_object.send(null);	
		xslStylesheet = xhr_object.responseXML;
		xsltProcessor.importStylesheet(xslStylesheet);
		var doc = xsltProcessor.transformToDocument(xmlDoc);
		var xmls = new XMLSerializer();
		var tmpHTML=cleanResultSearch(xmls.serializeToString(doc));
	}
	if (tmpHTML!=oldXML){
		oldXML=tmpHTML;
		tmpDIV.innerHTML=tmpHTML;
		tmpDIV.scrollTop = tmpDIV.scrollHeight;
	}
	loader(false);
}

function loader(v){
	if (v==true){
		$("loading").show();
	}else if(v==false){
		$("loading").hide();
	}
}

//---------------------------------------------------------
// SendMSG
//--
function SendMsg(){
	if ($('nick').value!="" && $('msginput').value!=""){
		//var smiliesMSG=smileyCheckString($('msginput').value);
		
		var msg = $H({  'nock':$F('nick')  , 'mossage' : $F('msginput') }).toQueryString();
		DEBUG(msg);
		$('msginput').value="";
		var myAjax = new Ajax.Request("funkychat/php/write.php",{method: 'post',parameters:msg,onComplete: ChatUpdate});
	}else{
		alert("Veuillez entrer votre nom et votre message");
	}
}

function cleanResultSearch(txtBuffer,b){
	var checkTxt1=new RegExp("&lt;", "g");
	var checkTxt2=new RegExp("&gt;", "g");
	txtBuffer = txtBuffer.replace(checkTxt1,"<");
	txtBuffer = txtBuffer.replace(checkTxt2,">");
	return (txtBuffer);	
}