define(['mqttws31','mqtt-client'],function () {
       return function(app_name){
		   
		   if(!app_name) app_name = "";
		   
		    function makeid(length) {
								  var text = "";
								  if(!length) length = 8;
								  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+=";

								  for (var i = 0; i < length; i++)
									text += possible.charAt(Math.floor(Math.random() * possible.length));

								  return text;
									}      
		   
		   var mqtt_host = "192.168.2.12";
		   var mqtt_port = 1884;
		   var mqtt_user = "kirill";
		   var mqtt_pass = "deytrin21";
		   
		   var mqtt = new MqttClient({ host : mqtt_host, port : 1884, 
		   reconnect: 1000, username: mqtt_user, password: mqtt_pass, clientId: "kirill_" + app_name + "_" + makeid()});
	
		   this.on = mqtt.on;
		   this.connect = mqtt.connect;
		   this.disconnect = mqtt.disconnect;
		   this.subscribe = mqtt.subscribe;
		   this.unsubscribe = mqtt.unsubscribe;			   
		   this.connected = mqtt.connected;
		  
	   }
	   
	   
});