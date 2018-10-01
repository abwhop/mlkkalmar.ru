

dhtmlXList.prototype.Myload = function(app,params,callback){
	
	
	 var query_array = Array();
		 for(item in params){
		 	query_array.push(item + "=" + params[item]);
		 }
		 if(callback)
	  	this.load(app + "?" + query_array.join("&"),callback ,"json");
	  	 else
	  	this.load(app + "?" + query_array.join("&"),"json");

  


}