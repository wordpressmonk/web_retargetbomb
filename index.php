<?php 
echo "<h1 align='center' >Testing App Via API</h1>";
echo "<br/>";
echo  "<p align='center' style='color:green'>".$_SERVER['SERVER_NAME']."</p>";
$url = "http://retargetbomb.herokuapp.com/link/";
file_get_content($url);
?>
