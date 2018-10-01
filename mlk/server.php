<?php
$ERRORS = array();
//ini_set("allow_call_time_pass_reference","on");
header('Content-type: application/json; charset=UTF-8');
header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );


//if(isset($_POST["DATA"]) or isset($_GET["DATA"])){
if(isset($_GET)){

	$dt =  array_merge($_POST,$_GET);
    $DATA = json_decode(stripslashes($dt["DATA"]),true);
    $DATA2[0] =  $DATA;


//print_r($DATA2);

  $url = "http://vpn.calmar-net.ru:8080/server.php?DATA=".urlencode(json_encode($DATA2));
 // $url = "http://vpn.calmar-net.ru:8080/lider/?payer_id=387";

//if($payer_id) $url .= " and contragent_payer_id=".$payer_id;
//if($min_rq_id) $url .= "&rq_id>=".$min_rq_id;
//if($max_rq_id) $url .= "&rq_id<=".$max_rq_id;
//if($rq_id) $url .= "&rq_id=".$rq_id;
//if($min_rq_date) $url .= "&rq_date>=to_date(".$min_rq_date.",'DD.MM.YYYY')";
//if($max_rq_date) $url .= "&and rq_date<=to_date(".$max_rq_date.",'DD.MM.YYYY')";

// print $url;

// $file = file($url);

echo file_get_contents($url);

//$json = json_decode(implode("",$file),true);

//echo json_encode($json);

 }

?>