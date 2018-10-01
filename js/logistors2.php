(function (G, U){
    "use strict";
    var $ = G.jQuery,
        bool   = "boolean",
        string = "string",
        number = "number",
        object = "object";

	G._____action = function(params,callback){		
//////////////////////////////////////////////
	
		G.contentBlock.detachObject(true);
		var self_win = G.contentBlock;
		
		var	cont = self_win.attachLayout("1C");
	
	  	var main_cell = cont.cells("a");
			main_cell.hideHeader();
			
		var toolbar  = main_cell.attachToolbar();
			toolbar.MyloadStruct("logistors_show_toolbar");
			toolbar.attachEvent("onClick", function(id){
							    switch (id) 	{
												case "new":

										             logistors_edit(null);
												break;
																								
												case "open":

										             var selected_row_id = table.getSelectedRowId();
										             if(selected_row_id)
										             logistors_edit(selected_row_id);


												break;
					                           	case "reload":
										           	table.fullLoad("/logistors/show",toolbar.MyItemsValues());
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
        
    					table.fullLoad("/logistors/show",toolbar.MyItemsValues());
    
					});	

			toolbar.attachEvent("onStateChange", function(id, state){
    					table.fullLoad("/logistors/show",toolbar.MyItemsValues());
					});
	
		var table = main_cell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			table.MyloadStruct2("logistors_show_grid");
			table.fullLoad("/logistors/show",toolbar.MyItemsValues());
			table.attachEvent("onRowDblClicked",logistors_edit);        
       
       
       
       function logistors_edit(rId){
	   				run_app("logistors_edit",{"item_id":rId},function(response_data){
					
							if(response_data.item_id) {
		                  		table.insert({"item_id":response_data.item_id},"logistors/show");

		                  		setTimeout(function(){                  	
		                  	 		table.update({"item_id":response_data.item_id},"logistors/show");
		                  	
		                  			},500);                

                  				}
						});
	   		} 
//////////////////////////////////////////	
}

}(this, undefined));