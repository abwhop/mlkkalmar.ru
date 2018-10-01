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

	G._____action = function(params,callback){		
//////////////////////////////////////////////


<?php 

$application = new \mlkkalmar\application(0,0,0);

echo "var  struct = ".$application->get_app_struct_json2().";\n";

?>


/////////////////////////////////////////////	
		G.contentBlock.detachObject(true);
		var self_win = G.contentBlock;
		
		var	cont = self_win.attachLayout("1C");
	
	  	var main_cell = cont.cells("a");
			main_cell.hideHeader();
			
		var toolbar  = main_cell.attachToolbar();
			
			toolbar.setIconsPath("common/dhxtoolbar/");
			toolbar.loadStruct(struct["toolbar"]);
			
			
			toolbar.attachEvent("onClick", function(id){
							    switch (id) 	{
												case "new":

										            item_edit(-1);
												break;
										
												
												
												
										}
						});
			toolbar.attachEvent("onEnter", function(id, value){
        
    					table.fullLoad("/applications2/show",toolbar.MyItemsValues());
    
					});	

			toolbar.attachEvent("onStateChange", function(id, state){
    					table.fullLoad("/applications2/show",toolbar.MyItemsValues());
					});
	
		var table = main_cell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			
			table.MyloadStruct3(struct["table"]);
			
			table.fullLoad("/applications2/show",toolbar.MyItemsValues());
			table.markCells();
			table.attachEvent("onRowDblClicked",item_edit);        
       
       function store_content(){
	   	run_app("store_content");
	   }
       
       function item_edit(rId){
	   				run_app("applications2_edit",{"item_id":rId},function(response_data){
					
							if(response_data.item_id) {
		                  		table.insert({"item_id":response_data.item_id},"/applications2/show");

		                  		setTimeout(function(){                  	
		                  	 		table.update({"item_id":response_data.item_id},"/applications2/show");
		                  	
		                  			},500);                

                  				}
						});
	   		} 
//////////////////////////////////////////	
}

}(this, undefined));