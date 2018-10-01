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

	G._____action = function(params,main_callback){		
//////////////////////////////////////////////
<?php 

$application = new \mlkkalmar\application(0,0,0);

echo "var  struct = ".$application->get_app_struct_json2().";\n\n";

?>	
/////////////////////////////////////////////		
	//var self_win = addWindow({"name": "window","posx": 20,"posy": 20,"type": "window","modal": false,"width": "450","height": "400","winname": "Транспортная компания","maximize": false});
	    	var dhtmlWindows = new dhtmlXWindows();	
	     var self_win = dhtmlWindows.MycreateWindow2(struct["window"]);
	      window.active_win = self_win;   //передаем в глобальную переменную объект нового окна
	      self_win.statusbar = self_win.attachStatusBar();
	    	
	    	
	    	
	    	self_win.center();
	
		var	win_form = self_win.attachLayout("2E");
	
	  	var form_cell = win_form.cells("a");
			form_cell.hideHeader();
			
	
		        
        var button_cell = win_form.cells("b");
			button_cell.hideHeader();
			button_cell.setHeight(50);
			
		var tabbar = form_cell.attachTabbar({
											    align: "left",
											    mode: "top",
											    tabs: [
											        {id: "a1", text: "Параметры", active: true},
											        {id: "a2", text: "Перемещаемые грузы"},
											        {id: "a3", text: "История перемещения грузов"}
											    ]
											}); 	
		var tab_a1 = tabbar.cells("a1");
		var tab_a2 = tabbar.cells("a2"); 
		var tab_a3 = tabbar.cells("a3");  	
			
		var table = tab_a2.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			table.enableDragAndDrop(true);
			table.selMultiRows = true;
			table.MyloadStruct3(struct["table"]);
			table.fullLoad("cargo_on_sends_now/show",{"location_id":params["item_id"]});
			table.markCells();	
			table.attachEvent("onDrop", function(dId,tId,sObj,tObj){				
					
					this.markCells();	
				
					
					return true;
					}); 
		
			table.getGridData = function(){
						var gridData = Array();
						var rows = 0;
						this.forEachRow(function(id){
						gridData[rows] = this.getRowData(id);
						rows++;
						});
					
					return 	gridData; 
					};
					
			table.params = {"location_id":params["item_id"]
				
			};		
					
			table.save = function(callback){
						
						var query_array = Array();
						 for(item in this.params){
						 	query_array.push(item + "=" + this.params[item]);
						 }
						
				window.dhx.ajax.post("/cargo_on_sends_now/chanage_table",query_array + "&table=" + JSON.stringify(this.getGridData()), function(data){
	        			var data_json = window.dhx.s2j(data.xmlDoc.responseText);
	        console.log(data_json);
	        if(callback) callback(data_json);
						});
						
						
					}		
		
		var table2 = tab_a3.attachGrid();
		    table2.enableAccessKeyMap();
		    table2.enableExcelKeyMap();
			table2.enableDragAndDrop(true);
			table2.selMultiRows = true;
			table2.MyloadStruct3(struct["table"]);
			table2.fullLoad("cargo_on_sends_hist/show",{"send_id":params["item_id"]});
			table2.markCells();
		
		var main_form = tab_a1.attachForm(struct["form"]);
			main_form.loadToSelects();

        	setTimeout(function(){
        		main_form.MyloadFormData("sends",params,function(response_data){
		            main_form.setFormData(response_data);
		        	main_form.depends_blocks();	
	        		main_form.onchange();
	        		
	        			        		
	        		if(main_form.getItemValue("send_date") == null) {
	        			
						main_form.setItemValue("send_date",new Date());
					}
	        				
	        		
	        		
	        		
	        		if(main_form.getItemValue("send_id")){
						tab_a2.enable();
						tab_a3.enable();
					}  else {
						tab_a2.disable();
						tab_a3.disable();
					}
	        			

      
       		}); 
				},500);  
       		
       		
       		
       		
       		
       		
       		    		
       		main_form.onchange = function(){
				main_form.forEachItem(function(item_name){
					
					switch (item_name) 	{
			       				case "move_type_id": 
			       					var  move_type_id =	main_form.getItemValue(item_name);
				       						main_form.forEachItem(function(name){
				       							
				       							if(main_form.getItemType(name) == "fieldset" && name.indexOf("move_type_id") != -1){
													if(name == item_name + "_" + main_form.getItemValue(item_name)) 
														main_form.showItem(name);
													else
														main_form.hideItem(name);	
												}
				       						});
			       				
			       				break;
								}
					
					});
				
			}
       		
       		main_form.attachEvent("onChange",function(item_name,item_value){
       						main_form.depends_blocks();
			       			main_form.onchange();
       			
				}); 
				      		
			
					
					
			var button_form = button_cell.attachForm();
	   		button_form.adjustParentSize();
			button_form.MyloadStruct("ok_save_close_form");
       		button_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{

							case "ok":							
								save(function(){								
									self_win.close();
									
								});						           
							break;
							
							
							case "save":
								save();							
							break;

							case "close":
								 self_win.close();
							break;
					}
			});
			
self_win.save = function(){
				save();
			}			
	function save(callback){
		
		
		table.save();
		
	 main_form.MySend("sends/change",function(response_data){
						            	
						            	var data_json = window.dhx.s2j(response_data.xmlDoc.responseText);	
						            	
						            	
						            	
						            	if (data_json != null){
						    				if(data_json.status) {	       					
													
											
															if(main_form && main_form.setFormData) {
																
															
															main_form.setFormData(data_json);
															if(main_form.getItemValue("send_id")){
																	tab_a2.enable();
																	tab_a3.enable();
																}  else {
																	tab_a2.disable();
																	tab_a3.disable();
																}
															}

															if(callback)  callback(data_json);
															if(main_callback) main_callback(data_json);

											                dhtmlx.message({ text: data_json.info});

								            } else {

								                		dhtmlx.message({ type: "error",  text: data_json.info});

								            }
										} else {
							                 dhtmlx.message({ type: "error", text: "Error"});
									    }
						            	
						            	
						            	
						            	
												
											
											
									});	
		
			}			
			
//////////////////////////////////////////	
}

}(this, undefined));