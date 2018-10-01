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

echo "var  struct = ".$application->get_app_struct_json().";\n\n";

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
			
			
		var table = form_cell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			table.enableDragAndDrop(true);
			table.selMultiRows = true; 
			table.MyloadStruct3(struct["table"]);
			
			table.fullLoad("/cargo_on_store/show",{});
			table.markCells();	
			table.attachEvent("onDrop", function(dId,tId,sObj,tObj){
					
					
					this.markCells();			
				
					
					return true;
					});	
/*
		var main_form = form_cell.attachForm(struct["form"]);
		

        	main_form.MyloadFormData("logistors_show",params,function(response_data){
		            main_form.setFormData(response_data);
		        
       		});       		
       		       		
			main_form.attachEvent("onButtonClick",function(item_name){
				    var self = this;
					switch (item_name) 	{
							case "contragents_list":
								run_app("contragents_list",{"ttt":"yyyy"},function(data){
										if(data && data.item_id){
											self.setItemValue("contragent_id",data.item_id);
											self.setItemValue("contragent_name",data.item_name);
										}
											
								});
							break;
							}
					});
*/				
					
					
			var button_form = button_cell.attachForm();
	   		button_form.adjustParentSize();
			button_form.MyloadStruct("ok_close_form");
       		button_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{

							case "ok":
						            main_form.MySend("logistors/change",function(response_data){
						            	
						            	var data_json = window.dhx.s2j(response_data.xmlDoc.responseText);	
						            	
						            	
						            	
						            	if (data_json != null){
						    				if(data_json.status) {
						        	       					if(callback)  callback(data_json);
															
															
															if(main_form && main_form.setFormData)
															main_form.setFormData(data_json);


															ui_data["grid_fields"]["logistor_name"][main_form.getItemValue("contragent_name")]  = main_form.getItemValue("logistor_color");
														            	
						              						self_win.close();

											                dhtmlx.message({ text: data_json.info});

								            } else {

								                		dhtmlx.message({ type: "error",  text: data_json.info});

								            }
										} else {
							                 dhtmlx.message({ type: "error", text: "Error"});
									    }
						            	
						            	
						            	
						            	
												
											
											
									});
							break;

							case "close":
								 self_win.close();
							break;
					}
			});
//////////////////////////////////////////	
}

}(this, undefined));