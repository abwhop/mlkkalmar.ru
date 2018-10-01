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

										             cargo_location(0);
												break;
												
												case "store":

										             store_content(0);
												break;
												
																								
												case "open":

										             var selected_row_id = table.getSelectedRowId();
										             if(selected_row_id)
										             cargo_location(selected_row_id);


												break;
					                           	case "reload":
										           	table.fullLoad("/sends/show",toolbar.MyItemsValues());
												break;
												
												case "print":

										           //	var selectedId = table.getSelectedRowId();
										           // print_doc(class_name,selectedId);
												break;
												
												case "exel":

										          // 	var params = toolbar.MyItemsValues();
										          //  export_doc(class_name,params);
												break;
												
										}
						});
			toolbar.attachEvent("onEnter", function(id, value){
        
    					table.fullLoad("/sends/show",toolbar.MyItemsValues());
    
					});	

			toolbar.attachEvent("onStateChange", function(id, state){
    					table.fullLoad("/sends/show",toolbar.MyItemsValues());
					});
	
		var table = main_cell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			
			table.MyloadStruct3(struct["table"]);
			
			table.fullLoad("/sends/show",toolbar.MyItemsValues());
			table.markCells();
			table.attachEvent("onRowDblClicked",cargo_location);        
       
       function store_content(){
	   	run_app("store_content");
	   }
       
       function cargo_location(rId){
	   				run_app("cargo_location2",{"item_id":rId},function(response_data){
					
							if(response_data.item_id) {
		                  		table.insert({"item_id":response_data.item_id},"/sends/show");

		                  		setTimeout(function(){                  	
		                  	 		table.update({"item_id":response_data.item_id},"/sends/show");
		                  	
		                  			},500);                

                  				}
						});
	   		} 
//////////////////////////////////////////	
}

}(this, undefined));