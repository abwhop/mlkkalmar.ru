var toolbar  = self_win.attachToolbar();
	 		toolbar.MyloadStruct(name + "_form_toolbar");
	    var	win_form = self_win.attachLayout("3U");
	  	var form_cell = win_form.cells("a");
	        this.form_cell = form_cell;
			form_cell.hideHeader();
			form_cell.setWidth(875);

		var tables_cell = win_form.cells("b");
            tables_cell.hideHeader();
        var tables_cell_la =  tables_cell.attachLayout("2E");

        var services_table =  tables_cell_la.cells("a");
        services_table.setText("Услуги и стоимость");
        services_table.setHeight(400);

	    var srvs_table = services_table.attachGrid();
	    srvs_table.enableAccessKeyMap();
	    srvs_table.enableExcelKeyMap();
	
		srvs_table.MyloadStruct(name +"_services_grid");
 		srvs_table.fullLoad("requests_services/show",{"rq_id": params["item_id"]});

     var statuses_table =  tables_cell_la.cells("b");
	     statuses_table.setText("Этапы выполнения заявки");;
     var sts_table = statuses_table.attachGrid();
    sts_table.enableAccessKeyMap();
    sts_table.enableExcelKeyMap();
    
	sts_table.MyloadStruct("requests__statuses_grid",{"rq_id": params["item_id"]});
	
	
	
	
	
	
// 	sts_table.fullLoad({},name +"_statuses_view");



           // table_cell.setWidth(350);
		var button_cell = win_form.cells("c");
			button_cell.hideHeader();
			button_cell.setHeight(50);

       var main_form = form_cell.attachForm();
       main_form.MyloadStruct(name + "_form");

       main_form.loadToSelects();

      
      
       setTimeout(function(){
       	
       	if(params["pattern"])
       	name2 = "requests_patterns";
       	else
       	name2 = name;
       main_form.MyloadFormData(name2,params,function(response_data){



	        main_form.setFormData(response_data);
            main_form.depends_blocks();
            
          //  setInterval(function(){
            	
            if(!main_form.getItemValue("rq_id") && main_form.getItemValue("auto_date"))
            	{
									
					main_form.setItemValue("rq_date",new Date());		
				}
           // } ,1000);
            
            
            
            console.log(main_form.getItemValue("rq_id"));

       });
        },500);
        
        
        
        

       var button_form = button_cell.attachForm();
	   button_form.adjustParentSize();
	   button_form.MyloadStruct("createpattern_ok_save_print_close_form");



       button_form.attachEvent("onButtonClick",function(item_name){
				     var self = this;
					switch (item_name) 	{
						
							case "createpattern":

					               self_win.save(function(){},true);
							break;					
						
						
							case "save":

					               self_win.save(function(){
					               	
					               	
					               });
							break;

							case "ok":
					              self_win.save(function(){
					              	     // 	 if(self_win.close);
					              	       	 self_win.close();
					              });

							break;

							case "close":
								self_win.close();
								//self = null;
							break;
							
							case "print": 
										if(params["item_id"])
										var item_id = params["item_id"]; 
										
										 else
										 var item_id = main_form.getItemValue("rq_id");
										 
										 
										 if(item_id)
											document.getElementById("print_body").src = "/" + name + "/print?item_id=" + item_id;
											else
											dhtmlx.alert("Не выбран объект для печати!");
							break;
					}
		});
		main_form.attachEvent("onChange",function(item_name,item_value){

					var self_form = this;
					
		self_form.setItemValue("cargo_volume",self_form.getItemValue("cargo_volume").replace(',','.').replace(/[a-zA-Zа-яА-Я]/g, ''));
		self_form.setItemValue("cargo_quantity",self_form.getItemValue("cargo_quantity").replace(',','.').replace(/[a-zA-Zа-яА-Я]/g, ''));
		self_form.setItemValue("cargo_weight",self_form.getItemValue("cargo_weight").replace(',','.').replace(/[a-zA-Zа-яА-Я]/g, ''));			
					
					if(item_name == "cargo_weight" || item_name == "cargo_volume"){
         

	

		                   
		                   var cargo_volume = parseFloat(self_form.getItemValue("cargo_volume"));
		                   var cargo_weight = parseFloat(self_form.getItemValue("cargo_weight"));
		                   var cargo_density = 0;

		                   if(cargo_volume > 0){

							cargo_density =  cargo_weight/cargo_volume;

		                    self_form.setItemValue("cargo_density",Math.round(cargo_density,3));
		                   }

                 	}
					
					
					self_form.depends_blocks(item_name);



		});




		main_form.attachEvent("onButtonClick",function(item_name){
				     var self_form = this;
					switch (item_name) 	{
							case "contragents_payer":
       								getForm("contragents_list",{"item_id":0},function(response_data){

		       								console.log(response_data);

		       								if(response_data && response_data.item_id){

                                                self_form.setItemValue("contragent_payer_id",response_data.item_id);
                                                self_form.setItemValue("contragent_payer",response_data.item_name);

		       								}
       								 });
							break;
                           case "contragents_sender":
       								getForm("contragents_list",{"item_id":0},function(response_data){

		       								console.log(response_data.item_id);

		       								if(response_data && response_data.item_id){

                                                self_form.setItemValue("contragent_sender_id",response_data.item_id);
                                                self_form.setItemValue("contragent_sender",response_data.item_name);
												
												if(response_data.post_address)
													self_form.setItemValue("contragent_sender_address",response_data.post_address);
												else 
													self_form.setItemValue("contragent_sender_address","");
																								
												if(response_data.contact_phone && response_data.contact_face)
													self_form.setItemValue("contragent_sender_contact",response_data.contact_phone + " " + response_data.contact_face);
												else if(response_data.contact_phone)
													self_form.setItemValue("contragent_sender_contact",response_data.contact_phone);
												else
													self_form.setItemValue("contragent_sender_contact","");	
												
		       								}
       								 });
						break;
                           case "contragents_reciever":
       								getForm("contragents_list",{"item_id":0},function(response_data){

		       								console.log(response_data.item_id);

		       								if(response_data && response_data.item_id){

                                                self_form.setItemValue("contragent_reciever_id",response_data.item_id);
                                                self_form.setItemValue("contragent_reciever",response_data.item_name);
                                                
                                                
                                                if(response_data.post_address)
													self_form.setItemValue("contragent_reciever_address",response_data.post_address);
												else
													self_form.setItemValue("contragent_reciever_address","");	
												
												if(response_data.contact_phone && response_data.contact_face)
													self_form.setItemValue("contragent_reciever_contact",response_data.contact_phone + " " + response_data.contact_face);
											    else if(response_data.contact_phone)
													self_form.setItemValue("contragent_reciever_contact",response_data.contact_phone);
												else
													self_form.setItemValue("contragent_reciever_contact","");

		       								}
       								 });
							break;
							
							
					}
		});





	self_win.save = function(onSend,pattern){
var name2;
		if(pattern)
		name2 = name +"_patterns"
		else
		name2 = name;
		
		main_form.MySend(name2 + "/change",function(response_data){

				var data_json = window.dhx.s2j(response_data.xmlDoc.responseText);
			//	if(onSend) onSend();

						
				if (data_json && data_json != null){
					    		if(data_json.status) {
						        	       		if(onSend)  onSend();
												self_callback(data_json);
										
										
										
										srvs_table.fullLoad("requests_services/show",{"rq_id": params["item_id"]});
	sts_table.MyloadStruct("requests__statuses_grid",{"rq_id": params["item_id"]});
												
												
												
										
										if(main_form && main_form.setFormData)
										main_form.setFormData(data_json);

						                dhtmlx.message({ text: data_json.info});

			                		} else {

			                		dhtmlx.message({ type: "error",  text: data_json.info});

			                		}
			    } else {
                 dhtmlx.message({ type: "error", text: "Error"});

               	}
				
				
				
    	},true);



     //callback();
	}



	}