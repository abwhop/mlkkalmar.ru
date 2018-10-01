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
////////////////////////////////////////////////////////////
<?php 

$application = new \mlkkalmar\application(0,0,0);

echo "var  struct = ".$application->get_app_struct_json2().";\n";

?>


			
		//var conteiner = addWindow({"name": "window","posx": 20,"posy": 20,"type": "window","modal": false,"width": "450","height": "400","winname": "Коттрагенты","maximize": false});
	
	var self_win = dhtmlWindows.MycreateWindow2(struct["window"]);
	      window.active_win = self_win;   //передаем в глобальную переменную объект нового окна
	      self_win.statusbar = self_win.attachStatusBar();
	
		//var self_win = conteiner;
	    	self_win.center();
	    	
	   console.log(params); 	
	    	
	    var toolbar  = self_win.attachToolbar();
			
			toolbar.setIconsPath("common/dhxtoolbar/");
			toolbar.loadStruct(struct["toolbar"]);
			
			toolbar.attachEvent("onClick", function(id){
				
				console.log(id);
							    switch (id) 	{
							    	case "new": 
							    	var parent_item_id;
							    	
							    	if(params.item_id != -1)
							    		parent_item_id = tree.getSelectedId();
							    	else
							    		parent_item_id = 0;	
							    	
							    	
							    	
							    	window.dhx.ajax.post("/application/add_item","parent_item_id=" + parent_item_id, function(data){
													    	
													    	var data_json = window.dhx.s2j(data.xmlDoc.responseText);
													    	console.log(data_json);
													    	if(data_json && data_json.new_item_id){
																													
													    			tree.addItem(data_json.new_item_id, "New Item_" + data_json.new_item_id, parent_item_id);
															    	
															    	if(parent_item_id != 0) {
																		tree.setItemIcons(data_json.new_item_id, {
																								    file:           "icon_tree_module",    // css for the file
																								    folder_opened:  "icon_tree_module",  // css for the opened folder
																								    folder_closed:  "icon_tree_module"   // css for theclosed folder
																								});
																	} else {
																		tree.setItemIcons(data_json.new_item_id, {
																								    file:           "icon_tree_application",    // css for the file
																								    folder_opened:  "icon_tree_application",  // css for the opened folder
																								    folder_closed:  "icon_tree_application"   // css for theclosed folder
																								});
																	}
															    	
																}
									});						
							    	
							    	break;
							    	
							    	case "delete": 
							    	var delete_item_id = tree.getSelectedId();
							    	console.log(delete_item_id);
							    	window.dhx.ajax.post("/application/delete_item","item_id=" + delete_item_id, function(data){
													    	
													    	var data_json = window.dhx.s2j(data.xmlDoc.responseText);
													    	if(data_json && data_json.item_id){
													    			tree.deleteItem(data_json.item_id);
																}
														});
							    	
							    	
							    	
							    	
							    	break;
								}
					
				});	
			
			
				
	
		var	win_form = self_win.attachLayout("3U");
	
	  
	
		var tree_cell = win_form.cells("a");
			tree_cell.hideHeader();
			tree_cell.setWidth(200);
			
		var form_cell = win_form.cells("b");
			form_cell.hideHeader();
		
		
		
		
		
		
		
		
		var tabbar = form_cell.attachTabbar({
											    align: "left",
											    mode: "top",
											    tabs: [
											        {id: "a1", text: "Конфигурация", active: true},
											        {id: "a2", text: "Права доступа"}
											       	]
											}); 	
		var tab_a1 = tabbar.cells("a1");
		var tab_a2 = tabbar.cells("a2"); 
		//var tab_a3 = tabbar.cells("a3");  		
			
				
         
        var button_cell = win_form.cells("c");
			button_cell.hideHeader();
			button_cell.setHeight(50); 
   
   
 /////////////////////////////////////////////////////////  
   
  /*       
        var list = list_cell.attachList({
        		edit:true,
        		
				type:{ height:"auto",
				template:"#item_name#",
            	template_edit:"<textarea class='dhx_item_editor' bind='obj.item_name'>"
				
				
				 }
				});
        list.attachEvent("onAfterEditStop", function (id){
    		console.log(this.get(id));
		});
        
         		
			list.Myload("ui_objects/list_",{"app_id":params["item_id"]});	

			list.attachEvent("onAfterSelect", function (id){
			    
			   var item = this.get(id);
			   
			    
			    main_form.MyloadFormData("application",{"item_id":item.item_id},function(response_data){
		            main_form.setFormData(response_data);
		            
       			});
			});
*/
//myTreeView.selectItem("2");
		var tree = tree_cell.attachTreeView({json: "/application/tree?item_id=" + params.item_id,
		 onload: function(){
        		tree.selectItem(params.item_id);
    	}
		
		});
		tree.attachEvent("onSelect", function(id, mode){
				    if(mode){
							main_form.MyloadFormData("application",{"item_id":id,"new":1},function(response_data){
		           			 main_form.setFormData(response_data);
		           			 
		           			var structure = main_form.getItemValue("structure");
		           			 
		            			if(structure)
		            			editor.set(JSON.parse(structure));	
       						});
					}
			});			
					//tree


		var main_form = tab_a1.attachForm(struct["form"]);
			main_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{
						case "code_edit":
							window.open('/application/code_edit');
						break;
						
					}
				});
		
		
			

		var options = {
						    mode: 'code',
						    modes: ['code', 'form', 'text', 'tree', 'view'], // allowed modes
						    onError: function (err) {
						      alert(err.toString());
						    }
						    //,
						    //onModeChange: function (newMode, oldMode) {
						    //  console.log('Mode switched from', oldMode, 'to', newMode);
						    //}
						  };
			var container = main_form.getContainer("jsoneditor")	
				if(container)		  
		        var editor = new JSONEditor(container, options);






		var	tab_a2_lo = tab_a2.attachLayout("2E");
			var userCell = tab_a2_lo.cells("a");
			var groupCell = tab_a2_lo.cells("b");
			userCell.setHeight(350);
			userCell.setText("Пользователи");
			groupCell.setText("Группы");
			//groupCell.setHeight(0);
			
		var table = userCell.attachGrid();
		    table.enableAccessKeyMap();
		    table.enableExcelKeyMap();
			
			table.MyloadStruct3(struct["table"]);
			
			table.fullLoad("/applications_permissions/show",{"app_id":params["item_id"]});
			table.markCells();
		
		var table2 = groupCell.attachGrid();
		    table2.enableAccessKeyMap();
		    table2.enableExcelKeyMap();
			
			table2.MyloadStruct3(struct["table2"]);
			
			//table2.fullLoad("/applications2/show",toolbar.MyItemsValues());
			table2.markCells();


       	var button_form = button_cell.attachForm();
	   		button_form.adjustParentSize();
			button_form.MyloadStruct("ok_save_close_form");
       		button_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{

							case "ok":
							
							
					         
					         save(function(data){
					         	
					          
					         
					         	self_win.close();
					         	
					         });     

							break;
							case "save":
					        
					         save(function(data){
					          
					         	console.log(data);
							});     

							break;
							

							case "close":
									self_win.close();
							break;
					}
			});

			self_win.select = function(data){
		        callback(data);
		        self_win.close();

	    	};
	    	
	    	
	    	self_win.save = function(){
				save();
			}
	    	
	    	function save(callback){
				
				var json = editor.get();						
							if(json)
							main_form.setItemValue("structure",JSON.stringify(json));
				
				 main_form.MySend("application/change2",function(response_data){
						            	
						            	var data_json = window.dhx.s2j(response_data.xmlDoc.responseText);	
						            	
						            	
						            	
						            	if (data_json != null){
						    				if(data_json.status) {
						        	       					
															
															
															if(main_form && main_form.setFormData)
															main_form.setFormData(data_json);

								var module_id =	main_form.getItemValue("item_id");
					         var module_name =	main_form.getItemValue("item_name");
					         
					         tree.setItemText(module_id, module_name);


											                dhtmlx.message({ text: data_json.info});
									if(callback)  callback(data_json);
								    if(main_callback) main_callback(data_json);            
								            
								            
								            } else {

								                		dhtmlx.message({ type: "error",  text: data_json.info});

								            }
										} else {
							                 dhtmlx.message({ type: "error", text: "Error"});
									    }
						            	
						            	
						            	
						            	
												
											
											
									});
				
				
				
				
			} 
	    	
	    	
	    	
	    	
///////////////////////////////////////////////////		
		
		}

}(this, undefined));