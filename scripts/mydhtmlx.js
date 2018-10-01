define(['dhtmlx','localforage.min'],function (dhtmlx,localforage) {

 function get_auth_token(callback){

       var store = localforage.createInstance();
		store.config({driver: localforage.INDEXEDDB,name: 'logistic',version: 1.0,size: 4980736,storeName: "auth",description : 'some description'});

		store.getItem('token', function (err, token) {
                callback(token);
         });
 }



	dhtmlXGridObject.prototype.setDataSrcName = function(DataSrcName){
				if(DataSrcName != "")
					this.DataSrcName = DataSrcName;

			};

	dhtmlXGridObject.prototype.setNotifier = function(Notifier){
				if(Notifier && Notifier.connect && Notifier.subscribe && Notifier.unsubscribe)
					this.Notifier = Notifier;

			};
	dhtmlXGridObject.prototype.Myinit = function(){
				this.init();


				//console.log("init",this.DataSrcName , this.Notifier);
				var self = this;

				if(this.DataSrcName && this.Notifier){

					this.Notifier.on('connect',    function() {
									console.log("I'm connected", "req");
									this.subscribe(self.DataSrcName, 1);
									});
					this.Notifier.on('message', function(topic,payload){

										if(topic == self.DataSrcName && payload != ""){
										 var payload_json =	JSON.parse(payload);

										 if(payload_json !== null && payload_json.operation && payload_json.item_id)
										 self.ChangeMsg(payload_json);

										}


									});
					if(!this.Notifier.connected){
							this.Notifier.connect();
					} else {
							this.Notifier.subscribe(self.DataSrcName, 1);
					}


				}

			};


dhtmlXGridObject.prototype.ChangeMsg = function(msg){

      //  console.log(this);

        if(msg !== null && msg.operation){



                   switch(msg.operation){

                        case "update":

                                this.MyRowUpdate(msg.item_id);
                       	        console.log("update", msg.item_id);
                        break;

                        case "insert":

                                this.MyRowInsert(msg.item_id);
                                console.log("insert", msg.item_id);
                        break;

                        case "delete":
                                this.deleteRow(msg.item_id);

                                console.log("delete", msg.item_id);
                        break;


                   }

                }






    };





dhtmlXGridObject.prototype.MyRowUpdate = function(id){
                    var self = this;
                    if(self.doesRowExist(id)){
						var params = {};
						params["requesting_oblect_type"] = "grid";
						params["item_id"] = id;
						var getData = new dhtmlX();

						getData.getPostData(self.DataSrcName,params,function(resp_data) {
						//window.dhx.ajax.post(self.DataSrcName, "item_id=" + id, function(r){
								// var t = window.dhx.s2j(r.xmlDoc.responseText); // convert response to json object
								 if (resp_data.rows && resp_data.rows[0] && resp_data.rows[0].data) {

									 var data = resp_data.rows[0].data;
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
					}
             };


dhtmlXGridObject.prototype.MyRowInsert = function(id){
                    var self = this;
					var getData = new dhtmlX();
					var params = {};
					params["requesting_oblect_type"] = "grid";
					params["item_id"] = id;


					getData.getPostData(self.DataSrcName,params,function(resp_data) {

    			             if (resp_data.rows && resp_data.rows[0] && resp_data.rows[0].data) {

                                self.addRow(id,resp_data.rows[0].data,0);
                                //if(t.rows[0].userdata)
                                //self.setUserData(id,"someName1","new value");
    			             }
                    });

             };



dhtmlXGridObject.prototype.fullLoad = function(params,callback){

	    var self = this;
	  	self.clearAll();
		if(!params)	 params = {};
		params["requesting_oblect_type"] = "grid";

		get_auth_token(function(token){

				params["token"] = token;
                var query = [];
				if(params){
					for(var name in params)
					query.push(name + "=" + params[name]);
				}

				self.load(self.DataSrcName + "?" + query.join("&"),callback,"json");

        });




	};




function dhtmlX(){

			this.getPostData = function(DataSrcName,params,callback){
				var query = [];

				if(params){
					for(var name in params)
					query.push(name + "=" + params[name]);
				}

				console.log(query);

				window.dhx.ajax.post(DataSrcName, query.join("&"), function(r){
						 var t = window.dhx.s2j(r.xmlDoc.responseText);
										 if (t !== null && callback) callback(t);




				});
			};


}




});


