(function (G, U,Modules){
    "use strict";
    var $ = G.jQuery,
        bool   = "boolean",
        string = "string",
        number = "number",
        object = "object";


	var module = new Module();



	Modules.loaded[Modules.id] = module ;
	
	module.id = Modules.id;
	module.init =  function() {
	
	console.log("Loaded", Modules.id,this.module_name);
	
	
	function hello(event) {
    console.log( event.detail.name,module.id,module.module_name);
  	}	
			
	this.addListen("hello",hello);
				
			
			};



	


}(this, undefined, Modules))

