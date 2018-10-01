
 dhtmlXGridObject.prototype.MyloadStruct = function(name){

		var self = this;
		 if(ui_data && ui_data[name]){
		        var data_json = ui_data[name];
//self.ui_data = ui_data[name];

			        if(data_json["header"])
			        	self.setHeader(data_json["header"].join(','));
			        if(data_json["columnIds"])
						self.setColumnIds(data_json["columnIds"].join(','));
					if(data_json["initwidths"])
						self.setInitWidths(data_json["initwidths"].join(','));
					if(data_json["colalign"])
						self.setColAlign(data_json["colalign"].join(','));
					if(data_json["coltypes"])
						self.setColTypes(data_json["coltypes"].join(','));
					if(data_json["colsorting"])
						self.setColSorting(data_json["colsorting"].join(','));
		   			if(data_json["imagepath"])
			        	self.setImagePath(data_json["imagepath"]);
			        else
			        	self.setImagePath("common/");
	        	}

			


	        this.init();
	//	});


  	};
  	
  	
 dhtmlXGridObject.prototype.MyloadStruct2 = function(name){

		var self = this;
		
	if(ui_data && ui_data[name]){
		        var data_json = ui_data[name];	
		 					var align = Array();
							var id = Array();
							var sort_ = Array();
							var type = Array();
							var value = Array();
							var width = Array();	
							
						self.setImagePath("common/");	
							
							for(var item_ in data_json.head){
								align[item_] = data_json.head[item_].align;
								id[item_] = data_json.head[item_].id;
								sort_[item_] = data_json.head[item_].sort;
								type[item_] = data_json.head[item_].type;
								value[item_] = data_json.head[item_].value;
								width[item_] = data_json.head[item_].width;
								//console.log(application_struct.head[item_].value);
								
							}
							
							
							
							
							self.setHeader(value.join(","));
							self.setInitWidths(width.join(","));
							self.setColAlign(align.join(","));
							self.setColTypes(type.join(","));
							self.setColSorting(sort_.join(","));
							self.setColumnIds(id.join(","));
							
							
							
							if(data_json.header)
							self.attachHeader(data_json.header.join(","));		


	        self.init();
	}


  	}; 	
  	
  	
dhtmlXGridObject.prototype.MyloadStruct3 = function(data_json){

		var self = this;
		
	if(data_json){
		        
		        if(data_json.foot){								
				self.attachFooter(data_json.foot);
				}
		 					var align = Array();
							var id = Array();
							var sort_ = Array();
							var type = Array();
							var value = Array();
							var width = Array();	
							
						self.setImagePath("common/");	
							
							for(var item_ in data_json.head){
								align[item_] = data_json.head[item_].align;
								id[item_] = data_json.head[item_].id;
								sort_[item_] = data_json.head[item_].sort;
								type[item_] = data_json.head[item_].type;
								value[item_] = data_json.head[item_].value;
								width[item_] = data_json.head[item_].width;
								//console.log(application_struct.head[item_].value);
								
							}
							
							
							
							
							self.setHeader(value.join(","));
							self.setInitWidths(width.join(","));
							self.setColAlign(align.join(","));
							self.setColTypes(type.join(","));
							self.setColSorting(sort_.join(","));
							self.setColumnIds(id.join(","));
							
							
							
							if(data_json.header)
							self.attachHeader(data_json.header.join(","));		


	        self.init();
	}


  	};
  	
dhtmlXGridObject.prototype.setDataSrcName = function(DataSrcName){
				if(DataSrcName != "")
					this.DataSrcName = DataSrcName;
				
			};  	
dhtmlXGridObject.prototype.setConfigIndex =  function(ConfigIndex){
				if(ConfigIndex != "")
					this.ConfigIndex = ConfigIndex;
				
			};  	
 
 

dhtmlXGridObject.prototype.fullLoad2 = function(params,callback){
	  	
	    var self = this;
	  	self.clearAll();
		if(!params)	 params = {};
		params["requesting_oblect_type"] = "grid";
		
	var query_array = Array();
		 for(item in params){ 	query_array.push(item + "=" + params[item]);  }
		 
		if(self.DataSrcName){
			
			  self.load(self.DataSrcName + "?" + query_array.join("&"),function(){
		  		  	
				if(callback) callback();		
		  	
		  },"json");
		 
		} else {
	
		console.error("Для таблицы не определен параметр имя источника данных (DataSrcName)");
	
		} 
		 
	  	
	};

 
 
  	 	  	

dhtmlXGridObject.prototype.fullLoad = function(app,params,callback){
	  	//var data = {ARGS:params};
	    var thisGrid = this;
	  	thisGrid.clearAll();
		//thisGrid.load("server1.php?DATA=" + encodeURIComponent(json_str(data)) ,"json");
	   // thisGrid.load("server.php?APP=" + app + "&DATA=" + encodeURIComponent(json_str(data)) ,"json");
	   
	  	 var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
		 
		
		  thisGrid.load(app + "?" + query_array.join("&"),function(){
		  				  	
				if(callback) callback();		
		  	
		  },"json");
		  
			
		 /*
		 window.dhx.ajax.get(app, query_array.join("&"), function(r){
			    
			    console.log(r);
			    
			    var t = window.dhx.s2j(r.xmlDoc.responseText); // convert response to json object
			    if (t != null) {
			    	
			    	console.log(thisGrid,app, query_array);
			    	
			       thisGrid.parse(t,"json");
			       if(callback) callback();
			    }
			});
		// 
		 
		 */
		 
		 
	  	 
	};

dhtmlXGridObject.prototype.Myupdate = function(params,app){
    //var data = {ARGS:params};
    var thisGrid = this;
    
     var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
    
    thisGrid.updateFromJSON(app + "?" + query_array.join("&"), false, false);
			   setTimeout(function(){
			thisGrid.markCells();	
				
			},500);
   

	};

dhtmlXGridObject.prototype.insert = function(params,app){
   // var data = {ARGS:params};
    var thisGrid = this;
    
    var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
    
    thisGrid.updateFromJSON(app + "?" + query_array.join("&"), "top");
			//setTimeout(function(){
			//thisGrid.markCells();	
				
			//},500);
	
	};

dhtmlXGridObject.prototype.delete = function(params,app){
 	//var data = {ARGS:params};
    var thisGrid = this;
     var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
    
	thisGrid.updateFromJSON(app + "?" + query_array.join("&"), true, true);
       };



dhtmlXGridObject.prototype.markCells = function(){
	var thisGrid = this;       
 thisGrid.forEachRow(function(row_id){
						
			thisGrid.forEachCell(row_id,function(cellObj,ind){
			if(ui_data["grid_fields"][thisGrid.getColumnId(ind)] && ui_data["grid_fields"][thisGrid.getColumnId(ind)][thisGrid.cells(row_id,ind).getValue()])
			{
				thisGrid.cells(row_id,ind).setBgColor(ui_data["grid_fields"][thisGrid.getColumnId(ind)][thisGrid.cells(row_id,ind).getValue()]); 
						
			}
			
				});
			}); 	       
};




dhtmlXGridObject.prototype.unmarkCells = function(){
	var thisGrid = this;       
 thisGrid.forEachRow(function(row_id){
						
			thisGrid.forEachCell(row_id,function(cellObj,ind){
			//if(ui_data["grid_fields"][thisGrid.getColumnId(ind)] && ui_data["grid_fields"][thisGrid.getColumnId(ind)][thisGrid.cells(row_id,ind).getValue()])
			//{
				thisGrid.cells(row_id,ind).setBgColor(""); 
						
			//}
			
				});
			}); 	       
};  


dhtmlXGridObject.prototype.markCell = function(row_id){
	var thisGrid = this;       
 //thisGrid.forEachRow(function(row_id){
				
		//	console.log(row_id);	
						
			thisGrid.forEachCell(row_id,function(cellObj,ind){
			if(ui_data["grid_fields"][thisGrid.getColumnId(ind)] && ui_data["grid_fields"][thisGrid.getColumnId(ind)][thisGrid.cells(row_id,ind).getValue()])
			{
				
				
				var color = ui_data["grid_fields"][thisGrid.getColumnId(ind)][thisGrid.cells(row_id,ind).getValue()];
				
				
				//console.log(row_id,ind,color);
					
				thisGrid.cells(row_id,ind).setBgColor(color); 
						
			}
			
				});
		//	}); 	       
}


dhtmlXGridObject.prototype.getGridData = function(){
						var gridData = {};
						//var rows = 0;
						this.forEachRow(function(id){
						gridData[id] = this.getRowData(id);
						//rows++;
						});
						
				//	console.log(rows);	
					return 	gridData; 
					}        


dhtmlXGridObject.prototype._subscribed = [];
 
dhtmlXGridObject.prototype.subscribe = function(topic,callback){
			
			 
			 var self = this; 	

			 if(this._mqtt && this._mqtt.subscribe){
			 	 this._mqtt.subscribe(topic, 1);
			 	 console.log("subscribe",topic);
			 }
			
			
			/*
				var lstnr_callback = function(e){
				if(e && e.detail && e.detail.topic && e.detail.topic == topic && e.detail.payload){
					
					//console.log("lstnr_callback",this,self);	
						
						var payload = JSON.parse(e.detail.payload);
						
						if(payload !== null)
						//callback(payload);
						
						self.ChangeMsg(payload);
					
				}
				
				
				
			}; */
			
			//this._subscribed.push({"topic":topic,"callback":lstnr_callback});
			
			
			this._mqtt.on('message', function(topic1,payload){
				
				//console.log(topic1,payload);
				if(topic == topic1)
				{
					var payload = JSON.parse(payload);
						
						if(payload !== null){
						
						
						self.ChangeMsg(payload);
						}
						
				}
				
			});				
							
//document.addEventListener('mqtt_msg',lstnr_callback, false);





	};


dhtmlXGridObject.prototype.unsubscribeAll = function(){
	
	for(var item in this._subscribed){
		
		 if(this._mqtt && this._mqtt.unsubscribe){
		this._mqtt.unsubscribe(this._subscribed[item].topic);
				}
		document.removeEventListener('mqtt_msg', this._subscribed[item].callback);
		
		console.log("unsubscribe",this._subscribed[item]);
		
		delete this._subscribed[item];
	}
	
		};	 
dhtmlXGridObject.prototype.ChangeMsg = function(payload){
        
      //  console.log(this);
        
        if(payload){
            
               if(payload !== null &&  payload.operation){
                   
                   switch(payload.operation){
                       
                        case "update": 
                             //   table.MyRowUpdate(payload.item_id);
                                this.MyRowUpdate(payload.item_id);
                       	        console.log("update", payload.item_id);
                        break;  
                       
                        case "insert":
                             //   table.MyRowInsert(payload.item_id);
                                this.MyRowInsert(payload.item_id);
                                console.log("insert", payload.item_id);
                        break;
                        
                        case "delete":
                                this.deleteRow(payload.item_id);
                              //  this.MyDelete(payload.item_id);
                                console.log("delete", payload.item_id);
                        break;
                        
                       
                   }
                  
                }
            
        }
        
    
       
        
    };
 
 dhtmlXGridObject.prototype.MyRowUpdate = function(id){
                    var self = this;
                    if(self.doesRowExist(id))
                    window.dhx.ajax.get(self.DataSource + "?item_id=" + id, function(r){
                             var t = window.dhx.s2j(r.xmlDoc.responseText); // convert response to json object
    			             if (t !== null && t.rows && t.rows[0] && t.rows[0].data) {
    			                 
    			                 var data = t.rows[0].data;
    			                 var new_data = {};
    			                 
    			                 for(var cell in data){
    			                     
    			                   var cell_id =  self.getColumnId(cell);
    			                   
    			                     if(cell_id)
    			                     new_data[cell_id] = data[cell];
    			                 }
    			                 
    			                self.setRowData(id,new_data); // setting new data for the row with id "row1"
                                self.markCell(id);
                                //if(t.rows[0].userdata)
                                //self.setUserData(id,"someName1","new value");
    			             }
                    });     
		    
             };
             
             
dhtmlXGridObject.prototype.MyRowInsert = function(id){
                    var self = this;
                    window.dhx.ajax.get(self.DataSource + "?item_id=" + id, function(r){
                             var t = window.dhx.s2j(r.xmlDoc.responseText); 
    			             if (t !== null && t.rows && t.rows[0] && t.rows[0].data) {
    			            
                                self.addRow(id,t.rows[0].data,0);
                                //if(t.rows[0].userdata)
                                //self.setUserData(id,"someName1","new value");
    			             }
                    });     
		    
             };         
