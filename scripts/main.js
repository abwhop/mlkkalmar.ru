requirejs.config({

urlArgs: "myparam=" + (new Date()).getTime(),
    //By default load any module IDs from js/lib
    baseUrl: './frontend',
    //except, if the module ID starts with "app",
    //load it from the js/app directory. paths
    //config is relative to the baseUrl, and
    //never includes a ".js" extension since
    //the paths config could be for a directory.
    paths: {
        dhtmlx: '../codebase/dhtmlx'
    }
});





requirejs(['jquery','mydhtmlx','mymqtt','auth'],function($,dhtmlx,mymqtt,auth) {

      var loaded_module;

	  this.activeWin = {};

      this.dhxWins = new dhtmlXWindows();

	  this.run_app =  function(name,params){

		    if(!params) params = {};

			params.name = name;
			params.dhxWins = dhxWins;
			params.activeWin = activeWin;

				require([name],function(obj){

					//console.log("%c" + params + " %c" + obj,"color:red","color:blue");

					new obj(params);

				});
		}


  auth(function(){
      	var  mqtt = new mymqtt();

		mqtt.on('connect',    function() {
            console.log("I'm connected");
            mqtt.subscribe("leter_all", 1);
			mqtt.subscribe("global_commands", 1);
            });

		mqtt.on('message', function(topic,payload){

		//	console.log(topic,payload);



		//	document.dispatchEvent(new CustomEvent('msg',{'detail':{ "topic": topic, "payload" : payload}}));

			if(topic == "leter_all")  dhtmlx.message({ text: payload});

			if(topic == "global_commands") {

			var commandBlock = JSON.parse(payload);

				if(commandBlock && commandBlock.command){
					console.log(commandBlock.command);
					if(commandBlock.command == "reload") location.reload();
				}

			}


		});

		mqtt.connect("main");



   	var mainInterface = new dhtmlXLayoutObject({parent: document.body,pattern: "2U",skin:"dhx_skyblue"});
   		mainInterface.cells("a").setWidth(185);
		mainInterface.cells("a").hideHeader();
		mainInterface.cells("b").hideHeader();
        this.cont =	mainInterface.cells("b");
	var myTreeView = mainInterface.cells("a").attachTreeView({
    json: "menu.json",
    onload: function(){
        // callback, optional
    }

	});
	myTreeView.attachEvent("onSelect", selectPage);



   function selectPage(id, mode){

							var params = JSON.parse(this.getUserData(id,"params"));
							if(!params) params = {};
								params.name = this.getUserData(id,"name");

								params.parent = cont;

      	if(mode) {
     		require([params.name],function(module){

     		   loaded_module = new module(params);


     		});
     	 } else {
     	 	loaded_module.destroy();
     	 	loaded_module = null;
     	 	cont.detachObject(true);

              }
   }

      });





});