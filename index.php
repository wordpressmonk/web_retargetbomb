<?php 
echo "<h1 align='center' >Please Wait Loading...</h1>";
echo "<br/>";
echo  "<p align='center' style='color:green;display:none;'>".$_SERVER['SERVER_NAME']."</p>";
$s = $_REQUEST['s'];
$u = $_REQUEST['u'];
if($s!='' && $u!=''){
$url = "http://retargetbomb.herokuapp.com/link/?s=$s&u=$u";	
}else {
$url = "http://retargetbomb.herokuapp.com/link/";		
}
//file_get_content($url);
header("location:$url");
exit;
?>
