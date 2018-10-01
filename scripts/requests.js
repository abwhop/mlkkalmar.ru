define(['jquery','mydhtmlx','mymqtt'],function ($,mydhtmlx,mymqtt) {
       return function(params){
    var self = this;



  //  var  mqtt = new MqttClient({ host :'localhost', port : 1884, reconnect: 1000, username: "kirill", password: "deytrin21", clientId: "kirill_requests_edit_" + makeid()});

    var mqtt = new mymqtt(params.name);


		if(params && params.parent && params.parent.attachLayout) {
			var	cont = params.parent.attachLayout("1C");
		} else {
			var	cont = params.parent.attachLayout("1C");
			var cont = new dhtmlXLayoutObject(parentId, "1C", "dhx_skyblue");
		}


		var main_cell = cont.cells("a");
			main_cell.hideHeader();

		var toolbar  = main_cell.attachToolbar();


		var mygrid = main_cell.attachGrid();
			mygrid.setDataSrcName("/v1/requests/show");
			mygrid.setNotifier(mqtt);
			/////////////////////////////////////
			mygrid.setImagePath("./codebase/imgs/");
			mygrid.setHeader("Sales,Book title,Author,Price");//the headers of columns
			mygrid.setInitWidths("100,250,150,100");          //the widths of columns
			mygrid.setColAlign("right,left,left,left");       //the alignment of columns
			mygrid.setColTypes("ro,ed,ed,ed");                //the types of columns
			mygrid.setColSorting("int,str,str,int");          //the sorting types
			////////////////////////////////////
			mygrid.Myinit();
			mygrid.attachEvent("onRowDblClicked", function(rId,cInd){
					run_app("requests_edit",{"item_id":rId});
			});
		var data={
						rows:[
							{ id:1, data: ["1","A Time to Kill", "John Grisham", "100"]},
							{ id:2, data: ["2","Blood and Smoke", "Stephen King", "1000"]},
							{ id:3, data: ["3","The Rainmaker", "John Grisham", "-200"]}
						]
					};
			//mygrid.parse(data,"json");
	mygrid.fullLoad();




	console.log("requests Loaded");





	this.destroy =  function(){

	if(mqtt.connected)
	mqtt.disconnect();

		console.log("Unloaded");
		delete this;
	};

	//////////////////////////////




	//this.addListen("/contragents/show",function(e){

	//	console.log(e);

	//});
















       };
});