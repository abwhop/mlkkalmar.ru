<?php
header("Cache-Control: no-cache, must-revalidate"); header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); header("Content-Type: text/javascript; charset=utf-8");

spl_autoload_register(function ($class) {
    include '../vendor/' . $class . '.php';
});

	$database = new \mlkkalmar\database();
    $ui_data = array();

	$QUERY = "select object_name,structure,params  from ui_objects";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {

	$ui_data[$item["object_name"]] = json_decode($item["structure"],true);



   }


	$QUERY = "select dest_name,dest_color  from destinations";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {
	$ui_data["grid_fields"]["dest_name"][$item["dest_name"]] = $item["dest_color"];

   }
   
   $QUERY = "select send_status_name,send_status_color  from send_statuses";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {
	$ui_data["grid_fields"]["send_status_name"][$item["send_status_name"]] = $item["send_status_color"];

   }
   
   $QUERY = "select strg_cond_short_name,strg_cond_color  from storage_conditions";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {
	$ui_data["grid_fields"]["strg_cond_short_name"][$item["strg_cond_short_name"]] = $item["strg_cond_color"];

   }
   
   
   $QUERY = "select move_type_name,move_type_color  from move_types";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {
	$ui_data["grid_fields"]["move_type_name"][$item["move_type_name"]] = $item["move_type_color"];

   }
   
   $QUERY = "select logistor_color,contragent_name  from logistors_color_list";
	$res = $database->get_data($QUERY);

    foreach($res as $item) {
	$ui_data["grid_fields"]["logistor_name"][$item["contragent_name"]] = $item["logistor_color"];

   }
   
   


	
  echo "var ui_data = ".json_encode($ui_data).";";

?>