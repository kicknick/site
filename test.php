<?php
	$home= $_POST['home'];
	if($home == "registration") {
		/*make req to SQL*/
	}
?>



<?php
//<script>
// function getXmlHttp(){
// 	var xmlhttp;
// 	try {
//     	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
//   	} catch (e) {
//     	try {
//      		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//     	} catch (E) {
//       		xmlhttp = false;
//     	}
//   	}
//   	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
//     	xmlhttp = new XMLHttpRequest();
//   	}
// 	return xmlhttp;
// }

// var sendReq = function(params) {
// 	var req = getXmlHttp();
// 	req.onreadystatechange = function() {
// 		if(req.readyState == 4) {
// 			console.log(req.statusText);
// 		}
// 		if(req.status == 200) {
// 			console.log("request: " + req.responseText);
// 		}
// 	}
// 	req.open("GET", "/site/hendler.php?"+params, true);
// 	//req.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
// 	req.send();
// 	//console.log(JSON.stringify(params));
// 	console.log("loading...");
// }
//</script>
?>