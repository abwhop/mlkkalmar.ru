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

$module_name = "finance";
echo "var module_name = \"".$module_name."\";\n";
$struct = array();
$database = new \mlkkalmar\database();

$res = $database->get_data("select object_name, structure from ui_objects where object_name like '".$module_name."%'");
	foreach($res as $str){
		$struct[$str["object_name"]] = json_decode($str["structure"],true);
	}

//print_r($struct);

echo "var  struct = ".json_encode($struct).";\n\n";

?>
	var conteiner;
	console.log(params);
	
	if(G.contentBlock && !window_app){
		contentBlock.detachObject(true);
		var cont = contentBlock.attachLayout("1C");
		var conteiner = cont.cells("a");
	 	conteiner.hideHeader();
	} else {
		
		
		conteiner = addWindow(struct);
            
		
		
	}
	console.log(struct.finance_show_grid);
	
	if(struct.finance_show_toolbar) {
		
	
			var toolbar = addToolbar(conteiner,struct.finance_show_toolbar);
			
			toolbar.attachEvent("onClick", function(id){
				
				run_app("system",{"id":id},function(id){
					console.log(id);
				});
			});
	}
	
	if(struct.finance_show_grid) {
		
	
	 	var grid = addGrid(conteiner,struct.finance_show_grid);
		grid.attachEvent("onRowDblClicked", function(rId,cInd){
			
			run_app("system",{"id":rId},function(id){
				console.log(id);
			});
		});
	}

}

}(this, undefined));