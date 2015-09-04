<?php 
echo "<h1 align='center' >Please Wait Loading...</h1>";
require_once("connect.php"); 
		$connectionurl = "host=".servername." port=5432 dbname=".database." user=".username." password=".password."";
		$dbconn3 = pg_pconnect($connectionurl);
		if (!$dbconn3) {
		die("Error in connection: " . pg_last_error());
		}
		$sqlHits = "SELECT * from retarget_link";		
		$result = pg_query($dbconn3,$sqlHits);
		$arr = pg_fetch_array($result,NULL, PGSQL_ASSOC);
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
$slug = $_REQUEST['s'];
$userId = $_REQUEST['u'];
if($slug!='' && $userId!=''){
/* ip address count start   */
		$ip = $_SERVER["REMOTE_ADDR"];
		$getIp['userId'] = $slug.$userId;
		$getIp['skey'] = 'ip';
		$ipvalue = targetClass::checkIpUniqueCount($getIp);
		if(empty($ipvalue)){
			$ipvalues = 1;
		} else {
			$ipvalues = $ipvalue['sval']+1;
		} 
		$ip_params['skey'] = $ip;
		$ip_params['userId'] = $slug.$userId;
		$ip_params['sval'] = $ipvalues;
		targetClass::addIpCount($ip_params);
	/*ip fixed */		
	/*  hits start */		
		$connectionurl = "host=".servername." port=5432 dbname=".database." user=".username." password=".password."";
		$dbconn3 = pg_pconnect($connectionurl);
		if (!$dbconn3) {
		die("Error in connection: " . pg_last_error());
		}
		$sqlHits = "SELECT * from retarget_link WHERE userId = '$userId' AND link = '$slug';";		
		$result = pg_query($dbconn3,$sqlHits);
		$arr = pg_fetch_array($result,NULL, PGSQL_ASSOC);		
		$hitsCount = ($arr['hits'])?$arr['hits']+1:1;
		$sql ="UPDATE  retarget_link SET hits='$hitsCount' WHERE userId = '$userId' AND link = '$slug';";		
		pg_query($dbconn3,$sql);
		//targetClass::addHitCount($hit_params);		
	/*  hits end */
	/* get all data  */
	$redirectto = $arr['redirectto'];
	if($arr['additional_vars']){
		$urlStep1 =  $redirectto.$arr['additional_vars'];
	} else {
		$urlStep1 = $redirectto;
	}
	if($arr['defaults_para_name']!='' && $arr['defaults_para_value']!='' ){
		if($arr['additional_vars']){
		$urlStep2 = $urlStep1.'&'.$arr['defaults_para_name'].'='.$arr['defaults_para_value'];			
		}else{
		$urlStep2 = $urlStep1.'?'.$arr['defaults_para_name'].'='.$arr['defaults_para_value'];			
		}
	} else {
		$urlStep2 = $urlStep1;
	}	
	$redirection = $urlStep2;
	$jsCode = $arr['track_standard_code'];
	/* get all data  */
}

?>
<html>
<head>
	<meta property="og:url" content="<?php echo $redirection; ?>" >
	<meta http-equiv="refresh" content="8; url=<?php echo $redirection; ?>">
	<?php 
		if($jsCode){
		echo stripslashes($jsCode);	
		}		
	?>
	<script type="text/javascript">
		<?php if(!empty($redirection)):?>
		setTimeout(function(){
			window.location = "<?php echo $redirection; ?>";
		},600);
		<?php endif; ?>
	</script>
</head><body> </body></html>
