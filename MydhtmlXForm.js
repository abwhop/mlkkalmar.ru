

dhtmlXForm.prototype.MyloadStruct = function (name){

 // console.log(name,ui_data[name]);

  if(ui_data && ui_data[name]){
  	this.loadStruct(ui_data[name]);
  }

};


dhtmlXForm.prototype.MySend = function (name,callback,validate){

//var self = this;
	//this.forEachItem(function(name){
    // console.log(name,self.getItemType(name),self.getItemValue(name),self.isItemHidden(name));
	//});	



  try {
  this.send("/" + name, "post",callback,validate);
   } catch(e){

   console.log(e);

   }// finally {

  // console.log("fin");
  // }


};


dhtmlXForm.prototype.MyloadFormData = function (name,params,callback){
		var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
		 
   window.dhx.ajax.get("/" + name + "/getformdata?" + query_array.join("&"), function(response_data){
     var response_data_json = window.dhx.s2j(response_data.xmlDoc.responseText);

                 		callback(response_data_json)
   });

};



dhtmlXForm.prototype.MyloadFormData2 = function (name,params,callback){
		
			var self = this;
			var query_array = Array();
			 for(item in params){
			 	query_array.push(item + "=" + params[item]);
			 }
			 
	   window.dhx.ajax.get(name + "?" + query_array.join("&"), function(response_data){
	     var response_data_json = window.dhx.s2j(response_data.xmlDoc.responseText);
							if(response_data_json) {
								
								     
	     					self.setFormData(response_data_json);
	     					if(callback)
	                 		callback(response_data_json);
	                 		
	                 		}
	   });

	};



dhtmlXForm.prototype.MyloadFormData3 = function (name,params,callback){
		
			var self_form = this;
	fetch(name + "?" + $.param(params)
	).then(function(response) {
                                        
             if(response.status != 200){
                                    
                                    response.text().then((data)=>{
                                        
                                       	dhtmlx.message({ type: "error",  text: data});   
                                       	console.log(data);
                                        
                                    });
                                   
            }
                    
       return response.json();
	}).then(function(data) {
		
		self_form.forEachItem(function(name){
                        if(data[name])
                            self_form.setItemValue(name,data[name]);
                    });
	if(callback) callback(data);
                                         
                            
	}).catch(function (error) {  
             console.log('Request failed', error);
             dhtmlx.message({ type: "error",  text: error.toString()});  
    });

	};






 dhtmlXForm.prototype.loadToSelects = function(callback){
            
             var lists_content = Array();
        	 var self_form = this;

        	 self_form.forEachItem(function(name){
                         if(self_form.getItemType(name) == "select"){

					var list_name = self_form.getUserData(name,"list_name");

					if(list_name) {

                                      
		                     window.dhx.ajax.get(list_name + "\\list_"  , function(data){
		                     	var Opts = window.dhx.s2j(data.xmlDoc.responseText);
		                     	var color = Array();
		                     	
		                     	if(Opts){

		                  			var localOpts = Array();

		                             for(var i in Opts){

		                               localOpts.push({"text": Opts[i]["item_name"], "value": Opts[i]["item_id"]});
                                       if(Opts[i]["item_color"])
                                       color[Opts[i]["item_id"]] = Opts[i]["item_color"];
		                             }


					          

                                        self_form.setUserData(name,"color",color);

					          

					                  			self_form.reloadOptions(name,localOpts);
					          
                          }//if(Opts)
		                     	
		                     	
							});
		                    

                    	}
				}

             });





        };
        
dhtmlXForm.prototype.RemoveAllItems = function(){        
        
        var items = []; 
	        this.forEachItem(function(name){
	                           
	            items.push(name);
	                            
	        });
	                    
	        for(var i in items) {
	            this.removeItem(items[i]);
	        }
        
};       
        
        
dhtmlXForm.prototype.MygetFormData = function(){
	
var self = this;
var main_form_data = {};
        
        
self.forEachItem(function(name){
            
          //console.log(main_form.getItemType(name));  
               switch(self.getItemType(name)) {
                    case "fieldset": 
                    case "block":
                    case "button":
                    break;    
                    
                    case "calendar": 
                        
                        var dt = new Date(self.getItemValue(name));
                        
                        //var curr_date = d.getDate();
                       
                       /* 
                        if(curr_date < 10)
                        curr_date = "0" + curr_date;
                        
                        var curr_month = d.getMonth() + 1;
                        
                        if(curr_month < 10)
                        curr_month = "0" + curr_month;
                        
                        var curr_year = d.getFullYear();
                       */ 
                        main_form_data[name] =  dt.toLocaleDateString("ru");

                          
                    break;
                    
                    default:
                    main_form_data[name] = self.getItemValue(name);
                    break;
               }
        
        });        
        
  return main_form_data;      
        
};        
        
        
        
        
        
        
dhtmlXForm.prototype.depends_blocks = function(item_name){

                    var self_form = this;
                    var blocks = Array();

		

            self_form.forEachItem(function(name){


                 



            	 var color = self_form.getUserData(name,"color");
	             if(color[self_form.getItemValue(name)]){
	                 $(self_form.getSelect(name)).css("border-color", color[self_form.getItemValue(name)]);
		             }


                                           var type = self_form.getItemType(name);
                                           var item_status = false;

                                           if(type == "input" && self_form.getItemValue(name) > 0) item_status = true;
                                           if(type == "checkbox") item_status = self_form.isItemChecked(name);
                                           
                                           
                                        //   if(type == "select") item_status = self_form.getItemValue(name);

                                           var depends_blocks = self_form.getUserData(name,"depends_blocks");

						if(depends_blocks){


											if(depends_blocks["visible"]){
			                                              for(var i in depends_blocks["visible"]){

			                                                 if(self_form.isItem(depends_blocks["visible"][i])){

			                                                 		if(item_status){

			                                                 		   blocks[depends_blocks["visible"][i]] = "show";

			                                                 		} else {
			                                                 						if(!blocks[depends_blocks["visible"][i]])
			                                                 			           blocks[depends_blocks["visible"][i]] = "hide";
			                                                 		}

			                                                 }

                                              }  //for(var i in depends_blocks["visible"])

                                                   }  //if(service_params_blocks["visible"])



			                                              if(depends_blocks["status"]){

                                                                          for(var k in depends_blocks["status"]){

			                                                 if(self_form.isItem(depends_blocks["status"][k])){

			                                                 		if(item_status){

			                                                 		   blocks[depends_blocks["status"][k]] = "enable";

			                                                 		} else {
			                                                 					//	if(!blocks[depends_blocks["status"][k]])
			                                                 			           blocks[depends_blocks["status"][k]] = "disable";
			                                                 		}

			                                                 }  //if(self_form.isItem(service_params_blocks["status"][i]))


                                                              }  //for(var i in service_params_blocks["status"])

			                                              } //if(depends_blocks["status"])



                              } //if(depends_blocks)




							});





		          for(var block_name in blocks){
		               if(self_form.isItem(block_name)){
		               	             //	console.log(block_name,blocks[block_name]);


		               	                if(blocks[block_name] == "show")  self_form.showItem(block_name);
		                                if(blocks[block_name] == "hide")  self_form.hideItem(block_name);
		                                if(blocks[block_name] == "enable")  self_form.enableItem(block_name);
		                                if(blocks[block_name] == "disable")  self_form.disableItem(block_name);
		               }  //if(self_form.isItem(block_name))


		          } //for(var block_name in blocks)


		}   
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
 dhtmlXForm.prototype.loadToSelects2 = function(callback){
            
             var lists_content = Array();
        	 var self_form = this;
        	 var lists_list = {};
        	 var list_on_select = {};
        	 var list_on_select2 = {};
			 var list_name;
        	 	lists_list["lists"] = [];

        	 self_form.forEachItem(function(name){
                         
                         if(self_form.getItemType(name) == "select"){

							list_name = self_form.getUserData(name,"list_name");
							
								if(list_name) {
									 lists_list["lists"].push(list_name);
									 list_on_select[list_name] = name;
									 list_on_select2[name] = list_name; 
									}
							}

             	});



			fetch("lists/list?" + $.param(lists_list))
			.then(function(response) {
                        
                                        
                                if(response.status != 200){
                                    
                                    response.text().then((data)=>{
                                        
                                       	dhtmlx.message({ type: "error",  text: data});   
                                       	console.log(data);
                                        
                                    });
                                   
                                }
                    
                        return response.json();
        	})
            .then(function(data) {
                            console.log(data); //
                            var list_opts = [];
                           	var color = [];
                           for(var name in list_on_select2){
						   	list_opts = [];
						   
						  for(var list_name in data[list_on_select2[name]]){
						  	
						  
						   list_opts.push({"text":data[list_on_select2[name]][list_name]["item_name"], "value": data[list_on_select2[name]][list_name]["item_id"]});
						   if(data[list_on_select2[name]][list_name]["item_color"])
                                       color[data[list_on_select2[name]][list_name]["item_id"]] = data[list_on_select2[name]][list_name]["item_color"];	
							}
							
											
												   
						   console.log(name,list_opts);
						   self_form.setUserData(name,"color",color);
						   self_form.reloadOptions(name,list_opts);
						   
						   }
                            
                            //console.log(list_on_select2);
                            
                             
                          
                          /*
                            var Opts = [];
                            var color = [];
                            //if(data.status)
                             //     dhtmlx.message({ text: data.info});
                             //     if(data.srv_id){
                              //        main_form.setItemValue("srv_id",data.srv_id);
                              //    }
                  for(var list_name in data)
                  {
					Opts = data[list_name];
						
						if(Opts){

		                  			var localOpts = [];

		                             for(var i in Opts){

		                               localOpts.push({"text": Opts[i]["item_name"], "value": Opts[i]["item_id"]});
                                      
                                       if(Opts[i]["item_color"])
                                       color[Opts[i]["item_id"]] = Opts[i]["item_color"];
                                       
                                       
		                             }


					          console.log(list_on_select[list_name],data);

                                     //   self_form.setUserData(list_on_select[list_name],"color",color);				          

					                  	self_form.reloadOptions(list_on_select[list_name],localOpts);
					          
                          }//if(Opts)
						
						
						
				  }            
              */
              
              
              
              
                              
                              
            if(callback) callback();                 
                            
           })
                       
           .catch(function (error) {  
                        console.log('Request failed', error);
                        	dhtmlx.message({ type: "error",  text: error.toString()});  
           });
        


        };		