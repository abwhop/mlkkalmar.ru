
var table_app = "/sends/show"; //приложение, данные которого загружаются в таблицу
var row_item_open_app = "cargo_location2"; //приложение, которое запускается при открытии строки таблицы




		G.contentBlock.detachObject(true);
		var self_win = G.contentBlock;
		
		var	contaner = self_win.attachLayout("1C");
	
	  	var main_cell = contaner.cells("a");
			main_cell.hideHeader();
			
		var toolbar  = main_cell.attachToolbar();
			
			toolbar.setIconsPath("common/dhxtoolbar/");
			
			if(struct && struct.toolbar)
			toolbar.loadStruct(struct.toolbar);
			
			
			toolbar.attachEvent("onClick", function(id){
							    switch (id){
							    	
												case "new":

										             row_item_open(0);
												break;
																								
												case "open":

										             var selected_row_id = table.getSelectedRowId();
										             if(selected_row_id)
										             row_item_open(selected_row_id);


												break;
					                           	case "reload":
										           	table.fullLoad(table_app,toolbar.MyItemsValues());
												break;
												
												
												
										}
						});
			toolbar.attachEvent("onEnter", function(id, value){
        
    					table.fullLoad(table_app,toolbar.MyItemsValues());
    
					});	

			toolbar.attachEvent("onStateChange", function(id, state){
    					table.fullLoad(table_app,toolbar.MyItemsValues());
					});
	
		var table = main_cell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			
			if(struct && struct.table){
				table.MyloadStruct3(struct.table);
				table.fullLoad(table_app,toolbar.MyItemsValues());
				table.markCells();
			}
			
			
			
			
			
			table.attachEvent("onRowDblClicked",row_item_open);        
       
             
       function row_item_open(rId){
	   				run_app(row_item_open_app,{"item_id":rId},function(response_data){
					
							if(response_data.item_id) {
		                  		table.insert({"item_id":response_data.item_id},table_app);

		                  		setTimeout(function(){                  	
		                  	 		table.update({"item_id":response_data.item_id},table_app);
		                  	
		                  			},500);                

                  				}
						});
	   		} 
