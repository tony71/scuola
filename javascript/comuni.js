var xmlhttp;
var id_g;

function showComuni(obj)
{
	if (obj.id.value == "provincia_nascita") {
		id_g = "comune_nascita";
	}
	if (obj.id.value == "provincia_residenza") {
		id_g = "comune_residenza";
	}
	
	id_g = "comune_nascita";

	alert("id "+id_g+" str "+iobj.value);

	if (obj.value.length == 0) {
		document.getElementById(id_g).innerHTML="";
		return;
	}
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp == null) {
		alert ("Your browser does not support XMLHTTP!");
		return;
	}
	var url="include/comuni.php";
	url=url+"?provincia="+str;
	id_g = id;
	xmlhttp.onreadystatechange=stateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged
{
	if (xmlhttp.readyState == 4) {
		document.getElementById(id_g).innerHTML=xmlhttp.responseText;
	}
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject) {
		// code for IE6, IE5
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}
