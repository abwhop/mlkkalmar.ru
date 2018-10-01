<?php
spl_autoload_register(function ($class) {
	
	if(file_exists('..\vendor\\' . $class . '.php'))
    include '..\vendor\\' . $class . '.php';
   //  else 
   //  echo "File not found!";
});

?>
(function (G, U){
    "use strict";
    var $ = G.jQuery,
        bool   = "boolean",
        string = "string",
        number = "number",
        object = "object";
/////////////////////////////////        
        
        
     var   window_app = false;
        
        
    
        
        
        
        
        
/////////////////////////////////////////////        

	G._____action = function(params,callback){		
<?php 

$module_name = "logistors";
echo "var module_name = \"".$module_name."\";\n";
$struct = array();
$database = new \mlkkalmar\database();

$res = $database->get_data("select ui.object_name, ui.structure from ui_objects ui left join applications app on ui.app_id=app.app_id where app.app_name = '".$module_name."'");
	foreach($res as $str){
		$struct[$str["object_name"]] = json_decode($str["structure"],true);
	}

//print_r($struct);

echo "var  struct = ".json_encode($struct).";\n\n";

?>
	
	
	if(G.contentBlock && !window_app){
		contentBlock.detachObject(true);
		var cont = contentBlock.attachLayout("1C");
		var conteiner = cont.cells("a");
	 	conteiner.hideHeader();
	} else {
		
		
		conteiner = addWindow(struct);
            
		
		
	}
	console.log(struct.show_grid);
	
	if(struct.show_toolbar) {
		
	
			var toolbar = addToolbar(conteiner,struct.show_toolbar);
			
			toolbar.attachEvent("onClick", function(id){
				
				run_app("logistors",{"item_id":id},function(id){
					console.log(id);
				});
			});
	}
	
	if(struct.show_grid) {
		
	
	 	var grid = addGrid(conteiner,struct.show_grid);
		grid.attachEvent("onRowDblClicked", function(rId,cInd){
			
			run_app("logistors_edit",{"item_id":rId},function(id){
				console.log(id);
			});
		});
	}

}

}(this, undefined));