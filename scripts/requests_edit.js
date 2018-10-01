define(['jquery','mydhtmlx','mymqtt'],function($,mydhtmlx,mymqtt) {   
    
    return function(params){
    	
    	var self = this;
    	var win;
		
		
		
    	
    
    	// var dhxWins = new dhtmlXWindows();
    if(params && params.dhxWins) {
		win = params.dhxWins.createWindow("dd", 100, 100, 400, 300);

	} else {
		var dhxWins = new dhtmlXWindows();
			dhxWins.attachEvent("onFocus", function(win){
							console.log("global event onFocus was called for "+win.getText());
							params.activeWin = win;
							
							console.log(params.activeWin);
						});		
		win = dhxWins.createWindow("dd", 100, 100, 400, 300);
	}
	
	
	
	
	win.attachEvent("onFocus", function(win){
				console.log("global event onFocus was called for "+win.getText());
				params.activeWin = win;
				
				console.log(params.activeWin);
			});
    
    
    win.attachHTMLString("<div>Item ID = " + params.item_id + "</div>");
    
    


    
	var  mqtt = new mymqtt(params.name);
       	
 
      
      
    mqtt.on('connect',    function() {
            console.log("I'm connected", "req_ed");
            mqtt.subscribe("/contragents/show", 1);

            });

		mqtt.on('message', function(topic,payload){

			console.log(topic,payload);

			win.attachHTMLString(payload);
   	
				}); 
    
      mqtt.connect();
    
	this.destroy =  function(){

		mqtt.disconnect();


		console.log("Unloaded");
		delete this;
	};
	
	//////////////////////////////
	
	
	
	
    
    
    
    
    
    win.attachEvent("onClose", function(win){
    	
    	self.destroy();
    	
     console.log("Destroy");
		
		return true;
		});
    
    console.log(params);
    	
    };
    
   
    }	
	    
	);	