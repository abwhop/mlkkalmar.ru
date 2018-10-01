

dhtmlXToolbarObject.prototype.MyloadStruct = function (name) { //,callback){
    this.setIconsPath("common/dhxtoolbar/");
   // this.loadStruct("server.php?APP=getUIObject&name=" + name,callback);
  // console.log(name);
   if(ui_data && ui_data[name])
      this.loadStruct(ui_data[name]);

};

dhtmlXToolbarObject.prototype.MyItemsValues = function(){
		var this_toolbar = this;
		var values = Array();
		 this_toolbar.forEachItem(function(itemId){

		        	if(this_toolbar.getType(itemId) == "buttonInput")
		    		values[itemId] = this_toolbar.getValue(itemId);

		    		if(this_toolbar.getType(itemId) == "buttonTwoState")
		    		values[itemId] = this_toolbar.getItemState(itemId);


				});
			return values;
		};
		
		
dhtmlXToolbarObject.prototype.getItemsValues = function(data){
    var tollbar = this;   
     //JSON.stringify()
    var data_str = tollbar.MyItemsValues();  
    
      
     
    if(MODULE_NAME)  $.cookie(MODULE_NAME,);
            
		};		
		
		
dhtmlXToolbarObject.prototype.setItemsValue = function(data){
    var tollbar = this;
    if(data) {
    	
    	//console.log("setItemsValue data",data);
    	
		    		 tollbar.forEachItem(function(itemId){

				       if(data[itemId] != undefined) {
					   	
					 
					  
					  	
				        	if(tollbar.getType(itemId) == "buttonInput")
				        		
							tollbar.setValue(itemId,data[itemId]);
							
				    		

				    		if(tollbar.getType(itemId) == "buttonTwoState")
				    		{
					    		//console.log("setItemsValue data",itemId,data[itemId], tollbar.getItemState(itemId) );				    		
					    		
					    		//if(data[itemId] == "true"){
					    			 
								   		tollbar.setItemState(itemId,data[itemId]);
								//} else {
									
								  // 		tollbar.setItemState(itemId,"false");
								//}   		
                             }
						 } 
						 
						});
            }
		}		