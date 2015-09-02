<?php 
echo "<h1 align='center' >Testing App Via API</h1>";
echo "<br/>";
echo  "<p align='center' style='color:green'>".$_SERVER['SERVER_NAME']."</p>";
$s = $_REQUEST['s'];
$u = $_REQUEST['u'];
$url = "http://retargetbomb.herokuapp.com/link/?s=$s&u=$u";
file_get_content($url);
?>
