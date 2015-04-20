var debugMode = false;
function DEBUG(str) {
	if (debugMode) {
		var debugDiv = document.getElementById('debugDiv');
		debugDiv.appendChild(document.createTextNode(str));
		debugDiv.appendChild(document.createElement("br"));
		debugDiv.scrollTop = debugDiv.scrollHeight;
	}
}
function toggleDebug() {
	debugMode = !debugMode;
	if (debugMode == true && !window.widget) {
		document.getElementById('debugDiv').style.display = 'block';
	} else {
		document.getElementById('debugDiv').style.display = 'none';
	}
}
