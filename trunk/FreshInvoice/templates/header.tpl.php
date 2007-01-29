<?
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Factuursysteem '.BEDRIJFSNAAM.'</title>
<link rel="stylesheet" href="'.URL.'/style.css" type="text/css">
<script type="text/javascript" language="JavaScript1.2" src="./js/prototype.js"> </script>
<script type="text/javascript" language="JavaScript1.2" src="./js/funct.js"> </script>
</head>';

if($fact->isLoggedIn()){
	if($_GET['p']!=''){
		echo'<body>';
	}
}else{
	echo'<body>';
}
?>
