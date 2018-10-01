(function (G, U){
    "use strict";
    var $ = G.jQuery,
        bool   = "boolean",
        string = "string",
        number = "number",
        object = "object";

	G._____action = function(params,callback){		
////////////////////////////////////////////////////////////
			
		//var conteiner = addWindow({"name": "window","posx": 20,"posy": 20,"type": "window","modal": false,"width": "450","height": "400","winname": "Коттрагенты","maximize": false});
	
	var self_win = dhtmlWindows.MycreateWindow("contragents_list_window");
	      window.active_win = self_win;   //передаем в глобальную переменную объект нового окна
	      self_win.statusbar = self_win.attachStatusBar();
	
		//var self_win = conteiner;
	    	self_win.center();
	
		var	win_form = self_win.attachLayout("3E");
	
	  	var form_cell = win_form.cells("a");
			form_cell.hideHeader();
			form_cell.setHeight(40);
	
		var list_cell = win_form.cells("b");
			list_cell.hideHeader();
         
        var button_cell = win_form.cells("c");
			button_cell.hideHeader();
			button_cell.setHeight(50); 
   
   
 /////////////////////////////////////////////////////////  
   
         
        var list = list_cell.attachList({
            	template:"<span><b>#item_name#</b> (#inn#)</span><br><span style='font: 8pt sans-serif;'>#post_address#</span>",
				type:{ height:"auto" }
				});
            list.attachEvent("onItemDblClick", function (id, ev, html){
				   self_win.select(this.get(id));

				    return true;
				});

		var main_form = form_cell.attachForm();
			main_form.MyloadStruct("contragents_list_form");

        	//main_form.MyloadFormData(name,params,function(response_data){
		    //        main_form.setFormData(response_data);
		    //        list.Myload("contragents/list_",{"item_name":main_form.getItemValue("contragent_name")});
       		//});
       
			main_form.attachEvent("onKeyUp",function(inp, ev, name, value){
			        list.clearAll();
			        list.Myload("contragents/list_",{"item_name":main_form.getItemValue("contragent_name")});
       		});


       	var button_form = button_cell.attachForm();
	   		button_form.adjustParentSize();
			button_form.MyloadStruct("ok_close_form");
       		button_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{

							case "ok":
					              self_win.select(list.get(list.getSelected()));

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
///////////////////////////////////////////////////		
		
		}

}(this, undefined));