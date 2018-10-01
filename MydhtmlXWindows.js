

dhtmlXWindows.prototype.MycreateWindow = function(name,callback){
	var this_win = this;
	var win;

//  console.log(name,ui_data[name]);

   if(ui_data && ui_data[name]){
            var win = this_win.createWindow(name,ui_data[name]["posx"],ui_data[name]["posy"],ui_data[name]["width"],ui_data[name]["height"]);
            	if(ui_data[name]["winname"]){
            	win.setText(ui_data[name]["winname"]);
                }
            	if(ui_data[name]["maximize"]){
            		win.maximize();
            	}

            	if(ui_data[name]["modal"]){
            	win.setModal(ui_data[name]["modal"]);
            	}
            } else {

            win = this_win.createWindow(name,100,100,300,300);
             win.setText(name);
            }

return win;
};



dhtmlXWindows.prototype.MycreateWindow2 = function(data_json){
	var this_win = this;
	var win;

//  console.log(name,ui_data[name]);

   if(data_json){
            var win = this_win.createWindow(name,data_json["posx"],data_json["posy"],data_json["width"],data_json["height"]);
            	if(data_json["winname"]){
            	win.setText(data_json["winname"]);
                }
            	if(data_json["maximize"]){
            		win.maximize();
            	}

            	if(data_json["modal"]){
            	win.setModal(data_json["modal"]);
            	}
            } else {

            win = this_win.createWindow(name,100,100,300,300);
             win.setText(name);
            }

return win;
};

dhtmlXWindows.prototype.getWinParams = function(name,callback){
	var this_win = this;
	var win;
    window.dhx.ajax.get("server.php?APP=getUIObject&name=" + name, function(data){
	        var data_json = window.dhx.s2j(data.xmlDoc.responseText);
 /*
	        "posx":10,
"posy":10,
"width":100,
"height":100
  */

    // console.log(data_json);

  if(data_json["winname"]){
            //;
           // win.setText(data_json["winname"]);

            if(data_json["maximize"])
            win.maximize();
            }


            //else {

            //win = this_win.createWindow(name,100,100,300,300);
            // win.setText(name);
            //}


    		callback(win);

    });
    // callback(this.createWindow(name, 10, 10, 10, 10));
};