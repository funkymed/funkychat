//---------------------------------------------------------
// Xml / Xsl : Load - Transform & Display
//--
var timerRefresh;
function Main(){
	
	var Stamp = new Date();
	
	var Hours = Stamp.getHours();
	var Mins = Stamp.getMinutes();
	var Secs = Stamp.getSeconds();
	
	$('nick').value="newUser"+Hours+Mins+Secs;
	
	var init = new Ajax.Request('funkychat/php/init.php',
		{
			method: 'get',
			oncomplete:function(v){alert(v);}
		}
	);
	
	Slider1.n_value=$('time').value;
	Slider1.e_slider.style.left = (Slider1.n_pathLeft + Math.round((Slider1.n_value - Slider1.n_minValue) * Slider1.n_pix2value)) + 'px';
	//toggleDebug(); // DEBUG MODE
	ChatUpdate();
	document.onkeypress = stopRKey; 
	$('chatroom').scrollTop = $('chatroom').scrollHeight;
	var laRequete = new Ajax.PeriodicalUpdater('whois','funkychat/php/whois_read.php',{method:'get',frequency:10});
	loader(false);
	
	
}
function stopRKey(evt) {
	var evt = (evt) ? evt : ((event) ? event : null);
	var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	if (evt.keyCode == 13){
		SendMsg();
	}
}
function ChatUpdate(){
	clearTimeout(timerRefresh);
	DEBUG("update"+$('time').value*1000);
	XmlXsl('funkychat/php/read.php','funkychat/xsl/readxml.xsl','chatroom');
	timerRefresh=setTimeout("ChatUpdate()",$('time').value*1000);
	var myAjaxTitle = new Ajax.Request('funkychat/php/title.php',{method: 'get', onComplete: showResponseTitle});
	var myAjaxUserWrite = new Ajax.Request('funkychat/php/whois_write.php?nick='+$('nick').value,{method: 'get'});
}

function showResponseTitle(v){
	top.document.title=v.responseText;
}

